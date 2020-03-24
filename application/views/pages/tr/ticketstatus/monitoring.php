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
  margin: 0px 8px 0px 8px;
}

table {
    border-collapse: separate;
    border-spacing: 2;
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

<style type="text/css">
.example3 {
 /*height: 100px;	*/
 overflow: hidden;
 position: relative;
}
.example3 h3 {
 display:inline-block;
 position: relative;
 width: 100%;
 /*height: 100%; */
 margin: 0;
 line-height: 20px;
 text-align: center;
 /* Starting position */
 -moz-transform:translateX(100%);
 -webkit-transform:translateX(100%);	
 transform:translateX(100%);
 /* Apply animation to this element */	
 -moz-animation: example3 20s ease infinite;
 -webkit-animation: example3 20s ease infinite;
 animation: example3 20s ease infinite;
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
<div class="col-md-12">
    <select type="hidden" class="form-control select2" id="fin_dept_id" name="fin_dept_id[]" style="width: 100%" multiple="multiple">
    </select>
</div>
<body>
  <div style="padding-bottom: 5px">
  <br>
    <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="6000">
      <!-- Wrapper for slides-->
      <div id="carousel-pengumuman" class="carousel-inner" role="listbox">
      </div>
    </div>
  </div>
  <!--<div class="example3" id="animation">
  <h3 name="msg"></h3>
  </div>-->
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
</html>
<script type="text/javascript">
  $(function(){
      isiTicketlist();
      setInterval(function(){
        isiTicketlist()        
      }, 90000);
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
      //$("#carousel-pengumuman").empty();
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
        if (v.fst_assignment_or_notice =='NOTICE'){
            $days = 7;
        }else{
            $days = Number(v.fin_service_level_days -1);
        }
        //$days = (Math.abs(parseInt($days))); //tambahan
        //$daysLevel = "{$days} days"; //tambahan
        //$now = new Date("Y-m-d H:i:s");
        //$now.setDate($now.getDate() + $daysLevel);
        //$ticketdeadline_datetime = new Date($now,"Y-m-d H:i:s");
        /*now = new Date();
        ticketdeadline_datetime = new Date();
        ticketdeadline_datetime.setDate(now.getDate() + $days);
        ticketdeadline_datetime = ticketdeadline_datetime.toDateString();*/

        var ticketdeadline_datetime = new Date(); 
        //el_up.innerHTML = today; 
        var dd = ticketdeadline_datetime.getDate() + $days; 
        var mm = ticketdeadline_datetime.getMonth() + 1; 
  
        var yyyy = ticketdeadline_datetime.getFullYear(); 
        if (dd < 10) { 
            dd = '0' + dd; 
        } 
        if (mm < 10) { 
            mm = '0' + mm; 
        } 
        var ticketdeadline_datetime = yyyy + '-' + mm + '-' + dd; 

        if (v.fdt_deadline_extended_datetime == null){
            v.fdt_deadline_datetime = ticketdeadline_datetime;
            v.fdt_deadline_extended_datetime = ticketdeadline_datetime; 
        }
        var ticketlist = '<tr>';
            if(v.fst_status == 'APPROVED/OPEN' | v.fst_status == 'COMPLETION_REVISED'){
              ticketlist +='<td><blink><font color="#00FF00">'+v.issuedTo+'</font></blink></td>';
            }else{
              ticketlist +='<td>'+v.issuedTo+'</td>';
            }
            ticketlist +='<td>'+v.fdt_ticket_datetime+'</td>';
            ticketlist +='<td>'+v.fdt_deadline_extended_datetime+'</td>';
            if(v.fst_status == 'NEED_REVISION' | v.fst_status == 'COMPLETED'){
              ticketlist +='<td><blink><font color="#00FF00">'+v.issuedBy+'</font></blink></td>';
            }else{
              ticketlist +='<td>'+v.issuedBy+'</td>';
            }
            //ticketlist +='<td>'+v.issuedBy+'</td>';
            //ticketlist +='<td>'+v.fdt_ticket_datetime+'</td>';
            if(v.fst_status == 'NEED_APPROVAL'){
              ticketlist +='<td><blink><font color="#00FF00">'+v.Approved+'</font></blink></td>';
            }else{
              ticketlist +='<td>'+v.Approved+'</td>';
            }
            ticketlist +='<td>'+$memo+'</td>';
            if(v.fst_status == 'NEED_APPROVAL' | v.fst_status == 'APPROVED/OPEN' | v.fst_status == 'NEED_REVISION' | v.fst_status == 'COMPLETION_REVISED'){
              ticketlist +='<td><font color="#00FF00">'+v.fst_status+'</font></td>';
            }else{
              ticketlist +='<td>'+v.fst_status+'</td>';             
            }
            ticketlist += '</tr>';
          $("#ticketlist").append(ticketlist);
          $('#fin_dept_id').next(".select2-container").hide();
        })

      //populate pengumuman
      /*$.each(resp.pengumuman,function(i,v){
        //console.log(v);
        var varactive = "";
          if(i == 0){
            varactive = "active";
          }
        $("#carousel-pengumuman").append("<div class='item " + varactive + "'><label><font color='#00FF00'>" + v.fst_memo + "</font></label></div>");
        //$("<div class='carousel-item " + varactive + "'><label><font color='#00FF00'>" + v.fst_memo + "</font></label></div>").append('#carousel-pengumuman');

          //interval between items (in milliseconds)
          /*var itemInterval = 1000;        
          //count number of items
          var numberOfItems = v.fst_memo.length;
          //set current item
          var currentItem = 0;
          //show first item
          //$("#animation").eq(currentItem).append("<h3>" + v.fst_memo + "</h3>");
	
          setInterval(function(){
            if(currentItem == numberOfItems -1){
              currentItem = 0;
            }else{
              currentItem++;
            }
            $("#animation").eq(currentItem).append("<h3>" + v.fst_memo + "</h3>");
          }, 1000);*/

        /*$('#myCarousel').carousel({
          interval: 9000
          });*/
       });
  }
</script>

<script type="text/javascript">
$(function(){
      setP();
      setInterval(function(){
        //setP()        
      }, 9000);
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
        $("#carousel-pengumuman").empty();
        $.each(pengumuman,function(i,v){
          console.log(v);
          var varactive = "";
            if(i == 0){
              varactive = "active";
            }
          $("#carousel-pengumuman").append("<div class='item " + varactive + "'><label><font color='#00FF00'>" + v.fst_memo + "</font></label></div>");
        });
      });
      //$('#carousel-pengumuman').carousel({
        //interval: 9000
      //});
    }
</script>

<script src="<?= COMPONENT_URL?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- Select2 -->
<script src="<?= COMPONENT_URL?>bower_components/select2/dist/js/select2.full.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=COMPONENT_URL?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>