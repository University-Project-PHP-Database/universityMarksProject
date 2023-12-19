
<?php
    include "db_functions.php";

    
    if(isset($_POST['submit'])) {
        // open connection to database
        $connect = database_connection();

        // take email password from form \\
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check login info if correct or not \\
        $sql = "SELECT * FROM loginstudents WHERE email = '$email' AND password = '$password'";
        $result = $connect->query($sql);

        // Then there is entry with that user in table `loginstudents`\\
        if(mysqli_num_rows($result) > 0) {
            // Get student name that have this email\\
            $get_name_st = "SELECT sname, sid FROM Student, LoginStudents WHERE loginstudents.student = student.sid AND `email` = '$email'";
            $result = $connect->query($get_name_st);
            mysqli_close($connect);

            $row = mysqli_fetch_array($result);
// set cookie for sname
            $name = "student_name";
            $value = $row[0];
            $time = time() + (60*60*24);
            setcookie($name, $value, $time);
// set cookie for sid (much important) = primary key
            $sid = "student_sid";
            $value = $row[1];
            $time = time() + (60*60*24);
            setcookie($sid, $value, $time);
            header('Location: student-home-page.php');
        } else {
            echo "Invalid email or password";
        }
        mysqli_close($connect);

        // Save email in cookie \\
        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Document</title>
</head>
<body>
    <form action="login-as-student.php" method="post">
        Email: <input name="email" type="text"> <br>
        Password: <input name="password" type="password"><br>
        <input type="submit" name="submit">
    </form>
</body>
</html>