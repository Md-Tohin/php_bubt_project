<?php

// session_start();

// namespace App\classes;

require_once "config/Connection.php";

class Authentication extends Connection{

    //  login
    public function login($request){       

        $email = $request['email'];
        $password = md5($request['password']); //  password123

        $result = $this->con->query("SELECT * FROM `users` WHERE email='$email' AND password='$password'");
        $user = $result->fetch_assoc();

        if ($result->num_rows > 0) {
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['photo'] = $user['image'];            
            header("Location: ?page=dashboard");
            exit();
        } else {
            $error = "Invalid username or password!";
            return $error;
        }
    }

    //  logout
    public function logout(){
        session_destroy();
        setcookie(session_name(), '', time() - 3600, '/');
        header("Location:?page=login");
        exit();
    }

    
}