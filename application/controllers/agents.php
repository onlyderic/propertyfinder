<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Agents extends CI_Controller {
    
    private $folder = 'agents/';
    
    function __construct() {
        parent::__construct();
        
        $this->load->model('Users_Model', 'user');
    }
    
    public function _remap($method, $params = array()) {
        $pre_verified = '';
        $pre_ratings = '';
        $pre_level = '';
        $search = false;
        switch($method) {
            case 'verified': $pre_verified = YES; $search = true; break;
            case 'ratings': $pre_ratings = YES; $search = true; break;
            case 'newbies': $pre_level = LEVEL_NEWBIE; $search = true; break;
            case 'regular-propertyfinders': $pre_level = LEVEL_REGULAR; $search = true; break;
            case 'master-propertyfinders': $pre_level = LEVEL_MASTER; $search = true; break;
            case 'prime-propertyfinders': $pre_level = LEVEL_PRIME; $search = true; break;
        }
        if($search) {
            $this->search($pre_verified, $pre_ratings, $pre_level);
            return true;
        }
        if(method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            $this->index();
        }
    }

    public function index() {
        $this->load->library('form_validation');
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $this->tank_auth->get_user_code();
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'Agents' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('agents' => true);
        
        include('ip2locationlite.class.php');
        $ipLite = new ip2location_lite;
        $ip = $this->input->ip_address();
        $location = $ipLite->getCountry($ip);
        $country = ( isset($location['countryCode']) ? $location['countryCode'] : '' );
        
        $off = 0; //Start new
        $lmt = LIMIT_AGENTS;
        $result_count = $this->_search_live('count', $off, $lmt, '', '', '', $country);
        if($result_count) {
            $data['total_found'] = $result_count->usercount;
        }
        $result = $this->_search_live('list', $off, $lmt, '', '', '', $country);
        $off += $lmt;
        
        $data['verified'] = '';
        $data['ratings'] = '';
        $data['level'] = '';
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
    
    public function search($pre_verified = '', $pre_ratings = '', $pre_level = '') {
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $this->tank_auth->get_user_code();
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'Agents' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('agents' => true);
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters(ERROR_DELIMITER_OPEN, ERROR_DELIMITER_CLOSE);
        $this->form_validation->set_rules('searchkeywords', 'Keywords', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchlocation', 'Location', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchcountry', 'Country', '');
        $this->form_validation->set_rules('searchverified', 'Verified Accounts', '');
        $this->form_validation->set_rules('score', 'Rating', '');
        $this->form_validation->set_rules('searchlevel[]', 'Level', '');
        $this->form_validation->set_rules('off', 'Offset', '');
        $this->form_validation->set_rules('lmt', 'Limit', '');
        $this->form_validation->set_rules('sort', 'Sort', '');
        $this->form_validation->set_rules('ord', 'Order', '');
        
        $country = $this->input->post('searchcountry');
        
        $result = array();
        $off = 0;
        $lmt = LIMIT_AGENTS;
        if($this->form_validation->run() !== FALSE || ( $pre_verified != '' || $pre_ratings != '' || $pre_level != '' ) ) {
            $off = 0; //Start new
            $lmt = LIMIT_AGENTS;
            $result_count = $this->_search_live('count', $off, $lmt, $pre_verified, $pre_ratings, $pre_level, $country);
            if($result_count) {
                $data['total_found'] = $result_count->usercount;
            }
            $result = $this->_search_live('list', $off, $lmt, $pre_verified, $pre_ratings, $pre_level, $country);
            $off += $lmt;
        }
        
        $arrlevel = ( isset($_POST['searchlevel']) ? array_flip($_POST['searchlevel']) : array() );
        
        $data['verified'] = ( $pre_verified != '' ? $pre_verified : $this->input->post('searchverified') );
        $data['ratings'] = $pre_ratings;
        $data['level'] = ( $pre_level != '' ? array($pre_level => '0') : $arrlevel );
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
            $result = $this->_search_live('list', $off, $lmt, '', '', '', $country);
        }
        
        $userlogin = $this->tank_auth->is_logged_in();
        
        $listagents = array();
        foreach($result as $rec) {
            $vw = $this->load->view($this->folder . 'item', array('record' => $rec, 'appended' => true, 'userlogin' => $userlogin), true);
            array_push($listagents, $vw);   
        }        
        
        echo json_encode($listagents);
    }
    
    private function _search_live($mode = 'list', $off = 0, $lmt = LIMIT_AGENTS, $pre_verified = '', $pre_ratings = '', $pre_level = '', $country = '') {
        $searchkeywords = str_replace(',', ' ', $this->input->post('searchkeywords'));
        $searchrating = $this->input->post('score');
        $searchrating = ( is_numeric($searchrating) ? $searchrating : 0 );
        $searchlocation = strtolower($this->input->post('searchlocation'));
        $searchlocation = str_replace('city', '', $searchlocation);
        $searchlocation = str_replace(',', ' ', $searchlocation);
        if($pre_verified != '') {
            $verified = $pre_verified;
        } else {
            $verified = $this->input->post('searchverified');
        }
        if($pre_level != '') {
            $searchlevel[] = $pre_level;
        } else {
            $searchlevel = ( is_array($this->input->post('searchlevel')) ? $this->input->post('searchlevel') : array() );
        }
        $filters = array('searchkeywords' => explode(' ', $searchkeywords),
                         'searchlocation' => explode(' ', $searchlocation),
                         'searchcountry' => $country,
                         'searchverified' => $verified,
                         'searchrating' => $searchrating,
                         'searchlevel' => $searchlevel,
                         'sort' => $this->input->post('sort'),
                         'ord' => $this->input->post('ord') );
        return $this->user->get_search_result($filters, $mode, $off, $lmt);
    }
}