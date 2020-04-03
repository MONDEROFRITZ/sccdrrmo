<?php

include ('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';

if (isset($_POST['insert_announcement'])) {

    $post_title= $_POST['title'];
    $post_date = date('Y-m-d');
    $post_content = $_POST['content'];
    $post_status = 'draft';
    $post_author = $db_fullname;
    $post_tag = $_POST['tags'];

    //if file input is empty
    if ($_FILES["myFiles"]["error"] == 4){     

    $insert_sql = "INSERT INTO tbl_announcement SET 

        title       = :title,
        author      = :author,
        postdate    = :postdate,
        image       = :image,
        content     = :content,
        status      = :status,
        tag         = :tag
        
        ";

    $sql_data = $con->prepare($insert_sql);
    $sql_data->execute([
 
        ':title'      => $post_title,
        ':author'     => $post_author,
        ':postdate'   => $post_date,
        ':image'      => 'sancarlos.png',
        ':content'    => $post_content,
        ':status'     => $post_status,
        ':tag'        => $post_tag
        
        ]);

    $alert_msg .= ' 
          <div class="alert alert-success alert-dismissible">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
              <i class="icon fa fa-check"></i>
              Announcement posted successfully. It will be published after admin approves it!
          </div>     
      ';

      $btnSave = 'hidden';
      $btnNew = '';
    
     }else{

    $currentDir = getcwd();
    $uploadDirectory = "../postimage/";

    $errors = [];

    $fileExtensions = ['png','jpg','jpeg'];

    $fileName = $_FILES['myFiles']['name'];
    $fileSize = $_FILES['myFiles']['size'];
    $fileTmpName = $_FILES['myFiles']['tmp_name'];
    $fileType = $_FILES['myFiles']['type'];
    $target_file = $uploadDirectory . basename($_FILES['myFiles']['name']);
    $fileExtension = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    // $fileExtension = strtolower(end(explode('.',$fileName)));
    $uploadPath = $uploadDirectory . basename($fileName);

    if (!in_array($fileExtension, $fileExtensions)) {
        $errors[] = "This file extension is not allowed.";
    }
    if (empty($errors)) {
        $dipUpload = move_uploaded_file($fileTmpName, $uploadPath);


        if ($dipUpload) {
            $alert_msg1 .= ' 
       <div class="table-bordered">
           <i class="icon fa fa-success"></i>
           File has been uploaded
       </div>     
   ';
            // $fname = $mname = $lname = $contact_number = $email = $uname = $upass = '';


        } else {
            $alert_msg1 .= ' 
       <div class="alert alert-warning alert-dismissible"">
           <i class="icon fa fa-warning"></i>
           An Error Occured;
       </div>     
   ';
            // $fname = $mname = $lname = $contact_number = $email = $uname = $upass = '';

            $btnStatus = 'disabled';
            $btnNew = 'disabled';
        }
    } else {
        foreach ($errors as $error) {
            echo $error . "These are the errors" . "\n";

        }
    }
   
    $insert_sql = "INSERT INTO tbl_announcement SET 

        title       = :title,
        author      = :author,
        postdate    = :postdate,
        image       = :image,
        content     = :content,
        status      = :status,
        tag         = :tag
        
        ";

    $sql_data = $con->prepare($insert_sql);
    $sql_data->execute([
 
        ':title'      => $post_title,
        ':author'     => $post_author,
        ':postdate'   => $post_date,
        ':image'      => $fileName,
        ':content'    => $post_content,
        ':status'     => $post_status,
        ':tag'        => $post_tag
        
        ]);

    $alert_msg .= ' 
        <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
         <i class="icon fa fa-check"></i>
         Announcement posted successfully. It will be published after admin approves it!
        </div>     
    ';

    $btnSave = 'hidden';
    $btnNew = '';
   
    }
}


?>