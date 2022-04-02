<?php
    require("../includes/app.php");
    use BancoNombre\Recargo;
    use BancoNombre\Cuenta;
    use BancoNombre\Historial;

    //Autenticamos sesion
    AutenticarSession();

    //Mandan a llamar a las funciones estaticas dentro de las clases
    $cuenta = Cuenta::getOneCuenta($_GET['NumeroCuenta']);
    $recargos = Recargo::getAllRecargos();

    //generamos el registro de transaccion y lo almacenamos en el historial
    $arregloInfoTransaccion['CodigoTipoTransaccion'] = 'CON';
    $arregloInfoTransaccion['NumeroCuenta'] = $cuenta->NumeroCuenta;
    $arregloInfoTransaccion['Monto'] = '0';
    $arregloInfoTransaccion['FechaHora'] = date("Y-m-d H:i:s"); 
    $arregloInfoTransaccion['Descripcion'] = 'Consultar saldo actual de la cuenta';

    //Instancia de objeto historial o registro de historial
    $historial = new Historial($arregloInfoTransaccion);

    //Sumamos una operacion
    $NewOperaciones = $cuenta->NumeroOperaciones + 1;
    Cuenta::SetOperaciones($NewOperaciones, $cuenta->NumeroCuenta);

    //Almacenamos los datos
    $historial->AlmacenarTransaccion();

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

    IncluirTemplate("sidebarcuenta", false, false);
?>

<main>
  <div class="Contenedor-TituloAdmin gr">
    <h2 class="TituloAdmin gr">Mostrar saldo</h2>
  </div>

  <div class="Mostrar-Saldo">
    <h3>Su saldo actual:</h3>
    <p><?php echo $cuenta->Saldo;?>$</p>
  </div>
</main>


    </div>
</body>
    <script src="../src/js/Menu-Button.js"></script>
</html>