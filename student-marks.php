<?php
    include "db_functions.php";
    $stud_name = $_COOKIE['student_name']; // contains sname for logged in student
    $stud_sid = $_COOKIE['student_sid']; // contains sid for logged in student
    // we have to access database <markregister> to get marks in courses for this student 
    $result = get_marks_ccode($stud_sid);
    $averages = view_avg($stud_sid);
    $status = get_status($stud_sid);

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
            <a href="./student-home-page.php">Home</a>
            <a href="./student-marks.php">View marks</a>
            <a href="./student-courses.php">View Courses</a>
            <a href="logout.php">Logout</a>

        </div>
        <h2>Marks</h2>
        <?php
            if($status == 3){
        ?>
        <table border=1>
            <tr>
                <th>Course</th>
                <th>Exam</th>
                <th>Marks</th>
            </tr>
            <?php
            
                while($row = @mysqli_fetch_array($result)) {
                    echo "
                        <tr>
                            <td>{$row['course']}</td>
                            <td>{$row['xlabel']}</td>
                            <td>{$row['mark']}</td>
                    
                    ";
                }
            
            
            ?>
        </table>
        <table border=1>
            <tr>
                <th>xlabel</th>
                <th>Average</th>
            </tr>
        <?php

            foreach ($averages as $xlabel => $avg_mark) {
                echo "<tr>
                    <td>$xlabel</td>
                    <td> $avg_mark</td>
                    </tr>";
            }

        ?>
        </table>
        <?php }elseif($status == 0){
            echo "The Doctor did not start correction yet.";
        }elseif($status == 1){
            echo "The Doctor started the correction phase.";
        }elseif($status == 2){
            echo "The Doctor has finished the correction phase, and the marks are under validation";
        }
        ?>
    </main>
    <footer>

    </footer>
</body>

</html>