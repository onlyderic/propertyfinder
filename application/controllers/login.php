<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {
    
    private $folder = 'login/';
    
    function __construct() {
        parent::__construct();
        
        $this->load->library('security');
        $this->lang->load('tank_auth', 'english');
    }

    public function index() {       
        if($this->tank_auth->is_logged_in()) {
            redirect('home');
        }
        
        $vw = $this->_get_view_login();
        
        echo $vw;
    }
    
    public function facebook() {
        $this->load->library('Fb');
        $this->fb->init_facebook();

        if($this->fb->user) {
            try {
                $user_profile = $this->fb->api('/me');
            } catch (FacebookApiException $e) { }
            
            if(!empty($user_profile)){  
                //Check if already a member
                $this->load->model('Users_Model', 'user');
                $userrow = $this->user->get_user_by_oauth('F', $user_profile['id']);
                
                if($userrow) {
                    //Auto-login, and redirect...
                    $this->session->set_userdata(array(
                                    'usercode'	=> $userrow->code,
                                    'username'	=> $userrow->fname . ' ' . $userrow->lname,
                                    'userpic'	=> $userrow->profilepic,
                                    'usertype'	=> $userrow->usertype,
                                    'status'	=> STATUS_ACTIVATED
                    ));
                    $user_profile = $this->fb->api('/me/permissions', 'DELETE');
                    echo '<script>if(opener && "" != opener.location) { opener.location = "' . site_url('home') . '"; opener.focus(); } window.close(); </script>';
                    exit();
                } else {
                    echo '<script>if(opener && "" != opener.location) { opener.location = "' . site_url('register/facebook') . '"; opener.focus(); } window.close(); </script>';
                    exit();
                }
            } else { 
                echo '<script>if(opener && "" != opener.location) { opener.location = "' . site_url('login') . '"; opener.focus(); } window.close(); </script>';
                exit();
            } 
        } else {
            //This might not be invoked at all
            //coz, facebook API is redirecting the page to facebook login
            echo '<script>if(opener && "" != opener.location) { opener.location = "' . site_url('login') . '"; opener.focus(); } window.close(); </script>';
            exit();
        }
    }
    
    public function twitter() {
        $this->load->library('TwitterOAuth');
        
        $twitteroauth = new TwitterOAuth(TWITTER_CONSUMER_KEY, TWITTER_CONSUMER_SECRET);  
        // Requesting authentication tokens, the parameter is the URL we will be redirected to  
        $request_token = $twitteroauth->getRequestToken( site_url('login/twitter_auth') );  

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
            echo '<script>if(opener && "" != opener.location) { opener.location = "' . site_url('register') . '"; opener.focus(); } window.close(); </script>';
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
                    
                    //Let's check if it user has already used twitter to register
                    $this->load->model('Users_Model', 'user');
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
                        echo '<script>console.log("xxx"); if(opener && "" != opener.location) { opener.location = "' . site_url('home') . '"; opener.focus(); } window.close(); </script>';
                        exit();
                    } else {
                        echo '<script>if(opener && "" != opener.location) { opener.location = "' . site_url('register/twitter-phase-1') . '"; opener.focus(); } window.close(); </script>';
                        exit();
                    }
                }
            
            } catch(Exception $e) {
                echo '<script>if(opener && "" != opener.location) { opener.location = "' . site_url('register/twitter-phase-1') . '"; opener.focus(); } window.close(); </script>';
                exit();
            }
        } else {  
            echo '<script>if(opener && "" != opener.location) { opener.location = "' . site_url('register/twitter-phase-1') . '"; opener.focus(); } window.close(); </script>';
            exit();
        } 
    }
    
    private function _get_view_login() {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('userlogin', 'Email Address', 'required|xss_clean');
        $this->form_validation->set_rules('userpass', 'Password', 'required|xss_clean');
        $this->form_validation->set_rules('userremember', 'Remember me', '');

        $data = array();
        
        // Get login for counting attempts to login
        if( $this->config->item('login_count_attempts', 'tank_auth') &&
            ($email = $this->input->post('userlogin')) ) {
            $email = $this->security->xss_clean($email);
        } else {
            $email = '';
        }
        
        $data['use_recaptcha'] = $this->config->item('use_recaptcha', 'tank_auth');
        if($this->tank_auth->is_max_login_attempts_exceeded($email)) {
            $this->form_validation->set_rules('confirmationcode', 'Confirmation Code', 'trim|xss_clean|required|callback__check_captcha');
        }
        
        $call_reference = $this->session->flashdata('call_reference');
        if(isset($_POST['submit'])) {
            $call_reference = $this->input->post('call_reference');
        } elseif(isset($_POST['login'])) {
            $call_reference = $this->input->post('pg');
        }
                        
        if($this->form_validation->run() !== FALSE) {
            if($this->tank_auth->login(
                    $this->form_validation->set_value('userlogin'),
                    $this->form_validation->set_value('userpass'),
                    $this->form_validation->set_value('userremember')
                    )) {
                if($call_reference == '') {
                    redirect('home');
                } else {
                    redirect($call_reference);
                }
            } else {
                $data['error_message'] = 'Invalid email address or password';
            }
        }
        
        $data['call_reference'] = $call_reference;
        
        $data['show_captcha'] = FALSE;
        if($this->tank_auth->is_max_login_attempts_exceeded($email)) {
            $data['show_captcha'] = TRUE;
            $data['captcha_html'] = $this->_create_captcha();
        }
                        
        $this->load->library('user_agent');
        $data['browser_ie'] = $this->agent->is_browser('Internet Explorer'); //Coz IE can't support placeholder... poor guy
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $this->tank_auth->get_user_code();
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['title'] = 'Login' . PAGE_TITLE;
        $datahead['solo'] = 'login';
        
        //This comes from Forgot Password on success. Show message to user
        $data['forgot_password'] = $this->session->flashdata('forgot_password');
        
        //This comes from Reset Password or Register (Facebook)
        $data['redirect_message_status'] = $this->session->flashdata('redirect_message_status');
        $data['redirect_message'] = $this->session->flashdata('redirect_message');
        
        $vw = $this->load->view('header2', $datahead);
        $vw .= $this->load->view($this->folder . 'login', $data);
        $vw .= $this->load->view('footer', $datafoot);
        
        return $vw;
    }
    
    protected function _create_captcha() {
        $this->load->helper('captcha');

        $cap = create_captcha(array(
            'img_path'  => './'.$this->config->item('captcha_path', 'tank_auth'),
            'img_url'	=> base_url().$this->config->item('captcha_path', 'tank_auth'),
            'font_path'	=> './'.$this->config->item('captcha_fonts_path', 'tank_auth'),
            'font_size'	=> $this->config->item('captcha_font_size', 'tank_auth'),
            'img_width'	=> $this->config->item('captcha_width', 'tank_auth'),
            'img_height' => $this->config->item('captcha_height', 'tank_auth'),
            'show_grid'	=> $this->config->item('captcha_grid', 'tank_auth'),
            'expiration'	=> $this->config->item('captcha_expire', 'tank_auth'),
        ));

        // Save captcha params in session
        $this->session->set_userdata(array(
            'captcha_word' => $cap['word'],
            'captcha_time' => $cap['time'],
        ));

        return $cap['image'];
    }
    
    public function _check_captcha($code) {
        $time = $this->session->userdata('captcha_time');
        $word = $this->session->userdata('captcha_word');

        list($usec, $sec) = explode(" ", microtime());
        $now = ((float)$usec + (float)$sec);
        
        if($now - $time > $this->config->item('captcha_expire', 'tank_auth')) {
            $this->form_validation->set_message('_check_captcha', $this->lang->line('auth_captcha_expired'));
            return FALSE;
        } elseif(($this->config->item('captcha_case_sensitive', 'tank_auth') AND
                $code != $word) OR
                strtolower($code) != strtolower($word)) {
            $this->form_validation->set_message('_check_captcha', $this->lang->line('auth_incorrect_captcha'));
            return FALSE;
        }
        return TRUE;
    }
}