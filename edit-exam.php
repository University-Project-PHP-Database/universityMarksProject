<?php
    include("db_functions.php");
    $admin_name = $_COOKIE['teacher_name']; // contains tname for logged in admin
    $admin_tid = $_COOKIE['teacher_tid']; // contains tid for logged in admin

    $id=$_REQUEST['xid'];
    $con = database_connection();
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
                if(isset($_POST['new']) && $_POST['new']==1)
                {
                    $id=$_POST['xid'];
                    $name =$_POST['xlabel'];
                    $fromdate = date("Y-m-d",strtotime($_POST['fromdate']));
                    $todate = date("Y-m-d",strtotime($_POST['todate']));
                    $duration =$_POST['duration'];
                    $update = "UPDATE exam SET xid='$id', xlabel='$name', fromdate='$fromdate', todate='$todate', duration='$duration' WHERE xid='$id'";
                    mysqli_query($con, $update) or die(mysqli_error($con));
                    $status = "Record Updated Successfully. </br></br>
                    <a href='exams-view-page.php'>View Updated Exam</a>";
                }else {
            ?>
            <div>
                <form name="form" method="post" action=""> 
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
                <p style="color:#FF0000;"><?php echo $status; ?></p>
                <?php } mysqli_close($con); ?>
            </div>
        </div>
    </body>
</html>