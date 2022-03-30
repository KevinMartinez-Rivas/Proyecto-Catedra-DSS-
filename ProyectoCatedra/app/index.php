<?php
    require("../includes/app.php");
    use BancoNombre\Cuenta;

    //Autenticamos sesion
    AutenticarSession();

    IncluirTemplate("sidebar", false, false);
?>

<main>
    <div class="Contenedor-Cuentas">
        <?php
            $cuentas = Cuenta::getAllCuentasOneUser($_SESSION['CodigoUsuario']);
            foreach($cuentas as $cuenta):
        ?>
        <a href="cuenta.php?NumeroCuenta=<?php echo $cuenta->NumeroCuenta; ?>">
            <div class="Cuenta-REG">
                <p>NumeroCuenta: <?php echo $cuenta->NumeroCuenta; ?></p>
                <p>Tipo de cuenta: <?php echo $cuenta->CodigoTipoCuenta; ?></p>
                <p>Saldo: <?php echo $cuenta->Saldo; ?>$</p>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</main>


    </div>
</body>
    <script src="../src/js/Menu-Button.js"></script>
</html>