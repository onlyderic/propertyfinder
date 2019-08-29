<?php
class UserRates_Model extends CI_Model {
    
    private $table = 'usrrates';
    private $table_user = 'usrs';

    function __construct() {
        parent::__construct();
    }
    
    function get_rate($agentcode = '') {
        return $this->db->select('rating, numrating')->get_where($this->table_user, array('code' => $agentcode))->row();
    }
    
    function get_rates_by_agent_codes($agentcodes = '', $usercode = '') {
        $usercode = $this->db->escape($usercode);
        $querystr = "SELECT agentcode AS arate, rating FROM usrrates WHERE usercode = $usercode AND agentcode IN ($agentcodes)";
        return $this->db->query($querystr, false)->result();
    }
    
    function check($agentcode = '', $usercode = '') {
        if( $this->db->select('rating')->get_where($this->table, array('agentcode' => $agentcode, 'usercode' => $usercode))->row() ) {
            return true;
        }
        return false;       
    }
    
    function create($agentcode = '', $usercode = '', $rating = 0) {
        if( ! $this->db->select('rating')->get_where($this->table, array('agentcode' => $agentcode, 'usercode' => $usercode))->row() &&
                is_numeric($rating) ) {
            if($this->db->insert($this->table, array('agentcode' => $agentcode, 'usercode' => $usercode, 'rating' => $rating))) {
                //Increase property's rate count
                $querystr = "UPDATE usrs u SET u.rating = ( SELECT SUM(r.rating)/COUNT(r.rating) FROM usrrates r WHERE r.agentcode = u.code ), u.numrating = ( u.numrating + 1 ) WHERE u.code = " . $this->db->escape($agentcode);
                $this->db->query($querystr);
                
                //Create notification
                $this->db->insert('notifications', array('usercode' => $agentcode, 'notifytype' => 'O', 'bycode' => $usercode, 'oncode' => $agentcode));
                
                return true;
            }
        }
        return NULL;
    }
}