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
    
        // Call the stored procedure
        $sql = "CALL CourseAvg('$cid', @avg, @success_percentage)";
        $result = $connect->query($sql);
        if (!$result) {
            // Handle errors
            echo "Error calling stored procedure: " . $connect->error;
            $connect->close();
            return false;
        }
        // Fetch the output parameters
        $outputQuery = "SELECT @avg AS avg, @success_percentage AS suc_percentage";
        $outputResult = $connect->query($outputQuery);
    
        if (!$outputResult) {
            // Handle errors
            echo "Error fetching output parameters: " . $connect->error;
            $connect->close();
            return false;
        }
    
        // Process the result set or output the average
        $row = $outputResult->fetch_assoc();
        $connect->close();
        return $row;
    }
    
    function compensation_fun(){
        $connect = database_connection();
        //get sid for all student.
        $sid_query="SELECT sid From Student";
        $sid_result=mysqli_query($connect, $sid_query)  or die("Error to select".mysql_error($connect));
        
        
       
        //iterates the sid of studentes
        while($sid_row=mysqli_fetch_array($sid_result)){
         

            //now we want to get all the marks for the student with this $sid
            $query="SELECT student, course, exam, mark, flag, xlabel from MarkRegister M, Exam E where M.student='$sid_row[0]' and M.exam=E.xid";
            $result=mysqli_query($connect,$query)  or die("Error to select".mysql_error($connect));;
            
            
            //we will iterate each mark, then we check if the mark value is between 35 and 49
            while($row=mysqli_fetch_assoc($result)){
                
                 if($row['mark']> 35 && $row['mark']<49 ){

                    //inorder to make the compensation only one times for each mark
                   
                    
                    //calculate the average of marks which are within the same semester of the mark $row['exam]//
                    $avg="SELECT AVG(mark) from MarkRegister M, Exam E where M.student='$sid_row[0]' and M.exam=E.xid and E.xlabel='".$row['xlabel']."'";
                    $avg_result=mysqli_query($connect,$avg)  or die("Error to select".mysql_error($connect));
                   
                        $avg_row = mysqli_fetch_array($avg_result);

                       if($avg_row[0] > 55  && !($row['flag'])){
                        
                        $query="UPDATE MarkRegister M SET flag = 1 WHERE M.course='".$row['course']."' and M.student='$sid_row[0]'";
                        mysqli_query($connect, $query)  or die("Error to select".mysql_error($connect));

                        //update obtaind courses in the course table
                        $course_query="UPDATE Course set obtainedBy= obtainedBy+1 where Course.cid='".$row['course']."'";
                        $course_result=mysqli_query($connect,$course_query);

                        //update acquiredCredits and obtainedCourses in the student table
                        $student_query="UPDATE Student set obtainedCourses =obtainedCourses+1, acquiredCredits=acquiredCredits +(
                        SELECT credits
                        FROM course c
                        WHERE c.cid = '".$row['course']."')
                        where sid='$sid_row[0]'";
                        $student_result=mysqli_query($connect,$student_query);
                        
                        if(!$course_result || !$student_result){
                            echo "Error: " . mysqli_error($connect);
                            mysqli_close($connect);
                        }
                    }
                }
            }
        }
        
    }

    function get_status($id){
        $connect = student_database_connection();
        $query = "SELECT exam FROM markregister WHERE student=$id";
        $result = $connect->query($query);
        $row = $result->fetch_assoc();
        $xid = $row['exam'];
        $query2 ="SELECT stat FROM Exam WHERE xid='$xid'";
        $result2 = $connect->query($query2);
        $row2 = $result2->fetch_assoc();
        $stat = $row2['stat'];
        $connect->close();
        return $stat;
    }

    function update_status($examid, $status) {
        $connect = doctor_database_connection();

        $update_query="UPDATE Exam SET stat = $status where xid = '$examid'";
        $result = $connect->query($update_query);
        if (!$result) {
            die("Error: " . mysqli_error($connect));
        }
        $connect->close();

    }


?>