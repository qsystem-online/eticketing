<html>
<head>
<script src="<?= COMPONENT_URL?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Select2 -->
<link rel="stylesheet" href="<?=COMPONENT_URL?>bower_components/select2/dist/css/select2.min.css">
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
.running-text{
	background-color: #6962de; /*untuk memberikan background, link : https://www.w3schools.com/cssref/css3_pr_background.asp*/
	color:white; /*untuk memberikan warna pada text, link : https://www.w3schools.com/cssref/pr_text_color.asp*/
	padding-top: 5px; /*untuk memberikan jarak dalam element di bagian atas (top), link : https://www.w3schools.com/cssref/pr_padding-top.asp*/
	bottom-top: 5px;
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
<div class="example3">
  <form name="info">
      <input type="text" name="msg" font-weight="bold" placeholder ="TIKET TIPE PENGUMUMAN" disabled/>
  </form>
</div>
<body>
<div class="col-md-12">
  <select class="form-control select2" id="fin_dept_id" name="fin_dept_id[]" style="width: 100%" multiple="multiple">
      <!--<php
      $deptList = $this->msdepartments_model->getAllList(); 
      foreach ($deptList as $dept) {    ?>
              <option value='<= $dept->fin_department_id ?>'><= $dept->fst_department_name ?> </option>
          <php
      } ?>-->
  </select>
</div>
  <!--<div class="example3">
  <h3>Libur Natal dan Tahun baru mulai 24 Des 2019 s/d 02 Jan 2020,selamat hari natal dan tahun baru.</h3>
  </div>-->

  <div class="tableticket">
    <table class="container" id="table-ticket">
      <thead>
      <!--<meta http-equiv="refresh" content="30">-->
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
      <!--<tbody id="ticketlist">
          <?php foreach($tickets as $data): ?>
            <tr>
              <td><?php echo $data->issuedTo; ?></td>
              <td><?php echo $data->fst_memo; ?></td>
              <td><?php echo $data->issuedBy; ?></td>
              <td><?php echo $data->fdt_ticket_datetime; ?></td>
              <td><?php echo $data->issuedBy; ?></td>
              <td><?php echo $data->fst_status; ?></td>
            </tr>
            <?php endforeach; ?>
      </tbody>-->
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
      }, 5000);
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
  });

  $("#destroy_select2").click(function() { 
    $("#fin_dept_id").select2("destroy"); 
  });
  $("#init_select2").click(function() { 
    $("#fin_dept_id").select2(); 
  });

  function isiTicketlist(){
    //Fungsi Ajax
    $.ajax({
      url: "monitoringticket",
      method:"GET",
      data:{'fin_dept_id':$("#fin_dept_id").val()},
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
              ticketlist +='<td><marquee><font color="#00FF00">'+v.issuedTo+'</font></marquee></td>';
            }else{
              ticketlist +='<td>'+v.issuedTo+'</td>';
            }
            ticketlist +='<td>'+v.fdt_ticket_datetime+'</td>';
            ticketlist +='<td>'+v.fdt_deadline_extended_datetime+'</td>';
            ticketlist +='<td>'+v.issuedBy+'</td>';
            //ticketlist +='<td>'+v.fdt_ticket_datetime+'</td>';
            if(v.fst_status == 'NEED_APPROVAL'){
              ticketlist +='<td><marquee><font color="#00FF00">'+v.Approved+'</font></marquee></td>';
            }else{
              ticketlist +='<td>'+v.Approved+'</td>';
            }
            ticketlist +='<td>'+$memo+'</td>';
            if(v.fst_status == 'NEED_APPROVAL' | v.fst_status == 'APPROVED/OPEN'){
              ticketlist +='<td><font color="#00FF00">'+v.fst_status+'</font></td>';
            }else{
              ticketlist +='<td>'+v.fst_status+'</td>';             
            }
            ticketlist += '<tr>';
        $("#ticketlist").append(ticketlist);
        $("#fin_dept_id").hide();
      })
    })
  }
</script>

<script>
var announcement = new Array();
var i = 0;
<?php foreach($arrPengumuman as $pengumuman){ ?>
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
  }
</script>
<script src="<?= COMPONENT_URL?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Select2 -->
<script src="<?= COMPONENT_URL?>bower_components/select2/dist/js/select2.full.js"></script>