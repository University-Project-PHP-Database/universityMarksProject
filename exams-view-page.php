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
    <title>View Exams</title>
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
|               <a href="exam-insert-page.php">Insert New Exam</a> 
|                <a href="exam-search.php">Search</a> 
|               <a href="admin-home-page.php">Back</a>
                <a href="logout.php">Logout</a>
            </p>
            <h2>Exams Records</h2>
        <table width="100%" border="1" style="border-collapse:collapse;">
        <thead>
        <tr>
        <th><strong>Exam code</strong></th>
        <th><strong>xLabel</strong></th>
        <th><strong>from date</strong></th>
        <th><strong>to date</strong></th>
        <th><strong>deadline</strong></th>
        <th><strong>Edit</strong></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $sel_query="Select * from exam ORDER BY xid asc;";
            $result = mysqli_query($con,$sel_query);
            while($row = mysqli_fetch_assoc($result)) { ?>
                <tr><td align="center"><?php echo $row["xid"] ?></td>
                <td align="center"><?php echo $row["xlabel"]; ?></td>
                <td align="center"><?php echo $row["fromdate"]; ?></td>
                <td align="center"><?php echo $row["todate"]; ?></td>
                <td align="center"><?php echo $row["deadline"]; ?></td>
                <td align="center">
                <a href="edit-exam.php?xid=<?php echo $row["xid"]; ?>">Edit</a>
                </td>
                <!-- <td align="center">
                <a href="delete-exam.php?xid=<?php echo $row["xid"]; ?>">Delete</a>
                </td> -->
                </tr>
            <?php } 
            mysqli_close($con);?>
        </tbody>
        </table>
        </div>
    </body>
</html>