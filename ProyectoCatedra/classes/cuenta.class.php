<?php

namespace BancoNombre;

class Cuenta {
    //Conexion a base de datos
    protected static $db;
    protected static $columnaDB = ['NumeroCuenta', 'CodigoUsuario', 'CodigoTipoCuenta', 'Saldo', 'Estado', 'NumeroOperaciones', 'FechaCreacionCuenta'];

    //Arreglo de Errores
    protected static $errores = [];

    //Variables publicas de clase
    public $NumeroCuenta;
    public $CodigoUsuario;
    public $CodigoTipoCuenta;
    public $Saldo;
    public $Estado;
    public $NumeroOperaciones;
    public $FechaCreacionCuenta;
    public $FechaFinalizacionCuenta;

    //Funcion Constructora
    public function __construct($args = []) {
        $this->CodigoUsuario = $args['CodigoUsuario'] ?? '';
        $this->CodigoTipoCuenta = $args['CodigoTipoCuenta'] ?? '';
        $this->Saldo = $args['Saldo'] ?? '';
        $this->Estado = $args['Estado'] ?? '';
        $this->NumeroOperaciones = $args['NumeroOperaciones'] ?? '';
        $this->FechaCreacionCuenta = $args['FechaCreacionCuenta'] ?? '';
    }

    //Funcion Para almacenar en la BD los datos
    public function AlmacenarCuenta() {
        //Arreglo de Argumentos
        $argumentos = [];
    
        //Iteramos sobre cada campo de el objeto
        foreach(self::$columnaDB as $columna):
            if($columna == 'NumeroCuenta') continue;
            $argumentos[$columna] = self::$db->escape_string($this->$columna);
        endforeach;
    
        //Creamos el query
        $query = "INSERT INTO cuenta (" . join(', ', array_keys($argumentos)) . ") VALUES ('" . join('\', \'', array_values($argumentos)) . "');";
    
        //Ejecutamos el query
        $r = self::$db->query($query);
    
        return $r;
    }

    //Mostrar todas las cuentas dentro de la BD
    public static function getAllCuentas() {
        $arregloCuentas = [];
    
        //Creamos el query
        $query = "SELECT * FROM cuenta";
    
        //Ejecutamos el query y traemos a los usuarios
        $cuentas = self::$db->query($query);
    
        //Iteramos sobre cada registro o columna para obtener cada usuario en la BD
        while($registro = $cuentas->fetch_assoc()):
            $arregloCuentas[] = self::ConvertirOBJ($registro);
        endwhile;
    
        //Liberar memoria
        $cuentas->free();

        //Devolvemos el arreglo de objetos
        return $arregloCuentas;
    }

    //Mostrar todas las cuentas dentro de la BD de una cuenta en especifico
    public static function getAllCuentasOneUser($CodigoUsuario) {
        $arregloCuentas = [];
    
        //Creamos el query
        $query = "SELECT * FROM cuenta WHERE CodigoUsuario = ${CodigoUsuario} AND estado = 1";
    
        //Ejecutamos el query y traemos a los usuarios
        $cuentas = self::$db->query($query);
    
        //Iteramos sobre cada registro o columna para obtener cada usuario en la BD
        while($registro = $cuentas->fetch_assoc()):
            $arregloCuentas[] = self::ConvertirOBJ($registro);
        endwhile;

        //Liberar memoria
        $cuentas->free();
    
        //Devolvemos el arreglo de objetos
        return $arregloCuentas;
    }

        //Mostrar todas las cuentas dentro de la BD de una cuenta en especifico
        public static function getAllCuentasAhorro($CodigoTipoCuenta) {
            $arregloCuentas = [];
        
            //Creamos el query
            $query = "SELECT * FROM cuenta WHERE CodigoTipoCuenta = '${CodigoTipoCuenta}' AND estado = 1";
        
            //Ejecutamos el query y traemos a los usuarios
            $cuentas = self::$db->query($query);
        
            //Iteramos sobre cada registro o columna para obtener cada usuario en la BD
            while($registro = $cuentas->fetch_assoc()):
                $arregloCuentas[] = self::ConvertirOBJ($registro);
            endwhile;
    
            //Liberar memoria
            $cuentas->free();
        
            //Devolvemos el arreglo de objetos
            return $arregloCuentas;
        }

    //Mostrar una cuenta en especifico
    public static function getOneCuenta($NumeroCuenta) {
        //Creamos el query
        $query = "SELECT * FROM cuenta WHERE NumeroCuenta = ${NumeroCuenta}";
    
        //Ejecutamos la consulta
        $rs = self::$db->query($query);
        $cuenta = $rs->fetch_assoc();
    
        //Pasamos a Objeto
        $cuentaOBJ = self::ConvertirOBJ($cuenta);
    
        return $cuentaOBJ;
    }

    //Eliminacion de una cuenta especifica
    public static function dropOneCuenta($NumeroCuenta1, $NumeroCuenta2 = '0', $saldo = '0',  $fechafin = '0-0-0') {
        $n1 = $NumeroCuenta1 ?? '';
        $n2 = $NumeroCuenta2 ?? '0';
        $fechafinal = self::$db->escape_string($fechafin);

        if($n2 != '0') {
            //Creamos el query 1
            $query = "UPDATE cuenta SET Saldo = ${saldo} WHERE NumeroCuenta = ${n2}";

            //Ejecutamos la consulta
            self::$db->query($query);
        }

        //Creamos el query 2
        $query = "UPDATE cuenta SET Estado = 0, Saldo = 0, FechaFinalizacionCuenta = '${fechafinal}'  WHERE NumeroCuenta = ${n1}";
    
        //Ejecutamos la consulta
        $rs = self::$db->query($query);

        return $rs;
    }

    //Editar el saldo de una cuenta especifica
    public static function SetSaldo($Saldo, $NumeroCuenta) {
        //Creamos el query
        $query = "UPDATE cuenta SET Saldo = ${Saldo} WHERE NumeroCuenta = ${NumeroCuenta}";
    
        //Ejecutamos la consulta
        $rs = self::$db->query($query);
    
        return $rs;
    }

    //Editar el numero de operaciones de una cuenta especifica
    public static function SetOperaciones($Operaciones, $NumeroCuenta) {
        //Creamos el query
        $query = "UPDATE cuenta SET NumeroOperaciones = ${Operaciones} WHERE NumeroCuenta = ${NumeroCuenta}";
    
        //Ejecutamos la consulta
        $rs = self::$db->query($query);
    
        return $rs;
    }

    
    //Obtener los errores de los datos en cuenta
    public static function getErroresCuenta() {
        return self::$errores;
    }

    //Validacion de cuenta
    public function ValidacionCuenta() {
        if(!$this->CodigoUsuario) self::$errores[] = 'Es estrictamente necesario que vincule esta cuenta a un usuario';
        if(!$this->CodigoTipoCuenta) self::$errores[] = 'Tiene que seleccionar al grupo/tipo de cuenta que pertenece la cuenta';
        if(!$this->Saldo) self::$errores[] = 'Es necesario indicar la cantidad inicial del saldo en cuenta';

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