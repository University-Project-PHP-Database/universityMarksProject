<?php
    include "db_functions.php";
    $teacher_name = $_COOKIE['teacher_name']; // contains sname for logged in student
    $teacher_tid = $_COOKIE['teacher_tid']; // contains sid for logged in student
    // we have to access database <markregister> to get marks in courses for this student 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="student-styles.css">
    <title>Student's Page</title>
</head>

<body>
    <header>
        <div>
            <nav>
                <div id="icons">
                    <a class="setting-icon" href="./student-setting.php"><img src="./setting-icon.png" width="27" height="27"></a>
                    <img class="profile-icon" src="./profile-icon.png" width="40" height="40">
                </div>

                <div id="student-name">Hello, <?=$teacher_name?></div>
            </nav>
        </div>

    </header>
    <main>

        
    </main>
    <footer>

    </footer>
</body>

</html>