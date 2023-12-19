<!-- Check login info if correct or not -->

<?php
    if(isset($_POST['submit'])) {
        $host = "localhost:3306";
        $user = 'root';
        $pass = '';
        $db = 'loginsdb';
        $connect = mysqli_connect($host, $user, $pass, $db) or die("Connection Error");
        
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM logindoctors WHERE email = '$email' AND password = '$password'";
        $result = $connect->query($sql);

        if(mysqli_num_rows($result) > 0) {
            echo "Login= Successful";
            header('Location: student-home-page.php');
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
    <title>Document</title>
</head>
<body>
    <form action="login-as-teacher.php" method="post">
        Email: <input name="email" type="text"> <br>
        Password: <input name="password" type="password"><br>
        <input type="submit" name="submit">
    </form>
</body>
</html>