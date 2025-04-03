<?php
namespace controllers;

use \Firebase\JWT\JWT;
use Dotenv\Dotenv;
use Exception;

class JwtHandler {
    private static $secretKey = '';

    public function __construct()
    {
        $dotenv = Dotenv::createImmutable('/../.env');
        $dotenv->load();
        $this->secretKey =  $_ENV['JWT_SECRET'];
    }

    public static function generateToken(int $userId): string {
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'userId' => $userId
        ];

        return JWT::encode($payload, self::$secretKey, "HS256");
    }

    public static function decodeToken(string $jwt): object {
        try {
            return JWT::decode($jwt, self::$secretKey);
        } catch (Exception $e) {
            throw new Exception('Invalid token');
        }
    }
}