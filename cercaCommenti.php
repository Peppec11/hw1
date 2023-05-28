<?php
 require_once 'auth.php';

 if(!$userid=checkAuth())exit;

 header('Content-Type: application/json');

 $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

 $userid=mysqli_real_escape_string($conn,$userid);



 $query="SELECT * from comment ORDER BY id DESC ";

 $res=mysqli_query($conn,$query) or die(mysqli_error($conn));

 $comment=array();

 while($entry=mysqli_fetch_assoc($res)){
    $comment[]= array('commentid'=> $entry['id'], 'userid'=>$entry['userid'], 'content'=> json_decode($entry['content']));


 }

 echo json_encode($comment);

 exit;

 ?>