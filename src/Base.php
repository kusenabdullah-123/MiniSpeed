<?php
namespace MiniSpeed;
use MiniSpeed\Factory;

class Base {
    public function create($name,$params=[]){
        Factory::create($name,$params);
    }
}