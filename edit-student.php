<?php
include("db_functions.php");
$id=$_REQUEST['sid'];
$con = database_connection();
$query = "SELECT * from student where sid='".$id."'"; 
$result = mysqli_query($con, $query) or die ( mysqli_error($con));
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Update Student</title>
    </head>
    <body>
        <div class="form">
            <p><a href="student-view-page.php">Back</a> 
            | <a href="student-insert-page.php">Insert New Record</a> 
            | <a href="logout.php">Logout</a></p>
            <h1>Update Record</h1>
            <?php
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
                <?php } mysqli_close($con); ?>
            </div>
        </div>
    </body>
</html>