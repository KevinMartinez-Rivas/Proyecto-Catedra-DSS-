<?php
    require("../includes/app.php");
    use BancoNombre\Cuenta;
    use BancoNombre\Recargo;
    use BancoNombre\Historial;

    //Autenticamos sesion
    AutenticarSession();

    //Obtenemos errores de la creacion de cuenta
    $errores = Cuenta::getErroresCuenta();

    //Verificamos si hay un estado de respuesta para imprimir un mensaje
    if(isset($_GET['state'])) {
        $state =  $_GET['state'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){

        //Para la cuenta de ahorros
        if((isset($_POST['AOperaciones']) OR isset($_POST['ARecargos'])) AND !isset($_POST['RRM'])){
            //Validar campos
            if(!$_POST['AOperaciones'] AND !$_POST['ARecargos']) $errores[] = 'Necesitas realizar por lo menos una operacion';

            if((empty($errores) AND $_POST['AOperaciones']) AND !$_POST['ARecargos']) {
                //Modificamos el numero de operaciones
                $Resultado = Recargo::SetOperaciones($_POST['AOperaciones'], 'AHR');

                if($Resultado) {
                    header('location: /ProyectoCatedra/admin/opcionesrecargo.php?state=1');
                }
                else {
                    echo "ah habido un error con el query";
                    exit;
                }
            }

            if((empty($errores) AND $_POST['ARecargos']) AND !$_POST['AOperaciones']) {
                //Modificamos el numero de operaciones
                $Resultado = Recargo::SetRecargoMensual($_POST['ARecargos']);

                if($Resultado) {
                    header('location: /ProyectoCatedra/admin/opcionesrecargo.php?state=1');
                }
                else {
                    echo "ah habido un error con el query";
                    exit;
                }
            }

            if(empty($errores) AND $_POST['ARecargos'] AND $_POST['AOperaciones']){
                //Modificamos el numero de operaciones
                $Resultado = Recargo::SetOperaciones($_POST['AOperaciones'], 'AHR');

                //Modificamos el recargo mensual
                $Resultado = Recargo::SetRecargoMensual($_POST['ARecargos']);

                if($Resultado) {
                    header('location: /ProyectoCatedra/admin/opcionesrecargo.php?state=1');
                }
                else {
                    echo "ah habido un error con el query";
                    exit;
                }
            }
        }

        //Para la cuenta empresarial
        if(isset($_POST['EOperaciones'])) {
            //Validar campos
            if(!$_POST['EOperaciones']) $errores[] = 'Necesita especificar el nuevo maximo de operaciones para la cuenta empresarial';

            if(empty($errores)) {
                //Modificamos el numero de operaciones
                $Resultado = Recargo::SetOperaciones($_POST['EOperaciones'], 'EMP');

                if($Resultado) {
                    header('location: /ProyectoCatedra/admin/opcionesrecargo.php?state=1');
                }
                else {
                    echo "ah habido un error con el query";
                    exit;
                }
            }
        }
        
        //Para la cuenta personal
        if(isset($_POST['POperaciones'])) {
            //Validar campos
            if(!$_POST['POperaciones']) $errores[] = 'Necesita especificar el nuevo maximo de operaciones para la cuenta personal';

            if(empty($errores)) {
                //Modificamos el numero de operaciones
                $Resultado = Recargo::SetOperaciones($_POST['POperaciones'], 'PER');

                if($Resultado) {
                    header('location: /ProyectoCatedra/admin/opcionesrecargo.php?state=1');
                }
                else {
                    echo "ah habido un error con el query";
                    exit;
                }
            }
        }

        //Para realizar los recargos mensuales
        if(isset($_POST['RRM'])) {
            //Traemos todos los recargos
            $recargos = Recargo::getAllRecargos();

            //Validar campos
            $today = strtotime(date('Y-m-d'));
            $month = date('m', $today);
            $day = date('d', $today);

            foreach($recargos as $recargo):
                if($recargo->CodigoCategoriaCuenta == 'AHR'):
                    $monthR =  date('m', strtotime($recargo->FechaUltimoRecargo));
                    if($recargo->Estado == '1' && $monthR == $month){
                        $errores[] = 'No es posible realizar el recargo 2 veces en el mismo mes';
                    }
                    else{
                        Recargo::SetEstado('0');
                    }
                endif;
            endforeach;

            if($day != '01') $errores[] = 'No es la fecha indicada para realizar esta accion, mejor prueba en ' . date('Y') . '-0' . date('m') + 1 . '-01';

            if(empty($errores)) {
                //obtiene todas las cuentas de ahorro y los recargos
                $Cuentas = Cuenta::getAllCuentasAhorro('AHR');
                $arregloInfoTransaccion = [];

                foreach($recargos as $recargo):
                    if($recargo->CodigoCategoriaCuenta == 'AHR') {
                        $porcentaje = $recargo->RecargoMensual / 100;

                        foreach($Cuentas as $cuenta):
                            $saldoencuenta = $cuenta->Saldo;
                            $saldoencuenta = $saldoencuenta - ($saldoencuenta * $porcentaje);

                            //Modificamos el saldo combrando el porcentaje establecido
                            $Resultado = Cuenta::SetSaldo($saldoencuenta, $cuenta->NumeroCuenta);

                            //generamos el registro de transaccion y lo almacenamos en el historial
                            $arregloInfoTransaccion['CodigoTipoTransaccion'] = 'REC';
                            $arregloInfoTransaccion['NumeroCuenta'] = $cuenta->NumeroCuenta;
                            $arregloInfoTransaccion['Monto'] = ($saldoencuenta * $porcentaje);
                            $arregloInfoTransaccion['FechaHora'] = date("Y-m-d H:i:s"); 
                            $arregloInfoTransaccion['Descripcion'] = 'Recargo mensual a las cuentas de ahorro';

                            //Instancia de objeto historial o registro de historial
                            $historial = new Historial($arregloInfoTransaccion);

                            //Almacenamos los datos
                            $result = $historial->AlmacenarTransaccion();
                        endforeach;
                    }
                endforeach;

                if($Resultado AND $result) {
                    Recargo::SetEstado('1');
                    header('location: /ProyectoCatedra/admin/opcionesrecargo.php?state=2');
                }
                else {
                    echo "ah habido un error con el query";
                    exit;
                }
            }
        }
    }

    IncluirTemplate("sidebar", true, false);
?>

<main>
    <div class="Contenedor-TituloAdmin y">
        <h2 class="TituloAdmin">Gestion de recargos y operaciones</h2>
    </div>

    <div class="Contenedor-Errores">
        <?php foreach($errores as $error): ?>
        <div class="Alerta red">
        <?php echo "<span class=\"material-icons\">warning</span>"?>
        <?php echo $error; ?>
        </div>
        <?php endforeach ?>
        <?php if(isset($state) AND empty($errores)){ if($state == 1) echo '<div class="Alerta green">Cambio realizado con exito</div>'; }?>
        <?php if(isset($state) AND empty($errores)){ if($state == 2) echo '<div class="Alerta green">Recargo mensual realizado con exito</div>'; }?>
    </div>

    <div class="Contenedor-OpcionesRecargos">
    <?php 
        $recargos = Recargo::getAllRecargos();
        
        foreach($recargos as $recargo):
    ?>
        <?php if($recargo->CodigoCategoriaCuenta == 'AHR'):?>
        <form method="POST" class="Formulario-Recargos">
            <h3 class="Titulo-Operaciones">Opciones cuenta de ahorros</h3>
            <div class="Inputs-Operaciones">
                <div>
                    <p>Maximo de operaciones actuales</p>
                    <span><?php if($recargo->CodigoCategoriaCuenta == 'AHR') echo $recargo->OperacionesDisponibles;?></span>
                </div>
                <div>
                    <label for="AOperaciones">Nuevo maximo de operaciones</label>
                    <input type="number" name="AOperaciones" class="Inp-Operaciones">
                </div>
            </div>
            <div class="Inputs-Operaciones">
                <div>
                    <p>Recargo mensual actual</p>
                    <span><?php if($recargo->CodigoCategoriaCuenta == 'AHR') echo $recargo->RecargoMensual . "%";?></span>
                </div>
                <div>
                    <label for="ARecargos">Nuevo recargo mensual</label>
                    <input type="number" name="ARecargos" class="Inp-Operaciones">
                </div>
            </div>
            <div class="Inputs-Recargos">
                <input type="submit" class="submit-Operaciones g" value="Modificar Recargos">
                <input type="submit" class="submit-Operaciones r" value="Realizar Recargo mensual" name="RRM">
            </div>
        </form>
        <?php endif;?>
        <?php if($recargo->CodigoCategoriaCuenta == 'EMP'):?>
        <form method="POST" class="Formulario-Operaciones">
            <h3 class="Titulo-Operaciones">Opciones cuenta de empresa</h3>
            <div class="Inputs-Operaciones">
                <div>
                    <p>Maximo de operaciones actuales</p>
                    <span><?php if($recargo->CodigoCategoriaCuenta == 'EMP') echo $recargo->OperacionesDisponibles;?></span>
                </div>
                <div>
                    <label for="EOperaciones">Nuevo maximo de operaciones</label>
                    <input type="number" name="EOperaciones" class="Inp-Operaciones">
                </div>
            </div>
            <div class="Inputs-Recargos">
                <input type="submit" class="submit-Operaciones g" value="Modificar Recargos">
            </div>
        </form>
        <?php endif;?>
        <?php if($recargo->CodigoCategoriaCuenta == 'PER'):?>
        <form method="POST" class="Formulario-Operaciones">
        <h3 class="Titulo-Operaciones">Opciones cuenta de personal</h3>
        <div class="Inputs-Operaciones">
                <div>
                    <p>Maximo de operaciones actuales</p>
                    <span><?php if($recargo->CodigoCategoriaCuenta == 'PER') echo $recargo->OperacionesDisponibles;?></span>
                </div>
                <div>
                    <label for="POperaciones">Nuevo maximo de operaciones</label>
                    <input type="number" name="POperaciones" class="Inp-Operaciones">
                </div>
            </div>
            <div class="Inputs-Recargos">
                <input type="submit" class="submit-Operaciones g" value="Modificar Recargos">
            </div>           
        </form>
        <?php endif;?>
    <?php endforeach; ?>
    </div>

</main>

    </div>
</body>
    <script src="../src/js/Menu-Button.js"></script>
</html>