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

        $data = [
            "ms_ticketstatus" => $rwTicketstatus
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

    public function get_IssuedApproved(){
        $user = $this->aauth->user();
        $ssql = "select * from trticket 
            where fst_status = 'APPROVED/OPEN' and fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_IssuedAccepted(){
        $user = $this->aauth->user();
        $ssql = "select * from trticket 
            where fst_status = 'ACCEPTED' and fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_IssuedNeedRevision(){
        $user = $this->aauth->user();
        $ssql = "select * from trticket 
            where fst_status = 'NEED_REVISION' and fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_IssuedCompleted(){
        $user = $this->aauth->user();
        $ssql = "select * from trticket 
            where fst_status = 'COMPLETED' and fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_ReceivedApproved(){
        $user = $this->aauth->user();
        $ssql = "select * from trticket 
            where fst_status = 'APPROVED/OPEN' and fin_issued_to_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_ReceivedAccepted(){
        $user = $this->aauth->user();
        $ssql = "select * from trticket 
            where fst_status = 'ACCEPTED' and fin_issued_to_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_ReceivedNeedRevision(){
        $user = $this->aauth->user();
        $ssql = "select * from trticket 
            where fst_status = 'NEED_REVISION' and fin_issued_to_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }

    public function get_ReceivedCompleted(){
        $user = $this->aauth->user();
        $ssql = "select * from trticket 
            where fst_status = 'COMPLETED' and fin_issued_to_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        return $qr->result_array();

    }
}