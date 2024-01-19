<!-- Check login info if correct or not -->


<?php
    include "db_functions.php";

    
    if(isset($_POST['submit'])) {
        // open connection to database
        $connect = database_connection();

        // take email password from form \\
        $email = $_POST['email'];
        $password = $_POST['password'];

        // Check login info if correct or not \\
        $sql = "SELECT * FROM logindoctors WHERE email = '$email' AND password = '$password'";
        $result = $connect->query($sql);

        // Then there is entry with that user in table `loginstudents`\\
        if(mysqli_num_rows($result) > 0) {
            // Get student name that have this email\\
            $get_name_dr = "SELECT tname, tid, type FROM teacher, logindoctors WHERE logindoctors.doctor = teacher.tid AND `email` = '$email'";
            $result = $connect->query($get_name_dr);
            mysqli_close($connect);

            $row = mysqli_fetch_array($result);
// set cookie for tname
            $name = "teacher_name";
            $value = $row[0];
            $time = time() + (60*60*24);
            setcookie($name, $value, $time);
// set cookie for tid (much important) = primary key
            $tid = "teacher_tid";
            $value = $row[1];
            setcookie($tid, $value, $time);
            if($row[2] == 'D'){
                header('Location: teacher-home-page.php');
            } else if($row[2] == 'A') {
                header('Location: admin-home-page.php');
            }
        } else {
            echo "Invalid email or password";
        }
        mysqli_close($connect);

        
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Login Page</title>
</head>
<body>
    <form action="./login-as-dr-or-admin.php" method="post">
        Email: <input name="email" type="text"> <br>
        Password: <input name="password" type="password"><br>
        <input type="submit" name="submit">
    </form>
</body>
</html>