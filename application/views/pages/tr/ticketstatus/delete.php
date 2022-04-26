<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<section class="content-header">
    <h1><?= lang("Delete Ticket") ?><small><?= lang("") ?></small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Transaksi") ?></a></li>
        <li><a href="#"><?= lang("Delete Ticket") ?></a></li>
    </ol>
</section>

<section class="content">
<div class="row">
    <div class="col-md-6">
        <div class="box box-default">
        <div class="box-header with-border">
            <i class="fa fa-bullhorn"></i>
            <h3 class="box-title">Informasi</h3>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion ion-ios-gear-outline"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">TOTAL LAMPIRAN</span>
                    <span class="info-box-number">
                    <?php
                        function folderSizeX($dir){
                            $size = 0;
                            foreach (glob(rtrim($dir, '/').'/*', GLOB_NOSORT) as $each) {
                                $size += is_file($each) ? filesize($each) : folderSizeX($each);
                            }
                            if($size<1024){
                                $size=$size." Bytes";
                            }elseif(($size<1048576)&&($size>1023)){
                                //$size=round($size/1024, 1)." KB";
                                $size=round($size/1048576, 2)." MB";
                            }elseif(($size<1073741824)&&($size>1048575)){
                                $size=round($size/1048576, 2)." MB";
                            }else{
                                $size=round($size/1073741824, 2)." GB";
                            }
                            return $size;
                        }
                        $filename = './assets/app/tickets/image/';
                        $lampiran = '';
                        echo $lampiran . '' . folderSizeX($filename);
                    ?>
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>

            <div class="callout callout-warning">
            <h4>PENTING!!!</h4>
			<li>Lakukan Backup dan Cetak laporan ticket sebelum delete ticket.</li>
            <li>Delete ticket berlaku untuk semua ticket dengan status :
                <ul>
                <li>REJECTED</li>
                <li>VOID</li>
                <li>CLOSED</li>
                <li>APPROVAL_EXPIRED</li>
                <li>REVISION_EXPIRED</li>
                <li>ACCEPTANCE_EXPIRED</li>
                <li>TICKET_EXPIRED</li>
                </ul>
            </li>
            </div>
        </div>
        <!-- /.box-body -->
        </div>
        <!-- /.box -->
    </div>
    <!-- /.col -->
	<div class="col-md-6">
    <div class="box box-default">
		<div class="box-header with-border">
		  <i class="fa fa-cloud-download"></i>
		  <h3 class="box-title">Backup</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
            <div class="form-group row">
                <div class="col-sm-12">								
                    <div class="radio">
                    <label>
                        <input type="radio" name="opsi_backup" id="bck_doc_only" value="1" checked="">
                        Lampiran (ZIP)
                    </label>
                    </div>
                    <div class="radio">
                    <label>
                        <input type="radio" name="opsi_backup" id="bck_ticket_log" value="2">
                        Log (Excel)
                    </label>
                    </div>
                </div>
            </div>
			<div class="form-group row">
				<label for="fdt_ticket_datetime" class="col-sm-4 control-label"><?=lang("s/d Tanggal Ticket :")?></label>
				<div class="col-sm-8">
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" class="form-control datepicker" id="fdt_ticket_datetime2" name="fdt_ticket_datetime2"/>
					</div>
					<div id="fdt_ticket_datetime2_err" class="text-danger"></div>
					<!-- /.input group -->
				</div>
			</div>
			<button type="button"  id="btnLOG" href="#" title="<?=lang("Download")?>" class="btn btn-primary btn-block"><i class="fa fa-cloud-download" aria-hidden="true"></i></button>
            <!--<button type="button"  id="btnSEND" href="#" title="<?=lang("Send Email")?>" class="btn btn-primary btn-block"><i class="fa fa-envelope-o" aria-hidden="true"></i></button>-->
		</div>
		<!-- /.box-body -->
	  </div>
	  <!-- /.box -->
	  <div class="box box-default">
		<div class="box-header with-border">
		  <i class="fa fa-trash"></i>

		  <h3 class="box-title">Delete ticket</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
            <div class="form-group row">
                <div class="col-sm-12">								
                    <div class="radio">
                    <label>
                      <input type="radio" name="opsi_delete" id="del_doc_only" value="1" checked="">
                      Hanya Lampiran
                    </label>
                    </div>
                    <div class="radio">
                        <label>
                        <input type="radio" name="opsi_delete" id="del_ticket_doc" value="2">
                        Ticket,Log dan Lampiran
                        </label>
                    </div>
                </div>
                <!--<div class="col-sm-12">
                <ul class="todo-list ui-sortable">
                    <li class="">
                    <!-- checkbox -->
                    <!--<input id="fbl_doc_only" type="checkbox" name="fbl_doc_only" value="1">
                    <!-- todo text -->
                    <!--<span class="text">Hanya Lampiran</span>
                    </li>
                </ul>
                </div>-->
            </div>
			<div class="form-group row">
				<label for="fdt_ticket_datetime" class="col-sm-4 control-label"><?=lang("s/d Tanggal Ticket :")?></label>
				<div class="col-sm-8">
					<div class="input-group date">
						<div class="input-group-addon">
							<i class="fa fa-calendar"></i>
						</div>
						<input type="text" class="form-control datepicker" id="fdt_ticket_datetime" name="fdt_ticket_datetime"/>
					</div>
					<div id="fdt_ticket_datetime_err" class="text-danger"></div>
					<!-- /.input group -->
				</div>
			</div>
            <div class="form-group row">
                <label for="fst_status" class="col-sm-4 control-label"><?=lang("Status")?></label>
                <div class="col-sm-8">
                    <select id="fst_status" class="form-control select2" name="fst_status" style="width:100%">
                        <option value="APPROVAL_EXPIRED"><?=lang("APPROVAL EXPIRED")?></option>
                        <option value="ACCEPTANCE_EXPIRED"><?=lang("ACCEPTANCE EXPIRED")?></option>
                        <option value="TICKET_EXPIRED"><?=lang("TICKET EXPIRED")?></option>
                        <option value="REJECTED"><?=lang("REJECTED")?></option>
                        <option value="VOID"><?=lang("VOID")?></option>
                        <option value="CLOSED"><?=lang("CLOSED")?></option>
                        <option value="0"><?=lang("-- All --")?></option>
                    </select>
                </div>
			</div>
			<button type="button"  id="btnDelete" href="#" title="<?=lang("Clear ticket and attachment")?>" class="btn btn-primary btn-block"><i class="fa fa-trash" aria-hidden="true"></i></button>
                        
        </div>
		<!-- /.box-body -->
	  </div>
	  <!-- /.box -->
	</div>
	<!-- /.col -->
</div>
</section>

<script type="text/javascript">
    $(function() {
        $("#btnDelete").click(function(event){
            event.preventDefault();
            //data = new FormData($("#frmDeltickets")[0]);
            var data = {
                    'fdt_ticket_datetime': document.getElementById('fdt_ticket_datetime').value,
                    'fst_status': document.getElementById('fst_status').value,
                    'opsi_delete': $('input[name=opsi_delete]:checked').val()
            };
            var end_date = $("#fdt_ticket_datetime").val();
            var opsi_delete = $('input[name=opsi_delete]:checked').val();
            if (end_date =="" | end_date == null){
                $("#fdt_ticket_datetime_err").html("Tanggal batas delete harus diisi !!!");
                $("#fdt_ticket_datetime_err").show();
                return;
            }else{
                $("#fdt_ticket_datetime_err").hide();
                if (opsi_delete != 1){
                    var confirmDelete = confirm("Delete ticket <= " + end_date +"???");
                }else{
                    var confirmDelete = confirm("Hanya lampiran <= " + end_date +"???");
                }
                if (confirmDelete){
                    if (opsi_delete !=1){
                        App.blockUIOnAjaxRequest("Deleting ticket, log ticket and attachment .....");
                    }else{
                        App.blockUIOnAjaxRequest("Deleting attachment .....");
                    }
                    //App.blockUIOnAjaxRequest("Deleting ticket, log ticket and attachment .....");
                    $.ajax({
                        url:"<?=site_url()?>tr/deleteticket/ajx_delete_ticket",
                        method:"GET",
                        data: data,
                    }).done(function(resp){
                        if (resp.status =="NOT FOUND"){
                            //alert(resp.message);
                            $.alert({
                                title: 'Message',
                                content: 'data not found!!!',
                                buttons: {
                                    OK : function(){
                                        if (resp.status == "NOT FOUND"){
                                            return;
                                        }
                                    },
                                }
                            });
                        }
                        if (resp.status =="SUCCESS"){
                            $.alert({
                                title: 'Message',
                                content: 'delete success!!!',
                                buttons: {
                                    OK : function(){
                                        if (resp.status == "SUCCESS"){
                                            window.location.replace("<?=site_url()?>tr/deleteticket");
                                            return;
                                        }
                                    },
                                }
                            });
                        }
                    });
                }
            }

        });

        $("#btnLOG").click(function(event){
            event.preventDefault();
            var end_dateLog = $("#fdt_ticket_datetime2").val();
            var opsi_backup = $('input[name=opsi_backup]:checked').val();
            if (end_dateLog =="" | end_dateLog == null){
                $("#fdt_ticket_datetime2_err").html("Tanggal batas ticket harus diisi !!!");
                $("#fdt_ticket_datetime2_err").show();
                return;
            }else{
                $("#fdt_ticket_datetime2_err").hide();
                if (opsi_backup != 1){
                    var confirmDelete = confirm("Download ticket LOG <= " + end_dateLog +"???");
                    var url= "<?=site_url()?>tr/deleteticket/ajx_download_ticketLog/?dateLog=" + end_dateLog;
                }else{
                    var confirmDelete = confirm("Download Lampiran <= " + end_dateLog +"???");
                    var url= "<?=site_url()?>tr/deleteticket/ajx_download_doc/?dateDoc=" + end_dateLog;
                }
                if (confirmDelete){
                    App.blockUIOnAjaxRequest("Download .....");
                    $.ajax({
                        url: url,
                        method:"GET",
                    }).done(function(resp){
                        if (resp.status != "NOT FOUND"){
                            if (opsi_backup != 1){
                                window.location.replace("<?=site_url()?>tr/deleteticket/ajx_download_ticketLog/?dateLog=" + end_dateLog);
                            }else{
                                window.location.replace("<?=site_url()?>tr/deleteticket/ajx_download_doc/?dateDoc=" + end_dateLog);
                            }
                            return;
                        }else{
                            $.alert({
                                title: 'Message',
                                content: 'Data Not Found!!!',
                                buttons: {
                                    OK : function(){
                                        window.location.replace("<?=site_url()?>tr/deleteticket");
                                        return;
                                    },
                                }
                            });
                        }
                    });
                }
            }

        });

        $("#btnSEND").click(function(event){
            event.preventDefault();
            var end_dateLog = $("#fdt_ticket_datetime2").val();
            var opsi_backup = $('input[name=opsi_backup]:checked').val();
            if (end_dateLog =="" | end_dateLog == null){
                $("#fdt_ticket_datetime2_err").html("Tanggal batas ticket harus diisi !!!");
                $("#fdt_ticket_datetime2_err").show();
                return;
            }else{
                $("#fdt_ticket_datetime2_err").hide();
                if (opsi_backup != 1){
                    var confirmDelete = confirm("Download ticket LOG <= " + end_dateLog +"???");
                    var url= "<?=site_url()?>tr/emailticket/send_email";
                }else{
                    var confirmDelete = confirm("Download Lampiran <= " + end_dateLog +"???");
                    var url= "<?=site_url()?>tr/deleteticket/send_email";
                }
                if (confirmDelete){
                    App.blockUIOnAjaxRequest("Download .....");
                    $.ajax({
                        url: url,
                        method:"GET",
                    }).done(function(resp){
                        if (resp.status =="NOT SUCCESS"){
                            //alert(resp.message);
                            $.alert({
                                title: 'Message',
                                content: 'Email not success!!!',
                                buttons: {
                                    OK : function(){
                                        if (resp.status == "NOT SUCCESS"){
                                            return;
                                        }
                                    },
                                }
                            });
                        }
                        if (resp.status =="SUCCESS"){
                            $.alert({
                                title: 'Message',
                                content: 'Email success!!!',
                                buttons: {
                                    OK : function(){
                                        if (resp.status == "SUCCESS"){
                                            window.location.replace("<?=site_url()?>tr/deleteticket");
                                            return;
                                        }
                                    },
                                }
                            });
                        }
                    });
                }
            }

        });

    });
</script>