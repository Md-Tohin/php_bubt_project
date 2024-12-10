<?php

// session_start();

// namespace App\classes;

require_once "config/Connection.php";

class Student extends Connection{

    public function __construct() {
        if (!isset($_SESSION['email'])) {
            header("Location: ?page=login");
            exit();
        }
        parent::__construct();
    }

    //  show all student
    public function show(){
        return $result = $this->con->query("SELECT * FROM `student_infos` ORDER BY `st_id` DESC");
    }

    //  get all class
    public function get_classes(){
        return $result = $this->con->query("SELECT * FROM `class_infos`");
    }

    //  get all group
    public function get_groups(){
        return $result = $this->con->query("SELECT * FROM `group_infos`");
    }

    //  store 
    public function store($request){  
       
        if (isset($_FILES['image'])) {

            $image = $_FILES['image'];
            $name_gen = rand(00000000, 999999999);
            $img_ex = pathinfo($image['name'], PATHINFO_EXTENSION);
            $image_name = $name_gen . '.' . $img_ex;            
            $destination = 'assets/img/students/' . $image_name;

            if (move_uploaded_file($image['tmp_name'], $destination)) {
                $save_path = $destination;
            } else {
                $save_path = "";
            }
        } else {
            $save_path = "";
        }

        $st_name = $request['full_name'];
        $email_id = $request['email'];
        $cell_no = $request['phone'];
        $st_dob = date('Y-m-d', strtotime($request['st_dob']));
        $photo = $save_path;
        $st_address = $request['st_address'];
        $st_gender = $request['st_gender'];
        $admission_date = date('Y-m-d', strtotime($request['admission_date']));
        $class_id = $request['class_id'];
        $group_id = $request['group_id'];

        $sql = "INSERT INTO `student_infos`(`st_id`, `st_name`, `photo`, `st_dob`, `st_gender`, `st_address`, `class_id`, `group_id`, `admission_date`, `cell_no`, `email_id`) VALUES 
        (NULL, '$st_name','$photo','$st_dob','$st_gender','$st_address','$class_id','$group_id','$admission_date','$cell_no','$email_id')";

        $result = mysqli_query($this->con, $sql);

        if ($result) {
            $_SESSION['message'] = "Student inserted successfully!";
            $_SESSION['type'] = "success";
        }
        else{
            $_SESSION['message'] = "Something is wrong! Try again later.";
            $_SESSION['type'] = "warning";
        }
        // return header("location: ?page=students");
    }

    //  edit
    public function edit($id){
        $result = $this->con->query("SELECT * FROM `student_infos` WHERE  st_id={$id}");
        return $result->fetch_assoc();
    }

    //  Get Student Information By Ajax
    public function getStudentInfo($id){       
        $studentInfo = $this->edit($id);

        $classInfos = [];
        $classResult = $this->con->query("SELECT * FROM `class_infos`");
        if ($classResult) {
            while ($row = $classResult->fetch_assoc()) {
                $classInfos[] = $row;
            }
        }

        $groupInfos = [];
        $groupResult = $this->con->query("SELECT * FROM `group_infos`");
        if ($groupResult) {
            while ($row = $groupResult->fetch_assoc()) {
                $groupInfos[] = $row;
            }
        }
        
        if ($studentInfo) {
            echo json_encode([
                'classInfos' => $classInfos,
                'groupInfos' => $groupInfos,
                'studentData' => $studentInfo
            ]);
        } else {
            echo json_encode(['error' => 'Student not found']);
        }
    }

    //  delete 
    public function delete($id){
        $student = $this->edit($id);
        $imagePath = $student['photo'];

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
        
        $result = $this->con->query("DELETE FROM `student_infos` WHERE  st_id={$id}");
        if ($result) {
            $_SESSION['message'] = "Student Deleted successfully!";
            $_SESSION['type'] = "success";
        }
        
        return header("location: ?page=students");
    }

    //  update 
    public function update($request){
        // echo "<pre>";
        // print_r($request);
        // exit();

        if (isset($_FILES['image'])) {
            $image = $_FILES['image'];
            $name_gen = rand(00000000, 999999999);
            $img_ex = pathinfo($image['name'], PATHINFO_EXTENSION);
            $image_name = $name_gen . '.' . $img_ex;
            $destination = 'assets/img/students/' . $image_name;

            if (move_uploaded_file($image['tmp_name'], $destination)) {
                $save_path = $destination;
                if (file_exists($request['old_image'])) {
                    unlink($request['old_image']);
                }
            } else {
                $save_path = $request['old_image'];
            }
        } else {
            $save_path = $request['old_image'];
        }

        $id = $request['student_id'];
        $st_name = $request['full_name'];
        $email_id = $request['email'];
        $cell_no = $request['phone'];
        $st_dob = date('Y-m-d', strtotime($request['st_dob']));
        $photo = $save_path;
        $st_address = $request['st_address'];
        $st_gender = $request['st_gender'];
        $admission_date = date('Y-m-d', strtotime($request['admission_date']));
        $class_id = $request['class_id'];
        $group_id = $request['group_id'];
       

        $sql = "UPDATE `student_infos` SET `st_name`='$st_name',`photo`='$photo',`st_dob`='$st_dob',`st_gender`='$st_gender',`st_address`='$st_address',`class_id`='$class_id',`group_id`='$group_id',`admission_date`='$admission_date',`cell_no`='$cell_no',`email_id`='$email_id' WHERE st_id={$id}";

        $result = mysqli_query($this->con, $sql);
       
        if ($result) {
            $_SESSION['message'] = "Student updated successfully!";
            $_SESSION['type'] = "success";
        }
        else{
            $_SESSION['message'] = "Something is wrong! Try again later.";
            $_SESSION['type'] = "warning";
        }
        // return header("location: ?page=students");
    }

    //  search 
    public function search(){
        // echo "<pre>";
        // print_r($_POST['student_id']);
        // exit();

        $id = $_POST['student_id'];
        $name = $_POST['student_name'];
        $class_id = $_POST['class_id'];

        $students = [];
        $sql = "SELECT * FROM `student_infos`";

        // Initialize an array to hold conditions
        $conditions = [];

        // Add conditions dynamically based on input
        if (!empty($id)) {
            $conditions[] = "st_id = " . (int)$id;
        }
        if (!empty($name)) {
            $conditions[] = "st_name = '" . $this->con->real_escape_string($name) . "'"; 
        }
        if (!empty($class_id)) {
            $conditions[] = "class_id = " . (int)$class_id;
        }
        if (count($conditions) > 0) {
            $sql .= " WHERE " . implode(' AND ', $conditions);
        }

        $queryResult = $this->con->query($sql);

        if ($queryResult) {
            while ($row = $queryResult->fetch_assoc()) {
                $students[] = $row;
            }
            echo json_encode(['students' => $students]);
        } else {
            echo json_encode(['error' => 'Student not found']);
        }
     }

    public function students(){
        $sql = "SELECT *, class_infos.class_name, group_infos.group_name
            FROM 
                student_infos
            INNER JOIN 
                class_infos ON student_infos.class_id = class_infos.class_id
            INNER JOIN 
                group_infos ON student_infos.group_id = group_infos.group_id";

        $queryResult = $this->con->query($sql);
        return $queryResult;
    }

}