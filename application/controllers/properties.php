<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Properties extends CI_Controller {
    
    private $folder = 'properties/';
    
    function __construct() {
        parent::__construct();
        
        $this->load->model('Properties_Model', 'prop');
    }
    
    /**
    * Remap classifications
    */
    public function _remap($method, $params = array()) {
        $proptype = '';
        $propclass = '';
        $search = false;
        $method_lw = strtolower($method);
        switch($method_lw) {
            case 'residential': $proptype = PROPCATEGORY_RESIDENTIAL; $search = true; break;
            case 'commercial': $proptype = PROPCATEGORY_COMMERCIAL; $search = true; break;
            case 'land': $proptype = PROPCATEGORY_LAND; $search = true; break;
            case 'hotels-resorts': $proptype = PROPCATEGORY_HOTEL; $search = true; break;
            case 'condominiums': $propclass = PROPSUBCATEGORY_R_CONDOMINIUM; $search = true; break;
            case 'house-and-lots': $propclass = PROPSUBCATEGORY_R_HOUSEANDLOT; $search = true; break;
            case 'apartments': $propclass = PROPSUBCATEGORY_R_APARTMENT; $search = true; break;
            case 'hdb': $propclass = PROPSUBCATEGORY_R_HDB; $search = true; break;
            case 'boarding-houses': $propclass = PROPSUBCATEGORY_R_BOARDINGHOUSE; $search = true; break;
            case 'offices': $propclass = PROPSUBCATEGORY_C_OFFICE; $search = true; break;
            case 'soho': $propclass = PROPSUBCATEGORY_C_SOHO; $search = true; break;
            case 'retails': $propclass = PROPSUBCATEGORY_C_RETAIL; $search = true; break;
            case 'industrials': $propclass = PROPSUBCATEGORY_C_INDUSTRIAL; $search = true; break;
            case 'land-only': $propclass = PROPSUBCATEGORY_L_LANDONLY; $search = true; break;
            case 'land-with-structure': $propclass = PROPSUBCATEGORY_L_LANDWITHSTRUCTURE; $search = true; break;
            case 'farms': $propclass = PROPSUBCATEGORY_L_FARM; $search = true; break;
            case 'beach': $propclass = PROPSUBCATEGORY_L_BEACH; $search = true; break;
            case 'hotels': $propclass = PROPCLASS_H_HOTEL; $search = true; break; //Special; Use propclass for this
            case 'resorts': $propclass = PROPCLASS_H_RESORT; $search = true; break; //Special; Use propclass for this
            case 'pension-inns': $propclass = PROPSUBCATEGORY_H_PENSIONINN; $search = true; break;
            case 'convention-centers': $propclass = PROPSUBCATEGORY_H_CONVENTIONCENTER; $search = true; break;
        }
        if($search) {
            $this->search($proptype, $propclass);
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
        $datahead['title'] = 'Properties' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('properties' => true);
        
        include('ip2locationlite.class.php');
        $ipLite = new ip2location_lite;
        $ip = $this->input->ip_address();
        $location = $ipLite->getCountry($ip);
        $country = ( isset($location['countryCode']) ? $location['countryCode'] : '' );
        
        $off = 0; //Start new
        $lmt = LIMIT_PROPERTIES;
        $result_count = $this->_search_live('count', $off, $lmt, '', '', $country);
        if($result_count) {
            $data['total_found'] = $result_count->propcount;
        }
        $result = $this->_search_live('list', $off, $lmt, '', '', $country);
        $off += $lmt;
        
        $data['currencies'] = $this->config->item('currencies');
        $data['searchareaunit'] = $this->input->post('searchareaunit');
        $data['searchpriceunit'] = $this->input->post('searchpriceunit');
        $data['proptype'] = '';
        $data['propclass'] = '';
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
    
    public function search($proptype = '', $propclass = '') {
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $this->tank_auth->get_user_code();
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'Properties' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('properties' => true);
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters(ERROR_DELIMITER_OPEN, ERROR_DELIMITER_CLOSE);
        $this->form_validation->set_rules('searchkeywords', 'Keywords', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchlocation', 'Location', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchcountry', 'Country', '');
        $this->form_validation->set_rules('searchpricemin', 'Minimum Price', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchpricemax', 'Maximum Price', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchpriceunit', 'Price Unit', '');
        $this->form_validation->set_rules('searchareamin', 'Minimum Area', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchareamax', 'Maximum Area', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchareaunit', 'Area Unit', '');
        $this->form_validation->set_rules('searchroommin', 'Minimum Rooms', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchroommax', 'Maximum Rooms', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchproppost[]', 'Posting Type', '');
        $this->form_validation->set_rules('searchproptype[]', 'Property Type', '');
        $this->form_validation->set_rules('searchpropclass[]', 'Property Class', '');
        $this->form_validation->set_rules('score', 'Rating', '');
        $this->form_validation->set_rules('off', 'Offset', '');
        $this->form_validation->set_rules('lmt', 'Limit', '');
        $this->form_validation->set_rules('sort', 'Sort', '');
        $this->form_validation->set_rules('ord', 'Order', '');
        
        if(isset($_POST['searchcountry'])) {
            $country = $this->input->post('searchcountry');
        } else {
            include('ip2locationlite.class.php');
            $ipLite = new ip2location_lite;
            $ip = $this->input->ip_address();
            $location = $ipLite->getCountry($ip);
            $country = ( isset($location['countryCode']) ? $location['countryCode'] : '' );
        }
        
        $result = array();
        $off = 0;
        $lmt = LIMIT_PROPERTIES;
        if($this->form_validation->run() !== FALSE || ( $proptype != '' || $propclass != '' ) ) {
            $off = 0; //Start new
            $lmt = LIMIT_PROPERTIES;
            $result_count = $this->_search_live('count', $off, $lmt, $proptype, $propclass, $country);
            if($result_count) {
                $data['total_found'] = $result_count->propcount;
            }
            $result = $this->_search_live('list', $off, $lmt, $proptype, $propclass, $country);
            $off += $lmt;
        }
        
        $arrproppost = ( isset($_POST['searchproppost']) && is_array($_POST['searchproppost']) ? array_flip($_POST['searchproppost']) : array() );
        $arrproptype = ( isset($_POST['searchproptype']) && is_array($_POST['searchproptype']) ? array_flip($_POST['searchproptype']) : array() );
        $arrpropclass = ( isset($_POST['searchpropclass']) && is_array($_POST['searchpropclass']) ? array_flip($_POST['searchpropclass']) : array() );
        
        $data['currencies'] = $this->config->item('currencies');
        $data['searchareaunit'] = $this->input->post('searchareaunit');
        $data['searchpriceunit'] = $this->input->post('searchpriceunit');
        $data['proppost'] = $arrproppost;
        $data['proptype'] = ( $proptype != '' ? array($proptype => '0') : $arrproptype );
        $data['propclass'] = ( $propclass != '' ? array($propclass => '0') : $arrpropclass );
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
            $result = $this->_search_live('list', $off, $lmt, '', '', $country);
        }
        
        $userlogin = $this->tank_auth->is_logged_in();
        $usercode = $this->tank_auth->get_user_code();
        
        $listprops = array();
        foreach($result as $rec) {
            $vw = $this->load->view($this->folder . 'item', array('record' => $rec, 'usercode' => $usercode, 'appended' => true, 'userlogin' => $userlogin), true);
            array_push($listprops, $vw);   
        }        
        
        echo json_encode($listprops);
    }
    
    private function _search_live($mode = 'list', $off = 0, $lmt = LIMIT_PROPERTIES, $proptype = '', $propclass = '', $country = '') {
        $searchkeywords = str_replace(',', ' ', $this->input->post('searchkeywords'));
        $searchlocation = strtolower($this->input->post('searchlocation'));
        $searchlocation = str_replace('city', '', $searchlocation);
        $searchlocation = str_replace(',', ' ', $searchlocation);
        $searchpricemin = preg_replace("/[^0-9.]/", "", $this->input->post('searchpricemin'));
        $searchpricemax = preg_replace("/[^0-9.]/", "", $this->input->post('searchpricemax'));
        $searchpriceunit = $this->input->post('searchpriceunit');
        $searchareamin = preg_replace("/[^0-9.]/", "", $this->input->post('searchareamin'));
        $searchareamax = preg_replace("/[^0-9.]/", "", $this->input->post('searchareamax'));
        $searchareaunit = $this->input->post('searchareaunit');
        $searchroommin = preg_replace("/[^0-9.]/", "", $this->input->post('searchroommin'));
        $searchroommax = preg_replace("/[^0-9.]/", "", $this->input->post('searchroommax'));
        if($proptype != '') {
            $searchproptype[] = $proptype;
        } else {
            $searchproptype = ( is_array($this->input->post('searchproptype')) ? $this->input->post('searchproptype') : array() );
        }
        if($propclass != '') {
            $searchpropclass[] = $propclass;
        } else {
            $searchpropclass = ( is_array($this->input->post('searchpropclass')) ? $this->input->post('searchpropclass') : array() );
        }
        $searchrating = $this->input->post('score');
        $searchrating = ( is_numeric($searchrating) ? $searchrating : 0 );
        $filters = array('searchkeywords' => explode(' ', $searchkeywords),
                         'searchlocation' => explode(' ', $searchlocation),
                         'searchcountry' => $country,
                         'searchpricemin' => ( is_numeric($searchpricemin) ? $searchpricemin + 0 : '' ), //Add 0 to make it a number
                         'searchpricemax' => ( is_numeric($searchpricemax) ? $searchpricemax + 0 : '' ), //Add 0 to make it a number
                         'searchpriceunit' => $searchpriceunit,
                         'searchareamin' => ( is_numeric($searchareamin) ? $searchareamin + 0 : '' ), //Add 0 to make it a number
                         'searchareamax' => ( is_numeric($searchareamax) ? $searchareamax + 0 : '' ), //Add 0 to make it a number
                         'searchareaunit' => $searchareaunit,
                         'searchroommin' => ( is_numeric($searchroommin) ? intval($searchroommin) : '' ),
                         'searchroommax' => ( is_numeric($searchroommax) ? intval($searchroommax) : '' ),
                         'searchproppost' => ( is_array($this->input->post('searchproppost')) ? $this->input->post('searchproppost') : array() ),
                         'searchproptype' => $searchproptype,
                         'searchpropclass' => $searchpropclass,
                         'searchrating' => $searchrating,
                         'sort' => $this->input->post('sort'),
                         'ord' => $this->input->post('ord') );
        return $this->prop->get_search_result($filters, $mode, $off, $lmt);
    }

    public function agent($usercode = '', $offset = 0, $limit = LIMIT_AGENTPROPERTIES) {
        $sort = '';
        $ord = '';
        if(isset($_POST['off']) && isset($_POST['lmt'])) {
            $offset = $this->input->post('off');
            $limit = $this->input->post('lmt');
            $sort = $this->input->post('sort');
            $ord = $this->input->post('ord');
        }
        $result = $this->prop->get_list_agent($usercode, $offset, $limit, $sort, $ord);
        
        $userlogin = $this->tank_auth->is_logged_in();
        $usercode = $this->tank_auth->get_user_code();
        
        $listprops = array();
        foreach($result as $rec) {
            $vw = $this->load->view($this->folder . 'item', array('record' => $rec, 'usercode' => $usercode, 'appended' => true, 'userlogin' => $userlogin, 'showuser' => false), true);
            array_push($listprops, $vw);   
        }        
        
        echo json_encode($listprops);
    }
    
    public function company($companycode = '', $offset = 0, $limit = LIMIT_COMPANYPROPERTIES) {
        $sort = '';
        $ord = '';
        if(isset($_POST['off']) && isset($_POST['lmt'])) {
            $offset = $this->input->post('off');
            $limit = $this->input->post('lmt');
            $sort = $this->input->post('sort');
            $ord = $this->input->post('ord');
        }
        $result = $this->prop->get_list_company($companycode, $offset, $limit, $sort, $ord);
        
        $userlogin = $this->tank_auth->is_logged_in();
        $usercode = $this->tank_auth->get_user_code();
        
        $listprops = array();
        foreach($result as $rec) {
            $vw = $this->load->view($this->folder . 'item', array('record' => $rec, 'usercode' => $usercode, 'appended' => true, 'userlogin' => $userlogin), true);
            array_push($listprops, $vw);   
        }        
        
        echo json_encode($listprops);
    }
}