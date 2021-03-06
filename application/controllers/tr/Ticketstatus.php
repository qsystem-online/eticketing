<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Ticketstatus extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('ticketstatus_model');
        $this->load->model("ticket_model");
        $this->load->model('servicelevel_model');
        $this->load->model('tickettype_model');
        $this->load->model('users_model');
        $this->load->model('msdepartments_model');
        $this->load->model("dashboard_model");
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
            ['title' => 'Transaksi', 'link' => '#', 'icon' => ''],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_Ticketstatus();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = "";
        $control_sidebar = null;
        $this->data['CONTROL_SIDEBAR']= null;
        $this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR'] = $main_sidebar;
        $this->data['PAGE_CONTENT'] = $page_content;
        $this->data['MAIN_FOOTER'] = $main_footer;
        $this->parser->parse('template/main', $this->data);
    }

    public function AR()
    {
        $this->load->library('menus');
        $this->list['page_name'] = "Approval Request";
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
            ['title' => 'Transaksi', 'link' => '#', 'icon' => ''],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_NeeddApproval();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = "";
        $control_sidebar = null;
        $this->data['CONTROL_SIDEBAR']= null;
        $this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR'] = $main_sidebar;
        $this->data['PAGE_CONTENT'] = $page_content;
        $this->data['MAIN_FOOTER'] = $main_footer;
        $this->parser->parse('template/main', $this->data);
    }

    public function rejected()
    {
        $this->load->library('menus');
        $this->list['page_name'] = "Rejected";
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
            ['title' => 'Transaksi', 'link' => '#', 'icon' => ''],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_IssuedRejected();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = "";
        $control_sidebar = null;
        $this->data['CONTROL_SIDEBAR']= null;
        $this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR'] = $main_sidebar;
        $this->data['PAGE_CONTENT'] = $page_content;
        $this->data['MAIN_FOOTER'] = $main_footer;
        $this->parser->parse('template/main', $this->data);
    }

    public function our_tickets()
    {
        $this->load->library('menus');
        $this->list['page_name'] = "Our Tickets";
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
            ['title' => 'Transaksi', 'link' => '#', 'icon' => ''],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_our_tickets();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = "";
        $control_sidebar = null;
        $this->data['CONTROL_SIDEBAR']= null;
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
        $this->list['page_name'] = "Ticket Issued Open";
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
            ['title' => 'Transaksi', 'link' => '#', 'icon' => ''],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_IssuedApproved();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = "";
        $control_sidebar = null;
        $this->data['CONTROL_SIDEBAR']= null;
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
        $this->list['page_name'] = "Ticket Issued Accepted";
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
            ['title' => 'Transaksi', 'link' => '#', 'icon' => ''],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_IssuedAccepted();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = "";
        $control_sidebar = null;
        $this->data['CONTROL_SIDEBAR']= null;
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
        $this->list['page_name'] = "Need Revision";
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
            ['title' => 'Transaksi', 'link' => '#', 'icon' => ''],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_IssuedNeedRevision();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = "";
        $control_sidebar = null;
        $this->data['CONTROL_SIDEBAR']= null;
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
        $this->list['page_name'] = "Ticket Issued Completed";
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
            ['title' => 'Transaksi', 'link' => '#', 'icon' => ''],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_IssuedCompleted();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = "";
        $control_sidebar = null;
        $this->data['CONTROL_SIDEBAR']= null;
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
            ['title' => 'Transaksi', 'link' => '#', 'icon' => ''],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_ReceivedApproved();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = "";
        $control_sidebar = null;
        $this->data['CONTROL_SIDEBAR']= null;
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
            ['title' => 'Transaksi', 'link' => '#', 'icon' => ''],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_ReceivedAccepted();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = "";
        $control_sidebar = null;
        $this->data['CONTROL_SIDEBAR']= null;
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
            ['title' => 'Transaksi', 'link' => '#', 'icon' => ''],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_ReceivedNeedRevision();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = "";
        $control_sidebar = null;
        $this->data['CONTROL_SIDEBAR']= null;
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
            ['title' => 'Transaksi', 'link' => '#', 'icon' => ''],
            ['title' => 'Ticket Status', 'link' => '#', 'icon' => ''],
            ['title' => 'List', 'link' => NULL, 'icon' => ''],
        ];
        $this->list["cards"] = $this->ticketstatus_model->get_ReceivedCompleted();
        $main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $page_content = $this->parser->parse('template/standardCardList', $this->list, true);
        $main_footer = $this->parser->parse('inc/main_footer', [], true);
        $control_sidebar = "";
        $control_sidebar = null;
        $this->data['CONTROL_SIDEBAR']= null;
        $this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR'] = $main_sidebar;
        $this->data['PAGE_CONTENT'] = $page_content;
        $this->data['MAIN_FOOTER'] = $main_footer;
        $this->parser->parse('template/main', $this->data);
    }

    public function ticket_report()
    {
        $this->load->library("menus");
        $this->list["depList"] = $this->ticketstatus_model->getAllList();

		$main_header = $this->parser->parse('inc/main_header', [], true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
        $mdlPrint = $this->parser->parse('template/mdlPrint.php', [], true);
        $data["mdlPrint"] = $mdlPrint;

		$data["title"] = "Ticket Monitoring";
		//$data["fin_user_id"] = $fin_user_id;

		$page_content = $this->parser->parse('report/ticket_report', $data, true);
		$main_footer = $this->parser->parse('inc/main_footer', [], true);

		$control_sidebar = NULL;
		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
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
        $data["title"] = $mode == "ADD" ? "Add Ticket Status" : "Update";
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
        $is_permit_ticket = $this->ticket_model->is_permit_ticket($fin_ticket_id);
        if ($is_permit_ticket != null){
            $this->openForm("EDIT", $fin_ticket_id);
        }else{
            show_404();
        }
        //$this->openForm("EDIT", $fin_ticket_id);
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

    public function ajx_update_status()
    {
        $this->load->model('ticketstatus_model');
        $fin_ticket_id = $this->input->post("fin_ticket_id");
        $data = $this->ticketstatus_model->getDataById($fin_ticket_id);
        $ticket = $data["ms_ticketstatus"];
        if (!$ticket) {
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
        $this->db->trans_start();

        $days = $this->input->post("fin_service_level_days");
        $newStatus = $this->input->post("fst_update_status");
        $days = abs(intval($days)); //tambahan
        $daysLevel = "{$days} days"; //tambahan
        $now = date("Y-m-d H:i:s");
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string($daysLevel));
        $ticketdeadline_datetime = date_format($now,"Y-m-d 23:59:59");
        //echo ($ticketdeadline_datetime);
        $data = [
            "fin_ticket_id" => $fin_ticket_id,
            "fst_status" => $newStatus,
            "fst_active" => 'A'
        ];

        $last_status = $ticket->fst_status;
        $deadline_date = $ticket->fdt_deadline_datetime;
        $user_received = $ticket->fin_issued_to_user_id;
        $user_issued = $ticket->fin_issued_by_user_id;
        $user_active = $this->aauth->get_user_id();
        $type_ticket = $ticket->fst_assignment_or_notice;
        //echo($deadline_date);
        //die();

        if ($last_status =='APPROVED/OPEN' && $deadline_date == NULL && $user_received == $user_active && $newStatus == 'ACCEPTED' && $type_ticket != "NOTICE"){
            //echo("NULL BUKAN NOTICE");
            //die();
            $data["fdt_deadline_datetime"]= $ticketdeadline_datetime;
            $data["fdt_deadline_extended_datetime"]= $ticketdeadline_datetime;
        }else if ($last_status =='APPROVED/OPEN' && $deadline_date == NULL && $user_received == $user_active && $newStatus == 'COMPLETED' && $type_ticket == "NOTICE"){
            //echo("NULL & NOTICE");
            //die();
            $data["fdt_deadline_datetime"]= date("Y-m-d H:i:s");
            $data["fdt_deadline_extended_datetime"]= date("Y-m-d H:i:s");
        }
        
        if ($last_status =='NEED_REVISION' && $deadline_date != NULL && $user_issued == $user_active){
            //echo("SET DEADNLINE");
            //die();
            $data["fdt_deadline_extended_datetime"]= dBDateTimeFormat($this->input->post("fdt_update_deadline_extended_datetime"));
        }else if ($last_status =='NEED_REVISION' && $deadline_date == NULL && $user_issued == $user_active){
            //echo($this->input->post("fin_service_level_id"));
            //die();
            $data["fin_service_level_id"]= $this->input->post("fin_service_level_id");
        }

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

        // Ticket Log
        $this->load->model("ticketlog_model");
        $user_status = $this->aauth->get_user_id();
        $data = [
            "fin_ticket_id" => $fin_ticket_id,
            "fdt_status_datetime" => date("Y-m-d H:i:s"),
            //"fst_status" => $this->input->post("fst_update_status"),
            "fst_status_memo" => $this->input->post("fst_memo_update"),
            "fin_status_by_user_id" => $user_status
        ];
        if($last_status =='NEED_REVISION'){
            $data["fst_status"]= 'REVISED';
        }else{
            $data["fst_status"] = $this->input->post("fst_update_status");
        }
        $insertId = $this->ticketlog_model->insert($data);

        $this->db->trans_complete();

        $this->ajxResp["status"] = "SUCCESS";
        $this->ajxResp["message"] = "Data Saved !";
        $this->ajxResp["data"]["insert_id"] = $fin_ticket_id;
        $this->json_output();
    }

    public function fetch_list_data()
    {
        $this->load->library("datatables");
        $user = $this->aauth->user();
        $deptActive = $user->fin_department_id;
		$this->datatables->setTableName("
			(
                SELECT a.*,b.fin_user_id,b.fst_username AS issuedBy,b.fin_department_id,c.fst_username AS issuedTo FROM trticket a 
                INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id
                INNER JOIN users c ON a.fin_issued_to_user_id = c.fin_user_id
                INNER JOIN users d ON a.fin_approved_by_user_id = d.fin_user_id
                WHERE b.fin_department_id = $deptActive OR c.fin_department_id = $deptActive
			) as a 
        ");

        $selectFields = "a.fin_ticket_id,a.fst_memo,a.fin_issued_by_user_id,a.fin_issued_to_user_id,a.fin_approved_by_user_id,a.fdt_ticket_datetime,a.fst_status";
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
        $this->ticketstatus_model->update_rejectedview($fin_ticket_id);
        $this->ticketstatus_model->update_view_newTicket($fin_ticket_id);
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

    public function get_print_ticketReport($ticketdate_awal,$ticketdate_akhir,$issuedBy,$issuedTo,$status) {
        $layout = $this->input->post("layoutColumn");
        $arrLayout = json_decode($layout);
        if ($status == "OPEN"){
            $status = "APPROVED/OPEN";
        }
        //echo ($status);
        //die();
        //$issuedBy = urldecode($issuedBy);
        //$issuedTo = urldecode($issuedTo);
        
        /*var_dump($arrLayout);
        echo "PRINT......";
        
        foreach($arrLayout as $layout){
            if($layout->column == "fin_cust_pricing_group_id"){
                if($layout->hidden == true){
                    echo $hidden;
                }else{
                    echo $show;
                }
            }
        }
        //die();*/
        
        $this->load->model("ticketstatus_model");
        $this->load->library("phpspreadsheet");
        
        $spreadsheet = $this->phpspreadsheet->load(FCPATH . "assets/templates/template_ticket_report.xlsx");
        $sheet = $spreadsheet->getActiveSheet();
        
		$sheet->getPageSetup()->setFitToWidth(1);
		$sheet->getPageSetup()->setFitToHeight(0);
		$sheet->getPageMargins()->setTop(1);
		$sheet->getPageMargins()->setRight(0.5);
		$sheet->getPageMargins()->setLeft(0.5);
        $sheet->getPageMargins()->setBottom(1);

        //AUTO SIZE COLUMN
        $sheet->getColumnDimension("A")->setAutoSize(true);
        $sheet->getColumnDimension("B")->setAutoSize(true);
        $sheet->getColumnDimension("C")->setAutoSize(true);
        $sheet->getColumnDimension("D")->setAutoSize(true);
        $sheet->getColumnDimension("E")->setAutoSize(true);
        $sheet->getColumnDimension("F")->setAutoSize(true);
        $sheet->getColumnDimension("G")->setAutoSize(true);
        $sheet->getColumnDimension("H")->setAutoSize(true);
        $sheet->getColumnDimension("I")->setAutoSize(true);
        $sheet->getColumnDimension("J")->setAutoSize(true);
        $sheet->getColumnDimension("K")->setAutoSize(true);

        // SUBTITLE
        $sheet->mergeCells('B4:D4');
        $sheet->mergeCells('B5:D5');
        $sheet->mergeCells('B3:D3');

        //HEADER COLUMN
        $sheet->setCellValue("A7", "No.");
        $sheet->setCellValue("B7", "Ticket No");
        $sheet->setCellValue("C7", "Datetime");
        $sheet->setCellValue("D7", "Issued By");
        $sheet->setCellValue("E7", "Issued To");
        $sheet->setCellValue("F7", "Ticket Type Name");
        $sheet->setCellValue("G7", "Memo");
        $sheet->setCellValue("H7", "Deadline");
        $sheet->setCellValue("I7", "Expiry");
        $sheet->setCellValue("J7", "Status");
        $sheet->setCellValue("K7", "Days");

        $i =10;
		$col = $this->phpspreadsheet->getNameFromNumber($i);

        //TITLE
        $sheet->mergeCells('A1:'.$col.'1');
        $sheet->setCellValue("A1", "DAFTAR TICKET");

        //FORMAT NUMBER
        //$spreadsheet->getActiveSheet()->getStyle('D8:'.$col.'500')->getNumberFormat()->setFormatCode('#,##0.00');
        
        //COLOR HEADER COLUMN
        $spreadsheet->getActiveSheet()->getStyle('A7:'.$col.'7')
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('99FFFF');

        //FONT HEADER CENTER
        $spreadsheet->getActiveSheet()->getStyle('A7:'.$col.'7')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        //FONT ITALIC
        $italycArray = [
            'font' => [
                'italic' => true,
            ],
        ];

        //FONT BOLD
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
        ];
        $sheet->getStyle('A7:'.$col.'7')->applyFromArray($styleArray);
        $sheet->getStyle('B3:N3')->applyFromArray($styleArray);
        $sheet->getStyle('B4:N4')->applyFromArray($styleArray);
        $sheet->getStyle('B5:N5')->applyFromArray($styleArray);

        //FONT SIZE
        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(18);
        $spreadsheet->getActiveSheet()->getStyle("A3:".$col."3")->getFont()->setSize(12);
        $spreadsheet->getActiveSheet()->getStyle("A7:".$col."7")->getFont()->setSize(12);

        $iRow0 = 3;
        $iRow1 = 4;
        $iRow2 = 5;
        $iRow = 8;
        $no = 1;

        //DATE & TIME
        $sheet->setCellValue('H3', '=NOW()');
        $sheet->mergeCells('H3:'.$col.'3');
        $sheet->setCellValue('I4', '=NOW()');
        $sheet->mergeCells('I4:'.$col.'4');
        $printTicket = $this->ticketstatus_model->get_PrintTicketReport($ticketdate_awal,$ticketdate_akhir,$issuedBy,$issuedTo,$status);
        foreach ($printTicket as $rw) {

            $sheet->setCellValue("A$iRow", $no++);
            $sheet->setCellValue("B$iRow0", $ticketdate_awal." s/d ".$ticketdate_akhir);
            $sheet->setCellValue("B$iRow1", $issuedBy);
            $sheet->setCellValue("B$iRow2", $issuedTo);
            //$sheet->setCellValue("A$iRow", $no++);
            $sheet->setCellValue("B$iRow", $rw->fst_ticket_no);
            $sheet->setCellValue("C$iRow", $rw->fdt_ticket_datetime);
            $sheet->setCellValue("D$iRow", $rw->issuedBy);
            $sheet->setCellValue("E$iRow", $rw->issuedTo);
            $sheet->setCellValue("F$iRow", $rw->fst_ticket_type_name);
            $sheet->setCellValue("G$iRow", $rw->fst_memo);
            $sheet->setCellValue("H$iRow", $rw->fdt_deadline_datetime);
            $sheet->setCellValue("I$iRow", $rw->fdt_deadline_extended_datetime);
            $sheet->setCellValue("J$iRow", $rw->fst_status);
            $sheet->setCellValue("K$iRow", $rw->fin_service_level_days);
            $iRow++;
            
        }

        //BORDER
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHED
                ],
            ],
        ];
        $iRow = $iRow - 1;
        $sheet->getStyle('A7:'.$col.$iRow)->applyFromArray($styleArray);
        
        //FILE NAME WITH DATE
        $this->phpspreadsheet->save("ticket_report_" . date("Ymd") . ".xls" ,$spreadsheet);
    }

    public function get_ticket_perUser($user_id){
        $layout = $this->input->post("layoutColumn");
        $arrLayout = json_decode($layout);
        //echo ($status);
        //die();
        //$issuedBy = urldecode($issuedBy);
        //$issuedTo = urldecode($issuedTo);
        
        /*var_dump($arrLayout);
        echo "PRINT......";
        
        foreach($arrLayout as $layout){
            if($layout->column == "fin_cust_pricing_group_id"){
                if($layout->hidden == true){
                    echo $hidden;
                }else{
                    echo $show;
                }
            }
        }
        //die();*/
        
        $this->load->model("ticketstatus_model");
        $this->load->library("phpspreadsheet");
        
        $spreadsheet = $this->phpspreadsheet->load(FCPATH . "assets/templates/ticket_summary_PerUser.xlsx");
        $sheet = $spreadsheet->getActiveSheet();
        
		$sheet->getPageSetup()->setFitToWidth(1);
		$sheet->getPageSetup()->setFitToHeight(0);
		$sheet->getPageMargins()->setTop(1);
		$sheet->getPageMargins()->setRight(0.5);
		$sheet->getPageMargins()->setLeft(0.5);
        $sheet->getPageMargins()->setBottom(1);

        //AUTO SIZE COLUMN
        $sheet->getColumnDimension("A")->setAutoSize(true);
        $sheet->getColumnDimension("B")->setAutoSize(true);
        $sheet->getColumnDimension("C")->setAutoSize(true);
        $sheet->getColumnDimension("D")->setAutoSize(true);
        $sheet->getColumnDimension("E")->setAutoSize(true);
        $sheet->getColumnDimension("F")->setAutoSize(true);
        $sheet->getColumnDimension("G")->setAutoSize(true);
        $sheet->getColumnDimension("H")->setAutoSize(true);
        $sheet->getColumnDimension("I")->setAutoSize(true);
        $sheet->getColumnDimension("J")->setAutoSize(true);
        $sheet->getColumnDimension("K")->setAutoSize(true);
        $sheet->getColumnDimension("L")->setAutoSize(true);
        $sheet->getColumnDimension("M")->setAutoSize(true);
        $sheet->getColumnDimension("N")->setAutoSize(true);
        $sheet->getColumnDimension("O")->setAutoSize(true);
        $sheet->getColumnDimension("P")->setAutoSize(true);
        $sheet->getColumnDimension("Q")->setAutoSize(true);
        $sheet->getColumnDimension("R")->setAutoSize(true);
        $sheet->getColumnDimension("S")->setAutoSize(true);

        // SUBTITLE
        $sheet->mergeCells('B4:D4');
        $sheet->mergeCells('B5:D5');
        $sheet->mergeCells('B3:D3');

        //HEADER COLUMN
        $sheet->setCellValue("A7", "No.");
        $sheet->setCellValue("B7", "Department");
        $sheet->setCellValue("C7", "User Group");
        $sheet->setCellValue("D7", "User");
        $sheet->setCellValue("E7", "Ticket Type");
        $sheet->setCellValue("F7", "Issued");
        $sheet->setCellValue("G7", "Accepted");
        $sheet->setCellValue("H7", "Closed");
        $sheet->setCellValue("I7", "Acceptance Expired");
        $sheet->setCellValue("J7", "Ticket Expired");
        $sheet->setCellValue("K7", "Rejected");
        $sheet->setCellValue("L7", "Void");
        $sheet->setCellValue("M7", "Issued");
        $sheet->setCellValue("N7", "Accepted");
        $sheet->setCellValue("O7", "Closed");
        $sheet->setCellValue("P7", "Acceptance Expired");
        $sheet->setCellValue("Q7", "Ticket Expired");
        $sheet->setCellValue("R7", "Rejected");
        $sheet->setCellValue("S7", "Void");

        $i =18;
		$col = $this->phpspreadsheet->getNameFromNumber($i);

        //TITLE
        $sheet->mergeCells('A1:'.$col.'1');
        $sheet->setCellValue("A1", "PER-USER TICKET SUMMARY");

        //FORMAT NUMBER
        //$spreadsheet->getActiveSheet()->getStyle('D8:'.$col.'500')->getNumberFormat()->setFormatCode('#,##0.00');
        
        //COLOR HEADER COLUMN
        $spreadsheet->getActiveSheet()->getStyle('A7:'.$col.'7')
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('99FFFF');

        //FONT HEADER CENTER
        $spreadsheet->getActiveSheet()->getStyle('A7:'.$col.'7')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        //FONT ITALIC
        $italycArray = [
            'font' => [
                'italic' => true,
            ],
        ];

        //FONT BOLD
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
        ];
        $sheet->getStyle('A7:'.$col.'7')->applyFromArray($styleArray);
        $sheet->getStyle('B3:N3')->applyFromArray($styleArray);
        $sheet->getStyle('B4:N4')->applyFromArray($styleArray);
        $sheet->getStyle('B5:N5')->applyFromArray($styleArray);

        //FONT SIZE
        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(18);
        $spreadsheet->getActiveSheet()->getStyle("A3:".$col."3")->getFont()->setSize(12);
        $spreadsheet->getActiveSheet()->getStyle("A7:".$col."7")->getFont()->setSize(12);

        $iRow0 = 3;
        $iRow1 = 4;
        $iRow2 = 5;
        $iRow = 8;
        $no = 1;

        //DATE & TIME
        $sheet->setCellValue('H3', '=NOW()');
        $sheet->mergeCells('H3:'.$col.'3');
        $sheet->setCellValue('I4', '=NOW()');
        $sheet->mergeCells('I4:'.$col.'4');
        $printTicket = $this->ticketstatus_model->get_PrintTicketUser($user_id);
        $userTicket ="";
        $ticketType ="";
        $ticketTypeID = "";
        foreach ($printTicket as $rw) {

            /**if ($ticketTypeID != $rw->fin_ticket_type_id){
                $iRow++;
                $ticketTypeID = $rw->fin_ticket_type_id;
            }**/

            //$sheet->setCellValue("A$iRow", $no++);
            $sheet->setCellValue("B$iRow0", $user_id." s/d ".$user_id);
            $sheet->setCellValue("B$iRow1", $user_id);
            $sheet->setCellValue("B$iRow2", $user_id);
            //$sheet->setCellValue("A$iRow", $no++);
            if ($userTicket != $rw->userTicket){

                $userTicket = $rw->userTicket;
                //$IssuedByID = $rw->fin_issued_by_user_id;
                //$IssuedToID = $rw->fin_issued_to_user_id;
                $sheet->setCellValue("A$iRow", $no++);
                $sheet->setCellValue("B$iRow", $rw->fst_department_name);
                $sheet->setCellValue("C$iRow", $rw->fst_group_name);
                $sheet->setCellValue("D$iRow", $rw->fst_username);

                $ssql = "select * from mstickettype";
                $qr = $this->db->query($ssql, []);
                $rsType = $qr->result();
    
                foreach ($rsType as $roType){
                    //$spreadsheet->getActiveSheet()->getStyle("E$iRow")->getFont()->getColor()->setRGB('0000FF');
                    /**$sheet->setCellValue("E$iRow", $roType->fst_ticket_type_name);
                    $sheet->setCellValue("F$iRow", 0);
                    $sheet->setCellValue("G$iRow", 0);
                    $sheet->setCellValue("H$iRow", 0);
                    $sheet->setCellValue("I$iRow", 0);
                    $sheet->setCellValue("J$iRow", 0);
                    $sheet->setCellValue("K$iRow", 0);
                    $sheet->setCellValue("L$iRow", 0);**/

                    $ticketTypeID = $roType->fin_ticket_type_id;
                    $ttl_issuedStatus = 0;
                    $ttl_receivedStatus = 0;
                    $ttl_allStatus = 0;
                    $ssql = "SELECT fin_issued_by_user_id,fin_ticket_type_id,fst_status,COUNT(*) AS ttl FROM trticket WHERE fin_issued_by_user_id=? AND  fin_ticket_type_id=? GROUP BY fst_status";
                    $qr = $this->db->query($ssql, [$userTicket,$ticketTypeID]);
                    //echo $this->db->last_query();
                    //die();
                    $rsIssued = $qr->result();
                    $issuedOpen = 0;
                    $issuedAccepted = 0;
                    $issuedClosed = 0;
                    $issuedAExpired = 0;
                    $issuedTExpired = 0;
                    $issuedRejected = 0;
                    $issuedVoid = 0;
                    foreach ($rsIssued as $roIssued){
                        if ($roIssued->fst_status == "APPROVED/OPEN" OR $roIssued->fst_status == "NEED_APPROVAL"){
                            $issuedOpen = $roIssued->ttl;
                            //$sheet->setCellValue("F$iRow", $roIssued->ttl);
                            //$spreadsheet->getActiveSheet()->getStyle("F$iRow")->getFont()->getColor()->setRGB('0000FF');
                        }
                        if ($roIssued->fst_status == "ACCEPTED"){
                            $issuedAccepted = $roIssued->ttl;
                            //$sheet->setCellValue("G$iRow", $roIssued->ttl);
                            //$spreadsheet->getActiveSheet()->getStyle("G$iRow")->getFont()->getColor()->setRGB('0000FF');
                        }
                        if ($roIssued->fst_status == "CLOSED"){
                            $issuedClosed = $roIssued->ttl;
                            //$sheet->setCellValue("H$iRow", $roIssued->ttl);
                            //$spreadsheet->getActiveSheet()->getStyle("H$iRow")->getFont()->getColor()->setRGB('0000FF');
                        }
                        if ($roIssued->fst_status == "ACCEPTANCE_EXPIRED"){
                            $issuedAExpired = $roIssued->ttl;
                            //$sheet->setCellValue("I$iRow", $roIssued->ttl);
                            //$spreadsheet->getActiveSheet()->getStyle("I$iRow")->getFont()->getColor()->setRGB('0000FF');
                        }
                        if ($roIssued->fst_status == "TICKET_EXPIRED"){
                            $issuedTExpired = $roIssued->ttl;
                            //$sheet->setCellValue("J$iRow", $roIssued->ttl);
                            //$spreadsheet->getActiveSheet()->getStyle("J$iRow")->getFont()->getColor()->setRGB('0000FF');
                        }
                        if ($roIssued->fst_status == "REJECTED"){
                            $issuedRejected = $roIssued->ttl;
                            //$sheet->setCellValue("K$iRow", $roIssued->ttl);
                            //$spreadsheet->getActiveSheet()->getStyle("K$iRow")->getFont()->getColor()->setRGB('0000FF');
                        }
                        if ($roIssued->fst_status == "VOID"){
                            $issuedVoid = $roIssued->ttl;
                            //$sheet->setCellValue("L$iRow", $roIssued->ttl);
                            //$spreadsheet->getActiveSheet()->getStyle("L$iRow")->getFont()->getColor()->setRGB('0000FF');
                        }
                    }
                    $ssql = "SELECT fin_issued_to_user_id,fin_ticket_type_id,fst_status,COUNT(*) AS ttl FROM trticket WHERE fin_issued_to_user_id=? AND  fin_ticket_type_id=? GROUP BY fst_status";
                    $qr = $this->db->query($ssql, [$userTicket,$ticketTypeID]);
                    //echo $this->db->last_query();
                    //die();
                    $rsReceived= $qr->result();
                    $receivedOpen = 0;
                    $receivedAccepted = 0;
                    $receivedClosed = 0;
                    $receivedAExpired = 0;
                    $receivedTExpired = 0;
                    $receivedRejected = 0;
                    $receivedVoid = 0;
                    foreach ($rsReceived as $roReceived){
                        if ($roReceived->fst_status == "APPROVED/OPEN" OR $roReceived->fst_status == "NEED_APPROVAL"){
                            $receivedOpen = $roReceived->ttl;
                            //$sheet->setCellValue("M$iRow", $roReceived->ttl);
                        }
                        if ($roReceived->fst_status == "ACCEPTED"){
                            $receivedAccepted = $roReceived->ttl;
                            //$sheet->setCellValue("N$iRow", $roReceived->ttl);
                        }
                        if ($roReceived->fst_status == "CLOSED"){
                            $receivedClosed = $roReceived->ttl;
                            //$sheet->setCellValue("O$iRow", $roReceived->ttl);
                        }
                        if ($roReceived->fst_status == "ACCEPTANCE_EXPIRED"){
                            $receivedAExpired = $roReceived->ttl;
                            //$sheet->setCellValue("P$iRow", $roReceived->ttl);
                        }
                        if ($roReceived->fst_status == "TICKET_EXPIRED"){
                            $receivedTExpired = $roReceived->ttl;
                            //$sheet->setCellValue("Q$iRow", $roReceived->ttl);
                        }
                        if ($roReceived->fst_status == "REJECTED"){
                            $receivedRejected = $roReceived->ttl;
                            //$sheet->setCellValue("R$iRow", $roReceived->ttl);
                        }
                        if ($roReceived->fst_status == "VOID"){
                            $receivedVoid = $roReceived->ttl;
                            //$sheet->setCellValue("S$iRow", $roReceived->ttl);
                        }
                    }
                    $ttl_issuedStatus += $issuedOpen + $issuedAccepted + $issuedClosed + $issuedAExpired + $issuedTExpired + $issuedRejected + $issuedVoid;
                    $ttl_receivedStatus += $receivedOpen + $receivedAccepted + $receivedClosed + $receivedAExpired + $receivedTExpired + $receivedRejected + $receivedVoid;;
                    $ttl_allStatus += $ttl_issuedStatus + $ttl_receivedStatus;
                    //echo ($ttl_issuedStatus);
                    //die();
                    if($ttl_allStatus != 0){
                        $sheet->setCellValue("E$iRow", $roType->fst_ticket_type_name);
                        $sheet->setCellValue("F$iRow", $issuedOpen);
                        $sheet->setCellValue("G$iRow", $issuedAccepted);
                        $sheet->setCellValue("H$iRow", $issuedClosed);
                        $sheet->setCellValue("I$iRow", $issuedAExpired);
                        $sheet->setCellValue("J$iRow", $issuedTExpired);
                        $sheet->setCellValue("K$iRow", $issuedRejected);
                        $sheet->setCellValue("L$iRow", $issuedVoid);
                        $sheet->setCellValue("M$iRow", $receivedOpen);
                        $sheet->setCellValue("N$iRow", $receivedAccepted);
                        $sheet->setCellValue("O$iRow", $receivedClosed);
                        $sheet->setCellValue("P$iRow", $receivedAExpired);
                        $sheet->setCellValue("Q$iRow", $receivedTExpired);
                        $sheet->setCellValue("R$iRow", $receivedRejected);
                        $sheet->setCellValue("S$iRow", $receivedVoid);
                        $iRow++;
                    }
                    //$iRow++;
                }
            }
            /**if($ticketType != $rw->fst_ticket_type_name){
                $ticketType = $rw->fst_ticket_type_name;
                $sheet->setCellValue("E$iRow", $rw->fst_ticket_type_name);
            }**/

            /*$status = "";
            $open = 0;
            $accepted = 0;
            $closed = 0;
            $tExpired = 0;
            $void = 0;
            $aExpired = 0;
            $rejected = 0;
            $completed = 0;
            
            if($rw->fst_status =="APPROVED/OPEN" OR $rw->fst_status == "NEED_APPROVAL"){
                $open = $rw->TOTAL;
                $sheet->setCellValue("F$iRow", $open);
            }
            if($rw->fst_status =="ACCEPTED"){
                $accepted = $rw->TOTAL;
                $sheet->setCellValue("G$iRow", $accepted);
            }
            if($rw->fst_status =="CLOSED"){
                $closed = $rw->TOTAL;
                $sheet->setCellValue("H$iRow", $closed);
            }
            if($rw->fst_status =="ACCEPTANCE_EXPIRED"){
                $aExpired = $rw->TOTAL;
                $sheet->setCellValue("I$iRow", $aExpired);
            }
            if($rw->fst_status =="TICKET_EXPIRED"){
                $tExpired = $rw->TOTAL;
                $sheet->setCellValue("J$iRow", $tExpired);
            }
            if($rw->fst_status =="REJECTED"){
                $rejected = $rw->TOTAL;
                $sheet->setCellValue("K$iRow", $rejected);
            }
            if($rw->fst_status =="COMPLETED"){
                $completed = $rw->TOTAL;
            }
            if($rw->fst_status =="VOID"){
                $void = $rw->TOTAL;
                $sheet->setCellValue("L$iRow", $void);
            }*/

           

            /**$ssql = "SELECT fin_issued_by_user_id,fst_status,COUNT(*) AS TOTAL FROM trticket WHERE fin_issued_by_user_id = ? AND fin_ticket_type_id=? GROUP BY fin_ticket_type_id,fst_status";
            $qr = $this->db->query($ssql,[$IssuedByID,$ticketTypeID]);
            //echo $this->db->last_query();
            //die();
            $rs = $qr->result();
            $status = "";
            $open = 0;
            $accepted = 0;
            $closed = 0;
            $tExpired = 0;
            $void = 0;
            $aExpired = 0;
            $rejected = 0;
            $completed = 0;
            foreach ($rs as $ro){
                $status = $ro->fst_status;
                if($ro->fst_status =="APPROVED/OPEN" OR $ro->fst_status == "NEED_APPROVAL"){
                    $open = $ro->TOTAL;
                    $sheet->setCellValue("F$iRow", $open);
                }
                if($ro->fst_status =="ACCEPTED"){
                    $accepted = $ro->TOTAL;
                    $sheet->setCellValue("G$iRow", $accepted);
                }
                if($ro->fst_status =="CLOSED"){
                    $closed = $ro->TOTAL;
                    $sheet->setCellValue("H$iRow", $closed);
                }
                if($ro->fst_status =="ACCEPTANCE_EXPIRED"){
                    $aExpired = $ro->TOTAL;
                    $sheet->setCellValue("I$iRow", $aExpired);
                }
                if($ro->fst_status =="TICKET_EXPIRED"){
                    $tExpired = $ro->TOTAL;
                    $sheet->setCellValue("J$iRow", $tExpired);
                }
                if($ro->fst_status =="REJECTED"){
                    $rejected = $ro->TOTAL;
                    $sheet->setCellValue("K$iRow", $rejected);
                }
                if($ro->fst_status =="COMPLETED"){
                    $completed = $ro->TOTAL;
                }
                if($ro->fst_status =="VOID"){
                    $void = $ro->TOTAL;
                    $sheet->setCellValue("L$iRow", $void);
                }
            }**/
            /**$ssql = "SELECT fin_issued_to_user_id,fst_status,COUNT(*) AS TOTAL FROM trticket WHERE fin_issued_to_user_id = ? AND fin_ticket_type_id=? GROUP BY fin_ticket_type_id,fst_status";
            $qr = $this->db->query($ssql,[$rw->fin_issued_to_user_id,$ticketTypeID]);
            //echo $this->db->last_query();
            //die();
            $rsr = $qr->result();
            $openR = 0;
            $acceptedR = 0;
            $closedR = 0;
            $tExpiredR = 0;
            $voidR = 0;
            $aExpiredR = 0;
            $rejectedR = 0;
            $completedR = 0;
            foreach ($rsr as $ror){
                if($ror->fst_status =="APPROVED/OPEN" OR $ror->fst_status == "NEED_APPROVAL"){
                    $openR = $ror->TOTAL;
                    $sheet->setCellValue("M$iRow", $openR);
                }
                if($ror->fst_status =="ACCEPTED"){
                    $acceptedR = $ror->TOTAL;
                    $sheet->setCellValue("N$iRow", $acceptedR);
                }
                if($ror->fst_status =="CLOSED"){
                    $closedR = $ror->TOTAL;
                    $sheet->setCellValue("O$iRow", $closedR);
                }
                if($ror->fst_status =="ACCEPTANCE_EXPIRED"){
                    $aExpiredR = $ror->TOTAL;
                    $sheet->setCellValue("P$iRow", $aExpiredR);
                }
                if($ror->fst_status =="TICKET_EXPIRED"){
                    $tExpiredR = $ror->TOTAL;
                    $sheet->setCellValue("Q$iRow", $tExpiredR);
                }
                if($ror->fst_status =="REJECTED"){
                    $rejectedR = $ror->TOTAL;
                    $sheet->setCellValue("R$iRow", $rejectedR);
                }
                if($ror->fst_status =="COMPLETED"){
                    $completedR = $ror->TOTAL;
                }
                if($ror->fst_status =="VOID"){
                    $void = $ror->TOTAL;
                    $sheet->setCellValue("S$iRow", $voidR);
                }
            }**/
            /*$sheet->setCellValue("F$iRow", $open);
            $sheet->setCellValue("G$iRow", $accepted);
            $sheet->setCellValue("H$iRow", $closed);
            $sheet->setCellValue("I$iRow", $aExpired);
            $sheet->setCellValue("J$iRow", $tExpired);
            $sheet->setCellValue("K$iRow", $rejected);
            $sheet->setCellValue("L$iRow", $void);
            $iRow++;*/
            
        }

        //BORDER
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHED
                ],
            ],
        ];
        $iRow = $iRow - 0;
        $sheet->getStyle('A8:'.$col.$iRow)->applyFromArray($styleArray);
        
        //FILE NAME WITH DATE
        $this->phpspreadsheet->save("ticket_summary_PerUser" . date("Ymd") . ".xls" ,$spreadsheet);
    }
    public function get_print_ticketSLDays($user_id) {
        $layout = $this->input->post("layoutColumn");
        $arrLayout = json_decode($layout);
        
        $this->load->model("ticketstatus_model");
        $this->load->library("phpspreadsheet");
        
        $spreadsheet = $this->phpspreadsheet->load(FCPATH . "assets/templates/template_ticket_report.xlsx");
        $sheet = $spreadsheet->getActiveSheet();
        
		$sheet->getPageSetup()->setFitToWidth(1);
		$sheet->getPageSetup()->setFitToHeight(0);
		$sheet->getPageMargins()->setTop(1);
		$sheet->getPageMargins()->setRight(0.5);
		$sheet->getPageMargins()->setLeft(0.5);
        $sheet->getPageMargins()->setBottom(1);

        //AUTO SIZE COLUMN
        $sheet->getColumnDimension("A")->setAutoSize(true);
        $sheet->getColumnDimension("B")->setAutoSize(true);
        $sheet->getColumnDimension("C")->setAutoSize(true);
        $sheet->getColumnDimension("D")->setAutoSize(true);
        $sheet->getColumnDimension("E")->setAutoSize(true);
        $sheet->getColumnDimension("F")->setAutoSize(true);
        $sheet->getColumnDimension("G")->setAutoSize(true);
        $sheet->getColumnDimension("H")->setAutoSize(true);
        $sheet->getColumnDimension("I")->setAutoSize(true);
        $sheet->getColumnDimension("J")->setAutoSize(true);
        $sheet->getColumnDimension("K")->setAutoSize(true);
        $sheet->getColumnDimension("L")->setAutoSize(true);
        $sheet->getColumnDimension("M")->setAutoSize(true);
        $sheet->getColumnDimension("N")->setAutoSize(true);

        // SUBTITLE
        $sheet->mergeCells('B4:D4');
        $sheet->mergeCells('B5:D5');
        $sheet->mergeCells('B3:D3');

        //HEADER COLUMN
        $sheet->setCellValue("A7", "No.");
        $sheet->setCellValue("B7", "Ticket No");
        $sheet->setCellValue("C7", "Ticket Type");
        $sheet->setCellValue("D7", "Service Level(SL)");
        $sheet->setCellValue("E7", "SL Days");
        $sheet->setCellValue("F7", "Issued Date");
        $sheet->setCellValue("G7", "Issued By");
        $sheet->setCellValue("H7", "Issued To");
        $sheet->setCellValue("I7", "Approved By");
        $sheet->setCellValue("J7", "Approved");
        $sheet->setCellValue("K7", "Accepted");
        $sheet->setCellValue("L7", "Completed");
        $sheet->setCellValue("M7", "Closed");
        $sheet->setCellValue("N7", "Completion Revised");

        $i =13;
		$col = $this->phpspreadsheet->getNameFromNumber($i);

        //TITLE
        $sheet->mergeCells('A1:'.$col.'1');
        $sheet->setCellValue("A1", "DAFTAR TICKET");

        //FORMAT NUMBER
        //$spreadsheet->getActiveSheet()->getStyle('D8:'.$col.'500')->getNumberFormat()->setFormatCode('#,##0.00');
        
        //COLOR HEADER COLUMN
        $spreadsheet->getActiveSheet()->getStyle('A7:'.$col.'7')
            ->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setRGB('99FFFF');

        //FONT HEADER CENTER
        $spreadsheet->getActiveSheet()->getStyle('A7:'.$col.'7')
            ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        //FONT ITALIC
        $italycArray = [
            'font' => [
                'italic' => true,
            ],
        ];

        //FONT BOLD
        $styleArray = [
            'font' => [
                'bold' => true,
            ],
        ];
        $sheet->getStyle('A7:'.$col.'7')->applyFromArray($styleArray);
        $sheet->getStyle('B3:N3')->applyFromArray($styleArray);
        $sheet->getStyle('B4:N4')->applyFromArray($styleArray);
        $sheet->getStyle('B5:N5')->applyFromArray($styleArray);

        //FONT SIZE
        $spreadsheet->getActiveSheet()->getStyle("A1")->getFont()->setSize(18);
        $spreadsheet->getActiveSheet()->getStyle("A3:".$col."3")->getFont()->setSize(12);
        $spreadsheet->getActiveSheet()->getStyle("A7:".$col."7")->getFont()->setSize(12);

        $iRow0 = 3;
        $iRow1 = 4;
        $iRow2 = 5;
        $iRow = 8;
        $no = 1;

        //DATE & TIME
        $sheet->setCellValue('H3', '=NOW()');
        $sheet->mergeCells('H3:'.$col.'3');
        $sheet->setCellValue('I4', '=NOW()');
        $sheet->mergeCells('I4:'.$col.'4');
        $printTicket = $this->ticketstatus_model->get_printTicket_SLDays($user_id);
        foreach ($printTicket as $rw) {

            //$sheet->setCellValue("A$iRow", $no++);
            $sheet->setCellValue("B$iRow0", $user_id." s/d ".$user_id);
            $sheet->setCellValue("B$iRow1", $user_id);
            $sheet->setCellValue("B$iRow2", $user_id);
            $sheet->setCellValue("A$iRow", $no++);
            $sheet->setCellValue("B$iRow", $rw->fst_ticket_no);
            $sheet->setCellValue("C$iRow", $rw->fst_ticket_type_name);
            $sheet->setCellValue("D$iRow", $rw->fst_service_level_name);
            $sheet->setCellValue("E$iRow", $rw->fin_service_level_days);
            $sheet->setCellValue("F$iRow", $rw->fdt_ticket_datetime);
            $sheet->setCellValue("G$iRow", $rw->userIssued);
            $sheet->setCellValue("H$iRow", $rw->userReceived);
            $sheet->setCellValue("I$iRow", $rw->userApproved);
            $ssql = "SELECT a.fin_ticket_id,a.fdt_ticket_datetime,b.fdt_status_datetime,b.fst_status,DATEDIFF(b.fdt_status_datetime,a.fdt_ticket_datetime) + 1 AS Days FROM trticket a 
            LEFT JOIN trticket_log b ON a.fin_ticket_id=b.fin_ticket_id WHERE a.fin_ticket_id=?";
            $qr = $this->db->query($ssql, [$rw->fin_ticket_id]);
            //echo $this->db->last_query();
            //die();
            $rsDays= $qr->result();
            $approvedDay = 0;
            $acceptedDay = 0;
            $completedDay = 0;
            $closedDay = 0;
            $completionRevised = 0;
            foreach($rsDays as $roDay){
                if ($roDay->fst_status == "APPROVED/OPEN"){
                    $approvedDay = $roDay->Days;
                }
                if ($roDay->fst_status == "ACCEPTED"){
                    $acceptedDay = $roDay->Days;
                }
                if ($roDay->fst_status == "COMPLETED"){
                    $completedDay = $roDay->Days;
                }
                if ($roDay->fst_status == "CLOSED"){
                    $closedDay = $roDay->Days;
                }
            }
            $sheet->setCellValue("J$iRow", $approvedDay);
            $sheet->setCellValue("K$iRow", $acceptedDay);
            $sheet->setCellValue("L$iRow", $completedDay);
            $sheet->setCellValue("M$iRow", $closedDay);
            $sheet->setCellValue("N$iRow", $completionRevised);
            $iRow++;
            
        }

        //BORDER
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DASHED
                ],
            ],
        ];
        $iRow = $iRow - 1;
        $sheet->getStyle('A7:'.$col.$iRow)->applyFromArray($styleArray);
        
        //FILE NAME WITH DATE
        $this->phpspreadsheet->save("ticket_report_" . date("Ymd") . ".xls" ,$spreadsheet);
    }
    public function monitoring(){
        
        $user = $this->aauth->user();
        $arrDepartment[]= $user->fin_department_id;
        //$arrDepartment = $this->input->get('fin_dept_id');
        //var_dump($arrDepartment);
        //die();
		$this->load->model("monitoringticket_model");
		$tickets = $this->monitoringticket_model->get_monitoringticket();
        $data = [
			"tickets" => $tickets['tickets']
        ];
        
        //var_dump($data);
        //die();
        $this->load->model("msdepartments_model");
        $data["arrDeptList"] =$this->msdepartments_model->getAllList();
        $this->parser->parse('pages/tr/ticketstatus/monitoring.php',$tickets);
    }

    public function monitoringticket(){

        $arrDepartment = $this->input->get('fin_dept_id');
        //var_dump($arrDepartment);
        //die();
        //$arrDepartment = ['2'];
        $this->load->model("monitoringticket_model");
        $tickets = $this->monitoringticket_model->get_monitoringticket($arrDepartment);
        $this->json_output($tickets);
    }

    public function ajx_add_doc(){
        /*
        fst_lampiran: (binary)
        fst_doc_title: asdasdasdasdasdasdasdasdasdasdasd asdasdasd asdasdasd        
        fst_memo: asdasdasdasd asdmemo
        */
        $this->load->model("ticketdocs_model");
        $this->load->model("ticket_model");
        $file = $_FILES['fst_lampiran'];

        
        $data = [
            "fin_ticket_id"=>$this->input->post("fin_ticket_id"),
            "fst_doc_title"=>$this->input->post("fst_doc_title"),
            "fst_status"=>$this->ticket_model->getLastLogStatus($this->input->post("fin_ticket_id")),
            "fst_filename"=>$file["name"],
            "fst_memo"=>$this->input->post("fst_memo"),
            "fst_active"=>"A",
        ];

        try{

        
            $this->db->trans_start();
            
            $insertId = $this->ticketdocs_model->insert($data);

            //Save Image
            if (!empty($_FILES['fst_lampiran']['tmp_name'])) {
                $config['upload_path']          = './assets/app/tickets/image/';
                $config['file_name']			= $insertId . '.jpg';
                $config['overwrite']			= TRUE;
                $config['file_ext_tolower']		= TRUE;
                $config['allowed_types']        = 'gif|jpg|png|jpeg';
                $config['max_size']             = 0; //kilobyte
                $config['max_width']            = 0; //1024; //pixel
                $config['max_height']           = 0; //768; //pixel
                $this->load->library('upload', $config);
                
                if (!$this->upload->do_upload('fst_lampiran')) {
                    throw new CustomException("Failed to upload images, " . $this->upload->display_errors(),3003,"IMAGES_FAILED",$this->upload->display_errors());                    
                } 
                
                $this->ajxResp["data"] = [
                    "insertId"=>$insertId,                    
                    "insertDatetime"=>date("Y-m-d H:i:s"),
                    "data_lampiran" => $this->upload->data()
                ];
            }



            $this->db->trans_complete();

            $this->ajxResp["status"] = "SUCCESS";
            $this->ajxResp["message"] = "";
            /*
            $this->ajxResp["data"] = [
                "data_lampiran" => $this->upload->data()                
            ];
            */
            $this->json_output();

        }catch(CustomException $e){
            $this->db->trans_rollback();
            $this->ajxResp["status"] = $e->getStatus();
            $this->ajxResp["message"] = $e->getMessage();
            $this->ajxResp["data"] = $e->getData();
            $this->json_output();
        }
        
	
    }

    public function ajx_delete_doc($finDocId){
        $this->load->model("ticketdocs_model");
        $result = $this->ticketdocs_model->getDataById($finDocId);
        $rwDoc = $result["ticket_Docs"];
        if ($rwDoc == null){
            $this->json_output([
                "status"=>"FAILED",
                "message"=>"Invalid Doc Id"                
            ]);
        }else{
            if ($this->aauth->get_user_id() == $rwDoc->fin_insert_id){
                //Delete Document file
                unlink("./assets/app/tickets/image/". $rwDoc->fin_rec_id .".jpg");
                $this->db->where("fin_rec_id",$rwDoc->fin_rec_id);
                $this->db->delete("trticket_docs");
                $this->json_output([
                    "status"=>"SUCCESS",
                    "message"=>""                
                ]);
            }else{
                $this->json_output([
                    "status"=>"FAILED",
                    "message"=>"Invalid Doc Id"                
                ]); 
            }
        }
    }

	public function monitoringpengumuman(){
        $arrDepartment = $this->input->get('fin_dept_id');
        //var_dump($arrDepartment);
        //die();
        //$arrDepartment = ['2'];
        $this->load->model("monitoringticket_model");
        $arrPengumuman = $this->monitoringticket_model->get_pengumuman();
        $this->json_output($arrPengumuman);
    }

    public function get_new_ticket(){
        $new = $this->dashboard_model->get_ttl_newTickets();
        $result['new'] = $new;
        $result['msg'] = "Refresh success!";
        echo json_encode($result);
    }

    public function get_new_ticket_notif(){
        $arrNotif = $this->ticketstatus_model->get_our_tickets_notif();
        $this->json_output([
            "arrNotif"=>$arrNotif
        ]);
    }

}
