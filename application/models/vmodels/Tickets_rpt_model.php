<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Tickets_rpt_model extends CI_Model {

    public $layout1Columns = ['No', 'No.Ticket', 'Type'];

    public function queryComplete($data, $sorder_by="a.fst_ticket_no", $rptLayout="1") {
        
        $branch_id = "";
        $department_id = "";
        $userGroup_id = "";
        $user_id = "";
        $ticket_type = "";
        $start_date = "";
        $end_date = "";
        if (isset($data['fin_branch_id'])) { $branch_id = $data['fin_branch_id'];}
        if (isset($data['fin_department_id'])) { $department_id = $data['fin_department_id'];}
        if (isset($data['fin_group_id'])) { $userGroup_id = $data['fin_group_id'];}
        if (isset($data['fin_user_id'])) { $user_id = $data['fin_user_id'];}
        if (isset($data['fin_ticket_type_id'])) { $ticket_type = $data['fin_ticket_type_id'];}
        if (isset($data['fdt_ticket_datetime'])) { $start_date = $data['fdt_ticket_datetime'];}
        if (isset($data['fdt_ticket_datetime2'])) { $end_date = $data['fdt_ticket_datetime2'];}

        $swhere = "";
        $sorderby = "";
        if ($rptLayout == "1"){
            if ($branch_id > "0") {
                $swhere .= " and b.fin_branch_id = " . $this->db->escape($branch_id);
            } 
            if ($department_id > "0") {
                $swhere .= " and b.fin_department_id = " . $this->db->escape($department_id);
            }
            if ($userGroup_id > "0") {
                $swhere .= " and b.fin_group_id = " . $this->db->escape($userGroup_id);
            }
            if ($user_id > "0" ) {
                $swhere .= " and b.fin_user_id = " . $this->db->escape($user_id);
            }
            if ($ticket_type > "0" ) {
                $swhere .= " and a.fin_ticket_type_id = " . $this->db->escape($ticket_type);
            }
            if (isset($start_date)) {
                $swhere .= " and a.fdt_ticket_datetime >= '" . date('Y-m-d', strtotime($start_date)) . "'";            
            }
            if (isset($end_date)) {
                $swhere .= " and a.fdt_ticket_datetime <= '". date('Y-m-d 23:59:59', strtotime($end_date)). "'";
            }
        }
        if ($rptLayout == "2"){
            if ($branch_id > "0") {
                $swhere .= " and a.fin_branch_id = " . $this->db->escape($branch_id);
            }
            if ($department_id > "0") {
                $swhere .= " and a.fin_department_id = " . $this->db->escape($department_id);
            }
            if ($userGroup_id > "0") {
                $swhere .= " and a.fin_group_id = " . $this->db->escape($userGroup_id);
            }
            if ($user_id > "0" ) {
                $swhere .= " and a.fin_user_id = " . $this->db->escape($user_id);
            }
            /*if (isset($start_date)) {
                $swhere .= " and b.fdt_ticket_datetime >= '" . date('Y-m-d', strtotime($start_date)) . "'";            
            }
            if (isset($end_date)) {
                $swhere .= " and b.fdt_ticket_datetime <= '". date('Y-m-d', strtotime($end_date)). "'";
            }*/
        }
        if ($rptLayout == "3"){
            if ($branch_id > "0") {
                $swhere .= " and d.fin_branch_id = " . $this->db->escape($branch_id);
            }
            if ($department_id > "0") {
                $swhere .= " and d.fin_department_id = " . $this->db->escape($department_id);
            }
            if ($userGroup_id > "0") {
                $swhere .= " and d.fin_group_id = " . $this->db->escape($userGroup_id);
            }
            if ($user_id > "0" ) {
                $swhere .= " and d.fin_user_id = " . $this->db->escape($user_id);
            }
            if ($ticket_type > "0" ) {
                $swhere .= " and a.fin_ticket_type_id = " . $this->db->escape($ticket_type);
            }
            if (isset($start_date)) {
                $swhere .= " and a.fdt_ticket_datetime >= '" . date('Y-m-d', strtotime($start_date)) . "'";            
            }
            if (isset($end_date)) {
                $swhere .= " and a.fdt_ticket_datetime <= '". date('Y-m-d 23:59:59', strtotime($end_date)). "'";
            }
        }
        if ($swhere != "") {
            $swhere = " where " . substr($swhere, 5);
        }
        if ($sorder_by != "") {
            $sorderby = " order by " .$sorder_by;
        }
        
        switch($rptLayout) {
            case "1":
                $ssql = "SELECT a.*,b.fst_username as issuedBy,c.fst_ticket_type_name,d.fst_service_level_name,d.fin_service_level_days,e.fst_username as issuedTo,f.fst_username as approvedBy
                FROM trticket a 
                LEFT JOIN users b on a.fin_issued_by_user_id = b.fin_user_id
                LEFT JOIN mstickettype c on a.fin_ticket_type_id = c.fin_ticket_type_id
                LEFT JOIN msservicelevel d on a.fin_service_level_id = d.fin_service_level_id
                LEFT JOIN users e on a.fin_issued_to_user_id = e.fin_user_id
                LEFT JOIN users f on a.fin_approved_by_user_id = f.fin_user_id " . $swhere . $sorderby;
                break;
            case "2":
                $swhere2 = "";
                if (isset($start_date)) {
                    $swhere2 .= " and fdt_ticket_datetime >= '" . date('Y-m-d', strtotime($start_date)) . "'";            
                }
                if (isset($end_date)) {
                    $swhere2 .= " and fdt_ticket_datetime <= '". date('Y-m-d 23:59:59', strtotime($end_date)). "'";
                }
                $ssql = "SELECT a.fin_user_id,a.fst_username,b.userTicket,c.fst_branch_name,d.fst_department_name,e.fst_group_name 
                FROM users a RIGHT JOIN
                (SELECT fin_issued_by_user_id AS userTicket FROM trticket WHERE fin_issued_by_user_id IS NOT NULL $swhere2
                UNION
                SELECT fin_issued_to_user_id AS userTicket FROM trticket WHERE fin_issued_to_user_id IS NOT NULL $swhere2)
                b ON a.fin_user_id = b.userTicket
                LEFT JOIN msbranches c ON a.fin_branch_id = c.fin_branch_id
                LEFT JOIN departments d ON a.fin_department_id = d.fin_department_id
                LEFT JOIN usersgroup e ON a.fin_group_id = e.fin_group_id $swhere  ORDER BY a.fin_department_id ";
                break;
            case "3":
                $ssql = "SELECT a.*,b.fst_ticket_type_name,b.fst_assignment_or_notice,c.fst_service_level_name,c.fin_service_level_days,d.fst_username AS userIssued,e.fst_username AS userReceived,f.fst_department_name,g.fst_username AS userApproved FROM trticket a
                LEFT JOIN mstickettype b ON a.fin_ticket_type_id = b.fin_ticket_type_id
                LEFT JOIN msservicelevel c ON a.fin_service_level_id = c.fin_service_level_id
                LEFT JOIN users d ON a.fin_issued_by_user_id = d.fin_user_id
                LEFT JOIN users e ON a.fin_issued_to_user_id = e.fin_user_id
                LEFT JOIN departments f ON a.fin_to_department_id = f.fin_department_id
                LEFT JOIN users g ON a.fin_approved_by_user_id = g.fin_user_id " . $swhere . $sorderby;
                break;
            default:
                break;
        }
        
        $query = $this->db->query($ssql);
        //echo $this->db->last_query();
        //die();
        return $query->result();
    }

    public function getRules()
    {
        $rules = [];

        /*$rules[] = [
            'field' => 'fin_branch_id',
            'label' => 'Branch',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];*/

        $rules[] = [
            'field' => 'fdt_ticket_datetime',
            'label' => 'Date',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        $rules[] = [
            'field' => 'fdt_ticket_datetime2',
            'label' => 's/d Date',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];
        
        return $rules;
    }   

    public function processReport($data) {
        // var_dump($data);die();
        //$data['fin_warehouse_id'], $data["fin_sales_order_datetime"], $data["fin_sales_order_datetime2"], $data["fin_relation_id"], $data['fin_sales_id']
        $dataReport = $this->queryComplete($data,"","1");
        // var_dump($recordset);
        // print_r($dataReturn["fields"]);die();
        
        // if (isset($this->$data['rows'])) {
        //     $reportData = $this->parser->parse('reports/sales_order/rpt',$this->$data["rows"], true);
        // } else {
        //     $reportData = $this->parser->parse('reports/sales_order/rpt',[], true);
        // }
        $reportData = $this->parser->parse('reports/sales_order/rpt',["rows"=>$dataReport['rows']], true);
        // var_dump($reportData);die();
        // return $reportData;
        return $reportData;
        
    }

}