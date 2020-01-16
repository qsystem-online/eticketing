<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Servicelevel_model extends MY_MODEL {

    public $tableName = "msservicelevel";
    public $pkey = "fin_service_level_id";

    public function __construct() {
        parent::__construct();
    }

    public function getDataById($fin_service_level_id){
        $ssql = "select * from ". $this->tableName ." where fin_service_level_id = ? ";
        $qr = $this->db->query($ssql,[$fin_service_level_id]);
        $rwServiceLevel = $qr->row();

        $data = [
            "serviceLevel" => $rwServiceLevel
        ];

        return $data;
    }

    public function getRules($mode = "ADD", $id = 0){
        $rules = [];

        $rules[] = [
            'field' => 'fst_service_level_name',
            'label' => 'Service Level Name',
            'rules' => 'required',
            'errors' => array(
                'required' => '%s tidak boleh kosong'
            )
        ];

        return $rules;
    }

    public function get_data_serviceLevel(){
        $term = $this->input->get("term");
        $ssql = "select * from " . $this->tableName . " where fst_active = 'A' order by fst_service_level_name";
        $qr = $this->db->query($ssql, []);
        $rs = $qr->result();
        return $rs;
    }

    public function getAllList(){
        $ssql = "select fin_service_level_id,fst_service_level_name from " . $this->tableName . " where fst_active = 'A' order by fst_service_level_name";
        $qr = $this->db->query($ssql, []);
        $rs = $qr->result();
        return $rs;
    }

    public function get_ServiceLevel(){
        $query = $this->db->get('servicelevel');
        return $query->result_array();
    }
}