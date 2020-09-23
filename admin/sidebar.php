<!-- navbar and sidebar -->
<?php
include_once('session.php');
include('../config/db_config.php');
include('send_notification.php');

// include('session.php');


// include ('../config/db_config.php');
// session_start();
// $user_id = $_SESSION['id'];

// if (!isset($_SESSION['id'])) {
//     header('location:../index.php');
// } else {

// }
$user_id = $_SESSION['id'];

$db_fullname = '';
$photo = '';

//fetch user from database
$get_user_sql = " SELECT CONCAT(firstname,' ',LEFT(middlename, 1),'. ',lastname) as fullname,photo FROM tbl_users where id = :id";
$user_data = $con->prepare($get_user_sql);
$user_data->execute([':id' => $user_id]);
while ($result4 = $user_data->fetch(PDO::FETCH_ASSOC)) {
  $db_fullname = $result4['fullname'];
  $photo = $result4['photo'];
}

//get all draft from announcement
$get_all_draft_sql = "SELECT * FROM tbl_announcement WHERE status = 'draft'";
$get_all_draft_data = $con->prepare($get_all_draft_sql);
$get_all_draft_data->execute();
$numberofdraft = $get_all_draft_data->rowCount();

//get all new report from report pum/pui
$get_all_newreport_sql = "SELECT * FROM tbl_reportpum WHERE remarks = 'NEW REPORT'";
$get_all_newreport_data = $con->prepare($get_all_newreport_sql);
$get_all_newreport_data->execute();
$numberofnewreport = $get_all_newreport_data->rowCount();

?>

<nav class="main-header navbar navbar-expand greenBG navbar-light border-bottom">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
    </li>
    <li class="nav-item">
      <a href="index.php" class="nav-link">SCCDRRMO | SYSTEM</a>
    </li>
  </ul>

  <ul class="navbar-nav ml-auto">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="../../lockscreen.php" class="nav-link">Lock Screen</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="../../logout.php" class="nav-link">Log Out</a>
    </li>
  </ul>



</nav>
<!-- /.navbar -->

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
  <!-- Brand Logo -->
  <div class="greenBG">
    <br>

    <!-- <a href="index" class="brand-link">
      <img src="../dist/img/scdrrmo_logo.png" class="img-circle elevation-2" width="40px">   
    </a> -->

    <!-- Sidebar -->

    <!-- Sidebar user panel (optional) -->
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="../userimage/<?php echo $photo ?>" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a style="color:white" href="profile.php" class="d-block"><?php echo $db_fullname ?> </a>
        </div>
      </div>
    </div>

  </div>
  <div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->

        <li class="nav-item">
          <a href="index" class="nav-link active">
            <i class="nav-icon fa fa-th"></i>
            <p>
              Dashboard

            </p>
          </a>
        </li>

        <li class="nav-item " style="font-size:16px">
          <a href="announcement" class="nav-link ">
            <i class="nav-icon fa fa-exclamation-circle"></i>
            <p>
              ANNOUNCEMENTS
            </p>
          </a>

        <li class="nav-item has-treeview" style="font-size:16px">
          <a href="#" class="nav-link ">
            <i class="nav-icon fa fa-thermometer-full"></i>
            <p>
              COVID-19
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">



            <li class="nav-item">
              <a href="#" class="nav-link">
                &nbsp;&nbsp; <i class="fa fa-address-book-o "></i>
                <p> &nbsp; Entity</p>
              </a>

              <ul class="nav nav-treeview">

                <li class="nav-item">
                  <a href="list_individual" class="nav-link">
                    &nbsp; &nbsp; &nbsp;<i class="fa fa-share fa-flip-vertical "></i>
                    <p> &nbsp; Individual</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="list_juridical" class="nav-link">
                    &nbsp; &nbsp; &nbsp;<i class="fa fa-share fa-flip-vertical "></i>
                    <p> &nbsp; Juridical</p>
                  </a>
                </li>

                <li class="nav-item">
                  <a href="add_pum" class="nav-link">
                    &nbsp; &nbsp; &nbsp;<i class="fa fa-share fa-flip-vertical "></i>
                    <p> &nbsp; Transportation</p>
                  </a>
                </li>




              </ul>




            </li>










            <!-- 

            <li class="nav-item">
              <a href="report_pum" class="nav-link">
                <i class="nav-icon fa fa-medkit"></i>
                <span class="badge badge-danger navbar-badge"><?php if ($numberofnewreport > 0) {
                                                                echo $numberofnewreport;
                                                              } ?></span>
                <p>Reported Cases</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="list_symptoms" class="nav-link">
                <i class="fa fa-minus nav-icon"></i>
                <p> Symptoms</p>
              </a>
            </li>
 -->




          </ul>




          <!-- <li class="nav-item has-treeview" style="font-size:16px">
            <a href="" class="nav-link ">
              <i class="nav-icon fa fa-exchange"></i>
              <p>
                REGISTRATION LIST
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
           

       
            <ul class="nav nav-treeview">
              <li class="nav-item">
              //<?php echo $registration_list ?>
            </ul> -->

        <li class="nav-item " style="font-size:16px">
          <?php echo $incident_report ?>

        <li class="nav-item has-treeview" style="font-size:16px">
          <a href="" class="nav-link ">
            <i class="nav-icon fa fa-list"></i>
            <p>
              SETTINGS
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="list_users.php" class="nav-link">
                <i class="fa fa-minus nav-icon"></i>
                <p>Users</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="view_all_posts" class="nav-link">
                <i class="fa fa-minus nav-icon"></i>
                <span class="badge badge-danger navbar-badge"><?php if ($numberofdraft > 0) {
                                                                echo $numberofdraft;
                                                              } ?></span>
                <p>View Announcements</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="#addnew" data-toggle="modal" data-target="#push_notify" class="nav-link">
                <i class="fa fa-minus nav-icon"></i>
                <p>Send Mobile Alerts</p>
              </a>
            </li>

          </ul>


        <li class="nav-item has-treeview" style="font-size:16px">
          <a href="#" class="nav-link ">
            <i class="nav-icon fa fa-cogs"></i>
            <p>
              SYSTEM
              <i class="right fa fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="" class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>Lock Screen</p>
              </a>
            <li class="nav-item">
              <a href="log_out" class="nav-link">
                <i class="fa fa-circle-o nav-icon"></i>
                <p>Log Out</p>
              </a>

          </ul>

    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->

  <?php include('push_notification.php'); ?>

</aside>