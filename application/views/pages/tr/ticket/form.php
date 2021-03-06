<?php
defined('BASEPATH') or exit ('No direct script access allowed');
?>
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/datatables.net/datatables.min.css">

<style type="text/css">
    .border-0{
        border: 0px;
    }
    .box-header-1{
        height: 50px;
    }
    .td{
        padding: 2px; !important
    }
    .form-group{
		margin-bottom:5px;
	}
    .body {
        font-family: Arial, Helvetica, sans-serif;
    }
    .row {
        margin: 0 -5px;
    }
    .row:after {
        content: "";
        display: table;
        clear: both;
    }
    /* Style the counter cards */
    .card-issued {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        padding: 16px;
        background-color: #f1f1f1;
        margin-bottom: 20px;
    }
    .card-received {
        box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
        padding: 16px;
        background-color: #3c8dbc;
        margin-bottom: 20px;
    }
    .card button {
        border: none;
        outline: 0;
        padding: 12px;
        color: white;
        background-color: #000;
        text-align: center;
        cursor: pointer;
        width: 100%;
        font-size: 18px;
    }

    .card button:hover {
        opacity: 0.7;
    }

    .card-title {
        font-weight:bold;
        /*text-align: center;*/
    }

    .sep {
        height: 15px;
    }

    .list-group {
        font-style: Italic;
        height: 100%;
    }

    .btn {
        margin-bottom: 20px;
    }
</style>

<section class="content-header">
    <h1><?= lang("Ticket") ?><small><?= lang("form") ?></small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
        <li><a href="#"><?= lang("Transaksi") ?></a></li>
        <li><a href="#"><?=lang("Ticket") ?></a></li>
        <li class="active title"><?= $title ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title title"><?= $title ?></h3>
                    <div class="btn-group btn-group-sm pull-right">
                        <a id="btnNew" class="btn btn-primary" href="#" title="<?=lang("Tambah Baru")?>" style="display:<?= $mode == "VIEW" ? "none" : "inline-block" ?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        <a id="btnSubmitAjax" class="btn btn-primary" href="#" title="<?=lang("Simpan")?>" style="display:<?= $mode == "VIEW" ? "none" : "inline-block" ?>"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
                        <!--<a id="btnDelete" class="btn btn-primary" href="#" title="<?=lang("Void")?>" style="display:<?= $mode == "VIEW" ? "none" : "inline-block" ?>"><i class="fa fa-trash" aria-hidden="true"></i></a> -->
                        <a id="btnList" class="btn btn-primary" href="#" title="<?=lang("Daftar Transaksi")?>" style="display:<?= $mode == "VIEW" ? "none" : "inline-block" ?>"><i class="fa fa-list" aria-hidden="true"></i></a>
                    </div>
                </div>
                <!-- end box header -->

                <div class="box-body">
                    <!-- form start -->
                    <?php if ($mode != "VIEW") { ?>
                        <form id="frmTicket" class="form-horizontal" action="<?= site_url() ?>tr/ticket/add" method="POST" enctype="multipart/form-data">
                            <!--<div class="box-body">-->
                                <input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">			
                                <input type="hidden" id="frm-mode" value="<?=$mode?>">
                                <input type="hidden" class="form-control" id="fin_ticket_id" placeholder="<?=lang("(Autonumber)")?>" name="fin_ticket_id" value="<?=$fin_ticket_id?>" readonly>
                                <input type="hidden" class="form-control" id="fbl_need_approval" name="fbl_need_approval" readonly>
                                <input type="hidden" class="form-control" id="fst_assignment_or_notice" name="fst_assignment_or_notice" readonly>
                                <input type="hidden" class="form-control" id="fin_service_level_days" name="fin_service_level_days" readonly>
                                
                                <div class="form-group">
                                    <label for="fst_ticket_no" class="col-xs-6 col-md-2 control-label"><?=lang("Ticket No.")?> #</label>
                                    <div class="col-xs-6 col-md-10">
                                        <input type="text" class="form-control" id="fst_ticket_no" placeholder="<?=lang("Ticket No.")?>" name="fst_ticket_no" value="<?=$fst_ticket_no?>" readonly>
                                        <div id="fst_ticket_no_err" class="text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="select-ticketType" class="col-xs-6 col-md-2 control-label"><?=lang("Ticket Type")?></label>
                                    <div class="col-xs-6 col-md-4">
                                        <select id="select-ticketType" class="form-control select2" name="fin_ticket_type_id" style="width:100%">
                                            <option value="" selected>-- <?=lang("select")?> --</option>
                                            <?php
                                                $tickettypeList = $this->tickettype_model->getTicketType();
                                                foreach ($tickettypeList as $ticketType) {
                                                    echo "<option value='$ticketType->fin_ticket_type_id' data-notice='$ticketType->fst_assignment_or_notice' data-fbl='$ticketType->fbl_need_approval'>$ticketType->fst_ticket_type_name</option>";
                                                }
                                            ?>
                                        </select>
                                        <div id="fin_ticket_type_id_err" class="text-danger"></div>
                                    </div>
                                
                                    <label for="select-serviceLevel" class="col-xs-6 col-md-2 control-label"><?=lang("Service Level")?></label>
                                    <div class="col-xs-6 col-md-4">
                                        <select id="select-serviceLevel" class="form-control select2" name="fin_service_level_id" style="width:100%">
                                            <option value="" selected>-- <?=lang("select")?> --</option>
                                            <?php
                                                $servicelevelList = $this->servicelevel_model->get_data_serviceLevel();
                                                foreach ($servicelevelList as $serviceLevel) {
                                                    echo "<option value='$serviceLevel->fin_service_level_id' data-days='$serviceLevel->fin_service_level_days'>$serviceLevel->fst_service_level_name - $serviceLevel->fin_service_level_days HARI </option>";
                                                }
                                            ?>
                                        </select>
                                        <div id="fin_service_level_id_err" class="text-danger"></div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="fdt_ticket_datetime" class="col-xs-6 col-md-2 control-label"><?=lang("Ticket Datetime")?></label>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control text-right datetimepicker" id="fdt_ticket_datetime" name="fdt_ticket_datetime" disabled/>								
                                        </div>
                                        <div id="fdt_ticket_datetime_err" class="text-danger"></div>
                                        <!-- /.input group -->
                                    </div>

                                    <label for="fdt_acceptance_expiry_datetime" class="col-xs-6 col-md-4 control-label"><?=lang("Acceptance Expiry Datetime")?></label>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control text-right datetimepicker" id="fdt_acceptance_expiry_datetime" name="fdt_acceptance_expiry_datetime" disabled/>
                                        </div>
                                        <div id="fdt_acceptance_expiry_datetime_err" class="text-danger"></div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label for="fdt_deadline_extended_datetime" class="col-xs-6 col-md-2 control-label"><?=lang("Deadline Datetime")?></label>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control text-right datetimepicker" id="fdt_deadline_extended_datetime" name="fdt_deadline_extended_datetime" disabled/>
                                        </div>
                                        <div id="fdt_deadline_extended_datetime_err" class="text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="select-users" class="col-xs-6 col-md-2 control-label"><?=lang("Issued By")?></label>
                                    <div class="col-xs-6 col-md-4">
                                        <select id="select-users" class="form-control select2" name="fin_issued_by_user_id" style="width:100%">
                                            <?php
                                                $active_user = $this->aauth->user();
                                                $issuedByOthers = getDbConfig("issued_by_others");
                                                if ($issuedByOthers == 1){
                                                    $usersList = $this->users_model->getAllList();
                                                    foreach ($usersList as $users) {
                                                        $isActive = ($users->fin_user_id == $active_user->fin_user_id) ? "selected " : "";
                                                        echo "<option value=" . $users->fin_user_id . " $isActive >" . $users->fst_username . "</option>";
                                                    }
                                                }else{
                                                    echo "<option value=" . $active_user->fin_user_id . " selected >" . $active_user->fst_username . "</option>";
                                                }
                                            ?>
                                        </select>
                                        <div id="fin_issued_by_user_id_err" class="text-danger"></div>
                                    </div>

                                    <label for="select-toUser" class="col-xs-6 col-md-2 control-label"><?=lang("Issued To")?></label>
                                    <div class="col-xs-6 col-md-4">
                                        <select id="select-toUser" class="form-control select2" name="fin_issued_to_user_id" style="width:100%">
                                            <option value="" selected>-- <?=lang("select")?> --</option>
                                            <?php
                                                $touserList = $this->users_model->getToUserList();
                                                foreach ($touserList as $toUser){
                                                    echo "<option value='$toUser->fin_user_id'>$toUser->fst_username</option>";
                                                }
                                            ?>
                                        </select>
                                        <div id="fin_issued_to_user_id_err" class="text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="fin_to_department_id" class="col-xs-6 col-md-2 control-label"><?=lang("Department")?></label>
                                    <div class="col-xs-6 col-md-4">
                                        <select id="select-department" class="form-control select2" name="fin_to_department_id" style="width:100%">
                                        <option value="" selected>-- <?=lang("select")?> --</option>
                                            <?php
                                                $deptidList = $this->msdepartments_model->getDepartment();
                                                foreach ($deptidList as $deptId) {
                                                    echo "<option value='$deptId->fin_department_id'>$deptId->fst_department_name</option>";
                                                }
                                            ?>
                                        </select>
                                        <div id="fin_to_department_id" class="text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="fin_approved_by_user_id" class="col-xs-6 col-md-2 control-label"><?=lang("Approved By")?></label>
                                    <div class="col-xs-6 col-md-4">
                                        <select id="select-approvedby" class="form-control select2" name="fin_approved_by_user_id" style="width:100%"></select>
                                        <div id="fin_approved_by_user_id_err" class="text-danger"></div>
                                    </div>

                                    <label for="fst_status" class="col-xs-6 col-md-2 control-label"><?=lang("Status")?></label>
                                    <div class="col-xs-6 col-md-4">
                                        <select id="select-status" class="form-control select2" name="fst_status" style="width:100%" disabled>
                                            <option value="">-- <?=lang("select")?> --</option>
                                            <option value="NEED_APPROVAL"><?=lang("NEED APPROVAL")?></option>
                                            <option value="APPROVED/OPEN"><?=lang("APPROVED/OPEN")?></option>
                                            <option value="ACCEPTED"><?=lang("ACCEPTED")?></option>
                                            <option value="NEED_REVISION"><?=lang("NEED REVISION")?></option>
                                            <option value="COMPLETED"><?=lang("COMPLETED")?></option>
                                            <option value="COMPLETION_REVISED"><?=lang("COMPLETION REVISED")?></option>
                                            <option value="CLOSED"><?=lang("CLOSED")?></option>
                                            <option value="APPROVAL_EXPIRED"><?=lang("APPROVAL EXPIRED")?></option>
                                            <option value="ACCEPTANCE_EXPIRED"><?=lang("ACCEPTANCE EXPIRED")?></option>
                                            <option value="TICKET_EXPIRED"><?=lang("TICKET EXPIRED")?></option>
                                            <option value="REJECTED"><?=lang("REJECTED")?></option>
                                            <option value="VOID"><?=lang("VOID")?></option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="fst_memo" class="col-xs-6 col-md-2 control-label"><?= lang("Memo") ?></label>
                                    <div class="col-xs-6 col-md-10">
                                        <textarea rows="7" style="width:100%" class="form-control" id="fst_memo" placeholder="<?= lang("Memo") ?>" name="fst_memo"></textarea>
                                        <div id="fst_memo_err" class="text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group hidden">
                                    <div class="col-xs-6 col-md-2 col-xs-offset-6 col-md-offset-2">
                                        <label class="checkbox-inline"><input id="fbl_rejected_view" type="checkbox" name="fbl_rejected_view" value="1"><?=lang("Void View")?></label></br>
                                        <div id="fbl_rejected_view_err" class="text-danger" style="padding-left:200px"></div>
                                    </div>
                                </div>
                        </form>
                    <?php } ?>
                    <!-- end form -->
                    
                    <?php if ($mode == "VIEW") { ?>
                        <div class="nav-tabs-custom" style="display:unset">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#ticket_view" data-toggle="tab" aria-expanded="true"><label><?=lang("Ticket View")?></label></a></li>
                                <li class=""><a href="#ticket_log" data-toggle="tab" aria-expanded="true"><label><?=lang("Ticket Log")?></label></a></li>
                                <li class=""><a href="#ticket_lampiran" data-toggle="tab" aria-expanded="true"><label><?=lang("Lampiran")?></label></a></li>
                            </ul>
                            
                            <div class="tab-content">
                                <div class="tab-pane active" id="ticket_view">
                                    <div class="box-header-1 with-border">
                                        <div class="btn-group btn-group-md pull-right">
                                            <a id="btnVoid" class="btn btn-primary" href="#" title="<?=lang("Void")?>" style="display:<?= $mode == "ADD" ? "none" : "inline-block" ?>"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>
                                            <a id="btnLizt" class="btn btn-primary" href="#" title="<?=lang("Daftar Transaksi")?>" style="display:<?= $mode == "ADD" ? "none" : "inline-block" ?>"><i class="fa fa-list" aria-hidden="true"></i></a>
                                        </div>
                                    </div>
                                    <form id="frmTicketView" class="form-horizontal">
                                        <div class="box-body">
                                            <input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">			
                                            <input type="hidden" id="frm-mode" value="<?=$mode?>">
                                            <input type="hidden" class="form-control" id="fin_ticket_id" placeholder="<?=lang("(Autonumber)")?>" name="fin_ticket_id" value="<?=$fin_ticket_id?>" readonly>
                                            
                                            
                                            <div class="form-group">
                                                <label for="fst_ticket_no" class="col-xs-6 col-md-2 control-label"><?=lang("Ticket No.")?> #</label>
                                                <div class="col-xs-6 col-md-10">
                                                    <input type="text" class="form-control" id="fst_ticket_no" placeholder="<?=lang("Ticket No.")?>" name="fst_ticket_no" value="<?=$fst_ticket_no?>" readonly>
                                                    <div id="fst_ticket_no_err" class="text-danger"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="select-ticketType" class="col-xs-6 col-md-2 control-label"><?=lang("Ticket Type")?></label>
                                                <div class="col-xs-6 col-md-4">
                                                    <select id="select-ticketType" class="form-control select2" name="fin_ticket_type_id" style="width:100%" disabled>
                                                        <option value="" selected>-- <?=lang("select")?> --</option>
                                                        <?php
                                                            $tickettypeList = $this->tickettype_model->getTicketType();
                                                            foreach ($tickettypeList as $ticketType) {
                                                                echo "<option value='$ticketType->fin_ticket_type_id' data-notice='$ticketType->fst_assignment_or_notice' data-fbl='$ticketType->fbl_need_approval'>$ticketType->fst_ticket_type_name</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                    <div id="fin_ticket_type_id_err" class="text-danger"></div>
                                                </div>
                                            
                                                <label for="select-serviceLevel" class="col-xs-6 col-md-2 control-label"><?=lang("Service Level")?></label>
                                                <div class="col-xs-6 col-md-4">
                                                    <select id="select-serviceLevel" class="form-control select2" name="fin_service_level_id" style="width:100%" disabled>
                                                        <option value="" selected>-- <?=lang("select")?> --</option>
                                                        <?php
                                                            $servicelevelList = $this->servicelevel_model->get_data_serviceLevel();
                                                            foreach ($servicelevelList as $serviceLevel) {
                                                                echo "<option value='$serviceLevel->fin_service_level_id'>$serviceLevel->fst_service_level_name - $serviceLevel->fin_service_level_days HARI </option>";
                                                            }
                                                        ?>
                                                    </select>
                                                    <div id="fin_service_level_id_err" class="text-danger"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="fdt_ticket_datetime" class="col-xs-6 col-md-2 control-label"><?=lang("Ticket Datetime")?></label>
                                                <div class="col-xs-6 col-md-3">
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control text-right datetimepicker" id="fdt_ticket_datetime" name="fdt_ticket_datetime" disabled/>								
                                                    </div>
                                                    <div id="fdt_ticket_datetime_err" class="text-danger"></div>
                                                    <!-- /.input group -->
                                                </div>

                                                <label for="fdt_acceptance_expiry_datetime" class="col-xs-6 col-md-4 control-label"><?=lang("Acceptance Expiry Datetime")?></label>
                                                <div class="col-xs-6 col-md-3">
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control text-right datetimepicker" id="fdt_acceptance_expiry_datetime" name="fdt_acceptance_expiry_datetime" disabled/>
                                                    </div>
                                                    <div id="fdt_acceptance_expiry_datetime_err" class="text-danger"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="fdt_deadline_extended_datetime" class="col-xs-6 col-md-2 control-label"><?=lang("Deadline Datetime")?></label>
                                                <div class="col-xs-6 col-md-3">
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input type="text" class="form-control text-right datetimepicker" id="fdt_deadline_extended_datetime" name="fdt_deadline_extended_datetime" disabled/>
                                                    </div>
                                                    <div id="fdt_deadline_extended_datetime_err" class="text-danger"></div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="select-users" class="col-xs-6 col-md-2 control-label"><?=lang("Issued By")?></label>
                                                <div class="col-xs-6 col-md-4">
                                                    <select id="select-users" class="form-control select2" name="fin_issued_by_user_id" style="width:100%" disabled>
                                                        <?php
                                                            $active_user = $this->aauth->get_user_id();
                                                            $usersList = $this->users_model->getAllList();
                                                            foreach ($usersList as $users) {
                                                                $isActive = ($users->fin_user_id == $active_user) ? "selected" : "";
                                                                echo "<option value=" . $users->fin_user_id . " $isActive >" . $users->fst_username . "</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                    <div id="fin_issued_by_user_id_err" class="text-danger"></div>
                                                </div>

                                                <label for="select-toUser" class="col-xs-6 col-md-2 control-label"><?=lang("Issued To")?></label>
                                                <div class="col-xs-6 col-md-4">
                                                    <select id="select-toUser" class="form-control select2" name="fin_issued_to_user_id" style="width:100%" disabled>
                                                        <option value=""  selected>-- <?=lang("select")?> --</option>
                                                        <?php
                                                            $touserList = $this->users_model->getToUserList();
                                                            foreach ($touserList as $toUser){
                                                                echo "<option value='$toUser->fin_user_id'>$toUser->fst_username</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                    <div id="fin_issued_to_user_id_err" class="text-danger"></div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="fin_to_department_id" class="col-xs-6 col-md-2 control-label"><?=lang("Department")?></label>
                                                <div class="col-xs-6 col-md-4">
                                                    <select id="select-department" class="form-control select2" name="fin_to_department_id" style="width:100%" disabled>
                                                        <option value="" selected>-- <?=lang("select")?> --</option>
                                                        <?php
                                                            $deptidList = $this->msdepartments_model->getDepartment();
                                                            foreach ($deptidList as $deptId) {
                                                                echo "<option value='$deptId->fin_department_id'>$deptId->fst_department_name</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label for="fin_approved_by_user_id" class="col-xs-6 col-md-2 control-label"><?=lang("Approved By")?></label>
                                                <div class="col-xs-6 col-md-4">
                                                    <select id="select-approvedby" class="form-control select2" name="fin_approved_by_user_id" style="width:100%" disabled>
                                                        <option value="" selected>-- <?=lang("select")?> --</option>
                                                        <?php
                                                            $approvedbyList = $this->users_model->getToUserList();
                                                            foreach ($approvedbyList as $approvedBy) {
                                                                echo "<option value='$approvedBy->fin_user_id'>$approvedBy->fst_username</option>";
                                                            }
                                                        ?>
                                                    </select>
                                                </div>

                                                <label for="fst_status" class="col-xs-6 col-md-2 control-label"><?=lang("Status")?></label>
                                                <div class="col-xs-6 col-md-4">
                                                    <select id="select-status" class="form-control select2" name="fst_status" style="width:100%" disabled>
                                                        <option value="NEED_APPROVAL"><?=lang("NEED APPROVAL")?></option>
                                                        <option value="APPROVED/OPEN"><?=lang("APPROVED/OPEN")?></option>
                                                        <option value="ACCEPTED"><?=lang("ACCEPTED")?></option>
                                                        <option value="NEED_REVISION"><?=lang("NEED REVISION")?></option>
                                                        <option value="COMPLETED"><?=lang("COMPLETED")?></option>
                                                        <option value="COMPLETION_REVISED"><?=lang("COMPLETION REVISED")?></option>
                                                        <option value="CLOSED"><?=lang("CLOSED")?></option>
                                                        <option value="APPROVAL_EXPIRED"><?=lang("APPROVAL EXPIRED")?></option>
                                                        <option value="ACCEPTANCE_EXPIRED"><?=lang("ACCEPTANCE EXPIRED")?></option>
                                                        <option value="TICKET_EXPIRED"><?=lang("TICKET EXPIRED")?></option>
                                                        <option value="REJECTED"><?=lang("REJECTED")?></option>
                                                        <option value="VOID"><?=lang("VOID")?></option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="fst_memo" class="col-xs-6 col-md-2 control-label"><?= lang("Memo") ?></label>
                                                <div class="col-xs-6 col-md-10">
                                                    <textarea rows="7" style="width:100%" class="form-control" id="fst_memo" placeholder="<?= lang("Memo") ?>" name="fst_memo"></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group hidden">
                                                <div class="col-xs-6 col-md-2 col-xs-offset-6 col-md-offset-2">
                                                    <label class="checkbox-inline"><input id="fbl_rejected_view" type="checkbox" name="fbl_rejected_view" value="1"><?=lang("Void View")?></label></br>
                                                    <div id="fbl_rejected_view_err" class="text-danger" style="padding-left:200px"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                                <div class="tab-pane fade" id="ticket_log">
                                    <div class="col-md-12" id="ticketlog_card"></div>
                                </div>

                                <div class="tab-pane fade" id="ticket_lampiran">
                                    <form id="frmTicketlampiran" class="form-horizontal">
                                        <input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">			
                                        <div class="form-group">
                                            <label for="fst_lampiran" class="col-xs-6 col-md-2 control-label"><?=lang("Lampiran Gambar")?></label>
                                            <div class="col-xs-6 col-md-4">
                                                <input type="file" class="form-control" id="fst_lampiran"  name="fst_lampiran" accept=".jpg">
                                                <div id="fst_lampiran_err" class="text-danger"></div>
                                            </div>

                                            <div class="col-xs-12 col-md-6">
                                                <input type="text" class="form-control" id="fst_doc_title"  name="fst_doc_title" placeholder="<?= lang("Judul") ?>">
                                                <div id="fst_doc_title_err" class="text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="fst_lampiran" class="col-xs-6 col-md-2 control-label"><?=lang("Keterangan")?></label>
                                            <div class="col-xs-6 col-md-9">
                                                <textarea class="form-control" id="fst_doc_memo"  name="fst_memo"></textarea>
                                            </div>
                                            <div class="col-xs-12 col-md-1">
                                                <button id="btn-add-lampiran" class="btn btn-primary">Add</button>
                                            </div>                                    
                                        </div>
                                    </form>
                                    <table class="table" style="width:100%">
                                        <thead>
                                            <th style="width:30%"><?=lang("Judul")?></th>
                                            <th><?=lang("Keterangan")?></th>
                                            <th style="width:30%"><?=lang("Tanggal")?></th>
                                        </thead>
                                        <tbody id="tblbodydocs">
                                        </tbody>
                                    </table>
                                </div>
                            </div>																		
                        </div>
                    <?php } ?>
                </div>

                <div class="box-footer"></div>

            </div>
        </div>
</section>

<script type="text/javascript" info="init">
$(function(){
    $("#select-approvedby").select2({
        ajax:{
            minimumInputLength: 1,
            dataType: 'json',
            delay: 250,
            url:function(params){
                return "<?=site_url()?>tr/ticket/ajxGetApproval/" + $("#select-users").val();
            },
            processResults: function (resp) {
                if(resp.status == "SUCCESS"){
                    var data = resp.data;

                    result = $.map(data,function(v,i){
                        return {
                            id:v.fin_user_id,
                            text:v.fst_username
                        };
                    });

                    return {
                        results:result
                    }
                }else{
                    return;
                }
            }

        }
    });

    $("#btn-add-lampiran").click(function(event){
        event.preventDefault();
        var docTitle = $("#fst_doc_title").val();
        var docFile = $("#fst_lampiran").val();
        if (docTitle == null || docTitle == "" ) {
            $("#fst_doc_title_err").html("Judul harus diisi !!!");
            $("#fst_doc_title_err").show();
            return;
        }
        if (docFile == ""){
            $("#fst_lampiran_err").html("Pilih File !!!");
            $("#fst_lampiran_err").show();
            return;
        }else{
            $("#fst_doc_title_err").hide();
            data = new FormData($("#frmTicketlampiran")[0]);

            data.append("fin_ticket_id", $("#fin_ticket_id").val());
            
            url = "<?= site_url() ?>tr/ticket/ajx_add_doc";

            App.blockUIOnAjaxRequest("Please wait while add attachment.....");
            $.ajax({
                type: "POST",
                //enctype: 'multipart/form-data',
                url: url,
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                success: function (resp) {
                    if (resp.message != "") {
                        $.alert({
                            title: 'Message',
                            content: resp.message,
                            buttons: {
                                OK : function(){
                                    return;
                                }
                            },
                        });
                    }

                    if (resp.status == "VALIDATION_FORM_FAILED"){
                        //Show Error
                        errors = resp.data;
                        for (key in errors) {
                            $("#" + key + "_err").html(errors[key]);
                        }
                    }else if(resp.status == "SUCCESS") {                            
                        
                        var tbody = '<tr id="doc_' + resp.data.insertId + '">';                            
                        tbody += '<td>';
                        tbody += '<a href="<?=site_url()?>assets/app/tickets/image/'+resp.data.insertId+'.jpg" target="_blank">';
                        tbody += '<img src="<?=site_url()?>assets/app/tickets/image/'+resp.data.insertId+'.jpg" width="50" height="50" style="vertical-align: text-top;margin-right:10px;" />';
                        tbody +=  data.get("fst_doc_title");
                        tbody +=  '</a>';
                        tbody +=  '</td>';
                        tbody += '<td>'+data.get("fst_memo")+'</td>';
                        tbody += '<td>'+App.dateTimeFormat("<?= date("Y-m-d H:i:s")?>")+'</td>';
                        tbody += '<td class="text-center">';                            
                        tbody += '<a class="btn btn-delete-doc" data-docid="'+resp.data.insertId+'" ><i class="fa fa-trash"></i></a>';
                        tbody += '</td>';
                        tbody += '</tr>';


                        $("#tblbodydocs").prepend(tbody);
                    }
                },
                error: function (e) {
                    $("#result").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#btnSubmit").prop("disabled", false);
                }
            });
        }   

    });

    $("#tblbodydocs").on("click",".btn-delete-doc",function(event){
        event.preventDefault();
        var docId = $(this).data("docid");
        var confirmDelete = confirm("Delete Lampiran");
        if (confirmDelete){
            row = $(this).parents('tr');
            App.blockUIOnAjaxRequest("Delete attachment .....");
            $.ajax({
                url:"<?=site_url()?>tr/ticket/ajx_delete_doc/" + docId,
                method:"GET",
            }).done(function(resp){
                if (resp.message !=""){
                    alert(resp.message);
                }

                if (resp.status =="SUCCESS"){
                    row.remove();
                }
            });
        }

    });

});


</script>

<script type="text/javascript">
    var $active_user = "<?= $this->aauth->get_user_id()?>";
    var $issuedByOthers = "<?= getDbConfig("issued_by_others")?>";
    $(function(){

        <?php if($mode != "ADD"){?>
            init_form($("#fin_ticket_id").val());
        <?php }?>

        $("#btnSubmitAjax").click(function(event){
            event.preventDefault();
            //data = new FormData($("#frmticket")[0]);
            data = $("#frmTicket").serializeArray();

            // TAMBAHAN 21/04/2020 11.40 service level harus diisi
            if ($("#select-ticketType").find(":selected").data("notice") == "NOTICE" && "INFO"){
                $("#fst_assignment_or_notice").val("INFO");
                $("#fst_assignment_or_notice").val("NOTICE");
                $("#select-serviceLevel").val(null).trigger("change.select2");
                $("#select-serviceLevel").prop("disabled", true);
            }else if ($("#select-ticketType").find(":selected").data("notice") == "ASSIGNMENT"){
                $("#fst_assignment_or_notice").val("ASSIGNMENT");
                $("#select-serviceLevel").prop("disabled", false);
                if ($("#select-serviceLevel").val() == 0){
                    alert("<?=lang('Pilih Service Level ...!')?>");
                    return;
                }
            }

            // TAMBAHAN 21/04/2020 16.56 Issued To harus diisi. selain INFO
            if ($("#select-ticketType").find(":selected").data("notice") == "INFO"){
                $("#select-toUser").val(null).trigger("change.select2");
                $("#select-toUser").prop("disabled", true);
            }else if ($("#select-ticketType").find(":selected").data("notice") == "NOTICE" || "ASSIGNMENT"){
                $("#select-toUser").prop("disabled", false);
                if($("#select-toUser").val() == 0){
                    alert("<?=lang('Pilih Issued To ...!')?>");
                    return;
                }
            }

            // TAMBAHAN 21/04/2020 15.00 filter issued to
            if ($("#select-toUser").val() == $("#select-users").val()){
                alert("<?=lang('IssuedBy tidak boleh sama dengan IssuedTo!!!')?>");
                return;
            }

            if ( $issuedByOthers == 0 && $("#select-users").val() != $active_user){
                alert("<?=lang('Cek IssuedBy!!!')?>");
                return;
            }

            // TAMBAHAN 17/04/2020 19.34 approved by harus diisi
            if ($("#select-ticketType").find(":selected").data("fbl") == "0"){
                $("#select-status").html("<option value='APPROVED/OPEN'><?=lang("APPROVED/OPEN")?></option>");
                $("#fbl_need_approval").val("0");
                $("#select-approvedby").val(null).prop("disabled", true);
            } else if ($("#select-ticketType").find(":selected").data("fbl") == "1"){
                $("#select-status").html("<option value='NEED_APPROVAL'><?=lang("NEED APPROVAL")?></option>");
                $("#fbl_need_approval").val("1");
                $("#select-approvedby").prop("disabled", false);
                if ($("#select-approvedby").val() == null){
                    alert("<?=lang('Pilih Approved By ....!')?>");
                    return;
                }
            }

            mode = $("#frm-mode").val();
            if (mode != "VIEW"){
                url = "<?= site_url() ?>tr/ticket/ajx_add_save";
            }else{
                url = "<?= site_url() ?>tr/ticket/ajx_view_save";
            }

            App.blockUIOnAjaxRequest("Please wait while saving data.....");
            $.ajax({
                type: "POST",
                //enctype: 'multipart/form-data',
                url: url,
                data: data,
                //processData: false,
                //contentType: false,
                //cache: false,
                timeout: 600000,
                success: function (resp) {
                    if (resp.message != "") {
                        $.alert({
                            title: 'Message',
                            content: resp.message,
                            buttons: {
                                OK : function(){
                                    if (resp.status == "SUCCESS"){
                                        $("#btnNew").trigger("click");
                                        return;
                                    }
                                },
                            }
                        });
                    }

                    if (resp.status == "VALIDATION_FORM_FAILED"){
                        //Show Error\\
                        errors = resp.data;
                        for (key in errors) {
                            $("#" + key + "_err").html(errors[key]);
                        }
                    }else if(resp.status == "SUCCESS") {
                        data = resp.data;
                        $("#fin_ticket_id").val(data.insert_id);

                        //Clear all previous error\\
                        $(".text-danger").html("");

                        //Change to Edit Mode\\
                        $("#frm-mode").val("VIEW"); //ADD|EDIT|VIEW\\
                        $('#fst_ticket_no').prop('readonly', true);

                    }
                },
                error: function (e) {
                    $("#result").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#btnSubmit").prop("disabled", false);
                }
            });
        });

        $("#btnNew").click(function(e){
            e.preventDefault();
            window.location.replace("<?=site_url()?>tr/ticket/add");
        });

        $("#btnList").click(function(e){
            e.preventDefault();
            window.location.replace("<?=site_url()?>tr/ticket/lizt");
        });

        /*$("#btnDelete").confirmation({
            title:"<?=lang("Void data ini ?")?>",
            rootSelector: '#btnDelete',
            placement: 'left',
        });
        $("#btnDelete").click(function(e){
            e.preventDefault();
            blockUIOnAjaxRequest("<h5>Void ....</h5>");
            $.ajax({
                url:"<?= site_url() ?>tr/ticket/delete/" + $("#fin_ticket_id").val(),
            }).done(function(resp){
                //consoleLog(resp):
                $.unblockUI();
                if (resp.message != "") {
                    $.alert({
                        title: 'Message',
                        content: resp.message,
                        buttons: {
                            OK : function() {
                                if (resp.status == "SUCCESS") {
                                    window.location.href = "<?=site_url() ?>tr/ticket/add";
                                    return;
                                }
                            },
                        }
                    });
                }

                if (resp.status == "SUCCESS") {
                    data = resp.data;
                    //$("#fin_ticket_id").val(data.insert_id);

                    //Clear all previous error
                    $(".text-danger").html("");
                    //Change to Edit Mode
                    $("#frm-mode").val("VIEW"); //ADD|EDIT|VIEW\\
                    $('#fst_ticket_no').prop('readonly', true);
                }
            });
        });*/

        $("#fdt_ticket_datetime").val(dateTimeFormat("<?= date("Y-m-d H:i:s")?>")).datetimepicker("update");

        mode = $("#frm-mode").val();
        if(mode != "VIEW"){
            $("#select-ticketType").change(function(event){
                event.preventDefault();
                <?php $acceptance_expiry = getDbConfig("acceptance_expiry")?>
                <?php $notify_deadline = getDbConfig("notify_deadline")?>

                var ticketType = $("#select-ticketType option:selected").data("notice");
                if (ticketType == "NOTICE" || ticketType == "INFO" ){

                    $("#select-serviceLevel").val(null).trigger("change.select2");
                    $("#select-serviceLevel").prop("disabled", true);
                }else{
                    
                    $("#select-serviceLevel").prop("disabled", false);
                }

                if (ticketType == "INFO" ){
                    $("#select-department").prop("disabled", false);
                }else{
                    $("#select-department").val(null).trigger("change.select2");
                    $("#select-department").prop("disabled", true);
                }

                // Tambahan 31/03/2020 16.15
                if (ticketType == "ASSIGNMENT" || ticketType == "NOTICE" ) {
                    $("#select-toUser").prop("disabled", false);
                } else {
                    $("#select-toUser").val(null).trigger("change.select2");
                    $("#select-toUser").prop("disabled", true);
                }
                
                $("#select-ticketType").each(function(index){
                    if($(this).find(":selected").data("notice") == "NOTICE"){
                        $("#select-serviceLevel").val(null).trigger("change.select2");
                        $("#select-serviceLevel").prop("disabled", true);
                        //$("#fdt_deadline_extended_datetime").val(dateTimeFormat("<?= date("Y-m-d H:i:s", strtotime("{$notify_deadline}days"))?>")).prop("disabled", true); // 19/03/2020 dimatikan
                        $("#fdt_acceptance_expiry_datetime").val(dateTimeFormat("<?= date("Y-m-d H:i:s", strtotime('01-01-3000 00:00:00'))?>")).prop("disabled", true);
                        $("#fst_assignment_or_notice").val("NOTICE");
                        $("#fdt_deadline_extended_datetime").val(null);                 //tambahan 31/03/2020 17.24
                        $("#fdt_deadline_extended_datetime").prop("disabled", true);    //tambahan 31/03/2020 17.24
                    }else if($(this).find(":selected").data("notice") == "ASSIGNMENT"){
                        $("#fdt_acceptance_expiry_datetime").val(dateTimeFormat("<?= date("Y-m-d 23:59:59", strtotime("{$acceptance_expiry}days"))?>")).prop("disabled", true);
                        $("#fst_assignment_or_notice").val("ASSIGNMENT");
                        $("#fdt_deadline_extended_datetime").val(null);                 //tambahan 31/03/2020 17.24
                        $("#fdt_deadline_extended_datetime").prop("disabled", true);    //tambahan 31/03/2020 17.24
                        //$("#select-serviceLevel").val(null).trigger("change.select2");
                        //$("#select-serviceLevel").prop("disabled", false);
                    }else if($(this).find(":selected").data("notice") == "INFO"){
                        $("#fdt_deadline_extended_datetime").val(dateTimeFormat("<?= date("Y-m-d 23:59:59", strtotime("{$notify_deadline}days"))?>")).prop("disabled", true);
                        $("#fdt_acceptance_expiry_datetime").val(dateTimeFormat("<?= date("Y-m-d 23:59:59", strtotime("{$notify_deadline}days"))?>")).prop("disabled", true);
                        $("#fst_assignment_or_notice").val("INFO");
                        $("#select-serviceLevel").val(null).trigger("change.select2");
                        $("#select-serviceLevel").prop("disabled", true);
                    }
                });
            });

            /*$("#select-serviceLevel").change(function(event){
                event.preventDefault();
                //alert($("#select-serviceLevel option:selected").data("days"));
                $("#select-serviceLevel").each(function(index){
                    if ($(this).find(":selected").data("days") == "1"){
                        $("#fdt_deadline_extended_datetime").val(dateTimeFormat("<?= date("Y-m-d H:i:s", strtotime('1 days'))?>")).prop("disabled", true);
                        $("#fin_service_level_days").val("1");
                    }else if ($(this).find(":selected").data("days") == "2"){
                        $("#fdt_deadline_extended_datetime").val(dateTimeFormat("<?= date("Y-m-d H:i:s", strtotime('2 days'))?>")).prop("disabled", true);
                        $("#fin_service_level_days").val("2");
                    }else if ($(this).find(":selected").data("days") == "3"){
                        $("#fdt_deadline_extended_datetime").val(dateTimeFormat("<?= date("Y-m-d H:i:s", strtotime('3 days'))?>")).prop("disabled", true);
                        $("#fin_service_level_days").val("3");
                    }else if ($(this).find(":selected").data("days") == "4"){
                        $("#fdt_deadline_extended_datetime").val(dateTimeFormat("<?= date("Y-m-d H:i:s", strtotime('4 days'))?>")).prop("disabled", true);
                        $("#fin_service_level_days").val("4");
                    }else if ($(this).find(":selected").data("days") == "5"){
                        $("#fdt_deadline_extended_datetime").val(dateTimeFormat("<?= date("Y-m-d H:i:s", strtotime('5 days'))?>")).prop("disabled", true);
                        $("#fin_service_level_days").val("5");
                    }else if ($(this).find(":selected").data("days") == "6"){
                        $("#fdt_deadline_extended_datetime").val(dateTimeFormat("<?= date("Y-m-d H:i:s", strtotime('6 days'))?>")).prop("disabled", true);
                        $("#fin_service_level_days").val("6");
                    }
                });
            });*/   // 19/03/2020 enny jangan dihapus utk dokumentasi
        }

        mode = $("#frm-mode").val();
        if(mode != "VIEW"){
            $("#select-ticketType").change(function(event){
                event.preventDefault();

                //alert($("#select-ticketType option:selected").data("fbl"));
                if($(this).find(":selected").data("fbl") == "0"){
                    //$("#select-status").val("APPROVED/OPEN");
                    $("#select-status").html("<option value='APPROVED/OPEN'><?=lang("APPROVED/OPEN")?></option>");
                    $("#fbl_need_approval").val("0");
                    $("#select-approvedby").val(null).prop("disabled", true);
                }else if($(this).find(":selected").data("fbl") == "1"){
                    //$("#select-status").val("NEED_APPROVAL");
                    $("#select-status").html("<option value='NEED_APPROVAL'><?=lang("NEED APPROVAL")?></option>");
                    $("#fbl_need_approval").val("1");
                    $("#select-approvedby").prop("disabled", false);
                }
            });
        }

    });

    function init_form(fin_ticket_id){

        //alert("Init Form);
        var $userActive ="<?= $this->aauth->get_user_id()?>";
        var url = "<?=site_url()?>tr/ticket/fetch_data/" + fin_ticket_id;
        var d = new Date();
        d.setDate(d.getDate() + 0);
        $.ajax({
            type: "GET",
            url: url,
            success: function (resp) {
                console.log(resp.ms_ticket);
                var ticket_no = $("#fst_ticket_no").val();
                $.each(resp.ms_ticket, function(name, val){
                    var $el = $('[name="'+name+'"]'),
                    type = $el.attr('type');
                    switch(type){
                        case 'checkbox':
                            $el.filter('[value="' + val + '"]').attr('checked', 'checked');
                            break;
                        case 'radio':
                            $el.filter('[value="' + val + '"]').attr('checked', 'checked');
                            break;
                        default:
                            $el.val(val);
                            console.log(val);
                    }
                });

                $("#fdt_ticket_datetime").datetimepicker('update', dateTimeFormat(resp.ms_ticket.fdt_ticket_datetime));
                $("#fdt_acceptance_expiry_datetime").datetimepicker('update', dateTimeFormat(resp.ms_ticket.fdt_acceptance_expiry_datetime));

                if (resp.ms_ticket.fdt_deadline_extended_datetime == null) {
                    $("#fdt_deadline_extended_datetime").datetimepicker();
                } else {
                    $("#fdt_deadline_extended_datetime").datetimepicker('update', dateTimeFormat(resp.ms_ticket.fdt_deadline_extended_datetime));
                }

                var newOption = new Option(resp.ms_ticket.fst_ticket_type_name, true);
                $('#select-ticketType').append(newOption).trigger('change');
                
                var newOption = new Option(resp.ms_ticket.fst_service_level_name, true);
                $('#select-serviceLevel').append(newOption).trigger('change');

                var newOption = new Option(resp.ms_ticket.userActive, true);
                $('#select-users').append(newOption).trigger('change');
                var newOption = new Option(resp.ms_ticket.fst_username, true);
                $('#select-toUser').append(newOption).trigger('change');

                var newOption = new Option(resp.ms_ticket.fst_status, true);
                $('#select-status').append(newOption).trigger('change');

                var newOption = new Option(resp.ms_ticket.fst_username, true);
                $('#select-approvedby').append(newOption).trigger('change');

                var newOption = new Option(resp.ms_ticket.fin_department_id, true);
                $('#select-department').append(newOption).trigger('change');

                //populate Ticket Log
                var issuedBy = resp.ms_ticket.fin_issued_by_user_id;
                var ticketStatus = resp.ms_ticket.fst_status;
                //alert(ticketStatus);
                if ($userActive == issuedBy && (ticketStatus =="APPROVED/OPEN" || ticketStatus =="NEED_APPROVAL")){
                    $("#frmTicketlampiran").show();
                    //alert(issuedBy);
                    //alert(ticketStatus);
                }else{
                    $("#frmTicketlampiran").hide();
                }
                //Tampilan Nav Tabs Ticket Log
                $.each(resp.ms_ticketlog, function(name, val) {
                    console.log(val);
                    //event.preventDefault();
                    if (val.fst_username == null ){
                        val.fst_username = 'SYSTEM';
                    }
                    if(val.fin_status_by_user_id == issuedBy){
                        var cardlog = '<div class="column col-md-12">';
                            cardlog += '<div class="card-issued">';
                            cardlog += '<div class="card-body">';
                                cardlog += '<p class="card-title">';
                                cardlog += '<div class ="col-md-4"><strong><i class="fa fa-user"></i>'+val.fst_username+'</strong></div>';
                                cardlog += '<span class="badge badge-primary badge-pill">';
                                cardlog += '<div class ="col-md-4">'+val.fdt_status_datetime+'</div></span>';
                                cardlog += '<div class ="col-md-4"><span class="badge badge-primary badge-pill">'+val.fst_status+'</span></div>';
                                cardlog += '</p>';
                        cardlog +=  '</div>';
                        cardlog += '<div class="direct-chat-msg">';
                            cardlog += '<div class="direct-chat-text">'+val.fst_status_memo+'</div>';
                        cardlog += '</div>';
                        
                        cardlog +=  '</div>';
                        cardlog +=  '</div>';
                        $("#ticketlog_card").append(cardlog);
                    }else{
                        var cardlog = '<div class="column col-md-12">';
                            cardlog += '<div class="card-received">';
                            cardlog += '<div class="card-body">';
                                cardlog += '<p class="card-title">';
                                cardlog += '<div class ="col-md-4"><strong><i class="fa fa-user"></i>'+val.fst_username+'</strong></div>';
                                cardlog += '<span class="badge badge-primary badge-pill">';
                                cardlog += '<div class ="col-md-4">'+val.fdt_status_datetime+'</div></span>';
                                cardlog += '<div class ="col-md-4"><span class="badge badge-primary badge-pill">'+val.fst_status+'</span></div>';
                                cardlog += '</p>';
                        cardlog +=  '</div>';
                        cardlog += '<div class="direct-chat-msg">';
                            cardlog += '<div class="direct-chat-text">'+val.fst_status_memo+'</div>';
                        cardlog += '</div>';

                        cardlog +=  '</div>';
                        cardlog +=  '</div>';
                        $("#ticketlog_card").append(cardlog);
                    }
                })

                //Ticket Docs
                $.each(resp.ms_ticketdocs, function(name, val) {
                    console.log(val);
                    //    var tbody = '<tr>';
                    //        tbody += '<td style="width:30%"><a href="<?=site_url()?>assets/app/tickets/image/'+val.fin_rec_id+'.jpg" target="_blank">'+val.fst_doc_title+'</a></td>';
                    //        tbody += '<td style="width:50%">'+val.fst_memo+'</td>';
                    //        tbody += '<td style="width:30%">'+val.fdt_insert_datetime+'</td>';
                    //    tbody += '</tr>';
                    //$("#tblbodydocs").append(tbody);
                    var tbody = '<tr id="doc_' + val.fin_rec_id + '">';                            
                        tbody += '<td>';
                        tbody += '<a href="<?=site_url()?>assets/app/tickets/image/'+val.fin_rec_id+'.jpg" target="_blank">';
                        tbody += '<img src="<?=site_url()?>assets/app/tickets/image/'+val.fin_rec_id+'.jpg" width="50" height="50" style="vertical-align: text-top;margin-right:10px;" />';
                        tbody +=  val.fst_doc_title;
                        tbody +=  '</a>';
                        tbody +=  '</td>';
                        tbody += '<td>'+val.fst_memo+'</td>';
                        tbody += '<td>'+val.fdt_insert_datetime+'</td>';
                        tbody += '<td class="text-center">';
                        if ( <?= $this->aauth->get_user_id() ?> == val.fin_insert_id){
                            tbody += '<a class="btn btn-delete-doc" data-docid="'+val.fin_rec_id+'" ><i class="fa fa-trash"></i></a>';
                        }                        
                        tbody += '</td>';
                    tbody += '</tr>';
                    $("#tblbodydocs").append(tbody);
                })

                //Image Load
                $('#imgLampiran').attr("src",resp.ms_ticket.lampiranURL);

                if(issuedBy != $userActive){
                    $("#btnVoid").hide();
                }

                if (mode == "COPY"){
                    $("#fst_ticket_no").val(ticket_no);
                    $("#fdt_ticket_datetime").datetimepicker('update', dateTimeFormat(d));
                    $('#select-users').select2();
                }

            },
            error: function (e) {
                $("#result").text(e.responseText);
                console.log("ERROR : ", e);
            }
        });

        $("#btnLizt").click(function(e){
            e.preventDefault();
            window.location.replace("<?=site_url()?>tr/ticket/lizt");
        });

        $("#btnVoid").confirmation({
            title:"<?=lang("Void data ini ?")?>",
            rootSelector: '#btnDelete',
            placement: 'left',
        });
        $("#btnVoid").click(function(e){
            e.preventDefault();
            blockUIOnAjaxRequest("<h5>Void ....</h5>");
            $.ajax({
                url:"<?= site_url() ?>tr/ticket/void/" + $("#fin_ticket_id").val(),
            }).done(function(resp){
                //consoleLog(resp):
                $.unblockUI();
                if (resp.message != "") {
                    consoleLog(resp);
                    $.alert({
                        title: 'Message',
                        content: resp.message,
                        buttons: {
                            OK : function() {
                                if (resp.status == "SUCCESS") {
                                    window.location.href = "<?=site_url() ?>tr/ticket/lizt";
                                    return;
                                }
                            },
                        }
                    });
                }

                if (resp.status == "SUCCESS") {
                    data = resp.data;
                    //$("#fin_ticket_id").val(data.insert_id);

                    //Clear all previous error
                    $(".text-danger").html("");
                    //Change to Edit Mode
                    $("#frm-mode").val("VIEW"); //ADD|EDIT|VIEW\\
                    $('#fst_ticket_no').prop('readonly', true);
                }
            });
        });
    }
</script>

<!-- Select2 -->
<script src="<?= COMPONENT_URL ?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- DataTables -->
<script src="<?= COMPONENT_URL ?>bower_components/datatables.net/datatables.min.js"></script>