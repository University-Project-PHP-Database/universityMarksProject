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
        primary key (email),
        foreign key (doctor) references Teacher(tid)
    )";
    mysqli_query($connect, $create_logindoctors_tbl);


    $insert_teacher = "INSERT INTO Teacher (`tid`, `tname`, `address`, `phone`, `speciality`) VALUES ('m001', 'MohDBOUK', 'Beirut', '03951293', 'CS-DB'), ('z000', 'ZeinIbrahim', 'Beirut', '03000000', 'CS-DB')";
    $insert_course = "INSERT into Course (`cid`, `teacher`, `ccode`, `cname`, `hours`, `credits`, `obtainedBy`) values ('I207E', 'm001', 'I207E', 'database', 72, 4, 0), ('I207F', 'm001', 'I207F', 'database', 72, 4, 0), ('I211E','m001', 'I211E', 'A. database', 60, 5, 0), ('I211F','m001', 'I211F', 'A. database', 60, 5, 0), ('I215F','z000', 'I215F', 'Op System', 60, 6, 0)";
    $insert_student = "INSERT into Student values ('200', 'Sami', '10-12-81', 'Beirut', '03434111', 0, 0), ('201', 'Fadi', '7/11/82',  'Bekaa', '01232211', 0, 0), ('103', 'Lina', '12/14/81', 'Birut', '07542312', 0, 0)";
    $insert_exam = "INSERT into Exam values ('2223s1f', 'FinalExamSem-1', '02/14/2023', '02/14/2023')";
    $insert_markregister = "INSERT into MarkRegister values ( '201', 'I207E', '2223s1f',  57), ( '103', 'I207E', '2223s1f',  40), ( '201', 'I207F', '2223s1f', 60), ( '201', 'I215F', '2223s1f', 35), ( '103', 'I215F', '2223s1f', 65), ( '200', 'I207F', '2223s1f', 62)";
    $insert_studentlogin = "INSERT INTO `loginstudents` (`student`, `email`, `password`) VALUES ('200', 'sami.ab@st.edu.lb', 'sami123'), ('201', 'fadi.sd@st.edu.lb', 'fadi'),('103', 'lina.mn@st.edu.lb', 'lina123')";
    $insert_doctorslogin = "INSERT INTO `logindoctors`(`doctor`, `email`, `password`) VALUES('m001', 'mohD@st.edu.lb', 'mohD123'), ('z000', 'zein@st.edu.lb', 'zein123')";
    $insert_studentcourses = "INSERT INTO `studentcourses`(`student`, `course`) VALUES('103', 'I211F')";
    
    
    mysqli_query($connect, $insert_teacher) or die("Could not add data");
    mysqli_query($connect, $insert_course) or die("Could not add data");
    mysqli_query($connect, $insert_student) or die("Could not add data");
    mysqli_query($connect, $insert_exam) or die("Could not add data");
    mysqli_query($connect, $insert_markregister) or die("Could not add data");
    mysqli_query($connect, $insert_studentlogin) or die("Could not add data");
    mysqli_query($connect, $insert_doctorslogin) or die("Could not add data");
    mysqli_query($connect, $insert_studentcourses) or die("Could not add data");
    mysqli_close($connect);


    echo "<h1>Congradualations! Your Database is created successfully..</h1>";
    
?>