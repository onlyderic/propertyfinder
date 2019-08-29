<?php
class UserTransactions_Model extends CI_Model {
    
    private $table = 'usrtrx';
    private $users_table = 'usrs';
    
    function __construct() {
        parent::__construct();
    }
    
    function get_list($filter = array()) {
        $this->db->select('t.code,
                            t.trxtype,
                            t.usercode,
                            t.numdays,
                            t.amount,
                            DATE_FORMAT(t.trxdate,\'%d %b %Y\') AS trxdate,
                            DATE_FORMAT(t.startdate,\'%d %b %Y\') AS startdate,
                            DATE_FORMAT(t.enddate,\'%d %b %Y\') AS enddate,
                            t.paystatus,
                            t.recstatus,
                            t.ppcode,
                            t.ppstatus, ' . 
                            $this->users_table . '.fname, ' . 
                            $this->users_table . '.lname, ' . 
                            $this->users_table . '.email ', false);
        $this->db->from($this->table . ' t');
        $this->db->join($this->users_table, $this->users_table . '.code = t.usercode', 'left');
        $this->db->where($filter);
        $this->db->where('t.recstatus !=', PAYRECSTATUS_DELETED);
        $this->db->order_by('t.trxdate DESC, fname ASC, lname ASC'); 

        return $this->db->get()->result();
    }
    
    function get_trx_by_code($trxcode = '') {
        $this->db->select('t.code,
                            t.trxtype,
                            t.usercode,
                            t.numdays,
                            t.amount,
                            DATE_FORMAT(t.trxdate,\'%d %b %Y\') AS trxdate,
                            DATE_FORMAT(t.startdate,\'%d %b %Y\') AS startdate,
                            DATE_FORMAT(t.enddate,\'%d %b %Y\') AS enddate,
                            t.paystatus,
                            t.recstatus,
                            t.ppcode,
                            t.ppstatus, ' . 
                            $this->users_table . '.fname, ' . 
                            $this->users_table . '.lname, ' . 
                            $this->users_table . '.email, ' . 
                            $this->users_table . '.licensenum, ' . 
                            $this->users_table . '.companyname ', false);
        $this->db->from($this->table . ' t');
        $this->db->join($this->users_table, $this->users_table . '.code = t.usercode', 'left');
        $this->db->where('t.code', $trxcode);
        $this->db->where('t.recstatus !=', PAYRECSTATUS_DELETED);

        return $this->db->get()->row();
    }
    
    function create($trxtype = '', $usercode = '', $record = array()) {
        if( !empty($trxtype) && !empty($usercode) ) {
            if($this->db->insert($this->table, array('code' => $record['code'], 
                                                     'trxtype' => $trxtype, 
                                                     'usercode' => $usercode, 
                                                     'numdays' => $record['numdays'], 
                                                     'amount' => $record['amount'], 
                                                     'trxdate' => $record['trxdate'], 
                                                     'promo' => $record['promo'], 
                                                     'paystatus' => $record['paystatus'], 
                                                     'recstatus' => $record['recstatus']) )) {
                return true;
            }
        }
        return NULL;
    }
    
    function delete($trxtype = '', $usercode = '', $trxcode = '') {
        $where = array('code' => $trxcode, 'trxtype' => $trxtype, 'usercode' => $usercode);
        $this->db->delete($this->table, $where);
    }
    
    function confirm($trxcode = '', $ppcode = '', $ppstatus = '', $ppdate = '') {
        if($this->db->update($this->table, array('ppcode' => $ppcode, 'ppstatus' => $ppstatus, 'ppdate' => $ppdate), array('code' => $trxcode))) {
            if(strtoupper($ppstatus) == 'COMPLETED') {
                
                //Update user to feature or verified, depending on trxtype
                $this->db->select('trxtype, usercode');
                $this->db->from($this->table);
                $this->db->where('code', $trxcode);
                
                $trxtype = '';

                if($trxrec = $this->db->get()->row()) {
                    $trxtype = $trxrec->trxtype;
                    if($trxtype == 'F') {
                        $data = array('featured' => YES);
                        $this->db->update($this->users_table, $data, array('code' => $trxrec->usercode));
                    } 
                }
                
                if($trxtype == 'F') {
                    $querystr = "UPDATE " . $this->table . " SET 
                                    startdate = CURRENT_DATE(), 
                                    enddate = DATE_ADD(current_date(), INTERVAL numdays day),
                                    paystatus = '" . PAYSTATUS_PAID . "',
                                    recstatus = '" . PAYRECSTATUS_ACTIVE . "'
                                WHERE code = {$this->db->escape($trxcode)}";
                    $this->db->query($querystr);   
                } elseif($trxtype == 'V') {
                    $querystr = "UPDATE " . $this->table . " SET 
                                    paystatus = '" . PAYSTATUS_PAID . "',
                                    recstatus = '" . PAYRECSTATUS_VERIFYING . "'
                                WHERE code = {$this->db->escape($trxcode)}";
                    $this->db->query($querystr); 
                }  
                
            }
            return true;
        }
        return false;
    }
}