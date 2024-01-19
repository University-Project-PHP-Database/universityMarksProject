<?php
include("db_functions.php");
$con = database_connection();
$admin_name = $_COOKIE['teacher_name']; // contains tname for logged in admin
$admin_tid = $_COOKIE['teacher_tid']; // contains tid for logged in admin

$status = "";
if(isset($_POST['tid']) && isset($_POST['tname'])  && isset($_POST['address']) && isset($_POST['phone'])&& isset($_POST['speciality']) && isset($_POST['email']) && isset($_POST['password'])){
    $id = $_POST['tid'];
    $name =$_POST['tname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $speciality = $_POST['speciality'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $type = $_POST['type'];
    $ins_query="insert into teacher (`tid`,`tname`,`address`,`phone`, `speciality`) values
    ('$id','$name','$address','$phone','$speciality')";
    mysqli_query($con,$ins_query)
    or die(mysqli_error($con));
    $ins_query2="insert into logindoctors (`doctor`, `email`, `password`,`type`) values
    ('$id', '$email', '$password','$type')";
    mysqli_query($con,$ins_query2)
    or die(mysqli_error($con));
    $status = "New Teacher Inserted Successfully.
    </br></br><a href='teacher-view-page.php'>View Inserted teacher</a>";
    mysqli_close($con);
}
?>

<!DOCTYPE html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sub-styles.css">
    <title>Insert Teacher Page</title>
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
    <body>
        <div >
        <p class="positioning-body"><a href="admin-home-page.php">Home</a> 
        | <a href="teacher-view-page.php">View Records</a> 
        | <a href="logout.php">Logout</a></p>
            <div>
                <h1>Insert New teacher</h1>
                <form name="form" method="post" action=""> 
                <input type="hidden" name="new" value="1" />
                <p><input type="text" name="tid" placeholder="Enter ID" required /></p>
                <p><input type="text" name="tname" placeholder="Enter Name" required /></p>
                <p><input type="text" name="address" placeholder="Enter Address" required /></p>
                <p><input type="text" name="phone" placeholder="Enter Phone Number" required /></p>
                <p><input type="text" name="speciality" placeholder="Enter Speciality" required /></p>
                <p><input type="text" name="email" placeholder="Enter Email" required /></p>
                <p><input type="text" name="password" placeholder="Enter Password" required /></p>
                <p><input type="text" name="type" placeholder="Enter Type(A - D)" required /></p>
                <p><input name="submit" type="submit" value="Submit" /></p>
                </form>
                <p style="color:#FF0000;"><?php echo $status; ?></p>
            </div>
        </div>
    </body>
</html>