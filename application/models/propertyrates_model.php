<?php
class PropertyRates_Model extends CI_Model {
    
    private $table = 'proprates';
    private $table_property = 'propinfos';

    function __construct() {
        parent::__construct();
    }
    
    function get_rate($propcode = '') {
        return $this->db->select('rating, numrating')->get_where($this->table_property, array('code' => $propcode))->row();
    }
    
    function get_rates_by_property_codes($propcodes = '', $usercode = '') {
        $usercode = $this->db->escape($usercode);
        $querystr = "SELECT propcode AS prate, rating FROM proprates WHERE usercode = $usercode AND propcode IN ($propcodes)";
        return $this->db->query($querystr, false)->result();
    }
    
    function check($propcode = '', $usercode = '') {
        if( $this->db->select('rating')->get_where($this->table, array('propcode' => $propcode, 'usercode' => $usercode))->row() ) {
            return true;
        }
        return false;       
    }
    
    function create($propcode = '', $usercode = '', $rating = 0) {
        if( ! $this->db->select('rating')->get_where($this->table, array('propcode' => $propcode, 'usercode' => $usercode))->row() &&
               is_numeric($rating) ) {
            if($this->db->insert($this->table, array('propcode' => $propcode, 'usercode' => $usercode, 'rating' => $rating))) {
                //Increase property's rate count
                $querystr = "UPDATE propinfos i SET i.rating = ( SELECT SUM(r.rating)/COUNT(r.rating) FROM proprates r WHERE r.propcode = i.code ), i.numrating = ( i.numrating + 1 ) WHERE i.code = " . $this->db->escape($propcode);
                $this->db->query($querystr);
                
                //Create notification
                if( $proprec = $this->db->select('ownercode')->get_where('propinfos', array('code' => $propcode))->row() ) {
                    $this->db->insert('notifications', array('usercode' => $proprec->ownercode, 'notifytype' => 'P', 'bycode' => $usercode, 'oncode' => $propcode));
                }
                
                return true;
            }
        }
        return NULL;
    }
}