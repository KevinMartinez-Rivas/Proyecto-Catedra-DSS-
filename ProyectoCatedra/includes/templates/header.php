<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="src/css/StyleIndex.css">
    <title>Banco Nombre</title>
</head>
<body>

<header class="Header">
    <div class="BarraNavegacion">
        <h4>Banco Salvadoreño</h4>
        <?php if($navHeader): ?>
        <nav>
            <a href="Index.php">Home</a>
            <a href="sobrenosotros.php">Sobre nosotros</a>
            <a href="">Creditos</a>
            <a href="login.php" class="SLform">Iniciar sesion</a>
            <a href="signup.php" class="SLform">Registrarse</a>
        </nav>
        <?php endif; ?>
    </div>

    <?php if($infoHeader):?>
    <div class="ContenedorHeader">
        <div class="InformacionHeader">
            <h2>¿Quieres crear una cuenta con nosotros?</h2>
            <p>Banco Nombre tiene como objetivo brindar el mejor servicio a sus usuarios, es por ello que con nuestro
                sistema de cuentas bancarias planeamos mejorar el modelo de transacciones, así mismo lograr que nuestros
                clientes puedan realizar transacciones desde el dispositivo y lugar que más les guste.</p>
        </div>

        <div class="ImageHeader">
            <img src="src/img/PersonaMovil.png" alt="">
            <img src="src/img/PersonaMovil2.png" alt="">
            <img src="src/img/PersonaMovil3.png" alt="">
        </div>
    </div>
    <?php endif; ?>
</header>