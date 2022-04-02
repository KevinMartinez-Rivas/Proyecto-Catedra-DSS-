<?php 
    require("includes/app.php");
    use BancoNombre\Usuario;

    //Obtenemos los errores
    $errores = Usuario::getErroresUsuario();

    if($_SERVER['REQUEST_METHOD'] == "POST"){
    
        //Rellenamos campos faltantes
        if(!empty($_POST['Nombre']) AND !empty($_POST['Apellido'])) $_POST['NombreCompleto'] = $_POST['Nombre'] . " " . $_POST['Apellido'] ?? "";
        $_POST['CodigoCategoria'] = 'REG';
        $_POST['FechaCreacionUsuario'] = date("Y-m-d");
        $_POST['Edad'] = date('Y')-date('Y', strtotime($_POST['FechaNacimiento']));

        //Validacion de contraseña y hash
        if($_POST['PasswordUsuario'] != $_POST['Rpassword']):
            $errores[] = 'Las contraseñas no coinciden';
       else:
           $_POST['PasswordUsuario'] = password_hash($_POST['PasswordUsuario'], PASSWORD_BCRYPT);
       endif;
    
        //Creamos una instancia de la clase
        $usuario = new Usuario($_POST);
    
        //Validamos el usuario
        $errores = $usuario->ValidacionUsuario();

        //Validacion de nombre de usuario
        $usuarios = Usuario::getAllUsuarios();
        foreach($usuarios as $user):
            if($user->NombreUsuario == $_POST['NombreUsuario']) {
                $errores[] = 'Ese nombre de usuario ya existe';
            }
        endforeach;
            
        if(empty($errores)){

            //Almacenamor en la BD
            $Resultado = $usuario->AlmacenarUsuario();

            if($Resultado) {
                header('location: /ProyectoCatedra/login.php?state=1');
            }
            else {
                echo "ah habido un error con el query";
                exit;
            }
        }
    }

    IncluirTemplate("header", false, false);
?>

<main>
    <div class="Contenedor-Errores">
        <?php foreach($errores as $error): ?>
        <div class="Alerta red">
        <?php echo "<span class=\"material-icons\">warning</span>"?>
        <?php echo $error; ?>
        </div>
        <?php endforeach ?>
    </div>
    <div class="ContenedorFormulario">
        <h2 class="TituloLogin">Registrase</h2>
        <div class="Formulario">
            <form action="" method="POST" class="FormularioLogin">
                <div>
                    <label for="Nombre">Nombres</label>
                    <input type="text" name="Nombre" id="Nombre" class="LabelText">
                </div>
                <div>
                    <label for="Apellido">Apellidos</label>
                    <input type="text" name="Apellido" id="Apellido" class="LabelText">
                </div>
                <div>
                    <label for="Email">Correo Electronico</label>
                    <input type="text" name="Email" id="Email" class="LabelText">
                </div>
                <div>
                    <label for="FechaNacimiento">Fecha de nacimiento</label>
                    <input type="date" name="FechaNacimiento" id="FechaNacimiento" class="LabelText">
                </div>
                <div>
                    <label for="NombreUsuario">Nombre de Usuario</label>
                    <input type="text" name="NombreUsuario" id="NombreUsuario" class="LabelText">
                </div>
                <div class="Input-pass">
                    <label for="PasswordUsuario">Password</label>
                    <input type="password" name="PasswordUsuario" id="PasswordUsuario" class="LabelText">
                    <span class="material-icons mostrar-password" id="Visibility1">visibility</span>
                </div>
                <div class="Input-pass">
                    <label for="Rpassword">Repite Password</label>
                    <input type="password" name="Rpassword" id="Rpassword" class="LabelText">
                    <span class="material-icons mostrar-password" id="Visibility2">visibility</span>
                </div>
                <input type="submit" value="Registrarse" class="InputSubmit">
            </form>
            <div class="Signup">
                <p>¿Ya creaste un usuario?</p>
                <a href="login.php">Log in</a>
            </div>
        </div>
        <div class="Return">
            <a href="Index.php"><span class="material-icons">keyboard_return</span>Regresar</a>
        </div>
    </div>
</main>
<script src="src/js/Show-Password.js"></script>

<?php 
    IncluirTemplate("footer"); 
?>