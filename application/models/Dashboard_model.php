<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model {
    //Get Ticket Status List
    public function getTtlNeedApproval(){
        $user = $this->aauth->user();

        $ssql = "select count(*) as ttl_need_approval from trticket 
            where fst_status = 'NEED_APPROVAL' and fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_need_approval;

    }
    public function getTtlIssuedApproved(){
        $user = $this->aauth->user();

        $ssql = "select count(*) as ttl_approved from trticket 
            where fst_status = 'APPROVED/OPEN' and fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_approved;

    }

    public function getTtlIssuedAccepted(){
        $user = $this->aauth->user();

        $ssql = "select count(*) as ttl_need_revision from trticket 
            where fst_status = 'ACCEPTED' and fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_need_revision;

    }

    public function getTtlIssuedNeedRevision(){
        $user = $this->aauth->user();

        $ssql = "select count(*) as ttl_need_revision from trticket 
            where fst_status = 'NEED_REVISION' and fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_need_revision;

    }

    
    public function getTtlIssuedCompleted(){
        $user = $this->aauth->user();

        $ssql = "select count(*) as ttl_need_revision from trticket 
            where fst_status = 'COMPLETED' and fin_issued_by_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_need_revision;

    }

    public function getTtlReceivedApproved(){
        $user = $this->aauth->user();

        $ssql = "select count(*) as ttl_approved from trticket 
            where fst_status = 'APPROVED/OPEN' and fin_issued_to_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_approved;

    }

    public function getTtlReceivedAccepted(){
        $user = $this->aauth->user();

        $ssql = "select count(*) as ttl_need_revision from trticket 
            where fst_status = 'ACCEPTED' and fin_issued_to_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_need_revision;

    }

    public function getTtlReceivedNeedRevision(){
        $user = $this->aauth->user();

        $ssql = "select count(*) as ttl_need_revision from trticket 
            where fst_status = 'NEED_REVISION' and fin_issued_to_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_need_revision;

    }

    
    public function getTtlReceivedCompleted(){
        $user = $this->aauth->user();

        $ssql = "select count(*) as ttl_need_revision from trticket 
            where fst_status = 'COMPLETED' and fin_issued_to_user_id =? ";
        $qr = $this->db->query($ssql,[$user->fin_user_id]);
        $rw = $qr->row();
        return $rw->ttl_need_revision;

    }

}