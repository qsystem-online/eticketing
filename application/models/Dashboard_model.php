<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    //Get Ticket Status List
    public function getTtlNeedApproval(){
        $user = $this->aauth->user();
        //$deptActive = $user->fin_department_id;
        //$levelActive = intval($user->fin_level) +1;
        //$levelActive = strval($levelActive);

        $ssql ="select count(*) as ttl_need_approval from (SELECT a.*,b.fin_user_id,b.fin_department_id as deptBy,c.fin_level FROM trticket a 
        INNER JOIN users b ON a.fin_issued_by_user_id = b.fin_user_id
        INNER JOIN usersgroup c ON b.fin_group_id = c.fin_group_id
        WHERE a.fst_status = 'NEED_APPROVAL' AND a.fin_approved_by_user_id =?)aa";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        //echo $this->db->last_query();
        $rw = $qr->row();
        return $rw->ttl_need_approval;

    }

    public function getTtlIssuedRejected(){
        $user = $this->aauth->user();

        $ssql = "select count(*) as ttl_rejected from trticket 
            where fst_status = 'REJECTED' and fin_issued_by_user_id =? and fbl_rejected_view =0 ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_rejected;

    }

    public function getTtlIssuedApproved(){
        $user = $this->aauth->user();
        //$now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        //$now = date_create($now);
        //date_add($now,date_interval_create_from_date_string("0 days"));
        $expiryaccepted = date("Y-m-d");

        $ssql = "select count(*) as ttl_approved from trticket a
            LEFT JOIN mstickettype b ON b.fin_ticket_type_id = a.fin_ticket_type_id
            where fst_status = 'APPROVED/OPEN' and b.fst_assignment_or_notice != 'INFO' and fin_issued_by_user_id =? and cast(fdt_acceptance_expiry_datetime as date) >='$expiryaccepted' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        //echo $this->db->last_query();
        $rw = $qr->row();
        return $rw->ttl_approved;

    }

    public function getTtlIssuedAccepted(){
        $user = $this->aauth->user();
        //$now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        //$now = date_create($now);
        //date_add($now,date_interval_create_from_date_string("0 days"));
        //$expirydeadline = date_format($now,"Y-m-d H:i:s");
        $expirydeadline = date("Y-m-d");

        $ssql = "select count(*) as ttl_issued_accepted from trticket 
            where fst_status = 'ACCEPTED' and fin_issued_by_user_id =? and CAST(fdt_deadline_extended_datetime AS DATE) >='$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_issued_accepted;

    }

    public function getTtlIssuedNeedRevision(){
        $user = $this->aauth->user();
        //$now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        //$now = date_create($now);
        //date_add($now,date_interval_create_from_date_string("0 days"));
        //$expirydeadline = date_format($now,"Y-m-d H:i:s");
        $expirydeadline = date("Y-m-d");

        $ssql = "select count(*) as ttl_need_revision from trticket 
            where (fst_status = 'NEED_REVISION' OR fst_status ='COMPLETION_REVISED') and fin_issued_by_user_id =? and CAST(fdt_deadline_extended_datetime AS DATE) >='$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        //echo $this->db->last_query();
        $rw = $qr->row();
        return $rw->ttl_need_revision;

    }

    
    public function getTtlIssuedCompleted(){
        $user = $this->aauth->user();
        //$now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        //$now = date_create($now);
        //date_add($now,date_interval_create_from_date_string("0 days"));
        //$expirydeadline = date_format($now,"Y-m-d H:i:s");
        $expirydeadline = date("Y-m-d");

        $ssql = "select count(*) as ttl_issued_completed from trticket 
            where fst_status = 'COMPLETED' and fin_issued_by_user_id =? and CAST(fdt_deadline_extended_datetime AS DATE) >='$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_issued_completed;

    }

    public function getTtlReceivedApproved(){
        $user = $this->aauth->user();
        //$now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        //$now = date_create($now);
        //date_add($now,date_interval_create_from_date_string("0 days"));
        //$expiryaccepted = date_format($now,"Y-m-d H:i:s");
        $expiryaccepted = date("Y-m-d");

        $ssql = "select count(*) as ttl_received_approved from trticket 
            where fst_status = 'APPROVED/OPEN' and fin_issued_to_user_id =? and CAST(fdt_acceptance_expiry_datetime AS DATE) >='$expiryaccepted' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_received_approved;

    }

    public function getTtlReceivedAccepted(){
        $user = $this->aauth->user();
        //$now = date("Y-m-d H:i:s",strtotime('23:59:59'));
        //$now = date_create($now);
        //date_add($now,date_interval_create_from_date_string("0 days"));
        //$expirydeadline = date_format($now,"Y-m-d H:i:s");
        $expirydeadline = date("Y-m-d");

        $ssql = "select count(*) as ttl_received_accepted from trticket 
            where fst_status = 'ACCEPTED' and fin_issued_to_user_id =? and CAST(fdt_deadline_extended_datetime AS DATE) >='$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        //echo $this->db->last_query();
        $rw = $qr->row();
        return $rw->ttl_received_accepted;

    }

    public function getTtlReceivedNeedRevision(){
        $user = $this->aauth->user();
        //$now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        //$now = date_create($now);
        //date_add($now,date_interval_create_from_date_string("0 days"));
        //$expirydeadline = date_format($now,"Y-m-d H:i:s");
        $expirydeadline = date("Y-m-d");

        $ssql = "select count(*) as ttl_need_revision from trticket 
            where (fst_status = 'NEED_REVISION' OR fst_status ='COMPLETION_REVISED') and fin_issued_to_user_id =? and CAST(fdt_deadline_extended_datetime AS DATE) >='$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        //echo $this->db->last_query();
        $rw = $qr->row();
        return $rw->ttl_need_revision;

    }

    
    public function getTtlReceivedCompleted(){
        $user = $this->aauth->user();
        //$now = date("Y-m-d H:i:s",strtotime(' 23:59:59'));
        //$now = date_create($now);
        //date_add($now,date_interval_create_from_date_string("0 days"));
        //$expirydeadline = date_format($now,"Y-m-d H:i:s");
        $expirydeadline = date("Y-m-d");

        $ssql = "select count(*) as ttl_received_completed from trticket 
            where fst_status = 'COMPLETED' and fin_issued_to_user_id =? and CAST(fdt_deadline_extended_datetime AS DATE) >='$expirydeadline' ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_received_completed;

    }

}