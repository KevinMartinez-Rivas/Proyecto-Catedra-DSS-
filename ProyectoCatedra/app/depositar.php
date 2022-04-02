<?php
  require("../includes/app.php");
  use BancoNombre\Recargo;
  use BancoNombre\Cuenta;
  use BancoNombre\Historial;

  //Autenticamos sesion
  AutenticarSession();

  //Verificamos si hay un estado de respuesta para imprimir un mensaje
  if(isset($_GET['state'])) {
    $state =  $_GET['state'];
  }

  //funciones estaticas de las clases
  $cuenta = Cuenta::getOneCuenta($_GET['NumeroCuenta']);
  $recargos = Recargo::getAllRecargos();

  //Obtenemos errores de la creacion de cuenta
  $errores = Cuenta::getErroresCuenta();

  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    //Validaciones
    if(!$_POST['Saldo']) $errores[] = 'Necesita indicar el monto a depositar en cuenta';

    if(empty($errores)) {
      $NewSaldo = $cuenta->Saldo + $_POST['Saldo'];

      //generamos el registro de transaccion y lo almacenamos en el historial
      $arregloInfoTransaccion['CodigoTipoTransaccion'] = 'DEP';
      $arregloInfoTransaccion['NumeroCuenta'] = $cuenta->NumeroCuenta;
      $arregloInfoTransaccion['Monto'] = $_POST['Saldo'];
      $arregloInfoTransaccion['FechaHora'] = date("Y-m-d H:i:s"); 
      $arregloInfoTransaccion['Descripcion'] = 'Deposito en cuenta bancaria';

      //Instancia de objeto historial o registro de historial
      $historial = new Historial($arregloInfoTransaccion);

      //Sumamos una operacion
      $NewOperaciones = $cuenta->NumeroOperaciones + 1;
      Cuenta::SetOperaciones($NewOperaciones, $cuenta->NumeroCuenta);

      //Almacenamos los datos
       $historial->AlmacenarTransaccion();

       //Actualizamos el saldo
       $Resultado = Cuenta::SetSaldo($NewSaldo, $cuenta->NumeroCuenta);
      
       foreach($recargos as $recargo) {
        if($recargo->CodigoCategoriaCuenta == $cuenta->CodigoTipoCuenta) {
          if($cuenta->NumeroOperaciones >= $recargo->OperacionesDisponibles) {
            $porcentaje = $recargo->RecargoMensual / 100;
            $saldoencuenta = $cuenta->Saldo;
            $saldoencuenta = $saldoencuenta - ($saldoencuenta * $porcentaje);
  
            //Modificamos el saldo combrando el porcentaje establecido
            Cuenta::SetSaldo($saldoencuenta, $cuenta->NumeroCuenta);
  
            //generamos el registro de transaccion y lo almacenamos en el historial
            $arregloInfoTransaccion['CodigoTipoTransaccion'] = 'REC';
            $arregloInfoTransaccion['NumeroCuenta'] = $cuenta->NumeroCuenta;
            $arregloInfoTransaccion['Monto'] = ($saldoencuenta * $porcentaje);
            $arregloInfoTransaccion['FechaHora'] = date("Y-m-d H:i:s"); 
            $arregloInfoTransaccion['Descripcion'] = 'Recargo por exceder el limite de operaciones';
  
            //Instancia de objeto historial o registro de historial
            $historial = new Historial($arregloInfoTransaccion);
  
            //Almacenamos los datos
            $historial->AlmacenarTransaccion();
          }
        }
      }

      if($Resultado) {
        header('location: /ProyectoCatedra/app/depositar.php?state=1&&NumeroCuenta=' . $cuenta->NumeroCuenta . '&&SaldoDescontado=' . $_POST['Saldo'] . '');
      }
      else {
          echo "ah habido un error con el query";
          exit;
      }
    }

  }

  IncluirTemplate("sidebarcuenta", false, false);
?>

<main>
  <div class="Contenedor-TituloAdmin gr">
    <h2 class="TituloAdmin gr">Depositar en cuenta</h2>
  </div>

  <div class="Contenedor-Errores">
        <?php foreach($errores as $error): ?>
        <div class="Alerta red">
        <?php echo "<span class=\"material-icons\">warning</span>"?>
        <?php echo $error; ?>
        </div>
        <?php endforeach ?>
        <?php if(isset($state) AND empty($errores)){ if($state == 1) echo '<div class="Alerta green">Deposito realizado exitosamente</div>'; }?>
    </div>

  <div class="Contenedor-DEP">
    <div class="SaldoActual-DEP">
      <h3>Su saldo anterior:</h3>
      <p><?php if(isset($state) AND empty($errores)){ if($state == 1){ echo $cuenta->Saldo - $_GET['SaldoDescontado'];}} else {echo '--.--';}?>$</p>
    </div>
    <form method="POST" class="NuevoSaldo-DEP">
      <h3>Depositar saldo</h3>
      <div>
        <label for="Saldo">Cantidad: </label>
        <input type="number" name="Saldo" class="Input-Saldo">
      </div>
      <input type="submit" class="Operacion-Saldo" value="Depositar Saldo">
    </form>
    <div class="Mostrar-NuevoSaldo">
      <h3>Nuevo saldo en cuenta:</h3>
      <p><?php if(isset($state) AND empty($errores)){ if($state == 1){ echo $cuenta->Saldo;}}else {echo '--.--';}?>$</p>
    </div>
  </div>
</main>


    </div>
</body>
    <script src="../src/js/Menu-Button.js"></script>
</html>