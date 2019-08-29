<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Register extends CI_Controller {
    
    private $folder = 'register/';
    
    function __construct() {
        parent::__construct();
        
        $this->load->library('security');
        $this->lang->load('error', 'english');
    }
    
    /**
     * Re-map URL to class functions
     * 
     * @param string $method    Name of function
     * @param array $params     Array of parameters
     * 
     * @return bool
     */
    public function _remap($method, $params = array()) {
        //Forgot Password form
        //Format: URL/register/twitter-phase-1
        if( $method == 'twitter-phase-1' ) {
            $this->twitter_phase1();
            return true;
        }
        if(method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            show_404();
        }
    }

    public function index() {
        if($this->tank_auth->is_logged_in()) {
            redirect('home');
        }
        
        if(!isset($_POST['username'])) {
            $this->load->library('PhpFastCache');
        
            phpFastCache::$path = APPPATH.'cache/';
            $vw = phpFastCache::get(array("files" => CACHE_COMMON . "_register"));

            if($vw == null) {
                $vw = $this->_get_view_register();
                phpFastCache::set(array("files" => CACHE_COMMON . "_register"), $vw, CACHE_COMMON_TIME);
            }

        } else {
            $vw = $this->_get_view_register();
        }
        
        echo $vw;
    }
    
    public function twitter_phase1() {
        //Ask for email
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('useremail', 'Email Address', 'trim|required|max_length[300]|valid_email|callback__check_email');

        if($this->form_validation->run() !== FALSE) {
            $email = $this->input->post('useremail');
            $this->session->set_userdata('twitter_email', $email);
            redirect('register/twitter_phase2');
        }
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['title'] = 'Join for FREE' . PAGE_TITLE;
        $datahead['solo'] = 'register';
        
        $this->load->view('header2', $datahead);
        $this->load->view($this->folder . 'form_twitter');
        $this->load->view('footer', $datafoot);
    }
    
    public function twitter_phase2() {
        //Check for email and password session
        //If not set, redirect to phase1
        
        $this->load->library('TwitterOAuth');
        
        $twitteroauth = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);  
        // Requesting authentication tokens, the parameter is the URL we will be redirected to  
        $request_token = $twitteroauth->getRequestToken( site_url('register/twitter_auth') );  

        // Saving them into the session  
        $this->session->set_userdata(array(
            'oauth_token' => $request_token['oauth_token'],
            'oauth_token_secret' => $request_token['oauth_token_secret']
        ));

        // If everything goes well..  
        if($twitteroauth->http_code == 200) {
            // Let's generate the URL and redirect  
            $url = $twitteroauth->getAuthorizeURL($request_token['oauth_token']); 
            redirect($url);
        } else { 
            redirect('register');
        }
    }
    
    public function twitter_auth() {
        $oauth_token = $this->session->userdata('oauth_token');
        $oauth_token_secret = $this->session->userdata('oauth_token_secret');
        if( !empty($_GET['oauth_verifier']) && !empty($oauth_token) && !empty($oauth_token_secret) ) {  
            $this->load->library('TwitterOAuth');
            
            try {
                $twitteroauth = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET, $oauth_token, $oauth_token_secret);  
                
                // Let's request the access token  
                $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']); 
                $this->session->set_userdata('access_token', $access_token);
                
                // Let's get the user's info 
                $user_info = $twitteroauth->get('account/verify_credentials'); 
                
                if( !empty($access_token['oauth_token']) && !empty($access_token['oauth_token_secret']) &&
                    !empty($user_info->id) && !empty($user_info->name) ) {
                    
                    $this->session->set_userdata(array(
                        'oauth_token' => '',
                        'oauth_token_secret' => '',
                        'access_token' => ''
                    ));
            
                    $this->load->model('Users_Model', 'user');
                    
                    //Let's check if the email address already exists
                    $email = $this->session->userdata('twitter_email');
                    $result = $this->user->check_email( $email );
                    if(!$result) {
                        $this->session->set_userdata(array('twitter_email' => ''));
                        $this->lang->load('error', 'english');
                        $this->session->set_flashdata('redirect_message_status', 'error');
                        $this->session->set_flashdata('redirect_message', $this->lang->line('error_oauth_register'));
                        redirect('login');

                        return true;
                    }
                    
                    //Let's check if it user has already used twitter to register
                    $userrow = $this->user->get_user_by_oauth('T', $user_info->id);
                    
                    if($userrow) {
                        //Auto-login, and redirect...
                        $this->session->set_userdata(array(
                                        'usercode'	=> $userrow->code,
                                        'username'	=> $userrow->fname . ' ' . $userrow->lname,
                                        'userpic'	=> $userrow->profilepic,
                                        'usertype'	=> $userrow->usertype,
                                        'status'	=> STATUS_ACTIVATED
                        ));
                        redirect('home');
                        
                        return true;
                    }
        
                    $oauthuid = $user_info->id;
                    $oauthtoken = $access_token['oauth_token'];
                    $oauthsecret = $access_token['oauth_token_secret'];
                    $name = $user_info->name;
//                    $email = '';
                    $password = '';

                    if (!is_null($data = $this->tank_auth->create_user(
                                    $name,
                                    $email,
                                    $password,
                                    '',
                                    'T',
                                    $oauthuid,
                                    $oauthtoken,
                                    $oauthsecret))) {
                        //Can't send an email because twitter doesn't provide the email address
                        $this->_send_email($email, $name);

                        //Auto login user
                        $this->session->set_flashdata('new_register', 'true');
                        redirect('home');

                    } else {
                        $data['message'] = $this->lang->line('error_user_save');

                        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
                        $datahead['title'] = 'Join for FREE' . PAGE_TITLE;
                        $datahead['solo'] = 'register';

                        $this->load->view('header2', $datahead);
                        $this->load->view($this->folder . 'form');
                        $this->load->view('footer', $datafoot);
                        return true;
                    }
                    
                }
            
            } catch(Exception $e) {
                redirect('register/twitter_phase2');
            }
        } else {  
            redirect('register/twitter_phase2');
        } 
    }
    
    public function facebook() {
        if(isset($_REQUEST['signed_request'])) {
            $response = $this->parse_signed_request($_REQUEST['signed_request'], FACEBOOK_SECRET);
            
            $this->load->model('Users_Model', 'user');
            
            //Let's check if the email address already exists
            $result = $this->user->check_email( $response["registration"]["email"] );
            if(!$result) {
                $this->lang->load('error', 'english');
                $this->session->set_flashdata('redirect_message_status', 'error');
                $this->session->set_flashdata('redirect_message', $this->lang->line('error_oauth_register'));
                redirect('login');

                return true;
            }
            
            //Let's check if user has already used facebook to register
            $userrow = $this->user->get_user_by_oauth('F', $response["user_id"]);

            if($userrow) {
                //Auto-login, and redirect...
                $this->session->set_userdata(array(
                                'usercode'	=> $userrow->code,
                                'username'	=> $userrow->fname . ' ' . $userrow->lname,
                                'userpic'	=> $userrow->profilepic,
                                'usertype'	=> $userrow->usertype,
                                'status'	=> STATUS_ACTIVATED
                ));
                redirect('home');

                return true;
            }

            $oauthuid = $response["user_id"];
            $oauthtoken = $response["oauth_token"];
            $name = $response["registration"]["name"];
            $email = $response["registration"]["email"];
            $password = $response["registration"]["password"];

            if (!is_null($data = $this->tank_auth->create_user(
                            $name,
                            $email,
                            $password,
                            '',
                            'F',
                            $oauthuid,
                            $oauthtoken))) {
                $this->_send_email($email, $name);

                //Auto login user
                $this->session->set_flashdata('new_register', 'true');
                redirect('home');

            } else {
                $data['message'] = $this->lang->line('error_user_save');
            }
        }
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['title'] = 'Join for FREE' . PAGE_TITLE;
        $datahead['solo'] = 'register';
        
        $this->load->view('header2', $datahead);
        $this->load->view($this->folder . 'form_fb');
        $this->load->view('footer', $datafoot);
    }
    
    private function parse_signed_request($signed_request, $secret) {
        list($encoded_sig, $payload) = explode('.', $signed_request, 2);
        // decode the data
        $sig = $this->base64_url_decode($encoded_sig);
        $data = json_decode($this->base64_url_decode($payload), true);
        if (strtoupper($data['algorithm']) !== 'HMAC-SHA256') {
            error_log('Unknown algorithm. Expected HMAC-SHA256');
            return null;
        }

        // check sig
        $expected_sig = hash_hmac('sha256', $payload, $secret, $raw = true);
        if ($sig !== $expected_sig) {
            error_log('Bad Signed JSON signature!');
            return null;
        }
        return $data;
    }
    
    private function base64_url_decode($input) {
        return base64_decode(strtr($input, '-_', '+/'));
    }
    
    private function _get_view_register() {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('username', 'Name', 'trim|required|min_length[1]|max_length[250]');
        $this->form_validation->set_rules('useremail', 'Email Address', 'trim|required|max_length[300]|valid_email|callback__check_email');
        $this->form_validation->set_rules('userpass', 'Password', 'required|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('usercpass', 'Confirm Password', 'required|matches[userpass]');
        $this->form_validation->set_rules('userme', 'User Type', '');

        if($this->form_validation->run() !== FALSE) {
            if (!is_null($data = $this->tank_auth->create_user(
                            $this->input->post('username'),
                            $this->input->post('useremail'),
                            $this->input->post('userpass'),
                            $this->input->post('userme')))) {									// success

                $this->_send_email($data['email'], $data['fname']);

                //Auto login user
                unset($data['password']); // Clear password (just in case)
                $this->session->set_flashdata('new_register', 'true');
                redirect('home');
            } else {
                $data['message'] = $this->lang->line('error_user_save');
            }
        }

        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['title'] = 'Join for FREE' . PAGE_TITLE;
        $datahead['solo'] = 'register';

        $data['userme'] = $this->input->post('userme');

        $vw = $this->load->view('header2', $datahead, true);
        $vw .= $this->load->view($this->folder . 'form', $data, true);
        $vw .= $this->load->view('footer', $datafoot, true);
        
        return $vw;
    }
    
    public function _check_email($str) {
        $this->load->model('Users_Model', 'user');
        $result = $this->user->check_email($str);
        if(!$result) {
            $this->lang->load('error', 'english');
            $this->form_validation->set_message('_check_email', $this->lang->line('error_email_used') );
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    protected function _send_email($toemail, $toname) {
        $fromemail = $this->config->item('email_from_register');
        $fromname = $this->config->item('email_from_name_register');
        $subject = $this->config->item('email_subject_register');

        $data2 = array(
            'mode' => 'register',
            'title' => 'Welcome to PropertyGusto.com!',
            'name' => $toname
        );
        $message = $this->load->view('email/template', $data2, true);
        
        send_email($toemail, $toname, $fromemail, $fromname, $subject, $message);
    }
    
    protected function _send_email2($toemail, $toname) {
        $fromemail = $this->config->item('email_from_register');
        $fromname = $this->config->item('email_from_name_register');
        $subject = $this->config->item('email_subject_register');

        /*$data2 = array(
            'mode' => 'register',
            'title' => 'Welcome to PropertyGusto.com!',
            'name' => $toname
        );
        $message = $this->load->view('email/template', $data2, true);*/
		//$message = $this->load->view('email/email_cfl', [], true);
		$message = $this->load->view('email/email_cfl_annual_meeting_2018', [], true);
        
        send_email($toemail, $toname, $fromemail, $fromname, $subject, $message);
    }
    
    public function test() {
		echo $this->_send_email2('onlyderic@gmail.com', 'eric');
		echo "test";
    }
}