<?php
include("db_functions.php");
$con = database_connection();
$admin_name = $_COOKIE['teacher_name']; // contains tname for logged in admin
$admin_tid = $_COOKIE['teacher_tid']; // contains tid for logged in admin


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sub-styles.css">
    <title>View Courses</title>
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
|               <a href="course-insert-page.php">Insert New Student</a> 
|               <a href="admin-home-page.php">Back</a>
                <a href="logout.php">Logout</a>
            </p>
            <h2>Courses Records</h2>
        <table width="100%" border="1" style="border-collapse:collapse;">
        <thead>
        <tr>
        <th><strong>Course code</strong></th>
        <th><strong>Course name</strong></th>
        <th><strong>Teacher name</strong></th>
        <th><strong>Hours</strong></th>
        <th><strong>Credits</strong></th>
        <th><strong>Edit</strong></th>
        <th><strong>Delete</strong></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $sel_query="Select * from course ORDER BY cid asc;";
            $result = mysqli_query($con,$sel_query);
            while($row = mysqli_fetch_assoc($result)) { ?>
                <tr><td align="center"><?php echo $row["cid"] ?></td>
                <td align="center"><?php echo $row["cname"]; ?></td>
                <td align="center"><?php echo $row["teacher"]; ?></td>
                <td align="center"><?php echo $row["hours"]; ?></td>
                <td align="center"><?php echo $row["credits"]; ?></td>
                <td align="center">
                <a href="edit-course.php?cid=<?php echo $row["cid"]; ?>">Edit</a>
                </td>
                <td align="center">
                <a href="delete-course.php?cid=<?php echo $row["cid"]; ?>">Delete</a>
                </td>
                </tr>
            <?php } 
            mysqli_close($con);?>
        </tbody>
        </table>
        </div>
    </body>
</html>