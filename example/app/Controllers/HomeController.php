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
        $data = [
            "nama"=>"mini",
        ];
        $this->Response($data);
    }
}