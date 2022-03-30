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

    if($_SERVER['REQUEST_METHOD'] == "POST"):
        //Rellenamos los campos faltantes
        $_POST['Estado'] = 1;
        $_POST['NumeroOperaciones'] = 0;
        $_POST['FechaCreacionCuenta'] = date("Y-m-d");

        //Creacion de instancia de la clase cuenta
        $cuenta = new Cuenta($_POST);

        //Validacion de cuenta
        $errores = $cuenta->ValidacionCuenta();

        //Validacion de que el usuario exista
        $users = Usuario::getAllUsuarios();

        if(!empty($_POST['CodigoUsuario'])) {
            foreach($users as $user){
                if($user->CodigoUsuario == $_POST['CodigoUsuario']) {
                    unset($errores[3]);
                    break;
                }
                else {
                    $errores[3] = 'No se ha encontrado ningun usuario con ese codigo';
                }
            }
        }

        //Validacion de saldo por tipo
        if(!empty($_POST['Saldo'])){
            switch ($_POST['CodigoTipoCuenta']):
                case 'AHR':
                        if($_POST['Saldo'] < 5) $errores[] = 'Es necesario un saldo de por lo menos 5 dolares para una cuenta de ahorro';
                    break;
                case 'EMP':
                        if($_POST['Saldo'] < 500) $errores[] = 'Es necesario un saldo de por lo menos 500 dolares para una cuenta empresarial';
                    break;
                case 'PER':
                    if($_POST['Saldo'] < 150) $errores[] = 'Es necesario un saldo de por lo menos 150 dolares para una cuenta de personal';
                    break;
            endswitch;
        }

        //Validacion para admin
        if($_POST['CodigoUsuario'] == '1') {
            $errores[] = 'El usuario administrador no puede poseer cuentas bancarias';
        }

        if(empty($errores)){

            //Almacenamos la cuenta en la BD
            $Resultado = $cuenta->AlmacenarCuenta();

            if($Resultado) {
                header('location: /ProyectoCatedra/admin/createcuenta.php?state=1');
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
    <div class="Contenedor-TituloAdmin g">
        <h2 class="TituloAdmin">Creación de cuenta bancaria</h2>
    </div>

    <div class="Contenedor-Errores">
        <?php foreach($errores as $error): ?>
        <div class="Alerta red">
        <?php echo "<span class=\"material-icons\">warning</span>"?>
        <?php echo $error; ?>
        </div>
        <?php endforeach ?>
        <?php if(isset($state)){ if($state == 1) echo '<div class="Alerta green">Cuenta creada correctamente</div>'; }?>
    </div>

    <form method="POST" class="FormularioCreate">
        <div class="Contenido-Input_CC">
            <h4 class="titulo-OptionCC">Codigo usuario</h4>
            <div>
                <label for="CodigoUsuario">Codigo:</label>
                <input type="text" name="CodigoUsuario" id="CodigoUsuario" class="inputCC">
            </div>
            <p class="info-CC">Info: Ingrese el codigo de usuario para la creacion de la cuenta</p>
        </div>
        <div class="Contenido-Input_CC">
            <h4 class="titulo-OptionCC">Saldo incial</h4>
            <div>
                <label for="Saldo">Saldo:</label>
                <input type="number" name="Saldo" id="Saldo" class="inputCC">
            </div>
            <p class="info-CC">Info: Ingrese el saldo inicial con el que contara la cuenta</p>
        </div>
        <div class="Contenido-Select_CC">
            <h4 class="titulo-OptionCC">Tipo de cuenta</h4>
            <div>
                <label for="CodigoTipoCuenta">Tipo: </label>
                <select name="CodigoTipoCuenta" id="CodigoTipoCuenta" class="Select">
                    <option value="0" selected hidden>Seleccione su opcion</option>
                    <option value="AHR">Ahorro</option>
                    <option value="EMP">Empresarial</option>
                    <option value="PER">Personal</option>
                </select>
            </div>
            <p class="info-CC">Info: Ingrese el tipo de cuenta que sera creada</p>
        </div>
        <div class="submit-CC">
            <p>Aviso: luego de realizar esta accion sera irreversible y quedara un registro de esta cuenta guardado en la base de datos, registro el cual estara enlazado al usuario especifico para el que se creo.</p>
            <div>
                <p>¿Seguro de realizar esta accion?</p>
                <input type="submit" value="Crear cuenta" class="btn-CC">
            </div>
        </div>
    </form>
</main>

    </div>
</body>
    <script src="../src/js/Menu-Button.js"></script>
</html>