<?php
class Notifications_Model extends CI_Model {
    
    private $table = 'notifications';

    function __construct() {
        parent::__construct();
    }
        
    function get_count_by_user($usercode = '') {
        return $this->db->select('COUNT(usercode) AS count', false)->get_where($this->table, array('usercode' => $usercode, 'viewstatus' => NO))->row();
    }
    
    function viewed($usercode = '') {
        $this->db->update($this->table, array('viewstatus' => YES), array('usercode' => $usercode, 'viewstatus' => NO));
    }
    
    function get_notifications_list($usercode = '') {
        $usercode = $this->db->escape($usercode);
        
        $querystr = "SELECT DISTINCT 
                        n.*,
                        u.fname, 
                        u.lname, 
                        u.usertype, 
                        u.profilepic,
                        p.code AS propcode,
                        p.name AS propname
                    FROM notifications n
                    LEFT JOIN usrs u ON u.code = n.bycode
                    LEFT JOIN propinfos p ON p.code = n.oncode
                    WHERE n.usercode = $usercode
                    ORDER BY n.datecreated DESC
                    LIMIT 100";
        return $this->db->query($querystr, false)->result();
    }
}