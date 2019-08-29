<?php
class Compares_Model extends CI_Model {
    
    private $table = 'propcompares';

    function __construct() {
        parent::__construct();
    }
    
    function get($propcode = '', $usercode = '') {
        if(!empty($usercode)) {
            $where = array('propcode' => $propcode, 'usercode' => $usercode);
        } else {
            $ip = $this->input->ip_address();
            $where = array('propcode' => $propcode, 'usercode' => 0, 'userip' => $ip);
        }
        return $this->db->get_where($this->table, $where)->row();
    }
    
    function count($usercode = '') {
        if(!empty($usercode)) {
            $where = array('usercode' => $usercode);
        } else {
            $ip = $this->input->ip_address();
            $where = array('usercode' => 0, 'userip' => $ip);
        }
        return $this->db->get_where($this->table, $where)->num_rows();
    }
    
    function delete($propcode = '', $usercode = '') {
        if(!empty($usercode)) {
            $where = array('propcode' => $propcode, 'usercode' => $usercode);
        } else {
            $ip = $this->input->ip_address();
            $where = array('propcode' => $propcode, 'usercode' => 0, 'userip' => $ip);
        }
        $this->db->delete($this->table, $where);
    }
    
    function create($propcode = '', $usercode = '') {
        $ip = $this->input->ip_address();
        if(!empty($usercode)) {
            $where = array('propcode' => $propcode, 'usercode' => $usercode);
        } else {
            $where = array('propcode' => $propcode, 'usercode' => 0, 'userip' => $ip);
        }
        if( ! $this->db->get_where($this->table, $where)->row() ) {
            if($this->db->insert($this->table, array('propcode' => $propcode, 'usercode' => $usercode, 'userip' => $ip))) {
                return true;
            }
        }
        return NULL;
    }
}