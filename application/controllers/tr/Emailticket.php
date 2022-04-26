<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Emailticket extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->model('ticketemail_model');
    }

	public function send_email(){

        $this->load->model("ticketemail_model");
        $result = $this->ticketemail_model->ticket_email();
		$data = $result["email_ticket"];

		$from = "m.bahroni86@gmail.com";
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

		foreach ($data as $email){
			$issuedBy = $email->issuedBy;
			$to = $email->fst_email;
			//$to = "bahroni111@gmail.com";
			$subject = $email->fst_ticket_type_name;
			$fin_email_id = $email->fin_email_id;

			$this->email->clear();
	
			$this->email->from($from, $issuedBy);
			$this->email->to($to);
			$this->email->subject($subject);
			$body = $this->load->view('template/emailTicket',$email,TRUE);
			$this->email->message($body);

			//send email (not success hanya jika $from is valid email tidak berlaku $to not valid email)
			if($this->email->send()){
				$ssql = "UPDATE trticket_email SET fst_status ='SENT' WHERE fin_email_id = ?";
				$this->db->query($ssql,[$fin_email_id]);
			}else{
				echo $this->email->print_debugger();
			}
		}
		/*$issuedBy = $data->issuedBy;
		$to = $data->emailTo;
		$subject = $data->fst_ticket_type_name;


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
		}*/
	}


}