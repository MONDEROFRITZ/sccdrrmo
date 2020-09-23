<?php

    header('Content-Type: application/json; charset=utf-8');

     if($_SERVER["REQUEST_METHOD"] == "GET"){
        require 'db-config.php';
        showAllPost();
     }else{
         echo "Oops! We're sorry! You do not have access to this option!";
     }


function showAllPost(){
        global $con;
        global $appUrl;
        $newsUrl = "http://34.92.117.58/sccdrrmo/postimage/";

        $listOfPosts = array();
        $status = "published";

//fetch user from database
$get_announcement_sql = "SELECT * FROM tbl_announcement where status = :status ORDER BY id DESC";
$get_data = $con->prepare($get_announcement_sql);
$get_data->execute([':status' => $status]);
while ($result = $get_data->fetch(PDO::FETCH_ASSOC)) {

    $listOfPosts[$result['id']] = [
        'id'        => $result['id'],
        'title'     => str_replace(['<p>', '</p>', '<b>','</b>',','],"",$result['title']),
        'author'    => $result['author'],
        'postDate'  => $result['postdate'],
        'image'     => $newsUrl . $result['image'],
        'content'   => $result['content'],
        'updatedOn' => $result['updated_on'],
        'status'    => $result['status'],
        'tag'       => $result['tag']
        
    ];
}

//     $userInfo = [
//         'userInfo' => array(
//                 'UserID' => $userID
//         )
//   ];

      


        $data = [];
		foreach ($listOfPosts as $info) {
           
         
        $data[] = $info;
		 }
         echo json_encode(array('newsfeed'=>$data));
         //echo $data;
   echo count($listOfPosts);
        }

?>



