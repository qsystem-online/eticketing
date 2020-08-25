<?php
defined('BASEPATH') or exit ('No direct script access allowed');
?>

<style type="text/css">
    #row1{
        display:none;
    }
</style>
<!-- form start -->
<form id="rptTicketsV2" action="<?= site_url() ?>report/tickets_v2/process" method="POST" enctype="multipart/form-data">
    <div class="box-body">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name() ?>" value="<?= $this->security->get_csrf_hash() ?>">
            <div class="form-group row" id="row1">                    
                <label for="fin_branch_id" class="col-md-2 control-label"><?=lang("Branch")?></label>
                <div class="col-md-4">
					<?php
                        $active_user = $this->session->userdata("active_user");	
                        $branchList = $this->msbranches_model->getAllList();
					?>
                    <select id="select-branch" class="form-control" name="fin_branch_id" disabled>
						<option value="0" selected>-- <?=lang("All")?> --</option>
						<?php
							$activeBranchId = $this->session->userdata("active_branch_id");
							foreach ($branchList as $branch) {
								//echo "<option value='$branch->fin_branch_id'>$branch->fst_branch_name</option>";
								$isActive = ($branch->fin_branch_id == $activeBranchId) ? "selected" : "";
								echo "<option value=" . $branch->fin_branch_id . " $isActive >" . $branch->fst_branch_name . "</option>";
							}
						?>
                    </select>
                    <div id="fin_branch_id_err" class="text-danger"></div>
                </div>
                <label for="fin_group_id" class="col-md-2 control-label"><?=lang("User Group")?></label>
                <div class="col-md-4">
                    <select id="fin_group_id" class="form-control select2" name="fin_group_id">
						<option value="" selected>-- <?=lang("All")?> --</option>
						<?php
                        $groupList = $this->usersgroup_model->getAllList();
						foreach ($groupList as $group) {
							echo "<option value='$group->fin_group_id'>$group->fst_group_name</option>";
						}
						?>
                    </select>
                    <div id="fin_group_id_id_err" class="text-danger"></div>
                </div>
            </div>
            
            <div class="form-group row">
                <label for="fin_department_id" class="col-md-2 control-label"><?=lang("Department")?></label>
                <div class="col-md-4">
                    <?php
                        $active_user = $this->session->userdata("active_user");	
                        $departmentList = $this->msdepartments_model->getAllList();
					?>
                    <select id="select-department" class="form-control select2" name="fin_department_id">
                        <!--<option value="0">-- <?=lang("All")?> --</option>-->
						<?php
							$activeDeptId = $this->session->userdata("active_dept_id");
							foreach ($departmentList as $department) {
                                //echo "<option value='$department->fin_department_id'>$department->fst_department_name</option>";
                                $isActive = ($department->fin_department_id == $activeDeptId) ? "selected" : "disabled";
								echo "<option value=" . $department->fin_department_id . " $isActive >" . $department->fst_department_name . "</option>";
							}
						?>
                    </select>
                    <div id="fin_department_id_err" class="text-danger"></div>
                </div>
                <label for="select-userId" class="col-md-2 control-label"><?=lang("User Name")?></label>
                <div class="col-md-4">
                    <select id="select-userId" class="form-control select2" name="fin_user_id">
                    <option value="0">-- <?=lang("All")?> --</option>
						<?php
							$userList = $this->users_model->getUnderList();
							foreach ($userList as $user) {
								echo "<option value='$user->fin_user_id'>$user->fst_username</option>";
							}
						?>
                    </select>
                    <div id="fin_user_id_id_err" class="text-danger"></div>
                </div>
            </div>

			<div class="form-group row">
				<label for="select-ticketType" class="col-md-2 control-label"><?=lang("Ticket Type")?></label>
				<div class="col-md-4">
					<select id="select-ticketType" class="form-control select2" name="fin_ticket_type_id">
						<option value="0" selected>-- <?=lang("All")?> --</option>
						<?php
							$tickettypeList = $this->tickettype_model->getTicketType();
							foreach ($tickettypeList as $ticketType) {
								echo "<option value='$ticketType->fin_ticket_type_id' data-notice='$ticketType->fst_assignment_or_notice' data-fbl='$ticketType->fbl_need_approval'>$ticketType->fst_ticket_type_name</option>";
							}
						?>
					</select>
					<div id="fin_ticket_type_id_err" class="text-danger"></div>
				</div>
			</div>
                                

            <div class="form-group row">
                <label for="fdt_ticket_datetime" class="col-sm-2 control-label"><?=lang("Ticket Date")?></label>
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
                <label for="fdt_ticket_datetime2" class="col-sm-2 control-label"><?=lang("s/d")?></label>
                <div class="col-sm-4">
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <input type="text" class="form-control datepicker" id="fdt_ticket_datetime2" name="fdt_ticket_datetime2"/>
                    </div>
                    <div id="fdt_ticket_datetime2_err" class="text-danger"></div>
                </div>
                <div class="col-sm-3"></div>
            </div>
        
            <div class="form-group row">
                <label for="rpt_layout" class="col-sm-2 control-label"><?=lang("Report Layout")?></label>
                <div class="col-sm-4">								
                    <label class="radio"><input type="radio" id="rpt_layout1" class="rpt_layout" name="rpt_layout" value="1" checked onclick="handleRadioClick(this);"><?=lang("Laporan Daftar Ticket")?></label>
                    <label class="radio"><input type="radio" id="rpt_layout2" class="rpt_layout" name="rpt_layout" value="2" onclick="handleRadioClick(this);"><?=lang("Laporan Summary ticket Per-User")?></label>
                    <label class="radio"><input type="radio" id="rpt_layout3" class="rpt_layout" name="rpt_layout" value="3" onclick="handleRadioClick(this);"><?=lang("Laporan Hitungan hari Per-Ticket")?></label>
                </div>
                <label for="selected_colums" class="col-sm-2 control-label"><?=lang("Selected Columns")?></label>
                <div class="container col-sm-4">
                    <select id="multiple-columns" multiple="multiple" name="selected_columns[]">
                        <?php
                            foreach($layout_columns as $row) {
                                if ($row['layout']==1){
                                    $caption = $row['label'];
                                    $colNo = $row['value'];
                                    echo "<option value='$colNo'>$caption</option>";
                                }
                            };

                        ?>
                        <!-- <option value="php">PHP</option>
                        <option value="javascript">JavaScript</option>
                        <option value="java">Java</option>
                        <option value="sql">SQL</option>
                        <option value="jquery">Jquery</option>
                        <option value=".net">.Net</option> -->
                    </select>             
                </div>
            </div>
    </div>
</form>

<script type="text/javascript">
    $(document).ready(function() {
       // $('#multiple-columns').multiselect();
        $('#multiple-columns').multiselect({
            enableFiltering: true,        
            // includeResetOption: true,
            includeSelectAllOption: true,
            selectAllText: 'Pilih semua'
        });
        $('#multiple-columns').multiselect('selectAll',false);
        $('#multiple-columns').multiselect('updateButtonText');
        
    });

    function handleRadioClick(myRadio) {
        // alert('Old value: ' + currentValue);        
        var js_data = '<?php echo json_encode($layout_columns); ?>';
        var js_obj_data = JSON.parse(js_data );
        
        var newArray = js_obj_data.filter(function (el) {                        
            // alert(el.layout==(myRadio.value).toString());
            return el.layout==(myRadio.value).toString();
        });        

        console.log(newArray);
        $('#multiple-columns').multiselect('dataprovider', newArray);
		$('#multiple-columns').multiselect('selectAll',false);
		$('#multiple-columns').multiselect('updateButtonText');
		
		if ($('input[name=rpt_layout]:checked').val() == "2"){
			$("#select-ticketType").val(null).trigger("change.select2");
        	$("#select-ticketType").prop("disabled", true);
		}else{
        	$("#select-ticketType").prop("disabled", false);
		}
        // for(var i=0; i<newArray.length; i++){
        //     alert(newArray[i].label);
        //     console.log(newArray[i].label);
        // }
        
        // currentValue = myRadio.value;
    }         
    $(function() {

		/*$("#select-branch").select2({
			width: '100%',
			ajax: {
				url: '<?=site_url()?>report/tickets/get_branch',
				dataType: 'json',
				delay: 250,
				processResults: function (data){
					items = [];
					data = data.data;
					$.each(data,function(index,value){
						items.push({
							"id" : value.fin_branch_id,
							"text" : value.fst_branch_name
						});
					});
					console.log(items);
					return {
						results: items
					};
				},
				cache: true,
			}
		});*/

		/*$("#select-department").select2({
			width: '100%',
			ajax: {
				url: '<?=site_url()?>report/tickets/get_department',
				dataType: 'json',
				delay: 250,
				processResults: function (data){
					items = [];
					data = data.data;
					$.each(data,function(index,value){
						items.push({
							"id" : value.fin_department_id,
							"text" : value.fst_department_name
						});
					});
					console.log(items);
					return {
						results: items
					};
				},
				cache: true,
			}
		});*/

		/*$("#select-groupId").select2({
			width: '100%',
			tokenSeparators: [",", " "],
			ajax: {
				url: '<?=site_url()?>report/tickets/get_usergroup',
				dataType: 'json',
				delay: 250,
				processResults: function (data){
					items = [];
					data = data.data;
					$.each(data,function(index,value){
						items.push({
							"id" : value.fin_group_id,
							"text" : value.fst_group_name
						});
					});
					console.log(items);
					return {
						results: items
					};
				},
				cache: true,
			}
		});*/

		/*$("#select-userId").select2({
			width: '100%',
			tokenSeparators: [",", " "],
			ajax: {
				url: '<?=site_url()?>report/tickets/get_userId',
				dataType: 'json',
				delay: 250,
				processResults: function (data){
					items = [];
					data = data.data;
					$.each(data,function(index,value){
						items.push({
							"id" : value.fin_user_id,
							"text" : value.fst_username
						});
					});
					console.log(items);
					return {
						results: items
					};
				},
				cache: true,
			}
		});*/


        $("#btnProcess").click(function(event) {
            event.preventDefault();
            App.blockUIOnAjaxRequest("Please wait while processing data.....");
            //data = new FormData($("#frmBranch")[0]);
            data = $("#rptTicketsV2").serializeArray();
            url = "<?= site_url() ?>report/tickets_v2/process";
            
            // $("iframe").attr("src",url);
            $.ajax({
                type: "POST",
                //enctype: 'multipart/form-data',
                url: url,
                data: data,
                //processData: false,
                //contentType: false,
                //cache: false,
                timeout: 600000,
                success: function(resp) {
                    if (resp.message != "") {
                        $.alert({
                            title: 'Message',
                            content: resp.message,
                            buttons: {
                                OK: function() {
                                    if (resp.status == "SUCCESS") {
                                        $("#btnNew").trigger("click");
                                        alert('OK');
                                        return;
                                    }
                                },
                            }
                        });
                    }


                    if (resp.status == "VALIDATION_FORM_FAILED") {
                        //Show Error
                        errors = resp.data;
                        for (key in errors) {
                            $("#" + key + "_err").html(errors[key]);
                        }
                    } else if (resp.status == "SUCCESS") {
                        data = JSON.stringify(resp.data);
                        // $("#fin_branch_id").val(data.insert_id);
                        // 
                        //Clear all previous error
                        $(".text-danger").html("");
                        url = "<?= site_url() ?>report/tickets_v2/generateexcel";
                        //alert(url);
                        //$("iframe").attr("src",url);
                        $("#rptTicketsV2").attr('action', url);
                        $("#rptTicketsV2").attr('target', 'rpt_iframe');
                        $("#rptTicketsV2").submit();
                        $("a#toggle-window").click();
                        // Change to Edit mode
                        // $("#frm-mode").val("EDIT"); //ADD|EDIT
                        // $('#fst_branch_name').prop('readonly', true);
                        // updateIFrame(resp.data);

                    }
                },
                error: function(e) {
                    alert('error : ' + e);
                    $("#result").text(e.responseText);
                    console.log("ERROR : ", e);
                    $("#btnProcess").prop("disabled", false);
                }
            });
        });

        $("#btnExcel").click(function(event) {
            event.preventDefault();
            App.blockUIOnAjaxRequest("Please wait while downloading excel file.....");
            //data = new FormData($("#frmBranch")[0]);
            resp = $("#rptTicketsV2").serializeArray();
            url = "<?= site_url() ?>report/tickets_v2/process";
            

            data = JSON.stringify(resp);
            // $("#fin_branch_id").val(data.insert_id);
            
            //Clear all previous error
            $(".text-danger").html("");
            url = "<?= site_url() ?>report/tickets_v2/generateexcel/0";
            //alert(url);
            //$("iframe").attr("src",url);
            $("#rptTicketsV2").attr('action', url);
            $("#rptTicketsV2").attr('target', 'rpt_iframe');
            $("#rptTicketsV2").submit();
            $("a#toggle-window").click();

        });        
    });

</script>

