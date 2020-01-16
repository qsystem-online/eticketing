<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    //Get Approval List
    public function getTtlApproved2(){
        $tbl = "";
        $ssql = "select count(*) as ttl_approve from trverification a
            inner join users b on a.fin_department_id = b.fin_department_id
            inner join users c on a.fin_user_group_id = c.fin_group_id
            where a.fin_rec_id = ? and a.fst_verification_status = 'RV'
            and b.fst_active = 'A'";
        $query = $this->db->query($ssql,$this->aauth->get_user_id());
        $row = $query->row();
        return $row->ttl_approve;
    }

    public function getTtlNeedApproval(){
        $user = $this->aauth->user();

        $ssql = "select count(*) as ttl_need_approval from trticket_log a
            inner join trticket b on a.fin_ticket_id = b.fin_ticket_id
            where a.fst_status = '0' and b.fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_need_approval;

    }
    public function getTtlApproved(){
        $user = $this->aauth->user();

        $ssql = "select count(*) as ttl_approved from trticket_log a
            inner join trticket b on a.fin_ticket_id = b.fin_ticket_id
            where a.fst_status = '1' and b.fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_approved;

    }

    public function getTtlChangeAfterApproved(){

    }

    public function getTtlVoidAuthorize(){

    }
}