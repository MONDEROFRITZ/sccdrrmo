<?php

if($_SERVER["REQUEST_METHOD"] == "POST"){
	require 'db-config.php';
	updateUser();
}else{
	echo "Oops! We're sorry! You do not have access to this option!";
}

function updateUser(){
    global $con;

    $userID = $_GET['loggedInUser'];

    if($_POST['image'] != null){
        $image = base64_decode($_POST['image']);
   }else{
        $image = "";
   }

   $firstname      = $_POST['firstname'];
   $middlename     = $_POST['middlename'];
   $lastname       = $_POST['lastname'];
   $birthdate      = $_POST['birthdate'];
   $mobileNumber   = $_POST['mobileNumber'];
   $address        = $_POST['address'];

   $id = md5(time() . rand());

   if($image != null){
       // $filename = ""
        $path = "../userimage/$id.jpg";
        $filename = $id.".jpg";
        $file = fopen($path, 'wb');
   
        $isWritten = fwrite($file, $image);
        fclose($file);
   }

  if ($image != null){ 
   $update_users_sql = "UPDATE tbl_users SET
       
        firstname           = :fname,
        middlename          = :mname,
        lastname            = :lname,
        birthdate           = :bday,
        mobileno            = :mobileno,
        address             = :address,
        photo               = :photo
        WHERE id            = :userid";
        

    $users_data = $con->prepare($update_users_sql);
    $users_data->execute([
       
        ':fname'            => $firstname,
        ':mname'            => $middlename,
        ':lname'            => $lastname,
        ':bday'             => $birthdate,
        ':mobileno'         => $mobileNumber,
        ':photo'            => $filename,
        ':address'          => $address,
        ':userid'           => $userID
        
        ]);
        
    }else{
        $update_users_sql = "UPDATE tbl_users SET
       
        firstname           = :fname,
        middlename          = :mname,
        lastname            = :lname,
        birthdate           = :bday,
        mobileno            = :mobileno,
        address             = :address
        WHERE id            = :userid";
        

    $users_data = $con->prepare($update_users_sql);
    $users_data->execute([
       
        ':fname'            => $firstname,
        ':mname'            => $middlename,
        ':lname'            => $lastname,
        ':bday'             => $birthdate,
        ':mobileno'         => $mobileNumber,
        ':address'          => $address,
        ':userid'           => $userID
        
        ]);

    }
}

echo "Account Updated!";


?>