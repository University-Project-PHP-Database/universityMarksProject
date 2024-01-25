<?php
    include "db_functions.php";
    $admin_name = $_COOKIE['teacher_name']; // contains tname for logged in admin
    $admin_tid = $_COOKIE['teacher_tid']; // contains tid for logged in admin
    $result = view_marks_admin();


    if(isset($_POST['submit'])) {
        compensation_fun();
    }
   
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sub-styles.css">
    <title>Admin Marks View</title>
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
    <main>
            <p class="positioning-body"><a href="student-view-page.php">View Student</a> 
    |       <a href="teacher-view-page.php">View Teacher</a> 
    |       <a href="courses-view-page.php">View Courses</a> 
    |       <a href="exams-view-page.php">View Exams</a>
    |       <a href="./admin-marks-view.php">View Marks</a>
    |       <a href="logout.php">Logout</a></p>
        </div>
        <table border=1>
            <tr>
                <th>course</th>
                <th>studentID</th>
                <th>mark</th>
                <th>cname</th>
                <th>Edit</th>

            </tr>
        <?php

            while ($row = mysqli_fetch_assoc($result)) {
                    $course = $row['cid'];
                    $student = $row['student'];
                    $mark = $row['mark'];
                    $cname = $row['cname'];

            echo "<tr>
                    <td>$course</td>
                    <td>$student</td>
                    <td>$mark</td>
                    <td>$cname</td>"?>
                    <td><a href="./admin-edit-mark.php?student=<?php echo $row['student'] ?>&course=<?php echo $row['cid'] ?>&mark=<?php echo $row['mark'] ?>">Edit</a></td>
                    
                </tr>
                
            <?php } ?>
            
        
        </table>
        
        <br>

        <form action="admin-marks-view.php" method="post">
            <button type="submit" style="margin-left :8em; background-color: lightblue;">Press here to make compensation</button> 
        </form>
       
           
    </main>
    <footer>

    </footer>
</body>

</html>