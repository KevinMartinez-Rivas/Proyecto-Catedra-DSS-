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
                <div class="Datoscuenta">
                    <p class="NCuenta">N°Cuenta: <span><?php echo $cuenta->NumeroCuenta; ?></span></p>
                    <p>Tipo de cuenta: <span><?php if($cuenta->CodigoTipoCuenta == 'AHR'): echo 'Ahorro'; elseif ($cuenta->CodigoTipoCuenta == 'EMP'): echo 'Empresarial'; else: echo 'Personal'; endif;?></span></p>
                    <p>Saldo: <span><?php echo $cuenta->Saldo . '$'; ?></span></p>
                </div>
                <div class="hidecuenta">
                    <p class="hidetext">Administrar</p>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</main>


    </div>
</body>
    <script src="../src/js/Menu-Button.js"></script>
</html>