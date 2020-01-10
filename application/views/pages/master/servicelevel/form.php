<?php
defined('BASEPATH') or exit ('No direct script access allowed');
?>
<link rel="stylesheet" href="<?= COMPONENT_URL ?>bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?= COMPONENT_URL ?>bower_components/datatables.net/datatables.min.css">

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
    <h1><?= lang("Service Level") ?><small><?= lang("form") ?></small></h1>
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
                <form id="frmServicelevel" class="form-horizontal" action="<?= site_url() ?>master/servicelevel/add" method="POST" enctype="multipart/form-data">
                    <div class="box-body">
                        <input type="hidden" name = "<?=$this->security->get_csrf_token_name()?>" value="<?=$this->security->get_csrf_hash()?>">			
						<input type="hidden" id="frm-mode" value="<?=$mode?>">

                        <div class="form-group">
                            <label for="fin_service_level_id" class="col-xs-6 col-md-2 control-label"><?=lang("Service Level")?> #</label>
                            <div class="col-xs-6 col-md-10">
                                <input type="text" class="form-control" id="fin_service_level_id" placeholder="<?=lang("(Autonumber)")?>" name="fin_service_level_id" value="<?=$fin_service_level_id?>" readonly>
                                <div id="fin_service_level_id_err" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fst_service_level_name" class="col-xs-6 col-md-2 control-label"><?=lang("Service Level Name")?>*</label>
                            <div class="col-xs-6 col-md-10">
                                <input type="text" class="form-control" id="fst_service_level_name" placeholder="<?=lang("Service Level Name")?>" name="fst_service_level_name">
                                <div id="fst_service_level_name_err" class="text-danger"></div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="fin_service_level_days" class="col-xs-6 col-md-2 control-label"><?=lang("Service Level Days")?></label>
                            <div class="col-xs-6 col-md-2">
                                <input type="text" class="form-control" id="fin_service_level_days" placeholder="<?=lang("Service Level Days")?>" name="fin_service_level_days">
                                <div id="fin_service_level_days_err" class="text-danger"></div>
                            </div>
                            <!--<label for="fin_terms_payment" class="col-sm-0 control-label"><?=lang("Day")?></label>-->
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
            init_form($("#fin_service_level_id").val());
        <?php } ?>

        $("#btnSubmitAjax").click(function(event){
            event.preventDefault();
            //data = new FormData($("#frmServicelevel")[0]);
            data = $("#frmServicelevel").serializeArray();

            mode = $("#frm-mode").val();
            if (mode == "ADD"){
                url = "<?= site_url() ?>master/servicelevel/ajx_add_save";
            }else{
                url = "<?= site_url() ?>master/servicelevel/ajx_edit_save";
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
                        $("#fin_service_level_id").val(data.insert_id);

                        //Clear all previous error
                        $(".text-danger").html("");

                        //Change to Edit Mode
                        $("#frm-mode").val("EDIT"); //ADD|EDIT
                        $('#fst_service_level_name').prop('readonly', true);
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
            window.location.replace("<?=site_url()?>master/servicelevel/add");
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
                url:"<?= site_url() ?>master/servicelevel/delete/" + $("#fin_service_level_id").val(),
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
                                    window.location.href = "<?=site_url() ?>master/servicelevel/lizt";
                                    return;
                                }
                            },
                        }
                    });
                }

                if (resp.status == "SUCCESS") {
                    data = resp.data;
                    $("#fin_service_level_id").val(data.insert_id);

                    //Clear all previous error
                    $(".text-danger").html("");
                    //Change to Edit Mode
                    $("#frm-mode").val("EDIT"); //ADD|EDIT
                    $('#fst_service_level_name').prop('readonly', true);
                }
            });
        });

        $("#btnList").click(function(e){
            e.preventDefault();
            window.location.replace("<?=site_url()?>master/servicelevel/lizt");
        });
    })

    function init_form(fin_service_level_id){
        //alert("Init Form);
        var url = "<?=site_url()?>master/servicelevel/fetch_data/" + fin_service_level_id;
        $.ajax({
            type: "GET",
            url: url,
            success: function (resp) {
                console.log(resp.serviceLevel);

                $.each(resp.serviceLevel, function(name, val){
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