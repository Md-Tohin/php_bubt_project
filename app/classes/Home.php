<?php

namespace App\classes;

class Home{

    public function index(){
        return header('location: route.php?page=login');
    }

}