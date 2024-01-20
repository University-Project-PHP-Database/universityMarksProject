<?php
    include "db_functions.php";
    $teacher_name = $_COOKIE['teacher_name']; // contains tname for logged in doctor
    $teacher_tid = $_COOKIE['teacher_tid']; // contains tid for logged in doctor

    $status="";
    if(isset($_POST['student']) && isset($_POST['course']) && isset($_POST['exam']) && isset($_POST['mark'])){
            $student = $_POST['student'];
            $course =$_POST['course'];
            $exam = $_POST['exam'];
            $mark = $_POST['mark'];

            upload_marks($student, $course, $exam, $mark);
            $status = "New Record Inserted Successfully.
            </br></br><a href='./teacher-marks-page.php'>View Inserted Marks</a>";
    
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sub-styles.css">
    <title>Insert Mark Page</title>
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
        <div >
        <p class="positioning-body"><a href="teacher-home-page.php">Home</a> 
        | <a href="./teacher-marks-page.php">View Records</a> 
        | <a href="logout.php">Logout</a></p>
            <div>
                <h1 >Insert New Mark</h1>
                <h2 style="color:#00FF00;"><?php echo $status; ?></h2>

                <form name="form" method="post" action=""> 
                <input type="hidden" name="new" value="1" />
                Student ID:<input type="text" name="student" placeholder="Enter studentID" required />
                Course ID:<input type="text" name="course" placeholder="Enter courseID" required />  
                Exam ID:<input type="text" name="exam" placeholder="Enter examID"  />
                Mark:<input type="text" name="mark" placeholder="Enter mark"  />
                <p><input name="submit" type="submit" value="Update" /></p>
                </form>
            </div>
        </div>
    </body>

</html>