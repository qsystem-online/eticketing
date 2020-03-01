<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Monitoringticket extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('Monitoringticket_model');
        $this->load->model('servicelevel_model');
        $this->load->model('tickettype_model');
        $this->load->model('users_model');
    }

    public function index(){

		$this->load->library('menus');
        $this->list['page_name']="Monitoring Tiket";
        $this->list['list_name']="Monitoring Daftar Tiket";
        $this->list['addnew_ajax_url']=site_url().'document/add';
        $this->list['pKey']="id";
		$this->list['fetch_list_data_ajax_url']=site_url().'tr/monitoringticket/fetch_list_data';
        $this->list['delete_ajax_url']=site_url().'document/delete/';
        $this->list['edit_ajax_url']=site_url().'document/edit/';
        $this->list['arrSearch']=[
            'fin_ticket_id' => 'Ticket ID',
            'fst_ticket_no' => 'Ticket Number',
            'fst_memo' => 'Ticket Memo'
		];
		
		$this->list['breadcrumbs']=[
			['title'=>'Home','link'=>'#','icon'=>"<i class='fa fa-dashboard'></i>"],
			['title'=>'Monitoring Tiket','link'=>'#','icon'=>''],
			['title'=>'List','link'=> NULL ,'icon'=>''],
		];
		
		$this->list['columns']=[];
        //$main_header = $this->parser->parse('inc/main_header',[],true);
        //$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
        $page_content = $this->parser->parse('pages/tr/ticketstatus/monitoring',$this->list,true);
        $main_footer = $this->parser->parse('inc/main_footer',[],true);
        //$control_sidebar=null;
        //$this->data['ACCESS_RIGHT']="A-C-R-U-D-P";
        //$this->data['MAIN_HEADER'] = $main_header;
        //$this->data['MAIN_SIDEBAR']= $main_sidebar;
        $this->data['PAGE_CONTENT']= $page_content;
        $this->data['MAIN_FOOTER']= $main_footer;        
		$this->parser->parse('template/main',$this->data);
		
    }
    
    public function fetch_list_data()
    {
        $this->load->library("datatables");
        $user = $this->aauth->user();
        $deptActive = $user->fin_department_id;
		$this->datatables->setTableName("
			(
                SELECT a.*,b.fin_user_id,b.fst_username AS issuedBy,b.fin_department_id as produksi,c.fst_username AS issuedTo,d.fst_username AS Approved FROM trticket a 
                INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id
                INNER JOIN users c ON a.fin_issued_to_user_id = c.fin_user_id
                INNER JOIN users d ON a.fin_approved_by_user_id = d.fin_user_id
                WHERE b.fin_department_id = $deptActive
			) as a 
        ");

        $selectFields = "a.fin_ticket_id,a.fst_memo,a.issuedTo,a.Approved,a.fdt_ticket_datetime,a.fst_status";
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

	public function monitoringpengumuman(){
        $arrDepartment = $this->input->get('fin_dept_id');
        //var_dump($arrDepartment);
        //die();
        //$arrDepartment = ['2'];
        $this->load->model("monitoringticket_model");
        $arrPengumuman = $this->monitoringticket_model->get_pengumuman();
        $this->json_output($arrPengumuman);
    }

}
