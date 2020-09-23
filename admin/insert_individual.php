<?php


include('../config/db_config.php');
//include('import_pdf.php');

$alert_msg = '';
$alert_msg1 = '';

if (isset($_POST['insert_purchase'])) {

    $pr_control_no = date("mdGis");
    $time = $_POST['time'];
    $dept_code = $_POST['dept'];


    $section = $_POST['section'];
    $saino = $_POST['saino'];
    $saidate = $_POST['saidate'];

    $requested = $_POST['requested'];
    $prepared = $_POST['prepared'];
    $approved = $_POST['approvedby'];

    $purpose = $_POST['purpose'];
    $status = 'Active';


    $insert_pr_sql = "INSERT INTO pr_info SET 
        pr_info_control_no          = :controlno,
        pr_info_time                = :prtime,

        pr_info_sai_no              = :saino,
        pr_info_sai_date            = :saidate,
        pr_info_dept                = :dept,
        pr_info_section             = :section,
        pr_info_reqby               = :reqby,
        pr_info_prepby              = :prepby,
        pr_info_approvedby          = :appby,
        pr_info_purpose             = :purpose,
        pr_info_status              = :stat
       ";

    $pr_data = $con->prepare($insert_pr_sql);
    $pr_data->execute([

        ':controlno'                => $pr_control_no,
        ':prtime'                   => $time,
        ':saino'                    => $saino,
        ':saidate'                  => $saidate,
        ':dept'                     => $dept_code,
        ':section'                  => $section,
        ':reqby'                    => $requested,
        ':prepby'                   => $prepared,
        ':appby'                    => $approved,
        ':purpose'                  => $purpose,
        ':stat'                     => $status

    ]);

    $alert_msg .= ' 
    <div class="new-alert new-alert-success alert-dismissible">
        <i class="icon fa fa-success"></i>
        Data Inserted
    </div>  
      ';
      
    header("location: add_pr_item.php?controlno=$pr_control_no");
}
