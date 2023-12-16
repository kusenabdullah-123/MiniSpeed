<?php

namespace MiniSpeed;


class ResponseJson {
    public function send(mixed $data, int $status = 200, int $options = JSON_NUMERIC_CHECK | JSON_PRETTY_PRINT): void{
        header('Content-Type: application/json');
        http_response_code($status);
        echo json_encode($data, $options);
    }
}