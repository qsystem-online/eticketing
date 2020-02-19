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
    <h1><?= lang("Monitoring And Report Ticket") ?><small><?= lang("") ?></small></h1>
    <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> <?= lang("Home") ?></a></li>
        <li><a href="#"><?= lang("Ticket monitoring and report") ?></a></li>
        <li class="active title"><?= $title ?></li>
    </ol>
</section>

<section class="content">
    <div class="row">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title title"><?= $title ?></h3>
                    <div class="btn-group btn-group-sm pull-right">
						<a id="btnPrinted" class="btn btn-primary" href="#" title="<?=lang("Cetak")?>"><i class="fa fa-print" aria-hidden="true"></i></a>											
					</div>
                </div>
                <div class="box-header with-border">
                    <h3 class="box-title title"><?= lang("Ticket Monitoring") ?></h3>
                    <div class="btn-group btn-group-sm pull-right">
                        <a id="btnMonitoring" class="btn btn-primary" href="#" title="<?=lang("Monitoring")?>"><i class="fa fa-list" aria-hidden="true"></i></a>											
					</div>
                </div>
                <!-- end box header -->
            </div>
        </div>
        <div class="col-md-12">
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
            <div id="fin_dept_id_err" class="text-danger"></div>
        </div>
    </div>
</section>

<div id="modal_Printed" class="modal fade in" role="dialog" style="display: none">
    <div class="modal-dialog" style="display:table;width:60%;min-width:600px;max-width:100%">
        <!-- modal content -->
		<div class="modal-content" style="border-top-left-radius:15px;border-top-right-radius:15px;border-bottom-left-radius:15px;border-bottom-right-radius:15px;">
            <div class="modal-header" style="padding:15px;background-color:#3c8dbc;color:#ffffff;border-top-left-radius: 15px;border-top-right-radius: 15px;">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title"><?= lang("Ticket Report") ?></h4>
			</div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12" >
                        <div style="border:1px inset #f0f0f0;border-radius:10px;padding:5px">
                            <fieldset style="padding:10px">

                            <form class="form-horizontal">
                                <div class="form-group">
                                    <label for="fdt_ticket_date_start" class="col-xs-6 col-md-2 control-label"><?=lang("Ticket Date")?></label>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control text-right datepicker" id="fdt_ticket_date_start" name="fdt_ticket_date_start">
                                        </div>
                                        <div id="fdt_ticket_date_start_err" class="text-danger"></div>
                                    </div>
                                    <label for="fdt_ticket_date_End" class="col-xs-6 col-md-2 control-label"><?=lang("To")?></label>
                                    <div class="col-xs-6 col-md-3">
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                                <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control text-right datepicker" id="fdt_ticket_date_End" name="fdt_ticket_date_End">
                                        </div>
                                        <div id="fdt_ticket_date_end_err" class="text-danger"></div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="select-user_issuedBy" class="col-xs-6 col-md-2 control-label"><?=lang("Issued By")?></label>
                                    <div class="col-xs-6 col-md-4">
                                        <select id="select-user_issuedBy" class="form-control select2" name="fin_issued_by_user_id" style="width: 100%">
                                        <option selected="selected" valeu="ALL"><?=lang("ALL")?></option>
                                            <?php
                                                $active_user = $this->aauth->get_user_id();
                                                $usersList = $this->users_model->getAllList();
                                                foreach ($usersList as $users) {
                                                    //$isActive = ($users->fin_user_id == $active_user) ? "selected" : "";
                                                    //echo "<option value=" . $users->fin_user_id . " $isActive >" . $users->fst_username . "</option>";
                                                    echo "<option value='$users->fin_user_id'>$users->fst_username</option>";
                                                }
                                            ?>
                                        </select>
                                        <div id="fin_issued_by_user_id_err" class="text-danger"></div>
                                    </div>

                                    <label for="select-user_issuedTo" class="col-xs-6 col-md-2 control-label"><?=lang("Issued To")?></label>
                                    <div class="col-xs-6 col-md-4">
                                        <select id="select-user_issuedTo" class="form-control select2" name="fin_issued_to_user_id" style="width: 100%">
                                        <option selected="selected" valeu="ALL"><?=lang("ALL")?></option>
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
                                    <label for="fst_status_report" class="col-xs-6 col-md-2 control-label"><?=lang("Status")?></label>
                                    <div class="col-xs-6 col-md-4">
                                        <select id="fst_status_report" class="form-control" name="fst_status_report" style="width: 100%">
                                            <option value="NEED_APPROVAL"><?=lang("NEED APPROVAL")?></option>
                                            <option value="APPROVED/OPEN"><?=lang("APPROVED/OPEN")?></option>
                                            <option value="ACCEPTED"><?=lang("ACCEPTED")?></option>
                                            <option valeu="NEED_REVISION"><?=lang("NEED_REVISION")?></option>
                                            <option valeu="COMPLETED"><?=lang("COMPLETED")?></option>
                                            <option valeu="COMPLETION_REVISED"><?=lang("COMPLETION_REVISED")?></option>
                                            <option valeu="CLOSED"><?=lang("CLOSED")?></option>
                                            <option valeu="ACCEPTANCE_EXPIRED"><?=lang("ACCEPTANCE_EXPIRED")?></option>
                                            <option valeu="TICKET_EXPIRED"><?=lang("TICKET_EXPIRED")?></option>
                                            <option valeu="VOID"><?=lang("VOID")?></option>
                                            <option valeu="REJECTED"><?=lang("REJECTED")?></option>
                                            <option selected="selected" valeu="ALL"><?=lang("ALL")?></option>
                                        </select>
                                    </div>
                                </div>

                            </form>

                            <div class="modal-footer" style="width:100%;padding:10px" class="text-center">
                                <button id="btnPrint" type="button" class="btn btn-primary btn-sm text-center" style="width:15%"><?=lang("Print")?></button>
                                <button type="button" class="btn btn-default btn-sm text-center" style="width:15%" data-dismiss="modal"><?=lang("Close")?></button>
                            </div>

                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
    echo $mdlPrint;
?>

<script type="text/javascript">
    $(function() {

        $("#btnPrinted").click(function(e){
			$("#modal_Printed").modal("toggle");
		});
        $("#btnMonitoring").click(function(e){
            e.preventDefault();
            //console.log($("#fin_dept_id").val());
            var monitoringDepart = $("#fin_dept_id").val();
            if (monitoringDepart == null || monitoringDepart == "") {
                $("#fin_dept_id_err").html("Please select Department");
                $("#fin_dept_id_err").show();
                return;
            } else {
                $("#fin_dept_id_err").hide();
                var monitoring = window.open("<?= site_url() ?>tr/ticketstatus/monitoring");
                monitoring.department = $("#fin_dept_id").val();
            }
			//var monitoring = window.open("<?= site_url() ?>tr/ticketstatus/monitoring");
            //monitoring.department = $("#fin_dept_id").val();
		});

		$("#btnPrint").click(function(e){
            layoutColumn = [];
			url = "<?= site_url() ?>tr/ticketstatus/get_print_ticketReport/" + $("#fdt_ticket_date_start").val() + '/' + $("#fdt_ticket_date_End").val() + '/' + $("#select-user_issuedBy").val() + '/' + $("#select-user_issuedTo").val() + '/' + $("#fst_status_report").val();
            MdlPrint.showPrint(layoutColumn,url);
        });

        $('#fin_dept_id, #fin_dept_id').select2({
            placeholder: 'Pilih divisi monitoring',
                width: '100%'
        });
    });
</script>

<!-- Select2 -->
<script src="<?= COMPONENT_URL ?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- DataTables -->
<script src="<?= COMPONENT_URL ?>bower_components/datatables.net/datatables.min.js"></script>