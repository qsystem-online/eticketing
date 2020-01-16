<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!-- <link rel="stylesheet" href="<?=base_url()?>bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css"> -->
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/datatables.net/datatables.min.css">
<style>
* {
  box-sizing: border-box;
}

body {
  font-family: Arial, Helvetica, sans-serif;
}

/* Float four columns side by side */
.column {
  float: left;
  width: 25%;
  padding: 0 10px;
}

/* Remove extra left and right margins, due to padding */
.row {margin: 0 -5px;}

/* Clear floats after the columns */
.row:after {
  content: "";
  display: table;
  clear: both;
}

/* Responsive columns */
@media screen and (max-width: 600px) {
  .column {
    width: 100%;
    display: block;
    margin-bottom: 20px;
  }
}

/* Style the counter cards */
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
  padding: 16px;
  text-align: center;
  background-color: #f1f1f1;
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
</style>

<section class="content-header">
	<h1><?=$page_name?><small>List</small></h1>
	<ol class="breadcrumb">
		<?php 
			foreach($breadcrumbs as $breadcrumb){
				if ($breadcrumb["link"] == NULL){
					echo "<li class='active'>".$breadcrumb["title"]."</li>";
				}else{
					echo "<li><a href='".$breadcrumb["link"]."'>".$breadcrumb["icon"].$breadcrumb["title"]."</a></li>";
				}
				
			} 
		?>
	</ol>
</section>

<section class="content">
	<div class="row">
		<div class="col-md-12">
			<div class="box box-info">
				<div class="box-header with-border">
				<h3 class="box-title"><?=$list_name?></h3>

			</div>			
			<!-- /.box-header -->
			<div class="box-body">
      <div align="right">
					<span>Search on:</span>
					<span>
            <select id="selectSearch" name="selectSearch" style="width: 148px;background-color:#e6e6ff;padding:8px;margin-left:6px;margin-bottom:6px">                            
                <?php
                    foreach($arrSearch as $key => $value){ ?>
                        <option value=<?=$key?>><?=$value?></option>
                    <?php
                    }
                // <option value="a.fin_id">No.Transaksi</option>
                // <option value="a.fst_customer_name">Customer</option>
                // <option value="c.fst_salesname">Sales Name</option>
                ?>
						</select>
					</span>
          <div class="col-12">
              <input type="text" name="searchbox" id="searchbox" class="filterinput form-control" placeholder="Search...">
          </div>
      </div>
      </div>
            
			<!-- /.box-body -->
			<div class="box-footer">
			</div>
			<!-- /.box-footer -->		
		</div>
	</div>
  <div class="row">
    <div class="col-md-12" id="recipe-card">
      <?php foreach($cards as $card): ?>
          <div class="column">
              <div class="card">
              <h3 class="card-id"><?php echo $card['fin_ticket_id']; ?></h3>
              <p><?php echo $card['fdt_ticket_datetime']; ?></p>
              <p><?php echo $card['fst_memo']; ?></p>
              <p><button data-id='<?= $card["fin_ticket_id"]?>'>Detail</button></p>
              </div>
          </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
    $("#searchbox").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#recipe-card div").filter(function() {
            $(this).toggle($(this).find('p').text().toLowerCase().indexOf(value) > -1)
        });
    });

    $("#recipe-card button").on("click",function(event){
      id = $(this).data("id");
      //window.location.replace("<=$edit_ajax_url?>" + id);
      window.location.href = "<?=$edit_ajax_url?>" + id;
    });
});
</script>

