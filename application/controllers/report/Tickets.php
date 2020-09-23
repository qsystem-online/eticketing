<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tickets extends MY_Controller
{
	public $layout_columns =[]; 

	public function __construct()
	{
		parent::__construct();
		if (!$this->aauth->is_permit("report")){
            show_404();
        }

		$this->load->library('form_validation');
		$this->load->model('vmodels/tickets_rpt_model');
        $this->load->model('users_model');
		$this->load->model('msdepartments_model');
		$this->load->model('msbranches_model');
		$this->load->model('usersgroup_model');
		$this->load->model('tickettype_model');

		$this->layout_columns = [
            ['layout' => 1, 'label'=>'No.', 'value'=>'0', 'selected'=>false,'sum_total'=>false],
            ['layout' => 1, 'label'=>'Ticket Number', 'value'=>'1', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Datetime', 'value'=>'2', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Issued By', 'value'=>'3', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Issued To', 'value'=>'4', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Approved By', 'value'=>'5', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Ticket Type', 'value'=>'6', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Memo', 'value'=>'7', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Deadline', 'value'=>'8', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Expiry', 'value'=>'9', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Last Status', 'value'=>'10', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Service Level', 'value'=>'11', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'S/L Days', 'value'=>'12', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Before Last status', 'value'=>'13', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Memo Before Last status', 'value'=>'14', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Nou.', 'value'=>'0', 'selected'=>false,'sum_total'=>false],
            ['layout' => 2, 'label'=>'Department', 'value'=>'1', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Group', 'value'=>'2', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'User', 'value'=>'3', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Ticket Type', 'value'=>'4', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Issued', 'value'=>'5', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Accepted', 'value'=>'6', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Closed', 'value'=>'7', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Acceptance Expired', 'value'=>'8', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Ticket Expired', 'value'=>'9', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Approval Expired', 'value'=>'10', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Rejected', 'value'=>'11', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Void', 'value'=>'12', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Issued', 'value'=>'13', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Accepted', 'value'=>'14', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Closed', 'value'=>'15', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Acceptance Expired', 'value'=>'16', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Ticket Expired', 'value'=>'17', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Approval Expired', 'value'=>'18', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Rejected', 'value'=>'19', 'selected'=>false,'sum_total'=>false],
			['layout' => 2, 'label'=>'Void', 'value'=>'20', 'selected'=>false,'sum_total'=>false],
			['layout' => 3, 'label'=>'Nou.', 'value'=>'0', 'selected'=>false,'sum_total'=>false],
			['layout' => 3, 'label'=>'Ticket No', 'value'=>'1', 'selected'=>false,'sum_total'=>false],
			['layout' => 3, 'label'=>'Ticket Type', 'value'=>'2', 'selected'=>false,'sum_total'=>false],
			['layout' => 3, 'label'=>'Service Level', 'value'=>'3', 'selected'=>false,'sum_total'=>false],
			['layout' => 3, 'label'=>'S/L Days', 'value'=>'4', 'selected'=>false,'sum_total'=>false],
			['layout' => 3, 'label'=>'Issued Date', 'value'=>'5', 'selected'=>false,'sum_total'=>false],
			['layout' => 3, 'label'=>'Issued by', 'value'=>'6', 'selected'=>false,'sum_total'=>false],
			['layout' => 3, 'label'=>'Issued to', 'value'=>'7', 'selected'=>false,'sum_total'=>false],
			['layout' => 3, 'label'=>'Approved by', 'value'=>'8', 'selected'=>false,'sum_total'=>false],
			['layout' => 3, 'label'=>'Approved', 'value'=>'9', 'selected'=>false,'sum_total'=>false],
			['layout' => 3, 'label'=>'Accepted', 'value'=>'10', 'selected'=>false,'sum_total'=>false],
			['layout' => 3, 'label'=>'Completed', 'value'=>'11', 'selected'=>false,'sum_total'=>false],
			['layout' => 3, 'label'=>'Closed', 'value'=>'12', 'selected'=>false,'sum_total'=>false],
			['layout' => 3, 'label'=>'Completion Revised', 'value'=>'13', 'selected'=>false,'sum_total'=>false],
		];

	}

	public function index()
	{
		if (!$this->aauth->is_permit("report")){
            show_404();
		}
		$this->loadForm();
	}

	public function loadForm()
	{
		$this->load->library('menus');
		$this->load->model('tickettype_model');
		$this->load->model('usersgroup_model');
		$this->load->model('msbranches_model');
						
		$main_header = $this->parser->parse('inc/main_header', [], true);
		$fin_branch_id = 0;

		$this->data["fin_branch_id"] = $fin_branch_id;
		$this->data["mystatus"]="OK";
		$this->data["layout_columns"] = $this->layout_columns;

		//$this->data["linebusinessList"] =$this->mslinebusiness_model->get_data_linebusiness();
		//$this->load->model("mslinebusiness_model");
        //$strLineBussiness =  "1,2,3";
        //echo $this->mslinebusiness_model->getSetName($strLineBussiness,"<br>");
        //return;
		

		$side_filter = $this->parser->parse('pages/reports/tickets/form',$this->data, true);
		$this->data['REPORT_FILTER'] = $side_filter;
		$this->data['TITLE'] = "TICKET REPORT";
		$mode = "Report";
		$report_filterbar = $this->parser->parse('inc/report_filterbar', $this->data, true);
		$main_sidebar = $this->parser->parse('inc/main_sidebar', [], true);
		$page_content = null; // $this->parser->parse('template/standardList', $this->list, true);
		$main_footer = $this->parser->parse('inc/main_footer', [], true);
		$control_sidebar = null;
		$this->data['ACCESS_RIGHT'] = "A-C-R-U-D-P";
		$this->data['MAIN_HEADER'] = $main_header;
		$this->data['MAIN_SIDEBAR'] = $main_sidebar;
		$this->data['REPORT_FILTERBAR'] = $report_filterbar;
		$this->data['REPORT_CONTENT'] = $page_content;
		$this->data['REPORT_FOOTER'] = $main_footer;
		$this->parser->parse('template/mainReport', $this->data);
	}

	//function ini untuk validasi form parameter report (jika ada parameter yg tidak boleh di kosongkan
	//sesuai di model)
	public function process()
	{
		// print_r('testing ajx-process');
		$this->load->model('tickets_rpt_model');
		$this->form_validation->set_rules($this->tickets_rpt_model->getRules());
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');

		if ($this->form_validation->run() == FALSE) {
			//print_r($this->form_validation->error_array());
			$this->ajxResp["status"] = "VALIDATION_FORM_FAILED";
			$this->ajxResp["message"] = "Error Validation Forms";
			$this->ajxResp["data"] = $this->form_validation->error_array();
			$this->json_output();
			return;
		}


		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["message"] = "";
		$this->ajxResp["data"] = "";
		$this->json_output();        
		
	}

	public function get_branch(){
		$term = $this->input->get("term");
		$ssql = "SELECT fin_branch_id, fst_branch_name from msbranches where fst_branch_name like ?";
		$qr = $this->db->query($ssql,['%'.$term.'%']);
		$rs = $qr->result();
		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["data"] = $rs;
		$this->json_output();
	}
	public function get_department(){
		$term = $this->input->get("term");
		$ssql = "SELECT fin_department_id, fst_department_name from departments where fst_department_name like ?";
		$qr = $this->db->query($ssql,['%'.$term.'%']);
		$rs = $qr->result();
		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["data"] = $rs;
		$this->json_output();
	}

	public function get_usergroup(){
		$term = $this->input->get("term");
		$ssql = "SELECT fin_group_id, fst_group_name from usersgroup where fst_group_name like ?";
		$qr = $this->db->query($ssql,['%'.$term.'%']);
		$rs = $qr->result();
		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["data"] = $rs;
		$this->json_output();
	}

	public function get_userId(){
		$term = $this->input->get("term");
		$ssql = "SELECT fin_user_id, fst_username from users where fst_username like ?";
		$qr = $this->db->query($ssql,['%'.$term.'%']);
		$rs = $qr->result();
		$this->ajxResp["status"] = "SUCCESS";
		$this->ajxResp["data"] = $rs;
		$this->json_output();
	}


	public function generateExcel($isPreview = 1) {
		$this->load->library("phpspreadsheet");
		// print_r("Hallo");print_r($data);die();
		//$dataReport = $this->tickets_rpt_model->queryCompleteAdmin($data,"a.fst_ticket_no");
		//print_r($dataReport);die();
		$data = [
			"fin_branch_id" => $this->input->post("fin_branch_id"),
			"fin_department_id" => $this->input->post("fin_department_id"),
			"fin_group_id" => $this->input->post("fin_group_id"),
			"fin_user_id" => $this->input->post("fin_user_id"),
			"fin_ticket_type_id" => $this->input->post("fin_ticket_type_id"),
			"fdt_ticket_datetime" => $this->input->post("fdt_ticket_datetime"),
			"fdt_ticket_datetime2" => $this->input->post("fdt_ticket_datetime2"),
			"rpt_layout" => $this->input->post("rpt_layout"),
			"selected_columns" => array($this->input->post("selected_columns"))
		];
		
		//print_r($data['selected_columns'][0]);die;
		

		$dataReport = $this->tickets_rpt_model->queryCompleteAdmin($data,"a.fst_ticket_no",$data['rpt_layout']);
		//print_r($dataReport);die();

		$arrMerged = [];  //row,ttlColType(full,sum)
		if (isset($dataReport)) {
			if ($dataReport==[]) {
				print_r("Data Not Found!");
			}else {
				$repTitle = "";
		
				$spreadsheet = $this->phpspreadsheet->load();
				$sheet = $spreadsheet->getActiveSheet();								
				$repPaperSize=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
				$repOrientation=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT;
				switch ($data['rpt_layout']){
					case "1":
						$repTitle = "LAPORAN DAFTAR TICKET";
						$repPaperSize=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL;
                        $repOrientation=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE;
                        $fullColumn = 14;
						break;
					case "2":
						$repTitle = "PER-USER TICKET SUMMARY";
						$repPaperSize=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL;
						$repOrientation=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE;
						$fullColumn = 21;
						break;
					default:
						$repTitle = "PER-TICKET S/L DAYS";
						$repPaperSize=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL;
                        $repOrientation=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE;
                        $fullColumn = 13;
						break;
				}	

				$spreadsheet->getProperties()->setCreator('QSystem - Indonesia')
				->setLastModifiedBy('Developer team')
				->setTitle($repTitle)
				->setSubject($repTitle)
				->setDescription($repTitle)
				->setKeywords('office 2007 openxml php')
				->setCategory('report file');
		
				$spreadsheet->getActiveSheet()->getPageSetup()
					->setOrientation($repOrientation);
				$spreadsheet->getActiveSheet()->getPageSetup()
					->setPaperSize($repPaperSize);
							
				// $spreadsheet->getActiveSheet()->getHeaderFooter()
				// ->setOddHeader('&C&HPlease treat this document as confidential!');
				
				$spreadsheet->getActiveSheet()->getHeaderFooter()
				->setOddFooter('&L&B' . $spreadsheet->getProperties()->getTitle() .date('d-m-Y H') . '-' . '&RPage &P of &N');
				$spreadsheet->getActiveSheet()->setTitle('Report Excel '.date('d-m-Y H'));
		
				$sheet->getPageSetup()->setFitToWidth(0);
				$sheet->getPageSetup()->setFitToHeight(0);
				$sheet->getPageMargins()->setTop(0.5);
				$sheet->getPageMargins()->setRight(0.5);
				$sheet->getPageMargins()->setLeft(0.5);
				$sheet->getPageMargins()->setBottom(0.5);
		
				$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
				$spreadsheet->getDefaultStyle()->getFont()->setSize(24);
				$sheet->setCellValue("A1", $repTitle);
				
				//$sheet->mergeCells('A1:L1');                
				$arrMerged[] = [1,"FULL"];

				$spreadsheet->getDefaultStyle()->getFont()->setName('Arial');
				$spreadsheet->getDefaultStyle()->getFont()->setSize(10);
				
				//ini contoh report layout 1 az yang sudah dibuat
				if  ($data['rpt_layout'] ==  1){
					$sheet->setCellValue("A3", "No.");
					$sheet->setCellValue("B3", "Ticket No");
					$sheet->setCellValue("C3", "Datetime");
					$sheet->setCellValue("D3", "Issued By");
					$sheet->setCellValue("E3", "Issued To");
					$sheet->setCellValue("F3", "Approved By");
					$sheet->setCellValue("G3", "Ticket Type");
					$sheet->setCellValue("H3", "Memo");
					$sheet->setCellValue("I3", "Deadline");
					$sheet->setCellValue("J3", "Expiry");
					$sheet->setCellValue("K3", "Last Status");
					$sheet->setCellValue("L3", "Service Level");
					$sheet->setCellValue("M3", "S/L Days");
					$sheet->setCellValue("N3", "Before Last status");
					$sheet->setCellValue("O3", "Memo Before Last status");
                    $sheet->getColumnDimension("A")->setAutoSize(false);
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
					$nou = 0;
					$cellRow = 4;
					$numOfRecs = count($dataReport);

					foreach ($dataReport as $rw) {

						$nou++;
						$fin_ticket_id = $rw->fin_ticket_id;
						$sheet->setCellValue("A$cellRow", $nou);
						//$sheet->setCellValue("A$cellRow", $no++);
						$sheet->setCellValue("B$cellRow", $rw->fst_ticket_no);
						$sheet->setCellValue("C$cellRow", $rw->fdt_ticket_datetime);
						$sheet->setCellValue("D$cellRow", $rw->issuedBy);
						$sheet->setCellValue("E$cellRow", $rw->issuedTo);
						$sheet->setCellValue("F$cellRow", $rw->approvedBy);
						$sheet->setCellValue("G$cellRow", $rw->fst_ticket_type_name);
						$sheet->setCellValue("H$cellRow", $rw->fst_memo);
						$sheet->setCellValue("I$cellRow", $rw->fdt_deadline_datetime);
						$sheet->setCellValue("J$cellRow", $rw->fdt_deadline_extended_datetime);
						$sheet->setCellValue("K$cellRow", $rw->fst_status);
						$sheet->setCellValue("L$cellRow", $rw->fst_service_level_name);
						$sheet->setCellValue("M$cellRow", $rw->fin_service_level_days);

						$ssql = "SELECT * FROM
						(SELECT * FROM trticket_log WHERE fin_ticket_id = ? ORDER BY fin_rec_id DESC LIMIT 2) a                   
						ORDER BY fin_rec_id ASC LIMIT 1";
						$qr = $this->db->query($ssql,[$fin_ticket_id]);
						//echo $this->db->last_query();
						//die();
						$rwLog = $qr->row();

						$sheet->setCellValue("N$cellRow", $rwLog->fst_status);
						$sheet->setCellValue("O$cellRow", $rwLog->fst_status_memo);
						$cellRow++;
						
					}
					

					$styleArray = [
						'borders' => [
							'allBorders' => [
								//https://phpoffice.github.io/PhpSpreadsheet/1.1.0/PhpOffice/PhpSpreadsheet/Style/Border.html
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE
							],
						],
					];
					//$sheet->getStyle('A1:L'.$cellRow)->applyFromArray($styleArray);
					//$sheet->getStyle('A1:IV65536'.$cellRow)->applyFromArray($styleArray);
					$sheet->setShowGridlines(false);
					//BORDER
					$styleArray = [
						'borders' => [
							'allBorders' => [
								//https://phpoffice.github.io/PhpSpreadsheet/1.1.0/PhpOffice/PhpSpreadsheet/Style/Border.html
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
							],
						],
					];
					$sheet->getStyle('A3:O'.$cellRow)->applyFromArray($styleArray);
		
					//FONT BOLD & Center
					$styleArray = [
						'font' => [
							'bold' => true,
						],
						'alignment' => [
							'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
						]
					];
					// $sheet->getStyle('A2')->applyFromArray($styleArray);
					$sheet->getStyle('A3:O3')->applyFromArray($styleArray);
					$sheet->getStyle('A3:A'.$cellRow)->applyFromArray($styleArray);

					$styleArray = [
						'numberFormat'=> [
							'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
						]
					];
					$sheet->getStyle('T4:T'.$cellRow)->applyFromArray($styleArray);
					//$sheet->getStyle('L4:M'.$cellRow)->applyFromArray($styleArray);

					//$styleArray = [
					//	'numberFormat'=> [
					//		'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
					//	]
					//];
					//$sheet->getStyle('H4:H'.$cellRow)->applyFromArray($styleArray);
					//$sheet->getStyle('J4:L'.$cellRow)->applyFromArray($styleArray);
					$styleArray = [
						'numberFormat'=> [
							'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY
						]
					];
					$sheet->getStyle('F4:F'.$cellRow)->applyFromArray($styleArray);

					$styleArray = [
						'font' => [
							'bold' => true,
							'size' => 24,
						],
					
					];
					$sheet->getStyle('A1')->applyFromArray($styleArray);

					$ttlSelectedCol = sizeof($data['selected_columns'][0]);
					$sumCol = $this->phpspreadsheet->getSumColPosition($this->layout_columns,$data['rpt_layout'],$data['selected_columns'][0]);
					$this->phpspreadsheet->cleanColumns($sheet,$fullColumn,$data['selected_columns'][0]);
					$this->phpspreadsheet->mergedData($sheet,$arrMerged,$ttlSelectedCol,$sumCol);

				} //end if layout 1
				if  ($data['rpt_layout'] ==  2){
					$sheet->setCellValue("F2", "Ticket Issued");
					$sheet->mergeCells('F2:M2'); 
					$sheet->setCellValue("N2", "Ticket Received");
					$sheet->mergeCells('N2:U2');
                    $sheet->setCellValue("A3","Nou.");
                    $sheet->setCellValue("B3","Department");
                    $sheet->setCellValue("C3","Group");
                    $sheet->setCellValue("D3","User");
                    $sheet->setCellValue("E3","Ticket Type");
                    $sheet->setCellValue("F3","Issued");
                    $sheet->setCellValue("G3","Accepted");
                    $sheet->setCellValue("H3","Closed");
                    $sheet->setCellValue("I3","Acceptance Expired");
                    $sheet->setCellValue("J3","Ticket Expired");
                    $sheet->setCellValue("K3","Approval Expired");
					$sheet->setCellValue("L3","Rejected");
					$sheet->setCellValue("M3","Void");
                    $sheet->setCellValue("N3","Issued");
                    $sheet->setCellValue("O3","Accepted");
                    $sheet->setCellValue("P3","Closed");
                    $sheet->setCellValue("Q3","Acceptance Expired");
                    $sheet->setCellValue("R3","Ticket Expired");
                    $sheet->setCellValue("S3","Approval Expired");
					$sheet->setCellValue("T3","Rejected");
					$sheet->setCellValue("U3","Void");
                    $sheet->getColumnDimension("A")->setAutoSize(false);
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
                    $sheet->getColumnDimension("T")->setAutoSize(true);
                    $sheet->getColumnDimension("U")->setAutoSize(true);
					$no = 1;
					$cellRow = 4;
					$numOfRecs = count($dataReport);
					$idx = 0;
					$userTicket ="";
					$ticketType ="";
					$ticketTypeID = "";
					$start_date = "";
					$end_date = "";
					if (isset($data['fdt_ticket_datetime'])) { $start_date = $data['fdt_ticket_datetime'];}
					if (isset($data['fdt_ticket_datetime2'])) { $end_date = $data['fdt_ticket_datetime2'];}
					
					foreach ($dataReport as $rw) {

						//$sheet->setCellValue("B$cellRow0", $user_id." s/d ".$user_id);
						//$sheet->setCellValue("B$cellRow1", $user_id);
						//$sheet->setCellValue("B$cellRow2", $user_id);
						//$sheet->setCellValue("A$cellRow", $no++);
						if ($rw->fst_username != ""){
							if ($userTicket != $rw->userTicket){
				
								$userTicket = $rw->userTicket;
								$sheet->setCellValue("A$cellRow", $no++);
								$sheet->setCellValue("B$cellRow", $rw->fst_department_name);
								$sheet->setCellValue("C$cellRow", $rw->fst_group_name);
								$sheet->setCellValue("D$cellRow", $rw->fst_username);
				
								$ssql = "select * from mstickettype";
								$qr = $this->db->query($ssql, []);
								$rsType = $qr->result();
					
								foreach ($rsType as $roType){
				
									$ticketTypeID = $roType->fin_ticket_type_id;
									$start_date =date('Y-m-d', strtotime($start_date));
									$end_date =date('Y-m-d 23:59:59', strtotime($end_date));
									$ttl_issuedStatus = 0;
									$ttl_receivedStatus = 0;
									$ttl_allStatus = 0;
									$ssql = "SELECT fin_issued_by_user_id,fin_ticket_type_id,fst_status,COUNT(*) AS ttl FROM trticket WHERE fin_issued_by_user_id=? AND  fin_ticket_type_id=? AND fdt_ticket_datetime >=? AND fdt_ticket_datetime <=? GROUP BY fst_status";
									$qr = $this->db->query($ssql, [$userTicket,$ticketTypeID,$start_date,$end_date]);
									//echo $this->db->last_query();
									//die();
									$rsIssued = $qr->result();
									$issuedOpen = 0;
									$issuedAccepted = 0;
									$issuedClosed = 0;
									$issuedAExpired = 0;
									$issuedTExpired = 0;
									$issuedAppExpired = 0;
									$issuedRejected = 0;
									$issuedVoid = 0;
									foreach ($rsIssued as $roIssued){
										if ($roIssued->fst_status == "APPROVED/OPEN" OR $roIssued->fst_status == "NEED_APPROVAL"){
											$issuedOpen = $roIssued->ttl;
										}
										if ($roIssued->fst_status == "ACCEPTED"){
											$issuedAccepted = $roIssued->ttl;
										}
										if ($roIssued->fst_status == "CLOSED"){
											$issuedClosed = $roIssued->ttl;
										}
										if ($roIssued->fst_status == "ACCEPTANCE_EXPIRED"){
											$issuedAExpired = $roIssued->ttl;
										}
										if ($roIssued->fst_status == "TICKET_EXPIRED"){
											$issuedTExpired = $roIssued->ttl;
										}
										if ($roIssued->fst_status == "APPROVAL_EXPIRED"){
											$issuedAppExpired = $roIssued->ttl;
										}
										if ($roIssued->fst_status == "REJECTED"){
											$issuedRejected = $roIssued->ttl;
										}
										if ($roIssued->fst_status == "VOID"){
											$issuedVoid = $roIssued->ttl;
										}
									}
									$ssql = "SELECT fin_issued_to_user_id,fin_ticket_type_id,fst_status,COUNT(*) AS ttl FROM trticket WHERE fin_issued_to_user_id=? AND  fin_ticket_type_id=? AND fdt_ticket_datetime >=? AND fdt_ticket_datetime <=? GROUP BY fst_status";
									$qr = $this->db->query($ssql, [$userTicket,$ticketTypeID,$start_date,$end_date]);
									//echo $this->db->last_query();
									//die();
									$rsReceived= $qr->result();
									$receivedOpen = 0;
									$receivedAccepted = 0;
									$receivedClosed = 0;
									$receivedAExpired = 0;
									$receivedTExpired = 0;
									$receivedAppExpired = 0;
									$receivedRejected = 0;
									$receivedVoid = 0;
									foreach ($rsReceived as $roReceived){
										if ($roReceived->fst_status == "APPROVED/OPEN" OR $roReceived->fst_status == "NEED_APPROVAL"){
											$receivedOpen = $roReceived->ttl;
											//$sheet->setCellValue("M$cellRow", $roReceived->ttl);
										}
										if ($roReceived->fst_status == "ACCEPTED"){
											$receivedAccepted = $roReceived->ttl;
											//$sheet->setCellValue("N$cellRow", $roReceived->ttl);
										}
										if ($roReceived->fst_status == "CLOSED"){
											$receivedClosed = $roReceived->ttl;
											//$sheet->setCellValue("O$cellRow", $roReceived->ttl);
										}
										if ($roReceived->fst_status == "ACCEPTANCE_EXPIRED"){
											$receivedAExpired = $roReceived->ttl;
											//$sheet->setCellValue("P$cellRow", $roReceived->ttl);
										}
										if ($roReceived->fst_status == "TICKET_EXPIRED"){
											$receivedTExpired = $roReceived->ttl;
											//$sheet->setCellValue("Q$cellRow", $roReceived->ttl);
										}
										if ($roReceived->fst_status == "APPROVAL_EXPIRED"){
											$receivedAppExpired = $roReceived->ttl;
											//$sheet->setCellValue("Q$cellRow", $roReceived->ttl);
										}
										if ($roReceived->fst_status == "REJECTED"){
											$receivedRejected = $roReceived->ttl;
											//$sheet->setCellValue("R$cellRow", $roReceived->ttl);
										}
										if ($roReceived->fst_status == "VOID"){
											$receivedVoid = $roReceived->ttl;
											//$sheet->setCellValue("S$cellRow", $roReceived->ttl);
										}
									}
									$ttl_issuedStatus += $issuedOpen + $issuedAccepted + $issuedClosed + $issuedAExpired + $issuedTExpired + $issuedRejected + $issuedVoid + $issuedAppExpired;
									$ttl_receivedStatus += $receivedOpen + $receivedAccepted + $receivedClosed + $receivedAExpired + $receivedTExpired + $receivedRejected + $receivedVoid + $receivedAppExpired;
									$ttl_allStatus += $ttl_issuedStatus + $ttl_receivedStatus;
									//echo ($ttl_issuedStatus);
									//die();
									if($ttl_allStatus != 0 ){
										$sheet->setCellValue("E$cellRow", $roType->fst_ticket_type_name);
										$sheet->setCellValue("F$cellRow", $issuedOpen);
										$sheet->setCellValue("G$cellRow", $issuedAccepted);
										$sheet->setCellValue("H$cellRow", $issuedClosed);
										$sheet->setCellValue("I$cellRow", $issuedAExpired);
										$sheet->setCellValue("J$cellRow", $issuedTExpired);
										$sheet->setCellValue("K$cellRow", $issuedAppExpired);
										$sheet->setCellValue("L$cellRow", $issuedRejected);
										$sheet->setCellValue("M$cellRow", $issuedVoid);
										$sheet->setCellValue("N$cellRow", $receivedOpen);
										$sheet->setCellValue("O$cellRow", $receivedAccepted);
										$sheet->setCellValue("P$cellRow", $receivedClosed);
										$sheet->setCellValue("Q$cellRow", $receivedAExpired);
										$sheet->setCellValue("R$cellRow", $receivedTExpired);
										$sheet->setCellValue("S$cellRow", $receivedAppExpired);
										$sheet->setCellValue("T$cellRow", $receivedRejected);
										$sheet->setCellValue("U$cellRow", $receivedVoid);
										$cellRow++;
									}
									//$cellRow++;
								}
							}
						}	
					}
					

					$styleArray = [
						'borders' => [
							'allBorders' => [
								//https://phpoffice.github.io/PhpSpreadsheet/1.1.0/PhpOffice/PhpSpreadsheet/Style/Border.html
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE
							],
						],
					];
					//$sheet->getStyle('A1:L'.$cellRow)->applyFromArray($styleArray);
					//$sheet->getStyle('A1:IV65536'.$cellRow)->applyFromArray($styleArray);
					$sheet->setShowGridlines(false);
					//BORDER
					$styleArray = [
						'borders' => [
							'allBorders' => [
								//https://phpoffice.github.io/PhpSpreadsheet/1.1.0/PhpOffice/PhpSpreadsheet/Style/Border.html
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
							],
						],
					];
					$sheet->getStyle('F2:M2')->applyFromArray($styleArray);
					$sheet->getStyle('N2:U2')->applyFromArray($styleArray);
					$sheet->getStyle('A3:U'.$cellRow)->applyFromArray($styleArray);
		
					//FONT BOLD & Center
					$styleArray = [
						'font' => [
							'bold' => true,
						],
						'alignment' => [
							'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
						]
					];
					$sheet->getStyle('F2:M2')->applyFromArray($styleArray);
					$sheet->getStyle('N2:U2')->applyFromArray($styleArray);
					$sheet->getStyle('A3:U3')->applyFromArray($styleArray);
					$sheet->getStyle('A3:A'.$cellRow)->applyFromArray($styleArray);

					/*$styleArray = [
						'numberFormat'=> [
							'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
						]
					];
					$sheet->getStyle('T4:T'.$cellRow)->applyFromArray($styleArray);*/
					//$sheet->getStyle('L4:M'.$cellRow)->applyFromArray($styleArray);

					//$styleArray = [
					//	'numberFormat'=> [
					//		'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
					//	]
					//];
					//$sheet->getStyle('H4:H'.$cellRow)->applyFromArray($styleArray);
					//$sheet->getStyle('J4:L'.$cellRow)->applyFromArray($styleArray);
					/*$styleArray = [
						'numberFormat'=> [
							'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY
						]
					];
					$sheet->getStyle('F4:F'.$cellRow)->applyFromArray($styleArray);*/

					$styleArray = [
						'font' => [
							'bold' => true,
							'size' => 24,
						],
					
					];
					$sheet->getStyle('A1')->applyFromArray($styleArray);

					$ttlSelectedCol = sizeof($data['selected_columns'][0]);
					$sumCol = $this->phpspreadsheet->getSumColPosition($this->layout_columns,$data['rpt_layout'],$data['selected_columns'][0]);
					$this->phpspreadsheet->cleanColumns($sheet,$fullColumn,$data['selected_columns'][0]);
					$this->phpspreadsheet->mergedData($sheet,$arrMerged,$ttlSelectedCol,$sumCol);

				} //End Of Layout 2
				if  ($data['rpt_layout'] ==  3){
					$sheet->setCellValue("J2", "Days");
					$sheet->mergeCells('J2:M2');
					$sheet->setCellValue("A3", "No.");
					$sheet->setCellValue("B3", "Ticket No");
					$sheet->setCellValue("C3", "Ticket Type");
					$sheet->setCellValue("D3", "Service Level");
					$sheet->setCellValue("E3", "S/L Days");
					$sheet->setCellValue("F3", "Issued Date");
					$sheet->setCellValue("G3", "Issued by");
					$sheet->setCellValue("H3", "Issued to");
					$sheet->setCellValue("I3", "Approved by");
					$sheet->setCellValue("J3", "Approved");
					$sheet->setCellValue("K3", "Accepted");
					$sheet->setCellValue("L3", "Completed");
					$sheet->setCellValue("M3", "Closed");
					$sheet->setCellValue("N3", "Completion Revised");
                    $sheet->getColumnDimension("A")->setAutoSize(false);
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
					$no = 1;
					$cellRow = 4;
					$numOfRecs = count($dataReport);
					
					foreach ($dataReport as $rw) {

						$sheet->setCellValue("A$cellRow", $no++);
						$sheet->setCellValue("B$cellRow", $rw->fst_ticket_no);
						$sheet->setCellValue("C$cellRow", $rw->fst_ticket_type_name);
						$sheet->setCellValue("D$cellRow", $rw->fst_service_level_name);
						$sheet->setCellValue("E$cellRow", $rw->fin_service_level_days);
						$sheet->setCellValue("F$cellRow", $rw->fdt_ticket_datetime);
						$sheet->setCellValue("G$cellRow", $rw->userIssued);
						$sheet->setCellValue("H$cellRow", $rw->userReceived);
						$sheet->setCellValue("I$cellRow", $rw->userApproved);
						$ssql = "SELECT a.fin_ticket_id,a.fdt_ticket_datetime,b.fdt_status_datetime,b.fst_status,DATEDIFF(b.fdt_status_datetime,a.fdt_ticket_datetime) + 0 AS Days FROM trticket a 
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
						$ssql = "SELECT fin_ticket_id,fst_status,COUNT(*) AS ttl_completion_revised FROM trticket_log  WHERE fin_ticket_id=? AND fst_status ='NEED_REVISION' GROUP BY fin_ticket_id";
						$qr = $this->db->query($ssql, [$rw->fin_ticket_id]);
						$rw = $qr->row();
						if ($rw != null){
							$completionRevised = $rw->ttl_completion_revised;
						}else{
							$completionRevised = 0;
						}
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
						$sheet->setCellValue("J$cellRow", $approvedDay);
						$sheet->setCellValue("K$cellRow", $acceptedDay);
						$sheet->setCellValue("L$cellRow", $completedDay);
						$sheet->setCellValue("M$cellRow", $closedDay);
						$sheet->setCellValue("N$cellRow", $completionRevised);
						$cellRow++;
						
					}
					

					$styleArray = [
						'borders' => [
							'allBorders' => [
								//https://phpoffice.github.io/PhpSpreadsheet/1.1.0/PhpOffice/PhpSpreadsheet/Style/Border.html
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_NONE
							],
						],
					];
					//$sheet->getStyle('A1:L'.$cellRow)->applyFromArray($styleArray);
					//$sheet->getStyle('A1:IV65536'.$cellRow)->applyFromArray($styleArray);
					$sheet->setShowGridlines(false);
					//BORDER
					$styleArray = [
						'borders' => [
							'allBorders' => [
								//https://phpoffice.github.io/PhpSpreadsheet/1.1.0/PhpOffice/PhpSpreadsheet/Style/Border.html
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN
							],
						],
					];
					$sheet->getStyle('J2:M2')->applyFromArray($styleArray);
					$sheet->getStyle('A3:N'.$cellRow)->applyFromArray($styleArray);
		
					//FONT BOLD & Center
					$styleArray = [
						'font' => [
							'bold' => true,
						],
						'alignment' => [
							'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
						]
					];
					$sheet->getStyle('J2:M2')->applyFromArray($styleArray);
					$sheet->getStyle('A3:N3')->applyFromArray($styleArray);
					$sheet->getStyle('A3:A'.$cellRow)->applyFromArray($styleArray);

					/*$styleArray = [
						'numberFormat'=> [
							'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
						]
					];
					$sheet->getStyle('T4:T'.$cellRow)->applyFromArray($styleArray);*/
					//$sheet->getStyle('L4:M'.$cellRow)->applyFromArray($styleArray);

					//$styleArray = [
					//	'numberFormat'=> [
					//		'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1
					//	]
					//];
					//$sheet->getStyle('H4:H'.$cellRow)->applyFromArray($styleArray);
					//$sheet->getStyle('J4:L'.$cellRow)->applyFromArray($styleArray);
					/*$styleArray = [
						'numberFormat'=> [
							'formatCode' => \PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY
						]
					];
					$sheet->getStyle('F4:F'.$cellRow)->applyFromArray($styleArray);*/

					$styleArray = [
						'font' => [
							'bold' => true,
							'size' => 24,
						],
					
					];
					$sheet->getStyle('A1')->applyFromArray($styleArray);

					$ttlSelectedCol = sizeof($data['selected_columns'][0]);
					$sumCol = $this->phpspreadsheet->getSumColPosition($this->layout_columns,$data['rpt_layout'],$data['selected_columns'][0]);
					$this->phpspreadsheet->cleanColumns($sheet,$fullColumn,$data['selected_columns'][0]);
					$this->phpspreadsheet->mergedData($sheet,$arrMerged,$ttlSelectedCol,$sumCol);

				} //End Of Layout 3

				if ($isPreview != 1) {
					$this->phpspreadsheet->save("Ticket-Report.xls" ,$spreadsheet);
					// $this->phpspreadsheet->savePDF();
				}else {
					//$this->phpspreadsheet->savePDF();
					$this->phpspreadsheet->saveHTMLvia($spreadsheet);    
				}
			}
		}else {
			print_r("Data Not Found !");
		}
    }
}