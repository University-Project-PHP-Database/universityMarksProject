<?php
    include("db_functions.php");
    $con = database_connection();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="sub-styles.css">
    <title>Search Page</title>
</head>
<body>
<p class="positioning-body">
                <a href="admin-home-page.php">Back</a>
|               <a href="logout.php">Logout</a></p>

<?php
if(isset($_POST['Search']))
{
	?><p class="positioning-body">
                <a href="student-search.php">Back</a>
|               <a href="logout.php">Logout</a></p>
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
        echo "ID:" . $row['sid'] . "</br>";
        echo "Name:" . $row['sname']. "</br>";
        echo "Date of birth:" . $row['bdate']. "</br>";
        echo "Address:" . $row['address']. "</br>";
        echo "Phone:" . $row['phone']. "</br>";
		echo "Acquired Credits:" . $row['acquiredCredits']. "</br>";
		echo "Obtained Courses:" . $row['obtainedCourses']. "</br>";

    }else{
        echo "there is no record for this student!";
    }

}else{
?>

<p class="positioning-body">
                <a href="student-view-page.php">Back</a>
|               <a href="logout.php">Logout</a></p>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
<fieldset>
	<legend>Search Student</legend>

<table border="0" >
	<tr>
		<td>ID</td>
		<td><input type="text" name="sid"  /></td>
	</tr>
	<tr>
		<td>Name</td>
		<td><input type="text" name="sname"  /></td>
	</tr>
<tr>
		<td colspan="2">&nbsp;&nbsp;<input type="submit" name="Search" /></td>
	</tr>
</table>
</fieldset>
</form>
<?php } mysqli_close($con); ?>
</body>
</html>