<?php
    require("../includes/app.php");
    use BancoNombre\Cuenta;
    use BancoNombre\Historial;

    //Autenticamos sesion
    AutenticarSession();

    IncluirTemplate("sidebarcuenta", false, false);
?>

<main>
    <div class="Contenedor-TituloAdmin gr">
        <h2 class="TituloAdmin gr">Historial de transacciones</h2>
    </div>

    <table class="Tabla-Historial">
        <thead>
            <tr class="TR-Historial">
                <th>Numero de transaccion</th>
                <th>Tipo de transaccion</th>
                <th>Numero de cuenta</th>
                <th>Monto</th>
                <th>Fecha y hora</th>
                <th>Descripcion</th>
            </tr>
        </thead>
        <tbody>
                <?php
                $Historial = Historial::getAllHistorialOneCuenta($_GET['NumeroCuenta']);

                foreach($Historial as $registro):
                ?>
                <tr class="TR-Historial">
                <td><?php echo $registro->NumeroTransaccion?></td>
                <td>
                    <?php 
                        if($registro->CodigoTipoTransaccion == 'REC') echo 'Recargo';
                        if($registro->CodigoTipoTransaccion == 'RET') echo 'Retiro';
                        if($registro->CodigoTipoTransaccion == 'CON') echo 'Consulta';
                        if($registro->CodigoTipoTransaccion == 'DEP') echo 'Deposito';
                
                    ?>
                </td>
                <td><?php echo $registro->NumeroCuenta?></td>
                <td>
                <?php
                    if($registro->CodigoTipoTransaccion == 'REC') echo '- '. $registro->Monto . '$';
                    if($registro->CodigoTipoTransaccion == 'RET') echo '- '. $registro->Monto . '$';
                    if($registro->CodigoTipoTransaccion == 'CON') echo $registro->Monto;
                    if($registro->CodigoTipoTransaccion == 'DEP') echo '+ '. $registro->Monto . '$';
                ?>
                </td>
                <td><?php echo $registro->FechaHora?></td>
                <td><?php echo $registro->Descripcion?></td>
                </tr>
                <?php endforeach;?>
        </tbody>
    </table>
 
</main>

    </div>
</body>
    <script src="../src/js/Menu-Button.js"></script>
</html>