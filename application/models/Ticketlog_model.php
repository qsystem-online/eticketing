<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Ticketlog_model extends MY_MODEL {

    public $tableName = "trticket_log";

    public function __construct() {
        parent::__construct();
    }

    public function deleteByUserId($fin_ticket_id){
        $ssql = "delete from " . $this->tableName . " where fin_ticket_id = ?";
        $this->db->query($ssql,[$fin_ticket_id]);
    }
}