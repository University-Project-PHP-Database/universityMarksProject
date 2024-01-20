<?php
    include "db_functions.php";
    $teacher_name = $_COOKIE['teacher_name']; // contains tname for logged in doctor
    $teacher_tid = $_COOKIE['teacher_tid']; // contains tid for logged in doctor
    $result = view_students($teacher_tid); // view students
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sub-styles.css">
    <title>Teacher's Page</title>
</head>

<body>
    <header>
        <div>
            <nav>
                <div id="icons">
                    <img class="profile-icon" src="./profile-icon.png" width="40" height="40">
                </div>
                <div class="person-name">Hello, <?=$teacher_name?></div>
            </nav>
        </div>

    </header>
    <main>
        </div>
            <p class="positioning-body"><a href="teacher-student-page.php">View Students</a> 
    |       <a href="teacher-marks-page.php">View Marks</a> 
    |       <a href="teacher-courses-page.php">View Courses</a> 
    |       <a href="logout.php">Logout</a></p>
        </div>
        <table border=1>
            <tr>
                <th>Course code</th>
                <th>Couse name</th>
                <th>StudentID</th>
                <th>Student name</th>
            </tr>
        <?php

            while ($row = mysqli_fetch_assoc($result)) {
                    $course = $row['cid'];
                    $student = $row['student'];
                    $cname = $row['cname'];
                    $stud_name = $row['sname'];
            echo "<tr>
                    <td>$course</td>
                    <td>$cname</td>
                    <td>$student</td>
                    <td>$stud_name</td>
                </tr>";
            }
        ?>
        </table>
        
    </main>
    <footer>

    </footer>
</body>

</html>