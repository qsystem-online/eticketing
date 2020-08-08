<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ticket extends MY_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('ticket_model');
        $this->load->model('ticketdocs_model');
        $this->load->model('servicelevel_model');
        $this->load->model('tickettype_model');
        $this->load->model('users_model');
        $this->load->model('msdepartments_model');
        $this->load->model('usersgroup_model');
    }

    public function index(){
        $this->lizt();
    }

    public function lizt(){
        $this->load->library('menus');
        $this->list['page_name'] = "Ticket";
        $this->list['list_name'] = "Ticket List";
        $this->list['addnew_ajax_url'] = site_url() . 'tr/ticket/add';
        //$this->list['report_url'] = site_url() . 'report/tickets';
        $this->list['pKey'] = "id";
        $this->list['fetch_list_data_ajax_url'] = site_url() . 'tr/ticket/fetch_list_data';
        $this->list['delete_ajax_url'] = site_url() . 'tr/ticket/delete/';
        $this->list['edit_ajax_url'] = site_url() . 'tr/ticket/view/';
        $this->list['arrSearch'] = [
            'fin_ticket_id' => 'Ticket ID',
            'fst_ticket_no' => 'Ticket No.'
        ];

        $this->list['breadcrumbs'] = [
            ['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
            ['title' => 'Transaksi', 'link' => '#', 'icon' => ''],
            ['title' => 'Ticket', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list['columns'] = [
            ['title' => 'ID', 'width' => '0%', 'data' => 'fin_ticket_id'],
            ['title' => 'Ticket No', 'width' => '10%', 'data' => 'fst_ticket_no'],
            ['title' => 'Ticket Type', 'width' => '10%', 'data' => 'fst_ticket_type_name'],
            ['title' => 'Ticket Datetime', 'width' => '15%', 'data' => 'fdt_ticket_datetime'],
            ['title' => 'Issued By', 'width' => '20%', 'data' => 'issuedBy'],
            ['title' => 'Issued To', 'width' => '20%', 'data' => 'issuedTo'],
            ['title' => 'Approved By', 'width' => '20%', 'data' => 'approvedBy'],
            ['title' => 'Status', 'width' => '20%', 'data' => 'fst_status'],
            ['title' => 'Action', 'width' => '10%', 'data' => 'action', 'sortable' => false, 'className' => 'dt-body-center text-center',
                'render'=>"function(data,type,row){
                    action = \"<div style='font-size:16px'>\";
                    action += \"<a class='btn-edit' href='#' data-id='\" + row.fin_ticket_id + \"'><i style='font-size:16px;color:lime' class='fa fa-bars'></i></a>\";
					action += \"</div>\";
					return action;
                }",
            ]
        ];
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = null;
        $this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR'] = $main_sidebar;
        $this->data['PAGE_CONTENT'] = $page_content;
        $this->data['MAIN_FOOTER'] = $main_footer;
        $this->parser->parse('template/main', $this->data);
    }

    private function openForm($mode = "ADD", $fin_ticket_id = 0){
        $this->load->library("menus");
        $this->load->model("ticket_model");
        $this->load->model('ticketdocs_model');
        $this->load->model("tickettype_model");
        $this->load->model("servicelevel_model");

        if ($this->input->post("submit") != "") {
            $this->add_save();
        }

        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $data["mode"] = $mode;
        $data["title"] = $mode == "ADD" ? "Add Ticket" : "View";
        // tambah ini
        if ($mode == 'ADD'){
            $data["fin_ticket_id"] = 0;
            $data["fst_ticket_no"] = $this->ticket_model->GenerateTicketNo();
        }else if ($mode == "VIEW"){
            $data["fin_ticket_id"] = $fin_ticket_id;
            $data["fst_ticket_no"] = "";
        }

        $page_content = $this->parser->parse('pages/tr/ticket/form', $data, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);

        $control_sidebar = NULL;
        $this->data["MAIN_HEADER"] = $main_header;
        $this->data["MAIN_SIDEBAR"] = $main_sidebar;
        $this->data["PAGE_CONTENT"] = $page_content;
        $this->data["MAIN_FOOTER"] = $main_footer;
        $this->data["CONTROL_SIDEBAR"] = $control_sidebar;
        $this->parser->parse('template/main', $this->data);
    }

    public function add(){
        $this->openForm("ADD", 0);
    }

    /*public function Edit($fin_ticket_id){
        $this->openForm("EDIT", $fin_ticket_id);
    }*/

    public function view($finTicketId){
        $this->openForm("VIEW", $finTicketId);
    }

    public function ajx_add_save(){
        $this->load->model('ticket_model');
        $this->load->model('servicelevel_model');

        $fdt_ticket_datetime = date("Y-m-d H:i:s");
        $fst_ticket_no = $this->ticket_model->GenerateTicketNo();

        $notifyDeadline = getDbConfig("notify_deadline"); // +7 hari
        $noW = date("Y-m-d H:i:s");
        $noW = date_create($noW);
        date_add($noW,date_interval_create_from_date_string("$notifyDeadline days"));
        $deadlineDatetime = date_format($noW,"Y-m-d H:i:s");

        $acceptDate = getDbConfig("acceptance_expiry"); // +3 hari
        $dateNow = date("Y-m-d H:i:s");
        $dateNow = date_create($dateNow);
        date_add($dateNow,date_interval_create_from_date_string("$acceptDate days"));
        $acceptDatetime = date_format($dateNow,"Y-m-d H:i:s");

        //$timestamp = strtotime('01-01-3000 00:00:00'); // hard coded
        $newDate = date('3000-01-01 00:00:00');
        //echo $newDate;

        /*$finServiceLevelDays = $this->input->post("fin_service_level_days");
        $finServiceLevelDays = abs(intval($finServiceLevelDays));
        $serVlevelDays = "{$finServiceLevelDays} days";
        $dateLevel = date("Y-m-d H:i:s");
        $dateLevel = date_create($dateLevel);
        date_add($dateLevel,date_interval_create_from_date_string($serVlevelDays));
        $serviceLevel =  date_format($dateLevel,"Y-m-d H:i:s");*/

        $this->form_validation->set_rules($this->ticket_model->getRules("ADD", 0));
        $this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');
        if ($this->form_validation->run() == FALSE) {
            //print_r($this->form_validation->error_array());
            $this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
            $this->ajxResp["message"] = "Error Validation Forms";
            $this->ajxResp["data"] = $this->form_validation->error_array();
            $this->json_output();
            return;
        }

        //Prepare Data
        $data = [
            "fst_ticket_no" => $fst_ticket_no,
            "fdt_ticket_datetime" => $fdt_ticket_datetime,
            //"fdt_acceptance_expiry_datetime" => dBDateTimeFormat($this->input->post("fdt_acceptance_expiry_datetime")),
            "fin_ticket_type_id" => $this->input->post("fin_ticket_type_id"),
            "fin_service_level_id" => $this->input->post("fin_service_level_id"),
            //"fdt_deadline_datetime" => dBDateTimeFormat($this->input->post("fdt_deadline_datetime")),
            //"fdt_deadline_extended_datetime" => dBDateTimeFormat($this->input->post("fdt_deadline_extended_datetime")),
            "fin_issued_by_user_id" => $this->input->post("fin_issued_by_user_id"),
            "fin_issued_to_user_id" => $this->input->post("fin_issued_to_user_id"),
            "fin_approved_by_user_id" => $this->input->post("fin_approved_by_user_id"),
            "fin_to_department_id" => $this->input->post("fin_to_department_id"),
            //"fst_status" => $this->input->post("fst_status"),
            "fst_memo" => $this->input->post("fst_memo"),
            //"fbl_rejected_view" => ($this->input->post("fbl_rejected_view") == null) ? 0 : 1,
            "fst_active" => 'A'
        ];

        $fbl_need_approval = $this->input->post("fbl_need_approval");
        if ($fbl_need_approval == "0" ){
            $data["fst_status"] = "APPROVED/OPEN";
        }else if ($fbl_need_approval == "1"){
            $data["fst_status"] = "NEED_APPROVAL";
        }

        $fst_assignment_or_notice = $this->input->post("fst_assignment_or_notice");
        if ($fst_assignment_or_notice == "NOTICE"){
            //$data["fdt_deadline_datetime"] = $deadlineDatetime;       // 19/03/2020 dimatikan
            //$data["fdt_deadline_extended_datetime"] = $deadlineDatetime;      // 19/03/2020 dimatikan
            $data["fdt_acceptance_expiry_datetime"] = $newDate;
        }else if ($fst_assignment_or_notice == "ASSIGNMENT"){
            $data["fdt_acceptance_expiry_datetime"] = $acceptDatetime;
            //$data["fdt_deadline_datetime"]= $serviceLevel;        // 19/03/2020 dimatikan
            //$data["fdt_deadline_extended_datetime"] = $serviceLevel;      // 19/03/2020 dimatikan
        }else if ($fst_assignment_or_notice == "INFO"){
            $data["fdt_acceptance_expiry_datetime"] = $deadlineDatetime;
            $data["fdt_deadline_datetime"] = $deadlineDatetime;
            $data["fdt_deadline_extended_datetime"] = $deadlineDatetime;
        }

        //save data
        $this->db->trans_start();
        $insertId = $this->ticket_model->insert($data);
        $dbError  = $this->db->error();
        if ($dbError["code"] != 0) {
            $this->ajxResp["status"] = "DB_FAILED";
            $this->ajxResp["message"] = "Insert Failed";
            $this->ajxResp["data"] = $this->db->error();
            $this->json_output();
            $this->db->trans_rollback();
            return;
        }

        // Ticket Log
        $this->load->model("ticketlog_model");
        $data = [
            "fin_ticket_id" => $insertId,
            "fdt_status_datetime" => $fdt_ticket_datetime,
            "fst_status" => $this->input->post("fst_status"),
            "fst_status_memo" => $this->input->post("fst_memo"),
            "fin_status_by_user_id" => $this->input->post("fin_issued_by_user_id")
        ];
        if($fbl_need_approval == "0"){
            $data["fst_status"]= "APPROVED/OPEN";
        }else{
            $data["fst_status"] = "NEED_APPROVAL";
        }
        $insertId = $this->ticketlog_model->insert($data);

        $this->db->trans_complete();
        $this->ajxResp["status"] = "SUCCESS";
        $this->ajxResp["message"] = "Data Saved !";
        $this->ajxResp["data"]["insert_id"] = $insertId;
        $this->json_output();
    }

    public function ajx_view_save(){
        $this->load->model('ticket_model');
        $fin_ticket_id = $this->input->post("fin_ticket_id");
        $data = $this->ticket_model->getDataById($fin_ticket_id);
        $ticket = $data["ms_ticket"];
        if (!$ticket) {
            $this->ajxResp["status"] = "DATA_NOT_FOUND";
            $this->ajxResp["message"] = "Data id $fin_ticket_id Not Found ";
            $this->ajxResp["data"] = [];
            $this->json_output();
            return;
        }

        $this->form_validation->set_rules($this->ticket_model->getRules("VIEW", $fin_ticket_id));
        $this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');
        if ($this->form_validation->run() == FALSE) {
            //print_r($this->form_validation->error_array());
            $this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
            $this->ajxResp["message"] = "Error Validation Forms";
            $this->ajxResp["data"] = $this->form_validation->error_array();
            $this->json_output();
            return;
        }

        $data = [
            "fin_ticket_id" => $fin_ticket_id,
            "fst_ticket_no" => $this->input->post("fst_ticket_no"),
            "fdt_ticket_datetime" => dBDateTimeFormat($this->input->post("fdt_ticket_datetime")),
            "fdt_acceptance_expiry_datetime" => dBDateTimeFormat($this->input->post("fdt_acceptance_expiry_datetime")),
            "fin_ticket_type_id" => $this->input->post("fin_ticket_type_id"),
            "fin_service_level_id" => $this->input->post("fin_service_level_id"),
            //"fdt_deadline_datetime" => dBDateTimeFormat($this->input->post("fdt_deadline_datetime")),
            "fdt_deadline_extended_datetime" => dBDateTimeFormat($this->input->post("fdt_deadline_extended_datetime")),
            "fin_issued_by_user_id" => $this->input->post("fin_issued_by_user_id"),
            "fin_issued_to_user_id" => $this->input->post("fin_issued_to_user_id"),
            "fin_approved_by_user_id" => $this->input->post("fin_approved_by_user_id"),
            "fin_to_department_id" => $this->input->post("fin_to_department_id"),
            "fst_status" => $this->input->post("fst_status"),
            "fst_memo" => $this->input->post("fst_memo"),
            //"fbl_rejected_view" => ($this->input->post("fbl_rejected_view") == null) ? 0 : 1,
            "fst_active" => 'A'
        ];

        $this->db->trans_start();
        $this->ticket_model->update($data);
        $dbError = $this->db->error();
        if ($dbError["code"] != 0) {
            $this->ajxResp["status"] = "DB_FAILED";
            $this->ajxResp["message"] = "Insert Failed";
            $this->ajxResp["data"] = $this->db->error();
            $this->json_output();
            $this->db->trans_rollback();
            return;
        }

        // Ticket Log
        $this->load->model("ticketlog_model");
        $user_status = $this->aauth->get_user_id();
        $data = [
            "fin_ticket_id" => $fin_ticket_id,
            "fdt_status_datetime" => $fdt_ticket_datetime,
            "fst_status" => $this->input->post("fst_status"),
            "fst_status_memo" => $this->input->post("fst_memo"),
            "fin_status_by_user_id" => $user_status
        ];
        $insertId = $this->ticketlog_model->insert($data);

        // Ticket Docs 27/02/2020
        $this->load->model("ticketdocs_model");

        $this->db->trans_complete();
        $this->ajxResp["status"] = "SUCCESS";
        $this->ajxResp["message"] = "Data Saved !";
        $this->ajxResp["data"]["insert_id"] = $fin_ticket_id;
        $this->json_output();
    }

    public function fetch_list_data(){
        $this->load->library("datatables");
        $user = $this->aauth->user();
        $userActive = $user->fin_user_id;
        $this->datatables->setTableName("(SELECT a.*,b.fst_ticket_type_name,c.fst_username AS issuedBy,d.fst_username AS issuedTo,e.fst_username AS approvedBy FROM trticket a 
        LEFT JOIN mstickettype b ON a.fin_ticket_type_id = b.fin_ticket_type_id
        LEFT JOIN users c ON a.fin_issued_by_user_id = c.fin_user_id
        LEFT JOIN users d ON a.fin_issued_to_user_id = d.fin_user_id
        LEFT JOIN users e ON a.fin_approved_by_user_id = e.fin_user_id
        WHERE a.fin_issued_by_user_id = $userActive OR a.fin_issued_to_user_id = $userActive OR a.fin_approved_by_user_id = $userActive) a");

        $selectFields = "fin_ticket_id,fst_ticket_no,fdt_ticket_datetime,fst_ticket_type_name,issuedBy,issuedTo,approvedBy,fst_status,'action' as action";
        $this->datatables->setSelectFields($selectFields);

        $Fields = $this->input->get('optionSearch');
        $searchFields = [$Fields];
        $this->datatables->setSearchFields($searchFields);
        $this->datatables->activeCondition = "a.fst_active !='D'";
        
        // Format Data
        $datasources = $this->datatables->getData();
        $arrData = $datasources["data"];
        $arrDataFormated = [];
        foreach ($arrData as $data) {
            //action
            $data["action"]    = "<div style='font-size:16px'>
					<a class='btn-edit' href='#' data-id='" . $data["fin_ticket_id"] . "'><i style='font-size:16px;color:lime class='fa fa-bars'></i></a>
				</div>";

            $arrDataFormated[] = $data;
        }
        $datasources["data"] = $arrDataFormated;
        $this->json_output($datasources);
    }

    public function fetch_data($fin_ticket_id){
        $this->load->model("ticket_model");
        $data = $this->ticket_model->getDataById($fin_ticket_id);
		
        $this->json_output($data);
    }

	public function delete($id){
		$this->db->trans_start();
        $this->ticket_model->delete($id);
        $this->db->trans_complete();

        $this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = lang("Data void !");
		//$this->ajxResp["data"]["insert_id"] = $insertId;
		$this->json_output();
    }
    
    public function void($id){
		$this->db->trans_start();
        $result=$this->ticket_model->void($id);
        $this->db->trans_complete();

        //$this->ajxResp["status"] = "SUCCESS";
		//$this->ajxResp["message"] = lang("Data void !");
		//$this->ajxResp["data"]["insert_id"] = $insertId;
		$this->json_output($result);
	}

    public function getAllList() {
        $this->load->model('ticket_model');
        $result = $this->ticket_model->getAllList();
        $this->ajxResp["data"] = $result;
        $this->json_output();
    }

    public function get_ticket(){
        $term = $this->input->get("term");
        $ssql = "select * from trticket where fst_ticket_no like ? order by fst_ticket_no";
        $qr = $this->db->query($ssql, ['%' . $term . '%']);
        $rs = $qr->result();

        $this->json_output($rs);
    }

    public function report_ticket(){
        $this->load->library('pdf');
        //$customPaper = array(0,0,381.89,595.28);
        //$this->pdf->setPaper($customPaper, 'landscape');
        $this->pdf->setPaper('A4', 'portrait');
        //$this->pdf->setPaper('A4', 'landscape');

        $this->load->model("ticket_model");
        $listticket = $this->ticket_model->get_ticket();
        $data = [
            "datas" => $listticket
        ];

        $this->pdf->load_view('report/ticket_pdf', $data);
        $this->Cell(30, 10, 'Percobaan Header Dan Footer With Page Number', 0, 0, 'C');
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . ' dari {nb}', 0, 0, 'R');
    }


    public function ajxGetApproval($finUserId){
        $this->load->model("users_model");
        $userList = $this->users_model->getApprovedBy($finUserId);
        $arrResult = [];
        foreach($userList as $user){
            $arrResult[] = [
                "fin_user_id"=>$user->fin_user_id,
                "fst_username"=>$user->fst_username
            ];
        }

        $this->json_output([
            "status"=>"SUCCESS",
            "messages"=>"",
            "data"=>$arrResult
        ]);

    }
    
}