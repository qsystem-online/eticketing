<?php
defined('BASEPATH') or exit('No direct script access allowed');

class ticket extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('ticket_model');
        $this->load->model('servicelevel_model');
        $this->load->model('tickettype_model');
        $this->load->model('users_model');
    }

    public function index()
    {
        $this->lizt();
    }

    public function lizt()
    {
        $this->load->library('menus');
        $this->list['page_name'] = "Ticket";
        $this->list['list_name'] = "Ticket List";
        $this->list['addnew_ajax_url'] = site_url() . 'tr/ticket/add';
        $this->list['pKey'] = "id";
        $this->list['fetch_list_data_ajax_url'] = site_url() . 'tr/ticket/fetch_list_data';
        $this->list['delete_ajax_url'] = site_url() . 'tr/ticket/delete/';
        $this->list['edit_ajax_url'] = site_url() . 'tr/ticket/edit/';
        $this->list['arrSearch'] = [
            'fin_ticket_no' => 'Ticket No.',
            'fst_ticket_no' => 'Ticket No.'
        ];

        $this->list['breadcrumbs'] = [
            ['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
            ['title' => 'Ticket', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list['columns'] = [
            ['title' => 'Ticket ID.', 'width' => '15%', 'visible' => 'false', 'data' => 'fin_ticket_id'],
            ['title' => 'Ticket No.', 'width' => '25%', 'data' => 'fst_ticket_no'],
            ['title' => 'Ticket Datetime', 'width' => '20%', 'data' => 'fdt_ticket_datetime'],
            ['title' => 'Acceptance Expiry Datetime', 'width' => '20%', 'data' => 'fdt_acceptance_expiry_datetime'],
            ['title' => 'Memo', 'width' => '25%', 'data' => 'fst_memo'],
            ['title' => 'Action', 'width' => '10%', 'data' => 'action', 'sortable' => false, 'className' => 'dt-body-center text-center']
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

    private function openForm($mode = "ADD", $fin_ticket_id = 0)
    {
        $this->load->library("menus");

        if ($this->input->post("submit") != "") {
            $this->add_save();
        }

        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $data["mode"] = $mode;
        $data["title"] = $mode == "ADD" ? "Add Ticket" : "Update Ticket";
        $data["fin_ticket_id"] = $fin_ticket_id;
        // tambah ini
        if ($mode == 'ADD'){
            $data["fin_ticket_id"] = 0;
            $data["fst_ticket_no"] = $this->ticket_model->GenerateTicketNo();
        }else if ($mode == "EDIT"){
            $data["fin_ticket_id"] = $fin_ticket_id;
            $data["fst_ticket_no"] = "";
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

    public function add()
    {
        $this->openForm("ADD", 0);
    }

    public function Edit($fin_ticket_id)
    {
        $this->openForm("EDIT", $fin_ticket_id);
    }

    public function ajx_add_save()
    {
        $fdt_ticket_datetime = dBDateTimeFormat($this->input->post("fdt_ticket_datetime"));
		
        $fst_ticket_no = $this->ticket_model->GenerateTicketNo();
        $this->load->model('ticket_model');
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

        $data = [
            "fst_ticket_no" => $fst_ticket_no,
            "fdt_ticket_datetime" => $fdt_ticket_datetime,
            "fdt_acceptance_expiry_datetime" => dBDateTimeFormat($this->input->post("fdt_acceptance_expiry_datetime")),
            "fin_ticket_type_id" => $this->input->post("fin_ticket_type_id"),
            "fin_service_level_id" => $this->input->post("fin_service_level_id"),
            "fdt_deadline_datetime" => dBDateTimeFormat($this->input->post("fdt_deadline_datetime")),
            "fdt_deadline_extended_datetime" => dBDateTimeFormat($this->input->post("fdt_deadline_extended_datetime")),
            "fdt_ticket_expiry_extended_datetime" =>dBDateTimeFormat($this->input->post("fdt_ticket_expiry_extended_datetime")),
            "fin_issued_by_user_id" => $this->aauth->get_active_user_id(),
            "fin_issued_to_user_id" => $this->input->post("fin_issued_to_user_id"),
            "fst_memo" => $this->input->post("fst_memo"),
            "fst_active" => 'A'
        ];

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

        $this->db->trans_complete();

        $this->ajxResp["status"] = "SUCCESS";
        $this->ajxResp["message"] = "Data Saved !";
        $this->ajxResp["data"]["insert_id"] = $insertId;
        $this->json_output();
    }

    public function ajx_edit_save()
    {
        $this->load->model('ticket_model');
        $fin_ticket_id = $this->input->post("fin_ticket_id");
        $data = $this->ticket_model->getDataById($fin_ticket_id);
        $trticket = $data["ms_ticket"];
        if (!$trticket) {
            $this->ajxResp["status"] = "DATA_NOT_FOUND";
            $this->ajxResp["message"] = "Data id $fin_ticket_id Not Found ";
            $this->ajxResp["data"] = [];
            $this->json_output();
            return;
        }

        $this->form_validation->set_rules($this->ticket_model->getRules("EDIT", $fin_ticket_id));
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
            "fdt_deadline_datetime" => dBDateTimeFormat($this->input->post("fdt_deadline_datetime")),
            "fdt_deadline_extended_datetime" => dBDateTimeFormat($this->input->post("fdt_deadline_extended_datetime")),
            "fdt_ticket_expiry_extended_datetime" =>dBDateTimeFormat($this->input->post("fdt_ticket_expiry_extended_datetime")),
            "fin_issued_by_user_id" => $this->aauth->get_active_user_id(),
            "fin_issued_to_user_id" => $this->input->post("fin_issued_to_user_id"),
            "fst_memo" => $this->input->post("fst_memo"),
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

        $this->db->trans_complete();

        $this->ajxResp["status"] = "SUCCESS";
        $this->ajxResp["message"] = "Data Saved !";
        $this->ajxResp["data"]["insert_id"] = $fin_ticket_id;
        $this->json_output();
    }

    public function fetch_list_data()
    {
        $this->load->library("datatables");
        $this->datatables->setTableName("trticket");

        $selectFields = "fin_ticket_id,fst_ticket_no,fdt_ticket_datetime,fst_memo,'action' as action";
        $this->datatables->setSelectFields($selectFields);

        $Fields = $this->input->get('optionSearch');
        $searchFields = [$Fields];
        $this->datatables->setSearchFields($searchFields);
        
        // Format Data
        $datasources = $this->datatables->getData();
        $arrData = $datasources["data"];
        $arrDataFormated = [];
        foreach ($arrData as $data) {
            //action
            $data["action"]    = "<div style='font-size:16px'>
					<a class='btn-edit' href='#' data-id='" . $data["fin_ticket_id"] . "'><i class='fa fa-pencil'></i></a>
				</div>";

            $arrDataFormated[] = $data;
        }
        $datasources["data"] = $arrDataFormated;
        $this->json_output($datasources);
    }

    public function fetch_data($fin_ticket_id)
    {
        $this->load->model("ticket_model");
        $data = $this->ticket_model->getDataById($fin_ticket_id);

        //$this->load->library("datatables");		
        $this->json_output($data);
    }

	public function delete($id){
		$this->db->trans_start();
        $this->ticket_model->delete($id);
        $this->db->trans_complete();

        $this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = lang("Data dihapus !");
		//$this->ajxResp["data"]["insert_id"] = $insertId;
		$this->json_output();
	}

    public function getAllList() {
        $this->load->model('ticket_model');
        $result = $this->ticket_model->getAllList();
        $this->ajxResp["data"] = $result;
        $this->json_output();
    }

    public function get_users(){
        $term = $this->input->get("term");
        $ssql = "select fin_user_id,fst_username from users where fst_username like ?";
        $qr = $this->db->query($ssql,['%'.$term.'%']);
        $rs = $qr->result();

        $this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["data"] = $rs;
		$this->json_output();
    }

    public function get_ticket()
    {
        $term = $this->input->get("term");
        $ssql = "select * from trticket where fst_ticket_no like ? order by fst_ticket_no";
        $qr = $this->db->query($ssql, ['%' . $term . '%']);
        $rs = $qr->result();

        $this->json_output($rs);
    }

    public function report_ticket()
    {
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
}
