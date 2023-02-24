<?php

$db = mysqli_connect($_ENV['DB_HOST'], $_ENV['DB_USER'], $_ENV['DB_PASS'], $_ENV['DB_DB']); //Usamos las variables de entorno de .env

if (!$db) {
    echo "Error: No se pudo conectar a MySQL.";
    echo "errno de depuración: " . mysqli_connect_errno();
    echo "error de depuración: " . mysqli_connect_error();
    exit;
}

use Model\ActiveRecord;

/*class Database {

    public $host = 'localhost';
    public $usuario = 'root';
    public $contrasena = 'password';
    public $nombreBD = 'appsalon';
    
    public static function crearConexion() {
        $dsn = 'mysql:host=' . self::$host . ';dbname=' . self::$nombreBD . ';charset=utf8mb4';
        
        $opciones = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        try {
            $pdo = new PDO($dsn, self::$usuario, self::$contrasena, $opciones);
            return $pdo;
        } catch (PDOException $e) {
            throw new PDOException($e->getMessage(), (int)$e->getCode());
        }
    } 
}*/

