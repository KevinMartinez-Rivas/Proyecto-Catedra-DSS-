<?php 

function ConectarDB() : mysqli{
    $db = new mysqli('localhost', 'root', '', 'banconombre');

    if(!$db) {
        echo "Error no se realizo la conexion";
        exit;
    }

    return $db;
}