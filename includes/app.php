<?php 
//Archivo que arranca todo
require __DIR__ . '/../vendor/autoload.php';
require 'funciones.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__); //Este es un paquete que instalamos (composer require vlucas/phpdotenv)
$dotenv->safeLoad(); //guarda las variables de entorno, lo hacemos antes de llamar a la BD
require 'database.php'; 


// Conectarnos a la base de datos
//use Dotenv\Dotenv;
use Model\ActiveRecord;
ActiveRecord::setDB($db);


