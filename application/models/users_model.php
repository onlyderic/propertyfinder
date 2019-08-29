<?php
class Users_Model extends CI_Model {
    
    private $users_table = 'usrs';
    private $userdescs_table = 'usrdescs';
    private $useroauths_table = 'usroauths';
    private $companies_table = 'comps';
    private $propinfos_table = 'propinfos';
    
    private $userrates_table = 'usrrates';

    function __construct() {
        parent::__construct();
    }
    
    function get_user_by_code($usercode = '') {
        $usercode2 = $this->tank_auth->get_user_code();
        $usercode2 = $this->db->escape($usercode2);
        
        $this->db->select($this->users_table.'.*, ' . $this->userdescs_table . '.*, DATE_FORMAT(datecreated,\'%D of %b %Y\') AS fdatecreated, ' . 
                            $this->userrates_table . '.rating AS useragentrating ', false);
        $this->db->from($this->users_table);
        $this->db->join($this->userdescs_table, $this->users_table . '.code = ' . $this->userdescs_table . '.code', 'left');
        $this->db->join($this->userrates_table, $this->userrates_table . '.agentcode = ' . $this->users_table . '.code AND ' . $this->userrates_table . '.usercode = ' . $usercode2, 'left');
        $this->db->where($this->users_table . '.code', $usercode);
        $this->db->where($this->users_table . '.recstatus = \'A\'');

        return $this->db->get()->row();
    }
    
    function get_user_by_oauth($oauthprovider = '', $oauthuid = '') {
        $this->db->select($this->users_table.'.*, ' . $this->useroauths_table . '.*, DATE_FORMAT(datecreated,\'%D of %b %Y\') AS fdatecreated', false);
        $this->db->from($this->users_table);
        $this->db->join($this->useroauths_table, $this->users_table . '.code = ' . $this->useroauths_table . '.code', 'left');
        $this->db->where($this->useroauths_table . '.oauthprovider', $oauthprovider);
        $this->db->where($this->useroauths_table . '.oauthuid', $oauthuid);
        $this->db->where($this->users_table . '.recstatus = \'A\'');
        
        return $this->db->get()->row();
    }
    
    function get_user_by_email($email = '') {
        $this->db->where('LOWER(email)=', strtolower($email));

        $query = $this->db->get($this->users_table);
        if($query->num_rows() == 1) {
            return $query->row();
        }
        return NULL;
    }
    
    function check_user_by_code($usercode = '') {
        if( $this->db->select('code')->get_where($this->users_table, array('code' => $usercode))->row() ) {
            return true;
        }
        return false;       
    }
    
    function create($record = array(), $lastip = '', $oauthprovider = '', $oauthuid = '', $oauthtoken = '', $oauthsecret = '') {
        $usercode = strtoupper(generate_code(CODE_AGENT));
        $record['code'] = $usercode;
        if($this->db->insert($this->users_table, $record)) {
            $data = array(
                'code' => $usercode,
                'dateregister' => date('Y-m-d H:i:s'),
                'lastip' => $lastip
            );
            $this->db->insert($this->userdescs_table, $data); 
            
            $data = array(
                'code' => $usercode,
                'oauthprovider' => $oauthprovider,
                'oauthuid' => $oauthuid,
                'oauthtoken' => $oauthtoken,
                'oauthsecret' => $oauthsecret
            );
            $this->db->insert($this->useroauths_table, $data); 
            return array('code' => $usercode);
        }
        return NULL;
    }
    
    function update($record = array(), $usercode = '') {
        if($this->db->update($this->users_table, $record, array('code' => $usercode))) {
            //If new company, insert
            if(empty($record['companycode'])) {
                $companycode = strtoupper(generate_code(CODE_COMPANY));
                $data = array(
                    'code' => $companycode,
                    'companyname' => $record['companyname'],
                    'profilepic' => $record['companypic']
                );
                $this->db->insert($this->companies_table, $data); 
                $record2 = array('companycode' => $companycode);
                $this->db->update($this->users_table, $record2, array('code' => $usercode));
            }
            //Otherwise, if the company has no Logo on its record and the user has uploaded for it,
            //save the same logo to the comps record and to all user records that uses the company
            else {
                $data = array('profilepic' => $record['companypic']);
                $where = "code = " . $this->db->escape($record['companycode']) . " AND ( profilepic IS NULL OR profilepic = '' )";
                $this->db->where($where);
                $this->db->update($this->companies_table, $data); 
            }
            
            //Update the "owner" data on property information table
            $this->db->update($this->propinfos_table, 
                    array('ownername' => $record['fname'] . ' ' . $record['lname']), 
                    array('ownercode' => $usercode));
        
            return true;
        }
        return false;
    }
    
    function update_numproperties($usercode = '') {
        $querystr = "UPDATE usrs u SET u.numproperties = (u.numproperties + 1) WHERE u.code = {$this->db->escape($usercode)}";
        $this->db->query($querystr);
        return true;
    }
    
    function update_desc($record = array(), $usercode = '') {
        if($this->db->update($this->userdescs_table, $record, array('code' => $usercode))) {
            return true;
        }
        return false;
    }
    
    function update_password($record = array(), $usercode = '') {
        if($this->db->update($this->users_table, $record, array('code' => $usercode))) {
            return true;
        }
        return false;
    }
    
    function update_pic($usercode = '', $field = '', $pic = '') {
        $this->db->set($field, $pic);
        $this->db->where('code', $usercode);
        if($this->db->update($this->users_table)) {
            return true;
        }
        return false;
    }
    
    function update_company_pic($usercode = '', $pic = '') {
        $this->db->update($this->users_table, 
                array('companypic' => $pic), 
                array('companycode' => $usercode));
    }
    
    function update_login_info($usercode, $recordip, $recordtime) {
        if($recordip) {
            $this->db->set('lastip', $this->input->ip_address());
        }
        if($recordtime) {
            $this->db->set('datelastlogin', date('Y-m-d H:i:s'));
        }
        $this->db->where('code', $usercode);
        $this->db->update($this->userdescs_table);
    }
    
    function get_search_result($filters = array(), $mode = 'list', $offset = 0, $limit = 10) {
        $usercode = $this->tank_auth->get_user_code();
        $usercode = $this->db->escape($usercode);
        
        if($mode == 'count') {
            $querystr = "SELECT COUNT(u.code) AS usercount ";
        } else {
            $querystr = "SELECT u.code AS usercode,
                                u.fname,
                                u.lname,
                                u.licensenum,
                                u.companycode,
                                u.companyname,
                                u.level,
                                ( CASE u.level 
                                    WHEN '" . LEVEL_NEWBIE . "' THEN 4
                                    WHEN '" . LEVEL_REGULAR . "' THEN 3
                                    WHEN '" . LEVEL_MASTER . "' THEN 2
                                    WHEN '" . LEVEL_PRIME . "' THEN 1
                                    WHEN '" . LEVEL_MODERATOR . "' THEN 5
                                    ELSE 6
                                    END ) AS levelord,
                                u.rating,
                                u.numrating,
                                u.numproperties,
                                u.verifiedagent,
                                u.profilepic,
                                u.featured,
                                DATE_FORMAT(u.datecreated, '%D of %b %Y') AS fdatecreated,
                                ud.country,
                                ud.city,
                                ur.rating AS useragentrating ";
        }
        $querystr .= " FROM usrs u
                       LEFT  JOIN usrdescs ud ON ud.code = u.code
                       LEFT JOIN usrrates ur ON ur.agentcode = u.code AND ur.usercode = $usercode 
                       WHERE u.recstatus = '" . USERSTATUS_ACTIVE . "'
                       AND u.usertype != '" . USERTYPE_COMPANY . "'";
        
        //Keyword
        $where = "";
        foreach($filters['searchkeywords'] as $k => $v) {
            if(!empty($v)) {
                $where .= " OR u.fname LIKE '%{$this->db->escape_like_str($v)}%' ";
                $where .= " OR u.lname LIKE '%{$this->db->escape_like_str($v)}%' ";
                $where .= " OR u.licensenum LIKE '%{$this->db->escape_like_str($v)}%' ";
                $where .= " OR u.companyname LIKE '%{$this->db->escape_like_str($v)}%' ";
            }
        }
        if($where != "") {
            $querystr .= " AND ( 1=0 " . $where . " ) ";
        }
        
        //Location
        $where = "";
        foreach($filters['searchlocation'] as $k => $v) {
            if(!empty($v)) {
                $where .= " OR ud.city LIKE '%{$this->db->escape_like_str($v)}%' ";
            }
        }
        if($where != "") {
            $querystr .= " AND ( 1=0 " . $where . " ) ";
        }
        
        //Country
        $where = "";
        if( isset($filters['searchcountry']) && !empty($filters['searchcountry']) ) {
            $where .= " OR ud.country = '{$this->db->escape_like_str($filters['searchcountry'])}' ";
        }
        if($where != "") {
            $querystr .= " AND ( 1=0 " . $where . " ) ";
        }
        
        //Verified Accounts
        if(!empty($filters['searchverified'])) {
            $querystr .= " AND u.verifiedagent = '" . YES . "' ";
        }
        
        //Ratings
        if( !empty($filters['searchrating']) && is_numeric($filters['searchrating']) ) {
            $querystr .= " AND u.rating >= " . $filters['searchrating'];
        }
        
        //Level
        $where = "";
        foreach($filters['searchlevel'] as $k => $v) {
            $where .= " OR u.level LIKE '%{$this->db->escape_like_str($v)}%' ";
        }
        if($where != "") {
            $querystr .= " AND ( 1=0 " . $where . " ) ";
        }
        
        //Verified Accounts
        if( isset($filters['searchcompany']) && !empty($filters['searchcompany']) ) {
            $querystr .= " AND u.companycode = '{$this->db->escape_like_str($filters['searchcompany'])}' ";
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
                    case 'name': //User Name
                        $sort = " u.lname " . $ord . ", u.fname " . $ord . ", u.featured DESC"; break;
                    case 'date-joined': //Date Joined
                        $sort = " u.datecreated " . $ord . ", u.featured DESC"; break;
                    case 'popularity': //Popularity (rates, likes, views)
                        $sort = " u.rating " . $ord . ", u.featured DESC"; break;
                    case 'level': //Level
                        $sort = " levelord " . $ord; break;
                    case 'verified': //Verified
                        $sort = " u.verifiedagent DESC "; break;
                    case 'featured': //Featured
                        $sort = " u.featured DESC "; break;
                }
            } else {
                $sort .= " u.featured DESC, u.lname ASC, u.fname ASC ";
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
    
    function check_email($email = '', $usercode = '') {
        $this->db->select('1', FALSE);
        $this->db->where('LOWER(email)=', strtolower($email)); 
        $this->db->where('recstatus', 'A');
        if($usercode != '') {
            $this->db->where('code !=', $usercode);
        }
        $query = $this->db->get($this->users_table);
        return $query->num_rows() == 0;
    }
}