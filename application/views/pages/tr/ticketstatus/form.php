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
<style>
    {
        box-sizing: border-box;
    }

    body {
        font-family: Arial, Helvetica, sans-serif;
    }

    /* Float four columns side by side 
    .column {
        float: left;
        width: 25%;
        padding: 0 10px;
    }*/

    /* Remove extra left and right margins, due to padding */
    .row {
        margin: 0 -5px;
    }

    /* Clear floats after the columns */
    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    /* Responsive columns 
    @media screen and (max-width: 600px) {
    .column {
        width: 100%;
        display: block;
        margin-bottom: 20px;
    }
    }*/

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
    <h1><?= lang("Ticket Status") ?><small><?= lang("Form") ?></small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
        <li><a href="#"><?= lang("Transaksi") ?></a></li>
        <li><a href="#"><?= lang("Ticket Status") ?></a></li>
        <li class="active title"><?= $title ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title title"><?= $title ?></h3>
                </div>
                <!-- end box header -->
                <div class="box-body">
                    <!-- form start -->
                    <form id="frmTicketStatus" class="form-horizontal" action="<?=site_url()?>tr/ticketstatus/Update" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">			
                        <input type="hidden" id="frm-mode" value="<?=$mode?>">
                        <input type="hidden" class="form-control" id="fin_ticket_id" placeholder="<?=lang("(Autonumber)")?>" name="fin_ticket_id" value="<?=$fin_ticket_id?>" readonly>
                        <input type="hidden" class="form-control" id="fin_service_level_days" name="fin_service_level_days" readonly>
                        <div class="form-group">
                            <label for="fst_update_status" class="col-xs-6 col-md-2 control-label"><?=lang("Update Status")?></label>
                            <div class="col-xs-6 col-md-10">
                                <select class="form-control" id="fst_update_status" name="fst_update_status">
                                </select>
                                <div id="fst_update_status_err" class="text-danger"></div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="fdt_update_deadline_extended_datetime" class="col-xs-6 col-md-2 control-label"><?=lang("Deadline Datetime")?></label>
                            <div class="col-xs-6 col-md-3">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control text-right datetimepicker" id="fdt_update_deadline_extended_datetime" name="fdt_update_deadline_extended_datetime">
                                </div>
                                <div id="fdt_deadline_extended_datetime_err" class="text-danger"></div>
                            </div>
                            <label for="select_update_serviceLevel" class="col-xs-6 col-md-2 control-label"><?=lang("Service Level")?></label>
                            <div class="col-xs-6 col-md-5 personal-info">
                                <select id="select_update_serviceLevel" class="form-control select2" name="fin_service_level_id" style="width: 100%">
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
                            <label for="fst_memo_update" class="col-xs-6 col-md-2 control-label"><?= lang("Memo") ?></label>
                            <div class="col-xs-6 col-md-10">
                                <textarea rows="4" style="width:100%" class="form-control" id="fst_memo_update" placeholder="<?= lang("Memo new status") ?>" name="fst_memo_update"></textarea>
                                <div id="fst_memo_update_err" class="text-danger"></div>
                            </div>
                        </div>
                        <button type="button"  id="btnSubmitAjax" href="#" class="btn btn-primary btn-block">Update</button>
                    </form>
                    
                    <div class="nav-tabs-custom" style="display:unset">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#ticket_log" data-toggle="tab" aria-expanded="true"><?= lang("Ticket Log")?></a></li>
                            <li class=""><a href="#ticket_info" data-toggle="tab" aria-expanded="true"><?= lang("Ticket Info")?></a></li>
                            <li class=""><a href="#ticket_lampiran" data-toggle="tab" aria-expanded="true"><?= lang("Lampiran")?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="ticket_log">
                                <div class="col-md-12" id="ticketlog_card">
                                </div>
                            </div> <!-- /.tab-pane -->  

                            <div class="tab-pane" id="ticket_info">	
                            <form id="frmTicketInfo" class="form-horizontal">							
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
                                        <select id="select-ticketType" class="form-control select2" name="fin_ticket_type_id" style="width: 100%" disabled>
                                            <?php
                                                $tickettypeList = $this->tickettype_model->getAllList();
                                                foreach ($tickettypeList as $ticketType) {
                                                    echo "<option value='$ticketType->fin_ticket_type_id'>$ticketType->fst_ticket_type_name</option>";
                                                }
                                            ?>
                                        </select>
                                        <div id="fin_ticket_type_id_err" class="text-danger"></div>
                                    </div>
                                
                                    <label for="select_serviceLevel" class="col-xs-6 col-md-2 control-label"><?=lang("Service Level")?></label>
                                    <div class="col-xs-6 col-md-4 personal-info">
                                        <select id="select-serviceLevel" class="form-control select2" name="fin_service_level_id" style="width: 100%" disabled>
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
                                        <select id="select-users" class="form-control select2" name="fin_issued_by_user_id" style="width: 100%" disabled>
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
                                        <select id="select-toUser" class="form-control select2" name="fin_issued_to_user_id" style="width: 100%" disabled>
                                            <?php
                                                $touserList = $this->users_model->getAllList();
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
                                        <select id="select-status" class="form-control" name="fst_status" style="width: 100%" disabled>
                                            <option value="NEED_APPROVAL"><?=lang("NEED APPROVAL")?></option>
                                            <option value="APPROVED/OPEN"><?=lang("APPROVED/OPEN")?></option>
                                            <option value="ACCEPTED"><?=lang("ACCEPTED")?></option>
                                            <option value="NEED_REVISION"><?=lang("NEED_REVISION")?></option>
                                            <option value="COMPLETED"><?=lang("COMPLETED")?></option>
                                            <option value="COMPLETION_REVISED"><?=lang("COMPLETION_REVISED")?></option>
                                            <option value="CLOSED"><?=lang("CLOSED")?></option>
                                            <option value="ACCEPTANCE_EXP"><?=lang("ACCEPTANCE EXPIRED")?></option>
                                            <option value="TICKET_EXP"><?=lang("TICKET EXPIRED")?></option>
                                            <option value="VOID"><?=lang("VOID")?></option>
                                            <option value="REJECTED"><?=lang("REJECTED")?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fst_memo" class="col-xs-6 col-md-2 control-label"><?= lang("Memo") ?></label>
                                    <div class="col-xs-6 col-md-10">
                                        <textarea rows="4" style="width:100%" class="form-control" id="fst_memo" placeholder="<?= lang("Memo") ?>" name="fst_memo" readonly></textarea>
                                    </div>
                                </div>			
                            </div>
                            </form>

                            <div class="tab-pane" id="ticket_lampiran">	
                                <form id="frmTicketlampiran" class="form-horizontal">
                                    <input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">			
                                    <div class="form-group">
                                        <label for="fst_lampiran" class="col-xs-6 col-md-2 control-label"><?=lang("Lampiran Gambar")?></label>
                                        <div class="col-xs-6 col-md-2">
                                            <input type="file" class="form-control" id="fst_lampiran"  name="fst_lampiran">
                                        </div>

                                        <div class="col-xs-12 col-md-8">
                                            <input type="text" class="form-control" id="fst_doc_title"  name="fst_doc_title">
                                        </div>
                                        
                                        

                                    </div>
                                    <div class="form-group">
                                        <label for="fst_lampiran" class="col-xs-6 col-md-2 control-label"><?=lang("Keterangan")?></label>
                                        <div class="col-xs-6 col-md-9">
                                            <textarea class="form-control" id="fst_doc_memo"  name="fst_memo" readonly></textarea>
                                        </div>
                                        <div class="col-xs-12 col-md-1">
                                            <button id="btn-add-doc" class="btn btn-primary">Add</button>
                                        </div>                                    
                                    </div>

                                    <!--                                                    
                                    <div class="form-group">
                                        <label for="fst_lampiran" class="col-xs-6 col-md-2 control-label"></label>
                                        <div class="col-xs-6 col-md-10">
                                            <img id="imgLampiran" style="border:0px solid #999;width:70%;" src="<?=site_url()?>assets/app/tickets/image/default.jpg"/>
                                        </div>
                                    </div>									
                                    -->
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
                            <!-- /.tab-pane -->
                        </div>				
                        <!-- /.tab-pane -->
                        <!-- /.tab-content -->
                    </div>
                            
                </div>
                <!-- end box body -->
                <div class="box-footer"></div>
                <!-- end box-footer -->
            </div>
        </div>
</section>
</div>

<script type="text/javascript">
    var $userActive ="<?= $this->aauth->get_user_id()?>";
    var $levelActive ="<?= $this->aauth->user('fin_user_id')->fin_level +1?>";
    $(function(){
        <?php if($mode == "EDIT"){?>
            init_form($("#fin_ticket_id").val());
        <?php } ?>

        $("#btnSubmitAjax").click(function(event){
            event.preventDefault();
            //$("#fdt_update_deadline_extended_datetime").prop("disabled",false);
            //data = $("#frmTicketStatus").serializeArray();
            data = new FormData($("#frmTicketStatus")[0]);

            
            mode = $("#frm-mode").val();
            if (mode == "EDIT"){
                url = "<?= site_url() ?>tr/ticketstatus/ajx_update_status";
            }

            App.blockUIOnAjaxRequest("Please wait while update ticket status.....");
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
                                    if (resp.status == "SUCCESS"){
                                        window.location.href = "<?=site_url() ?>home";
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

        $("#fst_lampiran").change(function(event){
			event.preventDefault();
			var reader = new FileReader();
			reader.onload = function (e) {
               $("#imgLampiran").attr('src', e.target.result);
            }
            reader.readAsDataURL(this.files[0]);
		});

        $("#fdt_ticket_datetime").val(dateTimeFormat("<?= date("Y-m-d H:i:s")?>")).datetimepicker("update");

        $("#fst_update_status").change(function(event){
            event.preventDefault();
            var leveldays = $('#fin_service_level_days').val();
            var days = parseInt(leveldays);
            //alert(leveldays);
            var d = new Date();
            d.setDate(d.getDate() + days);
            var dtdeadline = $("#fdt_update_deadline_extended_datetime").val();
            $("#select-status").each(function(index){
                if ($(this).val() == "APPROVED/OPEN" && dtdeadline == ""){
                    $("#fdt_update_deadline_extended_datetime").val(dateTimeFormat(d));
                }
            });
            
        });

        $("#btn-add-doc").click(function(event){
            event.preventDefault();
            data = new FormData($("#frmTicketlampiran")[0]);

            data.append("fin_ticket_id", $("#fin_ticket_id").val());
            
            url = "<?= site_url() ?>tr/ticketstatus/ajx_add_doc";

            App.blockUIOnAjaxRequest("Please wait while update ticket status.....");
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
                        $("#tblbodydocs").append("<tr id='doc_"+ resp.insertId +"'><td>"+data.get("fst_doc_title")+"</td><td>"+data.get("fst_memo")+"</td><td>"+ App.dateTimeFormat("<?= date("Y-m-d H:i:s")?>") +"</td></tr>");
                    }
                },
                error: function (e) {
                    $("#result").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#btnSubmit").prop("disabled", false);
                }
            });

        })

    })

    function init_form(fin_ticket_id){
        //alert("Init Form);
        var url = "<?=site_url()?>tr/ticketstatus/fetch_data/" + fin_ticket_id;
        $.ajax({
            type: "GET",
            url: url,
            success: function (resp) {
                console.log(resp.ms_ticketstatus);

                $.each(resp.ms_ticketstatus, function(name, val){
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

                if (resp.ms_ticketstatus.fdt_deadline_extended_datetime != null){
                    $("#fdt_ticket_datetime").datetimepicker('update', dateTimeFormat(resp.ms_ticketstatus.fdt_ticket_datetime));
                    $("#fdt_acceptance_expiry_datetime").datetimepicker('update', dateTimeFormat(resp.ms_ticketstatus.fdt_acceptance_expiry_datetime));
                    $("#fdt_update_deadline_extended_datetime").datetimepicker('update', dateTimeFormat(resp.ms_ticketstatus.fdt_deadline_extended_datetime));
                    $("#fdt_deadline_extended_datetime").datetimepicker('update', dateTimeFormat(resp.ms_ticketstatus.fdt_deadline_extended_datetime));
                    $("#fdt_ticket_expiry_extended_datetime").datetimepicker('update', dateTimeFormat(resp.ms_ticketstatus.fdt_ticket_expiry_extended_datetime));
                }

                var newOption = new Option(resp.ms_ticketstatus.fst_ticket_type_name, resp.ms_ticketstatus.fin_ticket_type_id, true, true);
                $('#select-ticketType').append(newOption).trigger('change');
                
                var newOption = new Option(resp.ms_ticketstatus.fst_service_level_name, true);
                $('#select-serviceLevel').append(newOption).trigger('change');

                var newOption = new Option(resp.ms_ticketstatus.fst_service_level_name, true);
                $('#select_update_serviceLevel').append(newOption).trigger('change');

                var newOption = new Option(resp.ms_ticketstatus.fin_issued_by_user_id, true);
                $('#select-users').append(newOption).trigger('change');
                var newOption = new Option(resp.ms_ticketstatus.fin_issued_to_user_id, true);
                $('#select-toUser').append(newOption).trigger('change');

                if (resp.ms_ticketstatus.fst_status == "NEED_APPROVAL"){
                    //$('#fst_update_status').val("NEED_APPROVAL",true).prop(disabled="disabled");
                    array_of_options = ['APPROVED/OPEN', 'REJECTED']
                    $.each(array_of_options, function(i, item) {
                        sel_op = ''; 
                        dis_op = ''; 
                        $('<option ' + sel_op + ' ' + dis_op + '/>').val(item).html(item).appendTo('#fst_update_status');
                    })
                    if(resp.ms_ticketstatus.fin_approved_by_user_id != $userActive){
                        $("#frmTicketStatus").hide();
                    }else{
                        $("#select_update_serviceLevel").prop("disabled",true);
                        $("#fdt_update_deadline_extended_datetime").prop("disabled",true);
                    }
                }

                if (resp.ms_ticketstatus.fst_status == "REJECTED" && resp.ms_ticketstatus.fin_issued_to_user_id != $userActive){
                    $("#frmTicketStatus").hide();
                }

                if (resp.ms_ticketstatus.fst_status == "APPROVED/OPEN"){
                    //$('#fst_update_status').val("NEED_APPROVAL",true).prop(disabled="disabled");
                    array_of_options = ['SELECT...','ACCEPTED', 'NEED_REVISION']
                    $.each(array_of_options, function(i, item) {
                        if(i==0) { 
                            sel_op = 'selected'; 
                            dis_op = 'disabled';
                        } else { 
                            sel_op = ''; 
                            dis_op = ''; 
                        }
                        $('<option ' + sel_op + ' ' + dis_op + '/>').val(item).html(item).appendTo('#fst_update_status');
                    })
                    if(resp.ms_ticketstatus.fin_issued_to_user_id != $userActive){
                        $("#frmTicketStatus").hide();
                    }else{
                        $("#select_update_serviceLevel").prop("disabled",true);
                        $("#fdt_update_deadline_extended_datetime").prop("disabled",true);
                    }
                }

                if (resp.ms_ticketstatus.fst_status == "NEED_REVISION"){
                    array_of_options = ['APPROVED/OPEN']
                    $.each(array_of_options, function(i, item) {
                        sel_op = ''; 
                        dis_op = ''; 
                        $('<option ' + sel_op + ' ' + dis_op + '/>').val(item).html(item).appendTo('#fst_update_status');
                    })
                    if(resp.ms_ticketstatus.fin_issued_by_user_id != $userActive){
                        $("#frmTicketStatus").hide();
                    }else{
                        $("#select_update_serviceLevel").prop("disabled",false);
                        $("#fdt_update_deadline_extended_datetime").prop("disabled",false);
                    }
                }

                if (resp.ms_ticketstatus.fst_status == "COMPLETION_REVISED"){
                    array_of_options = ['COMPLETED']
                    $.each(array_of_options, function(i, item) {
                        sel_op = ''; 
                        dis_op = ''; 
                        $('<option ' + sel_op + ' ' + dis_op + '/>').val(item).html(item).appendTo('#fst_update_status');
                    })
                    if(resp.ms_ticketstatus.fin_issued_to_user_id != $userActive){
                        $("#frmTicketStatus").hide();
                    }else{
                        $("#select_update_serviceLevel").prop("disabled",true);
                        $("#fdt_update_deadline_extended_datetime").prop("disabled",true);
                    }
                }

                if (resp.ms_ticketstatus.fst_status == "ACCEPTED"){
                    array_of_options = ['NEED_REVISION','COMPLETED']
                    $.each(array_of_options, function(i, item) {
                        sel_op = ''; 
                        dis_op = ''; 
                        $('<option ' + sel_op + ' ' + dis_op + '/>').val(item).html(item).appendTo('#fst_update_status');
                    })
                    if(resp.ms_ticketstatus.fin_issued_to_user_id != $userActive){
                        $("#frmTicketStatus").hide();
                    }else{
                        $("#select_update_serviceLevel").prop("disabled",true);
                        $("#fdt_update_deadline_extended_datetime").prop("disabled",true);
                    }
                }

                if (resp.ms_ticketstatus.fst_status == "COMPLETED"){
                    array_of_options = ['CLOSED','COMPLETION_REVISED']
                    $.each(array_of_options, function(i, item) {
                        sel_op = ''; 
                        dis_op = ''; 
                        $('<option ' + sel_op + ' ' + dis_op + '/>').val(item).html(item).appendTo('#fst_update_status');
                    })
                    if(resp.ms_ticketstatus.fin_issued_by_user_id != $userActive){
                        $("#frmTicketStatus").hide();
                    }else{
                        $("#select_update_serviceLevel").prop("disabled",true);
                        $("#fdt_update_deadline_extended_datetime").prop("disabled",true);
                    }
                }
                //populate Ticket Log
                var issuedBy = resp.ms_ticketstatus.fin_issued_by_user_id;
                //alert(issuedBy);
                $.each(resp.ms_ticketlog, function(name, val) {
                    console.log(val);
                    //event.preventDefault();
                    if(val.fin_status_by_user_id == issuedBy){
                        var cardlog = '<div class="column col-md-12">';
                            cardlog += '<div class="card-issued">';
                            cardlog += '<div class="card-body">';
                                cardlog += '<p class="card-title">';
                                cardlog += '<div class ="col-md-4"><strong><i class="fa fa-user"></i>'+val.fst_username+'</strong></div>';
                                cardlog += '<span class="badge badge-primary badge-pill">';
                                cardlog += '<div class ="col-md-4">'+val.fdt_status_datetime+'</div></span>';
                                //cardlog += '<span class="badge badge-primary badge-pill">';
                                cardlog += '<div class ="col-md-4"><span class="badge badge-primary badge-pill">'+val.fst_status+'</span></div>';
                                cardlog += '</p>';
                                //cardlog += '<hr>';
                                //cardlog += '<ul class="list-group">';
                                //cardlog += '<li class="list-group-item list-group-item-success" style="padding-top: 10px;padding-bottom: 30px;">';
                                //cardlog +='<li class="list-group-item list-group-item-success"><i class="fa fa-clock-o"style="font-size:20px;"></i>'+val.fdt_status_datetime+'</li>';
                                //cardlog +='<li class="list-group-item list-group-item-success"><i class="fa fa-user"style="font-size:20px;"></i>'+val.fst_username+'</li>';
                                    //cardlog += '<div class ="col-md-6"> <i class="fa fa-user"></i> '+val.fst_username+'</div>';
                                    //cardlog += '<span class="badge badge-primary badge-pill">';
                                    //cardlog += '<div class= "col-md-6">'+val.fdt_status_datetime+'</div>';
                                    //cardlog += '</span>';
                                //cardlog +='</li>';
                                //cardlog +=  '</ul>';
                        cardlog +=  '</div>';
                        //cardlog +='<div class="card-footer">';
                        //cardlog +='<button type="button" class="btn" data-toggle="modal" data-target="#modal_logmemo" id="right-panel-link">MEMO</button>';
                        //cardlog +='<li class="list-group-item list-group-item-light"><i class="fa fa-sticky-note-o"style="font-size:20px;">:</i>'+val.fst_status_memo+'</li>';
                        //cardlog +=  '</div>';
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
                                //cardlog += '<p class="card-title">'+val.fst_status+'</p>';
                                //cardlog += '<ul class="list-group">';
                                //cardlog += '<li class="list-group-item list-group-item-success" style="padding-top: 10px;padding-bottom: 30px;">';
                                    //cardlog += '<div class ="col-md-6"> <i class="fa fa-user"></i> '+val.fst_username+'</div>';
                                    //cardlog += '<span class="badge badge-primary badge-pill">';
                                    //cardlog += '<div class= "col-md-6">'+val.fdt_status_datetime+'</div>';
                                    //cardlog += '</span>';
                                //cardlog +='</li>';
                                cardlog += '<p class="card-title">';
                                cardlog += '<div class ="col-md-4"><strong><i class="fa fa-user"></i>'+val.fst_username+'</strong></div>';
                                cardlog += '<span class="badge badge-primary badge-pill">';
                                cardlog += '<div class ="col-md-4">'+val.fdt_status_datetime+'</div></span>';
                                //cardlog += '<span class="badge badge-primary badge-pill">';
                                cardlog += '<div class ="col-md-4"><span class="badge badge-primary badge-pill">'+val.fst_status+'</span></div>';
                                cardlog += '</p>';
                                //cardlog += '<hr>';
                                //cardlog += '<ul class="list-group">';
                                //cardlog +=  '</ul>';
                        cardlog +=  '</div>';
                        //cardlog +='<div class="card-footer">';
                        //cardlog +='<button type="button" class="btn" data-toggle="modal" data-target="#modal_logmemo" id="right-panel-link">MEMO</button>';
                        //cardlog +='<li class="list-group-item list-group-item-light"><i class="fa fa-sticky-note-o"style="font-size:20px;"> --</i>'+val.fst_status_memo+'</li>';
                        //cardlog +=  '</div>';
                        cardlog += '<div class="direct-chat-msg">';
                            cardlog += '<div class="direct-chat-text">'+val.fst_status_memo+'</div>';
                        cardlog += '</div>';

                        cardlog +=  '</div>';
                        cardlog +=  '</div>';
                    $("#ticketlog_card").append(cardlog);
                    }
                })

                //Ticket Docs 03/03/2020 enny
                $.each(resp.ms_ticketdocs, function(name, val) {
                    console.log(val);
                        var tbody = '<tr>';
                            tbody += '<td style="width:30%"><a href="<?=site_url()?>assets/app/tickets/image/yellow_ticket.jpg" target="_blank">'+val.fst_doc_title+'</td>';
                            tbody += '<td style="width:50%">'+val.fst_memo+'</td>';
                            tbody += '<td style="width:30%">'+val.fdt_insert_datetime+'</td>';
                        tbody += '</tr>';
                    $("#tblbodydocs").append(tbody);
                })

                //Image Load 
				$('#imgLampiran').attr("src",resp.ms_ticketstatus.lampiranURL);

            },

            error: function (e) {
                $("#result").text(e.responseText);
                console.log("ERROR : ", e);
            }
        });

    }
</script>

<script type="text/javascript">

    /*$(function(){
        var days = $("#fin_service_level_days").val();
        var d = new Date();
        d.setDate(d.getDate() + days);
        $('#fst_update_status').change(function(){
            $("#fdt_update_deadline_extended_datetime").val(dateTimeFormat(d));
        });
    });*/
	
</script>

<!-- Select2 -->
<script src="<?= COMPONENT_URL ?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- DataTables -->
<script src="<?= COMPONENT_URL ?>bower_components/datatables.net/datatables.min.js"></script>