<?php
    include("db_functions.php");
    $admin_name = $_COOKIE['teacher_name']; // contains tname for logged in admin
    $admin_tid = $_COOKIE['teacher_tid']; // contains tid for logged in admin

    $id=$_REQUEST['xid'];
    $con = admin_database_connection();
    $query = "SELECT * from exam where xid='".$id."'"; 
    $result = mysqli_query($con, $query) or die ( mysqli_error($con));
    $row = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sub-styles.css">
    <title>Update Exam Page</title>
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
            <p class="positioning-body" ><a href="exams-view-page.php">Back</a> 
            | <a href="exam-insert-page.php">Insert New Record</a> 
            | <a href="logout.php">Logout</a></p>
            <h1>Update Record</h1>
            <?php
                $status="";
                if(isset($_POST['new']) && $_POST['new']==1 )
                {
                    try{
                    mysqli_begin_transaction($con);
                    $id=$_POST['xid'];
                    $xlabel =$_POST['xlabel'];
                    $fromdate = date("Y-m-d",strtotime($_POST['fromdate']));
                    $todate = date("Y-m-d",strtotime($_POST['todate']));
                    $duration =$_POST['duration'];
                    $update = "UPDATE exam SET xid='$id', xlabel='$xlabel', fromdate='$fromdate', todate='$todate', duration='$duration' WHERE xid='$id'";
                    mysqli_query($con, $update) or die(mysqli_error($con));
                    $status = "Record Updated Successfully. </br></br>
                    <a href='exams-view-page.php'>View Updated Exam</a>";
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

                <form name="form" method="post" action="./edit-exam.php"> 
                <input type="hidden" name="new" value="1" />
                <p><input type="text" name="xid" placeholder="Enter ID" required value="<?php echo $row['xid'];?>"/></p>
                <p><input type="text" name="xlabel" placeholder="Enter Name" required value="<?php echo $row['xlabel'];?>"/></p>
                <div class="form-group mb-3">
                    <label for="">fromdate</label>
                    <input type="date" name="fromdate" class="form-control" />
                    <label for="">todate</label>
                    <input type="date" name="todate" class="form-control" />
                    <input type="text" name="duration" value="<?php echo $row['duration'];?>" placeholder="Correction duration" class="form-control" />
                </div>
                <p><input name="submit" type="submit" value="Update" /></p>
                </form>
            </div>
        </div>
    </body>
</html>