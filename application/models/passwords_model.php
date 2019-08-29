<?php
class Passwords_Model extends CI_Model {
    
    private $pwds_table = 'pwds';
    private $users_table = 'usrs';

    function __construct() {
        parent::__construct();
    }
    
    function get_pwd_by_code($key = '') {
        $this->db->select($this->pwds_table . '.*, ( TIME_TO_SEC(TIMEDIFF(CURRENT_TIMESTAMP(), ' . $this->pwds_table . '.datecreated )) / 3600 ) AS hourspast', false);
        $this->db->from($this->pwds_table);
        $this->db->join($this->users_table, $this->users_table . '.code = ' . $this->pwds_table . '.usercode', 'left');
        $this->db->where($this->pwds_table . '.code = ' . $this->db->escape($key) );
        $this->db->where($this->users_table . '.recstatus = \'' . USERSTATUS_ACTIVE . '\'');

        return $this->db->get()->row();
    }
    
    function create($key, $usercode) {
        $this->db->insert($this->pwds_table, array('code' => $key, 'usercode' => $usercode));
    }
    
    function delete($key = '') {
        $this->db->delete($this->pwds_table, $where = array('code' => $key));
        return true;
    }
}