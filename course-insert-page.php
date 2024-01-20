<?php
include("db_functions.php");
$con = admin_database_connection();
$admin_name = $_COOKIE['teacher_name']; // contains tname for logged in admin
$admin_tid = $_COOKIE['teacher_tid']; // contains tid for logged in admin

$status = "";
if(isset($_POST['cid']) && isset($_POST['cname']) && isset($_POST['teacher']) && isset($_POST['hours']) && isset($_POST['credits']) && isset($_POST['obtainedBy'])){
    $id = $_POST['cid'];
    $name =$_POST['cname'];
    $teacher = $_POST['teacher'];
    $hours = $_POST['hours'];
    $credits = $_POST['credits'];
    $obtainedBy = $_POST['obtainedBy'];
    $ins_query="insert into course
    (`cid`,`teacher`,`cname`,`ccode`,`hours`, `credits`, `obtainedBy`) values
    ('$id','$teacher','$name','$id','$hours', '$credits', '$obtainedBy')";
    $result = mysqli_query($con, $ins_query);
    if (!$result) {
        die("Error: " . mysqli_error($con));
    }
    $status = "New Record Inserted Successfully.
    </br></br><a href='./courses-view-page.php'>View Inserted Courses</a>";
    mysqli_close($con);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sub-styles.css">
    <title>Insert Course Page</title>
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
        | <a href="./courses-view-page.php">View Records</a> 
        | <a href="logout.php">Logout</a></p>
            <div>
                <h1 >Insert New Course</h1>
                <form name="form" method="post" action=""> 
                <input type="hidden" name="new" value="1" />
                <p><input type="text" name="cid" placeholder="Enter course ID" required /></p>
                <p><input type="text" name="cname" placeholder="Enter Course Name" required /></p>
                <p><input type="text" name="teacher" placeholder="Enter TeacherID" required /></p>
                <p><input type="text" name="hours" placeholder="Enter Hours needed" required /></p>
                <p><input type="text" name="credits" placeholder="Enter Credits amount" required /></p>
                <p><input type="text" name="obtainedBy" placeholder="Enter ObtainedBy" required /></p>
                <p><input name="submit" type="submit" value="Submit" /></p>
                </form>
                <p style="color:#FF0000;"><?php echo $status; ?></p>
            </div>
        </div>
    </body>
</html>