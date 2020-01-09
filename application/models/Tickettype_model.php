<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Tickettype_model extends MY_MODEL {

    public $tableName = "tickettype";
    public $pkey = "fin_ticket_type_id";

    public function __construct() {
        parent::__construct();
    }

    public function getDataById($fin_ticket_type_id){
        $ssql = "select * from ". $this->tableName ." where fin_ticket_type_id = ? ";
        $qr = $this->db->query($ssql,[$fin_ticket_type_id]);
        $rwTicketType = $qr->row();

        $data = [
            "ticketType" => $rwTicketType
        ];

        return $data;
    }

    public function getRules($mode = "ADD", $id = 0){
        $rules = [];

        $rules[] = [
            'field' => 'fst_ticket_type_name',
            'label' => 'Ticket Type Name',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        return $rules;
    }

    public function getAllList() {
        $ssql = "select fin_ticket_type_id,fst_ticket_type_name from ". $this->tableName ." where fst_active = 'A' order by fst_ticket_type_name";
        $qr = $this->db->query($ssql, []);
        $rs = $qr->result();
        return $rs;
    }

    public function get_TicketType() {
        $query = $this->db->get('tickettype');
        return $query->result_array();
    }
}