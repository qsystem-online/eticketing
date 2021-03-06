<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tickettype extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->aauth->is_permit("ticket_type")){
            show_404();
		}
        $this->load->library('form_validation');
        $this->load->model('tickettype_model');
    }

    public function index()
    {
        $this->lizt();
    }

    public function lizt()
    {
        $this->load->library('menus');
        $this->list['page_name'] = "Ticket Type";
        $this->list['list_name'] = "Ticket Type List";
        $this->list['addnew_ajax_url'] = site_url() . 'master/tickettype/add';
        $this->list['pKey'] = "id";
        $this->list['fetch_list_data_ajax_url'] = site_url() . 'master/tickettype/fetch_list_data';
        $this->list['delete_ajax_url'] = site_url() . 'master/tickettype/delete/';
        $this->list['edit_ajax_url'] = site_url() . 'master/tickettype/edit/';
        $this->list['addcopy_ajax_url'] = site_url() . 'master/tickettype/copy/'; //Hanya Dipakai di ticketList
        $this->list['arrSearch'] = [
            'fin_ticket_type_id' => 'Ticket Type ID',
            'fst_ticket_type_name' => 'Ticket Type Name'
        ];

        $this->list['breadcrumbs'] = [
            ['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
            ['title' => 'Master', 'link' => '#', 'icon' => ''],
            ['title' => 'Ticket Type', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list['columns'] = [
            ['title' => 'ID', 'width' => '5%', 'data' => 'fin_ticket_type_id'],
            ['title' => 'Ticket Type Name', 'width' => '40%', 'data' => 'fst_ticket_type_name'],
            ['title' => 'Assignment or Notice', 'width' => '20%', 'data' => 'fst_assignment_or_notice',
                'render' =>"function(data,type,row){
                    if(data == 'ASSIGNMENT'){
                        return 'ASSIGNMENT';
                    }else if(data == 'NOTICE'){
                        return 'NOTICE';
                    }else if(data == 'INFO'){
                        return 'INFO';
                    }
                }"
            ],
            ['title' => 'Approval', 'width' => '15%', 'data' => 'fbl_need_approval',
                'render' =>"function(data,type,row){
                    if(data == 1){
                        return 'Need Approval';
                    }else{
                        return '-';
                    }
                }"
            ],
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

    private function openForm($mode = "ADD", $fin_ticket_type_id = 0)
    {
        $this->load->library("menus");

        if ($this->input->post("submit") != "") {
            $this->add_save();
        }

        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);

        $data["mode"] = $mode;
        $data["title"] = $mode == "ADD" ? "Add Ticket Type" : "Update";
        $data["fin_ticket_type_id"] = $fin_ticket_type_id;

        $page_content = $this->parser->parse('pages/master/tickettype/form', $data, true);
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

    public function Edit($fin_ticket_type_id)
    {
        $this->openForm("EDIT", $fin_ticket_type_id);
    }

    public function ajx_add_save()
    {
        $this->load->model('tickettype_model');
        $this->form_validation->set_rules($this->tickettype_model->getRules("ADD", 0));
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
            "fst_ticket_type_name" => $this->input->post("fst_ticket_type_name"),
            "fst_assignment_or_notice" => $this->input->post("fst_assignment_or_notice"),
            "fbl_need_approval" => ($this->input->post("fbl_need_approval") == null ) ? 0 : 1,
            "fst_active" => 'A'
        ];

        $this->db->trans_start();
        $insertId = $this->tickettype_model->insert($data);
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
        $this->load->model('tickettype_model');
        $fin_ticket_type_id = $this->input->post("fin_ticket_type_id");
        $data = $this->tickettype_model->getDataById($fin_ticket_type_id);
        $mstickettype = $data["ticketType"];
        if (!$mstickettype) {
            $this->ajxResp["status"] = "DATA_NOT_FOUND";
            $this->ajxResp["message"] = "Data id $fin_ticket_type_id Not Found ";
            $this->ajxResp["data"] = [];
            $this->json_output();
            return;
        }

        $this->form_validation->set_rules($this->tickettype_model->getRules("EDIT", $fin_ticket_type_id));
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
            "fin_ticket_type_id" => $fin_ticket_type_id,
            "fst_ticket_type_name" => $this->input->post("fst_ticket_type_name"),
            "fst_assignment_or_notice" => $this->input->post("fst_assignment_or_notice"),
            "fbl_need_approval" => ($this->input->post("fbl_need_approval") == null ) ? 0 : 1,
            "fst_active" => 'A'
        ];

        $this->db->trans_start();

        $this->tickettype_model->update($data);
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
        $this->ajxResp["data"]["insert_id"] = $fin_ticket_type_id;
        $this->json_output();
    }

    public function fetch_list_data()
    {
        $this->load->library("datatables");
        $this->datatables->setTableName("mstickettype");

        $selectFields = "fin_ticket_type_id,fst_ticket_type_name,fst_assignment_or_notice,fbl_need_approval,'action' as action";
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
					<a class='btn-edit' href='#' data-id='" . $data["fin_ticket_type_id"] . "'><i class='fa fa-pencil'></i></a>
				</div>";

            $arrDataFormated[] = $data;
        }
        $datasources["data"] = $arrDataFormated;
        $this->json_output($datasources);
    }

    public function fetch_data($fin_ticket_type_id)
    {
        $this->load->model("tickettype_model");
        $data = $this->tickettype_model->getDataById($fin_ticket_type_id);

        //$this->load->library("datatables");		
        $this->json_output($data);
    }

	public function delete($id){
		$this->db->trans_start();
        $this->tickettype_model->delete($id);
        $this->db->trans_complete();

        $this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = lang("Data dihapus !");
		//$this->ajxResp["data"]["insert_id"] = $insertId;
		$this->json_output();
	}

    public function getAllList()
    {
        $this->load->model('tickettype_model');
        $result = $this->tickettype_model->getAllList();
        $this->ajxResp["data"] = $result;
        $this->json_output();
    }

    public function get_TicketType()
    {
        $term = $this->input->get("term");
        $ssql = "SELECT * FROM mstickettype WHERE fst_active = 'A' ORDER BY fst_ticket_type_name";
        $qr = $this->db->query($ssql, ['%' . $term . '%']);
        $rs = $qr->result();

        $this->json_output($rs);
    }

    public function report_tickettype()
    {
        $this->load->library('pdf');
        //$customPaper = array(0,0,381.89,595.28);
        //$this->pdf->setPaper($customPaper, 'landscape');
        $this->pdf->setPaper('A4', 'portrait');
        //$this->pdf->setPaper('A4', 'landscape');

        $this->load->model("tickettype_model");
        $listTickettype = $this->tickettype_model->get_TicketType();
        $data = [
            "datas" => $listTickettype
        ];

        $this->pdf->load_view('report/tickettype_pdf', $data);
        $this->Cell(30, 10, 'Percobaan Header Dan Footer With Page Number', 0, 0, 'C');
        $this->Cell(0, 10, 'Halaman ' . $this->PageNo() . ' dari {nb}', 0, 0, 'R');
    }
}
