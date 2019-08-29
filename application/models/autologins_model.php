<?php
class AutoLogins_Model extends CI_Model {
    
    private $autologins_table = 'autologins';
    private $users_table = 'usrs';

    function __construct() {
        parent::__construct();
    }
        
    function purge($usercode) {
        $this->db->where('usercode', $usercode);
        $this->db->where('useragent', substr($this->input->user_agent(), 0, 149));
        $this->db->where('lastip', $this->input->ip_address());
        $this->db->delete($this->autologins_table);
    }
	
    function get($usercode, $key) {
        $this->db->select($this->users_table.'.code');
        $this->db->select($this->users_table.'.fname');
        $this->db->select($this->users_table.'.lname');
        $this->db->select($this->users_table.'.usertype');
        $this->db->select($this->users_table.'.profilepic');
        $this->db->from($this->users_table);
        $this->db->join($this->autologins_table, $this->autologins_table.'.usercode = '.$this->users_table.'.code');
        $this->db->where($this->autologins_table.'.usercode', $usercode);
        $this->db->where($this->autologins_table.'.id', $key);
        $query = $this->db->get();
        if ($query->num_rows() == 1) return $query->row();
        return NULL;
    }
    
    function set($usercode, $key) {
        return $this->db->insert($this->autologins_table, array(
            'usercode' 		=> $usercode,
            'id'	 	=> $key,
            'useragent' 	=> substr($this->input->user_agent(), 0, 149),
            'lastip' 		=> $this->input->ip_address(),
        ));
    }
        
    function delete($usercode, $key) {
        $this->db->where('usercode', $usercode);
        $this->db->where('id', $key);
        $this->db->delete($this->autologins_table);
    }
}