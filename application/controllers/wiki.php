<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Wiki extends CI_Controller {
    
    private $folder = 'wiki/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function _remap($method, $params = array()) {
        //Feedback
        if( $method == 'feedback' ) {
            $this->_feedback();
            return true;
        }
        //Terms of Use
        elseif( $method == 'terms-of-use' ) {
            $this->_terms_of_use();
            return true;
        }
        //Privacy Policy
        elseif( $method == 'privacy-policy' ) {
            $this->_privacy_policy();
            return true;
        }
        //FAQ
        elseif( $method == 'faq' ) {
            $this->_faq();
            return true;
        }
        //About PropertyGusto
        elseif( $method == 'about-propertygusto' ) {
            $this->_about_propertygusto();
            return true;
        }
        if(method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            show_404();
        }
    }
    

    public function index() {
        $this->_faq();
    }
    
    protected function _faq() {
        $usercode = $this->tank_auth->get_user_code();
        $usercode_cache = ( empty($usercode) ? CACHE_COMMON : $usercode );
        $this->load->library('PhpFastCache');
        
        phpFastCache::$path = APPPATH.'cache/';
        $vwhd = phpFastCache::get(array("files" => $usercode_cache . "_header_faq"));

        if($vwhd == null) {
            $datahead['userlogin'] = $this->tank_auth->is_logged_in();
            $datahead['usercode'] = $this->tank_auth->get_user_code();
            $datahead['userpic'] = $this->tank_auth->get_userpic();
            $datahead['userfullname'] = $this->tank_auth->get_userfullname();
            $datahead['usertype'] = $this->tank_auth->get_usertype();
            $datahead['title'] = 'FAQ' . PAGE_TITLE;
            $datahead['currpg'] = $_SERVER['REQUEST_URI'];
            $datahead['menu'] = array('wiki' => true);

            $vwhd = $this->load->view('header', $datahead, true);
            phpFastCache::set(array("files" => $usercode_cache . "_header_faq"), $vwhd, CACHE_USER_TIME);

        }
        
        $vw = phpFastCache::get(array("files" => CACHE_COMMON . "_faq"));

        if($vw == null) {
            $vw = $this->load->view($this->folder . 'faq', array(), true);
            phpFastCache::set(array("files" => CACHE_COMMON . "_faq"), $vw, CACHE_COMMON_TIME);
        }
        
        $vwft = phpFastCache::get(array("files" => $usercode_cache . "_footer"));

        if($vwft == null) {
            $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
            
            $vwft = $this->load->view('footer', $datafoot, true);
            phpFastCache::set(array("files" => $usercode_cache . "_footer"), $vwft, CACHE_COMMON_TIME);
        }
            
        echo $vwhd . $vw . $vwft;
    }
    
    protected function _about_propertygusto() {
        $usercode = $this->tank_auth->get_user_code();
        $usercode_cache = ( empty($usercode) ? CACHE_COMMON : $usercode );
        $this->load->library('PhpFastCache');
        
        phpFastCache::$path = APPPATH.'cache/';
        $vwhd = phpFastCache::get(array("files" => $usercode_cache . "_header_about_propertygusto"));

        if($vwhd == null) {
            $datahead['userlogin'] = $this->tank_auth->is_logged_in();
            $datahead['usercode'] = $usercode;
            $datahead['userpic'] = $this->tank_auth->get_userpic();
            $datahead['userfullname'] = $this->tank_auth->get_userfullname();
            $datahead['usertype'] = $this->tank_auth->get_usertype();
            $datahead['title'] = 'About ' . SITE_NAME; 
            $datahead['currpg'] = $_SERVER['REQUEST_URI'];
            $datahead['menu'] = array('wiki' => true);

            $vwhd = $this->load->view('header', $datahead, true);
            phpFastCache::set(array("files" => $usercode_cache . "_header_about_propertygusto"), $vwhd, CACHE_USER_TIME);

        }
        
        $vw = phpFastCache::get(array("files" => CACHE_COMMON . "_about_propertygusto"));

        if($vw == null) {
            $vw = $this->load->view($this->folder . 'about', array(), true);
            phpFastCache::set(array("files" => CACHE_COMMON . "_about_propertygusto"), $vw, CACHE_COMMON_TIME);
        }
        
        $vwft = phpFastCache::get(array("files" => $usercode_cache . "_footer"));

        if($vwft == null) {
            $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
            
            $vwft = $this->load->view('footer', $datafoot, true);
            phpFastCache::set(array("files" => $usercode_cache . "_footer"), $vwft, CACHE_COMMON_TIME);
        }
            
        echo $vwhd . $vw . $vwft;
    }
    
    protected function _terms_of_use() {
        $usercode = $this->tank_auth->get_user_code();
        $usercode_cache = ( empty($usercode) ? CACHE_COMMON : $usercode );
        $this->load->library('PhpFastCache');
        
        phpFastCache::$path = APPPATH.'cache/';
        $vwhd = phpFastCache::get(array("files" => $usercode_cache . "_header_terms_of_use"));

        if($vwhd == null) {
            $datahead['userlogin'] = $this->tank_auth->is_logged_in();
            $datahead['usercode'] = $this->tank_auth->get_user_code();
            $datahead['userpic'] = $this->tank_auth->get_userpic();
            $datahead['userfullname'] = $this->tank_auth->get_userfullname();
            $datahead['usertype'] = $this->tank_auth->get_usertype();
            $datahead['title'] = 'Terms of Use' . PAGE_TITLE; 
            $datahead['currpg'] = $_SERVER['REQUEST_URI'];
            $datahead['menu'] = array('wiki' => true);

            $vwhd = $this->load->view('header', $datahead, true);
            phpFastCache::set(array("files" => $usercode_cache . "_header_terms_of_use"), $vwhd, CACHE_USER_TIME);

        }
        
        $vw = phpFastCache::get(array("files" => CACHE_COMMON . "_terms_of_use"));

        if($vw == null) {
            $vw = $this->load->view($this->folder . 'terms_of_use', array(), true);
            phpFastCache::set(array("files" => CACHE_COMMON . "_terms_of_use"), $vw, CACHE_COMMON_TIME);
        }
        
        $vwft = phpFastCache::get(array("files" => $usercode_cache . "_footer"));

        if($vwft == null) {
            $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
            
            $vwft = $this->load->view('footer', $datafoot, true);
            phpFastCache::set(array("files" => $usercode_cache . "_footer"), $vwft, CACHE_COMMON_TIME);
        }
            
        echo $vwhd . $vw . $vwft;
    }
    
    protected function _privacy_policy() {
        $usercode = $this->tank_auth->get_user_code();
        $usercode_cache = ( empty($usercode) ? CACHE_COMMON : $usercode );
        $this->load->library('PhpFastCache');
        
        phpFastCache::$path = APPPATH.'cache/';
        $vwhd = phpFastCache::get(array("files" => $usercode_cache . "_header_privacy_policy"));

        if($vwhd == null) {
            $datahead['userlogin'] = $this->tank_auth->is_logged_in();
            $datahead['usercode'] = $this->tank_auth->get_user_code();
            $datahead['userpic'] = $this->tank_auth->get_userpic();
            $datahead['userfullname'] = $this->tank_auth->get_userfullname();
            $datahead['usertype'] = $this->tank_auth->get_usertype();
            $datahead['title'] = 'Privacy Policy' . PAGE_TITLE; 
            $datahead['currpg'] = $_SERVER['REQUEST_URI'];
            $datahead['menu'] = array('wiki' => true);

            $vwhd = $this->load->view('header', $datahead, true);
            phpFastCache::set(array("files" => $usercode_cache . "_header_privacy_policy"), $vwhd, CACHE_USER_TIME);

        }
        
        $vw = phpFastCache::get(array("files" => CACHE_COMMON . "_privacy_policy"));

        if($vw == null) {
            $vw = $this->load->view($this->folder . 'privacy_policy', array(), true);
            phpFastCache::set(array("files" => CACHE_COMMON . "_privacy_policy"), $vw, CACHE_COMMON_TIME);
        }
        
        $vwft = phpFastCache::get(array("files" => $usercode_cache . "_footer"));

        if($vwft == null) {
            $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
            
            $vwft = $this->load->view('footer', $datafoot, true);
            phpFastCache::set(array("files" => $usercode_cache . "_footer"), $vwft, CACHE_COMMON_TIME);
        }
            
        echo $vwhd . $vw . $vwft;
    }
    
    protected function _feedback() {
        $usercode = $this->tank_auth->get_user_code();
        $usercode_cache = ( empty($usercode) ? CACHE_COMMON : $usercode );
        $this->load->library('PhpFastCache');
        
        phpFastCache::$path = APPPATH.'cache/';
        $vwhd = phpFastCache::get(array("files" => $usercode_cache . "_header_feedback"));

        if($vwhd == null) {
            $datahead['userlogin'] = $this->tank_auth->is_logged_in();
            $datahead['usercode'] = $this->tank_auth->get_user_code();
            $datahead['userpic'] = $this->tank_auth->get_userpic();
            $datahead['userfullname'] = $this->tank_auth->get_userfullname();
            $datahead['usertype'] = $this->tank_auth->get_usertype();
            $datahead['title'] = 'FAQ' . PAGE_TITLE;
            $datahead['currpg'] = $_SERVER['REQUEST_URI'];
            $datahead['menu'] = array('wiki' => true);

            $vwhd = $this->load->view('header', $datahead, true);
            phpFastCache::set(array("files" => $usercode_cache . "_header_feedback"), $vwhd, CACHE_USER_TIME);

        }
        
        if(!isset($_POST['userlogin'])) {
            $vw = phpFastCache::get(array("files" => CACHE_COMMON . "_feedback"));

            if($vw == null) {
                $vw = $this->_get_view_feedback();
                phpFastCache::set(array("files" => CACHE_COMMON . "_feedback"), $vw, CACHE_COMMON_TIME);
            }
        } else {
            $vw = $this->_get_view_feedback();
        }
        
        $vwft = phpFastCache::get(array("files" => $usercode_cache . "_footer"));

        if($vwft == null) {
            $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
            
            $vwft = $this->load->view('footer', $datafoot, true);
            phpFastCache::set(array("files" => $usercode_cache . "_footer"), $vwft, CACHE_COMMON_TIME);
        }
            
        echo $vwhd . $vw . $vwft;
    }
    
    private function _get_view_feedback() {
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('name', 'Name', 'trim|required|min_length[1]|max_length[500]|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('email', 'Email Address', 'trim|required|max_length[300]|valid_email');
        $this->form_validation->set_rules('subject', 'Subject', 'required');
        $this->form_validation->set_rules('message', 'Message', 'trim|required|min_length[1]|xss_clean|encode_php_tags');

        if($this->form_validation->run() !== FALSE) {
            
            $email = $this->input->post('email');
            $name = $this->input->post('name');
            $subject = $this->input->post('subject');
            $message = $this->input->post('message');
            $ip = $this->input->ip_address();
            $this->_send_email($email, $name, $subject, $message, $ip);
            
            $this->session->set_flashdata('feedback_sent', $email);
            redirect('wiki/feedback');
            
        }
        
        $data['feedback_sent'] = $this->session->flashdata('feedback_sent');
        $data['subject'] = $this->input->post('subject');

        $this->load->view($this->folder . 'feedback', $data);
    }
    
    protected function _send_email($fromemail, $fromname, $topic, $message, $ip) {
        $toemail = $this->config->item('email_to_contactus');
        $toname = $this->config->item('email_to_name_contactus');
        $subject = $this->config->item('email_subject_contactus') .  ' [' . $topic . ' | ' . $fromname . ']';

        $data2 = array(
            'mode' => 'contactus',
            'title' => 'User Feedback  [' . $topic . ' | ' . $fromname . ']',
            'fromemail' => $fromemail,
            'fromname' => htmlentities($fromname),
            'topic' => htmlentities($topic),
            'message' => nl2br(htmlentities($message)),
            'ip' => $ip
        );
        $message = $this->load->view('email/template', $data2, true);
        
        send_email($toemail, $toname, $fromemail, $fromname, $subject, $message);
    }
}