<?php
class RecentViews_Model extends CI_Model {
    
    private $views_table = 'propviews';
    private $history_table = 'propviewhists';

    function __construct() {
        parent::__construct();
    }
    
    function delete($propcode = '', $usercode = '') {
        //History should not be deleted
        if(!empty($usercode)) {
            $where = array('propcode' => $propcode, 'usercode' => $usercode);
        } else {
            $ip = $this->input->ip_address();
            $where = array('propcode' => $propcode, 'usercode' => 0, 'userip' => $ip);
        }
        $this->db->delete($this->views_table, $where);
    }
    
    function create($propcode = '', $usercode = '') {
        $ip = $this->input->ip_address();
        if(!empty($usercode)) {
            $where = array('propcode' => $propcode, 'usercode' => $usercode);
        } else {
            $where = array('propcode' => $propcode, 'usercode' => 0, 'userip' => $ip);
        }
        if( ! $this->db->get_where($this->views_table, $where)->row() ) {
            //There could be times when the profile has been viewed and was deleted from views list.
            //Views list will also be regularly cleaned up by the system, and each agent has only limited number of views recorded at a certain time
            //So, still insert into the views list but not anymore to history
            if( ! $this->db->get_where($this->history_table, $where)->row() ) {
                //Create history and increment numviews of property.
                $this->db->insert($this->history_table, array('propcode' => $propcode, 'usercode' => $usercode, 'userip' => $ip));
                $querystr = "UPDATE propinfos i SET i.numviews = (i.numviews + 1) WHERE i.code = {$this->db->escape($propcode)}";
                $this->db->query($querystr);
            }
            if($this->db->insert($this->views_table, array('propcode' => $propcode, 'usercode' => $usercode, 'userip' => $ip))) {
                return true;
            }
        }
        return NULL;
    }
}