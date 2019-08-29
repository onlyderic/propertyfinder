<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Companies extends CI_Controller {
    
    private $folder = 'companies/';
    
    function __construct() {
        parent::__construct();
        
        $this->load->model('Companies_Model', 'comp');
    }

    public function index() {
        $this->load->library('form_validation');
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $this->tank_auth->get_user_code();
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'Companies' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('companies' => true);
        
        include('ip2locationlite.class.php');
        $ipLite = new ip2location_lite;
        $ip = $this->input->ip_address();
        $location = $ipLite->getCountry($ip);
        $country = ( isset($location['countryCode']) ? $location['countryCode'] : '' );
        
        $off = 0; //Start new
        $lmt = LIMIT_COMPANIES;
        $result_count = $this->_search_live('count', $off, $lmt, $country);
        if($result_count) {
            $data['total_found'] = $result_count->compcount;
        }
        $result = $this->_search_live('list', $off, $lmt, $country);
        $off += $lmt;
        
        $data['ratings'] = '';
        $data['off'] = $off;
        $data['lmt'] = $lmt;
        $data['sort'] = '';
        $data['ord'] = '';
        $data['list'] = $result;
        $data['default_list'] = true;
        
        $data['country'] = $country;
        $data['countries'] = $this->config->item('countries');
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'listing', $data);
        $this->load->view('footer', $datafoot);
    }
    
    public function search() {
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $this->tank_auth->get_user_code();
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'Companies' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('companies' => true);
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters(ERROR_DELIMITER_OPEN, ERROR_DELIMITER_CLOSE);
        $this->form_validation->set_rules('searchkeywords', 'Keywords', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchlocation', 'Location', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchcountry', 'Country', '');
        $this->form_validation->set_rules('score', 'Rating', '');
        $this->form_validation->set_rules('off', 'Offset', '');
        $this->form_validation->set_rules('lmt', 'Limit', '');
        $this->form_validation->set_rules('sort', 'Sort', '');
        $this->form_validation->set_rules('ord', 'Order', '');
        
        $country = $this->input->post('searchcountry');
        
        $result = array();
        $off = 0;
        $lmt = LIMIT_COMPANIES;
        if($this->form_validation->run() !== FALSE) {
            $off = 0; //Start new
            $lmt = LIMIT_COMPANIES;
            $result_count = $this->_search_live('count', $off, $lmt, $country);
            if($result_count) {
                $data['total_found'] = $result_count->compcount;
            }
            $result = $this->_search_live('list', $off, $lmt, $country);
            $off += $lmt;
        }
        
        $data['off'] = $off;
        $data['lmt'] = $lmt;
        $data['sort'] = $this->input->post('sort');
        $data['ord'] = $this->input->post('ord');
        $data['list'] = $result;
        
        $data['countries'] = $this->config->item('countries');
        $data['country'] = $country;
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'listing', $data);
        $this->load->view('footer', $datafoot);
    }
    
    public function search_more() {
        $result = array();
        if(isset($_POST['searchkeywords'])) {
            $off = $this->input->post('off');
            $lmt = $this->input->post('lmt');
            $country = $this->input->post('searchcountry');
            $result = $this->_search_live('list', $off, $lmt, $country);
        }
        
        $userlogin = $this->tank_auth->is_logged_in();
        
        $listcompanies = array();
        foreach($result as $rec) {
            $vw = $this->load->view($this->folder . 'item', array('record' => $rec, 'appended' => true, 'userlogin' => $userlogin), true);
            array_push($listcompanies, $vw);   
        }        
        
        echo json_encode($listcompanies);
    }
    
    private function _search_live($mode = 'list', $off = 0, $lmt = LIMIT_COMPANIES, $country = '') {
        $searchkeywords = str_replace(',', ' ', $this->input->post('searchkeywords'));
        $searchrating = $this->input->post('score');
        $searchrating = ( is_numeric($searchrating) ? $searchrating : 0 );
        $searchlocation = strtolower($this->input->post('searchlocation'));
        $searchlocation = str_replace('city', '', $searchlocation);
        $searchlocation = str_replace(',', ' ', $searchlocation);
        $filters = array('searchkeywords' => explode(' ', $searchkeywords),
                         'searchlocation' => explode(' ', $searchlocation),
                         'searchcountry' => $country,
                         'searchrating' => $searchrating,
                         'sort' => $this->input->post('sort'),
                         'ord' => $this->input->post('ord') );
        return $this->comp->get_search_result($filters, $mode, $off, $lmt);
    }
}