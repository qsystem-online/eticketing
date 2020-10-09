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
			<li>Jalankan backup/cetak data laporan ticket sebelum delete ticket.</li>
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
		  <i class="fa fa-trash"></i>

		  <h3 class="box-title">Delete ticket (termasuk Log dan lampiran)</h3>
		</div>
		<!-- /.box-header -->
		<div class="box-body">
			<input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
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
            var end_date = $("#fdt_ticket_datetime").val();
            if (end_date =="" | end_date == null){
                $("#fdt_ticket_datetime_err").html("Tanggal batas delete harus diisi !!!");
                $("#fdt_ticket_datetime_err").show();
                return;
            }else{
                $("#fdt_ticket_datetime_err").hide();
                var confirmDelete = confirm("Delete ticket <= " + end_date +"???");
                if (confirmDelete){
                    App.blockUIOnAjaxRequest("Deleting ticket, log ticket and attachment .....");
                    $.ajax({
                        url:"<?=site_url()?>tr/deleteticket/ajx_delete_ticket/" + end_date,
                        method:"GET",
                    }).done(function(resp){
                        if (resp.message !=""){
                            alert(resp.message);
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
    });
</script>

<!-- Select2 -->
<script src="<?= COMPONENT_URL ?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- DataTables -->
<script src="<?= COMPONENT_URL ?>bower_components/datatables.net/datatables.min.js"></script>