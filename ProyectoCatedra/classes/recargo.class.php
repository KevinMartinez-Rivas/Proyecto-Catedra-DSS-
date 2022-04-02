<?php

namespace BancoNombre;

class Recargo {
    //Conexion a base de datos
    protected static $db;
    protected static $columnaDB = ['CodigoRecargo', 'CodigoCategoriaCuenta', 'OperacionesDisponibles', 'RecargoMensual'];

    //Arreglo de Errores
    protected static $errores = [];

    //Variables publicas de clase
    public $CodigoRecargo;
    public $CodigoCategoriaCuenta;
    public $OperacionesDisponibles;
    public $RecargoMensual;

    //Funcion Constructora
    public function __construct($args = []) {
        $this->CodigoRecargo = $args['CodigoRecargo'] ?? '';
        $this->CodigoCategoriaCuenta = $args['CodigoCategoriaCuenta'] ?? '';
        $this->OperacionesDisponibles = $args['OperacionesDisponibles'] ?? '';
        $this->RecargoMensual = $args['RecargoMensual'] ?? '';
    }

    //Mostrar a todas las transacciones dentro de la BD
    public static function getAllRecargos() {
        $arregloRecargos = [];

        //Creamos el query
        $query = "SELECT * FROM recargos";

        //Ejecutamos el query y traemos a los usuarios
        $recargo = self::$db->query($query);

        //Iteramos sobre cada registro o columna para obtener cada usuario en la BD
        while($registro = $recargo->fetch_assoc()):
            $arregloRecargos[] = self::ConvertirOBJ($registro);
        endwhile;

        //Devolvemos el arreglo de objetos
        return $arregloRecargos;
    }

    //Editar el numero de operaciones por tipo de una cuenta
    public static function SetOperaciones($OperacionesDisponibles, $CodigoRecargo) {
        //Creamos el query
        $query = "UPDATE recargos SET OperacionesDisponibles = ${OperacionesDisponibles} WHERE CodigoCategoriaCuenta = '${CodigoRecargo}'";
    
        //Ejecutamos la consulta
        $rs = self::$db->query($query);
    
        return $rs;
    }

    //Editar el porcentaje de recargo mensual en las cuentas de ahorro
    public static function SetRecargoMensual($RecargoMensual) {
        //Creamos el query
        $query = "UPDATE recargos SET RecargoMensual = ${RecargoMensual} WHERE CodigoCategoriaCuenta = 'AHR'";
    
        //Ejecutamos la consulta
        $rs = self::$db->query($query);
    
        return $rs;
    }

    //Obtener los errores de los datos en recargos
    public static function getErroresRecargos() {
        return self::$errores;
    }

    //Metodo para definir la conexion a BD
    public static function setDB($database) {
        self::$db = $database;
    }

    //Funcion para convertir a objeto cualquier arreglo associativo
    protected static function ConvertirOBJ($registro) {
        $objeto = new self;

        //Iteramos sobre el registro
        foreach($registro as $key => $value):
            if(property_exists($objeto, $key)){
                $objeto->$key = $value;
            }
        endforeach;

        //Devolvemos el arreglo en formato de objeto
        return $objeto;
    }
}