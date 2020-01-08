<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Ticketlog_model extends MY_MODEL {

    public $tableName = "ticket_log";
    public $pkey = "fin_ticket_id";

    public function __construct() {
        parent::__construct();
    }

    public function getRules($mode = "ADD", $id = 0){
        $rules = [];

        $rules[] = [
            'field' => 'fst_status',
            'label' => 'Status',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        $rule[] = [
            'field' => 'fst_status_memo',
            'label' => 'Status Memo',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        return $rules;
    }
}