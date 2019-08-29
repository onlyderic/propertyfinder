<?php
class Companies_Model extends CI_Model {
    
    private $table = 'comps';
    
    private $users_table = 'usrs';
    private $userdescs_table = 'usrdescs';
    private $propinfos_table = 'propinfos';
    
    private $comprates_table = 'comprates';

    function __construct() {
        parent::__construct();
    }
    
    function create($record = array()) {
        if($this->db->insert($this->table, $record)) {
            return array('code' => $record['code']);
        }
        return NULL;
    }
    
    function get_company_by_code($companycode = '') {
        $usercode = $this->tank_auth->get_user_code();
        $usercode = $this->db->escape($usercode);
        
        $this->db->select($this->table . '.*, ' . $this->users_table . '.featured, ' . $this->table . '.rating AS comprating, ' . $this->comprates_table . '.rating AS useragentrating ', false);
        $this->db->from($this->table);
        $this->db->join($this->users_table, $this->users_table . '.code = ' . $this->table . '.code', 'left');
        $this->db->join($this->comprates_table, $this->comprates_table . '.compcode = ' . $this->table . '.code AND ' . $this->comprates_table . '.usercode = ' . $usercode, 'left');
        $this->db->where($this->table . '.code', $companycode);
        
        return $this->db->get()->row();
    }
    
    function get_autocomplete($term = '') {
        $this->db->select('code AS id, companyname AS value, profilepic AS pic');
        $this->db->like('companyname', $this->db->escape_like_str($term));
        return $this->db->get($this->table)->result();
    }
    
    function update($companyrecord = array(), $userrecord = array(), $userdescrecord = array(), $usercode = '') {
        if($this->db->update($this->table, $companyrecord, array('code' => $usercode))) {
            //Also update the user record...
            $this->db->update($this->users_table, $userrecord, array('code' => $usercode));
            $this->db->update($this->userdescs_table, $userdescrecord, array('code' => $usercode));
            
            //Update user's info of company
            $this->db->update($this->users_table, 
                    array('companyname' => $companyrecord['companyname']), 
                    array('companycode' => $usercode));
        
            return true;
        }
        return false;
    }
    
    function update_pic($usercode = '', $field = '', $pic = '') {
        $this->db->set($field, $pic);
        $this->db->where('code', $usercode);
        if($this->db->update($this->table)) {
            
            //Update the profile pic of the user of this company
            $this->db->update($this->users_table, 
                    array('profilepic' => $pic), 
                    array('code' => $usercode));
            
            //Update the "owner" data on property information table
            $this->db->update($this->propinfos_table, 
                    array('ownerpic' => $pic), 
                    array('ownercode' => $usercode));
            
            return true;
        }
        return false;
    }
    
    function get_search_result($filters = array(), $mode = 'list', $offset = 0, $limit = 10) {
        $usercode = $this->tank_auth->get_user_code();
        $usercode = $this->db->escape($usercode);
        
        if($mode == 'count') {
            $querystr = "SELECT COUNT(c.code) AS compcount ";
        } else {
            $querystr = "SELECT c.code AS compcode,
                                c.companyname,
                                c.rating,
                                c.numrating,
                                c.profilepic,
                                c.country,
                                c.city,
                                u.numproperties,
                                u.featured,
                                ur.rating AS useragentrating ";
        }
        $querystr .= " FROM comps c
                       LEFT  JOIN usrs u ON u.code = c.code 
                            AND u.recstatus = '" . USERSTATUS_ACTIVE . "' 
                            AND u.usertype = '" . USERTYPE_COMPANY . "'
                       LEFT JOIN usrrates ur ON ur.agentcode = u.code AND ur.usercode = $usercode 
                       WHERE 1=1 ";
        
        //Keyword
        $where = "";
        foreach($filters['searchkeywords'] as $k => $v) {
            if(!empty($v)) {
                $where .= " OR c.companyname LIKE '%{$this->db->escape_like_str($v)}%' ";
            }
        }
        if($where != "") {
            $querystr .= " AND ( 1=0 " . $where . " ) ";
        }
        
        //Location
        $where = "";
        foreach($filters['searchlocation'] as $k => $v) {
            if(!empty($v)) {
                $where .= " OR c.city LIKE '%{$this->db->escape_like_str($v)}%' ";
            }
        }
        if($where != "") {
            $querystr .= " AND ( 1=0 " . $where . " ) ";
        }
        
        //Country
        $where = "";
        if( isset($filters['searchcountry']) && !empty($filters['searchcountry']) ) {
            $where .= " OR c.country = '{$this->db->escape_like_str($filters['searchcountry'])}' ";
        }
        if($where != "") {
            $querystr .= " AND ( 1=0 " . $where . " ) ";
        }
        
        //Ratings
        if( !empty($filters['searchrating']) && is_numeric($filters['searchrating']) ) {
            $querystr .= " AND c.rating >= " . $filters['searchrating'];
        }
        
        //Sorting and Limits
        if($mode != 'count') {
            
            $sort = "";
            if( isset($filters['sort']) && !empty($filters['sort']) ) {
                $ord = '';
                if( isset($filters['ord']) && ($filters['ord'] == 'asc' || $filters['ord'] == 'desc') ) {
                    $ord = $filters['ord'];
                }
                switch($filters['sort']) {
                    case 'name': //Company Name
                        $sort = " c.companyname " . $ord . ", u.featured DESC"; break;
                    case 'popularity': //Popularity (rates)
                        $sort = " c.rating " . $ord . ", u.featured DESC"; break;
                    case 'featured': //Featured
                        $sort = " u.featured DESC "; break;
                }
            } else {
                $sort .= " u.featured DESC, c.companyname ASC ";
            }
            if($sort != "") {
                $querystr .= " ORDER BY " . $sort;
            }
            if( is_numeric($offset) && is_numeric($limit) ) {
                $querystr .= " LIMIT " . (int)$offset . ", " . (int)$limit;
            }
        
        }
                
        $query = $this->db->query($querystr, false);
        
        if($mode == 'count') {
            return $query->row();
        } else {
            return $query->result();
        }
    }
}