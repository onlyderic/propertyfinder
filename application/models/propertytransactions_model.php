<?php
class PropertyTransactions_Model extends CI_Model {
    
    private $table = 'proptrx';

    private $users_table = 'usrs';
    private $propinfos_table = 'propinfos';
    
    function __construct() {
        parent::__construct();
    }
    
    function get_list($filter = array()) {
        $this->db->select('t.code,
                            t.propcode,
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
                            $this->propinfos_table . '.name AS propname, ' . 
                            $this->propinfos_table . '.subcategory AS propsubcategory, ' . 
                            $this->propinfos_table . '.classification AS propclassification, ' . 
                            $this->propinfos_table . '.city AS propcity, ' . 
                            $this->propinfos_table . '.country AS propcountry ', false);
        $this->db->from($this->table . ' t');
        $this->db->join($this->users_table, $this->users_table . '.code = t.usercode', 'left');
        $this->db->join($this->propinfos_table, $this->propinfos_table . '.code = t.propcode', 'left');
        $this->db->where($filter);
        $this->db->where('t.recstatus !=', PAYRECSTATUS_DELETED);
        $this->db->order_by('t.trxdate DESC, propname ASC'); 

        return $this->db->get()->result();
    }
    
    function get_trx_by_code($trxcode = '') {
        $this->db->select('t.code,
                            t.propcode,
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
                            $this->propinfos_table . '.name AS propname, ' . 
                            $this->propinfos_table . '.subcategory AS propsubcategory, ' . 
                            $this->propinfos_table . '.classification AS propclassification, ' . 
                            $this->propinfos_table . '.city AS propcity, ' . 
                            $this->propinfos_table . '.country AS propcountry ', false);
        $this->db->from($this->table . ' t');
        $this->db->join($this->users_table, $this->users_table . '.code = t.usercode', 'left');
        $this->db->join($this->propinfos_table, $this->propinfos_table . '.code = t.propcode', 'left');
        $this->db->where('t.code', $trxcode);
        $this->db->where('t.recstatus !=', PAYRECSTATUS_DELETED);

        return $this->db->get()->row();
    }
    
    function create($propcode = '', $usercode = '', $record = array()) {
        if( !empty($propcode) && !empty($usercode) ) {
            if($this->db->insert($this->table, array('code' => $record['code'], 
                                                     'propcode' => $propcode, 
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
    
    function delete($propcode = '', $usercode = '', $trxcode = '') {
        $where = array('code' => $trxcode, 'propcode' => $propcode, 'usercode' => $usercode);
        $this->db->delete($this->table, $where);
    }
    
    function confirm($trxcode = '', $ppcode = '', $ppstatus = '', $ppdate = '') {
        if($this->db->update($this->table, array('ppcode' => $ppcode, 'ppstatus' => $ppstatus, 'ppdate' => $ppdate), array('code' => $trxcode))) {
            if(strtoupper($ppstatus) == 'COMPLETED') {
                $querystr = "UPDATE " . $this->table . " SET 
                                startdate = CURRENT_DATE(), 
                                enddate = DATE_ADD(current_date(), INTERVAL numdays day),
                                paystatus = '" . PAYSTATUS_PAID . "',
                                recstatus = '" . PAYRECSTATUS_ACTIVE . "'
                            WHERE code = {$this->db->escape($trxcode)}";
                $this->db->query($querystr);
                
                //Update property to feature
                $this->db->select('propcode');
                $this->db->from($this->table);
                $this->db->where('code', $trxcode);

                if($trxrec = $this->db->get()->row()) {
                    $this->db->update($this->propinfos_table, array('featured' => YES), array('code' => $trxrec->propcode));
                }  
                
            }
            return true;
        }
        return false;
    }
}