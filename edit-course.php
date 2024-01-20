<?php
include("db_functions.php");
$admin_name = $_COOKIE['teacher_name']; // contains tname for logged in admin
$admin_tid = $_COOKIE['teacher_tid']; // contains tid for logged in admin

$id=$_REQUEST['cid'];
$con = admin_database_connection();
$query = "SELECT * from course where cid ='".$id."'"; 
$result = mysqli_query($con, $query) or die ( mysqli_error($con));
$row = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sub-styles.css">
    <title>Update Course Page</title>
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
        <div>
            <p class="positioning-body"><a href="courses-view-page.php">Back</a> 
            | <a href="courses-insert-page.php">Insert New Record</a> 
            | <a href="admin-home-page.php">Home</a>
            <a href="logout.php">Logout</a>
            </p>
            <h1>Update Record</h1>
            <?php
                $status="";

                if(isset($_POST['new']) && $_POST['new']==1)
                {
                    try {
                    mysqli_begin_transaction($con);
                    $id=$_POST['cid'];
                    $teacher = $_POST['teacher'];
                    $code =$_POST['ccode'];
                    $name =$_POST['cname'];
                    $hours = $_POST['hours'];
                    $credits = $_POST['credits'];
                    $update="UPDATE course set cid='$id' , teacher='$teacher', ccode='$code', cname='$name', hours=$hours, credits=$credits WHERE cid='$id';";
                    mysqli_query($con, $update) or die(mysqli_error($con));
                    $status = "Record Updated Successfully. </br></br>
                    <a href='courses-view-page.php'>View Updated Course</a>";
                    mysqli_commit($con);
                    $row = " ";

                    mysqli_close($con);
                } catch (Exception $e){
                    mysqli_rollback($con);
                    $status = 'Error ' . $e->getMessage() . "<br />";
                    mysqli_close($con);
                 }
                }
            ?>
            <div>
                <h2 style="color:#00FF00;"><?php echo $status; ?></h2>

                <form name="form" method="post" action="./edit-course.php"> 
                <input type="hidden" name="new" value="1" />
                
                <p><input type="text" name="cid" placeholder="Enter Course ID" required value="<?php echo $row['cid'];?>"/></p>
                <p><input type="text" name="teacher" placeholder="Enter Teacher ID" required value="<?php echo $row['teacher'];?>"/></p>
                <p><input type="text" name="ccode" placeholder="Enter Course Code" required value="<?php echo $row['ccode'];?>"/></p>
                <p><input type="text" name="cname" placeholder="Enter Course Name" required value="<?php echo $row['cname'];?>"/></p>
                <p><input type="text" name="hours" placeholder="Enter Hours" required value="<?php echo $row['hours'];?>"/></p>
                <p><input type="text" name="credits" placeholder="Enter Credits" required value="<?php echo $row['credits'];?>"/></p>
                <p><input name="submit" type="submit" value="Update" /></p>
                </form>


            </div>
        </div>
    </body>
</html>