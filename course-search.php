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

<?php
if(isset($_POST['Search']))
{
	?><p class="positioning-body">
                <a href="course-search.php">Back</a>
|               <a href="logout.php">Logout</a></p>
<?php
	
	$tabQuery = array();
	$addWhere=0;

	if(isset($_POST['cid']) && !empty($_POST['cid']))
	{
		$tabQuery[]="cid='".$_POST['cid']."'";
		$addWhere++;
	}
	if(isset($_POST['cname']) && !empty($_POST['cname']))
	{
		$tabQuery[]="cname='".$_POST['cname']."'";
		$addWhere++;
	}
	
	$query="SELECT * FROM course";
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
        echo "ID:" . $row['cid'] . "</br>";
        echo "Course Code:" . $row['ccode']. "</br>";
        echo "Course Name:" . $row['cname']. "</br>";
        echo "Teacher ID:" . $row['teacher']. "</br>";
        echo "Hours:" . $row['hours']. "</br>";
		echo "Credits:" . $row['credits']. "</br>";
		echo "Obtained BY:" . $row['obtainedBy']. "</br>";

    }else{
        echo "there is no record for this course!";
    }

}else{
?>

<p class="positioning-body">
                <a href="courses-view-page.php">Back</a>
|               <a href="logout.php">Logout</a></p>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
<fieldset>
	<legend>Search Student</legend>

<table border="0" >
	<tr>
		<td>ID</td>
		<td><input type="text" name="cid"  /></td>
	</tr>
	<tr>
		<td>Name</td>
		<td><input type="text" name="cname"  /></td>
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