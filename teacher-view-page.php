<?php
include("db_functions.php");
$con = database_connection();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
            <title>Teacher Records</title>
    </head>
    <body>
        <div class="form">
            <p><a href="teacher-insert-page.php">Insert New Teacher</a> 
|               <a href="admin-home-page.php">Back</a></p>
            <h2>View Records</h2>
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
    </body>
</html>