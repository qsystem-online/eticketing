<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function get_ttl_newTickets(){
        $user = $this->aauth->user();
        $userActive = $user->fin_user_id;
        $deptActive = $user->fin_department_id;
        $levActive = intval($user->fin_level);
        $levActive = strval($levActive);

        $ssql = "SELECT count(*) as ttl_newTickets FROM (SELECT a.*,b.fst_ticket_type_name,c.fst_username AS issuedBy,d.fst_username AS issuedTo,e.fst_username AS approvedBy FROM trticket a 
        LEFT JOIN mstickettype b ON a.fin_ticket_type_id = b.fin_ticket_type_id
        LEFT JOIN (SELECT a.fin_user_id,a.fst_username,a.fin_department_id,b.fin_level FROM users a INNER JOIN usersgroup b ON a.fin_group_id = b.fin_group_id) c ON a.fin_issued_by_user_id = c.fin_user_id
        LEFT JOIN (SELECT a.fin_user_id,a.fst_username,a.fin_department_id,b.fin_level FROM users a INNER JOIN usersgroup b ON a.fin_group_id = b.fin_group_id) d ON a.fin_issued_to_user_id = d.fin_user_id
        LEFT JOIN (SELECT a.fin_user_id,a.fst_username,a.fin_department_id,b.fin_level FROM users a INNER JOIN usersgroup b ON a.fin_group_id = b.fin_group_id) e ON a.fin_approved_by_user_id = e.fin_user_id
        WHERE ((fin_issued_by_user_id = $userActive OR fin_issued_to_user_id = $userActive OR fin_approved_by_user_id =$userActive)
        OR (c.fin_department_id = $deptActive AND c.fin_level > $levActive)
        OR (d.fin_department_id = $deptActive AND d.fin_level > $levActive)
        OR (e.fin_department_id = $deptActive AND e.fin_level > $levActive))
        AND a.fst_status !='CLOSED' AND a.fst_status !='ACCEPTANCE_EXPIRED' AND a.fst_status !='APPROVAL_EXPIRED' AND a.fst_status !='REJECTED' AND a.fst_status !='TICKET_EXPIRED' AND a.fst_status !='VOID'
        AND NOT FIND_IN_SET (". $userActive.",a.fst_view_id)) a ";
        $qr = $this->db->query($ssql,[]);
        //echo $this->db->last_query();
        //die();
        $rw = $qr->row();
        return $rw->ttl_newTickets;

    }

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

    public function getTtlOurTickets(){
        $user = $this->aauth->user();
        $userActive = $user->fin_user_id;
        $deptActive = $user->fin_department_id;
        $levActive = intval($user->fin_level);
        $levActive = strval($levActive);

        $ssql = "SELECT count(*) as ttl_ourTickets FROM (SELECT a.*,b.fst_ticket_type_name,c.fst_username AS issuedBy,d.fst_username AS issuedTo,e.fst_username AS approvedBy FROM trticket a 
        LEFT JOIN mstickettype b ON a.fin_ticket_type_id = b.fin_ticket_type_id
        LEFT JOIN (SELECT a.fin_user_id,a.fst_username,a.fin_department_id,b.fin_level FROM users a INNER JOIN usersgroup b ON a.fin_group_id = b.fin_group_id) c ON a.fin_issued_by_user_id = c.fin_user_id
        LEFT JOIN (SELECT a.fin_user_id,a.fst_username,a.fin_department_id,b.fin_level FROM users a INNER JOIN usersgroup b ON a.fin_group_id = b.fin_group_id) d ON a.fin_issued_to_user_id = d.fin_user_id
        LEFT JOIN (SELECT a.fin_user_id,a.fst_username,a.fin_department_id,b.fin_level FROM users a INNER JOIN usersgroup b ON a.fin_group_id = b.fin_group_id) e ON a.fin_approved_by_user_id = e.fin_user_id
        WHERE ((fin_issued_by_user_id = $userActive OR fin_issued_to_user_id = $userActive OR fin_approved_by_user_id =$userActive)
        OR (c.fin_department_id = $deptActive AND c.fin_level > $levActive)
        OR (d.fin_department_id = $deptActive AND d.fin_level > $levActive)
        OR (e.fin_department_id = $deptActive AND e.fin_level > $levActive))
        AND a.fst_status !='REJECTED' AND a.fst_status !='CLOSED' AND a.fst_status !='VOID' AND a.fst_status !='ACCEPTANCE_EXPIRED' AND a.fst_status !='APPROVAL_EXPIRED' AND a.fst_status !='TICKET_EXPIRED') a ";
        $qr = $this->db->query($ssql,[]);
        $rw = $qr->row();
        return $rw->ttl_ourTickets;

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
            where (fst_status = 'NEED_REVISION' OR fst_status ='COMPLETION_REVISED') and fin_issued_by_user_id =? and (CAST(fdt_deadline_extended_datetime AS DATE) >='$expirydeadline' or fdt_deadline_extended_datetime is null) ";
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

        $ssql = "select count(*) as ttl_received_approved from trticket a
            LEFT JOIN mstickettype b ON b.fin_ticket_type_id = a.fin_ticket_type_id
            where fst_status = 'APPROVED/OPEN' and b.fst_assignment_or_notice != 'INFO' and fin_issued_to_user_id =? and CAST(fdt_acceptance_expiry_datetime AS DATE) >='$expiryaccepted' ";
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
            where (fst_status = 'NEED_REVISION' OR fst_status ='COMPLETION_REVISED') and fin_issued_to_user_id =? and (CAST(fdt_deadline_extended_datetime AS DATE) >='$expirydeadline' or fdt_deadline_extended_datetime is null)";
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