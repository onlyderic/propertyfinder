<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller {
    
    function __construct() {                
        parent::__construct();
    }

    public function index($tempid = '') {
        require('UploadHandler.php');
        $_SERVER['REQUEST_METHOD'] = 'UPLOAD';
        $upload_handler = new UploadHandler(null, true, null, $tempid);

        echo '{"jsonrpc" : "2.0", "result" : null, "id" : "id", "filename" : "' . $upload_handler->new_file_name . '"}';
    }

    public function load($tempid = '') {
        error_reporting(E_ALL | E_STRICT);
        require('UploadHandler.php');
        $upload_handler = new UploadHandler(null, true, null, $tempid);
    }

    public function remove() {
        if( isset($_GET['delete']) && isset($_POST['delete']) && isset($_POST['id']) && $_GET['delete'] == 'true' && $_POST['delete'] == 'true' && !empty($_POST['id']) ) {
            error_reporting(E_ALL | E_STRICT);
            require('UploadHandler.php');
            $_SERVER['REQUEST_METHOD'] = 'DELETE';
            $upload_handler = new UploadHandler(null, true, null, $_POST['id']);
        }
        echo '';
    }
    
}