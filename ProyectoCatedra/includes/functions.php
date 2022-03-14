<?php
define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');

function IncluirTemplate(string $nombre = "", bool $infoHeader = false, bool $navHeader = false){
    include TEMPLATES_URL . "/${nombre}.php";
}

function debug($variable){
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}