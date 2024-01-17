<?php
include("db_functions.php");
$id=$_REQUEST['tid'];
$con = database_connection();
$query = "SELECT * from teacher where tid = '".$id."'"; 
$result = mysqli_query($con, $query) or die ( mysqli_error($con));
$row = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Update Teacher</title>
    </head>
    <body>
        <div class="form">
            <p><a href="teacher-view-page.php">Back</a> 
            | <a href="teacher-insert-page.php">Insert New Record</a> 
            | <a href="logout.php">Logout</a></p>
            <h1>Update Record</h1>
            <?php
                $status="";
                if(isset($_POST['new']) && $_POST['new']==1)
                {
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
                }else {
            ?>
            <div>
                <form name="form" method="post" action=""> 
                <input type="hidden" name="new" value="1" />
                <p><input type="text" name="tid" placeholder="Enter ID" required value="<?php echo $row['tid'];?>"/></p>
                <p><input type="text" name="tname" placeholder="Enter Name" required value="<?php echo $row['tname'];?>"/></p>
                <p><input type="text" name="address" placeholder="Enter Address" required value="<?php echo $row['address'];?>"/></p>
                <p><input type="text" name="phone" placeholder="Enter Phone Number" required value="<?php echo $row['phone'];?>"/></p>
                <p><input type="text" name="speciality" placeholder="Enter Phone Number" required value="<?php echo $row['speciality'];?>"/></p>
                <p><input name="submit" type="submit" value="Update" /></p>
                </form>
                <p style="color:#FF0000;"><?php echo $status; ?></p>
                <?php } mysqli_close($con); ?>
            </div>
        </div>
    </body>
</html>