<?php

require 'functions.php';
require 'config/database.php';
require __DIR__ . '/../classes/usuario.class.php';
require __DIR__ . '/../classes/cuenta.class.php';
require __DIR__ . '/../classes/historial.class.php';
require __DIR__ . '/../classes/recargo.class.php';

//Conexion a BD
$db = ConectarDB();

//Conexion BD con clase Usuario
use BancoNombre\Usuario;
Usuario::setDB($db);

//Conexion BD con clase Cuenta
use BancoNombre\Cuenta;
Cuenta::setDB($db);

//Conexion BD con clase Historial
use BancoNombre\Historial;
Historial::setDB($db);

//Conexion BD con clase Recargo
use BancoNombre\Recargo;
Recargo::setDB($db);