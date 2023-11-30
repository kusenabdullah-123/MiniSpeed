<?php
namespace MiniSpeed;

use MiniSpeed\Base;
use MiniSpeed\ResponseJson;

class Controller extends Base {
    public function Response($data,$code = 200) {
       return ResponseJson::send($data,$code); 
    }
}