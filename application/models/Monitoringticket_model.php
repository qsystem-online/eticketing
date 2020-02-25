<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Monitoringticket_model extends MY_MODEL {
    public $tableName = "trticket";
    public $pkey = "fin_ticket_id";

    public function __construct() {
        parent::__construct();
    }

    public function get_monitoringticket($arrDepartment){

        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username AS issuedBy,b.fin_department_id as produksi,c.fst_username AS issuedTo,d.fst_username AS Approved FROM trticket a 
        INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id
        INNER JOIN users c ON a.fin_issued_to_user_id = c.fin_user_id
        INNER JOIN users d ON a.fin_approved_by_user_id = d.fin_user_id
        WHERE b.fin_department_id IN (SELECT c.fin_department_id FROM users) OR b.fin_department_id NOT IN (SELECT c.fin_department_id FROM users) 
        AND a.fst_status != 'CLOSED' AND a.fst_status != 'REJECTED' AND a.fst_status != 'VOID' AND a.fst_status != 'TICKET_EXPIRED' ORDER BY a.fdt_ticket_datetime ";
        $qr = $this->db->query($ssql,[$arrDepartment,$arrDepartment]);
        //echo $this->db->last_query();
        //die();
        //return $qr->result_array();
        $rwtickets = $qr->result();

        $ssql = "SELECT a.fst_memo FROM trticket a
        INNER JOIN mstickettype b ON b.fin_ticket_type_id = a.fin_ticket_type_id
        WHERE b.fst_assignment_or_notice = 'INFO' ORDER BY a.fin_ticket_id desc";
        $qr = $this->db->query($ssql, []);
        //echo $this->db->last_query();
        //die();
        $rwInfo = $qr->result();

        $data = [
            "tickets" => $rwtickets,
            "arrPengumuman" => $rwInfo
        ];
        return $data;
    }
}