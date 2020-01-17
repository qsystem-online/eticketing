<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticketstatus extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('ticketstatus_model');
        $this->load->model('servicelevel_model');
        $this->load->model('tickettype_model');
        $this->load->model('users_model');
    }

    public function index()
    {
        $this->cards();
    }

    public function cards()
    {
        $this->load->library('menus');
        $this->list['page_name'] = "Ticket Status";
        $this->list['list_name'] = "Ticket Status List";
        $this->list['pKey'] = "id";
        $this->list['fetch_list_data_ajax_url'] = site_url() . 'tr/ticketstatus/fetch_list_data';
        $this->list['edit_ajax_url'] = site_url() . 'tr/ticketstatus/Update/';
        $this->list['arrSearch'] = [
            'fin_ticket_id' => 'Ticket ID',
            'fst_ticket_no' => 'Ticket Number',
            'fst_memo' => 'Ticket Memo'
        ];

        $this->list['breadcrumbs'] = [
            ['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_Ticketstatus();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = null;
        $this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR'] = $main_sidebar;
        $this->data['PAGE_CONTENT'] = $page_content;
        $this->data['MAIN_FOOTER'] = $main_footer;
        $this->parser->parse('template/main', $this->data);
    }

    public function I01()
    {
        $this->load->library('menus');
        $this->list['page_name'] = "Ticket Status";
        $this->list['list_name'] = "Ticket Status List";
        $this->list['pKey'] = "id";
        $this->list['fetch_list_data_ajax_url'] = site_url() . 'tr/ticketstatus/fetch_list_data';
        $this->list['edit_ajax_url'] = site_url() . 'tr/ticketstatus/Update/';
        $this->list['arrSearch'] = [
            'fin_ticket_id' => 'Ticket ID',
            'fst_ticket_no' => 'Ticket Number',
            'fst_memo' => 'Ticket Memo'
        ];

        $this->list['breadcrumbs'] = [
            ['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_IssuedApproved();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = null;
        $this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR'] = $main_sidebar;
        $this->data['PAGE_CONTENT'] = $page_content;
        $this->data['MAIN_FOOTER'] = $main_footer;
        $this->parser->parse('template/main', $this->data);
    }

    public function I02()
    {
        $this->load->library('menus');
        $this->list['page_name'] = "Ticket Status";
        $this->list['list_name'] = "Ticket Status List";
        $this->list['pKey'] = "id";
        $this->list['fetch_list_data_ajax_url'] = site_url() . 'tr/ticketstatus/fetch_list_data';
        $this->list['edit_ajax_url'] = site_url() . 'tr/ticketstatus/Update/';
        $this->list['arrSearch'] = [
            'fin_ticket_id' => 'Ticket ID',
            'fst_ticket_no' => 'Ticket Number',
            'fst_memo' => 'Ticket Memo'
        ];

        $this->list['breadcrumbs'] = [
            ['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_IssuedAccepted();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = null;
        $this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR'] = $main_sidebar;
        $this->data['PAGE_CONTENT'] = $page_content;
        $this->data['MAIN_FOOTER'] = $main_footer;
        $this->parser->parse('template/main', $this->data);
    }

    public function I03()
    {
        $this->load->library('menus');
        $this->list['page_name'] = "Ticket Status";
        $this->list['list_name'] = "Ticket Status List";
        $this->list['pKey'] = "id";
        $this->list['fetch_list_data_ajax_url'] = site_url() . 'tr/ticketstatus/fetch_list_data';
        $this->list['edit_ajax_url'] = site_url() . 'tr/ticketstatus/Update/';
        $this->list['arrSearch'] = [
            'fin_ticket_id' => 'Ticket ID',
            'fst_ticket_no' => 'Ticket Number',
            'fst_memo' => 'Ticket Memo'
        ];

        $this->list['breadcrumbs'] = [
            ['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_IssuedNeedRevision();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = null;
        $this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR'] = $main_sidebar;
        $this->data['PAGE_CONTENT'] = $page_content;
        $this->data['MAIN_FOOTER'] = $main_footer;
        $this->parser->parse('template/main', $this->data);
    }

    public function I04()
    {
        $this->load->library('menus');
        $this->list['page_name'] = "Ticket Status";
        $this->list['list_name'] = "Ticket Status List";
        $this->list['pKey'] = "id";
        $this->list['fetch_list_data_ajax_url'] = site_url() . 'tr/ticketstatus/fetch_list_data';
        $this->list['edit_ajax_url'] = site_url() . 'tr/ticketstatus/Update/';
        $this->list['arrSearch'] = [
            'fin_ticket_id' => 'Ticket ID',
            'fst_ticket_no' => 'Ticket Number',
            'fst_memo' => 'Ticket Memo'
        ];

        $this->list['breadcrumbs'] = [
            ['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_IssuedCompleted();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = null;
        $this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR'] = $main_sidebar;
        $this->data['PAGE_CONTENT'] = $page_content;
        $this->data['MAIN_FOOTER'] = $main_footer;
        $this->parser->parse('template/main', $this->data);
    }

    public function R01()
    {
        $this->load->library('menus');
        $this->list['page_name'] = "Ticket Status";
        $this->list['list_name'] = "Ticket Status List";
        $this->list['pKey'] = "id";
        $this->list['fetch_list_data_ajax_url'] = site_url() . 'tr/ticketstatus/fetch_list_data';
        $this->list['edit_ajax_url'] = site_url() . 'tr/ticketstatus/Update/';
        $this->list['arrSearch'] = [
            'fin_ticket_id' => 'Ticket ID',
            'fst_ticket_no' => 'Ticket Number',
            'fst_memo' => 'Ticket Memo'
        ];

        $this->list['breadcrumbs'] = [
            ['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_ReceivedApproved();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = null;
        $this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR'] = $main_sidebar;
        $this->data['PAGE_CONTENT'] = $page_content;
        $this->data['MAIN_FOOTER'] = $main_footer;
        $this->parser->parse('template/main', $this->data);
    }

    public function R02()
    {
        $this->load->library('menus');
        $this->list['page_name'] = "Ticket Status";
        $this->list['list_name'] = "Ticket Status List";
        $this->list['pKey'] = "id";
        $this->list['fetch_list_data_ajax_url'] = site_url() . 'tr/ticketstatus/fetch_list_data';
        $this->list['edit_ajax_url'] = site_url() . 'tr/ticketstatus/Update/';
        $this->list['arrSearch'] = [
            'fin_ticket_id' => 'Ticket ID',
            'fst_ticket_no' => 'Ticket Number',
            'fst_memo' => 'Ticket Memo'
        ];

        $this->list['breadcrumbs'] = [
            ['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_ReceivedAccepted();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = null;
        $this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR'] = $main_sidebar;
        $this->data['PAGE_CONTENT'] = $page_content;
        $this->data['MAIN_FOOTER'] = $main_footer;
        $this->parser->parse('template/main', $this->data);
    }

    public function R03()
    {
        $this->load->library('menus');
        $this->list['page_name'] = "Ticket Status";
        $this->list['list_name'] = "Ticket Status List";
        $this->list['pKey'] = "id";
        $this->list['fetch_list_data_ajax_url'] = site_url() . 'tr/ticketstatus/fetch_list_data';
        $this->list['edit_ajax_url'] = site_url() . 'tr/ticketstatus/Update/';
        $this->list['arrSearch'] = [
            'fin_ticket_id' => 'Ticket ID',
            'fst_ticket_no' => 'Ticket Number',
            'fst_memo' => 'Ticket Memo'
        ];

        $this->list['breadcrumbs'] = [
            ['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_ReceivedNeedRevision();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = null;
        $this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR'] = $main_sidebar;
        $this->data['PAGE_CONTENT'] = $page_content;
        $this->data['MAIN_FOOTER'] = $main_footer;
        $this->parser->parse('template/main', $this->data);
    }

    public function R04()
    {
        $this->load->library('menus');
        $this->list['page_name'] = "Ticket Status";
        $this->list['list_name'] = "Ticket Status List";
        $this->list['pKey'] = "id";
        $this->list['fetch_list_data_ajax_url'] = site_url() . 'tr/ticketstatus/fetch_list_data';
        $this->list['edit_ajax_url'] = site_url() . 'tr/ticketstatus/Update/';
        $this->list['arrSearch'] = [
            'fin_ticket_id' => 'Ticket ID',
            'fst_ticket_no' => 'Ticket Number',
            'fst_memo' => 'Ticket Memo'
        ];

        $this->list['breadcrumbs'] = [
            ['title' => 'Home', 'link' => '#', 'icon' => "<i class='fa fa-dashboard'></i>"],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_ReceivedCompleted();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
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
        $data["title"] = $mode == "ADD" ? "Add Ticket Status" : "Update Ticket Status";
        $data["fin_ticket_id"] = $fin_ticket_id;

        $page_content = $this->parser->parse('pages/tr/ticketstatus/form', $data, true);
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

    public function Update($fin_ticket_id)
    {
        $this->openForm("EDIT", $fin_ticket_id);
    }

    public function ajx_add_save()
    {
        $this->load->model('ticketstatus_model');
        $this->form_validation->set_rules($this->ticketstatus_model->getRules("ADD", 0));
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
        $insertId = $this->ticketstatus_model->insert($data);
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
        $this->load->model('ticketstatus_model');
        $fin_ticket_id = $this->input->post("fin_ticket_id");
        $data = $this->ticketstatus_model->getDataById($fin_ticket_id);
        $mstickettype = $data["ticketType"];
        if (!$mstickettype) {
            $this->ajxResp["status"] = "DATA_NOT_FOUND";
            $this->ajxResp["message"] = "Data id $fin_ticket_id Not Found ";
            $this->ajxResp["data"] = [];
            $this->json_output();
            return;
        }

        $this->form_validation->set_rules($this->ticketstatus_model->getRules("EDIT", $fin_ticket_id));
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
            "fst_ticket_type_name" => $this->input->post("fst_ticket_type_name"),
            "fst_assignment_or_notice" => $this->input->post("fst_assignment_or_notice"),
            "fbl_need_approval" => ($this->input->post("fbl_need_approval") == null ) ? 0 : 1,
            "fst_active" => 'A'
        ];

        $this->db->trans_start();

        $this->ticketstatus_model->update($data);
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
        $this->datatables->setTableName("mstickettype");

        $selectFields = "fin_ticket_id,fst_ticket_type_name,fst_assignment_or_notice,'action' as action";
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
        $this->load->model("ticketstatus_model");
        $data = $this->ticketstatus_model->getDataById($fin_ticket_id);

        //$this->load->library("datatables");		
        $this->json_output($data);
    }

	public function delete($id){
		$this->db->trans_start();
        $this->ticketstatus_model->delete($id);
        $this->db->trans_complete();

        $this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = lang("Data dihapus !");
		//$this->ajxResp["data"]["insert_id"] = $insertId;
		$this->json_output();
	}

    public function getAllList()
    {
        $this->load->model('ticketstatus_model');
        $result = $this->ticketstatus_model->getAllList();
        $this->ajxResp["data"] = $result;
        $this->json_output();
    }




}
