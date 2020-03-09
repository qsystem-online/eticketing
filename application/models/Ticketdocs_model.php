<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Ticketdocs_model extends MY_MODEL {

    public $tableName = "trticket_docs";
    public $pkey = "fin_rec_id";

    public function __construct() {
        parent::__construct();
    }

    public function getDataById($fin_rec_id){
        $ssql = "select * from " . $this->tableName . " where fin_rec_id = ? and fst_active = 'A'";
        $qr = $this->db->query($ssql, [$fin_rec_id]);
        $rw = $qr->row();
        $data = [
            "ticket_Docs" => $rw
        ];
        return $data;
    }

    public function getRules($mode = "ADD", $id = 0){
        $rules = [];

        $rules[] = [
            'field' => 'fst_doc_title',
            'label' => 'Judul',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        return $rules;
    }
    
}