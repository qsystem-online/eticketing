<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Tickettype_model extends MY_MODEL {

    public $tableName = "tickettype";
    public $pkey = "fin_ticket_type_id";

    public function __construct() {
        parent::__construct();
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
}