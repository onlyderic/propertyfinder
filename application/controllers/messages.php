<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Messages extends CI_Controller {
    
    private $folder = 'messages/';
    
    function __construct() {
        parent::__construct();
        
        $this->load->model('Messages_Model', 'msg');
    }
    
    public function _remap($method, $params = array()) {
        if( $method == 'index' ) {
            //If not logged in or editing a different profile, logout and redirect to login page
            if(!$this->tank_auth->is_logged_in()) {
                $this->tank_auth->logout(true);
                $this->session->set_flashdata('call_reference', 'messages');
                redirect('login');
            }
        }
        elseif( $method == 'count' ) {
            $this->_count();
            return true;
        }
        //If method is read it means that it's reading a particular conversation
        //Format: URL/messages/read/agent-name/agentid
        elseif( $method == 'read' && count($params) == 2 ) {
            $this->_read($params[1]);
            return true;
        }
        //If method is load it means that it's loading more messages a particular conversation
        //Format: URL/messages/load/agent-name/agentid
        elseif( $method == 'load' && count($params) == 2 ) {
            $this->_load($params[1]);
            return true;
        }
        //If method is reply it means that it's replying a new message to a particular conversation
        //Format: URL/messages/reply/agent-name/agentid
        elseif( $method == 'reply' && count($params) == 2 ) {
            $this->_reply($params[1]);
            return true;
        }
        //This means that it's starting a new conversation, but we use the same function
        //Format: URL/messages/start-conversation/agent-name/agentid
        elseif( $method == 'start-conversation' && count($params) == 2 ) {
            $this->_reply($params[1]);
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
        $datahead['title'] = 'Inbox' . PAGE_TITLE;
        $datahead['currpg'] = $_SERVER['REQUEST_URI'];
        $datahead['menu'] = array('user' => true);
        
        $userrows = $this->msg->get_messages_summary_list_by_user_code($usercode);

        $summary = array();
        foreach($userrows as $row) {
            $readstatusarr = explode('/', $row->readstatus);
            $readstatusclass = '';
            if(count($readstatusarr) == 2) {
                $readstatus = ( $readstatusarr[0] == $usercode ? $readstatusarr[1] : '' );
                $readstatusclass = ( $readstatus == NO ? 'unread' : '' );
            }
            $summary[] = array('ucode' => $row->ucode,
                          'userfullname' => $row->fname . ' ' . $row->lname,
                          'usertype' => $row->usertype,
                          'profilepic' => $row->profilepic,
                          'msgdate' => $row->msgdate,
                          'readstatusclass' => $readstatusclass);
        }
        $data['summary'] = array_reverse($summary);
        
        //Count unique unread conversations 
        $row = $this->msg->count_unread($usercode);
        
        $data['msgcount'] = '';
        if($row) {
            $data['msgcount'] = $row->msgcount;
        }
        
        $this->load->view('header', $datahead);
        $this->load->view($this->folder . 'messages', $data);
        $this->load->view('footer', $datafoot);
    }
    
    protected function _read($otherguy_usercode = '') {
        $usercode = $this->tank_auth->get_user_code();
        
        $row = $this->msg->get_otherguy_name($otherguy_usercode);
        
        $data['otherguy_usercode'] = $otherguy_usercode;
        $data['userfullname'] = '';
        if($row) {
            $data['userfullname'] = $row->fname . ' ' . $row->lname;
        }
        
        $row = $this->msg->get_messages_list_by_conversation('count', $otherguy_usercode, $usercode, 0, 2);
        $data['conversationcount'] = 0;
        if($row) {
            $data['conversationcount'] = $row->msgcount;
        }
        
        $result = $this->msg->get_messages_list_by_conversation('list', $otherguy_usercode, $usercode, 0, 2);
        
        //Update all messages for this user from the otherguy to 'Read'
        $this->msg->update_read_by_conversation($otherguy_usercode, $usercode);
        
        $data['off'] = 2;
        $data['lmt'] = 2;
        $data['list'] = array_reverse($result);
        
        $this->load->view($this->folder . 'conversation', $data);
    }
    
    protected function _load($otherguy_usercode = '') {
        $usercode = $this->tank_auth->get_user_code();
        
        $off = $this->input->get('off');
        $lmt = $this->input->get('lmt');
        
        $result = $this->msg->get_messages_list_by_conversation('list', $otherguy_usercode, $usercode, $off, $lmt);
        
        $listmsgs = array();
        foreach($result as $rec) {
            $vw = $this->load->view($this->folder . 'item', array('record' => $rec), true);
            array_push($listmsgs, $vw);   
        }        
        
        echo json_encode($listmsgs);
    }
    
    protected function _reply($otherguy_usercode = '') {
        $result = array('status' => 'failed', 'message' => 'Failed to record your reply.', 'item' => '');
        
        if( isset($_POST['newmsg']) && !empty($_POST['newmsg']) ) {
            $usercode = $this->tank_auth->get_user_code();

            $msg = $this->input->post('newmsg');
            $msg = htmlspecialchars($msg);

            $msgcode = $this->msg->create($otherguy_usercode, $usercode, $msg);

            if( $msgcode ) {
                $row = $this->msg->get($msgcode);
                
                if($row) {
                    $vw = $this->load->view($this->folder . 'item', array('record' => $row), true);
                    $result['status'] = 'success';   
                    $result['item'] = $vw;   
                    $result['message'] = '';
                }  else {
                    $result['status'] = 'Failed to get the record.'; 
                }               
            }  else {
                $result['status'] = 'Failed to save your reply.'; 
            }
        } 
        
        echo json_encode($result);
    }

    protected function _count() {
        $usercode = $this->tank_auth->get_user_code();
        
        //Count unique unread conversations 
        $row = $this->msg->count_unread($usercode);
        
        $result['msgcount'] = '';
        if($row) {
            $result['msgcount'] = $row->msgcount;
        }
        
        echo json_encode($result);
    }
}