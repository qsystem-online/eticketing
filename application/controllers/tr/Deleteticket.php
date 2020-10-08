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

    public function ajx_delete_ticket($end_date){

        $this->load->model("ticketstatus_model");
        $result = $this->ticketstatus_model->delete_ticket_doc($end_date);
        $rwTicket = $result["del_ticket"];
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
            $ssql  = "delete from trticket where fin_ticket_id = ?";
            $this->db->query($ssql,[$ticket->fin_ticket_id]);

            $ssql  = "delete from trticket_log where fin_ticket_id = ?";
            $this->db->query($ssql,[$ticket->fin_ticket_id]);
        }

        $this->json_output([
            "status"=>"SUCCESS",
            "message"=>""                
        ]);
    }


}