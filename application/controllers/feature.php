<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Feature extends CI_Controller {
    
    private $folder = 'feature/';
    
    function __construct() {                
        parent::__construct();
    }
    
    public function _remap($method, $params = array()) {
        //Feature a property
        //Format: URL/property/property-name/propertyid
        if( $method == 'property' && count($params) == 2 ) {
            //If not logged in, logout and redirect to login page
            $usercode = $this->tank_auth->get_user_code();
            if(!$this->tank_auth->is_logged_in()) {
                $this->tank_auth->logout(true);
                $this->session->set_flashdata('call_reference', 'feature/property/' . $params[0] . '/' . $params[1] );
                redirect('login');
            }
            $this->_property($params[0], $params[1]);
            return true;
        }
        //Feature an agent profile
        //Format: URL/agent/agent-name/agentid
        elseif( $method == 'agent' && count($params) == 2 ) {
            //If not logged in, or is different user, logout and redirect to login page
            $usercode = $this->tank_auth->get_user_code();
            if(!$this->tank_auth->is_logged_in()) {
                $this->tank_auth->logout(true);
                $this->session->set_flashdata('call_reference', 'feature/agent/' . $params[0] . '/' . $params[1] );
                redirect('login');
            }
            elseif($usercode != $params[1]) {
                $this->tank_auth->logout(true);
                $this->session->set_flashdata('call_reference', 'feature/agent/' . $params[0] . '/' . $usercode );
                redirect('login');
            }
            $this->_agent($params[0], $params[1]);
            return true;
        }
        //Feature a company profile
        //Format: URL/company/company-name/userid
        elseif( $method == 'company' && count($params) == 2 ) {
            //If not logged in, or is different user, logout and redirect to login page
            $usercode = $this->tank_auth->get_user_code();
            if(!$this->tank_auth->is_logged_in()) {
                $this->tank_auth->logout(true);
                $this->session->set_flashdata('call_reference', 'feature/company/' . $params[0] . '/' . $params[1] );
                redirect('login');
            }
            elseif($usercode != $params[1]) {
                $this->tank_auth->logout(true);
                $this->session->set_flashdata('call_reference', 'feature/company/' . $params[0] . '/' . $usercode );
                redirect('login');
            }
            $this->_agent($params[0], $params[1]); //Use the same function
            return true;
        }
        if(method_exists($this, $method)) {
            return call_user_func_array(array($this, $method), $params);
        } else {
            show_404();
        }
    }

    public function index() {
    }
    
    protected function _property($propname = '', $propcode = '') {
        $usercode = $this->tank_auth->get_user_code();
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $usercode;
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'Feature Property' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('user' => true);
                
        $this->load->model('Properties_Model', 'prop');
        $profilerow = $this->prop->get_property_by_code($propcode);
        
        //The property should exists and owned by the current user
        if($profilerow && $profilerow->ownercode == $usercode) {
            //However, check if it's currently featured
            $propname = $profilerow->name;
            $data['record'] = $profilerow;
        } else {
            redirect('property/' . url_title($propname) . '/' . $propcode);
        }
        $pckg = $this->input->post('pckg');
        $data['pckg'] = $pckg;
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('pckg', 'Package', 'trim|required|maxlength[1]|xss_clean');
        
        if($this->form_validation->run() !== FALSE) {
            $this->load->model('PropertyTransactions_Model', 'trx');
            $numdays = str_replace('DAYS', '', $pckg);
            switch($numdays) {
                case '30': $amount = 45; break;
                case '90': $amount = 94.50; break;
                case '180': $amount = 189; break;
                case '360': $amount = 249; break;
                default: $amount = 0;
            }
            $trxcode = strtoupper(generate_code('PROPTRX'));
            $record = array('code' => $trxcode,
                            'numdays' => $numdays,
                            'amount' => $amount,
                            'trxdate' => date('Y-m-d H:i:s'),
                            'promo' => NO,
                            'paystatus' => PAYSTATUS_UNPAID,
                            'recstatus' => PAYRECSTATUS_SUBMITTED);
            $result = $this->trx->create($propcode, $usercode, $record);
            
            if($result) {
                $data['purchase_id'] = $trxcode;
                $data['purchase_name'] = 'Feature: ' . $propname;
                $data['purchase_amount'] = $amount;
                $data['purchase_type'] = 'Property Feature';
                $data['purchase_urladd'] = 'property/' . url_title($propname) . '/' . $propcode . '/' . $trxcode;
                $this->load->view('header', $datahead);
                $this->load->view('payments/redirect', $data);
                $this->load->view('footer');
                return true;
            }
        }   
        
        $data['message_status'] = $this->session->flashdata('transaction_status');
        $data['message'] = $this->session->flashdata('transaction_message');
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'form_property', $data);
        $this->load->view('footer', $datafoot);
    }
    
    protected function _agent($agentname = '', $agentcode = '') {
        $usercode = $this->tank_auth->get_user_code();
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $usercode;
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'Feature Profile' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('user' => true);
                
        $this->load->model('Users_Model', 'user');
        $profilerow = $this->user->get_user_by_code($agentcode);
        
        //The agent is the same as the current user
        if($profilerow && $profilerow->code == $usercode) {
            //However, check if it's currently featured
            $agentname = $profilerow->fname . ' ' . $profilerow->lname;
            $data['record'] = $profilerow;
        } else {
            redirect( ($profilerow->fname == USERTYPE_COMPANY ? 'company/' : 'agent/' ) . url_title($agentname) . '/' . $agentcode);
        }
        $pckg = $this->input->post('pckg');
        $data['pckg'] = $pckg;
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('pckg', 'Package', 'trim|required|maxlength[1]|xss_clean');
        
        if($this->form_validation->run() !== FALSE) {
            $this->load->model('UserTransactions_Model', 'trx');
            $numdays = str_replace('DAYS', '', $pckg);
            switch($numdays) {
                case '30': $amount = 25; break;
                case '90': $amount = 52.50; break;
                case '180': $amount = 105; break;
                case '360': $amount = 199; break;
                default: $amount = 0;
            }
            $trxcode = strtoupper(generate_code('USERTRX'));
            $record = array('code' => $trxcode,
                            'numdays' => $numdays,
                            'amount' => $amount,
                            'trxdate' => date('Y-m-d H:i:s'),
                            'promo' => NO,
                            'paystatus' => PAYSTATUS_UNPAID,
                            'recstatus' => PAYRECSTATUS_SUBMITTED);
            $result = $this->trx->create('F', $usercode, $record);
            
            if($result) {
                $data['purchase_id'] = $trxcode;
                $data['purchase_name'] = 'Feature: ' . $agentname;
                $data['purchase_amount'] = $amount;
                $data['purchase_type'] = 'Profile Feature';
                $data['purchase_urladd'] = 'agent/' . url_title($agentname) . '/' . $usercode . '/' . $trxcode;
                $this->load->view('header', $datahead);
                $this->load->view('payments/redirect', $data);
                $this->load->view('footer');
                return true;
            }
        }   
        
        $data['message_status'] = $this->session->flashdata('transaction_status');
        $data['message'] = $this->session->flashdata('transaction_message');
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'form_agent', $data);
        $this->load->view('footer', $datafoot);
    }
}