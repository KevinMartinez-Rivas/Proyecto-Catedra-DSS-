<?php

namespace BancoNombre;

class Usuario {
    //Conexion a base de datos
    protected static $db;
    protected static $columnaDB = ['CodigoUsuario', 'CodigoCategoria', 'NombreCompleto', 'NombreUsuario', 'PasswordUsuario', 'Email', 'FechaNacimiento', 'Edad', 'FechaCreacionUsuario'];

    //Arreglo de Errores
    protected static $errores = [];

    //Variables publicas de clase
    public $CodigoUsuario;
    public $CodigoCategoria;
    public $NombreCompleto;
    public $NombreUsuario;
    public $PasswordUsuario;
    public $Email;
    public $FechaNacimiento;
    public $Edad;
    public $FechaCreacionUsuario;

    //Funcion Constructora 
    public function __construct($args = []) {
        $this->CodigoUsuario = $args['CodigoUsuario'] ?? '';
        $this->CodigoCategoria = $args['CodigoCategoria'] ?? '';
        $this->NombreCompleto = $args['NombreCompleto'] ?? '';
        $this->NombreUsuario = $args['NombreUsuario'] ?? '';
        $this->PasswordUsuario = $args['PasswordUsuario'] ?? '';
        $this->Email = $args['Email'] ?? '';
        $this->FechaNacimiento = $args['FechaNacimiento'] ?? '';
        $this->Edad = $args['Edad'] ?? '';
        $this->FechaCreacionUsuario = $args['FechaCreacionUsuario'] ?? '';
    }

    //Funcion Para almacenar en la BD los datos
    public function AlmacenarUsuario() {
        //Arreglo de Argumentos
        $argumentos = [];

        //Iteramos sobre cada campo de el objeto
        foreach(self::$columnaDB as $columna):
            if($columna == 'CodigoUsuario') continue;
            $argumentos[$columna] = self::$db->escape_string($this->$columna);
        endforeach;

        //Creamos el query
        $query = "INSERT INTO usuario (" . join(', ', array_keys($argumentos)) . ") VALUES ('" . join('\', \'', array_values($argumentos)) . "');";

        //Ejecutamos el query
        $r = self::$db->query($query);

        return $r;
    }

    //Mostrar a todos los usuarios dentro de la BD
    public static function getAllUsuarios() {
        $arregloUsuarios = [];

        //Creamos el query
        $query = "SELECT * FROM usuario";

        //Ejecutamos el query y traemos a los usuarios
        $usuarios = self::$db->query($query);

        //Iteramos sobre cada registro o columna para obtener cada usuario en la BD
        while($registro = $usuarios->fetch_assoc()):
            $arregloUsuarios[] = self::ConvertirOBJ($registro);
        endwhile;

        //Devolvemos el arreglo de objetos
        return $arregloUsuarios;
    }

    //Mostrar un usuario en especifico
    public static function getOneUsuario($CodigoUsuario) {
        //Creamos el query
        $query = "SELECT * FROM usuario WHERE CodigoUsuario = ${CodigoUsuario}";

        //Ejecutamos la consulta
        $rs = self::$db->query($query);
        $usuario = $rs->fetch_assoc();

        //Pasamos a Objeto
        $usuarioOBJ = self::ConvertirOBJ($usuario);

        return $usuarioOBJ;
    }

    //Obtener los errores del usuario
    public static function getErroresUsuario() {
        return self::$errores;
    }

    //Validacion de usuario
    public function ValidacionUsuario() {
        if(!$this->NombreCompleto) self::$errores[] = 'Es necesario que ingrese su nombre completo';
        if(!$this->NombreUsuario) self::$errores[] = 'Es necesario que ingrese un nombre de usuario para poder identificarlo';
        if(!$this->PasswordUsuario) self::$errores[] = 'Es necesario que ingrese una contraseña';
        if(!$this->Email) self::$errores[] = 'Es necesario que ingrese su E-Mail para poder contactarlo';
        if(!$this->FechaNacimiento) self::$errores[] = 'Es necesario que ingrese su Fecha de nacimiento para comprobar su edad';
        
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

    // //Funcion para almacenar la contraseñas encriptada
    // public function SetPassword() {
    //     $pass = $this->PasswordUsuario;
    //     $encriptPass = password_hash($pass, PASSWORD_BCRYPT);

    //     //creamos el query
    //     $query = "UPDATE usuario SET PasswordUsuario = '${encriptPass}' WHERE CodigoUsuario = " . $this->CodigoUsuario . "";";
    // }
}