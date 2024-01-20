<?php
    include "db_functions.php";
    $con = database_connection();
    $id=$_REQUEST['sid'];
    $query1 = "DELETE from loginstudents where student='$id';";
    //$query = "delete from student where sid='$id'";
    echo $query."<br>";
    $resul1 = mysqli_query($con, $query1) or die("Query failed: " . mysqli_error($con));

    //$result = mysqli_query($con, $query) or die("Query failed: " . mysqli_error($con));

    mysqli_close($con);
    header("Location: student-view-page.php"); 
    exit();
?>