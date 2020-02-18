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
.example3 {
 height: 30px;	
 overflow: hidden;
 position: relative;
}
.example3 input {
 position: absolute;
 width: 100%;
 height: 100%;
 margin: 0;
 line-height: 30px;
 text-align: center;
 font-size:20px;
 /* Starting position */
 -moz-transform:translateX(100%);
 -webkit-transform:translateX(100%);	
 transform:translateX(100%);
 /* Apply animation to this element */	
 -moz-animation: example3 15s ease infinite;
 -webkit-animation: example3 15s ease infinite;
 animation: example3 15s ease infinite;
}
/* Move it (define the animation) */
@-moz-keyframes example3 {
 0%   { -moz-transform: translateX(100%); }
 40%   { -moz-transform: translateX(0%); }
 60%   { -moz-transform: translateX(0%); }
 100% { -moz-transform: translateX(-100%); }
}
@-webkit-keyframes example3 {
 0%   { -webkit-transform: translateX(100%); }
 40%   { -webkit-transform: translateX(0%); }
 60%   { -webkit-transform: translateX(0%); }
 100% { -webkit-transform: translateX(-100%); }
}
@keyframes example3 {
 0%   { 
 -moz-transform: translateX(100%); /* Firefox bug fix */
 -webkit-transform: translateX(100%); /* Firefox bug fix */
 transform: translateX(100%); 		
 }
 40%   { 
 -moz-transform: translateX(0%); /* Firefox bug fix */
 -webkit-transform: translateX(0%); /* Firefox bug fix */
 transform: translateX(0%); 		
 }
 60%   { 
 -moz-transform: translateX(0%); /* Firefox bug fix */
 -webkit-transform: translateX(0%); /* Firefox bug fix */
 transform: translateX(0%); 		
 }
 100% { 
 -moz-transform: translateX(-100%); /* Firefox bug fix */
 -webkit-transform: translateX(-100%); /* Firefox bug fix */
 transform: translateX(-100%); 
 }
}
</style>
</head>
<!--<div class="example3">
  <form name="info">
      <input type="text" name="msg" font-weight="bold" height="pixels" placeholder ="TIKET TIPE PENGUMUMAN" disabled/>
  </form>
</div>-->
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
  <!--<div class="example3">
  <h3>Libur Natal dan Tahun baru mulai 24 Des 2019 s/d 02 Jan 2020,selamat hari natal dan tahun baru.</h3>
  </div>-->

  <div class="tableticket">
    <table class="container" id="table-ticket">
      <thead>
        <tr>
          <th id="init_select2">Penerima</th>
          <th>Tanggal</th>
          <th>Deadline</th>
          <th>Dari User</th>
          <th>Persetujuan</th>
          <th>Memo Tiket</th>
          <th id="destroy_select2">Status</th>
        </tr>
      </thead>
      <tbody id="ticketlist">
      </tbody>
    </table>
  </div>
</body>
</html>
<script type="text/javascript">
var $fin_department_id = $("#fin_dept_id").val();
  $(function(){
      isiTicketlist();
      setInterval(function(){
        isiTicketlist()        
      }, 70000);
  });

  $(function(){
    $deptList = [];
    console.log(window.department);
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
  });

  /*$("#destroy_select2").click(function() { 
    $('#fin_dept_id').next(".select2-container").hide(); 
  });
  $("#init_select2").click(function() { 
    $('#fin_dept_id').next(".select2-container").show(); 
  });*/

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
        if (v.issuedTo == null){
          $issuedTo = "";
        }else{
          $issuedTo = v.issuedTo;
        }
        if (v.Approved == null){
          $Approved = "";
        }else{
          $Approved = v.Approved;
        }
        var ticketlist = '<tr>';
            if(v.fst_status == 'APPROVED/OPEN' && $issuedTo != ""){
              ticketlist +='<td><marquee><font color="#00FF00">'+$issuedTo+'</font></marquee></td>';
            }else{
              ticketlist +='<td>'+$issuedTo+'</td>';
            }
            ticketlist +='<td>'+v.fdt_ticket_datetime+'</td>';
            ticketlist +='<td>'+v.fdt_deadline_extended_datetime+'</td>';
            if(v.fst_status == 'NEED_REVISION' || v.fst_status == 'COMPLETED'){
              ticketlist +='<td><marquee><font color="#00FF00">'+v.issuedBy+'</font></marquee></td>';
            }else{
              ticketlist +='<td>'+v.issuedBy+'</td>';
            }
            //ticketlist +='<td>'+v.fdt_ticket_datetime+'</td>';
            if(v.fst_status == 'NEED_APPROVAL' && $Approved !="" ){
              ticketlist +='<td><marquee><font color="#00FF00">'+$Approved+'</font></marquee></td>';
            }else{
              ticketlist +='<td>'+$Approved+'</td>';
            }
            ticketlist +='<td>'+$memo+'</td>';
            if(v.fst_status == 'NEED_APPROVAL' | v.fst_status == 'APPROVED/OPEN'){
              ticketlist +='<td><font color="#00FF00">'+v.fst_status+'</font></td>';
            }else{
              ticketlist +='<td>'+v.fst_status+'</td>';             
            }
            ticketlist += '<tr>';
        $("#ticketlist").append(ticketlist);
        $('#fin_dept_id').next(".select2-container").hide();
      })
    })
  }
  /*$(function(){
      isiPengumuman();
      setInterval(function(){
        isiPengumuman()        
      }, 5000);
  });

  function isiPengumuman(){
    //Fungsi Ajax
    $.ajax({
      url: "monitoringpengumuman",
      method:"GET",
      data:{'fin_dept_id':$("#fin_dept_id").val()},
      datatype:"JSON",
    }).done(function(resp){
      $.each(resp.arrPengumuman,function(i,v){
        console.log(v);
        //var announcement = new Array();
        var i = 0;
        var announcement = v.fst_memo;
        var durasi = 15000;
        id = setInterval('script()',durasi);
        var c = 0;
          function script() {
            app = announcement;
            if (c == i) c = 0;
            document.info.msg.value = app;
            //$("#pengumuman").html(app);
          }
        //$("#running_info").append(ticketlist);
      })
    })
  }*/
/*var announcement = new Array();
var i = 0;
<?php foreach($tickets as $pengumuman){ ?>
  announcement[i++] = '<?= $pengumuman->fst_memo ?>';
<?php } ?>
var durasi = 15000;
id = setInterval('script()',durasi);
var c = 0;
  function script() {
    app = announcement[c++];
    if (c == i) c = 0;
    document.info.msg.value = app;
    //$("#pengumuman").html(app);
  }*/
</script>
<script type="text/javascript">
$(function(){
      setP();
      setInterval(function(){
        setP()        
      }, 50000);
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
        $("#corousel").append("<div class='item " + varactive + "'><label>" + v.fst_memo + "</label></div>");
      })
    })
  }
</script>

<script src="<?= COMPONENT_URL?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Select2 -->
<script src="<?= COMPONENT_URL?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=COMPONENT_URL?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>