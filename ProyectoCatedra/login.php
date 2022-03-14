<?php
    require("includes/functions.php");

    IncluirTemplate('header', false, false);
?>

<main>
    <div class="ContenedorFormulario">
        <h2 class="TituloLogin">Iniciar Sesion</h2>
        <div class="Formulario">
            <form action="" method="POST" class="FormularioLogin">
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
        </div>
        <div class="Return">
            <a href="Index.php"><span class="material-icons">keyboard_return</span>Regresar</a>
        </div>
    </div>
</main>

<?php
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        if($_POST["Usuario"] == '1')$errores[] = "Usuario no valido";

        if(empty($errores)){
            header("location: /ProyectoCatedra/app/index.php");
        }
    }

    IncluirTemplate('footer', false); 
?>