<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Ticketstatus_model extends MY_MODEL {

    public $tableName = "trticket";
    public $pkey = "fin_ticket_id";

    public function __construct() {
        parent::__construct();
    }

    public function getDataById($fin_ticket_id){
        $ssql = "select a.*,b.fst_ticket_type_name,c.fst_service_level_name,c.fin_service_level_days,d.fst_username as useractive,e.fst_username,f.fin_level from ". $this->tableName ." a
        left join mstickettype b on a.fin_ticket_type_id = b.fin_ticket_type_id
        left join msservicelevel c on a.fin_service_level_id = c.fin_service_level_id
        left join users d on a.fin_issued_by_user_id = d.fin_user_id
        left join users e on a.fin_issued_to_user_id = e.fin_user_id
        left join usersgroup f ON d.fin_group_id = f.fin_group_id
        where fin_ticket_id = ?";
        $qr = $this->db->query($ssql,[$fin_ticket_id]);
        $rwTicketstatus = $qr->row();

		if ($rwTicketstatus) {
			if (file_exists(FCPATH . 'assets/app/tickets/image/' . $rwTicketstatus->fin_ticket_id . '.jpg')) {
				$lampiranURL = site_url() . 'assets/app/tickets/image/' . $rwTicketstatus->fin_ticket_id . '.jpg';
			} else {

				$lampiranURL = site_url() . 'assets/app/tickets/image/default.jpg';
			}
			$rwTicketstatus->lampiranURL = $lampiranURL;
		}

        $ssql = "select a.*,b.fst_username from trticket_log a
        left join users b on a.fin_status_by_user_id = b.fin_user_id
        where a.fin_ticket_id = ? order by a.fin_rec_id desc";
        $qr = $this->db->query($ssql, [$fin_ticket_id]);
        $rsTicketlog = $qr->result();

        // Ticket Lampiran 27/02/2020 enny
        $ssql = "SELECT a.*,b.fin_ticket_id,b.fst_status_memo FROM trticket_docs a
        INNER JOIN trticket_log b ON a.fst_memo = b.fst_status_memo 
        WHERE b.fin_ticket_id = ? ORDER BY a.fin_rec_id DESC";
        $qr = $this->db->query($ssql, [$fin_ticket_id]);
        $rsTicketDocs = $qr->result();

        $data = [
            "ms_ticketstatus" => $rwTicketstatus,
            "ms_ticketlog" => $rsTicketlog,
            "ms_ticketdocs" => $rsTicketDocs
        ];

        return $data;
    }

    public function getRules($mode = "ADD", $id = 0){
        $rules = [];
        $rules[] = [
            'field' => 'fst_memo_update',
            'label' => 'Memo',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s Required!!!'
            )
            ];
        $rules[] = [
            'field' => 'fst_update_status',
            'label' => 'New Status',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s not selected'
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

    public function get_Ticketstatus() {
        $query = $this->db->get('trticket');
        return $query->result_array();
    }

    public function get_NeeddApproval(){
        $user = $this->aauth->user();
        //$deptActive = $user->fin_department_id;
        //$levelActive = intval($user->fin_level) +1;
        //$levelActive = strval($levelActive);

        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id as DeptBy,c.fin_level FROM trticket a 
            INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id
            INNER JOIN usersgroup c ON b.fin_group_id = c.fin_group_id
            WHERE a.fst_status = 'NEED_APPROVAL'AND a.fin_approved_by_user_id =?";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        //echo $this->db->last_query();
        return $qr->result_array();

    }

    public function get_IssuedRejected(){
        $user = $this->aauth->user();
        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_to_user_id = b.fin_user_id
            WHERE a.fst_status = 'REJECTED' AND a.fin_issued_by_user_id =? AND fbl_rejected_view =0 ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_IssuedApproved(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expiryaccepted = date_format($now,"Y-m-d H:i:s");

        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_to_user_id = b.fin_user_id
            WHERE a.fst_status = 'APPROVED/OPEN' AND a.fin_issued_by_user_id =? AND fdt_acceptance_expiry_datetime >'$expiryaccepted' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        //echo $this->db->last_query();
        return $qr->result_array();

    }

    public function get_IssuedAccepted(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expirydeadline = date_format($now,"Y-m-d H:i:s");

        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_to_user_id = b.fin_user_id 
            where a.fst_status = 'ACCEPTED' and a.fin_issued_by_user_id =? AND fdt_deadline_extended_datetime >'$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_IssuedNeedRevision(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expirydeadline = date_format($now,"Y-m-d H:i:s");

        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_to_user_id = b.fin_user_id 
            where (a.fst_status = 'NEED_REVISION' OR a.fst_status ='COMPLETION_REVISED') and a.fin_issued_by_user_id =? AND fdt_deadline_extended_datetime >'$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_IssuedCompleted(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expirydeadline = date_format($now,"Y-m-d H:i:s");

        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_to_user_id = b.fin_user_id 
            where a.fst_status = 'COMPLETED' and a.fin_issued_by_user_id =? AND fdt_deadline_extended_datetime >'$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_ReceivedApproved(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expiryaccepted = date_format($now,"Y-m-d H:i:s");

        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id 
            where a.fst_status = 'APPROVED/OPEN' and a.fin_issued_to_user_id =? AND fdt_acceptance_expiry_datetime >'$expiryaccepted' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_ReceivedAccepted(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expirydeadline = date_format($now,"Y-m-d H:i:s");

        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id 
            where a.fst_status = 'ACCEPTED' and a.fin_issued_to_user_id =? AND fdt_deadline_extended_datetime >'$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_ReceivedNeedRevision(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expirydeadline = date_format($now,"Y-m-d H:i:s");

        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id 
            where (a.fst_status = 'NEED_REVISION' OR a.fst_status ='COMPLETION_REVISED') and a.fin_issued_to_user_id =? AND fdt_deadline_extended_datetime >'$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_ReceivedCompleted(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expirydeadline = date_format($now,"Y-m-d H:i:s");

        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id 
            where a.fst_status = 'COMPLETED' and a.fin_issued_to_user_id =? AND fdt_deadline_extended_datetime >'$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_PrintTicketReport($ticketdate_awal,$ticketdate_akhir,$issuedBy,$issuedTo,$status){
        if ($issuedBy == 'null'){
            $issuedBy ="";
        }
        if ($issuedTo == 'null'){
            $issuedTo ="";
        }
        if ($status == 'null'){
            $status ="";
        }

        $ssql = "SELECT a.*,c.fst_username as issuedBy,d.fst_ticket_type_name,e.fst_service_level_name,e.fin_service_level_days,f.fst_username as issuedTo
                FROM trticket a 
                LEFT JOIN users c on a.fin_issued_by_user_id = c.fin_user_id
                LEFT JOIN mstickettype d on a.fin_ticket_type_id = d.fin_ticket_type_id
                LEFT JOIN msservicelevel e on a.fin_service_level_id = e.fin_service_level_id
                LEFT JOIN users f on a.fin_issued_to_user_id = f.fin_user_id
                WHERE a.fdt_ticket_datetime >='$ticketdate_awal' AND a.fdt_ticket_datetime >='$ticketdate_akhir' ";
                if ($issuedBy != 'ALL'){
                    $ssql .= " AND a.fin_issued_by_user_id ='$issuedBy'";
                }
                if ($issuedTo != 'ALL'){
                    $ssql .= " AND a.fin_issued_to_user_id ='$issuedTo'";
                }
                if ($status == 'ALL'){
                    $ssql .= "ORDER BY a.fst_status";
                }else{
                    $ssql .= " AND a.fst_status ='$status' ORDER BY a.fst_status";
                }

        $query = $this->db->query($ssql,[]);
        //echo $this->db->last_query();
        //die();
        $rs = $query->result();

        return $rs;
    }

    public function update_rejectedview($fin_ticket_id){
        $ssql = "select * from trticket where fin_ticket_id = ? and fst_status ='REJECTED'";
        $qr = $this->db->query($ssql,$fin_ticket_id);
        if ($qr->row() != null){
            //--Ticket Rejected viewed--
            $ssql = "update trticket set fbl_rejected_view = 1 where fin_ticket_id = ?";
            $this->db->query($ssql,[$fin_ticket_id]);
        }
    }

    public function update_ticketExpiry(){
        $logStartToday = date("Y-m-d H:i:s");
        $dateToday = date("Y-m-d");

        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("-1 days"));
        $expirydeadline = date_format($now,"Y-m-d H:i:s");

        $user_status = $this->aauth->get_user_id();
        $expiryUpdate = false;
        $newLog = false;

        $ssql = "select * from trticketexpiry_log where fdt_log_start_datetime like ? ";
        $qr = $this->db->query($ssql,["%".$dateToday."%"]);
        $rw = $qr->row();

        if ($qr->row() == null){
            $expiryUpdate = true;
            $newLog = true;
        }else{
            if ($qr->row() != null && $rw->fdt_log_end_datetime == null){
                if ($rw->fdt_log_start_datetime <= date("Y-m-d H:i:s", strtotime("-1 hours"))){
                    $expiryUpdate = true;
                }
            }
        }
        //--Record LOG hari ini sudah ada
        if ($expiryUpdate == true){
            if ($newLog == true){
                $data  = array(
                    'fdt_log_start_datetime' => date('Y-m-d H:i:s'),
                    'fin_count' => '1'
                );
                $this->db->insert('trticketexpiry_log', $data);
                $log_id = $this->db->insert_id();              
            }else{
                $log_id = $rw->rec_id;
                $data  = array(
                    'fdt_log_start_datetime' => date('Y-m-d H:i:s'),
                    'fin_count' => $rw->fin_count + 1
                );
                $this->db->where('rec_id', $log_id);
                $this->db->update('trticketexpiry_log', $data);
            }
            $ssql = "select * from trticket where fdt_acceptance_expiry_datetime < ? and fst_status ='APPROVED/OPEN' and fdt_deadline_extended_datetime is null";
            $qr = $this->db->query($ssql,[$expirydeadline]);
            //echo $this->db->last_query();
            //die();
            $rwTicketAcceptanceExpiry = $qr->result();
            if ($qr->row() != null){
                foreach($rwTicketAcceptanceExpiry as $dataA){
                    //---Update Expiry Acceptance Ticket---
                    $ssql = "update trticket set fst_status = 'ACCEPTANCE_EXPIRED' where fin_ticket_id = ?";
                    $this->db->query($ssql,[$dataA->fin_ticket_id]);
    
                    //--Ticket LOG--
                    $this->load->model("ticketlog_model");
                    $data = [
                        "fin_ticket_id" => $dataA->fin_ticket_id,
                        "fdt_status_datetime" => date("Y-m-d H:i:s"),
                        "fst_status" => 'ACCEPTANCE_EXPIRED',
                        "fst_status_memo" => 'ACCEPTANCE_EXPIRED BY SYSTEM',
                        "fin_status_by_user_id" => $user_status
                    ];
                    $insertId = $this->ticketlog_model->insert($data);
                }
            }
    
            $ssql = "select * from trticket where fdt_deadline_extended_datetime < ? and (fst_status ='ACCEPTED' or fst_status ='NEED_REVISION' or fst_status ='COMPLETED' or fst_status ='COMPLETION_REVISED' or (fst_status ='APPROVED/OPEN'  and fdt_deadline_extended_datetime is not null)) ";
            $qr = $this->db->query($ssql,[$expirydeadline]);
            $rwTicketDeadlineExpiry = $qr->result();
            if ($qr->row() != null){
                foreach($rwTicketDeadlineExpiry as $dataD){
                    //---Update Expiry Deadline Ticket---
                    $ssql = "update trticket set fst_status = 'TICKET_EXPIRED' where fin_ticket_id = ?";
                    $this->db->query($ssql,[$dataD->fin_ticket_id]);
    
                    //--Ticket LOG--
                    $this->load->model("ticketlog_model");
                    $data = [
                        "fin_ticket_id" => $dataD->fin_ticket_id,
                        "fdt_status_datetime" => date("Y-m-d H:i:s"),
                        "fst_status" => 'TICKET_EXPIRED',
                        "fst_status_memo" => 'TICKET_EXPIRED BY SYSTEM',
                        "fin_status_by_user_id" => $user_status
                    ];
                    $insertId = $this->ticketlog_model->insert($data);
                }
            }

            $data  = array(
                'fdt_log_end_datetime' => date('Y-m-d H:i:s')
            );
            $this->db->where('rec_id', $log_id);
            $this->db->update('trticketexpiry_log', $data);

        }
    }

}