<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('dashboard_model');
	}
	
	public function index(){				
		$this->load->library("menus");
		
		$main_header = $this->parser->parse('inc/main_header',[],true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);

		$this->data["title"] = "Dashboard";
		$this->data["ttlNeedApproval"] = formatNumber($this->dashboard_model->getTtlNeedApproval());
		$this->data["ttlIssuedRejected"] = formatNumber($this->dashboard_model->getTtlIssuedRejected());
		$this->data["ttlOurTickets"] = formatNumber($this->dashboard_model->getTtlOurTickets());
		$this->data["ttlIssuedApproved"] = formatNumber($this->dashboard_model->getTtlIssuedApproved());
		$this->data["ttlIssuedNeedRevision"] = formatNumber($this->dashboard_model->getTtlIssuedNeedRevision());
		$this->data["ttlIssuedAccepted"] = formatNumber($this->dashboard_model->getTtlIssuedAccepted());
		$this->data["ttlIssuedCompleted"] = formatNumber($this->dashboard_model->getTtlIssuedCompleted());

		$this->data["ttlReceivedApproved"] = formatNumber($this->dashboard_model->getTtlReceivedApproved());
		$this->data["ttlReceivedNeedRevision"] = formatNumber($this->dashboard_model->getTtlReceivedNeedRevision());
		$this->data["ttlReceivedAccepted"] = formatNumber($this->dashboard_model->getTtlReceivedAccepted());
		$this->data["ttlReceivedCompleted"] = formatNumber($this->dashboard_model->getTtlReceivedCompleted());

		$page_content = $this->parser->parse('pages/dashboard/dashboard', $this->data, true);
		$main_footer = $this->parser->parse('inc/main_footer', [], true);
		
		$control_sidebar = NULL;
		$this->data["MAIN_HEADER"] = $main_header;
		$this->data["MAIN_SIDEBAR"] = $main_sidebar;
		$this->data["PAGE_CONTENT"] = $page_content;
		$this->data["MAIN_FOOTER"] = $main_footer;
		$this->data["CONTROL_SIDEBAR"] = $control_sidebar;
		$this->parser->parse('template/main',$this->data);
	}
	
}