
<?php
session_start();


if (isset($_GET['page'])) {
    if ("home" == $_GET['page']) {
        include "pages/home.php";
    }  
    elseif ("login" == $_GET['page']) {
        include "pages/login.php";
    }
    elseif ("dashboard" == $_GET['page']) {        
        include "pages/dashboard.php";
    }
    elseif ("students" == $_GET['page']) {
        include "pages/admin/student/students.php";
    }
    elseif ("students-list" == $_GET['page']) {
        include "pages/admin/student/students-list.php";
    }
}

if (isset($_GET['action'])) {
    if ("logout" == $_GET['action']) {
        require_once "app/classes/Authentication.php";
        $auth = new Authentication();
        $auth->logout();
    }  
    if ("student-delete" == $_GET['action'] && isset($_GET['id'])) {
        $studentId = $_GET['id'];  
        require_once "app/classes/Student.php";
        $stu = new Student();
        $stu->delete($studentId); 
    } 
    if ("student-edit" == $_GET['action'] && isset($_GET['id'])) {
        $studentId = $_GET['id'];
        require_once "app/classes/Student.php";
        $stu = new Student();
        $stu->getStudentInfo($studentId); 
    }  
    if ('student-search' == $_GET['action']) {
        require_once "app/classes/Student.php";
        $stu = new Student();
        $stu->search();
    }
}

