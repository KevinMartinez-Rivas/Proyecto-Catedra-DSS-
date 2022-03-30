<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="../src/css/StyleApp.css">
    <title>Gestion de cuentas</title>
</head>
<body>
    <!-- SideBar (En proceso..) -->
    <aside class="Sidebar active">
        <div class="LogoSidebar">
            
        </div>
        <div class="MenuSidebar">
            <ul class="Menu-list">
                <li class="li-option">
                    <a href="index.php" class="option">
                        <span class="material-icons">home</span>
                        <p>Inicio</p>
                    </a>
                </li>
                <?php if($option1):?>
                <li class="li-option">
                    <a href="createcuenta.php" class="option">
                        <span class="material-icons">add_circle_outline</span>
                        <p>Crear Cuenta</p>
                    </a>
                </li>
                <li class="li-option">
                    <a href="deletecuenta.php" class="option">
                        <span class="material-icons">remove_circle_outline</span>
                        <p>Borrar Cuenta</p>
                    </a>
                </li>
                <li class="li-option">
                    <a href="opcionesrecargo.php" class="option">
                        <span class="material-icons">manage_accounts</span>
                        <p>Recargos</p>
                    </a>
                </li>
                <?php endif;?>
                <li class="li-option">
                    <a href="" class="option">
                        <span class="material-icons">settings</span>
                        <p>Opciones</p>
                    </a>
                </li>
                <li class="li-option">
                    <a href="" class="option">
                        <span class="material-icons">people</span>
                        <p>Creditos</p>
                    </a>
                </li>
            </ul>
        </div>
        <div class="LogoutSidebar">
            <a href="/ProyectoCatedra/login.php" class="log-out_US">
                <span class="material-icons">logout</span>
                <p>Salir</p>
            </a>
        </div>
    </aside>

    <div class="Contenido">
        <!-- Header (En proceso..) -->
        <header class="Header">
            <div class="Content-Button-Menu">
                <button class="Button-Menu">
                    <div class="top-line"></div>
                    <div class="mid-line"></div>
                    <div class="bot-line"></div>
                </button>
            </div>
        </header>