<?php
class PropertyLikes_Model extends CI_Model {
    
    private $table = 'proplikes';
    private $table_property = 'propinfos';  

    function __construct() {
        parent::__construct();
    }
    
    function get_thumbs_count($propcode = '') {
        return $this->db->select('numlikes, numdislikes')->get_where($this->table_property, array('code' => $propcode))->row();
    }
    
    function get_likes_by_property_codes($propcodes = '', $usercode = '') {
        $usercode = $this->db->escape($usercode);
        $querystr = "SELECT propcode AS plike, thumbs AS thumbs FROM proplikes WHERE usercode = $usercode AND propcode IN ($propcodes)";
        return $this->db->query($querystr, false)->result();
    }
    
    function create($propcode = '', $usercode = '', $thumbs = '') {
        //If not yet liked/disliked, insert
        $row = $this->db->select('thumbs')->get_where($this->table, array('propcode' => $propcode, 'usercode' => $usercode))->row();
        if( ! $row ) {
            if($this->db->insert($this->table, array('propcode' => $propcode, 'usercode' => $usercode, 'thumbs' => $thumbs))) {
                if($thumbs == 'U') {
                    $querystr = "UPDATE propinfos i SET i.numlikes = ( i.numlikes + 1 ) WHERE i.code = " . $this->db->escape($propcode);
                } else {
                    $querystr = "UPDATE propinfos i SET i.numdislikes = ( i.numdislikes + 1 ) WHERE i.code = " . $this->db->escape($propcode);
                }
                $this->db->query($querystr);
                
                //Create notification
                if( $proprec = $this->db->select('ownercode')->get_where('propinfos', array('code' => $propcode))->row() ) {
                    $this->db->insert('notifications', array('usercode' => $proprec->ownercode, 'notifytype' => $thumbs, 'bycode' => $usercode, 'oncode' => $propcode));
                }
                
                return true;
            }
        }
        //Otherwise, reset
        else {
            if( $this->db->delete($this->table, array('propcode' => $propcode, 'usercode' => $usercode, 'thumbs' => $row->thumbs)) ) {
                $propcode = $this->db->escape($propcode);
                if($row->thumbs == 'U') {
                    $querystr = "UPDATE propinfos i SET i.numlikes = ( i.numlikes - 1 ) WHERE i.code = $propcode";
                } else {
                    $querystr = "UPDATE propinfos i SET i.numdislikes = ( i.numdislikes - 1 ) WHERE i.code = $propcode";
                }
                $this->db->query($querystr);
            }
            return true;
        }
        return NULL;
    }
}