<?php
    include "db_functions.php";
    $teacher_name = $_COOKIE['teacher_name']; // contains tname for logged in doctor
    $teacher_tid = $_COOKIE['teacher_tid']; // contains tid for logged in doctor
    $result = view_marks($teacher_tid);
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
            <p class="positioning-body"><a href="teacher-home-page.php">Back</a> 
    |       <a href="teacher-marks-page.php">View Marks</a> 
    |       <a href="./upload-marks.php">Upload Marks</a> 
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
                    <td><a href="edit-mark.php?student=<?php echo $row['student'] ?>&course=<?php echo $row['cid'] ?>&mark=<?php echo $row['mark'] ?>">Edit</a></td>
                    
                </tr>
                
            <?php } ?>
            
        
        </table>
        
    </main>
    <footer>

    </footer>
</body>

</html>