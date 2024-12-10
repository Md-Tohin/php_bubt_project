<?php

// session_start();

// namespace App\classes;

require_once "config/Connection.php";

class Dashboard extends Connection{

    public function __construct() {
        if (!isset($_SESSION['email'])) {
            header("Location: ?page=login");
            exit();
        }
        parent::__construct();
    }

    //  dashboard
    public function dashboard(){

        $data['total_student'] = 0;
        $data['total_teacher'] = 0;
        $data['total_class'] = 0;
        $data['total_group'] = 0;

        $student_result = $this->con->query("SELECT COUNT(`st_id`) AS total_students FROM `student_infos`");
        $teacher_result = $this->con->query("SELECT COUNT(`t_id`) AS total_teachers FROM `teacher_infos`");
        $class_result = $this->con->query("SELECT COUNT(`class_id`) AS total_classes FROM `class_infos`");
        $group_result = $this->con->query("SELECT COUNT(`group_id`) AS total_groups FROM `group_infos`");

        if ($student_result) {

            $row = $student_result->fetch_assoc();
            $data['total_student'] = $row['total_students'];

            $row = $teacher_result->fetch_assoc();
            $data['total_teacher'] = $row['total_teachers'];

            $row = $class_result->fetch_assoc();
            $data['total_class'] = $row['total_classes'];

            $row = $group_result->fetch_assoc();
            $data['total_group'] = $row['total_groups'];
        }        
        return $data;

    }
    
}