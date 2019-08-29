<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {
    
    private $folder = 'home/';
    
    function __construct() {
        parent::__construct();
    }

    public function index() {
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $this->tank_auth->get_user_code();
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = SITE_NAME . ' - The best property search';
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        
        //For caching, create 2 home pages, 1 as default, the other as with popup
        $data['new_register'] = $this->session->flashdata('new_register');
        
        include('ip2locationlite.class.php');
        $ipLite = new ip2location_lite;
        $ip = $this->input->ip_address();
        $location = $ipLite->getCountry($ip);
        $country = ( isset($location['countryCode']) ? $location['countryCode'] : '' );
        
        $off = 0; //Start new
        $lmt = LIMIT_PROPERTIES;
        $result_count = $this->_search_live('count', $off, $lmt, $country);
        if($result_count) {
            $data['total_found'] = $result_count->propcount;
        }
        $result = $this->_search_live('list', $off, $lmt, $country);
        $off += $lmt;
        
        $sort = $this->input->post('sort');
        $ord = $this->input->post('ord');
        if(!isset($_POST['sort'])) {
            //Default sort or default loaded list is popularity
            $sort = 'popularity';
            $ord = 'desc';
        }
        
        $data['off'] = $off;
        $data['lmt'] = $lmt;
        $data['sort'] = $sort;
        $data['ord'] = $ord;
        $data['list'] = $result;
        $data['act'] = $this->input->post('act');
        $data['searchkeywords'] = $this->input->post('searchkeywords');
        
        $data['country'] = $country;
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'home', $data);
        $this->load->view('footer', $datafoot);
    }
    
    private function _search_live($mode = 'list', $off = 0, $lmt = LIMIT_HOME, $country = '') {
        $this->load->model('Properties_Model', 'prop');
        $searchkeywords = str_replace(',', ' ', $this->input->post('searchkeywords'));
        $sort = $this->input->post('sort');
        $ord = $this->input->post('ord');
        if(!isset($_POST['sort'])) {
            //Default sort or default loaded list is popularity
            $sort = 'popularity';
            $ord = 'desc';
        }
        $filters = array(
                         'searchkeywords' => explode(' ', $searchkeywords),
                         'searchcountry' => $country,
                         'sort' => $sort,
                         'ord' => $ord );
        return $this->prop->get_search_result($filters, $mode, $off, $lmt);
    }
}