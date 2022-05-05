<?php
    require("../includes/app.php");
    use BancoNombre\Cuenta;
    use BancoNombre\Usuario;

    //Autenticamos sesion
    AutenticarSession();

    //Traemos todos los usuarios
    $Usuarios = Usuario::getAllUsuarios();
    $Cuentas = Cuenta::getAllCuentasTop(); 


    IncluirTemplate("sidebar", true, false);
?>

<main>
    <div class="Contenedor-TituloAdmin t">
        <h2 class="TituloAdmin i">Administracion de Banco Nombre</h2>
    </div>
</main>

<div class="Contenido-DashBoardAndUsers">
<section class="Contenedor-Usuarios">
    <h2>Tabla de usuarios</h2>
    <table>
        <thead>
            <tr>
                <th>Codigo Usuario</th>
                <th>Nombre de Usuario</th>
                <th>Nombre Completo</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($Usuarios as $Usuario):
                    if($Usuario->CodigoUsuario != '1'):    
            ?>
            <tr>
                <td><?php echo $Usuario->CodigoUsuario; ?></td>
                <td><?php echo $Usuario->NombreUsuario; ?></td>
                <td><?php echo $Usuario->NombreCompleto; ?></td>
            </tr>
            <?php   endif;
                    endforeach;?>
        </tbody>
    </table>
</section>

<section class="Contenedor-Usuarios">
    <h2>Dashboard de cuentas</h2>
    <table>
        <thead>
            <tr>
                <th>Codigo Cuenta</th>
                <th>Nombre de Usuario</th>
                <th>Operaciones realizadas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($Cuentas as $cuenta):?>
            <tr>
                <td><?php echo $cuenta->NumeroCuenta;?></td>
                <?php foreach($Usuarios as $Usuario)
                { 
                    if($Usuario->CodigoUsuario == $cuenta->CodigoUsuario) echo '<td>' . $Usuario->NombreUsuario . '</td>'; 
                }?>
                <td><?php echo $cuenta->NumeroOperaciones;?></td>
            </tr>
            <?php endforeach;?>
        </tbody>
    </table>
</section>
</div>
    
    </div>
</body>
    <script src="../src/js/Menu-Button.js"></script>
</html>