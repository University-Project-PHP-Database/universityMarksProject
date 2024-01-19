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
    <title>Insert Student Page</title>
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
<p class="positioning-body">
                <a href="admin-home-page.php">Back</a>
|               <a href="logout.php">Logout</a></p>

<?php
if(isset($_POST['Search']))
{
	?>
<?php
	
	$tabQuery = array();
	$addWhere=0;

	if(isset($_POST['sid']) && !empty($_POST['sid']))
	{
		$tabQuery[]="sid=".$_POST['sid']."";
		$addWhere++;
	}
	if(isset($_POST['sname']) && !empty($_POST['sname']))
	{
		$tabQuery[]="sname='".$_POST['sname']."'";
		$addWhere++;
	}
	
	$query="SELECT * FROM student";
	if($addWhere>0) 
	{
		$query .= " WHERE ".$tabQuery[0];
		for($i=1;$i<count($tabQuery);$i++)
		{
			$query .= " AND ".$tabQuery[$i];
		}
		/*
		foreach($tabQuery as $val)
		{
			$query .= $val." AND ";
		}
		echo "<hr> before substring: ".$query."<hr>";
		$query = substr($query, 0, -4);
		*/
	}
	$result = mysqli_query($con,$query) or die( mysqli_error($con));

    $row = mysqli_fetch_assoc($result);

    if($row){
		?>
		<table border="1">
		<tr>
			<td>ID</td>
			<td>Name</td>
			<td>Address Of Birth</td>
			<td>Phone</td>
			<td>Acquired Courses</td>
			<td>Obtained Courses</td>
		</tr>
		<tr><?php
    echo "<td>{$row['sid']}</td>
          <td>{$row['sname']}</td>
          <td>{$row['bdate']}</td>
          <td>{$row['phone']}</td>
          <td>{$row['acquiredCredits']}</td>
          <td>{$row['obtainedCourses']}</td>";
?>

		</tr>
	</table>
<?php
    }else{
        echo "<h2>There is no record for this student!</h2>";
    }

}else{
?>

<h2>Search Student (ID or Name)</h2>
<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">

	ID:<input type="text" name="sid" placeholder="Enter ID" /></td>
	Name:<input type="text" name="sname"  placeholder="Enter name" /></td>
	<input type="submit" name="Search" /></td>
	
</form>
<?php } mysqli_close($con); ?>
</main>
</body>
</html>