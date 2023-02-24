<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//Funcion que revisa que el usuario este autenticado
function isAuth() : void{
    if(!isset($_SESSION['login'])){ //Si no esta definida la variable de sesion, redireccionamos
        header('Location: /');
    }
}

function esUltimo(string $actual, string $proximo): bool{
    if($actual !== $proximo){
        return true;
    }else{
        return false;
    }
}

function isAdmin() : void { //void le indica que no va a retornar nada
    if(!isset($_SESSION['admin'])){
        header('Location: /');
    }
}