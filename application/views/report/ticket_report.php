<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<link rel="stylesheet" href="<?= COMPONENT_URL ?>bower_components/select2/dist/css/select2.min.css">
<link rel="stylesheet" href="<?= COMPONENT_URL ?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">

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
    <h1><?= lang("Ticket Monitoring") ?><small><?= lang("") ?></small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
        <li><a href="#"><?= lang("Ticket monitoring") ?></a></li>
        <li class="active title"><?= $title ?></li>
    </ol>
</section>
<body onload="init_form()"></body>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title title"><?= lang("Ticket Monitoring") ?></h3>
                    <div class="btn-group btn-group-sm pull-right">
                        <a id="btnMonitoring" class="btn btn-primary" href="#" title="<?=lang("Monitoring")?>"><i class="fa fa-list" aria-hidden="true"></i></a>											
					</div>
                </div>
                <!-- end box header -->
            </div>
        </div>
        <div class="col-md-12" style="display: none;">
        <?php		
			$deptList = $this->msdepartments_model->getAllList();
			?>
            <select class="form-control select2" id="fin_dept_id" name="fin_dept_id[]" style="width: 100%" multiple="multiple">
                <?php
                $activeBranchId = "4";
                foreach ($deptList as $dept) {
                    $isActive = ($dept->fin_department_id == $activeBranchId) ? "selected" : "";
                    ?>
                        <option value='<?= $dept->fin_department_id ?>'$isActive><?= $dept->fst_department_name ?> </option>
                    <?php
                } ?>
            </select>
            <!--<div id="fin_dept_id_err" class="text-danger"></div>-->
        </div>
    </div>
</section>

<script type="text/javascript">
    $(function() {

        /*$("#btnPrinted").click(function(e){
			$("#modal_Printed").modal("toggle");
		});*/
        $("#btnMonitoring").click(function(e){
            e.preventDefault();
            var monitoringDepart = $("#fin_dept_id").val();
            //if (monitoringDepart == null || monitoringDepart == "") {
            //    $("#fin_dept_id_err").html("Please select Department");
            //    $("#fin_dept_id_err").show();
            //    return;
            //} else {
            //    $("#fin_dept_id_err").hide();
                var monitoring = window.open("<?= site_url() ?>tr/ticketstatus/monitoring");
                monitoring.department = $("#fin_dept_id").val();
            //}
		});

		/*$("#btnPrint").click(function(e){
            layoutColumn = [];
            var statusReport = $("#fst_status_report").val();
            if (statusReport == "APPROVED/OPEN"){
                statusReport = "OPEN";
            }
			url = "<?= site_url() ?>tr/ticketstatus/get_print_ticketReport/" + $("#fdt_ticket_date_start").val() + '/' + $("#fdt_ticket_date_End").val() + '/' + $("#select-user_issuedBy").val() + '/' + $("#select-user_issuedTo").val() + '/' + statusReport;
            //url = "<?= site_url() ?>tr/ticketstatus/get_ticket_perUser/" + $("#select-user_issuedBy").val() ;
            //url = "<?= site_url() ?>tr/ticketstatus/get_print_ticketSLDays/" + $("#select-user_issuedBy").val() ;
            MdlPrint.showPrint(layoutColumn,url);
        });*/

        $('#fin_dept_id, #fin_dept_id').select2({
            placeholder: 'Pilih divisi monitoring',
                width: '100%'
        });
    });

    function init_form(){
        var monitoringDepart = $("#fin_dept_id").val();
        var monitoring = window.open("<?= site_url() ?>tr/ticketstatus/monitoring");
        monitoring.department = $("#fin_dept_id").val();
    }
</script>

<!-- Select2 -->
<script src="<?= COMPONENT_URL ?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- DataTables -->
<script src="<?= COMPONENT_URL ?>bower_components/datatables.net/datatables.min.js"></script>