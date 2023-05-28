<?php
header('Content-Type: application/json');

film();

function film(){
    $apikey="c265e9a3";
    $query=urldecode($_GET["q"]);
    $url='http://www.omdbapi.com/?apikey='.$apikey.'&t='.$query;

   
    $ch=curl_init();
    curl_setopt($ch, CURLOPT_URL,$url);
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
    $res=curl_exec($ch);
    curl_close($ch);

    echo $res;
}

?>