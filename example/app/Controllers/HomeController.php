<?php

namespace App\Controllers;

use MiniSpeed\Controller;
use MiniSpeed\Database\Manager;

class HomeController extends Controller {

    private $db;

    public function __construct(){
        $this->db = Manager::get('main');
    }

    public function result(){
        echo "hello world";
        // $this->Response($data);
    }
    
    public function insert(){
        echo $_GET['id'];
        // $this->Response($data);
    }
}