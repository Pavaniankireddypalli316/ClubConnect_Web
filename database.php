<?php 
define('URL', 'http://localhost/appweb');

 $host = 'localhost';
 $root = 'root';
 $pass = '';
 $data_base = 'clubevents';

 $conn = new mysqli($host, $root, $pass, $data_base);

 if($conn == false){
    die('Connection interupted!.. Try Again'.$conn->connect_error);
 }
 

?> 