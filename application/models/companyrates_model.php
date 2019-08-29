<?php
class CompanyRates_Model extends CI_Model {
    
    private $table = 'comprates';
    private $table_comp = 'comps';

    function __construct() {
        parent::__construct();
    }
    
    function get_rate($compcode = '') {
        return $this->db->select('rating, numrating')->get_where($this->table_comp, array('code' => $compcode))->row();
    }
    
    function get_rates_by_agent_codes($compcodes = '', $usercode = '') {
        $usercode = $this->db->escape($usercode);
        $querystr = "SELECT compcode AS crate, rating FROM comprates WHERE usercode = $usercode AND compcode IN ($compcodes)";
        return $this->db->query($querystr, false)->result();
    }
    
    function check($compcode = '', $usercode = '') {
        if( $this->db->select('rating')->get_where($this->table, array('compcode' => $compcode, 'usercode' => $usercode))->row() ) {
            return true;
        }
        return false;       
    }
    
    function create($compcode = '', $usercode = '', $rating = 0) {
        if( ! $this->db->select('rating')->get_where($this->table, array('compcode' => $compcode, 'usercode' => $usercode))->row() &&
                is_numeric($rating) ) {
            if($this->db->insert($this->table, array('compcode' => $compcode, 'usercode' => $usercode, 'rating' => $rating))) {
                //Increase property's rate count
                $querystr = "UPDATE comps c SET c.rating = ( SELECT SUM(r.rating)/COUNT(r.rating) FROM comprates r WHERE r.compcode = c.code ), c.numrating = ( c.numrating + 1 ) WHERE c.code = " . $this->db->escape($compcode);
                $this->db->query($querystr);
                
                //Create notification
                $this->db->insert('notifications', array('usercode' => $compcode, 'notifytype' => 'O', 'bycode' => $usercode, 'oncode' => $compcode));
                
                return true;
            }
        }
        return NULL;
    }
}