<?php


if($_SERVER["REQUEST_METHOD"] == "POST"){
	require 'db-config.php';
	addPost();
}else{
	echo "Oops! We're sorry! You do not have access to this option!";
}



// session_start();
// $user_id = $_SESSION['id'];

     // echo "<pre>";
     // print_r($_POST);
     // echo "</pre>";

// $content = $_POST['Content_Type'];
function addPost(){

global $con;
date_default_timezone_set('Asia/Manila');

$path = '';
$type = $_POST['Type'];
$severity = $_POST['topicSeverity'];
$title = $_POST['topicTitle'];

if($_POST['topicImage'] != null){
     $image = base64_decode($_POST['topicImage']);
}else{
     $image = "";
}

$latitude= $_POST['latitude'];
$longitude = $_POST['longitude'];
$locationAddress = $_POST['topicLocationAddress'];
$postedBy = $_POST['topicPostedBy'];
$mobileno = $_POST['mobileNo'];
$created = $_POST['topicDateAndTimePosted'];
$date = date('Y-m-d');
$time = date('h:i:s');
$user_id = $_POST['userID'];
$victims = $_POST['victims'];

$id = md5(time() . rand());

if($image != null){
    // $filename = ""
     $path = "images/$id.jpg";
     $filename = $id.".jpg";
     $file = fopen($path, 'wb');

     $isWritten = fwrite($file, $image);
     fclose($file);
}

$insert_users_sql = "INSERT INTO tbl_incident SET
type                = :type,
severity            = :severity,
topic               = :topic,
image               = :path,
date                = :date,
time                = :time,
latitude            = :latitude,
longitude           = :longitude,
location_address    = :locationAddress,
victims             = :victims,
reported_by         = :reportedBy,
mobileno            = :mobileno,
createdat           = :createdAt,
userid              = :userid,
remarks             = 'NEW REPORT'";

$users_data = $con->prepare($insert_users_sql);
$users_data->execute([
':type'             => $type,
':severity'         => $severity,
':topic'            => $title,
':path'             => $filename,
':date'             => $date,
':time'             => $time,
':latitude'         => $latitude,
':longitude'        => $longitude,
':locationAddress'  => $locationAddress,
':victims'          => $victims,
':reportedBy'       => $postedBy,
':userid'           => $user_id,
':mobileno'         => $mobileno,
':createdAt'        => $created

]);
}

echo "Incident Reported! We will contact you as soon as possible. Thank you!";


?>




