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
                    <div class="btn-group btn-group-sm pull-right">
                        <a id="btnNew" class="btn btn-primary" href="#" title="<?=lang("Tambah Baru")?>"><i class="fa fa-plus" aria-hidden="true"></i></a>
                        <a id="btnSubmitAjax" class="btn btn-primary" href="#" title="<?=lang("Simpan")?>"><i class="fa fa-floppy-o" aria-hidden="true"></i></a>
                        <a id="btnDelete" class="btn btn-primary" href="#" title="<?=lang("Hapus")?>"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        <a id="btnList" class="btn btn-primary" href="#" title="<?=lang("Daftar Transaksi")?>"><i class="fa fa-list" aria-hidden="true"></i></a>
                    </div>
                </div>
                <!-- end box header -->

                <!-- form start -->
                <form id="frmTicket" class="form-horizontal" action="<?= site_url() ?>tr/ticket/add" method="POST" enctype="multipart/form-data">
                    <div class="box-body">
                        <input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">			
						<input type="hidden" id="frm-mode" value="<?=$mode?>">
                        <input type="hidden" class="form-control" id="fin_ticket_id" placeholder="<?=lang("(Autonumber)")?>" name="fin_ticket_id" value="<?=$fin_ticket_id?>" readonly>

                        <div class="form-group">
                            <label for="fst_ticket_no" class="col-xs-6 col-md-2 control-label"><?=lang("Ticket No.")?></label>
                            <div class="col-xs-6 col-md-10">
                                <input type="text" class="form-control" id="fst_ticket_no" placeholder="<?=lang("Ticket No.")?>" name="fst_ticket_no" value="<?=$fst_ticket_no?>" readonly>
                                <div id="fst_ticket_no_err" class="text-danger"></div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="fdt_ticket_datetime" class="col-xs-6 col-md-2 control-label"><?=lang("Ticket Datetime")?></label>
                            <div class="col-xs-6 col-md-4">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control text-right datetimepicker" id="fdt_ticket_datetime" name="fdt_ticket_datetime"/>								
                                </div>
                                <div id="fdt_ticket_datetime_err" class="text-danger"></div>
                            </div>

                            <label for="fdt_acceptance_expiry_datetime" class="col-xs-6 col-md-2 control-label"><?=lang("Expiry Datetime")?></label>
                            <div class="col-xs-6 col-md-4">
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
                            <label for="fin_ticket_type_id" class="col-xs-6 col-md-2 control-label"><?=lang("Ticket Type")?></label>
                            <div class="col-xs-6 col-md-4">
                                <select id="select-ticketType" class="form-control" name="fin_ticket_type_id">
                                    <option value="0">-- <?=lang("select")?> --</option>
                                </select>
                                <div id="fin_ticket_type_id_err" class="text-danger"></div>
                            </div>
                        
                            <label for="fin_service_level_id" class="col-xs-6 col-md-2 control-label"><?=lang("Service Level")?></label>
                            <div class="col-xs-6 col-md-4">
                                <select id="select-serviceLevel" class="form-control" name="fin_service_level_id">
                                    <option value="0">-- <?=lang("select")?> --</option>
                                </select>
                                <div id="fin_service_level_id_err" class="text-danger"></div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="fdt_deadline_datetime" class="col-xs-6 col-md-2 control-label"><?=lang("Deadline Datetime")?></label>
                            <div class="col-xs-6 col-md-4">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control text-right datetimepicker" id="fdt_deadline_datetime" name="fdt_deadline_datetime"/>
                                </div>
                                <div id="fdt_deadline_datetime_err" class="text-danger"></div>
                            </div>
 
                            <label for="fdt_deadline_extended_datetime" class="col-xs-6 col-md-2 control-label"><?=lang("Extended Datetime")?></label>
                            <div class="col-xs-6 col-md-4">
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
                            <label for="fdt_ticket_expiry_extended_datetime" class="col-xs-6 col-md-2 control-label"><?=lang("Expiry Ext. Datetime")?></label>
                            <div class="col-xs-6 col-md-10">
                                <div class="input-group date">
                                    <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <input type="text" class="form-control text-right datetimepicker" id="fdt_ticket_expiry_extended_datetime" name="fdt_ticket_expiry_extended_datetime"/>
                                </div>
                                <div id="fdt_ticket_expiry_extended_datetime_err" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fin_issued_by_user_id" class="col-xs-6 col-md-2 control-label"><?=lang("Issued By")?></label>
                            <div class="col-xs-6 col-md-4">
                                <input type="text" class="form-control" id="fin_issued_by_user_id" placeholder="<?=lang("Issued By")?>" name="fin_issued_by_user_id">
                                <div id="fin_issued_by_user_id_err" class="text-danger"></div>
                            </div>

                            <label for="fin_issued_to_user_id" class="col-xs-6 col-md-2 control-label"><?=lang("Issued To")?></label>
                            <div class="col-xs-6 col-md-4">
                                <input type="text" class="form-control" id="fin_issued_to_user_id" placeholder="<?=lang("Issued To")?>" name="fin_issued_to_user_id">
                                <div id="fin_issued_to_user_id_err" class="text-danger"></div>
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
            event.preventDefault();
            //data = new FormData($("#frmticket")[0]);
            data = $("#frmTicket").serializeArray();

            mode = $("#frm-mode").val();
            if (mode == "ADD"){
                url = "<?= site_url() ?>tr/ticket/ajx_add_save";
            }else{
                url = "<?= site_url() ?>tr/ticket/ajx_edit_save";
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

        $("#select-ticketType").select2({
            width: '100%',
            ajax: {
                url: '<?=site_url()?>tr/ticket/get_ticketType',
                dataType: 'json',
                delay: 250,
                processResults: function (data){
                    items = [];
                    data  = data.data;
                    $.each(data,function(index,value){
                        items.push({
                            "id" : value.fin_ticket_type_id,
                            "text" : value.fst_ticket_type_name
                        });
                    });
                    console.log(items);
                    return {
                        results: items
                    };
                },
                cache: true,
            }
        });

        $("#select-serviceLevel").select2({
            width: '100%',
            ajax: {
                url: '<?=site_url()?>tr/ticket/get_serviceLevel',
                dataType: 'json',
                delay: 250,
                processResults: function (data){
                    items = [];
                    data  = data.data;
                    $.each(data,function(index,value){
                        items.push({
                            "id" : value.fin_service_level_id,
                            "text" : value.fst_service_level_name
                        });
                    });
                    console.log(items);
                    return {
                        results: items
                    };
                },
                cache: true,
            }
        });

        $("#btnNew").click(function(e){
            e.preventDefault();
            window.location.replace("<?=site_url()?>tr/ticket/add");
        });

        $("#btnDelete").confirmation({
            title:"<?=lang("Hapus data ini ?")?>",
            rootSelector: '#btnDelete',
            placement: 'left',
        });
        $("#btnDelete").click(function(e){
            e.preventDefault();
            blockUIOnAjaxRequest("<h5>Deleting ....</h5>");
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
                                    window.location.href = "<?=site_url() ?>tr/ticket/lizt";
                                    return;
                                }
                            },
                        }
                    });
                }

                if (resp.status == "SUCCESS") {
                    data = resp.data;
                    $("#fin_ticket_id").val(data.insert_id);

                    //Clear all previous error
                    $(".text-danger").html("");
                    //Change to Edit Mode
                    $("#frm-mode").val("EDIT"); //ADD|EDIT
                    $('#fst_ticket_no').prop('readonly', true);
                }
            });
        });

        $("#btnList").click(function(e){
            e.preventDefault();
            window.location.replace("<?=site_url()?>tr/ticket/lizt");
        });

        $("#fdt_ticket_datetime").val(dateTimeFormat("<?= date("Y-m-d H:i:s")?>")).datetimepicker("update");
    })

    function init_form(fin_ticket_id){
        //alert("Init Form);
        var url = "<?=site_url()?>tr/ticket/fetch_data/" + fin_ticket_id;
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
                $("#fdt_ticket_datetime").val(dateTimeFormat("<?=date("Y-m-d H:i:s")?>").datetimepicker("update"));
                
                var newOption = new Option (resp.ms_ticket.fst_ticket_type_name, resp.ms_ticket.fin_ticket_type_id, true, true);
                $("#select-ticketType").append(newOption).trigger('change');

                var newOption = new Option (resp.ms_ticket.fst_service_level_name, resp.ms_ticket.fin_service_level_id, true,true);
                $("#select-serviceLevel").append(newOption).trigger('change');
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