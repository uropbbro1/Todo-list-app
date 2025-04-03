<?php
namespace controllers;
class jsonResponseController{
    public static function jsonResponse(array $data, int $statusCode = 200): void {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        exit();
    }
}
