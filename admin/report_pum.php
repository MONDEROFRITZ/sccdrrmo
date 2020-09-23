
<?php

include ('../config/db_config.php');
include ('verify_admin.php');
$user_id = $_SESSION['id'];

if (!isset($_SESSION['id'])) {
    header('location:../index.php');
} else {

}


//get all reported pum
$get_all_reportpum_sql = "SELECT * FROM tbl_reportpum";
$get_all_reportpum_data = $con->prepare($get_all_reportpum_sql);
$get_all_reportpum_data->execute();

$alert_msg = '';

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SCCDRRMO | Reported PUM</title>
 
  <?php include('header.php');?>

</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <?php include('sidebar.php');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" >
    <div class="content-header"></div>
    <div class="container-fluid">      
 
     <div class="row">

       <div class="col-lg-12">
           <div class="card shadow card-info">
             <div class="card-header">
               <h4 class="page-header">
                  REPORTED PUI/PUM
               </h4>
             </div> <!-- /.card-header -->
             <form role="form" method="get" action="<?php htmlspecialchars("PHP_SELF");?>">
              <div class="card-body">
                 <div class="float-topright">
                    <?php echo $alert_msg; ?>      
                 </div>

                <table id="maintable" class="table table-bordered table-striped table-responsive">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th width="175px">Date Created</th>
                      <th>Fullname</th>
                      <th>Address</th>
                      <th>Contact Number</th>
                      <th width="25px" style='font-size: 10px'>Traveled during the past 14 days</th>
                      <th width="25px" style='font-size: 10px'>Travel history to an infected area</th>
                      <th width="25px" style='font-size: 10px'>COVID-19 related symptoms</th>
                      <th>Reported by</th>
                      <th>View Report</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while($data = $get_all_reportpum_data->fetch(PDO::FETCH_ASSOC)){ ?>
                      <tr>
                        <td><?php echo  $data['objid']; ?></td>
                        <td><?php echo  $data['createdat']; ?></td>
                        <td><?php echo $data['fullname'];?></td>
                        <td><?php echo $data['address'];?></td>
                        <td><?php echo $data['contactno'];?></td>
                        <td><input type="checkbox" onclick="return false;" <?php echo ($data['travel']=='YES' ? 'checked' : '');?>></td>
                        <td><input type="checkbox" onclick="return false;" <?php echo ($data['travelhistory']=='YES' ? 'checked' : '');?>></td>
                        <td><input type="checkbox" onclick="return false;" <?php echo ($data['symptoms']=='YES' ? 'checked' : '');?>></td>
                        <td><?php echo $data['reportedby'];?></td>
                        <td align="center">
                        <?php if($data['remarks'] == 'NEW REPORT'){$btnnew = ''; $btndone = 'hidden';}else{$btnnew = 'hidden'; $btndone = '';}?>
                        <button <?php echo $btnnew ?> class="btn btn-flat btn-danger viewreport btn-lg" data-id="<?php echo $data["objid"]; ?>" data-placement="top" title="View Report"><i class="fa fa-folder"></i></button>
                        <button <?php echo $btndone ?> class="btn btn-flat btn-outline-success viewreport btn-lg" data-id="<?php echo $data["objid"]; ?>" data-placement="top" title="View Report"><i class="fa fa-folder-open"></i></button>
                        </td>
                      </tr>

                    <?php } ?>
                  </tbody>
                </table>
              </div><!-- /.card-body -->
             </form>
           </div> <!-- /.card shadow-->
       </div><!-- /.col-lg-12 -->
          
      

     </div><!-- end row -->
    </div><!-- end container-fluid -->
    

  </div><!-- /.content-wrapper -->

  <!-- View Report Modal -->
  <div class="modal fade" id="viewreport">
    <div class="modal-dialog modal-lg">
          <div class="modal-content">
          	<div class="modal-header card-outline card-info">
            	<h4 class="modal-title"><b>Reported PUI/PUM</b></h4>
          	</div>
          	<div class="modal-body">
            	<form class="form-horizontal" method="POST" action="<?php htmlspecialchars("PHP_SELF"); ?>">
            		<input type="hidden" type="" class="objid" name="id">
            		<div class="row">
                  <div class="col-md-5">
                     <label class="col-form-label ">DATE</label>
                     <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                      <input type="text" name ="date" class="form-control date" data-provide="datepicker" data-date-format="yyyy/mm/dd" data-date-today-btn="linked" id="datepicker">
                     </div>
                  </div>
                  <div class="col-md-5">
                     <label class="col-form-label ">TIME </label>
                     <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-clock-o"></i></span>
                      <input type="text" name ="time" class="form-control time">
                     </div>
                  </div>
	            	</div>
                <div class="row">
                  <div class="col-md-12">
                     <label class="col-form-label ">FULL NAME</label>
                     <input type="text" name ="fullname" class="form-control fullname" id="">
                  </div>
	            	</div>
                <div class="row">
                  <div class="col-md-12">
                     <label class="col-form-label ">ADDRESS</label>
                     <input type="text" name ="address" class="form-control address" id="">
                  </div>
	            	</div>
                <div class="row">
                  <div class="col-md-12">
                     <label class="col-form-label ">CONTACT NUMBER</label>
                     <input type="text" name ="contactno" class="form-control contactno" id="">
                  </div>
	            	</div>
                <br>
                <div class="row">
                  <div class="col-md-5">
                     <p class="col-form-label ">Traveled recently during the past 14 days.</p>
                  </div>
                  <div class="col-md-1">
                     <div id="travel"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                     <p class="col-form-label ">Travel history to an infected area.</p>
                  </div>
                  <div class="col-md-1">
                     <div id="travelhistory"></div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-5">
                     <p class="col-form-label ">Experienced any COVID-19 related symptoms.</p>
                  </div>
                  <div class="col-md-1">
                     <div id="symptoms"></div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-5">
                     <label class="col-form-label ">REPORTED BY</label>
                     <input type="text" name ="reportedby" class="form-control reportedby" id="">
                  </div>
                  <div class="col-md-4">
                     <label class="col-form-label ">REPORTER'S MOBILE NUMBER</label>
                     <input type="text" name ="remarks" class="form-control mobileno" id="">
                  </div>
                </div>
          	</div>
          	<div class="modal-footer">
            	<button type="submit" class="btn btn-flat btn-dark pull-left"><i class="fa fa-close"></i> Close</button>
            	
            	</form>
          	</div>
          </div>
     </div>
  </div><!-- View Report Modal -->

 <?php include('footer.php')?>

</div><!-- /.wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/jquery/jquery.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- datepicker -->
<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
<!-- iCheck 1.0.1 -->
<script src="../plugins/iCheck/icheck.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="../plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/adminlte.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="../dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../dist/js/demo.js"></script>
<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap4.js"></script>

<script>
$('#maintable').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'autoHeight'  : true,
      "order": [[ 0, "desc" ]]
    });
</script>

<script>
 $(function(){
  $(document).on('click', '.viewreport', function(e) {
    e.preventDefault();
    $('#viewreport').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
 
});

function getRow(id){

  $.ajax({

    type: 'POST',
    url: 'report_pum_fetch.php',
    data: {id:id},
    dataType: 'json',
    success: function(data){
      
      $('#objid').val(data.id);
      $('.objid').val(data.id);
      $('.date').val(data.date);
      $('.time').val(data.time);
      $('.fullname').val(data.fullname);
      $('.contactno').val(data.contactno);
      $('.address').val(data.address);
      $('#travel').html(data.travel);
      $('#travelhistory').html(data.travelhistory);
      $('#symptoms').html(data.symptoms);
      $('.reportedby').val(data.reportedby);
      $('.mobileno').val(data.mobileno);
      $('.remarks').val(data.remarks);
      
    }
  });
};

 </script>

</body>
</html>
