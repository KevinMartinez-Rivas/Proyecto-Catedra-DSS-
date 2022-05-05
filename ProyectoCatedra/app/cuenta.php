<?php
    require("../includes/app.php");
    use BancoNombre\Cuenta;
    use BancoNombre\Usuario;
    use BancoNombre\Recargo;

    //Autenticamos sesion
    AutenticarSession();

    IncluirTemplate("sidebarcuenta", false, false);
?>

<main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"></script>
    <link rel="stylesheet" href="../src/css/perfil.css">
    <script src=""></script>
    <div class="Contenedor-TituloAdmin gr">
        <h2 class="TituloAdmin gr">Inicio</h2>
    </div>

    <div class="TablaInfoUsuario">
        <img src="../src/img/Persona-Cuenta.png">
        <ul class="ListaInfo-Usuario">
            <h2>Datos de cuenta</h2>
            <?php
            $usuario = Usuario::getOneUsuario($_SESSION['CodigoUsuario']);
            $cuenta = Cuenta::getOneCuenta($_GET['NumeroCuenta']);
            $recargos = Recargo::getAllRecargos();
            ?>
            <li>Nombre completo: <span><?php echo $usuario->NombreCompleto; ?></span></li>
            <li>Correo: <span><?php echo $usuario->Email; ?></span></li>
            <li>NumeroCuenta: <span><?php echo $cuenta->NumeroCuenta; ?></span></li>
            <li>Tipo de cuenta: <span><?php echo $cuenta->CodigoTipoCuenta; ?></span></li>
        </ul>
        <div class="charts">
            <h2 class="subtitulo-InfoCuenta">Operaciones realizadas</h2>
            <?php 
                foreach($recargos as $recargo):
                if($recargo->CodigoCategoriaCuenta == $cuenta->CodigoTipoCuenta):
            ?>
                <span><?php echo $cuenta->NumeroOperaciones ?>/<?php echo $recargo->OperacionesDisponibles?></span>
            <?php endif; endforeach;?>
        </div>
        <div class="charts">
            <h2>Operaciones realizadas hoy (pendiente...)</h2>
            <span><?php echo $cuenta->NumeroOperaciones ?></span>
        </div>
    </div>
</main>
</body>
<script src="../src/js/Menu-Button.js"></script>

</html>