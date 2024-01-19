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
    <title>View Teacher Page</title>
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
        <div>
            <p class="positioning-body">
                <a href="teacher-insert-page.php">Insert New Teacher</a>
|               <a href="teacher-search.php">Search</a>  
|               <a href="admin-home-page.php">Back</a>
|               <a href="logout.php">Logout</a></p>

            <h2>View Records</h2></p>
        <table width="100%" border="1" style="border-collapse:collapse;">
        <thead>
        <tr>
        <th><strong>Teachcer ID</strong></th>
        <th><strong>Name</strong></th>
        <th><strong>Address</strong></th>
        <th><strong>Phone number</strong></th>
        <th><strong>Speciality</strong></th>
        <th><strong>Edit</strong></th>
        <th><strong>Delete</strong></th>
        </tr>
        </thead>
        <tbody>
        <?php
            $sel_query="Select * from teacher ORDER BY tid asc;";
            $result = mysqli_query($con,$sel_query);
            while($row = mysqli_fetch_assoc($result)) { ?>
                <tr><td align="center"><?php echo $row["tid"] ?></td>
                <td align="center"><?php echo $row["tname"]; ?></td>
                <td align="center"><?php echo $row["address"]; ?></td>
                <td align="center"><?php echo $row["phone"]; ?></td>
                <td align="center"><?php echo $row["speciality"]; ?></td>
                <td align="center">
                <a href="edit-teacher.php?tid=<?php echo $row["tid"]; ?>">Edit</a>
                </td>
                <td align="center">
                <a href="delete-teacher.php?tid=<?php echo $row["tid"]; ?>">Delete</a>
                </td>
                </tr>
            <?php } 
            mysqli_close($con);?>
        </tbody>
        </table>
        </div>
        </main>
    </body>
</html>