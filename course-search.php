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
		?>
		<table border="1">
		<tr>
			<td>ID</td>
			<td>Course code</td>
			<td>Course name</td>
			<td>TeacherID</td>
			<td>Hours</td>
			<td>Credits</td>
			<td>Obtained By</td>
		</tr>
		<tr><?php
    echo "<td>{$row['cid']}</td>
          <td>{$row['ccode']}</td>
          <td>{$row['cname']}</td>
          <td>{$row['teacher']}</td>
          <td>{$row['hours']}</td>
          <td>{$row['credits']}</td>
          <td>{$row['obtainedBy']}</td>";

    }else{
        echo "<h2>There is no record for this course!</h2>";
    }

}else{
?>

<p class="positioning-body">
                <a href="courses-view-page.php">Back</a>
|               <a href="logout.php">Logout</a></p>

<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
	ID:<input type="text" name="cid"  />
	Name:<input type="text" name="cname"  />
	<input type="submit" name="Search" />

</form>
<?php } mysqli_close($con); ?>
</main>
</body>
</html>