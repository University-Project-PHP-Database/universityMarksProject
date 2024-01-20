<?php
    include "db_functions.php";
    $con = database_connection();
    $id=$_REQUEST['xid'];
    $query = "DELETE from exam where xid='$id';";
    echo $query."<br>";

    $result = mysqli_query($con, $query) or die("Query failed: " . mysqli_error($con));

    mysqli_close($con);
    header("Location: exam-view-page.php"); 
    exit();
?>