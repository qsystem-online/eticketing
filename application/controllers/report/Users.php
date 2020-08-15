<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Users extends MY_Controller
{
	public $layout_columns =[]; 

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model('vmodels/users_rpt_model');
		$this->load->model('msdepartments_model');
		$this->load->model('msbranches_model');
		$this->load->model('usersgroup_model');

		$this->layout_columns = [
            ['layout' => 1, 'label'=>'No.', 'value'=>'0', 'selected'=>false,'sum_total'=>false],
            ['layout' => 1, 'label'=>'ID', 'value'=>'1', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'User Name', 'value'=>'2', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Full Name', 'value'=>'3', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Gender', 'value'=>'4', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Email', 'value'=>'5', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Birth Date', 'value'=>'6', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Birth Place', 'value'=>'7', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Address', 'value'=>'8', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Phone', 'value'=>'9', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Branch', 'value'=>'10', 'selected'=>false,'sum_total'=>false],
			['layout' => 1, 'label'=>'Department', 'value'=>'11', 'selected'=>false,'sum_total'=>false],
            ['layout' => 1, 'label'=>'Group', 'value'=>'12', 'selected'=>false,'sum_total'=>false],
            ['layout' => 1, 'label'=>'Level', 'value'=>'13', 'selected'=>false,'sum_total'=>false],
            ['layout' => 1, 'label'=>'Admin', 'value'=>'14', 'selected'=>false,'sum_total'=>false],
		];

	}

	public function index()
	{
		$this->loadForm();
	}

	public function loadForm()
	{
        $this->load->library('menus');
        $this->load->model('msdepartments_model');
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
		

		$side_filter = $this->parser->parse('pages/reports/users/form',$this->data, true);
		$this->data['REPORT_FILTER'] = $side_filter;
		$this->data['TITLE'] = "USERS REPORT";
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
		$this->load->model('users_rpt_model');
		$this->form_validation->set_rules($this->users_rpt_model->getRules());
		$this->form_validation->set_error_delimiters('<div class="text-danger">* ', '</div>');

		if (!$this->form_validation->run() == FALSE) {
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
		//$dataReport = $this->tickets_rpt_model->queryComplete($data,"a.fst_ticket_no");
		//print_r($dataReport);die();
		$data = [
			"fin_branch_id" => $this->input->post("fin_branch_id"),
			"fin_department_id" => $this->input->post("fin_department_id"),
			"fin_group_id" => $this->input->post("fin_group_id"),
			"rpt_layout" => $this->input->post("rpt_layout"),
			"selected_columns" => array($this->input->post("selected_columns"))
		];
		
		//print_r($data['selected_columns'][0]);die;
		

		$dataReport = $this->users_rpt_model->queryComplete($data,"a.fin_user_id",$data['rpt_layout']);
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
						$repTitle = "USERS REPORT";
						$repPaperSize=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL;
                        $repOrientation=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE;
                        $fullColumn = 14;
						break;
					default:
						$repTitle = "USERS REPORT";
						$repPaperSize=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL;
                        $repOrientation=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE;
                        $fullColumn = 14;
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
					$sheet->setCellValue("B3", "ID");
					$sheet->setCellValue("C3", "User Name");
					$sheet->setCellValue("D3", "Full Name");
					$sheet->setCellValue("E3", "Gender");
					$sheet->setCellValue("F3", "Email");
					$sheet->setCellValue("G3", "Birth Date");
					$sheet->setCellValue("H3", "Birth Place");
					$sheet->setCellValue("I3", "Address");
					$sheet->setCellValue("J3", "Phone");
					$sheet->setCellValue("K3", "Branch");
					$sheet->setCellValue("L3", "Department");
                    $sheet->setCellValue("M3", "Group");
                    $sheet->setCellValue("N3", "Level");
                    $sheet->setCellValue("O3", "Admin");
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
                        $fst_level = $rw->fin_level;
                        switch($fst_level){
                            case 1:
                                $fst_level = "TOP MANAGEMENT";
                                break;
                            case 2:
                                $fst_level = "UPPER MANAGEMENT";
                                break;
                            case 3:
                                $fst_level = "MIDDLE MANAGEMENT";
                                break;
                            case 4:
                                $fst_level = "SUPERVISOR";
                                break;
                            case 5:
                                $fst_level = "LINE WORKERS";
                                break;
                            case 6:
                                $fst_level = "PUBLIC";
                                break;
                            case '':
                                $fst_level = "-";
                                break;
                        }
                        if ($rw->fbl_admin == 1){
                            $rw->fbl_admin = "ADMIN";
                        }else{
                            $rw->fbl_admin = "-";
                        }
						$nou++;
						$sheet->setCellValue("A$cellRow", $nou);
						//$sheet->setCellValue("A$cellRow", $no++);
						$sheet->setCellValue("B$cellRow", $rw->fin_user_id);
						$sheet->setCellValue("C$cellRow", $rw->fst_username);
						$sheet->setCellValue("D$cellRow", $rw->fst_fullname);
						$sheet->setCellValue("E$cellRow", $rw->fst_gender);
						$sheet->setCellValue("F$cellRow", $rw->fst_email);
						$sheet->setCellValue("G$cellRow", $rw->fdt_birthdate);
						$sheet->setCellValue("H$cellRow", $rw->fst_birthplace);
						$sheet->setCellValue("I$cellRow", $rw->fst_address);
						$sheet->setCellValue("J$cellRow", $rw->fst_phone);
						$sheet->setCellValue("K$cellRow", $rw->fst_branch_name);
						$sheet->setCellValue("L$cellRow", $rw->fst_department_name);
                        $sheet->setCellValue("M$cellRow", $rw->fst_group_name);
                        $sheet->setCellValue("N$cellRow", $fst_level);
                        $sheet->setCellValue("O$cellRow", $rw->fbl_admin);
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

				if ($isPreview != 1) {
					$this->phpspreadsheet->save("Users-Report.xls" ,$spreadsheet);
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