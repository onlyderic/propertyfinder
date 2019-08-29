<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Shortlist extends CI_Controller {
    
    private $folder = 'selections/';
    private $folder_props = 'properties/';
    
    function __construct() {
        parent::__construct();
        
        $this->load->model('Shortlists_Model', 'short');
    }
    
    public function _remap($method, $params = array()) {
        //Add to shortlist
        //Format: URL/shortlist/add/property-name/propertyid
        if( $method == 'add' &&  count($params) == 2 ) {
            $this->_add($params[1]);
            return true;
        }
        //Remove from shortlist
        //Format: URL/shortlist/remove/property-name/propertyid
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
        $datahead['title'] = 'My Shortlist' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('selections' => true);
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters(ERROR_DELIMITER_OPEN, ERROR_DELIMITER_CLOSE);
        $this->form_validation->set_rules('searchkeywords', 'Keywords', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchlocation', 'Location', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchcountry', 'Country', '');
        $this->form_validation->set_rules('searchpricemin', 'Minimum Price', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchpricemax', 'Maximum Price', 'trim|xss_clean|encode_php_tags');
        $this->form_validation->set_rules('searchpriceunit', 'Price Unit', '');
        $this->form_validation->set_rules('searchproppost[]', 'Property Posting', '');
        $this->form_validation->set_rules('searchproptype[]', 'Property Type', '');
        $this->form_validation->set_rules('off', 'Offset', '');
        $this->form_validation->set_rules('lmt', 'Limit', '');
        $this->form_validation->set_rules('sort', 'Sort', '');
        $this->form_validation->set_rules('ord', 'Order', '');
        
        $off = 0; //Start new
        $lmt = LIMIT_MYSHORTLIST;
        $result = $this->_search_live_shortlist($off, $lmt);
        $off += $lmt;
        
        $this->form_validation->run();
        
        $arrproppost = ( isset($_POST['searchproppost']) && is_array($_POST['searchproppost']) ? array_flip($_POST['searchproppost']) : array() );
        $arrproptype = ( isset($_POST['searchproptype']) && is_array($_POST['searchproptype']) ? array_flip($_POST['searchproptype']) : array() );
        
        $data['currencies'] = $this->config->item('currencies');
        $data['insearch'] = ( isset($_POST['searchkeywords']) ? true : false );
        $data['searchpriceunit'] = $this->input->post('searchpriceunit');
        $data['proppost'] = $arrproppost;
        $data['proptype'] = $arrproptype;
        $data['off'] = $off;
        $data['lmt'] = $lmt;
        $data['sort'] = $this->input->post('sort');
        $data['ord'] = $this->input->post('ord');
        $data['list'] = $result;
        
        $data['countries'] = $this->config->item('countries');
        $data['country'] = $this->input->post('searchcountry');
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'shortlist', $data);
        $this->load->view('footer');
    }
    
    public function search_more() {
        $result = array();
        if(isset($_POST['searchkeywords'])) {
            $off = $this->input->post('off');
            $lmt = $this->input->post('lmt');
            $result = $this->_search_live_shortlist($off, $lmt);
        }
        
        $userlogin = $this->tank_auth->is_logged_in();
        $usercode = $this->tank_auth->get_user_code();
        
        $listprops = array();
        foreach($result as $rec) {
            $vw = $this->load->view($this->folder_props . 'item', array('record' => $rec, 'usercode' => $usercode, 'shortlist' => true, 'appended' => true, 'userlogin' => $userlogin), true);
            array_push($listprops, $vw);   
        }        
        
        echo json_encode($listprops);
    }
    
    private function _search_live_shortlist($off = 0, $lmt = LIMIT_MYSHORTLIST) {
        $this->load->model('Properties_Model', 'prop');
        
        $usercode = $this->tank_auth->get_user_code();
        
        $searchkeywords = str_replace(',', ' ', $this->input->post('searchkeywords'));
        $searchlocation = strtolower($this->input->post('searchlocation'));
        $searchlocation = str_replace('city', '', $searchlocation);
        $searchlocation = str_replace(',', ' ', $searchlocation);
        $searchpricemin = str_replace(',', '', $this->input->post('searchpricemin'));
        $searchpricemin = str_replace(' ', '', $searchpricemin);
        $searchpricemax = str_replace(',', '', $this->input->post('searchpricemax'));
        $searchpricemax = str_replace(' ', '', $searchpricemax);
        $searchpriceunit = $this->input->post('searchpriceunit');
        $searchproppost = ( is_array($this->input->post('searchproppost')) ? $this->input->post('searchproppost') : array() );
        $searchproptype = ( is_array($this->input->post('searchproptype')) ? $this->input->post('searchproptype') : array() );
        $filters = array('searchshortlist' => true,
                         'searchshortlistusercode' => $usercode,
                         'searchkeywords' => explode(' ', $searchkeywords),
                         'searchlocation' => explode(' ', $searchlocation),
                         'searchcountry' => $this->input->post('searchcountry'),
                         'searchpricemin' => ( is_numeric($searchpricemin) ? $searchpricemin + 0 : '' ), //Add 0 to make it a number
                         'searchpricemax' => ( is_numeric($searchpricemax) ? $searchpricemax + 0 : '' ), //Add 0 to make it a number
                         'searchpriceunit' => $searchpriceunit,
                         'searchproppost' => $searchproppost,
                         'searchproptype' => $searchproptype,
                         'sort' => $this->input->post('sort'),
                         'ord' => $this->input->post('ord') );
        return $this->prop->get_search_result($filters, 'list', $off, $lmt);
    }
    
    public function _add($propcode = '') {
        if( isset($_POST['add']) && $_POST['add'] == 'true' && $propcode != '' ) {
            $usercode = $this->tank_auth->get_user_code();
            if($this->tank_auth->is_logged_in()) {
                $limit_sl = LIMIT_SHORTLIST;
            } else {
                $limit_sl = LIMIT_SHORTLIST_NOTSIGNEDIN;
            }
            if($this->_count() >= $limit_sl) {
                echo 'full';
            } elseif($this->short->create($propcode, $usercode)) {
                echo 'true';
            }
        }
        echo '';
    }
    
    public function _remove($propcode = '') {
        if( isset($_POST['remove']) && $_POST['remove'] == 'true' && $propcode != '' ) {
            $usercode = $this->tank_auth->get_user_code();
            $this->short->delete($propcode, $usercode);
        }
    }
    
    protected function _count() {
        $usercode = $this->tank_auth->get_user_code();
        return $this->short->count($usercode);
    }
}