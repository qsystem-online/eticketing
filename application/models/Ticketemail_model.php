<?php
if (!defined('BASEPATH')) exit ('No direct script access allowed');

class Ticketemail_model extends MY_MODEL {

    public $tableName = "trticket_email";
    public $pkey = "fin_email_id";

    public function __construct() {
        parent::__construct();
    }

    public function deleteByUserId($fin_ticket_id){
        $ssql = "delete from " . $this->tableName . " where fin_ticket_id = ?";
        $this->db->query($ssql,[$fin_ticket_id]);
    }

    public function postingEmail($email){

        $issuedTo ="";
        $approveBy ="";
        $fbl_need_approval ="";
        $fin_ticket_id ="";
        $fdt_email_datetime = "";

        if (isset($email['fin_issued_to_user_id'])) { 
            $issuedTo = $email['fin_issued_to_user_id'];
        }
        if (isset($email['fin_approved_by_user_id'])) { 
            $approveBy = $email['fin_approved_by_user_id'];
        }
        if (isset($email['fbl_need_approval'])) { 
            $fbl_need_approval = $email['fbl_need_approval'];
        }
        if (isset($email['fin_ticket_id'])) { 
            $fin_ticket_id = $email['fin_ticket_id'];
        }
        if (isset($email['fdt_email_datetime'])) { 
            $fdt_email_datetime = $email['fdt_email_datetime'];
        }

        if ($fbl_need_approval == 0){ //Ticket status = APPROVED/OPEN -----
            $ssql = "SELECT a.fbl_block_hirarki_email,b.fin_user_id ,b.fst_username,b.fst_email,b.fin_department_id,b.fst_email,b.fbl_block_direct_email,b.fin_level
            FROM (SELECT a.fin_user_id,a.fst_username,a.fst_email,a.fin_department_id,a.fbl_block_direct_email,a.fbl_block_hirarki_email,b.fin_level FROM users a LEFT JOIN usersgroup b ON a.fin_group_id = b.fin_group_id WHERE a.fin_user_id = $issuedTo) a, 
            (SELECT a.fin_user_id,a.fst_username,a.fst_email,a.fin_department_id,a.fbl_block_direct_email,a.fbl_block_hirarki_email,b.fin_level FROM users a LEFT JOIN usersgroup b ON a.fin_group_id = b.fin_group_id) b 
            WHERE ((b.fin_user_id = $issuedTo AND b.fbl_block_direct_email = FALSE) OR (a.fin_department_id = b.fin_department_id AND a.fin_level > b.fin_level AND b.fbl_block_hirarki_email = FALSE))";
            $qr = $this->db->query($ssql,[]);
            //echo $this->db->last_query();
            //die();
            $emails = $qr->result();
            foreach ($emails as $email){
                $data = [
                    "fin_ticket_id" => $fin_ticket_id,
                    "fdt_email_datetime" => $fdt_email_datetime,
                    //"fst_status" => $this->input->post("fst_status"),
                    "fst_email_memo" => $this->input->post("fst_memo"),
                    "fin_email_to_user_id" => $email->fin_user_id
                ];
                $this->ticketemail_model->insert($data);
            }
        }else if($fbl_need_approval == 1){ // Ticket status = NEED APPROVAL ----
            $ssql = "SELECT fin_user_id,fst_username,fst_fullname,fst_email FROM users WHERE fin_user_id = $approveBy AND fbl_block_direct_email = FALSE";
            $qr = $this->db->query($ssql,[$approveBy]);
            //echo $this->db->last_query();
            //die();
            $emails = $qr->result();
            foreach ($emails as $email){
                $data = [
                    "fin_ticket_id" => $fin_ticket_id,
                    "fdt_email_datetime" => $fdt_email_datetime,
                    //"fst_status" => $this->input->post("fst_status"),
                    "fst_email_memo" => $this->input->post("fst_memo"),
                    "fin_email_to_user_id" => $email->fin_user_id
                ];
                $this->ticketemail_model->insert($data);
            }
        }
    }

    public function ticket_email(){
        $ssql = "SELECT a.fin_email_id,a.fin_ticket_id,a.fdt_email_datetime,a.fst_email_memo,a.fin_email_to_user_id,b.fst_status,b.fdt_ticket_datetime,b.fst_memo,c.fst_ticket_type_name,c.fst_assignment_or_notice,
        d.fst_service_level_name,d.fin_service_level_days,e.fst_username as issuedTo,f.fst_username as issuedBy,e.fst_email FROM trticket_email a 
        LEFT JOIN trticket b ON a.fin_ticket_id = b.fin_ticket_id
        LEFT JOIN mstickettype c on b.fin_ticket_type_id = c.fin_ticket_type_id
        LEFT JOIN msservicelevel d on b.fin_service_level_id = d.fin_service_level_id
        LEFT JOIN users e ON a.fin_email_to_user_id = e.fin_user_id 
        LEFT JOIN users f ON b.fin_issued_by_user_id = f.fin_user_id WHERE a.fst_status ='DRAFT'";
        $qr = $this->db->query($ssql);
        //echo $this->db->last_query();
        //die();
        $rsEmail = $qr->result();
        $data = [
            "email_ticket" => $rsEmail
        ];

        return $data;
    }
}