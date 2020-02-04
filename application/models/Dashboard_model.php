<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    //Get Ticket Status List
    public function getTtlNeedApproval(){
        $user = $this->aauth->user();
        $deptActive = $user->fin_department_id;
        $levelActive = intval($user->fin_level) +1;
        $levelActive = strval($levelActive);

        $ssql ="select count(*) as ttl_need_approval from (SELECT a.*,b.fin_user_id,b.fin_department_id,c.fin_level FROM trticket a 
        INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id
        INNER JOIN usersgroup c ON b.fin_group_id = c.fin_group_id
        WHERE a.fst_status = 'NEED_APPROVAL' AND b.fin_department_id =".$deptActive." AND c.fin_level =?)aa";
        $qr = $this->db->query($ssql,[$levelActive]);
        //echo $this->db->last_query();
        $rw = $qr->row();
        return $rw->ttl_need_approval;

    }

    public function getTtlIssuedRejected(){
        $user = $this->aauth->user();

        $ssql = "select count(*) as ttl_approved from trticket 
            where fst_status = 'REJECTED' and fin_issued_by_user_id =? and fbl_rejected_view =0 ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_approved;

    }

    public function getTtlIssuedApproved(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expiryaccepted = date_format($now,"Y-m-d H:i:s");

        $ssql = "select count(*) as ttl_approved from trticket 
            where fst_status = 'APPROVED/OPEN' and fin_issued_by_user_id =? and fdt_acceptance_expiry_datetime >'$expiryaccepted' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        //echo $this->db->last_query();
        $rw = $qr->row();
        return $rw->ttl_approved;

    }

    public function getTtlIssuedAccepted(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expirydeadline = date_format($now,"Y-m-d H:i:s");

        $ssql = "select count(*) as ttl_need_revision from trticket 
            where fst_status = 'ACCEPTED' and fin_issued_by_user_id =? and fdt_deadline_extended_datetime >'$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_need_revision;

    }

    public function getTtlIssuedNeedRevision(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expirydeadline = date_format($now,"Y-m-d H:i:s");

        $ssql = "select count(*) as ttl_need_revision from trticket 
            where (fst_status = 'NEED_REVISION' OR fst_status ='COMPLETION_REVISED') and fin_issued_by_user_id =? and fdt_deadline_extended_datetime >'$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        //echo $this->db->last_query();
        $rw = $qr->row();
        return $rw->ttl_need_revision;

    }

    
    public function getTtlIssuedCompleted(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expirydeadline = date_format($now,"Y-m-d H:i:s");

        $ssql = "select count(*) as ttl_need_revision from trticket 
            where fst_status = 'COMPLETED' and fin_issued_by_user_id =? and fdt_deadline_extended_datetime >'$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_need_revision;

    }

    public function getTtlReceivedApproved(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expiryaccepted = date_format($now,"Y-m-d H:i:s");

        $ssql = "select count(*) as ttl_approved from trticket 
            where fst_status = 'APPROVED/OPEN' and fin_issued_to_user_id =? and fdt_acceptance_expiry_datetime >'$expiryaccepted' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_approved;

    }

    public function getTtlReceivedAccepted(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expirydeadline = date_format($now,"Y-m-d H:i:s");

        $ssql = "select count(*) as ttl_need_revision from trticket 
            where fst_status = 'ACCEPTED' and fin_issued_to_user_id =? and fdt_deadline_extended_datetime >='$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        //echo $this->db->last_query();
        $rw = $qr->row();
        return $rw->ttl_need_revision;

    }

    public function getTtlReceivedNeedRevision(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expirydeadline = date_format($now,"Y-m-d H:i:s");

        $ssql = "select count(*) as ttl_need_revision from trticket 
            where (fst_status = 'NEED_REVISION' OR fst_status ='COMPLETION_REVISED') and fin_issued_to_user_id =? and fdt_deadline_extended_datetime >'$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_need_revision;

    }

    
    public function getTtlReceivedCompleted(){
        $user = $this->aauth->user();
        $now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        $now = date_create($now);
        date_add($now,date_interval_create_from_date_string("0 days"));
        $expirydeadline = date_format($now,"Y-m-d H:i:s");

        $ssql = "select count(*) as ttl_need_revision from trticket 
            where fst_status = 'COMPLETED' and fin_issued_to_user_id =? and fdt_deadline_extended_datetime >'$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_need_revision;

    }

}