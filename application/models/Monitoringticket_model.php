<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Monitoringticket_model extends MY_MODEL {
    public $tableName = "trticket";
    public $pkey = "fin_ticket_id";

    public function __construct() {
        parent::__construct();
    }

    public function get_monitoringticket(){
        /*if ($arrDepartment == null OR $arrDepartment ==""){
            $arrDepartment = [];
        }
        if ( sizeof($arrDepartment) > 0){
            $deptByTo =" AND (b.fin_department_id IN ? OR c.fin_department_id IN ?) ORDER BY a.fdt_ticket_datetime";
            $arrDept = [$arrDepartment,$arrDepartment];
        }else{
            $deptByTo ="ORDER BY a.fdt_ticket_datetime";
            $arrDept = [];
        }*/
        $user = $this->aauth->user();
        $userActive = $user->fin_user_id;

        $ssql = "SELECT a.*,b.fin_level FROM users a inner join usersgroup b on a.fin_group_id = b.fin_group_id where a.fin_user_id = ?";
        $qr=$this->db->query($ssql,[$userActive]);			
        $user = $qr->row();

        $levelActive = intval($user->fin_level);
        $levelActive = strval($levelActive);
        
        if ($levelActive <= 1){
            $userMonitoring ="ORDER BY a.fdt_ticket_datetime";
        }else{
            $userMonitoring = " AND (a.fin_issued_by_user_id = $userActive OR a.fin_issued_to_user_id = $userActive OR a.fin_approved_by_user_id = $userActive)  ORDER BY a.fdt_ticket_datetime";
        }
        //$userMonitoring = " AND (a.fin_issued_by_user_id = $userActive OR a.fin_issued_to_user_id = $userActive OR a.fin_approved_by_user_id = $userActive)  ORDER BY a.fdt_ticket_datetime";

        $ssql = "SELECT a.*,b.fin_user_id,b.fst_username AS issuedBy,b.fin_department_id as department,c.fst_username AS issuedTo,d.fst_username AS Approved,e.fst_assignment_or_notice,f.fin_service_level_days FROM trticket a 
        INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id
        LEFT JOIN users c ON a.fin_issued_to_user_id = c.fin_user_id
        LEFT JOIN users d ON a.fin_approved_by_user_id = d.fin_user_id
        LEFT JOIN mstickettype e ON a.fin_ticket_type_id = e.fin_ticket_type_id
        LEFT JOIN msservicelevel f on a.fin_service_level_id = f.fin_service_level_id
        WHERE a.fst_status != 'CLOSED' AND a.fst_status != 'REJECTED' AND a.fst_status != 'VOID' AND a.fst_status != 'APPROVAL_EXPIRED' AND a.fst_status != 'ACCEPTANCE_EXPIRED' AND a.fst_status != 'TICKET_EXPIRED' AND e.fst_assignment_or_notice != 'INFO' AND a.fst_active !='D' " .$userMonitoring;
        $qr = $this->db->query($ssql,[]);
        //echo $this->db->last_query();
        //die();
        //return $qr->result_array();
        $rwtickets = $qr->result();

        $ssql = "SELECT a.* FROM trticket a
        LEFT JOIN mstickettype b ON b.fin_ticket_type_id = a.fin_ticket_type_id
        WHERE b.fst_assignment_or_notice = 'INFO' AND a.fst_status ='APPROVED/OPEN' AND a.fst_active !='D'
        ORDER BY a.fin_ticket_id desc";
        $qr = $this->db->query($ssql, []);
        //echo $this->db->last_query();
        //die();
        $rwInfo = $qr->result_array();

        $data = [
            "tickets" => $rwtickets
            //"pengumuman" => $rwInfo
        ];
        return $data;
    }
    public function get_pengumuman(){
        $ssql = "SELECT a.* FROM trticket a
        LEFT JOIN mstickettype b ON b.fin_ticket_type_id = a.fin_ticket_type_id
        WHERE b.fst_assignment_or_notice = 'INFO' AND a.fst_status ='APPROVED/OPEN' AND a.fst_active !='D'
        ORDER BY a.fin_ticket_id desc";
        $qr = $this->db->query($ssql, []);
        //echo $this->db->last_query();
        //die();
        $rwInfo = $qr->result_array();
        $data = [
            "arrPengumuman" => $rwInfo
        ];
        return $data;
    }
}