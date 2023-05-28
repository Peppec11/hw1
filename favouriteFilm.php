<?php
 require_once 'auth.php';

 if(!$userid=checkAuth())exit;

 header('Content-Type: application/json');

 $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

 $userid=mysqli_real_escape_string($conn,$userid);

 $next=isset($_GET['from']) ?'AND film.id < '.mysqli_real_escape_string($conn,$_GET['from']).' ' : ' ';

 $query="SELECT userid AS userid, id AS filmid, content As content from film where userid=$userid ORDER BY filmid DESC LIMIT 10";

 $res=mysqli_query($conn,$query) or die(mysqli_error($conn));

 $films=array();

 while($entry=mysqli_fetch_assoc($res)){
    $films[]= array('filmid'=> $entry['filmid'], 'userid'=>$entry['userid'], 'content'=> json_decode($entry['content']));


 }

 echo json_encode($films);

 exit;

 ?>