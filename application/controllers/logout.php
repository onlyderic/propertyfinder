<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->tank_auth->logout();
        redirect('home');
    }
}