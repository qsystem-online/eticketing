<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Ticketdocs_model extends MY_MODEL {

    public $tableName = "trticket_docs";
    public $pkey = "fin_rec_id";

    public function __construct() {
        parent::__construct();
    }

    
}