<?php
    require("includes/app.php");
    use BancoNombre\Usuario;

    if(isset($_GET['state'])) {
        $state =  $_GET['state'];
    }

    IncluirTemplate('header', false, false);
?>

<main>
    <div class="ContenedorFormulario">
        <h2 class="TituloLogin">Iniciar Sesion</h2>
        <div class="Formulario">
            <form method="POST" class="FormularioLogin">
                <div>
                    <label for="Usuario">Usuario: </label>
                    <input type="text" name="Usuario" id="Usuario" class="LabelText">
                </div>
                <div>
                    <label for="password">Password: </label>
                    <input type="password" name="password" id="password" class="LabelText">
                </div>
                <input type="submit" value="Iniciar sesion" class="InputSubmit">
            </form>
            <div class="Signup">
                <p>¿No dispones de un usuario aún?</p>
                <a href="signup.php">Sign up</a>
            </div>
            <?php 
                if(isset($state)):
                    if($state == 0) echo "<h4 class=\"red\">Lo sentimos, ese usuario no existe</h4>";
                    if($state == 1) echo "<h4 class=\"green\">El usuario fue registrado con exito</h4>";
                endif;
            ?>
        </div>
        <div class="Return">
            <a href="Index.php"><span class="material-icons">keyboard_return</span>Regresar</a>
        </div>
    </div>
</main>

<?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $usuarios = Usuario::getAllUsuarios();
        foreach($usuarios as $usuario):
            if($usuario->NombreUsuario == $_POST['Usuario'] AND password_verify($_POST['password'], $usuario->PasswordUsuario) ) {

                //Iniciamos Sesion
                session_start();
                $_SESSION['login'] = true;
                $_SESSION['NombreUsuario'] = $_POST['Usuario'];
                $_SESSION['PasswordUsuario'] = $_POST['password'];
                $_SESSION['CodigoUsuario'] = $usuario->CodigoUsuario;
      
                if($usuario->CodigoCategoria == 'ADM'):
                    header("location: /ProyectoCatedra/admin/index.php");
                else:
                    header("location: /ProyectoCatedra/app/index.php");
                endif;
            }
        endforeach;
        
        if (!isset($_SESSION)) {
            header('location: /ProyectoCatedra/login.php?state=0');
        }
    }

    IncluirTemplate('footer', false); 
?>