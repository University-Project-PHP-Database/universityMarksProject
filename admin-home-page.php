<?php
    include "db_functions.php";
    $admin_name = $_COOKIE['teacher_name']; // contains tname for logged in admin
    $admin_tid = $_COOKIE['teacher_tid']; // contains tid for logged in admin

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
                    <a class="setting-icon" href="./student-setting.php"><img src="./setting-icon.png" width="27" height="27"></a>
                    <img class="profile-icon" src="./profile-icon.png" width="40" height="40">
                </div>

                <div class="person-name">Hello, <?=$admin_name?>
                    <p><a href="student-view-page.php">View Student</a> 
    |               <a href="teacher-view-page.php">View Teacher</a> 
    |               <a href="courses-view-page.php">View Courses</a> 
    |               <a href="exams-view-page.php">View Exams</a> 
    |               <a href="logout.php">Logout</a></p>
                </div>
            </nav>
        </div>

    </header>
    <main>

        
    </main>
    <footer>

    </footer>
</body>

</html>