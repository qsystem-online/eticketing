<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Ticket_model extends MY_MODEL {

    public $tableName = "trticket";
    public $pkey = "fin_ticket_id";

    public function __construct() {
        parent::__construct();
    }

    public function getDataById($fin_ticket_id){
        $activeUser = $this->aauth->is_login();
        $ssql = "select a.*,b.fst_ticket_type_name,b.fst_assignment_or_notice,c.fst_service_level_name,c.fin_service_level_days,
        d.fst_username as userActive,e.fst_username,f.fst_department_name,g.fst_username from ". $this->tableName ." a
        left join mstickettype b on a.fin_ticket_type_id = b.fin_ticket_type_id
        left join msservicelevel c on a.fin_service_level_id = c.fin_service_level_id
        left join users d on a.fin_issued_by_user_id = d.fin_user_id
        left join users e on a.fin_issued_to_user_id = e.fin_user_id
        left join departments f on a.fin_to_department_id = f.fin_department_id
        left join users g on a.fin_approved_by_user_id = g.fin_user_id
        where a.fin_ticket_id = ?";
        $qr = $this->db->query($ssql,[$fin_ticket_id]);
        $rwTicket = $qr->row();

        // Ticket Log
        $ssql = "select a.*,b.fst_username from trticket_log a 
        left join users b on a.fin_status_by_user_id = b.fin_user_id
        where a.fin_ticket_id = ? order by a.fin_rec_id desc";
        $qr = $this->db->query($ssql, [$fin_ticket_id]);
        $rsTicketlog = $qr->result();

        // Ticket Docs 27/02/2020
        $ssql = "SELECT a.* FROM trticket_docs a WHERE a.fin_ticket_id = ? ORDER BY a.fin_rec_id DESC";
        $qr = $this->db->query($ssql, [$fin_ticket_id]);
        $rsTicketDocs = $qr->result();

        if ($rwTicket) {
			if (file_exists(FCPATH . 'assets/app/tickets/image/' . $rwTicket->fin_ticket_id . '.jpg')) {
				$lampiranURL = site_url() . 'assets/app/tickets/image/' . $rwTicket->fin_ticket_id . '.jpg';
			} else {

				$lampiranURL = site_url() . 'assets/app/tickets/image/default.jpg';
			}
			$rwTicket->lampiranURL = $lampiranURL;
		}

        $data = [
            "ms_ticket" => $rwTicket,
            "ms_ticketlog" => $rsTicketlog,
            "ms_ticketdocs" => $rsTicketDocs
        ];

        return $data;
    }

    public function getDataHeaderById($finTicketId){
        $ssql = "select * from trticket where fin_ticket_id = ? and fst_active != 'D'";
        $qr = $this->db->query($ssql,[$finTicketId]);
        return $qr->row();
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
            'field' => 'fin_ticket_type_id',
            'label' => 'Ticket Type',
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

    /*public function show_transaction($finTicketId){
        redirect(site_url()."tr/ticket/view/$finTicketId", 'refresh');
    }*/

    public function GenerateTicketNo($trDate = null) {
        $trDate = ($trDate == null) ? date ("Y-m-d"): $trDate;
        $tahun = date("Ym", strtotime ($trDate));
        /*$activeBranch = $this->aauth->get_active_branch();
        $branchCode = "";
        if($activeBranch){
            $branchCode = $activeBranch->fst_branch_code;
        }*/
        $prefix = getDbConfig("ticket_prefix") . "/";
        $query = $this->db->query("SELECT MAX(fst_ticket_no) as max_id FROM trticket where fst_ticket_no like '".$prefix.$tahun."%'");
        $row = $query->row_array();

        $max_id = $row['max_id']; 
        
        $max_id1 =(int) substr($max_id,strlen($max_id)-5);
        
        $fst_tr_no = $max_id1 +1;
        
        $max_tr_no = $prefix.''.$tahun.'/'.sprintf("%05s",$fst_tr_no);
        
        return $max_tr_no;
    }

    // Devi 20/02/2020
    public function getLastLogStatus($finTicketId){
        $ssql = "SELECT fst_status from trticket_log where fin_ticket_id = ? order by fin_rec_id desc limit 1";
        $qr = $this->db->query($ssql,[$finTicketId]);
        $rw = $qr->row();
        if ($rw != null){
            return $rw->fst_status;
        }else{
            return null;
        }

    }

    public function void($fin_ticket_id){
        $ssql = "SELECT * FROM trticket WHERE fin_ticket_id = ?";
        $qr = $this->db->query($ssql,$fin_ticket_id);
        $rw = $qr->row();
        //update status void and active = D
        if($rw->fst_status =='CLOSED' OR $rw->fst_status =='REJECTED' OR $rw->fst_status =='APPROVAL_EXPIRED' OR $rw->fst_status =='ACCEPTANCE_EXPIRED' OR $rw->fst_status =='TICKET_EXPIRED'){
            return ["status"=>"FAILED","message"=>"CLOSED/REJECTED/EXPIRED TICKET CAN'T VOID"];
        }else{
            $ssql = "UPDATE trticket SET fst_status='VOID',fst_active='D' WHERE fin_ticket_id = ?";
            $this->db->query($ssql,$fin_ticket_id);
            return ["status"=>"SUCCESS","message"=>"Data void !"];
        }
    }

    public function is_permit_ticket($fin_ticket_id){

        $user = $this->aauth->user();
        $userActive = $user->fin_user_id;
        $deptActive = $user->fin_department_id;
        $levActive = intval($user->fin_level);
        $levActive = strval($levActive);
        $ssql = "SELECT a.*,b.fst_ticket_type_name,c.fst_username AS issuedBy,d.fst_username AS issuedTo,e.fst_username AS approvedBy FROM trticket a 
        LEFT JOIN mstickettype b ON a.fin_ticket_type_id = b.fin_ticket_type_id
        LEFT JOIN (SELECT a.fin_user_id,a.fst_username,a.fin_department_id,b.fin_level FROM users a INNER JOIN usersgroup b ON a.fin_group_id = b.fin_group_id) c ON a.fin_issued_by_user_id = c.fin_user_id
        LEFT JOIN (SELECT a.fin_user_id,a.fst_username,a.fin_department_id,b.fin_level FROM users a INNER JOIN usersgroup b ON a.fin_group_id = b.fin_group_id) d ON a.fin_issued_to_user_id = d.fin_user_id
        LEFT JOIN (SELECT a.fin_user_id,a.fst_username,a.fin_department_id,b.fin_level FROM users a INNER JOIN usersgroup b ON a.fin_group_id = b.fin_group_id) e ON a.fin_approved_by_user_id = e.fin_user_id
        WHERE ((fin_issued_by_user_id = $userActive OR fin_issued_to_user_id = $userActive OR fin_approved_by_user_id =$userActive)
        OR (c.fin_department_id = $deptActive AND c.fin_level > $levActive)
        OR (d.fin_department_id = $deptActive AND d.fin_level > $levActive)
        OR (e.fin_department_id = $deptActive AND e.fin_level > $levActive))
        AND a.fin_ticket_id = ? ";
        $qr = $this->db->query($ssql,$fin_ticket_id);
        //echo $this->db->last_query();
        //die();
        $rw = $qr->row();
        //cek boleh view ticket
        if($rw != null){
            return true;
        }else{
            return false;
        }
    }

}