<?php
    include "db_functions.php";
    $teacher_name = $_COOKIE['teacher_name']; // contains tname for logged in doctor
    $teacher_tid = $_COOKIE['teacher_tid']; // contains tid for logged in doctor

    $status="";
    if(isset($_POST['examid']) && isset($_POST['status'])){
            $examid = $_POST['examid'];
            $status =$_POST['status'];

            update_status($examid, $status);
            $status = "Status Updated Successfully.
            </br></br><a href='./teacher-marks-page.php'>View Inserted Marks</a>";
    
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sub-styles.css">
    <title>Update status Page</title>
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
        | <a href="logout.php">Logout</a></p>
            <div>
                <h1 >Update Exam Status</h1>
                <h2 style="color:#00FF00;"><?php echo $status; ?></h2>

                <form name="form" method="post" action=""> 
                <input type="hidden" name="new" value="1" />
                Exam ID:<input type="text" name="examid" placeholder="Enter examID" require  />
                Status:<input type="text" name="status" placeholder="Enter status" require />
                Note: 1:I started correction. / 2:I finished correction.
                <p><input name="submit" type="submit" value="Update" /></p>
                </form>
            </div>
        </div>
    </body>

</html>