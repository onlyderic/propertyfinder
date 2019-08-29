<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Settings extends CI_Controller {
    
    private $folder = 'settings/';
    
    function __construct() {
        parent::__construct();
        
        if(!$this->tank_auth->is_logged_in()) {
            $this->session->set_flashdata('call_reference', 'settings');
            redirect('login');
        }
        
        $this->load->model('Users_Model', 'user');
    }

    public function index() {
        $usercode = $this->tank_auth->get_user_code();
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $usercode;
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'Settings' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('user' => true);
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_rules('profsettings[NEWPOST]', 'Email me on newly posted properties', '');
        $this->form_validation->set_rules('profsettings[PROPCOMMENT]', 'Email me on comments to my properties', '');
        $this->form_validation->set_rules('profsettings[PROPRATE]', 'Email me on rating of my properties', '');
        $this->form_validation->set_rules('profsettings[PROPEDIT]', 'Email me on edits of my properties', '');
        
        if($this->form_validation->run() !== FALSE) {
            $settings = serialize($_POST['profsettings']);
            $record = array('settings' => $settings);
            $result = $this->user->update_desc($record, $usercode);
            
            if($result) {
                $this->lang->load('success', 'english');
                $this->session->set_flashdata('message_user_update_status', 'success');
                $this->session->set_flashdata('message_user_update', $this->lang->line('success_user_settings_update'));
            } else {
                $this->lang->load('error', 'english');
                $this->session->set_flashdata('message_user_update_status', 'error');
                $this->session->set_flashdata('message_user_update', $this->lang->line('error_user_settings_update'));
            }
            redirect('settings');
        }
        
        $userrow = $this->user->get_user_by_code($usercode);

        $data = array('settings' => '');
        if($userrow) {
            $data = array('settings' => unserialize($userrow->settings) );
        }
        
        $data['message_status'] = $this->session->flashdata('message_user_update_status');
        $data['message'] = $this->session->flashdata('message_user_update');
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'form', $data);
        $this->load->view('footer', $datafoot);
    }
}