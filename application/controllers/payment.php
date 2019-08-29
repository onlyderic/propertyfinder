<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Payment extends CI_Controller {
    
    private $folder = 'payments/';
    
    function __construct() {                
        parent::__construct();
    }

    public function index() {
    }
    
    //$mode = 'property'
    public function complete($mode = '', $name = '', $code = '', $trxcode = '') {
        $usercode = $this->tank_auth->get_user_code();
        
        //Set session for useracct, temporarily
        $this->session->set_userdata(array('useracct' => YES));
                                                
        $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
        $datahead['usercode'] = $usercode;
        $datahead['userpic'] = $this->tank_auth->get_userpic();
        $datahead['userfullname'] = $this->tank_auth->get_userfullname();
        $datahead['usertype'] = $this->tank_auth->get_usertype();
        $datahead['title'] = 'Payment Complete' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('user' => true);
                        
        $data['mode'] = $mode;
        $data['name'] = $name;
        $data['code'] = $code;
        $data['trxcode'] = $trxcode;
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'complete', $data);
        $this->load->view('footer', $datafoot);
    }
    
    //$mode = 'property'
    public function cancel($mode = '', $name = '', $code = '', $trxcode = '') {
        $usercode = $this->tank_auth->get_user_code();
            
        if($mode == 'property') {
            //Remove the record
            $this->load->model('PropertyTransactions_Model', 'trx');
            $result = $this->trx->delete($code, $usercode, $trxcode);
            
            $this->session->set_flashdata('transaction_status', 'info');
            $this->session->set_flashdata('transaction_message', 'You have cancelled the PayPal transaction.');
            redirect('feature/property/' . $name . '/' . $code);
        } else {
            
            $datahead['userlogin'] = $datafoot['userlogin'] = $this->tank_auth->is_logged_in();
            $datahead['usercode'] = $usercode;
            $datahead['userpic'] = $this->tank_auth->get_userpic();
            $datahead['userfullname'] = $this->tank_auth->get_userfullname();
            $datahead['usertype'] = $this->tank_auth->get_usertype();
            $datahead['title'] = 'Payment Cancelled' . PAGE_TITLE;
            $datahead['currpg'] = $_SERVER['REQUEST_URI'];
            $datahead['menu'] = array('user' => true);

            $data['mode'] = $mode;
            $data['name'] = $name;
            $data['code'] = $code;
            $data['trxcode'] = $trxcode;

            $this->load->view('header', $datahead);
            $this->load->view($this->folder . 'cancel', $data);
            $this->load->view('footer', $datafoot);
            
        }
    }

    public function process() {
        $this->load->library('Paypal_Lib');
        try {
            if ($this->paypal_lib->validate_ipn()) {
                $payment_status = $this->paypal_lib->ipn_data['payment_status']; //PayPal's status
                $txn_id = $this->paypal_lib->ipn_data['txn_id']; //PayPal's code
                $payment_date = $this->paypal_lib->ipn_data['payment_date']; //PayPal's date
                $item_number = $this->paypal_lib->ipn_data['item_number']; //My code
                $custom = $this->paypal_lib->ipn_data['custom']; //My custom

                if($custom == 'Property Feature') {
                    $this->load->model('PropertyTransactions_Model', 'trx');
                    $payment_date = date('Y-m-d H:i:s',strtotime($payment_date));
                    $result = $this->trx->confirm($item_number, $txn_id, $payment_status, $payment_date);

                    if(strtoupper($payment_status) == 'COMPLETED') {
                        $record = $this->trx->get_trx_by_code($item_number);

                        if($record) {
                            $trxcode = $record->code;
                            $username = $record->fname . ' ' . $record->lname;
                            $email = $record->email;
                            $rec = array(
                                'trxcode' => $trxcode,
                                'propcode' => $record->propcode,
                                'usercode' => $record->usercode,
                                'numdays' => $record->numdays,
                                'amount' => format_money($record->amount) . ' USD',
                                'trxdate' => $record->trxdate,
                                'startdate' => $record->startdate,
                                'enddate' => $record->enddate,
                                'paystatus' => $record->paystatus,
                                'recstatus' => $record->recstatus,
                                'ppcode' => $record->ppcode,
                                'ppstatus' => $record->ppstatus,
                                'username' => $username,
                                'email' => $email,
                                'propname' => $record->propname,
                                'propsubcategory' => get_text_subcategory($record->propsubcategory),
                                'propclassification' => get_text_classification($record->propclassification),
                                'proplocation' => $record->propcity . ', ' . get_text_country($record->propcountry)
                            );
                            $subject = 'Property Featured - Invoice [' . $trxcode . ']';
                            
                            //Send invoice email...
                            $this->_send_email_invoice($email, $username, $subject, $rec, 'property feature invoice');
                        }
                    }

                } elseif($custom == 'Profile Feature') {
                    $this->load->model('UserTransactions_Model', 'trx');
                    $payment_date = date('Y-m-d H:i:s',strtotime($payment_date));
                    $result = $this->trx->confirm($item_number, $txn_id, $payment_status, $payment_date);

                    if(strtoupper($payment_status) == 'COMPLETED') {
                        $record = $this->trx->get_trx_by_code($item_number);

                        if($record) {
                            $trxcode = $record->code;
                            $username = $record->fname . ' ' . $record->lname;
                            $email = $record->email;
                            $rec = array(
                                'trxcode' => $trxcode,
                                'trxtype' => $record->trxtype,
                                'usercode' => $record->usercode,
                                'numdays' => $record->numdays,
                                'amount' => format_money($record->amount) . ' USD',
                                'trxdate' => $record->trxdate,
                                'startdate' => $record->startdate,
                                'enddate' => $record->enddate,
                                'paystatus' => $record->paystatus,
                                'recstatus' => $record->recstatus,
                                'ppcode' => $record->ppcode,
                                'ppstatus' => $record->ppstatus,
                                'username' => $username,
                                'email' => $email
                            );
                            $subject = 'Profile Featured - Invoice [' . $trxcode . ']';
                            
                            //Send invoice email...
                            $this->_send_email_invoice($email, $username, $subject, $rec, 'profile feature invoice');
                        }
                    }

                } elseif($custom == 'Profile Verification') {
                    $this->load->model('UserTransactions_Model', 'trx');
                    $payment_date = date('Y-m-d H:i:s',strtotime($payment_date));
                    $result = $this->trx->confirm($item_number, $txn_id, $payment_status, $payment_date);

                    if(strtoupper($payment_status) == 'COMPLETED') {
                        $record = $this->trx->get_trx_by_code($item_number);

                        if($record) {
                            $trxcode = $record->code;
                            $username = $record->fname . ' ' . $record->lname;
                            $email = $record->email;
                            $rec = array(
                                'trxcode' => $trxcode,
                                'trxtype' => $record->trxtype,
                                'usercode' => $record->usercode,
                                'numdays' => $record->numdays,
                                'amount' => format_money($record->amount) . ' USD',
                                'trxdate' => $record->trxdate,
                                'startdate' => $record->startdate,
                                'enddate' => $record->enddate,
                                'paystatus' => $record->paystatus,
                                'recstatus' => $record->recstatus,
                                'ppcode' => $record->ppcode,
                                'ppstatus' => $record->ppstatus,
                                'username' => $username,
                                'email' => $email,
                                'licensenum' => $record->licensenum,
                                'companyname' => $record->companyname
                            );
                            $subject = 'Profile Verification - Invoice [' . $trxcode . ']';
                            
                            //Send invoice email...
                            $this->_send_email_invoice($email, $username, $subject, $rec, 'verify profile invoice');
                        }
                    }

                }
            }
        } catch(Exception $e) {}
    }
    
    protected function _send_email_invoice($toemail = '', $toname = '', $subject = '', $record = array(), $mode = '') {
        $fromemail = $this->config->item('email_from_invoice');
        $fromname = $this->config->item('email_from_name_invoice');

        $data2 = array(
            'mode' => $mode,
            'title' => 'Your PropertyGusto Receipt',
            'name' => $toname,
            'record' => $record
        );
        $message = $this->load->view('email/template', $data2, true);
        
        send_email($toemail, $toname, $fromemail, $fromname, $subject, $message);
    }
}