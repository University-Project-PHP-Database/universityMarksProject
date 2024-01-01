<?php
    $host = "localhost:3306";
    $user = 'root';
    $pass = '';
    $db = 'univdb';
    $connect = mysqli_connect($host, $user, $pass) or die("Connection Error");
    $drop_db = "DROP DATABASE univdb";
    $connect->query($drop_db) or die("Could not drop DB");
    mysqli_close($connect);
    echo "<h1>Done! Database has been dropped successfully</h1>"
?>