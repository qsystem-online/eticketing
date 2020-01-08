<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Servicelevel_model extends MY_MODEL {

    public $tableName = "servicelevel";
    public $pkey = "fin_service_level_id";

    public function __construct() {
        parent::__construct();
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
}