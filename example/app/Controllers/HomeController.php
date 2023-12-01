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
            "nama"=>"n",
        ];
        // $this->db->insert("mini",$data);
        // $this->db->update("mini",$data,["idMini"=>19]);
        // $this->db->delete("mini",["idMini"=>22]);
        // $this->Response($data);
    }
    
    public function insert(){
        echo $_GET['id'];
        // $this->Response($data);
    }
}