<?php
// database connection
    function database_connection() {
        $host = "localhost:3306";
        $user = 'root';
        $pass = '';
        $db = 'univdb';
        $connect = mysqli_connect($host, $user, $pass, $db) or die("Connection Error");

        return $connect;
    }
// get course, exam and marks from markrigester table 
    function get_marks_ccode($sid) {
        $connect = database_connection();
        $get_info = "SELECT course, exam, mark FROM markregister WHERE student='$sid'";
        $result = mysqli_query($connect, $get_info) or die("Query failed: " . mysqli_error($connect));
        
        mysqli_close($connect);
        return $result;
        
    }
    
?>