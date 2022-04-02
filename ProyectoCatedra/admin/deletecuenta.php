<?php
    require("../includes/app.php");
    use BancoNombre\Cuenta;
    use BancoNombre\Usuario;

    //Autenticamos sesion
    AutenticarSession();

    //Obtenemos errores de la creacion de cuenta
    $errores = Cuenta::getErroresCuenta();

    //Verificamos si hay un estado de respuesta para imprimir un mensaje
    if(isset($_GET['state'])) {
        $state =  $_GET['state'];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'):
        //Validaciones
        if(!$_POST['NumeroCuenta1']) $errores[] = 'Es necesario indicar la cuenta que desea eliminar';
        if($_POST['NumeroCuenta2'] == $_POST['NumeroCuenta1']) $errores[] = 'No se puede abonar a la misma cuenta que sera deshabilitada';

        //Verificamos que la cuenta exista
        $cuentas = Cuenta::getAllCuentas();

        //Var Saldo
        $sumsaldo = '0';

        if(!empty($_POST['NumeroCuenta1'])) {
            foreach($cuentas as $cuenta) {
                if($cuenta->NumeroCuenta == $_POST['NumeroCuenta1']) {
                    $sumsaldo = $cuenta->Saldo;
                    unset($errores[3]);
                    break;
                }
                else {
                    $errores[3] = 'No se ha encontrado ninguna cuenta con ese codigo para poder deshabilitarla';
                }
            }
        }
        
        if(!empty($_POST['NumeroCuenta1'])) {
            foreach($cuentas as $cuenta) {
                if($cuenta->NumeroCuenta == $_POST['NumeroCuenta1']) {
                    if($cuenta->Estado == '0') {
                        $errores[5] = 'La cuenta ha deshabilitar ya se encuentra deshabilitada';
                    }
                }
            }
        }

        if(!empty($_POST['NumeroCuenta2'])) {
            foreach($cuentas as $cuenta) {
                if($cuenta->NumeroCuenta == $_POST['NumeroCuenta2']) {
                    if($cuenta->Estado == '0') {
                        $errores[5] = 'La cuenta ha abonar se encuentra deshabilitada';
                    }
                }
            }
        }

        if($_POST['NumeroCuenta2'] != '0' AND !empty($_POST['NumeroCuenta2'])) {
            foreach($cuentas as $cuenta) {
                if($cuenta->NumeroCuenta == $_POST['NumeroCuenta2']) {
                    $sumsaldo += $cuenta->Saldo;
                    unset($errores[4]);
                    break;
                }
                else {
                    $errores[4] = 'No se ha encontrado ninguna cuenta con ese codigo para poder abonarla';
                }
            }
        }

        if(empty($errores)) {
            //Procedemos a deshabulitar la cuenta y transferir el dinero
            $c1 = $_POST['NumeroCuenta1'];
            $c2 = $_POST['NumeroCuenta2'];
            $fechafin = date("Y-m-d");

            $Result = Cuenta::dropOneCuenta($c1, $c2, $sumsaldo, $fechafin);

            if($Result) {
                header('location: /ProyectoCatedra/admin/deletecuenta.php?state=1');
            }
            else {
                echo "ah habido un error con el query";
                exit;
            }
        }

    endif;

    IncluirTemplate("sidebar", true, false);
?>

<main>
    <div class="Contenedor-TituloAdmin r">
        <h2 class="TituloAdmin">Deshabilitar cuenta bancaria</h2>
    </div>

    <div class="Contenedor-Errores">
        <?php foreach($errores as $error): ?>
        <div class="Alerta red">
        <?php echo "<span class=\"material-icons\">warning</span>"?>
        <?php echo $error; ?>
        </div>
        <?php endforeach ?>
        <?php if(isset($state) AND empty($errores)){ if($state == 1) echo '<div class="Alerta green">Cuenta deshabilitada correctamente</div>'; }?>
    </div>

    <form method="POST" class="FormularioDelete">
        <div class="Contenido-Input_CC">
            <h4 class="titulo-OptionCC">Numero de cuenta (Eliminada)</h4>
            <div>
                <label for="NumeroCuenta1">Codigo:</label>
                <input type="text" name="NumeroCuenta1" id="NumeroCuenta1" class="inputCC">
            </div>
            <p class="info-CC">Info: Ingrese el codigo de cuenta que se eliminara</p>
        </div>
        <div class="Contenido-Input_CC">
            <h4 class="titulo-OptionCC">Numero de cuenta (Abonada)</h4>
            <div>
                <label for="NumeroCuenta2">Codigo: </label>
                <input type="text" name="NumeroCuenta2" id="NumeroCuenta2" class="inputCC">
            </div>
            <p class="info-CC">Info: Ingrese el codigo de cuenta a la que abonara el saldo, (0/vacio) solo en caso de retiro en efectivo</p>
        </div>
        <div class="submit-DC">
            <p>Aviso: luego de realizar esta accion sera irreversible y quedara un registro de esta cuenta guardado en la base de datos, registro el cual estara enlazado al usuario especifico para el que se creo.</p>
            <div>
                <p>¿Seguro de realizar esta accion?</p>
                <input type="submit" value="Deshabilitar cuenta" class="btn-CC">
            </div>
        </div>
    </form>
</main>

    </div>
</body>
    <script src="../src/js/Menu-Button.js"></script>
</html>