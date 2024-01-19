<?php
    include "db_functions.php";
    $con = database_connection();
    $stud_name = $_COOKIE['student_name']; // contains sname for logged in student
    $stud_sid = $_COOKIE['student_sid']; // contains sid for logged in student
    // we have to access database <markregister> to get marks in courses for this student 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sub-styles.css">
    <title>Student's Page</title>
</head>

<body>
    <header>
        <div>
            <nav>
                <div id="icons">
                    <img class="profile-icon" src="./profile-icon.png" width="40" height="40">
                </div>

                <div class="person-name">Hello, <?=$stud_name?></div>
            </nav>
        </div>

    </header>
    <main>
        <div class="positioning-body">
            <a href="./student-marks.php">View marks</a>
            <a href="./student-courses.php">View Courses</a>
        </div>
        <table width="100%" border="1" style="border-collapse:collapse;">
        <thead>
        <tr>
        <th><strong>Course code</strong></th>
        <th><strong>Course name</strong></th>
        <th><strong>Hours</strong></th>
        <th><strong>Credits</strong></th>

        </tr>
        </thead>
        <tbody>
        <?php
            $sel_query="SELECT cid, cname, hours, credits from studentcourses, course WHERE studentcourses.student='$stud_sid' AND studentcourses.course=course.cid";
            $result = mysqli_query($con,$sel_query);
            while($row = mysqli_fetch_assoc($result) ) { 
                ?>
                <tr><td align="center"><?php echo $row["cid"] ?></td>
                <td align="center"><?php echo $row["cname"]; ?></td>
                <td align="center"><?php echo $row["hours"]; ?></td>
                <td align="center"><?php echo $row["credits"]; ?></td>

                </tr>
            <?php } 
            mysqli_close($con);?>
        </tbody>
        </table>
    </main>
    <footer>

    </footer>
</body>

</html>