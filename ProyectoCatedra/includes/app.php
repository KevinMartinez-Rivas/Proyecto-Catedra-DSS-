<?php

require 'functions.php';
require 'config/database.php';
require __DIR__ . '/../classes/usuario.class.php';
require __DIR__ . '/../classes/cuenta.class.php';

//Conexion a BD
$db = ConectarDB();

//Conexion BD con clase Usuario
use BancoNombre\Usuario;
Usuario::setDB($db);

//Conexion BD con clase Cuenta
use BancoNombre\Cuenta;
Cuenta::setDB($db);