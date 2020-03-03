<html>
<head>
<script src="<?= COMPONENT_URL?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Select2 -->
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/select2/dist/css/select2.min.css">
<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/bootstrap/dist/css/bootstrap.min.css">
<style type="text/css">
body {
  font-family: 'Open Sans', sans-serif;
  font-weight: 100;
  line-height: 1.42em;
  color:#eee8f5;
  background-color:#1F2739;
}

h1 {
  font-size:2em; 
  font-weight: 300;
  line-height:1em;
  text-align: center;
  color: #4DC3FA;
}

h2 {
  font-size:1em; 
  font-weight: 300;
  text-align: center;
  display: block;
  line-height:1em;
  padding-bottom: 2em;
  color: #FB667A;
}

h2 a {
  font-weight: 700;
  text-transform: uppercase;
  color: #FB667A;
  text-decoration: none;
}

.blue { color: #185875; }
.yellow { color: #FFF842; }

.container th h1 {
	  font-weight: bold;
	  font-size: 1em;
  text-align: left;
  color: #185875;
}

.container td {
	  font-weight: normal;
	  font-size: 1em;
  -webkit-box-shadow: 0 2px 2px -2px #0E1119;
	   -moz-box-shadow: 0 2px 2px -2px #0E1119;
	        box-shadow: 0 2px 2px -2px #0E1119;
}

.container {
	  text-align: left;
	  overflow: hidden;
	  width: 100%;
	  margin: 0 auto;
  display: table;
  padding: 0 0 4em 0;
}

.container td, .container th {
	  padding-bottom: 0.5%;
	  padding-top: 0.5%;
  padding-left:0%;  
}

/* Background-color of the odd rows */
.container tr:nth-child(odd) {
	  background-color: #2a2a2d;
}

/* Background-color of the even rows */
.container tr:nth-child(even) {
	  background-color: #2C3446;
}

.container th {
	  background-color: #093cf9;
	  color:#dee8ec;
}

.container td:last-child { color: #FB667A; }

.container tr:hover {
   background-color: #464A52;
-webkit-box-shadow: 0 6px 6px -6px #0E1119;
	   -moz-box-shadow: 0 6px 6px -6px #0E1119;
	        box-shadow: 0 6px 6px -6px #0E1119;
}

.container td:hover {
  background-color: #FFF842;
  color: #403E10;
  font-weight: bold;
  
  box-shadow: #7F7C21 -1px 1px, #7F7C21 -2px 2px, #7F7C21 -3px 3px, #7F7C21 -4px 4px, #7F7C21 -5px 5px, #7F7C21 -6px 6px;
  transform: translate3d(6px, -6px, 0);
  
  transition-delay: 0s;
	  transition-duration: 0.4s;
	  transition-property: all;
  transition-timing-function: line;
}

@media (max-width: 800px) {
.container td:nth-child(4),
.container th:nth-child(4) { display: none; }
}
</style>

<style type="text/css">
blink {
  -webkit-animation: 2s linear infinite condemned_blink_effect; /* for Safari 4.0 - 8.0 */
  animation: 2s linear infinite condemned_blink_effect;
}

/* for Safari 4.0 - 8.0 */
@-webkit-keyframes condemned_blink_effect { 
  0% {
    visibility: hidden;
  }
  50% {
    visibility: hidden;
  }
  100% {
    visibility: visible;
  }
}

@keyframes condemned_blink_effect {
  0% {
    visibility: hidden;
  }
  50% {
    visibility: hidden;
  }
  100% {
    visibility: visible;
  }
}
</style>
</head>
<div class="col-md-12">
    <select type="hidden" class="form-control select2" id="fin_dept_id" name="fin_dept_id[]" style="width: 100%" multiple="multiple">
    </select>
</div>
<body>
  <div class="container" style="padding-bottom: 5px">
  <br>
    <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="3000">
      <!-- Wrapper for slides -->
      <div id="corousel" class="carousel-inner" role="listbox">
      </div>
    </div>
  </div>
  <div class="tableticket">
    <table class="container" id="table-ticket">
      <thead>
        <tr>
          <th>Penerima</th>
          <th>Tanggal</th>
          <th>Deadline</th>
          <th>Dari User</th>
          <th>Persetujuan</th>
          <th>Memo Tiket</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody id="ticketlist">
      </tbody>
    </table>
  </div>
</body>
</html>
<script type="text/javascript">
  $(function(){
      isiTicketlist();
      setInterval(function(){
        isiTicketlist()        
      }, 50000);
  });

  $(function(){
    $deptList = [];
      <?php
      $arrDeptList = $this->msdepartments_model->getAllList();
      //$deptList = [];
       foreach($arrDeptList as $dept){ ?>
        $deptList.push({
              "id":"<?= $dept->fin_department_id ?>",
              "text":"<?= $dept->fst_department_name ?>"
          });  
      <?php } ?>

      $("#fin_dept_id").select2({
          width: '100%',
          data: $deptList
      });
      $('#fin_dept_id').next(".select2-container").hide();
  });

  function isiTicketlist(){
    //Fungsi Ajax
    $dept = window.department;
    $.ajax({
      url: "monitoringticket",
      method:"GET",
      data:{'fin_dept_id':$dept},
      datatype:"JSON",
    }).done(function(resp){
      $("#ticketlist").empty();
      $.each(resp.tickets,function(i,v){
        //console.log(v);
        if (v.fst_memo.length > 65){
          $cutmemo = v.fst_memo.substring(0,65);
          $spasi = $cutmemo.lastIndexOf(' ');
          $memo =$spasi? $cutmemo.substring(0,$spasi) : $cutmemo.substring(0);
          $memo +='  >>>';
        }else{
          $memo = v.fst_memo;
        }
        var ticketlist = '<tr>';
            if(v.fst_status == 'APPROVED/OPEN'){
              ticketlist +='<td><blink><font color="#00FF00">'+v.issuedTo+'</font></blink></td>';
            }else{
              ticketlist +='<td>'+v.issuedTo+'</td>';
            }
            ticketlist +='<td>'+v.fdt_ticket_datetime+'</td>';
            ticketlist +='<td>'+v.fdt_deadline_extended_datetime+'</td>';
            ticketlist +='<td>'+v.issuedBy+'</td>';
            //ticketlist +='<td>'+v.fdt_ticket_datetime+'</td>';
            if(v.fst_status == 'NEED_APPROVAL'){
              ticketlist +='<td><blink><font color="#00FF00">'+v.Approved+'</font></blink></td>';
            }else{
              ticketlist +='<td>'+v.Approved+'</td>';
            }
            ticketlist +='<td>'+$memo+'</td>';
            if(v.fst_status == 'NEED_APPROVAL' | v.fst_status == 'APPROVED/OPEN'){
              ticketlist +='<td><font color="#00FF00">'+v.fst_status+'</font></td>';
            }else{
              ticketlist +='<td>'+v.fst_status+'</td>';             
            }
            ticketlist += '</tr>';
        $("#ticketlist").append(ticketlist);
        $('#fin_dept_id').next(".select2-container").hide();
      })
    })
  }
</script>

<script type="text/javascript">
$(function(){
      setP();
      setInterval(function(){
        setP()        
      }, 100000);
  });

  function setP(){
      //$dept = window.department;
      $.ajax({
        url: "monitoringpengumuman",
        method:"GET",
        //data:{'fin_dept_id':$dept},
        datatype:"JSON",
      }).done(function(resp){
        var pengumuman = resp.arrPengumuman;
        $("#corousel").empty();
        $.each(pengumuman,function(i,v){
          console.log(v);
          var varactive = "";
            if(i == 0){
              varactive = "active";
            }
          $("#corousel").append("<div class='item " + varactive + "'><label><font color='#00FF00'>" + v.fst_memo + "</font></label></div>");
        });
      });
    }
</script>

<script src="<?= COMPONENT_URL?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Select2 -->
<script src="<?= COMPONENT_URL?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=COMPONENT_URL?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>