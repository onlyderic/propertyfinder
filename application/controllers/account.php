<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Account
 * 
 * My Account page functions
 * 
 * @author      Eric Domingo
 * @version     0.1
 * @copyright   2013
 */
class Account extends CI_Controller {
    
    /**
     * Folder name of view for login
     *
     * @var string
     * @access private
     */
    private $folder = 'login/';
    
    /**
     * Folder name of view for accounts
     *
     * @var string
     * @access private
     */
    private $account_folder = 'accounts/';
    
    /**
     * Class construct
     */
    function __construct() {
        parent::__construct();
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
        //Format: URL/account/forgot-password
        if( $method == 'forgot-password' ) {
            $this->_forgot_password();
            return true;
        }
        //Reset Password form
        //Format: URL/account/reset-password/key
        elseif( $method == 'reset-password' && count($params) == 1 ) {
            $this->_reset_password($params[0]);
            return true;
        }
        if(method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            show_404();
        }
    }

    /**
     * Landing page
     * 
     * Displays My Accounts page of the user
     * User must be logged in
     * 
     * @access public
     */
    public function index() { 
        if(!$this->tank_auth->is_logged_in()) {
            $this->session->set_flashdata('call_reference', str_replace('propertygusto/', '', $_SERVER['REQUEST_URI']) );
            redirect('login');
        }
        
        $usercode = $this->tank_auth->get_user_code();
        $userfullname = $this->tank_auth->get_userfullname();
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $usercode;
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $userfullname;
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'My Account' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('user' => true);

        //Get Featured Properties transaction records
        $this->load->model('PropertyTransactions_Model', 'ptrx');
        $filter = array('usercode' => $usercode);
        $list_featured_properties = $this->ptrx->get_list($filter);
        $data['list_featured_properties'] = $list_featured_properties;
        
        //Get Featured Profile transaction records
        $this->load->model('UserTransactions_Model', 'utrx');
        $filter = array('usercode' => $usercode, 'trxtype' => 'F');
        $list_featured_profile = $this->utrx->get_list($filter);
        $data['list_featured_profile'] = $list_featured_profile;
        
        //Get Verified Profile transaction records
        $filter = array('usercode' => $usercode, 'trxtype' => 'V');
        $list_profile_verification = $this->utrx->get_list($filter);
        $data['list_profile_verification'] = $list_profile_verification;
        
        //Get current profile's verification or featured status
        $this->load->model('Users_Model', 'user');
        $profilerow = $this->user->get_user_by_code($usercode);
        $featured = NO;
        $verifiedagent = NO;
        $usertype = USERTYPE_AGENT;
        if($profilerow) {
            $featured = $profilerow->featured;
            $verifiedagent = $profilerow->verifiedagent;
            $usertype = $profilerow->usertype;
        }
        $data['usertype'] = $usertype;
        $data['featured'] = $featured;
        $data['verifiedagent'] = $verifiedagent;
        $data['usercode'] = $usercode;
        $data['userfullname'] = $userfullname;
        
        $this->load->view('header', $datahead);
        $this->load->view($this->account_folder . 'list', $data);
        $this->load->view('footer', $datafoot);    
    }
    
    /**
     * Forgot Password
     * 
     * Displays the Forgot Password form
     * User must NOT be logged in
     * 
     * @access protected
     */
    protected function _forgot_password() {
        if($this->tank_auth->is_logged_in()) {
            redirect('home');
        }
        
        //If not coming from submit, retrieve the cached page
        //Otherwise, display a non-cached version to display errors, if any
        if(!isset($_POST['userlogin'])) {
            $this->load->library('PhpFastCache');
        
            phpFastCache::$path = APPPATH.'cache/';
            $vw = phpFastCache::get(array("files" => CACHE_COMMON . "_forgot_password"));

            if($vw == null) {
                $vw = $this->_get_view_forgot_password();
                phpFastCache::set(array("files" => CACHE_COMMON . "_forgot_password"), $vw, CACHE_COMMON_TIME);
            }

        } else {
            $vw = $this->_get_view_forgot_password();
        }
        
        echo $vw;
    }
    
    private function _get_view_forgot_password() {
        $data = array();
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('userlogin', 'Email Address', 'required|valid_email|xss_clean');
                        
        //When submitted...
        
        if($this->form_validation->run() !== FALSE) {
            //User should be existing and active
            $this->load->model('Users_Model', 'user');
            $row = $this->user->get_user_by_email($this->input->post('userlogin'));
            if( $row && $row->recstatus == USERSTATUS_ACTIVE ) {
                //Create a key and insert it to Passwords table
                $this->load->model('Passwords_Model', 'pwd');
                $key = generate_code('PWD');
                $result = $this->pwd->create($key, $row->code);
            
                //Send an email to the user together with the key
                $email = $row->email;
                $name = $row->fname . ' ' . $row->lname;
                $urlcode = site_url('account/reset-password/' . $key);
                $this->_send_email($email, $name, $urlcode);
            
                //Inform user of successful request
                $this->session->set_flashdata('forgot_password', 'true');
                redirect('login');
            } else {
                $data['error_message'] = 'Invalid email address';
            }
        }
        
        //Display page...
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = '';
        $datahead['userpic'] = '';
        $datahead['userfullname'] = '';
        $datahead['title'] = 'Forgot Password' . PAGE_TITLE;
        $datahead['solo'] = 'forgotpassword';

        $vw = $this->load->view('header2', $datahead);
        $vw .= $this->load->view($this->folder . 'forgot_password', $data);
        $vw .= $this->load->view('footer', $datafoot);
        
        return $vw;
    }
    
    /**
     * Reset Password
     * 
     * Displays the Reset Password form
     * The link to this page comes from the Forgot Password email
     * User must NOT be logged in
     * 
     * @access protected
     */
    protected function _reset_password($key = '') {
        if($this->tank_auth->is_logged_in()) {
            redirect('home');
        }

        //If not coming from submit, retrieve the cached page
        //Otherwise, display a non-cached version to display errors, if any
        if(!isset($_POST['userpass'])) {
            $this->load->library('PhpFastCache');
        
            phpFastCache::$path = APPPATH.'cache/';
            $vw = phpFastCache::get(array("files" => CACHE_COMMON . "_reset_password"));

            if($vw == null) {
                $vw = $this->_get_view_reset_password($key);
                phpFastCache::set(array("files" => CACHE_COMMON . "_reset_password"), $vw, CACHE_COMMON_TIME);
            }

        } else {
            $vw = $this->_get_view_reset_password($key);
        }
        
        echo $vw;
    }
    
    private function _get_view_reset_password($key = '') {
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = '';
        $datahead['userpic'] = '';
        $datahead['userfullname'] = '';
        $datahead['title'] = 'Reset Password' . PAGE_TITLE;
        $datahead['solo'] = 'resetpassword';
        
        $data = array();
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
                
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('userpass', 'Password', 'required|min_length[1]|max_length[30]');
        $this->form_validation->set_rules('usercpass', 'Confirm Password', 'required|matches[userpass]');
                      
        //The key must exist, valid and not yet expired
        $this->load->model('Passwords_Model', 'pwd');
        $row = $this->pwd->get_pwd_by_code($key);
        $usercode = '';
        if($row) {
            if($row->hourspast <= 24) {
                $data['key'] = $key;
                $usercode = $row->usercode;
            } else {
                $data['invalid_message'] = true;
            }
        } else {
            $data['invalid_message'] = true;
        }
        
        //When submitted...
        
        if($this->form_validation->run() !== FALSE) {
            //Update password
            $this->load->model('Users_Model', 'user');
            $password = $this->tank_auth->create_password($this->input->post('userpass'));
            $record = array('password' => $password);
            $result = $this->user->update_password($record, $usercode);
            
            //And, inform user
            if($result) {
                $result = $this->pwd->delete($key);
                $this->lang->load('success', 'english');
                $this->session->set_flashdata('redirect_message_status', 'success');
                $this->session->set_flashdata('redirect_message', $this->lang->line('success_password_update'));
                redirect('login');
            } else {
                $this->lang->load('error', 'english');
                $this->session->set_flashdata('redirect_message_status', 'error');
                $this->session->set_flashdata('redirect_message', $this->lang->line('error_password_update'));
                redirect('account/reset-password/' . $key);
            }
        }
        
        //Display page...
        
        $data['redirect_message_status'] = $this->session->flashdata('redirect_message_status');
        $data['redirect_message'] = $this->session->flashdata('redirect_message');
        
        $vw = $this->load->view('header2', $datahead);
        $vw .= $this->load->view($this->folder . 'reset_password', $data);
        $vw .= $this->load->view('footer', $datafoot);
        
        return $vw;
    }
    
    /**
     * Send email
     * 
     * Process and send an email through SMTP
     * 
     * @access protected
     * 
     * @param string $toemail   Email address of receiver
     * @param string $toname    Name of the receiver
     * @param string $urlcode   URL of the Forgot Password with key/code
     * 
     * @return null
     */
    protected function _send_email($toemail, $toname, $urlcode) {
        $fromemail = $this->config->item('email_from_forgotpassword');
        $fromname = $this->config->item('email_from_name_forgotpassword');
        $subject = $this->config->item('email_subject_forgotpassword');

        $data2 = array(
            'mode' => 'forgotpassword',
            'title' => 'PropertyGusto.com - Reset Password Request',
            'name' => $toname,
            'urlcode' => $urlcode
        );
        $message = $this->load->view('email/template', $data2, true);
        
        send_email($toemail, $toname, $fromemail, $fromname, $subject, $message);
    }
}