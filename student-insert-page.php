<?php
include("db_functions.php");
$con = database_connection();
$status = "";
if(isset($_POST['sid']) && isset($_POST['name']) && isset($_POST['dateofbirth']) && isset($_POST['address']) && isset($_POST['phone'])){
    $id = $_POST['sid'];
    $name =$_POST['name'];
    $trn_date = date("Y-m-d ",strtotime($_POST['dateofbirth']));
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $ins_query="insert into student
    (`sid`,`sname`,`bdate`,`address`,`phone`)values
    ('$id','$name','$trn_date','$address','$phone')";
    mysqli_query($con,$ins_query)
    or die(mysqli_error($con));
    $status = "New Record Inserted Successfully.
    </br></br><a href='student-view-page.php'>View Inserted student</a>";
    mysqli_close($con);
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Insert New student</title>
    </head>
    <body>
        <div class="form">
        <p><a href="admin-home-page.php">home</a> 
        | <a href="student-view-page.php.php">View Records</a> 
        | <a href="logout.php">Logout</a></p>
            <div>
                <h1>Insert New student</h1>
                <form name="form" method="post" action=""> 
                <input type="hidden" name="new" value="1" />
                <p><input type="text" name="sid" placeholder="Enter ID" required /></p>
                <p><input type="text" name="name" placeholder="Enter Name" required /></p>
                <div class="form-group mb-3">
                    <label for="">Date of Birth</label>
                    <input type="date" name="dateofbirth" class="form-control" />
                </div>
                <p><input type="text" name="address" placeholder="Enter Address" required /></p>
                <p><input type="text" name="phone" placeholder="Enter Phone Number" required /></p>
                <p><input name="submit" type="submit" value="Submit" /></p>
                </form>
                <p style="color:#FF0000;"><?php echo $status; ?></p>
            </div>
        </div>
    </body>
</html>