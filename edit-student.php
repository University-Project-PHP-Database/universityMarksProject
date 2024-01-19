<?php
include("db_functions.php");
$admin_name = $_COOKIE['teacher_name']; // contains tname for logged in admin
$admin_tid = $_COOKIE['teacher_tid']; // contains tid for logged in admin

$id=$_REQUEST['sid'];
$con = database_connection();
$query = "SELECT * from student where sid='".$id."'"; 
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
        <div class="form">
            <p class="positioning-body" ><a href="student-view-page.php">Back</a> 
            | <a href="student-insert-page.php">Insert New Record</a> 
            | <a href="logout.php">Logout</a></p>
            <h1>Update Record</h1>
            <?php
                $status="";
                if(isset($_POST['new']) && $_POST['new']==1)
                {
                    $id=$_POST['sid'];
                    $name =$_POST['sname'];
                    $bdate = date("Y-m-d",strtotime($_POST['dateofbirth']));
                    $address =$_POST['address'];
                    $phone = $_POST['phone'];
                    $update="update student set sid=$id ,sname='$name',bdate='$bdate', address='$address',
                    phone='$phone' where sid=$id";
                    mysqli_query($con, $update) or die(mysqli_error($con));
                    $status = "Record Updated Successfully. </br></br>
                    <a href='student-view-page.php'>View Updated Student</a>";
                }else {
            ?>
            <div>
                <form name="form" method="post" action=""> 
                <input type="hidden" name="new" value="1" />
                <p><input type="text" name="sid" placeholder="Enter ID" required value="<?php echo $row['sid'];?>"/></p>
                <p><input type="text" name="sname" placeholder="Enter Name" required value="<?php echo $row['sname'];?>"/></p>
                <div class="form-group mb-3">
                    <label for="">Date of Birth</label>
                    <input type="date" name="dateofbirth" class="form-control" />
                </div>
                <p><input type="text" name="address" placeholder="Enter Address" required value="<?php echo $row['address'];?>"/></p>
                <p><input type="text" name="phone" placeholder="Enter Phone Number" required value="<?php echo $row['phone'];?>"/></p>
                <p><input name="submit" type="submit" value="Update" /></p>
                </form>
                <p style="color:#FF0000;"><?php echo $status; ?></p>
                <?php } mysqli_close($con); ?>
            </div>
        </div>
    </body>
</html>