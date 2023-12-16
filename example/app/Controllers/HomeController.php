<?php

namespace App\Controllers;
use Exception;
use MiniSpeed\Controller;
use MiniSpeed\Database\Manager;

class HomeController extends Controller {

    private $db;
    public function __construct(){
        $this->db = Manager::get('main');
    }

    public function result(){

        $data = $this->db->get("mini");
        $this->Response($data,200);
    }

    public function insert(){
        try {
            $post = json_decode($this->Request()->raw(), true);
            $lastId = $this->db->insert("mini",$post);
            $this->Response(["id"=>$lastId],200);
        } catch (\Throwable $e) {
            throw new Exception(message:'mini/insert-failed',code:500);
        }
    }

    public function update(){
        try {
            $id = $this->Request()->get('id');
            $data = json_decode($this->Request()->raw(), true);
            $success = $this->db->update('mini',$data,['idMini'=>$id]);
            if ($success) return $this->Response(null,200);
        } catch (\Throwable $e) {
            throw new Exception(message:'mini/insert-failed',code:500);
        }
    }

    public function delete(){
        try {
            $id =  $this->Request()->get('nama');
            $success = $this->db->delete("mini",["idMini"=>$id]);
            if ($success) return $this->Response(null,200);
        } catch (\Throwable $e) {
            throw new Exception(message:'mini/insert-failed',code:500);
        }

    }

}