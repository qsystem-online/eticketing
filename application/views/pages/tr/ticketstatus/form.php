<?php
defined('BASEPATH') or exit ('No direct script access allowed');
?>
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/datatables.net/datatables.min.css">

<style type="text/css">
    .border-0{
        border: 0px;
    }
    td{
        padding: 2px; !important
    }
    .form-group{
		margin-bottom:10px;
	}
</style>

<section class="content-header">
    <h1><?= lang("Ticket") ?><small><?= lang("form") ?></small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
        <li><a href="#"><?= lang("Menus") ?></a></li>
        <li class="active title"><?= $title ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title title"><?= $title ?></h3>
                    <?php if ($mode != "VIEW") { ?>
                    <div class="btn-group btn-group-sm pull-right">
                        <a id="btnSubmitAjax" class="btn btn-primary" href="#" title="<?=lang("Update")?>"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
                    </div>
                    <?php } ?>
                </div>
                <!-- end box header -->

                <!-- form start -->
                <form id="frmTicket" class="form-horizontal" action="<?= site_url() ?>tr/ticket/add" method="POST" enctype="multipart/form-data">
                    <div class="box-body">
                        <input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">			
						<input type="hidden" id="frm-mode" value="<?=$mode?>">
                        <input type="hidden" class="form-control" id="fin_ticket_id" placeholder="<?=lang("(Autonumber)")?>" name="fin_ticket_id" value="<?=$fin_ticket_id?>" readonly>

                        <div class="form-group">
                            <label for="fst_ticket_no" class="col-xs-6 col-md-2 control-label"><?=lang("Ticket No.")?> #</label>
                            <div class="col-xs-6 col-md-10">
                                <input type="text" class="form-control" id="fst_ticket_no" placeholder="<?=lang("Ticket No.")?>" name="fst_ticket_no" readonly>
                                <div id="fst_ticket_no_err" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="select-ticketType" class="col-xs-6 col-md-2 control-label"><?=lang("Ticket Type")?></label>
                            <div class="col-xs-6 col-md-4">
                                <select id="select-ticketType" class="form-control select2" name="fin_ticket_type_id">
                                    <?php
                                        $tickettypeList = $this->tickettype_model->get_data_ticketType();
                                        foreach ($tickettypeList as $ticketType) {
                                            echo "<option value='$ticketType->fin_ticket_type_id'>$ticketType->fst_ticket_type_name</option>";
                                        }
                                    ?>
                                </select>
                                <div id="fin_ticket_type_id_err" class="text-danger"></div>
                            </div>
                        
                            <label for="select_serviceLevel" class="col-xs-6 col-md-2 control-label"><?=lang("Service Level")?></label>
                            <div class="col-xs-6 col-md-4 personal-info">
                                <select id="select-serviceLevel" class="form-control select2" name="fin_service_level_id">
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
                                    <input type="text" class="form-control text-right datetimepicker" id="fdt_ticket_datetime" name="fdt_ticket_datetime"/>								
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
                                    <input type="text" class="form-control text-right datetimepicker" id="fdt_acceptance_expiry_datetime" name="fdt_acceptance_expiry_datetime"/>
                                </div>
                                <div id="fdt_acceptance_expiry_datetime_err" class="text-danger"></div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="fdt_deadline_datetime" class="col-xs-6 col-md-2 control-label"><?=lang("Deadline Datetime")?></label>
                            <div class="col-xs-6 col-md-3">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control text-right datetimepicker" id="fdt_deadline_datetime" name="fdt_deadline_datetime"/>
                                </div>
                                <div id="fdt_deadline_datetime_err" class="text-danger"></div>
                            </div>
 
                            <label for="fdt_deadline_extended_datetime" class="col-xs-6 col-md-4 control-label"><?=lang("Deadline Extended Datetime")?></label>
                            <div class="col-xs-6 col-md-3">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control text-right datetimepicker" id="fdt_deadline_extended_datetime" name="fdt_deadline_extended_datetime"/>
                                </div>
                                <div id="fdt_deadline_extended_datetime_err" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="select-users" class="col-xs-6 col-md-2 control-label"><?=lang("Issued By")?></label>
                            <div class="col-xs-6 col-md-4">
                                <?php
                                    $active_user = $this->session->userdata("active_user");
                                    //$usersList = $this->users_model->getByUserList();			
                                    //$branchs = $this->msbranches_model->getAllList();
                                ?>
                                <select id="select-users" class="form-control select2" name="fin_issued_by_user_id">
                                    <?php
                                        $touserList = $this->users_model->getToUserList();
                                        foreach ($touserList as $toUser){
                                            echo "<option value='$toUser->fin_user_id'>$toUser->fst_username</option>";
                                        }
                                    ?>
                                </select>
                                <div id="fin_issued_by_user_id_err" class="text-danger"></div>
                            </div>

                            <label for="select-toUser" class="col-xs-6 col-md-2 control-label"><?=lang("Issued To")?></label>
                            <div class="col-xs-6 col-md-4">
                                <select id="select-toUser" class="form-control select2" name="fin_issued_to_user_id">
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
                            <label for="fst_status" class="col-xs-6 col-md-2 control-label"><?=lang("Last Status")?></label>
                            <div class="col-xs-6 col-md-4">
                                <select class="form-control" id="fst_status" name="fst_status" >
                                    <option value='NEED_APPROVAL'><?=lang("NEED APPROVAL")?></option>
                                    <option value='APPROVED/OPEN'><?=lang("APPROVED/OPEN")?></option>
                                    <option value='ACCEPTED'><?=lang("ACCEPTED")?></option>
                                    <option value='NEED_REVISION'><?=lang("NEED REVISION")?></option>
                                    <option valeu='COMPLETED'><?=lang("COMPLETED")?></option>
                                    <option valeu='CLOSED'><?=lang("CLOSED")?></option>
                                    <option valeu='ACCEPTANCE_EXP'><?=lang("ACCEPTANCE EXPIRED")?></option>
                                    <option valeu='TICKET_EXP'><?=lang("TICKET EXPIRED")?></option>
                                    <option valeu='VOID'><?=lang("VOID")?></option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fst_update_status" class="col-xs-6 col-md-2 control-label"><?=lang("Update Status")?></label>
                            <div class="col-xs-6 col-md-4">
                                <select class="form-control" id="fst_update_status" name="fst_update_status">

                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fst_memo" class="col-md-2 control-label"><?= lang("Memo") ?></label>
                            <div class="col-md-10">
                                <textarea rows="4" style="width:100%" class="form-control" id="fst_memo" placeholder="<?= lang("Memo") ?>" name="fst_memo"></textarea>
                            </div>
                        </div>
                    </div>
                    <!-- end box body -->

                    <div class="box-footer text-right"></div>

                    <!-- end box-footer -->
                </form>
            </div>
        </div>
</section>

<script type="text/javascript">
    $(function(){
        <?php if($mode == "EDIT"){?>
            init_form($("#fin_ticket_id").val());
        <?php } ?>

        $("#btnSubmitAjax").click(function(event){
            $("#select-users").prop("disabled",false);
            event.preventDefault();
            //data = new FormData($("#frmticket")[0]);
            data = $("#frmTicket").serializeArray();

            mode = $("#frm-mode").val();
            if (mode == "ADD"){
                url = "<?= site_url() ?>tr/ticketstatus/ajx_add_save";
            }else{
                url = "<?= site_url() ?>tr/ticketstatus/ajx_update_status";
            }

            App.blockUIOnAjaxRequest("Please wait while update ticket status.....");
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
                        //Show Error
                        errors = resp.data;
                        for (key in errors) {
                            $("#" + key + "_err").html(errors[key]);
                        }
                    }else if(resp.status == "SUCCESS") {
                        data = resp.data;
                        $("#fin_ticket_id").val(data.insert_id);

                        //Clear all previous error
                        $(".text-danger").html("");

                        //Change to Edit Mode
                        $("#frm-mode").val("EDIT"); //ADD|EDIT
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

        $("#fdt_ticket_datetime").val(dateTimeFormat("<?= date("Y-m-d H:i:s")?>")).datetimepicker("update");
    })

    function init_form(fin_ticket_id){
        //alert("Init Form);
        var url = "<?=site_url()?>tr/ticket/fetch_data/" + fin_ticket_id;
        $("#fst_status").prop("disabled",true);
        $("#select-toUser").prop("disabled",true);
        $("#select-users").prop("disabled",true);
        $.ajax({
            type: "GET",
            url: url,
            success: function (resp) {
                console.log(resp.ms_ticket);

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
                $("#fdt_deadline_datetime").datetimepicker('update', dateTimeFormat(resp.ms_ticket.fdt_deadline_datetime));
                $("#fdt_deadline_extended_datetime").datetimepicker('update', dateTimeFormat(resp.ms_ticket.fdt_deadline_extended_datetime));
                $("#fdt_ticket_expiry_extended_datetime").datetimepicker('update', dateTimeFormat(resp.ms_ticket.fdt_ticket_expiry_extended_datetime));

                var newOption = new Option(resp.ms_ticket.fst_ticket_type_name, resp.ms_ticket.fin_ticket_type_id, true, true);
                $('#select-ticketType').append(newOption).trigger('change');
                
                var newOption = new Option(resp.ms_ticket.fst_service_level_name, resp.ms_ticket.fin_service_level_id, true, true);
                $('#select-serviceLevel').append(newOption).trigger('change');

                var newOption = new Option(resp.ms_ticket.fin_issued_by_user_id, true);
                $('#select-users').append(newOption).trigger('change');
                var newOption = new Option(resp.ms_ticket.fin_issued_to_user_id, true);
                $('#select-toUser').append(newOption).trigger('change');

                if (resp.ms_ticket.fst_status == "APPROVED/OPEN"){
                    //$('#fst_update_status').val("NEED_APPROVAL",true).prop(disabled="disabled");
                    array_of_options = ['ACCEPTED', 'NEED_REVISION',]
                    $.each(array_of_options, function(i, item) {
                        sel_op = ''; 
                        dis_op = ''; 
                        $('<option ' + sel_op + ' ' + dis_op + '/>').val(item).html(item).appendTo('#fst_update_status');
                    })
                }

                if (resp.ms_ticket.fst_status == "NEED_REVISION"){
                    //$('#fst_update_status').val("NEED_APPROVAL",true).prop(disabled="disabled");
                    array_of_options = ['ACCEPTED', 'APPROVED/OPEN',]
                    $.each(array_of_options, function(i, item) {
                        sel_op = ''; 
                        dis_op = ''; 
                        $('<option ' + sel_op + ' ' + dis_op + '/>').val(item).html(item).appendTo('#fst_update_status');
                    })
                }

                if (resp.ms_ticket.fst_status == "ACCEPTED"){
                    //$('#fst_update_status').val("NEED_APPROVAL",true).prop(disabled="disabled");
                    array_of_options = ['NEED_REVISION','COMPLETED']
                    $.each(array_of_options, function(i, item) {
                        sel_op = ''; 
                        dis_op = ''; 
                        $('<option ' + sel_op + ' ' + dis_op + '/>').val(item).html(item).appendTo('#fst_update_status');
                    })
                }

                if (resp.ms_ticket.fst_status == "COMPLETED"){
                    //$('#fst_update_status').val("NEED_APPROVAL",true).prop(disabled="disabled");
                    array_of_options = ['CLOSED','NEED_REVISION']
                    $.each(array_of_options, function(i, item) {
                        sel_op = ''; 
                        dis_op = ''; 
                        $('<option ' + sel_op + ' ' + dis_op + '/>').val(item).html(item).appendTo('#fst_update_status');
                    })
                }

                //<select id="tagging"></select>
                //array_of_options = ['Choose Tagging', 'Option A', 'Option B', 'Option C']
                //$.each(array_of_options, function(i, item) {
                    //if(i==0) { 
                        //sel_op = 'selected'; 
                        //dis_op = 'disabled'; 
                    //} else { 
                        //sel_op = ''; 
                        //dis_op = ''; }
                    //$('<option ' + sel_op + ' ' + dis_op + '/>').val(item).html(item).appendTo('#tagging');
                //})

            },

            error: function (e) {
                $("#result").text(e.responseText);
                console.log("ERROR : ", e);
            }
        });
    }
</script>

<!-- Select2 -->
<script src="<?= COMPONENT_URL ?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- DataTables -->
<script src="<?= COMPONENT_URL ?>bower_components/datatables.net/datatables.min.js"></script>