<?php
include("db_functions.php");
$admin_name = $_COOKIE['teacher_name']; // contains tname for logged in admin
$admin_tid = $_COOKIE['teacher_tid']; // contains tid for logged in admin

$id=$_REQUEST['student'];
$course = $_REQUEST['course'];
$con = admin_database_connection();
$query = "SELECT * from markregister where student='".$id."' and course='$course' "; 
$result = mysqli_query($con, $query) or die ( mysqli_error($con));
$row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sub-styles.css">
    <title>Update Student Page</title>
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
    <body>
        <div>
            <p class="positioning-body" ><a href="student-view-page.php">Back</a> 
            | <a href="teacher-marks-page.php">Insert New Record</a> 
            | <a href="logout.php">Logout</a></p>
            <h1>Update Record</h1>

            <?php
                $status="";
                if(isset($_POST['new']) && $_POST['new']==1)
                
                {
                try{
                    mysqli_begin_transaction($con);
                    $id= $_POST['sid'];
                    $mark =$_POST['mark'];
                    $update="update markregister set mark=$mark where student='$id'";
                    mysqli_query($con, $update) or die(mysqli_error($con));
                    $status = "Record Updated Successfully. </br></br>
                    <a href='teacher-marks-page.php'>View Updated mark</a>";
                    mysqli_commit($con);
                    mysqli_close($con);
                } catch (Exception $e){
                    mysqli_rollback($con);
                    $status = 'Error ' . $e->getMessage() . "<br />";
                    $row = "";
                    mysqli_close($con);
                }
            }
            ?>
            <div>
            <h2 style="color:#00FF00;"><?php echo $status; ?></h2>

                <form name="form" method="post" action=""> 
                <input type="hidden" name="new" value="1" />
                <p><input type="label" name="sid"  value="<?php echo $row['student'];?>"/></p>
                <p><input type="text" name="mark" placeholder="Enter mark" required value="<?php echo $row['mark'];?>"/></p>
                <p><input name="submit" type="submit" value="Update" /></p>
                </form>
            </div>
        </div>
    </body>
</html>