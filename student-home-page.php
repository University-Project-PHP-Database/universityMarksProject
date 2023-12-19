<?php
    include "db_functions.php";
    $stud_name = $_COOKIE['student_name']; // contains sname for logged in student
    $stud_sid = $_COOKIE['student_sid']; // contains sid for logged in student
    // we have to access database <markregister> to get marks in courses for this student 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="student-styles.css">
    <title>Student's Page</title>
</head>

<body>
    <header>
        <div>
            <nav>
                <div id="setting"><a href="./student-setting.php"><img src="./setting-icon.png" width="25"
                            height="25"></a></div>
                <div id="student-name">Hello, <?=$stud_name?></div>
            </nav>
        </div>

    </header>
    <main>
        <div class="positioning">
            <a href="./student-marks.php">View marks</a>
            <a href="./student-courses.php">View Courses</a>
        </div>
        
    </main>
    <footer>

    </footer>
</body>

</html>