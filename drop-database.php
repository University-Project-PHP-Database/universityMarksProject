<?php
    $host = "localhost:3306";
    $user = 'root';
    $pass = '';
    $db = 'univdb';
    $connect = mysqli_connect($host, $user, $pass) or die("Connection Error");
    $drop_db = "DROP DATABASE univdb";
    $connect->query($drop_db);
    mysqli_close($connect);
?>