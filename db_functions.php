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
        $get_info = "SELECT course, xlabel, mark FROM markregister, exam WHERE student='$sid' AND xid=exam";
        $result = mysqli_query($connect, $get_info) or die("Query failed: " . mysqli_error($connect));
        
        mysqli_close($connect);
        return $result;
        
    }
    
    // insert a course to the database, $info is an array contain all the information of the element 
    function insert($tableName, $Info){
        $connect = database_connection();
        foreach ($Info as $coloumnName => $coloumnValue) {          
            $set_info = "INSERT INTO $tableName ($coloumnName) VALUES ('$coloumnValue') ";
        }
        $result = mysqli_query($connect, $set_info) or die("Query failed: " . mysqli_error($connect));
        
        mysqli_close($connect);
        
    }

    function delete($tableName, $id ,$eid){

        $connect = database_connection();
        $query = "delete from $tableName where $id = $eid";
        echo $query."<br>";
        $result = mysqli_query($connect, $query) or die("Query failed: " . mysqli_error($connect));
        
        mysqli_close($connect);
    }

    function search($tableName, $eid){
        $connect = database_connection();
        $query = "SELECT * from '$tableName' where sid.='".$eid."'"; 
        $result = mysqli_query($connect, $query) or die("Query failed: " . mysqli_error($connect));

        mysqli_close($connect);

        return $result;
    }

    function edit($tableName,$Info,$id,$eid){
        $connect = database_connection();
        foreach ($Info as $coloumnName => $coloumnValue) {          
            $set_info = "update '$tableName' set '$coloumnName' = '$coloumnValue' where '$id' = '$eid' ";
        }
        $result = mysqli_query($connect, $set_info) or die("Query failed: " . mysqli_error($connect));
        
        mysqli_close($connect);
    }

    
    function view_avg($id) {
        $connect = database_connection();
        
        $query = "SELECT E.xlabel, AVG(M.mark) AS avg_mark
                FROM markregister M, exam E
                WHERE E.xid=M.exam
                AND M.student = '$id'
                GROUP BY E.xlabel";
        
        $result = $connect->query($query);
        
        // Fetching all rows if there are multiple xlabels
        $averages = [];
        while ($row = $result->fetch_assoc()) {
            $averages[$row['xlabel']] = $row['avg_mark'];
        }
        
        $connect->close();
    
        return $averages;
    }
    function view_students($id) {
        $connect = database_connection();
        $query = "SELECT course, student
        FROM course, studentcourses
        WHERE teacher = '$id'
        GROUP BY course, student; ";
        $result = $connect->query($query);
        $connect->close();  
        return $result;
    }
?>