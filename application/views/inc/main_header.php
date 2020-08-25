<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<header class="main-header">
	<!-- Logo -->
	<a href="index2.html" class="logo">
		<!-- mini logo for sidebar mini 50x50 pixels -->
		<span class="logo-mini"><b>A</b>LT</span>
		<!-- logo for regular state and mobile devices -->
		<span class="logo-lg"><b>Admin</b>LTE</span>
	</a>

	<!-- Header Navbar: style can be found in header.less -->
	<nav class="navbar navbar-static-top">
		<!-- Sidebar toggle button-->
		<a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
			<span class="sr-only">Toggle navigation</span>
		</a>

		<div class="navbar-custom-menu">
			<ul class="nav navbar-nav">
				<!-- Notifications: style can be found in dropdown.less -->
				<li class="dropdown notifications-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
					<i class="fa fa-bell-o"></i>
					<span class="label label-warning" id="ticket-new">
					<?php
						//$this->load->model("dashboard_model");
						$newTickets = $this->dashboard_model->get_ttl_newTickets();
						echo $newTickets;
					?>
					</span>
					</a>
					<ul class="dropdown-menu">
					<li>
						<!-- inner menu: contains the actual data -->
						<ul class="menu">
						<li>
							<a href="<?= site_url() ?>tr/ticketstatus/our_tickets">
							<i class="label label-success" id="ticket-newDetail">
							<?php
								//$this->load->model("dashboard_model");
								$newTickets = $this->dashboard_model->get_ttl_newTickets();
								echo $newTickets;
							?>
							</i>
							   new ticket on your department
							</a>
						</li>
						</ul>
					</li>
					<!--<li class="footer"><a href="#">cek
					</a></li>-->
					</ul>
				</li>
				<!-- User Account: style can be found in dropdown.less -->
				<li class="dropdown user user-menu">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown">
						<img src="<?=COMPONENT_URL?>dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
						<span class="hidden-xs">
							<?php
								$active_user = $this->session->userdata("active_user");
								echo ($active_user->fst_fullname);
							?>
						</span>
					</a>
					<ul class="dropdown-menu">
						<!-- User image -->
						<li class="user-header">
							<img src="<?=COMPONENT_URL?>dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
							<p><?= $active_user->fst_fullname?><small><?= $active_user->fst_group_name?></small></p>
						</li>						
						<!-- Menu Body -->
						<li class="user-body">							
						</li>
						<!-- Menu Footer-->
						<li class="user-footer">
							<div class="pull-left"><a href="<?=site_url()?>user/changepassword" class="btn btn-default btn-flat">Change Password</a></div>
							<div class="pull-right"><a href="<?= site_url() ?>signout" class="btn btn-default btn-flat">Sign out</a></div>
						</li>
					</ul>
				</li>
				
				<!-- Control Sidebar Toggle Button -->
				<li style="display:none;">
					<a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
				</li>
				
			</ul>
		</div>
	</nav>
</header>

<script type="text/javascript">
	$(function(){
		$(".sidebar-toggle").click(function(){
			if($("body").hasClass("sidebar-collapse")){
				setValue = 0;
			}else{
				setValue = 1;
			}

			$.ajax({
				url:"<?=site_url()?>setting/set_sidebar_collapse/" + setValue
			});
			
		});
	});
</script>
<script type="text/javascript">
  $(document).ready(function(){
    setInterval(function(){
          $.ajax({
                url:"<?=site_url()?>tr/ticketstatus/get_new_ticket",
                type:"GET",
                dataType:"json",//datatype lainnya: html, text
                data:{},
                success:function(data){
                    $("#ticket-new").html(data.new);
					$("#ticket-newDetail").html(data.new);
                }
            });
          },60000);
  })
</script> 