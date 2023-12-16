<?php

namespace App\Controllers;
use Exception;
use MiniSpeed\Request;
use MiniSpeed\ResponseJson;
use App\Model\Mini;

class HomeController {

    public function result(ResponseJson $response, Mini $Mini){
        $data = $Mini->result("mini");
        $response->send($data,200);
    }

    public function insert(Request $request,ResponseJson $response, Mini $Mini){
        try {
            $post = json_decode($request->raw(), true);
            $lastId = $Mini->insert("mini",$post);
            $response->send(["id"=>$lastId],200);
        } catch (\Throwable $e) {
            throw new Exception(message:'mini/insert-failed', code:500);
        }
    }

    public function update(Request $request,ResponseJson $response, Mini $Mini){
        try {
            $id = $request->get("id");
            $data = json_decode($request->raw(), true);
            $where = ["idMini" => $id];
            $success = $Mini->update("mini", $data, $where);
            if ($success) return $response->send(null,200);
        } catch (\Throwable $e) {
            throw new Exception(message:'mini/update-failed', code:500);
        }
    }

    public function delete(Request $request,ResponseJson $response, Mini $Mini){
        try {
            $id =  $request->get("id");
            $where = ["idMini"=> $id];
            $success = $Mini->delete("mini",$where);
            if ($success) return $response->send(null,200);
        } catch (\Throwable $e) {
            throw new Exception(message:'mini/delete-failed', code:500);
        }

    }

}