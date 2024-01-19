<?php
    include "db_functions.php";
    $con = database_connection();
    $id=$_REQUEST['cid'];
    $query = "delete from course where cid='$id'";
    echo $query."<br>";
    $result = mysqli_query($con, $query) or die("Query failed: " . mysqli_error($con));
    mysqli_close($con);
    header("Location: courses-view-page.php"); 
    exit();
?>
