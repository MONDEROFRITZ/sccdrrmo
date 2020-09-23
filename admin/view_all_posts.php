
<?php

include ('../config/db_config.php');
include ('verify_admin.php');
$user_id = $_SESSION['id'];

if (!isset($_SESSION['id'])) {
    header('location:../index.php');
} else {

}

include('view_all_posts_insert.php');

//get all announcement
$get_all_announcement_sql = "SELECT * FROM tbl_announcement";
$get_all_announcement_data = $con->prepare($get_all_announcement_sql);
$get_all_announcement_data->execute();

?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SCCDRRMO | View All Announcement</title>
 
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
           <div class="card shadow">
             <div class="card-header">
               <h2 class="page-header">
                  View All Announcements
                  <div class="pull-right">
                    <a href="add_announcement" class="btn btn-success btn-lg" data-placement="top" title="Add Announcement"><i class="fa fa-plus"></i></a>
                  </div>
               </h2>
             </div> <!-- /.card-header -->
             <form role="form" method="get" action="<?php htmlspecialchars("PHP_SELF");?>">
              <div class="card-body">
                 <div class="float-topright">
                    <?php echo $alert_msg; ?>      
                 </div>

                <table id="maintable" class="table table-bordered table-striped table-responsive">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Author</th>
                      <th>Title</th>
                      <th width="75px">Image</th>
                      <th>Tags</th>
                      <th width="75px">Date</th>
                      <th>Status</th>
                      <th width="50px">Option</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php while($data = $get_all_announcement_data->fetch(PDO::FETCH_ASSOC)){ ?>
                      <tr>
                        <td><?php echo  $data['id']; ?></td>
                        <td><?php echo $data['author'];?></td>
                        <td><?php echo $data['title'];?></td>
                        <td><img src=<?php echo '../postimage/'.$data['image'];?> class="img-fluid" ></td>
                        <td><?php echo $data['tag'];?></td>
                        <td><?php echo $data['postdate'];?></td>
                        <td><?php if($data['status'] == 'draft'){$btnpublish = ''; $btnunpublish = 'hidden';}else{$btnpublish = 'hidden'; $btnunpublish = '';}?>
                           <button class="btn col-12  btn-success publish btn-sm" data-id="<?php echo $data["id"]; ?>" data-placement="top" title="Publish Post" <?php echo $btnpublish ?> ><i class="fa fa-file"></i>  DRAFT</button>
                           <button class="btn col-12 btn-outline-success unpublish btn-sm" data-id="<?php echo $data["id"]; ?>" data-placement="top" title="Unpublish Post" <?php echo $btnunpublish ?> ><i class="fa fa-check"></i>  PUBLISHED</button>
                        </td>
                        <td>
                           <a href="update_announcement?post=<?php echo $data["id"]; ?>" class="btn btn-outline-success btn-sm" data-placement="top" title="Edit Post"><i class='fa fa-pencil'></i></a>       
                           <a href="view_post?post=<?php echo $data["id"]; ?>" class="btn btn-outline-success btn-sm" data-placement="top" title="View Post"><i class='fa fa-eye'></i></a>    
                           <button class="btn btn-outline-danger delete btn-sm" data-id="<?php echo $data["id"]; ?>" data-placement="top" title="Delete Post"><i class="fa fa-trash-o"></i></button>
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

 <?php include('view_all_posts_modal.php')?>
 <?php include('footer.php')?>

</div><!-- /.wrapper -->

<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<script src="../plugins/jquery/jquery.js"></script>
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
      "order": [[ 6, "asc" ]]
    });
</script>

<script>
 $(function(){
  $(document).on('click', '.edit', function(e) {
    e.preventDefault();
    $('#edit').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.delete', function(e){
    e.preventDefault();
    $('#delete').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.publish', function(e){
    e.preventDefault();
    $('#publish').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });

  $(document).on('click', '.unpublish', function(e){
    e.preventDefault();
    $('#unpublish').modal('show');
    var id = $(this).data('id');
    getRow(id);
  });
  
});

function getRow(id){

  $.ajax({

    type: 'POST',
    url: 'announcement_fetch.php',
    data: {id:id},
    dataType: 'json',
    success: function(data){
      
      $('.objid').val(data.id);
      $('#objid').val(data.id);
      $('.image').val(data.image);
      $('.edit_status').val(data.status).html(data.status);
      $('.edit_title').val(data.title).html(data.title);
      $('.edit_author').val(data.author).html(data.author);
      $('.edit_image').attr('src',data.image1);
      
    }
  });
};

 </script>
</body>
</html>
