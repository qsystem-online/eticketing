<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Ticketstatus_model extends MY_MODEL {

    public $tableName = "trticket";
    public $pkey = "fin_ticket_id";

    public function __construct() {
        parent::__construct();
    }

    public function getDataById($fin_ticket_id){
        $ssql = "select a.*,b.fst_ticket_type_name,c.fst_service_level_name,d.fst_username as useractive,e.fst_username from ". $this->tableName ." a
        left join mstickettype b on a.fin_ticket_type_id = b.fin_ticket_type_id
        left join msservicelevel c on a.fin_service_level_id = c.fin_service_level_id
        left join users d on a.fin_issued_by_user_id = d.fin_user_id
        left join users e on a.fin_issued_to_user_id = e.fin_user_id
        where fin_ticket_id = ?";
        $qr = $this->db->query($ssql,[$fin_ticket_id]);
        $rwTicketstatus = $qr->row();

        $ssql = "select a.*,b.fst_username from trticket_log a
        left join users b on a.fin_status_by_user_id = b.fin_user_id
        where a.fin_ticket_id = ? order by a.fin_rec_id desc";
        $qr = $this->db->query($ssql, [$fin_ticket_id]);
        $rwTicketlog = $qr->result();

        $data = [
            "ms_ticketstatus" => $rwTicketstatus,
            "ms_ticketlog" => $rwTicketlog
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

    public function get_Ticketstatus() {
        $query = $this->db->get('trticket');
        return $query->result_array();
    }

    public function get_NeeddApproval(){
        $user = $this->aauth->user();
        $deptActive = $user->fin_department_id;
        $levelActive = intval($user->fin_level) +1;
        $levelActive = strval($levelActive);

        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id,c.fin_level FROM trticket a 
            INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id
            INNER JOIN usersgroup c ON b.fin_group_id = c.fin_group_id
            WHERE a.fst_status = 'NEED_APPROVAL'AND b.fin_department_id =".$deptActive." AND c.fin_level =?";
        $qr = $this->db->query($ssql,[$levelActive]);
        //echo $this->db->last_query();
        return $qr->result_array();

    }

    public function get_IssuedApproved(){
        $user = $this->aauth->user();
        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id
            WHERE a.fst_status = 'APPROVED/OPEN' AND a.fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_IssuedAccepted(){
        $user = $this->aauth->user();
        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id 
            where a.fst_status = 'ACCEPTED' and a.fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_IssuedNeedRevision(){
        $user = $this->aauth->user();
        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id 
            where a.fst_status = 'NEED_REVISION' OR a.fst_status ='COMPLETION_REVISED' and a.fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_IssuedCompleted(){
        $user = $this->aauth->user();
        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id 
            where a.fst_status = 'COMPLETED' and a.fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_ReceivedApproved(){
        $user = $this->aauth->user();
        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_to_user_id = b.fin_user_id 
            where a.fst_status = 'APPROVED/OPEN' and a.fin_issued_to_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_ReceivedAccepted(){
        $user = $this->aauth->user();
        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_to_user_id = b.fin_user_id 
            where a.fst_status = 'ACCEPTED' and a.fin_issued_to_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_ReceivedNeedRevision(){
        $user = $this->aauth->user();
        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_to_user_id = b.fin_user_id 
            where a.fst_status = 'NEED_REVISION' OR a.fst_status ='COMPLETION_REVISED' and a.fin_issued_to_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_ReceivedCompleted(){
        $user = $this->aauth->user();
        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username,b.fin_department_id FROM trticket a 
            INNER JOIN users b ON a.fin_issued_to_user_id = b.fin_user_id 
            where a.fst_status = 'COMPLETED' and a.fin_issued_to_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }
}