<?php
    include "db_functions.php";
    $con = database_connection();
    $id=$_REQUEST['sid'];
    $query = "delete from student where sid='$id'";
    echo $query."<br>";
    $result = mysqli_query($con, $query) or die("Query failed: " . mysqli_error($con));
    mysqli_close($con);
    header("Location: student-view-page.php"); 
    exit();
?>