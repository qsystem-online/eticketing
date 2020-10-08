<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style type="text/css">
    .border-0 {
        border: 0px;
    }

    td {
        padding: 2px;
         !important
    }

    .nav-tabs-custom>.nav-tabs>li.active>a {
        font-weight: bold;
        border-left-color: #3c8dbc;
        border-right-color: #3c8dbc;
        border-style: fixed;
    }

    .nav-tabs-custom>.nav-tabs {
        border-bottom-color: #3c8dbc;
        border-bottom-style: fixed;
    }
</style>
<section class="content-header">
    <h1><?= lang("Delete Ticket") ?><small><?= lang("") ?></small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Transaksi") ?></a></li>
        <li><a href="#"><?= lang("Delete Ticket") ?></a></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-xs-12 col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title title">
                    <?php
                        function folderSizeX ($dir)
                        {
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
                                $size=round($size/1048576, 1)." MB";
                            }else{
                                $size=round($size/1073741824, 1)." GB";
                            }
                            return $size;
                        }
                        $filename = './assets/app/tickets/image/';
                        $lampiran = 'Total pemakaian semua lampiran';
                        echo $lampiran . ': ' . folderSizeX($filename);
                    ?>
                    </h3>
                </div>
                <!-- end box header -->
                <div class="box-body">
                    <!-- form start -->
                    <form id="frmDeltickets" action="<?= site_url() ?>tr/deleteticket/ajx_delete_ticket" method="GET" enctype="multipart/form-data">
                        <div class="box-body">
                            <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
                            <div class="form-group row">
                                <label for="fdt_ticket_datetime" class="col-sm-8 control-label"><?=lang("Delete ticket termasuk log ticket dan attachment s/d tgl :")?></label>
                                <div class="col-sm-4">
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
                        <div class="col-md-12">
                        <div class="box box-warning box-solid">
                            <div class="box-header with-border">
                            <h3 class="box-title">PENTING!!!</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                                </button>
                            </div>
                            <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body" style="">
                            *Harap lakukan backup/cetak data laporan ticket sebelum melakukan delete ticket termasuk Log ticket dan lampiran.
                            <br/>
                            *Delete ticket berlaku untuk semua ticket dengan status REJECTED,VOID,CLOSED,APPROVAL_EXPIRED,REVISION_EXPIRED,ACCEPTANCE_EXPIRED dan TICKET_EXPIRED sampai dengan tanggal yang dipilih.
                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                        </div>
                    </form>
                </div>
                <!-- end box body -->
                <div class="box-footer"></div>
                <!-- end box-footer -->
            </div>
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
                var confirmDelete = confirm("Delete ticket termasuk log ticket and attachment <= " + end_date +"???");
                if (confirmDelete){
                    App.blockUIOnAjaxRequest("Deleting ticket termasuk log ticket and attachment .....");
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
                                            //$("#btnNew").trigger("click");
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