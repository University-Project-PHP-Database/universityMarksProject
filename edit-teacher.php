<?php
include("db_functions.php");
$admin_name = $_COOKIE['teacher_name']; // contains tname for logged in admin
$admin_tid = $_COOKIE['teacher_tid']; // contains tid for logged in admin
$update_record = "Update Record";
$id=$_REQUEST['tid'];
$con = admin_database_connection();
$query = "SELECT * from teacher where tid = '".$id."'"; 
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
            <p class="positioning-body"><a href="teacher-view-page.php">Back</a> 
            | <a href="teacher-insert-page.php">Insert New Record</a> 
            | <a href="logout.php">Logout</a></p>
            <h1>Update Record</h1>
            <?php
                $status="";
                if(isset($_POST['new']) && $_POST['new']==1)
                {
                try {
                    mysqli_begin_transaction($con);
                    $id=$_POST['tid'];
                    $name =$_POST['tname'];
                    $address =$_POST['address'];
                    $phone = $_POST['phone'];
                    $speciality = $_POST['speciality'];
                    $update="update teacher set tid='$id' ,tname='$name', address='$address',
                    phone='$phone', speciality='$speciality' where tid='$id'";
                    mysqli_query($con, $update) or die(mysqli_error($con));
                    $status = "Record Updated Successfully. </br></br>
                    <a href='teacher-view-page.php'>View Updated teacher</a>";
                    mysqli_commit($con);
                    $row = "";

                    mysqli_close($con);
                }catch (Exception $e){
                    mysqli_rollback($con);
                    $status = 'Error ' . $e->getMessage() . "<br />";
                    mysqli_close($con);
                 }
                }

            ?>
            <div>
            <h2 style="color:#00FF00;"><?php echo $status; ?></h2>

                <form name="form" method="post" action=""> 
                <input type="hidden" name="new" value="1" />
                <p><input type="text" name="tid" placeholder="Enter ID" required value="<?php echo $row['tid'];?>"/></p>
                <p><input type="text" name="tname" placeholder="Enter Name" required value="<?php echo $row['tname'];?>"/></p>
                <p><input type="text" name="address" placeholder="Enter Address" required value="<?php echo $row['address'];?>"/></p>
                <p><input type="text" name="phone" placeholder="Enter Phone Number" required value="<?php echo $row['phone'];?>"/></p>
                <p><input type="text" name="speciality" placeholder="Enter Phone Number" required value="<?php echo $row['speciality'];?>"/></p>
                <p><input name="submit" type="submit" value="Update" /></p>
                </form>
            </div>
        </div>
    </body>
</html>