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
                    <a href="cuenta.php?NumeroCuenta=<?php echo $_GET['NumeroCuenta']?>" class="option">
                        <span class="material-icons">home</span>
                        <p>Inicio</p>
                    </a>
                </li>
                <li class="li-option">
                    <a href="#" class="option">
                        <span class="material-icons">payment</span>
                        <p>Depositar</p>
                    </a>
                </li>
                <li class="li-option">
                    <a href="#" class="option">
                        <span class="material-icons">account_balance_wallet</span>
                        <p>Retirar</p>
                    </a>
                </li>
                <li class="li-option">
                    <a href="#" class="option">
                        <span class="material-icons">query_stats</span>
                        <p>Mostrar saldo</p>
                    </a>
                </li>
                <li class="li-option">
                    <a href="#" class="option">
                        <span class="material-icons">receipt</span>
                        <p>Historial</p>
                    </a>
                </li>
                <li class="li-option">
                    <a href="#" class="option">
                        <span class="material-icons">people</span>
                        <p>Creditos</p>
                    </a>
                </li>
            </ul>
        </div>
        <div class="LogoutSidebar">
            <a href="/ProyectoCatedra/app/index.php" class="log-out_US">
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