<?php
include("db_functions.php");
$con = admin_database_connection();
$admin_name = $_COOKIE['teacher_name']; // contains tname for logged in admin
$admin_tid = $_COOKIE['teacher_tid']; // contains tid for logged in admin

$status = "";
if(isset($_POST['xid']) && isset($_POST['xlabel']) && isset($_POST['fromdate']) && isset($_POST['todate']) && isset($_POST['duration'])){
    $id = $_POST['xid'];
    $xlabel =$_POST['xlabel'];
    $fromdate = $_POST['fromdate'];
    $todate = $_POST['todate'];
    $duration = $_POST['duration'];
    $ins_query="INSERT into exam
    (`xid`,`xlabel`,`fromdate`,`todate`,`stat`,`duration`) values
    ('$id','$xlabel','$fromdate','$todate',0,'$duration')";
    $result = mysqli_query($con, $ins_query);
    // $ins_exam = "INSERT INTO markregister (`student`, `course`,`exam`)
    // SELECT student, course, course FROM studentcourses WHERE course='$id'";
    // $result2 =mysqli_query($con, $ins_exam);
    if (!$result /*|| !$result2*/) {
        die("Error: " . mysqli_error($con));
    }
    $status = "New Record Inserted Successfully.
    </br></br><a href='./exams-view-page.php'>View Inserted Exams</a>";
    mysqli_close($con);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sub-styles.css">
    <title>Insert Exam Page</title>
</head>

<body>
    <header>
        <div>
            <nav>
                <div id="icons">
                    <img class="profile-icon" src="./profile-icon.png" width="40" height="40">
                </div>

                <div class="person-name">Hello, <?=$admin_name?></div>
            </nav>
        </div>
    </header>
    <body>
        <div >
        <p class="positioning-body"><a href="admin-home-page.php">Home</a> 
        | <a href="./exams-view-page.php">View Records</a> 
        | <a href="logout.php">Logout</a></p>
            <div>
                <h1 >Insert New Exam</h1>
                <form name="form" method="post" action=""> 
                <input type="hidden" name="new" value="1" />
                <p><input type="text" name="xid" placeholder="Enter ID" required /></p>
                <p><input type="text" name="xlabel" placeholder="Enter label" required /></p>
                <div class="form-group mb-3">
                    <label for="">fromdate</label>
                    <input type="date" name="fromdate" class="form-control" />
                    <label for="">todate</label>
                    <input type="date" name="todate" class="form-control" />
                    <input type="text" name="duration" placeholder="Correction duration" class="form-control" />
                </div>
                <p><input name="submit" type="submit" value="Submit" /></p>
                </form>
                <p style="color:#FF0000;"><?php echo $status; ?></p>
            </div>
        </div>
    </body>
</html>