<?php
define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');

function IncluirTemplate(string $nombre = "", bool $option1 = false, bool $option2 = false){
    include TEMPLATES_URL . "/${nombre}.php";
}

function AutenticarSession() {
    session_start();
 
    if(!$_SESSION['login']){
        header('location: /ProyectoCatedra/login.php');
    }
}

function debug($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}