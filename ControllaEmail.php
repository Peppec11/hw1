<?php
  
    require_once 'dbconfig.php';
    
  
    if (!isset($_GET["q"])) {
        echo "Non dovresti essere qui";
        exit;
    }

    
    header('Content-Type: application/json');
    
 
    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

   
    $email = mysqli_real_escape_string($conn, $_GET["q"]);

 
    $query = "SELECT email FROM users WHERE email = '$email'";


    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));

  
    echo json_encode(array('exists' => $res));

   
    mysqli_close($conn);
?>