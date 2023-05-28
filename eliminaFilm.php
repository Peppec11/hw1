<?php
require_once 'auth.php';

if(!$userid=checkAuth())exit;

header('Content-Type: application/json');

$conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

$userid=mysqli_real_escape_string($conn,$userid);

$film=urldecode($_GET["q"]) ;



$query="DELETE FROM film WHERE userid='$userid' AND id='$film' ";

$res=mysqli_query($conn,$query) or die(mysqli_error($conn));

echo json_encode("CANZONE ELIMINATA") ;

exit;





?>