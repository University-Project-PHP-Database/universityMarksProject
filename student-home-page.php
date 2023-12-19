<?php
    include "db_functions.php";
    $stud_name = $_COOKIE['student_name']; // contains sname for logged in student
    $stud_sid = $_COOKIE['student_sid']; // contains sid for logged in student
    // we have to access database <markregister> to get marks in courses for this student 
    $result = get_marks_ccode($stud_sid);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="student-styles.css">
    <title>Doctor's Page</title>
</head>

<body>
    <header>
        <div>
            <nav>
                <div id="setting"><a href="./student-setting.php"><img src="./setting-icon.png" width="25"
                            height="25"></a></div>
                <div id="student-name">Hello, <?=$stud_name?></div>
            </nav>
        </div>

    </header>
    <main>
        <table border=1>
            <tr>
                <th>Course</th>
                <th>Exam</th>
                <th>Marks</th>
            </tr>
            <?php
            
                while($row = @mysqli_fetch_array($result)) {
                    echo "
                        <tr>
                            <td>{$row['course']}</td>
                            <td>{$row['exam']}</td>
                            <td>{$row['mark']}</td>
                    
                    ";
                }
            
            
            ?>
        </table>
    </main>
    <footer>

    </footer>
</body>

</html>