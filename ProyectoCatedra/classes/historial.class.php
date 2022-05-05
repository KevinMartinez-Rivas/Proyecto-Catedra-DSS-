<?php

namespace BancoNombre;

class Historial {
    //Conexion a base de datos
    protected static $db;
    protected static $columnaDB = ['NumeroTransaccion', 'CodigoTipoTransaccion', 'NumeroCuenta', 'Monto', 'FechaHora', 'Descripcion'];

    //Arreglo de Errores
    protected static $errores = [];

    //Variables publicas de clase
    public $NumeroTransaccion;
    public $CodigoTipoTransaccion;
    public $NumeroCuenta;
    public $Monto;
    public $FechaHora;
    public $Descripcion;

    //Funcion Constructora
    public function __construct($args = []) {
        $this->NumeroTransaccion = $args['NumeroTransaccion'] ?? '';
        $this->CodigoTipoTransaccion = $args['CodigoTipoTransaccion'] ?? '';
        $this->NumeroCuenta = $args['NumeroCuenta'] ?? '';
        $this->Monto = $args['Monto'] ?? '';
        $this->FechaHora = $args['FechaHora'] ?? '';
        $this->Descripcion = $args['Descripcion'] ?? '';
    }

    //Funcion Para almacenar en la BD los datos
    public function AlmacenarTransaccion() {
        //Arreglo de Argumentos
        $argumentos = [];

        //Iteramos sobre cada campo de el objeto
        foreach(self::$columnaDB as $columna):
            if($columna == 'NumeroTransaccion') continue;
            $argumentos[$columna] = self::$db->escape_string($this->$columna);
        endforeach;

        //Creamos el query
        $query = "INSERT INTO historial (" . join(', ', array_keys($argumentos)) . ") VALUES ('" . join('\', \'', array_values($argumentos)) . "');";

        //Ejecutamos el query
        $r = self::$db->query($query);

        return $r;
    }

    //Mostrar a todas las transacciones dentro de la BD
    public static function getAllHistorial() {
        $arregloTransaccion = [];

        //Creamos el query
        $query = "SELECT * FROM historial";

        //Ejecutamos el query y traemos a los usuarios
        $transaccion = self::$db->query($query);

        //Iteramos sobre cada registro o columna para obtener cada usuario en la BD
        while($registro = $transaccion->fetch_assoc()):
            $arregloTransaccion[] = self::ConvertirOBJ($registro);
        endwhile;

        //Devolvemos el arreglo de objetos
        return $arregloTransaccion;
    }

    //Mostrar a todas las transacciones dentro de la BD
    public static function getAllHistorialOneCuenta($NumeroCuenta) {
        $arregloTransaccion = [];

        //Creamos el query
        $query = "SELECT * FROM historial WHERE NumeroCuenta = ${NumeroCuenta}";

        //Ejecutamos el query y traemos a los usuarios
        $transaccion = self::$db->query($query);

        //Iteramos sobre cada registro o columna para obtener cada usuario en la BD
        while($registro = $transaccion->fetch_assoc()):
            $arregloTransaccion[] = self::ConvertirOBJ($registro);
        endwhile;

        //Devolvemos el arreglo de objetos
        return $arregloTransaccion;
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