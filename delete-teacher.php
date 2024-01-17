<?php
    include "db_functions.php";
    $con = database_connection();
    $id=$_REQUEST['tid'];
    $query = "delete from teacher where tid = '$id'";
    echo $query."<br>";
    $result = mysqli_query($con, $query) or die("Query failed: " . mysqli_error($con));
    mysqli_close($con);
    header("Location: teacher-view-page.php"); 
    exit();
?>