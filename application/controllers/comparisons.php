<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comparisons extends CI_Controller {
    
    private $folder = 'selections/';
    
    function __construct() {
        parent::__construct();
    }
    
    public function _remap($method, $params = array()) {
        //Add to comparisons
        //Format: URL/comparisons/add/property-name/propertyid
        if( $method == 'add' &&  count($params) == 2 ) {
            $this->_add($params[1]);
            return true;
        }
        //Remove from comparisons
        //Format: URL/comparisons/remove/property-name/propertyid
        elseif( $method == 'remove' &&  count($params) == 2 ) {
            $this->_remove($params[1]);
            return true;
        }
        if(method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            show_404();
        }
    }

    public function index() {
        $usercode = $this->tank_auth->get_user_code();
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $usercode;
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'My Comparisons' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('selections' => true);
        
        $this->load->model('Properties_Model', 'prop');
        $data['list'] = $this->prop->get_list_comparison($usercode);
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'comparisons', $data);
        $this->load->view('footer');
    }
    
    public function _add($propcode = '') {
        if( isset($_POST['add']) && $_POST['add'] == 'true' && $propcode != '' ) {
            $this->load->model('Compares_Model', 'compare');
            $usercode = $this->tank_auth->get_user_code();
            if($this->tank_auth->is_logged_in()) {
                $limit_compare = LIMIT_COMPARE;
            } else {
                $limit_compare = LIMIT_COMPARE_NOTSIGNEDIN;
            }
            if($this->_count() >= $limit_compare) {
                echo 'full';
            } elseif($this->compare->create($propcode, $usercode)) {
                echo 'true';
            }
        }
        echo '';
    }
    
    public function _remove($propcode = '') {
        if( isset($_POST['remove']) && $_POST['remove'] == 'true' && $propcode != '' ) {
            $this->load->model('Compares_Model', 'compare');
            $usercode = $this->tank_auth->get_user_code();
            $this->compare->delete($propcode, $usercode);
        }
    }
    
    protected function _count() {
        $this->load->model('Compares_Model', 'compare');
        $usercode = $this->tank_auth->get_user_code();
        return $this->compare->count($usercode);
    }
}