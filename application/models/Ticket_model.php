<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Ticket_model extends MY_MODEL {

    public $tableName = "ticket";
    public $pkey = "fin_ticket_id";

    public function __construct() {
        parent::__construct();
    }

    public function getDataById($fin_ticket_id){
        $ssql = "select a.*,b.fst_ticket_type_name,c.fin_service_level_name from ". $this->tableName ." a
        left join tickettype b on a.fin_ticket_type_id = b.fin_ticket_type_id
        left join servicelevel b on a.fin_service_level_id = c.fin_service_level_id
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
        $query = $this->db->get('ticket');
        return $query->result_array();
    }
}