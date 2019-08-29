<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Join extends CI_Controller {
    
    private $folder = 'register/';
    
    function __construct() {
        parent::__construct();
    }

    public function index() {
        if($this->tank_auth->is_logged_in()) {
            redirect('home');
        }
        
        $datahead['title'] = 'Join for FREE' . PAGE_TITLE;
        $datafoot['userlogin'] = false;
        
        $this->load->view('header2', $datahead);
        $this->load->view($this->folder . 'register');
        $this->load->view('footer', $datafoot);
    }
}