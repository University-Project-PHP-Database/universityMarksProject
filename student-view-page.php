<?php
include("db_functions.php");
$con = database_connection();
$admin_name = $_COOKIE['teacher_name']; // contains tname for logged in admin
$admin_tid = $_COOKIE['teacher_tid']; // contains tid for logged in admin

?>
<!DOCTYPE html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sub-styles.css">
    <title>Student's Page</title>
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
        <div class="form">
            <p class="positioning-body"><a href="student-insert-page.php">Insert New Student</a> 
|               <a href="admin-home-page.php">Back</a>
                <a href="logout.php">Logout</a>
            </p>
            <h2>Student Records</h2>
        <table width="100%" border="1" style="border-collapse:collapse;">
        <thead>
        <tr>
        <th><strong>Student ID</strong></th>
        <th><strong>Name</strong></th>
        <th><strong>Birth date</strong></th>
        <th><strong>Address</strong></th>
        <th><strong>Phone number</strong></th>
        <th><strong>Edit</strong></th>
        <th><strong>Delete</strong></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $sel_query="Select * from student ORDER BY sid asc;";
            $result = mysqli_query($con,$sel_query);
            while($row = mysqli_fetch_assoc($result)) { ?>
                <tr><td align="center"><?php echo $row["sid"] ?></td>
                <td align="center"><?php echo $row["sname"]; ?></td>
                <td align="center"><?php echo $row["bdate"]; ?></td>
                <td align="center"><?php echo $row["address"]; ?></td>
                <td align="center"><?php echo $row["phone"]; ?></td>
                <td align="center">
                <a href="edit-student.php?sid=<?php echo $row["sid"]; ?>">Edit</a>
                </td>
                <td align="center">
                <a href="delete-student.php?sid=<?php echo $row["sid"]; ?>">Delete</a>
                </td>
                </tr>
            <?php } 
            mysqli_close($con);?>
        </tbody>
        </table>
        </div>
    </body>
</html>