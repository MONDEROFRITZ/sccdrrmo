<?php



include('../config/db_config.php');

if (isset($_POST['edit'])) {
//     echo "<pre>";
//     print_r($_POST);
// echo "</pre>";

$finalcount = null;
$finalcount1 = null;
$finaltype = null;
$id = null;


// $office = $_POST['office'];
$user_id = $_SESSION['id'];

//select all data type
// $get_all_type_sql = "SELECT `health_status` FROM `tbl_PUM` WHERE health_status = :status";
// $get_all_type_data = $con->prepare($get_all_type_sql);
// $get_all_type_data->execute([':status'=> $health_status]);  
//  while ($result = $get_all_type_data->fetch(PDO::FETCH_ASSOC)) {
//  $finaltype =  $result['health_status'];
 
// }

$get_noofdocs_sql= "SELECT COUNT(`id`) as total FROM `tbl_individual` ";
$get_noofdocs_data = $con->prepare($get_noofdocs_sql);
$get_noofdocs_data->execute();
$get_noofdocs_data->setFetchMode(PDO::FETCH_ASSOC);
while ($result1 = $get_noofdocs_data->fetch(PDO::FETCH_ASSOC)) {    
  $finalcount =  $result1['total'];
}

    $finalcount1 = $finalcount + 1;
    $id = 'SC'.'-'.$finalcount1;
    echo $id;



die();

}


