<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Selections extends CI_Controller {
    
    function __construct() {
        parent::__construct();
    }

    public function index() {
        redirect('comparisons');
    }
}