<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Deleteticket extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        if (!$this->aauth->is_permit("clear_ticket")){
            show_404();
		}
        $this->load->library('form_validation');
        $this->load->model('ticketstatus_model');
    }

    public function index(){

		$this->load->library('menus');
        $this->list['page_name']="Delete Tiket";
        $this->list['pKey']="id";
        $this->list['arrSearch']=[];
		
		$this->list['breadcrumbs']=[
			['title'=>'Home','link'=>'#','icon'=>"<i class='fa fa-dashboard'></i>"],
			['title'=>'Monitoring Tiket','link'=>'#','icon'=>''],
			['title'=>'List','link'=> NULL ,'icon'=>''],
		];
		
		$this->list['columns']=[];
        $main_header = $this->parser->parse('inc/main_header',[],true);
        $main_sidebar = $this->parser->parse('inc/main_sidebar',[],true);
        $page_content = $this->parser->parse('pages/tr/ticketstatus/delete',$this->list,true);
        $main_footer = $this->parser->parse('inc/main_footer',[],true);
        $control_sidebar = "";
        $control_sidebar = null;
        $this->data['ACCESS_RIGHT']="A-C-R-U-D-P";
        $this->data['MAIN_HEADER'] = $main_header;
        $this->data['MAIN_SIDEBAR']= $main_sidebar;
        $this->data['PAGE_CONTENT']= $page_content;
        $this->data['MAIN_FOOTER']= $main_footer;        
        $this->parser->parse('template/main',$this->data);
		
    }

    public function ajx_delete_ticket(){
		$data = [
			"fst_status" => $this->input->get("fst_status"),
			"fdt_ticket_datetime" => $this->input->get("fdt_ticket_datetime"),
			"opsi_delete" => $this->input->get("opsi_delete"),
		];
        $this->load->model("ticketstatus_model");
        $result = $this->ticketstatus_model->delete_ticket_doc($data);
		$rwTicket = $result["del_ticket"];
		if ($rwTicket ==[]){
			$this->json_output([
				"status"=>"NOT FOUND",
				"message"=>""                
			]);
		}else{
			foreach($rwTicket as $ticket){
				$ssql = "SELECT * FROM trticket_docs  WHERE fin_ticket_id = ? ORDER BY fin_rec_id DESC";
				$qr = $this->db->query($ssql, [$ticket->fin_ticket_id]);
				//echo $this->db->last_query();
				//die();
				$rsDocs = $qr->result();
				foreach($rsDocs as $rwDoc){
					//Delete Document file
					if($rwDoc != null){
						if (file_exists("./assets/app/tickets/image/". $rwDoc->fin_rec_id .".jpg")){
							unlink("./assets/app/tickets/image/". $rwDoc->fin_rec_id .".jpg");
						}
						$this->db->where("fin_rec_id",$rwDoc->fin_rec_id);
						$this->db->delete("trticket_docs");
					}
				}

				if ($this->input->get("opsi_delete") != 1){
					$ssql  = "delete from trticket_log where fin_ticket_id = ?";
					$this->db->query($ssql,[$ticket->fin_ticket_id]);
					
					$ssql  = "delete from trticket where fin_ticket_id = ?";
					$this->db->query($ssql,[$ticket->fin_ticket_id]);
					//echo $this->db->last_query();
					//die();
				}
			}

			$this->json_output([
				"status"=>"SUCCESS",
				"message"=>""                
			]);
		}
    }

    public function ajx_download_ticketLog(){
		
		$this->load->library("phpspreadsheet");
		$datelog = $this->input->get("dateLog");
		if (isset($datelog)) {
            $datelog = date('Y-m-d 23:59:59', strtotime($datelog));
        }
		$data = [
			"rpt_layout" => 1,
			"selected_columns" => 7,
		];

        $ssql = "SELECT a.*,b.fst_ticket_no,c.fst_username FROM trticket_log a
        LEFT JOIN trticket b ON a.fin_ticket_id = b.fin_ticket_id
        LEFT JOIN users c ON a.fin_status_by_user_id = c.fin_user_id
        WHERE b.fdt_ticket_datetime <= ? ORDER BY a.fin_ticket_id,a.fin_rec_id";
        $qr = $this->db->query($ssql, $datelog);
        $dataReport = $qr->result();

		$arrMerged = [];  //row,ttlColType(full,sum)
		if (isset($dataReport)) {
			if ($dataReport==[]){
				//print_r("Data Not Found!");
				$this->json_output([
					"status"=>"NOT FOUND",
					"message"=>""                
				]);
			}else{
				$repTitle = "";
		
				$spreadsheet = $this->phpspreadsheet->load();
				$sheet = $spreadsheet->getActiveSheet();								
				$repPaperSize=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_A4;
				$repOrientation=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT;
				switch ($data['rpt_layout']){
					case "1":
						$repTitle = "TICKET LOG";
						$repPaperSize=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL;
                        $repOrientation=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE;
                        $fullColumn = 7;
						break;
					default:
						$repTitle = "TICKET LOG";
						$repPaperSize=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::PAPERSIZE_LEGAL;
                        $repOrientation=\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE;
                        $fullColumn = 7;
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
				
					$sheet->setCellValue("A3", "Rec ID");
					$sheet->setCellValue("B3", "Ticket ID");
					$sheet->setCellValue("C3", "Ticket No");
					$sheet->setCellValue("D3", "Tanggal Status");
					$sheet->setCellValue("E3", "Status");
					$sheet->setCellValue("F3", "User");
					$sheet->setCellValue("G3", "Memo");
                    $sheet->getColumnDimension("A")->setAutoSize(false);
                    $sheet->getColumnDimension("B")->setAutoSize(true);
                    $sheet->getColumnDimension("C")->setAutoSize(true);
                    $sheet->getColumnDimension("D")->setAutoSize(true);
                    $sheet->getColumnDimension("E")->setAutoSize(true);
                    $sheet->getColumnDimension("F")->setAutoSize(true);
                    $sheet->getColumnDimension("G")->setAutoSize(true);
					$cellRow = 4;
					$numOfRecs = count($dataReport);

					foreach ($dataReport as $rw) {
						$sheet->setCellValue("A$cellRow", $rw->fin_rec_id);
						$sheet->setCellValue("B$cellRow", $rw->fin_ticket_id);
						$sheet->setCellValue("C$cellRow", $rw->fst_ticket_no);
						$sheet->setCellValue("D$cellRow", $rw->fdt_status_datetime);
						$sheet->setCellValue("E$cellRow", $rw->fst_status);
						$sheet->setCellValue("F$cellRow", $rw->fst_username);
						$sheet->setCellValue("G$cellRow", $rw->fst_status_memo);
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
					$sheet->getStyle('A3:G'.$cellRow)->applyFromArray($styleArray);
		
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
					$sheet->getStyle('A3:G3')->applyFromArray($styleArray);
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

					//$ttlSelectedCol = sizeof($data['selected_columns'][0]);
					//$sumCol = $this->phpspreadsheet->getSumColPosition($this->layout_columns,$data['rpt_layout'],$data['selected_columns'][0]);
					//$this->phpspreadsheet->cleanColumns($sheet,$fullColumn,$data['selected_columns'][0]);
					//$this->phpspreadsheet->mergedData($sheet,$arrMerged,$ttlSelectedCol,$sumCol);

					$this->phpspreadsheet->save("Ticket-LOG.xls" ,$spreadsheet);
			}

		}
	}
	
	public function ajx_download_doc(){
		$user = $this->aauth->user();
        $download_id = $user->fin_user_id;
		$datedoc = $this->input->get("dateDoc");
		$dateZIP = $datedoc;

		$delzips = glob('assets/app/tickets/*.zip'); // get all file names
		foreach($delzips as $delzip){ // iterate files
			if(filemtime($delzip) <time() - 1800){
				if(is_file($delzip))
					unlink($delzip); // delete file
			}
		}

		if (isset($datedoc)) {
            $datedoc = date('Y-m-d 23:59:59', strtotime($datedoc));
        }
        $ssql = "SELECT * FROM trticket WHERE fdt_ticket_datetime <= ? ";
        $qr = $this->db->query($ssql, $datedoc);
		$rwTicket = $qr->result();
		
		if ($rwTicket ==[]){
			$this->json_output([
				"status"=>"NOT FOUND",
				"message"=>""                
			]);
		}else{
			$currentfolder = getcwd();
			$newfolder = "backup_temp-" . $download_id;
			$dir = $currentfolder."/assets/app/tickets"."/$newfolder";
			$dirZIP = $currentfolder."/assets/app/tickets"."/";
			if( is_dir($dir) === false )
			{
				mkdir($dir, 0777, true);
			}

			foreach($rwTicket as $ticket){
				
				$ssql = "SELECT * FROM trticket_docs  WHERE fin_ticket_id = ? ORDER BY fin_rec_id DESC";
				$qr = $this->db->query($ssql, [$ticket->fin_ticket_id]);
				//echo $this->db->last_query();
				//die();
				$rsDocs = $qr->result();
				foreach($rsDocs as $rwDoc){
					//Copy Document file
					if($rwDoc != null){
						if (file_exists("./assets/app/tickets/image/". $rwDoc->fin_rec_id .".jpg")){
							copy("./assets/app/tickets/image/". $rwDoc->fin_rec_id .".jpg",$dir."/". $rwDoc->fin_rec_id .".jpg");
						}
					}
				}
			}

			/*$images_dir = '/assets/app/tickets/image_copy';
			//this folder must be writeable by the server
			$backup = '/assets/app/tickets/image_copy';
			$zip_file = $backup.'/backup.zip';

			if ($handle = opendir($dir)){
				$zip = new ZipArchive();

				if ($zip->open($zip_file, ZipArchive::CREATE)!==TRUE) 
				{
					exit("cannot open <$zip_file>\n");
				}

				while (false !== ($file = readdir($handle))) 
				{
					$zip->addFile($images_dir,$file);
					echo "$file\n";
				}
				closedir($handle);
				echo "numfiles: " . $zip->numFiles . "\n";
				echo "status:" . $zip->status . "\n";
				$zip->close();
				echo 'Zip File:'.$zip_file . "\n";
			}*/
			// Get real path for our folder
			$rootPath = realpath($dir);
			// Initialize archive object
			//var_dump($dirZIP."/"."doc_eticketing_".$dateZIP."_".$download_id.".zip");
			//die();
			$zip = new ZipArchive();
			$zip->open($dirZIP."/"."doc_eticketing_".$dateZIP."_".$download_id.".zip", ZipArchive::CREATE | ZipArchive::OVERWRITE);
			// Initialize empty "delete list"
			$filesToDelete = array();
			// Create recursive directory iterator
			/** @var SplFileInfo[] $files */
			$files = new RecursiveIteratorIterator(
				new RecursiveDirectoryIterator($rootPath),
				RecursiveIteratorIterator::LEAVES_ONLY
			);
			foreach ($files as $name => $file)
			{
				// Skip directories (they would be added automatically)
				if (!$file->isDir())
				{
					// Get real and relative path for current file
					$filePath = $file->getRealPath();
					$relativePath = substr($filePath, strlen($rootPath) + 1);

					// Add current file to archive
					$zip->addFile($filePath, $relativePath);
					$filesToDelete[] = $filePath;
				}
			}
			// Zip archive will be created only after closing object
			$zip->close();
			
			$base = $dirZIP."/";
			$file = "doc_eticketing_".$dateZIP."_".$download_id.".zip"; // or anything else
			if(file_exists($base.$file)){        
				header('Content-Type:'.mime_content_type($base.$file));
				header('Content-disposition: attachment; filename="'.basename($file).'"');
				header('Content-Length: ' . filesize($base.$file));
				readfile($base.$file);
			}

			// Delete all files from "delete list"
			foreach ($filesToDelete as $file)
			{
				unlink($file);
			}
			rmdir($dir);
			
			$this->json_output([
				"status"=>"SUCCESS",
				"message"=>""                
			]);
		}

	}

	public function send_email(){

		$ssql = "SELECT a.fin_email_id,a.fin_ticket_id,a.fdt_email_datetime,a.fst_email_memo,a.fin_email_to_user_id,b.fst_status,b.fdt_ticket_datetime,b.fst_memo,c.fst_ticket_type_name,c.fst_assignment_or_notice,
        d.fst_service_level_name,d.fin_service_level_days,e.fst_username as issuedTo,f.fst_username as issuedBy,e.fst_email AS emailTo FROM trticket_email a 
        LEFT JOIN trticket b ON a.fin_ticket_id = b.fin_ticket_id
        LEFT JOIN mstickettype c on b.fin_ticket_type_id = c.fin_ticket_type_id
        LEFT JOIN msservicelevel d on b.fin_service_level_id = d.fin_service_level_id
        LEFT JOIN users e ON a.fin_email_to_user_id = e.fin_user_id 
        LEFT JOIN users f ON b.fin_issued_by_user_id = f.fin_user_id WHERE a.fst_status ='DRAFT' AND a.fin_ticket_id ='1498'";
        $qr = $this->db->query($ssql);
		//echo $this->db->last_query();
        //die();
		$data = $qr->row();
		
		$from = "m.bahroni86@gmail.com";
		$issuedBy = $data->issuedBy;
		$to = $data->emailTo;
		$subject = $data->fst_ticket_type_name;

		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'ssl://smtp.googlemail.com',
			'smtp_port' => 465,
			'smtp_user' => $from,
			'smtp_pass' => 'bahroni!68',
			'mailtype' => 'html',
			'charset' => 'iso-8859-1',
		);

		$this->load->library('email',$config);
		$this->email->set_newline("\r\n");

		$this->email->from($from, $issuedBy);
		$this->email->to($to);
		$this->email->subject($subject);
		$body = $this->load->view('template/emailTicket',$data,TRUE);
		$this->email->message($body);
		//$this->email->send();

		//send email (not success hanya jika $from is valid email tidak berlaku $to not valid email)
		if(!$this->email->send()){
			$this->json_output([
				"status"=>"NOT SUCCESS",
				"message"=>""                
			]);
		}else{
			$this->json_output([
				"status"=>"SUCCESS",
				"message"=>""                
			]);
		}
	}


}