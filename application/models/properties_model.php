<?php
class Properties_Model extends CI_Model {
    
    private $propinfos_table = 'propinfos';
    private $propdescs_table = 'propdescs';
    
    private $proprates_table = 'proprates';
    private $proplikes_table = 'proplikes';
    
    private $userrates_table = 'usrrates';
    
    private $comps_table = 'comps';
    private $users_table = 'usrs';
    private $userdescs_table = 'usrdescs';

    function __construct() {
        parent::__construct();
    }
    
    function create($record_infos = array(), $record_descs = array(), $usercode = '', $companyname = '') {
        $propcode = strtoupper(generate_code(CODE_PROPERTY));
        $record_infos['code'] = $propcode;
        if($this->db->insert($this->propinfos_table, $record_infos)) {
            $record_descs['code'] = $propcode;
            $this->db->insert($this->propdescs_table, $record_descs); 
            
            //If new company/developer, create it and update the record
            if( empty($record_infos['companycode']) && !empty($companyname) ) {
                $companycode = generate_code(CODE_COMPANY);
                $this->db->insert($this->comps_table, array('code' => $companycode, 'companyname' => $companyname));
                $this->db->update($this->propinfos_table, array('companycode' => $companycode), array('code' => $propcode));
            }
            
            //Update the owner
            if($this->tank_auth->get_usertype() == USERTYPE_COMPANY) {
                $this->db->select('companyname, profilepic');
                $this->db->from($this->comps_table);
                $this->db->where('code', $usercode);

                if($userrec = $this->db->get()->row()) {
                    $this->db->update($this->propinfos_table, 
                            array('ownername' => $userrec->companyname,
                                  'ownerpic' => $userrec->profilepic), 
                            array('code' => $propcode));
                }  
            } else {
                $this->db->select('fname, lname, profilepic');
                $this->db->from($this->users_table);
                $this->db->where('code', $usercode);

                if($userrec = $this->db->get()->row()) {
                    $this->db->update($this->propinfos_table, 
                            array('ownername' => $userrec->fname . ' ' . $userrec->lname,
                                  'ownerpic' => $userrec->profilepic), 
                            array('code' => $propcode));
                }  
            }          
            
            return array('code' => $propcode);
        }
        return NULL;
    }
    
    function update($record_infos = array(), $record_descs = array(), $propcode = '', $companyname = '') {
        if($this->db->update($this->propinfos_table, $record_infos, array('code' => $propcode))) {
            
            $this->db->update($this->propdescs_table, $record_descs, array('code' => $propcode)); 
            
            //If new company/developer, create it and update the record
            if( empty($record_infos['companycode']) && !empty($companyname) ) {
                $companycode = generate_code(CODE_COMPANY);
                $this->db->insert($this->comps_table, array('code' => $companycode, 'companyname' => $companyname));
                $this->db->update($this->propinfos_table, array('companycode' => $companycode), array('code' => $propcode));
            }
            
            return array('code' => $propcode);
        }
        return NULL;
    }
    
    function update_field($propcode = '', $field = '', $value = '') {
        $this->db->set($field, $value);
        $this->db->where('code', $propcode);
        if($this->db->update($this->propinfos_table)) {
            return true;
        }
        return false;
    }
    
    function update_user_pic($usercode = '', $pic = '') {
        $this->db->update($this->propinfos_table, 
                array('ownerpic' => $pic), 
                array('ownercode' => $usercode));
    }
    
    function get_property_only($propcode = '') {
        return $this->db->get_where($this->propinfos_table, array('code' => $propcode))->row();
    }
    
    function get_propertydesc_only($propcode = '') {
        return $this->db->get_where($this->propdescs_table, array('code' => $propcode))->row();
    }
    
    function get_property_by_code($propcode = '') {  
        $usercode = $this->tank_auth->get_user_code();
        $usercode = $this->db->escape($usercode);
        
        $this->db->select($this->propinfos_table . '.*, 
                            DATE_FORMAT(' . $this->propinfos_table . '.datepublished , \'%d %M %Y\') AS fdatepublished, ' . 
                            $this->propdescs_table . '.*, ' . 
                            $this->comps_table . '.companyname, ' . 
                            $this->comps_table . '.profilepic AS companypic, ' . 
                
                            $this->users_table . '.mobilenum AS ownermobilenum, ' .
                            $this->users_table . '.homenum AS ownerhomenum, ' .
                            $this->users_table . '.officenum AS ownerofficenum, ' .
                            $this->users_table . '.skype AS ownerskype, ' .
                            $this->userdescs_table . '.accfb AS owneraccfb, ' .
                            $this->userdescs_table . '.acctwitter AS owneracctwitter, ' .
                            $this->userdescs_table . '.accgoogle AS owneraccgoogle, ' .
                            $this->userdescs_table . '.acclinkedin AS owneracclinkedin, ' .
                
                            $this->users_table . '.licensenum AS ownerlicense, ' . 
                            $this->users_table . '.level AS ownerlevel, ' . 
                            $this->users_table . '.verifiedagent AS ownerverifiedagent, ' . 
                            $this->users_table . '.rating AS ownerrating, ' . 
                            $this->users_table . '.numrating AS ownernumrating, ' .
                            $this->users_table . '.usertype AS ownertype, ' .
                            $this->proprates_table . '.rating AS userrating, ' . 
                            $this->proplikes_table . '.thumbs AS userthumbs, ' . 
                            $this->userrates_table . '.rating AS useragentrating ', false);
        $this->db->from($this->propinfos_table);
        $this->db->join($this->propdescs_table, $this->propinfos_table . '.code = ' . $this->propdescs_table . '.code', 'left');
        $this->db->join($this->comps_table, $this->propinfos_table . '.companycode = ' . $this->comps_table . '.code', 'left');
        $this->db->join($this->users_table, $this->propinfos_table . '.ownercode = ' . $this->users_table . '.code', 'left');
        $this->db->join($this->userdescs_table, $this->propinfos_table . '.ownercode = ' . $this->userdescs_table . '.code', 'left');
        
        $this->db->join($this->proprates_table, $this->proprates_table . '.propcode = ' . $this->propinfos_table . '.code AND ' . $this->proprates_table . '.usercode = ' . $usercode, 'left');
        $this->db->join($this->proplikes_table, $this->proplikes_table . '.propcode = ' . $this->propinfos_table . '.code AND ' . $this->proplikes_table . '.usercode = ' . $usercode, 'left');
        $this->db->join($this->userrates_table, $this->userrates_table . '.agentcode = ' . $this->propinfos_table . '.ownercode AND ' . $this->userrates_table . '.usercode = ' . $usercode, 'left');
        
        $this->db->where($this->propinfos_table . '.code', $propcode);
        $this->db->where($this->propinfos_table . '.recstatus IN (\'' . PROPSTATUS_ACTIVE . '\',\'' . PROPSTATUS_DRAFT . '\')');

        return $this->db->get()->row();
    }
    
    function get_search_result($filters = array(), $mode = 'list', $offset = 0, $limit = 10) {
        $usercode = $this->tank_auth->get_user_code();
        $usercode = $this->db->escape($usercode);
        
        if($mode == 'count') {
            $querystr = "SELECT COUNT(i.code) AS propcount ";
        } else {
            $querystr = "SELECT i.code AS propcode,
                                    i.name AS propname,
                                    i.subcategory,
                                    i.classification,
                                    i.posting,
                                    i.pricemin,
                                    i.pricemax,
                                    i.priceunit,
                                    i.roomsmin,
                                    i.roomsmax,
                                    i.areamin,
                                    i.areamax,
                                    i.areaunit,
                                    i.city,
                                    i.country,
                                    i.profilepic,
                                    i.profilepicwidth,
                                    i.profilepicheight,
                                    i.ownercode,
                                    i.ownerpic,
                                    i.ownername,
                                    i.datepublished,
                                    i.numlikes,
                                    i.numdislikes,
                                    i.numviews,
                                    i.rating,
                                    i.numrating,
                                    i.featured,
                                    i.soldout,
                                    i.closed,
                                    i.recstatus,
                                    (i.numlikes + i.numviews) AS numpopular,
                                    pr.rating AS userrating,
                                    pl.thumbs AS userthumbs,
                                    ur.rating AS useragentrating,
                                    u.usertype AS ownerusertype,
                                    s2.propcode AS shortlisted,
                                    c2.propcode AS compared "; 
        }
        $querystr .= " FROM propinfos i ";
        $querystr .= " LEFT JOIN proprates pr ON pr.propcode = i.code AND pr.usercode = $usercode ";
        $querystr .= " LEFT JOIN proplikes pl ON pl.propcode = i.code AND pl.usercode = $usercode ";
        $querystr .= " LEFT JOIN usrrates ur ON ur.agentcode = i.ownercode AND ur.usercode = $usercode ";
        $querystr .= " LEFT JOIN propshorts s2 ON s2.propcode = i.code AND s2.usercode = $usercode ";
        $querystr .= " LEFT JOIN propcompares c2 ON c2.propcode = i.code AND c2.usercode = $usercode ";
        $querystr .= " LEFT JOIN usrs u ON u.code = i.ownercode ";
        
        if( isset($filters['searchshortlist']) && isset($filters['searchshortlistusercode']) && $filters['searchshortlist'] ) {
            $querystr .= " INNER JOIN propshorts s ON s.propcode = i.code AND s.usercode = " . ( empty($filters['searchshortlistusercode']) ? '0' : $this->db->escape($filters['searchshortlistusercode']) );
        }
        
        if( isset($filters['searchrecentviews']) && isset($filters['searchrecentviewsusercode']) && $filters['searchrecentviews'] ) {
            if(empty($filters['searchrecentviewsusercode'])) {
                $ip = $this->input->ip_address();
                $querystr .= " INNER JOIN propviews v ON v.propcode = i.code AND v.usercode = 0 AND v.userip = " . $this->db->escape($ip);
            } else {
                $querystr .= " INNER JOIN propviews v ON v.propcode = i.code AND v.usercode = " . $this->db->escape($filters['searchrecentviewsusercode']);
            }
        }
        
        $querystr .= " WHERE 1=1 ";
        
        //Record Status
        if(isset($filters['searchpropstate'])) {
            
            $where = "";
            foreach($filters['searchpropstate'] as $k => $v) {
                if(!empty($v)) {
                    $where .= " OR i.recstatus = {$this->db->escape($v)} ";
                }
            }
            if($where != "") {
                $querystr .= " AND ( 1=0 " . $where . " ) ";
            }
            
        } else {
            
            $querystr .= " AND i.recstatus = '" . PROPSTATUS_ACTIVE . "' ";
            
        }
        
        //Availability
        if( isset($filters['searchpropavail']) && count($filters['searchpropavail']) > 0 ) {
                
            $where = "";
            $filters['searchpropavail'] = array_flip($filters['searchpropavail']);
            if( isset($filters['searchpropavail']['S']) ) {
                $where .= " AND i.soldout = 'Y' ";
            }
            if( isset($filters['searchpropavail']['C']) ) {
                $where .= " AND i.closed = 'Y' ";
            }
            if( isset($filters['searchpropavail']['A']) ) {
                if( !isset($filters['searchpropavail']['S']) && !isset($filters['searchpropavail']['C']) ) {
                    $where .= " AND i.soldout = 'N' AND i.closed = 'N' ";
                } else if( isset($filters['searchpropavail']['S']) && !isset($filters['searchpropavail']['C']) ) {
                    $where .= " OR i.closed = 'N' ";
                } else if( !isset($filters['searchpropavail']['S']) && isset($filters['searchpropavail']['C']) ) {
                    $where .= " OR i.soldout = 'N' ";
                }
            }
            if($where != "") {
                $querystr .= " AND ( 1=1 " . $where . " ) ";
            }
            
        } else {
            
            $querystr .= " AND i.closed != 'Y' ";
            
        }
        
        //Owner
        if( isset($filters['searchownercode']) && !empty($filters['searchownercode']) ) {
            
            $querystr .= " AND i.ownercode = " . ( empty($filters['searchownercode']) ? '0' : $this->db->escape($filters['searchownercode']) ) . " ";
            
        }
        
        //Company
        if( isset($filters['searchcompanycode']) && !empty($filters['searchcompanycode']) ) {
            
            $querystr .= " AND i.companycode = " . ( empty($filters['searchcompanycode']) ? '0' : $this->db->escape($filters['searchcompanycode']) ) . " ";
            
        }
        
        //Keyword
        if(isset($filters['searchkeywords'])) {
            
            $where = "";
            foreach($filters['searchkeywords'] as $k => $v) {
                if(!empty($v)) {
                    $where .= " OR i.name LIKE '%{$this->db->escape_like_str($v)}%' ";
                }
            }
            if($where != "") {
                $querystr .= " AND ( 1=0 " . $where . " ) ";
            }
            
        }
        
        //Location
        if(isset($filters['searchlocation'])) {
            
            $where = "";
            foreach($filters['searchlocation'] as $k => $v) {
                if(!empty($v)) {
                    $where .= " OR i.city LIKE '%{$this->db->escape_like_str($v)}%' ";
                }
            }
            if($where != "") {
                $querystr .= " AND ( 1=0 " . $where . " ) ";
            }
            
        }
        
        //Country
        $where = "";
        if( isset($filters['searchcountry']) && !empty($filters['searchcountry']) ) {
            $where .= " OR i.country = '{$this->db->escape_like_str($filters['searchcountry'])}' ";
        }
        if($where != "") {
            $querystr .= " AND ( 1=0 " . $where . " ) ";
        }
        
        //Posting
        if(isset($filters['searchproppost'])) {
            
            $where = "";
            foreach($filters['searchproppost'] as $k => $v) {
                $where .= " OR i.posting LIKE '%{$this->db->escape_like_str($v)}%' ";
            }
            if($where != "") {
                $querystr .= " AND ( 1=0 " . $where . " ) ";
            }
            
        }
        
        //Category
        $querystr_searchproptype = "";
        
        if(isset($filters['searchproptype'])) {
            
            $where = "";
            foreach($filters['searchproptype'] as $k => $v) {
                $where .= " OR i.category = {$this->db->escape($v)} ";
            }
            if($where != "") {
                $querystr_searchproptype .= " ( 1=0 " . $where . " ) ";
            }
            
        }
        
        //Classification
        $querystr_searchpropclass = "";
        
        if(isset($filters['searchpropclass'])) {
            
            $where = "";
            foreach($filters['searchpropclass'] as $k => $v) {
                //"Hotels" and "Resorts" are special; use classification
                if($v == PROPCLASS_H_HOTEL || $v == PROPCLASS_H_HOTEL) {
                    $where .= " OR i.classification = {$this->db->escape($v)} OR i.classification = '" . PROPCLASS_H_HOTELANDRESORT . "' ";
                } else {
                    $where .= " OR i.subcategory = {$this->db->escape($v)} ";
                }
            }
            if($where != "") {
                $querystr_searchpropclass .= " ( 1=0 " . $where . " ) ";
            }
            
        }
        
        //If both searchproptype and searchpropclass are selected, combine both with 'OR' operator
        if( $querystr_searchproptype !== "" && $querystr_searchpropclass !== "" ) {
            $querystr2 = " ( $querystr_searchproptype OR $querystr_searchpropclass ) ";
        } else {
            $querystr2 = $querystr_searchproptype . $querystr_searchpropclass;
        }
        
        if( $querystr2 != "" ) {
            $querystr .= " AND " . $querystr2;
        }
        
        //Prices
        if( isset($filters['searchpricemin']) && isset($filters['searchpricemax']) ) {
         
            if( !empty($filters['searchpricemin']) && !empty($filters['searchpricemax']) ) {
                $querystr .= " AND (
                                    (
                                      i.pricemin <= {$filters['searchpricemax']} 
                                     OR 
                                      ( i.pricemax <> '' AND i.pricemax <= {$filters['searchpricemax']} )
                                    )

                                    OR

                                    (
                                     {$filters['searchpricemin']} <= i.pricemin
                                    OR
                                     ( i.pricemax <> '' AND {$filters['searchpricemin']} <= i.pricemax )
                                    )
                                   )
                               AND i.priceunit LIKE '%{$this->db->escape_like_str($filters['searchpriceunit'])}%' ";
            } elseif( !empty($filters['searchpricemin']) ) {
                $querystr .= " AND (
                                     {$filters['searchpricemin']} <= i.pricemin
                                    OR
                                     ( i.pricemax <> '' AND {$filters['searchpricemin']} <= i.pricemax )
                                    )
                               AND i.priceunit LIKE '%{$this->db->escape_like_str($filters['searchpriceunit'])}%' ";
            } elseif( !empty($filters['searchpricemax']) ) {
                $querystr .= " AND (
                                      i.pricemin <= {$filters['searchpricemax']} 
                                     OR 
                                      ( i.pricemax <> '' AND i.pricemax <= {$filters['searchpricemax']} )
                                    )
                               AND i.priceunit LIKE '%{$this->db->escape_like_str($filters['searchpriceunit'])}%' ";
            }
        
        }
        
        //Areas
        if( isset($filters['searchareamin']) && isset($filters['searchareamax']) ) {
            
            if( !empty($filters['searchareamin']) && !empty($filters['searchareamax']) ) {
                $querystr .= " AND (
                                    (
                                      ( i.areamin <> '' AND i.areamin <= {$filters['searchareamax']} )
                                     OR 
                                      ( i.areamax <> '' AND i.areamax <= {$filters['searchareamax']} )
                                    )

                                    OR

                                    (
                                     ( i.areamin <> '' AND {$filters['searchareamin']} <= i.areamin )
                                    OR
                                     ( i.areamax <> '' AND {$filters['searchareamin']} <= i.areamax )
                                    )
                                   )
                               AND i.areaunit LIKE '%{$this->db->escape_like_str($filters['searchareaunit'])}%' ";
            } elseif( !empty($filters['searchareamin']) ) {
                $querystr .= " AND (
                                     ( i.areamin <> '' AND {$filters['searchareamin']} <= i.areamin )
                                    OR
                                     ( i.areamax <> '' AND {$filters['searchareamin']} <= i.areamax )
                                    )
                               AND i.areaunit LIKE '%{$this->db->escape_like_str($filters['searchareaunit'])}%' ";
            } elseif( !empty($filters['searchareamax']) ) {
                $querystr .= " AND (
                                      ( i.areamin <> '' AND i.areamin <= {$filters['searchareamax']} )
                                     OR 
                                      ( i.areamax <> '' AND i.areamax <= {$filters['searchareamax']} )
                                    )
                               AND i.areaunit LIKE '%{$this->db->escape_like_str($filters['searchareaunit'])}%' ";
            }
            
        }
        
        //Rooms
        if( isset($filters['searchroommin']) && isset($filters['searchroommax']) ) {
            
            if( !empty($filters['searchroommin']) && !empty($filters['searchroommax']) ) {
                $querystr .= " AND (
                                    (
                                      ( i.roomsmin <> 'S' AND i.roomsmin <> '' AND i.roomsmin <= {$filters['searchroommax']} )
                                     OR 
                                      ( i.roomsmax <> '' AND i.roomsmax <= {$filters['searchroommax']} )
                                    )

                                    OR

                                    (
                                     ( i.roomsmin <> 'S' AND i.roomsmin <> '' AND {$filters['searchroommin']} <= i.roomsmin )
                                    OR
                                     ( i.roomsmax <> '' AND {$filters['searchroommin']} <= i.roomsmax )
                                    )
                                   )";
            } elseif( !empty($filters['searchroommin']) ) {
                $querystr .= " AND (
                                     ( i.roomsmin <> 'S' AND i.roomsmin <> '' AND {$filters['searchroommin']} <= i.roomsmin )
                                    OR
                                     ( i.roomsmax <> '' AND {$filters['searchroommin']} <= i.roomsmax )
                                    ) ";
            } elseif( !empty($filters['searchroommax']) ) {
                $querystr .= " AND (
                                      ( i.roomsmin <> 'S' AND i.roomsmin <> '' AND i.roomsmin <= {$filters['searchroommax']} )
                                     OR 
                                      ( i.roomsmax <> '' AND i.roomsmax <= {$filters['searchroommax']} )
                                    )";
            }
            
        }
        
        //Ratings
        if( !empty($filters['searchrating']) && is_numeric($filters['searchrating']) ) {
            $querystr .= " AND i.rating >= " . $filters['searchrating'];
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
                    case 'name': //Property Name
                        $sort = " i.name " . $ord . ", i.featured DESC"; break;
                    case 'price': //Price
                        $sort = " i.pricemin " . $ord . ", i.pricemax " . $ord . ", i.featured DESC"; break;
                    case 'upload-date': //Upload Date
                        $sort = " i.datepublished " . $ord . ", i.featured DESC"; break;
                    case 'popularity': //Popularity (rates, likes, views)
                        $sort = " i.rating " . $ord . ", numpopular " . $ord . ", i.featured DESC"; break;
                    case 'featured': //Featured
                        $sort = " i.featured DESC "; break;
                }
            } else {
                if( isset($filters['searchrecentviews']) && isset($filters['searchrecentviewsusercode']) && $filters['searchrecentviews'] ) {
                    $sort .= " viewdate DESC ";
                } else {
                    $sort .= " i.featured DESC, i.datepublished DESC ";
                }
            }
            if($sort != "") {
                $querystr .= " ORDER BY " . $sort;
            }
            if( is_numeric($offset) && is_numeric($limit) ) {
                $querystr .= " LIMIT " . (int)$offset . ", " . (int)$limit;
            }
        
        }
                
        $query = $this->db->query($querystr);
        
        if($mode == 'count') {
            return $query->row();
        } else {
            return $query->result();
        }
    }
    
    function get_list_popular($offset = 0, $limit = 3) {
        $querystr = $this->_get_standard_select();
        $query = $this->db->query($querystr . " ORDER BY i.featured DESC, numpopular DESC, i.rating DESC
                        LIMIT $offset, $limit");

        return $query->result();
    }
    
    function get_list_newest($offset = 0, $limit = 3) {
        $querystr = $this->_get_standard_select();
        $query = $this->db->query($querystr . " ORDER BY i.featured DESC, i.datepublished DESC
                                    LIMIT $offset, $limit");

        return $query->result();
    }
    
    function get_list_agent($usercode = 0, $offset = 0, $limit = 3, $sort = '', $ord = '') {
        $querystr = $this->_get_standard_select();
        $querystr .= " AND i.ownercode = '$usercode' ";
        $sortstr = "";
        if( $sort != '' && $ord != '') {
            $ordstr = '';
            if( $ord == 'asc' || $ord == 'desc') {
                $ordstr = $ord;
            }
            switch($sort) {
                case 'name': //Property Name
                    $sortstr = " i.name " . $ordstr . ", i.featured DESC, i.datepublished DESC "; break;
                case 'price': //Price
                    $sortstr = " i.pricemin " . $ordstr . ", i.pricemax " . $ordstr . ", i.featured DESC, i.datepublished DESC "; break;
                case 'upload-date': //Upload Date
                    $sortstr = " i.datepublished " . $ordstr . ", i.featured DESC"; break;
                case 'popularity': //Popularity (rates, likes, views)
                    $sortstr = " i.rating " . $ordstr . ", numpopular " . $ordstr . ", i.featured DESC, i.datepublished DESC "; break;
                case 'featured': //Featured
                    $sortstr = " i.featured DESC "; break;
            }
        } else {
            $sortstr .= " i.featured DESC, i.datepublished DESC ";
        }
        if($sortstr != "") {
            $querystr .= " ORDER BY " . $sortstr;
        }
        $querystr .= " LIMIT $offset, $limit";
        $query = $this->db->query($querystr);

        return $query->result();
    }
    
    function get_list_company($companycode = 0, $offset = 0, $limit = 3, $sort = '', $ord = '') {
        $querystr = $this->_get_standard_select();
        $querystr .= " AND i.companycode = '$companycode' ";
        $sortstr = "";
        if( $sort != '' && $ord != '') {
            $ordstr = '';
            if( $ord == 'asc' || $ord == 'desc') {
                $ordstr = $ord;
            }
            switch($sort) {
                case 'name': //Property Name
                    $sortstr = " i.name " . $ordstr . ", i.featured DESC, i.datepublished DESC "; break;
                case 'price': //Price
                    $sortstr = " i.pricemin " . $ordstr . ", i.pricemax " . $ordstr . ", i.featured DESC, i.datepublished DESC "; break;
                case 'upload-date': //Upload Date
                    $sortstr = " i.datepublished " . $ordstr . ", i.featured DESC"; break;
                case 'popularity': //Popularity (rates, likes, views)
                    $sortstr = " i.rating " . $ordstr . ", numpopular " . $ordstr . ", i.featured DESC, i.datepublished DESC "; break;
                case 'featured': //Featured
                    $sortstr = " i.featured DESC "; break;
            }
        } else {
            $sortstr .= " i.featured DESC, i.datepublished DESC ";
        }
        if($sortstr != "") {
            $querystr .= " ORDER BY " . $sortstr;
        }
        $querystr .= " LIMIT $offset, $limit";
        $query = $this->db->query($querystr);

        return $query->result();
    }
    
    function get_list_comparison($usercode = 0) {
        $usercode = $this->db->escape($usercode);
        $querystr = "SELECT i.code AS propcode,
                                i.name AS propname,
                                i.category,
                                i.subcategory,
                                i.classification,
                                i.posting,
                                i.pricemin,
                                i.pricemax,
                                i.priceunit,
                                i.roomsmin,
                                i.roomsmax,
                                i.toiletmin,
                                i.toiletmax,
                                i.areamin,
                                i.areamax,
                                i.areaunit,
                                i.garagemin,
                                i.garagemax,
                                i.city,
                                i.country,
                                i.profilepic,
                                i.profilepicwidth,
                                i.profilepicheight,
                                i.ownercode,
                                i.ownerpic,
                                i.ownername,
                                DATE_FORMAT(i.datepublished,'%d %M %Y') AS fdatepublished,
                                i.numlikes,
                                i.numdislikes,
                                i.rating,
                                i.numrating,
                                i.numviews,
                                i.featured,
                                i.companycode,
                                c.companyname,
                                d.pricereserve,
                                d.pricedown,
                                d.pricediscount,
                                d.floorsnum,
                                d.unitsnum,
                                d.tenure,
                                d.tenureyr,
                                d.construction,
                                d.completionmo,
                                d.completionyr,
                                d.pricenegotiable,
                                d.foreclosure,
                                d.resale,
                                d.occupancy,
                                d.financing,
                                d.paymentscheme,
                                d.furnished,
                                d.furnishings,
                                d.features,
                                u.usertype AS ownerusertype
                        FROM propinfos i
                        LEFT JOIN propdescs d ON d.code = i.code
                        LEFT JOIN comps c ON c.code = i.companycode
                        LEFT JOIN usrs u ON u.code = i.ownercode
                        INNER JOIN propcompares pc ON pc.propcode = i.code
                        WHERE i.recstatus = '" . PROPSTATUS_ACTIVE . "' ";
        if(!empty($usercode)) {
            $querystr .= " AND pc.usercode = $usercode ";
        } else {
            $ip = $this->input->ip_address();
            $querystr .= " AND pc.usercode = 0 AND pc.userip = '$ip' ";
        }
        $querystr .= " ORDER BY i.featured DESC, i.datepublished DESC";
        $query = $this->db->query($querystr);

        return $query->result();
    }
    
    protected function _get_standard_select() {
        $usercode = $this->tank_auth->get_user_code();
        $usercode = $this->db->escape($usercode);
        
        return "SELECT i.code AS propcode,
                        i.name AS propname,
                        i.subcategory,
                        i.classification,
                        i.posting,
                        i.pricemin,
                        i.pricemax,
                        i.priceunit,
                        i.roomsmin,
                        i.roomsmax,
                        i.areamin,
                        i.areamax,
                        i.areaunit,
                        i.city,
                        i.country,
                        i.profilepic,
                        i.profilepicwidth,
                        i.profilepicheight,
                        i.ownercode,
                        i.ownerpic,
                        i.ownername,
                        i.datepublished,
                        i.numlikes,
                        i.numdislikes,
                        i.rating,
                        i.numrating,
                        i.numviews,
                        i.featured,
                        (i.numlikes + i.numviews) AS numpopular,
                        i.soldout,
                        i.closed,
                        pr.rating AS userrating,
                        pl.thumbs AS userthumbs,
                        ur.rating AS useragentrating,
                        u.usertype AS ownerusertype,
                        s2.propcode AS shortlisted,
                        c2.propcode AS compared
                FROM propinfos i
                LEFT JOIN proprates pr ON pr.propcode = i.code AND pr.usercode = $usercode
                LEFT JOIN proplikes pl ON pl.propcode = i.code AND pl.usercode = $usercode
                LEFT JOIN usrrates ur ON ur.agentcode = i.ownercode AND ur.usercode = $usercode
                LEFT JOIN propshorts s2 ON s2.propcode = i.code AND s2.usercode = $usercode
                LEFT JOIN propcompares c2 ON c2.propcode = i.code AND c2.usercode = $usercode
                LEFT JOIN usrs u ON u.code = i.ownercode
                WHERE i.recstatus = '" . PROPSTATUS_ACTIVE . "'
                AND i.closed != 'Y'";
    }
    
    function get_property_for_checking($propcode = '') {
        return $this->db->select('code, ownercode')->get_where($this->propinfos_table, array('code' => $propcode))->row();
    }
    
    function get_map_properties($latitude = 0, $longitude = 0, $distance = 10, $limit = LIMIT_MAP) {
        $query = $this->db->query("
                SELECT code, name, coordlat AS clat, coordlong AS clng, category AS proptype, ((ACOS(SIN($latitude * PI() / 180) * SIN(coordlat * PI() / 180) + 
                    COS($latitude * PI() / 180) * COS(coordlat * PI() / 180) * COS(($longitude - coordlong) * 
                    PI() / 180)) * 180 / PI()) * 60 * 1.1515) AS distance 
                FROM propinfos 
                WHERE closed != 'Y'
                HAVING distance <= '$distance' ORDER BY distance ASC LIMIT 0, " . $limit);

        return $query->result();
    }
}