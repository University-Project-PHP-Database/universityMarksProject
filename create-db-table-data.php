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


    $insert_teacher = "INSERT INTO Teacher (`tid`, `tname`, `address`, `phone`, `speciality`) VALUES ('m001', 'MohDBOUK', 'Beirut', '03951293', 'CS-DB'), ('z000', 'ZeinIbrahim', 'Beirut', '03000000', 'CS-DB'), ('z101', 'Zeinab', 'Beirut', '03000001', 'CS-Admin'), ('c001', 'Hala', 'Beirut', '03951293', 'CS-CA')";
    $insert_course = "INSERT into Course (`cid`, `teacher`, `ccode`, `cname`, `hours`, `credits`, `obtainedBy`) values ('I207E', 'm001', 'I207E', 'database', 72, 4, 0), ('I207F', 'm001', 'I207F', 'database', 72, 4, 0), ('I211E','m001', 'I211E', 'A. database', 60, 5, 0), ('I211F','m001', 'I211F', 'A. database', 60, 5, 0), ('I215F','z000', 'I215F', 'Op System', 60, 6, 0), ('I2202', 'c001', 'I2202', 'CA', 72, 4, 0)";
    $insert_student = "INSERT into Student values ('200', 'Sami', '10-12-81', 'Beirut', '03434111', 0, 0), ('201', 'Fadi', '7/11/82',  'Bekaa', '01232211', 0, 0), ('103', 'Lina', '12/14/81', 'Birut', '07542312', 0, 0),  ('400', 'Nicole', '12/14/41', 'Beirut', '03434331', 0, 0)";
    $insert_exam = "INSERT into Exam values ('2223s1f', 'FinalExamSem-1', '02/14/2023', '02/14/2023')";
    $insert_markregister = "INSERT into MarkRegister values ( '201', 'I207E', '2223s1f',  57), ( '103', 'I207E', '2223s1f',  40), ( '201', 'I207F', '2223s1f', 60), ( '201', 'I215F', '2223s1f', 35), ( '103', 'I215F', '2223s1f', 65), ( '200', 'I207F', '2223s1f', 62)";
    $insert_studentlogin = "INSERT INTO `loginstudents` (`student`, `email`, `password`) VALUES ('200', 'sami.ab@st.edu.lb', 'sami123'), ('201', 'fadi.sd@st.edu.lb', 'fadi'),('103', 'lina.mn@st.edu.lb', 'lina123'), ('400', 'nicole.ab@st.edu.lb', 'nicole123')";
    $insert_doctorslogin = "INSERT INTO `logindoctors`(`doctor`, `email`, `password`, `type`) VALUES('m001', 'mohD@st.edu.lb', 'mohD123', 'D'), ('z000', 'zein@st.edu.lb', 'zein123', 'D'), ('z101', 'zeinab@st.edu.lb', 'zeinab123', 'A'), ('c001', 'hala@st.edu.lb', 'hala123', 'D')";
    $insert_studentcourses = "INSERT INTO `studentcourses`(`student`, `course`) VALUES('103', 'I211F')";
    
    
    mysqli_query($connect, $insert_teacher) or die("Could not add data");
    mysqli_query($connect, $insert_course) or die("Could not add data");
    mysqli_query($connect, $insert_student) or die("Could not add data");
    mysqli_query($connect, $insert_exam) or die("Could not add data");
    mysqli_query($connect, $insert_markregister) or die("Could not add data");
    mysqli_query($connect, $insert_studentlogin) or die("Could not add data");
    mysqli_query($connect, $insert_doctorslogin) or die("Could not add data");
    mysqli_query($connect, $insert_studentcourses) or die("Could not add data");

    
// Add new column deadline(calculated automatically using a trigger) in datetime
// Add new column duration (entered by admin) in days

    $query = "ALTER TABLE Exam ADD deadline datetime NULL";
    mysqli_query($connect, $query);
    $query = "ALTER table Exam add duration int";
    mysqli_query($connect, $query);




// TRIGGER to calculate deadline and save it in Exam table
$query1= "CREATE TRIGGER ti_exam BEFORE INSERT ON exam
    FOR EACH ROW
    BEGIN
        DECLARE start_date DATE;
        DECLARE new_deadline DATE;
        DECLARE new_duration INT;

        SET start_date = NEW.fromdate;
        SET new_duration = NEW.duration;

        SET NEW.deadline = DATE_ADD(start_date, INTERVAL new_duration DAY);
    END";
    mysqli_query($connect, $query1);
    //data to test the trigger
    $insert_exam = "INSERT INTO Exam (xid, xlabel, fromdate, todate, deadline, duration) 
    VALUES ('2223s11e', 'ExamSem-1', '2023-02-14', '2023-02-14', NULL, 14)";

    mysqli_query($connect, $insert_exam);


    
    $query = "CREATE TRIGGER ti_markregister
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
    END;

    
    ";
    //more insertions after triggers creation
    mysqli_query($connect, $query);
    $query = "INSERT into MarkRegister values ( '200', 'I207E', '2223s1f',  55)";
    $insert_exam = "INSERT into exam values ( 'x400', 'Sem1', '02/14/2023', '02/14/2023',NULL,  30),( 'x401', 'Sem1', '02/14/2023', '02/14/2023',NULL,  50) ";
    $insert_studentcourses = "INSERT INTO `studentcourses`(`student`, `course`) VALUES('103', 'I215F'),('200', 'I2202'), ('201', 'I2202'), ('103', 'I2202') ";
    $insert_markregister = "INSERT into MarkRegister values ( '400', 'I2202', 'x400',  50), ( '400', 'I215F', 'x401',  55)";
    mysqli_query($connect, $query);
    mysqli_query($connect, $insert_exam);
    mysqli_query($connect, $insert_studentcourses);
    mysqli_query($connect, $insert_markregister);


    mysqli_close($connect);





    echo "<h1>Congradualations! Your Database is created successfully..</h1>";
    
?>