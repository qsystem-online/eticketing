<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Users_rpt_model extends CI_Model {

    public $layout1Columns = ['No', 'ID', 'User Name'];

    public function queryComplete($data, $sorder_by="a.fin_user_id", $rptLayout="1") {
        
        $branch_id = "";
        $department_id = "";
        $userGroup_id = "";
        $user_id = "";
        if (isset($data['fin_branch_id'])) { $branch_id = $data['fin_branch_id'];}
        if (isset($data['fin_department_id'])) { $department_id = $data['fin_department_id'];}
        if (isset($data['fin_group_id'])) { $userGroup_id = $data['fin_group_id'];}

        $swhere = "";
        $sorderby = "";
        if ($rptLayout == "1"){
            if ($branch_id > "0") {
                $swhere .= " and a.fin_branch_id = " . $this->db->escape($branch_id);
            } 
            if ($department_id > "0") {
                $swhere .= " and a.fin_department_id = " . $this->db->escape($department_id);
            }
            if ($userGroup_id > "0") {
                $swhere .= " and a.fin_group_id = " . $this->db->escape($userGroup_id);
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
                $ssql = "SELECT a.*,b.fst_department_name,c.fst_group_name,c.fin_level,d.fst_branch_name FROM users a 
                LEFT JOIN departments b ON a.fin_department_id = b.fin_department_id
                LEFT JOIN usersgroup c ON a.fin_group_id = c.fin_group_id
                LEFT JOIN msbranches d ON a.fin_branch_id = d.fin_branch_id " . $swhere . $sorderby;
                break;
            case "2":
                $ssql = "SELECT a.*,b.fst_department_name,c.fst_group_name,c.fin_level,d.fst_branch_name FROM users a 
                LEFT JOIN departments b ON a.fin_department_id = b.fin_department_id
                LEFT JOIN usersgroup c ON a.fin_group_id = c.fin_group_id
                LEFT JOIN msbranches d ON a.fin_branch_id = d.fin_branch_id " . $swhere . $sorderby;
                break;
            case "3":
                $ssql = "SELECT a.*,b.fst_department_name,c.fst_group_name,c.fin_level,d.fst_branch_name FROM users a 
                LEFT JOIN departments b ON a.fin_department_id = b.fin_department_id
                LEFT JOIN usersgroup c ON a.fin_group_id = c.fin_group_id
                LEFT JOIN msbranches d ON a.fin_branch_id = d.fin_branch_id " . $swhere . $sorderby;
                break;
            default:
                $ssql = "SELECT a.*,b.fst_department_name,c.fst_group_name,c.fin_level,d.fst_branch_name FROM users a 
                LEFT JOIN departments b ON a.fin_department_id = b.fin_department_id
                LEFT JOIN usersgroup c ON a.fin_group_id = c.fin_group_id
                LEFT JOIN msbranches d ON a.fin_branch_id = d.fin_branch_id " . $swhere . $sorderby;
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