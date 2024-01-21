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
    function doctor_database_connection() {
        $host = "localhost:3306";
        $user = 'doctor';
        $pass = 'doctor123';
        $db = 'univdb';
        $connect = mysqli_connect($host, $user, $pass, $db) or die("Connection Error");
        return $connect;
    }

    function student_database_connection() {
        $host = "localhost:3306";
        $user = 'student';
        $pass = 'student123';
        $db = 'univdb';
        $connect = mysqli_connect($host, $user, $pass, $db) or die("Connection Error");
        return $connect;
      
    }
    function admin_database_connection() {
        $host = "localhost:3306";
        $user = 'admin';
        $pass = 'admin123';
        $db = 'univdb';
        $connect = mysqli_connect($host, $user, $pass, $db) or die("Connection Error");
        return $connect;
      
    }

// get course, exam and marks from markrigester table 
    function get_marks_ccode($sid) {
        $connect = student_database_connection();
        $get_info = "SELECT course, xlabel, mark FROM markregister, exam WHERE student='$sid' AND xid=exam";
        $result = mysqli_query($connect, $get_info) or die("Query failed: " . mysqli_error($connect));
        
        mysqli_close($connect);
        return $result;
        
    }
    

    //students can view there average in each semester
    function view_avg($id) {
        $connect = student_database_connection();
        
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
// doctors can view courses they teach and students they have in each course they teach
function view_students($id) {
    $connect = doctor_database_connection();
    $query = "SELECT c.cname, c.cid, s.student, ss.sname
    FROM course c, studentcourses s, student ss
    WHERE c.teacher = '$id' and c.cid=s.course and ss.sid=s.student;";
    $result = $connect->query($query);
    $connect->close();
    return $result;
    }
    //doctors can view marks for all students they teach with the course id

    function view_marks($id) {
        $connect = doctor_database_connection();
        $query = "SELECT m.student, c.cid, cname, m.mark
                  FROM course c,  markregister m
                  WHERE c.teacher='$id' AND c.cid=m.course";
                  
        $result = $connect->query($query);
        $connect->close();
        return $result; 
    }
    function view_marks_admin() {
        $connect = admin_database_connection();
        $query = "SELECT m.student, c.cid, cname, m.mark
                  FROM course c,  markregister m
                  WHERE c.cid=m.course";
                  
        $result = $connect->query($query);
        $connect->close();
        return $result; 
    }

    function upload_marks($student, $course, $exam, $mark) {
            $connect = doctor_database_connection();

            $ins_query="INSERT into markregister
            (`student`,`course`,`exam`,`mark`) values
            ('$student','$course','$exam','$mark')";
            $result = $connect->query($ins_query);
            if (!$result) {
                die("Error: " . mysqli_error($connect));
            }
            $connect->close();
            return $result;
    }
    //doctors can view courses that they teach
    function view_courses($id) {
        $connect = doctor_database_connection();
        $query="SELECT cid, cname, hours, credits, obtainedBy
                FROM course WHERE teacher= '$id'";
        $result = $connect->query($query);
        if (!$result) {
            die("Error: " . mysqli_error($connect));
        }
        $connect->close();
        return $result;

    }
    function view_obtainedCourses($id) {
        $connect = student_database_connection();
        $query = "SELECT obtainedCourses FROM student WHERE sid='$id'";
        $result = $connect->query($query);
        $row = $result->fetch_assoc();
        $connect->close();
        return $row;
    }
    function view_aquiredCredits($id) {
        $connect = student_database_connection();
        $query = "SELECT acquiredCredits FROM student WHERE sid='$id'";
        $result = $connect->query($query);
        $row = $result->fetch_assoc();
        $connect->close();
        return $row;
    }
    function view_course_avg($cid) {
        $connect = database_connection();
        $sql = "CALL CourseAvg('$cid')";
        $result = mysqli_query($connect, $sql);
        
        if ($result) {
            // Process the result set or output the average
            $row = mysqli_fetch_assoc($result);
            $connect->close();
            return $row['avg'];
        } else {
            // Handle errors
            echo "Error: " . mysqli_error($connect);
            $connect->close();
        }
        
    }
?>