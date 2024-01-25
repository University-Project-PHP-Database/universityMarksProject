<?php
    $host = "localhost:3306";
    $user = 'root';
    $pass = '';
    $db = 'univdb';
    $connect = mysqli_connect($host, $user, $pass) or die("Connection Error");
    $create_db = "CREATE DATABASE univdb";
    mysqli_query($connect, $create_db);
    mysqli_select_db($connect, $db);


/*==============================================================*/
/* Table: Teacher                                               */
/*==============================================================*/
    $create_teacher_tbl = "CREATE table Teacher (
        tid                  char(5)              not null,
        tname                varchar(30)          null,
        address              varchar(50)          null,
        phone                varchar(24)          null,
        speciality           varchar(30)          null,
        primary key (tid)

    )";   
    mysqli_query($connect, $create_teacher_tbl);

/*==============================================================*/
/* Table: Course                                                */
/*==============================================================*/
    $create_course_tbl = "CREATE table Course (
        cid                  char(5)              not null,
        teacher              char(5)              not null,
        ccode                varchar(10)          null,
        cname                varchar(50)          null,
        `hours`                int                  null,
        credits              int                  null,
        primary key (cid),
        foreign key (teacher) references Teacher (tid)      
    
    )";
    mysqli_query($connect, $create_course_tbl);


/*==============================================================*/
/* Table: ALTER Course                                                */
/*==============================================================*/

    $alter_course_tbl = "ALTER table Course add  obtainedBy int ";
    mysqli_query($connect, $alter_course_tbl);


/*==============================================================*/
/* Table: Exam                                                  */
/*==============================================================*/                  
    $create_exam_tbl = "CREATE table Exam (
        xid                  char(10)             not null,
        xlabel               varchar(30)          null,
        fromdate             datetime             null,
        todate               datetime             null,
        stat                 int                  not null,
        primary key (xid)
    )";
    mysqli_query($connect, $create_exam_tbl);

/*==============================================================*/
/* Table: Student                                               */
/*==============================================================*/
    $create_student_tbl = "CREATE table Student (
        sid                  char(5)              not null,
        sname                varchar(30)          null,
        bdate                datetime             null,
        address              varchar(50)          null,
        phone                varchar(24)          null,
        primary key (sid)
    )";
    mysqli_query($connect, $create_student_tbl);

/*==============================================================*/
/* Table: ALTER Student                                               */
/*==============================================================*/
    $alter_student_tbl = "ALTER TABLE Student 
                    add acquiredCredits int, 
                    add obtainedCourses int;
                        ";

    mysqli_query($connect, $alter_student_tbl);


/*==============================================================*/
/* Table: MarkRegister                                          */
/*==============================================================*/
    $create_markregister_tbl = "CREATE table MarkRegister (
        student              char(5)              not null,
        course               char(5)              not null,
        exam                 char(10)             not null,
        mark                 decimal(6,2)         null,
        primary key (student, course, exam),
        foreign key (student) references Student (sid),
        foreign key (course)  references Course (cid),
        foreign key (exam)    references Exam (xid)
    )";
    mysqli_query($connect, $create_markregister_tbl);

/*==============================================================*/
/* Table: StudentCourses                                        */
/*==============================================================*/
    $create_studentcourses_tbl = "CREATE table StudentCourses (
        student              char(5)              not null,
        course               char(5)              not null,
        primary key (student, course),
        foreign key (student) references Student (sid),
        foreign key (course)  references Course (cid)
    )";
    mysqli_query($connect, $create_studentcourses_tbl);
    

/*==============================================================*/
/* Table: LoginDetails                                          */
/*==============================================================*/
    $create_loginstudents_tbl = "CREATE table LoginStudents (
        student                 char(5)                 not null,
        email              char(50)              not null,
        password               char(50)              not null,
        primary key (email),
        foreign key (student) references Student(sid)
    )";
    mysqli_query($connect, $create_loginstudents_tbl);

    $create_logindoctors_tbl = "CREATE table LoginDoctors (
        doctor              char(5)                 not null,
        email              char(50)              not null,
        password               char(50)              not null,
        type               char(5)              not null,
        primary key (email),
        foreign key (doctor) references Teacher(tid)
    )";
    mysqli_query($connect, $create_logindoctors_tbl);



    
// Add new column deadline(calculated automatically using a trigger) in datetime
// Add new column duration (entered by admin) in days

    $query = "ALTER TABLE Exam ADD deadline datetime NULL";
    mysqli_query($connect, $query);
    $query = "ALTER table Exam add duration int";
    mysqli_query($connect, $query);




// TRIGGER to calculate deadline and save it in Exam table
$query= "CREATE TRIGGER ti_exam BEFORE INSERT ON exam
    FOR EACH ROW
    BEGIN
        DECLARE start_date DATE;
        DECLARE new_deadline DATE;
        DECLARE new_duration INT;

        SET start_date = NEW.fromdate;
        SET new_duration = NEW.duration;

        SET NEW.deadline = DATE_ADD(start_date, INTERVAL new_duration DAY);
    END;
    CREATE TRIGGER tu_exam BEFORE UPDATE ON exam
    FOR EACH ROW
    BEGIN
        DECLARE start_date DATE;
        DECLARE new_deadline DATE;
        DECLARE new_duration INT;

        SET start_date = NEW.fromdate;
        SET new_duration = NEW.duration;

        SET NEW.deadline = DATE_ADD(start_date, INTERVAL new_duration DAY);
    END;




    /*trigger to count obtained courses and acquired credits */
    CREATE TRIGGER ti_markregister
    AFTER INSERT ON MarkRegister
    FOR EACH ROW
    BEGIN
        DECLARE avg_mark DECIMAL(5,2);
        DECLARE mark_value INT;
    
        SET mark_value = NEW.mark;
    
        SET avg_mark = (
            SELECT AVG(M.mark)
            FROM MarkRegister M
            WHERE M.student = NEW.student
        );
    
        IF (mark_value >= 50 OR (mark_value BETWEEN 35 AND 49 AND avg_mark >= 55)) THEN
            UPDATE Student
            SET obtainedCourses = obtainedCourses + 1,
                acquiredCredits = acquiredCredits + (
                    SELECT credits
                    FROM course c
                    WHERE c.cid = NEW.course
                )
            WHERE sid = NEW.student;
    
            UPDATE course
            SET obtainedBy = obtainedBy + 1
            WHERE cid = NEW.course;
        ELSE
            SIGNAL SQLSTATE '45000'
            SET MESSAGE_TEXT = 'No action to take';
        END IF;
    END;";
    $result = $connect->multi_query($query);
    // Check for errors
    if (!$result) {
        echo "Error: " . $connect->error;
    }
    // Consume all result sets
    while ($connect->more_results()) {
        $connect->next_result();
    }
    // Clear the buffered results
    $connect->next_result();


// Insertion of data in the database   
    $insert_teacher = "INSERT INTO Teacher (tid, tname, address, phone, speciality) VALUES 
   ('A001', 'JaberAli', 'Beirut', '03951293', 'CS-PHP'),
   ('m001', 'MohDBOUK', 'Beirut', '03951293', 'CS-DB'),
   ('z000', 'ZeinIbrahim', 'Beirut', '03000000', 'CS-GRAPH'),
   ('z101', 'Zeinab', 'Beirut', '03000001', 'CS-Admin'),
   ('A002', 'Ahmad', 'Beirut', '03000021', 'CS-OS')";

$insert_course = "INSERT INTO Course (cid, teacher, ccode, cname, hours, credits, obtainedBy) VALUES 
   ('I207E', 'm001', 'I207E', 'database', 72, 5, 0),
   ('I207F', 'm001', 'I207F', 'database', 72, 5, 0),
   ('I211E', 'A001', 'I211E', 'PHP', 72, 5, 0),
   ('I211F', 'A001', 'I211F', 'PHP', 72, 5, 0),
   ('I215E', 'z000', 'I215E', 'Graph', 60, 4, 0),
   ('I210E', 'A002', 'I210E', 'OS', 60, 4, 0),
   ('I215F', 'z000', 'I215F', 'Graph', 60, 4, 0),
   ('I220E', 'z000', 'I220E', 'Data Structure', 72, 5, 0),
   ('I220F', 'z000', 'I220F', 'Data Structure', 72, 5, 0),
   ('I221E', 'A001', 'I221E', 'Computer Architecture', 60, 4, 0),
   ('I221F', 'A001', 'I221F', 'Computer Architecture', 60, 4, 0)";

$insert_student = "INSERT INTO Student VALUES 
   ('103', 'Lina', '12/14/81', 'Beirut', '07542312', 0, 0),
   ('200', 'Sami', '10-12-81', 'Beirut', '03434111', 0, 0),
   ('201', 'Fadi', '7/11/82', 'Bekaa', '01232211', 0, 0),
   ('400', 'Nicole', '12/14/41', 'Beirut', '03434331', 0, 0)";

$insert_exam = "INSERT INTO Exam VALUES 
   ('2223s1f', 'FinalExamSem-1', '02/14/2023', '02/14/2023', 2, NULL, 0),
   ('x400', 'Sem1', '02/14/2023', '02/14/2023', 2, NULL, 30),
   ('x401', 'Sem1', '02/14/2023', '02/14/2023', 2, NULL, 50),
   ('x402', 'Sem1', '02/14/2023', '02/14/2023', 2, NULL, 50),
   ('x403', 'Sem1', '02/14/2023', '02/14/2023', 2, NULL, 38)";

$insert_markregister = "INSERT INTO MarkRegister(student, course, exam, mark) VALUES 
   ('103', 'I207E', '2223s1f', 50),
   ('103', 'I210E', 'x400', 65),
   ('200', 'I207E', '2223s1f', 62),
   ('200', 'I210E', 'x400', 80),
   ('201', 'I207F', 'x401', 50),
   ('201', 'I211F', 'x403', 60),
   ('201', 'I215F', 'x402', 75),
   ('400', 'I207F', 'x401', 50),
   ('400', 'I211F', 'x403', 55),
   ('400', 'I215F', 'x402', 77)";

$insert_studentlogin = "INSERT INTO loginstudents (student, email, password) VALUES 
   ('103', 'lina.mn@st.edu.lb', 'lina123'),
   ('200', 'sami.ab@st.edu.lb', 'sami123'),
   ('201', 'fadi.sd@st.edu.lb', 'fadi'),
   ('400', 'nicole.ab@st.edu.lb', 'nicole123')";

$insert_doctorslogin = "INSERT INTO logindoctors (doctor, email, password, type) VALUES 
   ('A001', 'Jaber@st.edu.lb', 'Jaber123', 'D'),
   ('m001', 'mohD@st.edu.lb', 'mohD123', 'D'),
   ('z000', 'zein@st.edu.lb', 'zein123', 'D'),
   ('z101', 'zeinab@st.edu.lb', 'zeinab123', 'A')";

$insert_studentcourses = "INSERT INTO studentcourses (student, course) VALUES 
   ('103', 'I220E'),
   ('103', 'I221E'),
   ('200', 'I220E'),
   ('200', 'I221E'),
   ('201', 'I220F'),
   ('201', 'I221F'),
   ('400', 'I220F'),
   ('400', 'I221F')";

    
    mysqli_query($connect, $insert_teacher) or die("Could not add data");
    mysqli_query($connect, $insert_course) or die("Could not add data");
    mysqli_query($connect, $insert_student) or die("Could not add data");
    mysqli_query($connect, $insert_exam) or die("Could not add data");
    mysqli_query($connect, $insert_studentlogin) or die("Could not add data");
    mysqli_query($connect, $insert_doctorslogin) or die("Could not add data");
    mysqli_query($connect, $insert_studentcourses) or die("Could not add data");
    mysqli_query($connect, $insert_markregister) or die("Could not add data");









    // Drop users if they exist
    $dropAdmin = "DROP USER IF EXISTS 'admin'@'localhost'";
    $dropDoctor = "DROP USER IF EXISTS 'doctor'@'localhost'";
    $dropStudent = "DROP USER IF EXISTS 'student'@'localhost'";

    $connect->query($dropAdmin);
    $connect->query($dropDoctor);
    $connect->query($dropStudent);


    //create users (security)
    $createAdmin = $connect->query("CREATE USER 'admin'@'localhost' IDENTIFIED BY 'admin123'");
    $createDoctor = $connect->query("CREATE USER 'doctor'@'localhost' IDENTIFIED BY 'doctor123'");
    $createStudent = $connect->query("CREATE USER 'student'@'localhost' IDENTIFIED BY 'student123'");

    if (!$createAdmin || !$createDoctor || !$createStudent) {
        die("Error creating users: " . $connect->error);
    }
    
    //student can only view selected tables
    $student_permissions = "GRANT SELECT ON `univdb`.`studentcourses` TO 'student'@'localhost' IDENTIFIED BY 'student123';
    GRANT SELECT ON `univdb`.`course` TO 'student'@'localhost' IDENTIFIED BY 'student123';
    GRANT SELECT ON `univdb`.`exam` TO 'student'@'localhost' IDENTIFIED BY 'student123';
    GRANT SELECT ON `univdb`.`markregister` TO 'student'@'localhost' IDENTIFIED BY 'student123';
    GRANT SELECT ON `univdb`.`student` TO 'student'@'localhost' IDENTIFIED BY 'student123';
    ";
    $result = $connect->multi_query($student_permissions); 
    if (!$result) {
        echo "Error: " . $connect->error;
    }
    while ($connect->more_results()) {
        $connect->next_result();
    }
    $connect->next_result();   




    //admin can do anything
   

    $admin_privileges = "GRANT SELECT, UPDATE, INSERT, DELETE ON `univdb`.`exam` TO 'admin'@'localhost' IDENTIFIED BY 'admin123';
    GRANT SELECT, UPDATE, INSERT, DELETE ON `univdb`.`student` TO 'admin'@'localhost' IDENTIFIED BY 'admin123';
    GRANT SELECT, UPDATE, INSERT, DELETE ON `univdb`.`course` TO 'admin'@'localhost' IDENTIFIED BY 'admin123';
    GRANT SELECT, UPDATE, INSERT, DELETE ON `univdb`.`exam` TO 'admin'@'localhost' IDENTIFIED BY 'admin123';
    GRANT SELECT, UPDATE, INSERT, DELETE ON `univdb`.`studentcourses` TO 'admin'@'localhost' IDENTIFIED BY 'admin123';
    GRANT SELECT, UPDATE, INSERT, DELETE ON `univdb`.`teacher` TO 'admin'@'localhost' IDENTIFIED BY 'admin123';
    GRANT SELECT, UPDATE, INSERT, DELETE ON `univdb`.`markregister` TO 'admin'@'localhost' IDENTIFIED BY 'admin123';
    ";
    $result = $connect->multi_query($admin_privileges); 
    if (!$result) {
        echo "Error: " . $connect->error;
    }
    while ($connect->more_results()) {
        $connect->next_result();
    }
    $connect->next_result();   




    $doctor_privileges = "GRANT SELECT ON `univdb`.`studentcourses` TO 'doctor'@'localhost' IDENTIFIED BY 'doctor123';
    GRANT SELECT ON `univdb`.`course` TO 'doctor'@'localhost' IDENTIFIED BY 'doctor123';
    GRANT SELECT, INSERT, UPDATE ON `univdb`.`exam` TO 'doctor'@'localhost' IDENTIFIED BY 'doctor123';
    GRANT SELECT, INSERT, UPDATE, DELETE ON `univdb`.`markregister` TO 'doctor'@'localhost' IDENTIFIED BY 'doctor123';
    GRANT SELECT ON `univdb`.`student` TO 'doctor'@'localhost' IDENTIFIED BY 'doctor123';
    ";
    $result = $connect->multi_query($doctor_privileges); 
    if (!$result) {
        echo "Error: " . $connect->error;
    }
    while ($connect->more_results()) {
        $connect->next_result();
    }
    $connect->next_result();   



    // "CourseAvg" procedure that returns the average of marks of each course and the percentage of succeedin this course.
    $sql = "CREATE PROCEDURE `CourseAvg` (IN course_id CHAR(5), OUT avg_value DECIMAL(6,2), OUT success_percentage DECIMAL(5,2))
    BEGIN
        DECLARE mark_value DECIMAL(6,2);
        DECLARE sum_value DOUBLE;
        DECLARE Passed_counter_value INT;
        DECLARE counter_value INT;
        DECLARE done INT DEFAULT FALSE;
    
        DECLARE cur CURSOR FOR
            SELECT m.mark
            FROM markregister m
            WHERE m.course = course_id;
    
        DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;
    
        OPEN cur;
    
        SET sum_value = 0;
        SET counter_value = 0;
        SET Passed_counter_value = 0;
    
        read_loop: LOOP
            FETCH cur INTO mark_value;
            IF done THEN LEAVE read_loop; END IF;
    
            -- calculate the number of students registered in the course
            SET counter_value = counter_value + 1;
    
            -- calculate the number of students who passed the course exam
            IF mark_value >= 50 THEN
                SET sum_value = sum_value + mark_value;
                SET Passed_counter_value = Passed_counter_value + 1;
            END IF;
        END LOOP;
    
        IF counter_value > 0 THEN
            SET avg_value = sum_value / counter_value;
            SET success_percentage = (Passed_counter_value / counter_value) * 100;
        ELSE
            SET avg_value = NULL;
            SET success_percentage = NULL;
        END IF;
    
        CLOSE cur;
        
    END;";
    $result = $connect->multi_query($sql);
    // Check for errors
    if (!$result) {
        echo "Error: " . $connect->error;
    }
    // Consume all result sets
    while ($connect->more_results()) {
        $connect->next_result();
    }
    // Clear the buffered results
    $connect->next_result();
   


    echo "<h1>Congradualations! Your Database is created successfully..</h1>";
    
?>