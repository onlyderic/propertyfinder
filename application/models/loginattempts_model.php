<?php
class LoginAttempts_Model extends CI_Model {
    
    private $loginattempts_table = 'loginattempts';

    function __construct() {
        parent::__construct();
    }
    
    function get_attempts_num($ipaddress, $email) {
        $this->db->select('1', FALSE);
        $this->db->where('ipaddress', $ipaddress);
        if(strlen($email) > 0) {
            $this->db->or_where('email', $email);
        }
        $qres = $this->db->get($this->loginattempts_table);
        return $qres->num_rows();
    }
    
    function increase_attempt($ipaddress, $email) {
        $this->db->insert($this->loginattempts_table, array('ipaddress' => $ipaddress, 'email' => $email));
    }
    
    function clear_attempts($ipaddress, $email, $expire_period = 86400) {
        $this->db->where(array('ipaddress' => $ipaddress, 'email' => $email));
        // Purge obsolete login attempts
        $this->db->or_where('UNIX_TIMESTAMP(time) <', time() - $expire_period);
        $this->db->delete($this->loginattempts_table);
    }
}