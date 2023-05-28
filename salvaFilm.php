<?php
require_once 'auth.php';
if (!$userid = checkAuth()) exit;

film();

function film()
{
    global $dbconfig, $userid;

    $conn = mysqli_connect($dbconfig['host'], $dbconfig['user'], $dbconfig['password'], $dbconfig['name']);

    $userid = mysqli_real_escape_string($conn, $userid);
    $titolo = mysqli_real_escape_string($conn, $_POST['titolo']);
    $poster = mysqli_real_escape_string($conn, $_POST['poster']);
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    $query = "SELECT * FROM film WHERE userid = '$userid' AND id = '$id'";
    $res = mysqli_query($conn, $query) or die(mysqli_error($conn));
    # if song is already present, do nothing
    if (mysqli_num_rows($res) > 0) {
        echo json_encode(array('ok'=>true));
        exit;
    }
    
    $query = "INSERT INTO film(id, userid, content) VALUES('$id','$userid', JSON_OBJECT('id', '$id', 'title', '$titolo', 'poster', '$poster'))";
    error_log($query);
    # Se corretta, ritorna un JSON con {ok: true}
    if (mysqli_query($conn, $query) or die(mysqli_error($conn))) {
        echo json_encode(array('ok'=>true));
        exit;
    }

    mysqli_close($conn);
    echo json_encode(array('ok'=>false));
}
?>