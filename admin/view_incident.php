
<?php

include ('../config/db_config.php');
include ('update_incident.php');
// include ('get_photo.php');
session_start();
$user_id = $_SESSION['id'];

if (!isset($_SESSION['id'])) {
    header('location:../index.php');
} else {

}

date_default_timezone_set('Asia/Manila');  
$date = date('Y-m-d');
$time = date('H:i:s');



//fetch user from database
$get_user_sql = "SELECT * FROM tbl_users where id = :id";
$user_data = $con->prepare($get_user_sql);
$user_data->execute([':id' => $user_id]);
while ($result = $user_data->fetch(PDO::FETCH_ASSOC)) {

    $db_fullname = $result['fullname'];

}


$btnSave = $btnMap = $get_objid = $get_time = $get_date = 
$get_name = $get_details = $get_type = $get_serivity = '';

  $user_id = $_GET['id'];

  $get_incident_sql = "SELECT * FROM tbl_incident WHERE objid = :id ";
  $get_incident_data = $con->prepare($get_incident_sql);
  $get_incident_data->execute([':id' => $user_id]);
  while ($result = $get_incident_data->fetch(PDO::FETCH_ASSOC)) {
    $get_objid                  = $result['objid'];  
    $get_date                   = $result['date'];
    $get_time                   = $result['time'];
    $get_name                   = $result['reported_by'];
    $get_type                   = $result['type'];
    $get_severity               = $result['severity'];
    $get_mobileno               = $result['mobileno'];
    $get_details                = $result['topic'];
    $get_createdat              = $result['createdat'];
    $latitude                   = $result['latitude'];
    $longitude                  = $result['longitude'];
    $image                      = $result['image'];
    $remarks                     = $result['remarks'];

  };

  // // this is an example of valid latitude ang longitude
  // $lat = $latitude;
  // $lon = $longitude;

 

 //update remarks to read so that it will not appear on notification
 if($remarks == 'NEW REPORT'){
$query = "UPDATE tbl_incident SET remarks = 'READ' WHERE objid = '$user_id' ";
$stmt = $con->prepare($query);
$stmt->execute();
};
?>

 

<!DOCTYPE html>
<html>
<meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SCCDRRMO | Incident Report</title>
  <?php include('header.php');?>


</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <?php include('sidebar.php');?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper" align="center">
    <div class="content-header"></div>

    <section class="content" >
                        <div class="row">
                          <div class="col-md-8">
                            <iframe height="100%" width="100%" frameborder="0" src = "https://maps.google.com/maps?q=<?= $latitude ?>,<?= $longitude ?>&hl=es;z=14&amp;output=embed"></iframe>
                          </div>
                          <div class="col-md-4">
                            <div class="card">
                            
                              <img class="img-fluid" src="<?php echo (empty($image)) ? '../dist/img/scdrrmo_logo.png' : '../mobile/images/'.$image ; ?>">
                            </div>
                          </div>
                         </div>
                         <br>

        <div class="card card-outline card-info"  >
         
                <div class="card-header ">
                  <h6>INCIDENT DETAILS</h6>
                </div>

                <div class="card-body">

            
            <div class="box">
                          
                          <div class="row"> 
                            <div class="col-md-4" style="text-align: right;padding-top: 5px;">
                              <label>ID No:</label>
                            </div>
                            <div class="col-md-3" >
                              <input type="text" readonly  class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="objid" id ="objid" placeholder="ID NO" value="<?php echo $get_objid;?>" required>
                            </div>
                          </div><br>

                          <div class="row"> 
                            <div class="col-md-4" style="text-align: right;padding-top: 5px;">
                              <label>Date:</label>
                            </div>
                            <div class="col-md-2" >
                              <input type="text" readonly class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="date" placeholder="Date" value="<?php echo $get_date;?>" required>
                            </div>
                            <div class="col-md-1" style="text-align: right;padding-top: 5px;">
                              <label>Time:</label>
                            </div>
                            <div class="col-md-2">
                            <input type="text" readonly class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="time" placeholder="Time" value="<?php echo $get_time;?>" required>     
                            </div>
                          </div><br>


                          <div class="row"> 
                            <div class="col-md-4" style="text-align: right;padding-top: 5px;">
                              <label>Type:</label>
                            </div>
                            <div class="col-md-2" >
                              <input type="text" readonly class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="type" placeholder="Type" value="<?php echo $get_type;?>" required>
                            </div>
                            <div class="col-md-1" style="text-align: right;padding-top: 5px;">
                              <label>Serevity:</label>
                            </div>
                            <div class="col-md-2" >
                            <input type="text" readonly class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="severity" placeholder="Serivity" value="<?php echo $get_severity;?>" required>     
                            </div>
                          </div><br>




                          <div class="row"> 
                            <div class="col-md-4" style="text-align: right;padding-top: 5px;">
                              <label>Name:</label>
                            </div>
                            <div class="col-md-5" >
                              <input type="text" readonly class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="name" placeholder="Name" value="<?php echo $get_name;?>" required>
                            </div>
                          </div><br>

                          <div class="row"> 
                            <div class="col-md-4" style="text-align: right;padding-top: 5px;">
                              <label>Mobile Number:</label>
                            </div>
                            <div class="col-md-5" >
                              <input type="text" readonly  class="form-control" onkeyup="this.value = this.value.toUpperCase();" name="mobileno" placeholder="Mobile Number" value="<?php echo $get_mobileno;?>" required>
                            </div>
                          </div><br>

                          <div class="row"> 
                            <div class="col-md-4" style="text-align: right;padding-top: 5px;">
                 
                              <label>Details of Incident:</label>
                              </div>
                              <div class="col-md-5" >
                              <textarea readonly class="form-control" row="10"  name="topic" placeholder="Details of Incident" required><?php echo $get_details;?></textarea>
                     
                              </div>
                          </div><br>
                               
                          <!-- /.box-body -->
                          <div class="box-footer" >
                              <a href="list_incident.php">
                                <button type="button" name="cancel" class="btn btn-danger">       
                                CLOSE </button>
                              </a>
                          </div>

                    </div>
                  
                  </form>
                </div>
              <!-- /.box -->
        </div>
       

    </section>
    

  </div>
  <!-- /.content-wrapper -->
  
 <?php 

 include('footer.php')?>

</div>

<!-- add pum modal -->









<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- datepicker -->
<script src="../plugins/datepicker/bootstrap-datepicker.js"></script>
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
<!-- DataTables Bootstrap -->
<script src="../plugins/datatables/dataTables.bootstrap4.js"></script>
<!-- Select2 -->
<script src="../plugins/select2/select2.full.min.js"></script>

<script>
     $('.select2').select2();

    $('#users').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : true,
      'info'        : true,
      'autoWidth'   : true,
      'autoHeight'  : true
     
    });
   
</script>
</body>
</html>
