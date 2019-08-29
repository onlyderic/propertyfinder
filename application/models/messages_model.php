<?php
class Messages_Model extends CI_Model {

    private $messages_table = 'msgs';
    private $users_table = 'usrs';
    
    function __construct() {
        parent::__construct();
    }
    
    function get($msgcode = '') {
        $msgcode = $this->db->escape($msgcode);
        
        $this->db->select($this->messages_table. '.*, ' .
                            $this->users_table . '.fname, ' . 
                            $this->users_table . '.lname, ' .
                            $this->users_table . '.profilepic, ' .
                            $this->users_table . '.usertype, ' .
                            ' DATE_FORMAT(MAX(' . $this->messages_table . '.datecreated),\'%d %b %y | %h:%i%p\') AS msgdate ', false);
        $this->db->from($this->messages_table);
        $this->db->join($this->users_table, $this->users_table . '.code = ' . $this->messages_table . '.fromcode', 'left');
        $this->db->where($this->messages_table . '.code', $msgcode);
        
        return $this->db->get()->row();
    }
    
    function get_otherguy_name($otherguy_usercode = '') {
        return $this->db->select('fname, lname')->get_where($this->users_table, array('code' => $otherguy_usercode))->row();
    }
    
    function count_unread($usercode = '') {
        $usercode = $this->db->escape($usercode);
        
        $querystr = "SELECT COUNT(distinct m.fromcode) AS msgcount
                    FROM msgs m
                    WHERE m.tocode = $usercode
                    AND m.readstatus = '" . NO . "' ";
        return $this->db->query($querystr, false)->row();
    }
    
    function get_messages_summary_list_by_user_code($usercode = '') {
        $usercode = $this->db->escape($usercode);
        
        $querystr = "SELECT DISTINCT 
                        CASE m.tocode WHEN $usercode THEN m.fromcode ELSE m.tocode END AS ucode, 
                        u.fname, 
                        u.lname, 
                        u.profilepic, 
                        u.usertype, 
                        DATE_FORMAT(MAX(m.datecreated),'%b %d, %Y | %h:%i%p') AS msgdate,
                        /*GROUP_CONCAT(m.readstatus ORDER BY m.datecreated DESC SEPARATOR ',') AS readstatuses*/
                        SUBSTRING_INDEX(GROUP_CONCAT(CONCAT(m.tocode,'/',m.readstatus) ORDER BY m.datecreated DESC SEPARATOR ','),',',1) AS readstatus
                    FROM msgs m
                    LEFT JOIN usrs u ON u.code = (CASE m.tocode WHEN $usercode THEN m.fromcode ELSE m.tocode END) AND u.code != $usercode
                    WHERE m.tocode = $usercode OR m.fromcode = $usercode
                    GROUP BY ucode
                    ORDER BY m.datecreated ASC ";
        return $this->db->query($querystr, false)->result();
    }
    
    function get_messages_list_by_conversation($mode = 'list', $otherguy_usercode = '', $usercode = '', $offset = 0, $limit = 2) {
        $otherguy_usercode = $this->db->escape($otherguy_usercode);
        $usercode = $this->db->escape($usercode);
        
        if($mode == 'count') {
            $querystr = "SELECT COUNT(m.code) AS msgcount ";
        } else {
            $querystr = "SELECT m.tocode, 
                                m.fromcode, 
                                m.message,
                                m.readstatus, 
                                u.fname, 
                                u.lname, 
                                u.profilepic, 
                                u.usertype, 
                                DATE_FORMAT(m.datecreated,'%d %b %y | %h:%i%p') AS msgdate ";    
        }
        $querystr .= " FROM msgs m
                    LEFT JOIN usrs u ON u.code = m.fromcode
                    WHERE ( m.tocode = $usercode OR m.fromcode = $usercode ) AND ( m.tocode = $otherguy_usercode OR m.fromcode = $otherguy_usercode )
                    ORDER BY m.datecreated DESC ";
        
        if( $mode == 'list' && is_numeric($offset) && is_numeric($limit) ) {
            $querystr .= " LIMIT " . (int)$offset . ", " . (int)$limit;
        }
        
        if($mode == 'list') {
            return $this->db->query($querystr, false)->result();
        } else {
            return $this->db->query($querystr, false)->row();
        }
    }
    
    function create($otherguy_usercode = '', $usercode = '', $msg = '') {
        if($this->db->insert($this->messages_table, array('tocode' => $otherguy_usercode, 'fromcode' => $usercode, 'message' => $msg))) {
            $messageid = $this->db->insert_id();
            
            //Create notification
            //First, remove previous notifications for the same conversation
            //We still create notification record for every reply, even if both are like chatting,
            //coz the notification will be updated every view of the reply
            //and when a reply wasn't viewed, at least there's still a notification
            $this->db->delete('notifications', array('usercode' => $otherguy_usercode, 'notifytype' => 'M', 'bycode' => $usercode));
            $this->db->insert('notifications', array('usercode' => $otherguy_usercode, 'notifytype' => 'M', 'bycode' => $usercode, 'oncode' => $messageid));
            
            return $messageid;
        }
        return NULL;
    }
    
    function update_read_by_conversation($otherguy_usercode = '', $usercode = '') {
        if($this->db->update($this->messages_table, array('readstatus' => YES), array('fromcode' => $otherguy_usercode, 'tocode' => $usercode))) {
            //Also update the notification counterpart
            $this->db->update('notifications', array('viewstatus' => YES), array('usercode' => $usercode, 'notifytype' => 'M', 'bycode' => $otherguy_usercode, 'viewstatus' => NO));
            return true;
        }
        return false;
    }
}