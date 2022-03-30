<?php
    require("../includes/app.php");
    use BancoNombre\Cuenta;
    use BancoNombre\Usuario;

    //Autenticamos sesion
    AutenticarSession();

    IncluirTemplate("sidebar", true, false);
?>

<main>
<div class="Contenedor-TituloAdmin r">
        <h2 class="TituloAdmin">Eliminar cuenta bancaria</h2>
    </div>
</main>

    </div>
</body>
    <script src="../src/js/Menu-Button.js"></script>
</html>