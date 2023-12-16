<?php
namespace App\Model;
use MiniSpeed\Database\Manager;

class Mini {
    private $db;
    
    public function __construct(){
        $this->db = Manager::get('main');
    }
    public function result(){
        return $this->db->get("mini");
    }

    public function insert(string $table ,array $data){
        return $this->db->insert($table,$data);
    }

    public function update(string $table,array $data, array $where){
        return $this->db->update($table,$data,$where);
    }

    public function delete(string $table,$where){
        return $this->db->delete($table,$where);
    }
}