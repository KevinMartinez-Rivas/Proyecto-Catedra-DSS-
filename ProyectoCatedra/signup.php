<?php 
    require("includes/functions.php");

    IncluirTemplate("header", false, false);
?>

<main>
    <div class="ContenedorFormulario">
        <h2 class="TituloLogin">Registrase</h2>
        <div class="Formulario">
            <form action="" method="POST" class="FormularioLogin">
                <div>
                    <label for="Nombre">Nombre</label>
                    <input type="text" name="Nombre" id="Nombre" class="LabelText">
                </div>
                <div>
                    <label for="Apellido">Apellido</label>
                    <input type="text" name="Apellido" id="Apellido" class="LabelText">
                </div>
                <div>
                    <label for="Usuario">Nombre de Usuario</label>
                    <input type="text" name="Usuario" id="Usuario" class="LabelText">
                </div>
                <div>
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="LabelText">
                </div>
                <div>
                    <label for="Rpassword">Repite Password</label>
                    <input type="password" name="Rpassword" id="Rpassword" class="LabelText">
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

<?php IncluirTemplate("footer"); ?>