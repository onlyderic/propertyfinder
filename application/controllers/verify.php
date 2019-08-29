<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Verify extends CI_Controller {
    
    private $folder = 'verify/';
    
    function __construct() {                
        parent::__construct();
    }
    
    public function _remap($method, $params = array()) {
        //Verify an agent
        //Format: URL/agent/agent-name/agentid
        if( $method == 'agent' && count($params) == 2 ) {
            //If not logged in, or is different user, logout and redirect to login page
            $usercode = $this->tank_auth->get_user_code();
            if(!$this->tank_auth->is_logged_in()) {
                $this->tank_auth->logout(true);
                $this->session->set_flashdata('call_reference', 'verify/agent/' . $params[0] . '/' . $params[1] );
                redirect('login');
            }
            elseif($usercode != $params[1]) {
                $this->tank_auth->logout(true);
                $this->session->set_flashdata('call_reference', 'verify/agent/' . $params[0] . '/' . $usercode );
                redirect('login');
            }
            $this->_agent($params[0], $params[1]);
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
    
    protected function _agent($agentname = '', $agentcode = '') {
        $usercode = $this->tank_auth->get_user_code();
        
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $usercode;
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'Verify Profile' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('user' => true);
                
        $this->load->model('Users_Model', 'user');
        $profilerow = $this->user->get_user_by_code($agentcode);
        
        //The agent is the same as the current user
        if($profilerow && $profilerow->code == $usercode) {
            //However, check if it's currently verified
            $agentname = $profilerow->fname . ' ' . $profilerow->lname;
            $data['record'] = $profilerow;
        } else {
            redirect('agent/' . url_title($agentname) . '/' . $agentcode);
        }
        $pckg = $this->input->post('pckg');
        $data['pckg'] = $pckg;
        
        $this->load->helper(array('form'));
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_rules('id', '', 'trim');
        
        if($this->form_validation->run() !== FALSE) {
            $this->load->model('UserTransactions_Model', 'trx');
            $numdays = 0;
            $amount = 299;
            $trxcode = strtoupper(generate_code('USERTRX'));
            $record = array('code' => $trxcode,
                            'numdays' => $numdays,
                            'amount' => $amount,
                            'trxdate' => date('Y-m-d H:i:s'),
                            'promo' => NO,
                            'paystatus' => PAYSTATUS_UNPAID,
                            'recstatus' => PAYRECSTATUS_SUBMITTED);
            $result = $this->trx->create('V', $usercode, $record);
            
            if($result) {
                $data['purchase_id'] = $trxcode;
                $data['purchase_name'] = 'Verify: ' . $agentname;
                $data['purchase_amount'] = $amount;
                $data['purchase_type'] = 'Profile Verification';
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
        $this->load->view($this->folder . 'form', $data);
        $this->load->view('footer', $datafoot);
    }
}