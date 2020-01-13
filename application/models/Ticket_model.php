<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Ticket_model extends MY_MODEL {

    public $tableName = "trticket";
    public $pkey = "fin_ticket_id";

    public function __construct() {
        parent::__construct();
    }

    public function getDataById($fin_ticket_id){
        $ssql = "select a.*,b.fst_ticket_type_name,c.fin_service_level_name from ". $this->tableName ." a
        left join mstickettype b on a.fin_ticket_type_id = b.fin_ticket_type_id
        left join msservicelevel b on a.fin_service_level_id = c.fin_service_level_id
        where fin_ticket_id = ?";
        $qr = $this->db->query($ssql,[$fin_ticket_id]);
        $rwTicket = $qr->row();

        $data = [
            "ms_ticket" => $rwTicket
        ];

        return $data;
    }

    public function getRules($mode = "ADD", $id = 0){
        $rules = [];

        $rules[] = [
            'field' => 'fst_ticket_no',
            'label' => 'Ticket No.',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        $rules[] = [
            'field' => 'fst_memo',
            'label' => 'Memo',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
            ];

        return $rules;
    }

    public function getAllList() {
        $ssql = "select fin_ticket_id,fst_ticket_no from ". $this->tableName ." where fst_active = 'A'";
        $qr = $this->db->query($ssql, []);
        $rs = $qr->result();
        return $rs;
    }

    public function get_Ticket() {
        $query = $this->db->get('trticket');
        return $query->result_array();
    }

    /*public function GenerateTicketNo($trDate = null) {
        $trDate = ($trDate == null) ? date ("Y-m-d"): $trDate;
        $tahun = date("Y/m", strtotime ($trDate));
        $activeBranch = $this->aauth->get_active_branch();
        $branchCode = "";
        if($activeBranch){
            $branchCode = $activeBranch->fst_branch_code;
        }
        $prefix = getDbConfig("purchaseorder_prefix") . "/" . $branchCode ."/";
        $query = $this->db->query("SELECT MAX(fst_ticket_no) as max_id FROM ticket where fst_ticket_no like '".$prefix.$tahun."%'");
        $row = $query->row_array();

        $max_id = $row['max_id']; 
        
        $max_id1 =(int) substr($max_id,strlen($max_id)-5);
        
        $fst_tr_no = $max_id1 +1;
        
        $max_tr_no = $prefix.''.$tahun.'/'.sprintf("%05s",$fst_tr_no);
        
        return $max_tr_no;
    }*/
}