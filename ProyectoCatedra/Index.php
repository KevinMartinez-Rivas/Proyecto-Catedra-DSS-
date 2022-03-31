<?php
    require("includes/functions.php");

    IncluirTemplate("header", true, true);
?>

    <!-- Main (Finalizado) -->
    <main>
        <!-- SeccionCuentas (Finalizado) -->
        <section class="SeccionCuentas">
            <h2 class="TituloCuentas">Tipos de Cuentas</h2>

            <div class="ContenedorCards">
                <div class="Card">
                    <div class="Cont-Card PortadaCard">
                    <span class="material-icons">person_outline</span>
                        <p>Cuenta personal</p>
                    </div>
                    <div class="Cont-Card InformacionCard">
                        <p></p>
                    </div>
                </div>
                <div class="Card">
                    <div class="Cont-Card PortadaCard">
                    <span class="material-icons">business</span>
                        <p>Cuenta empresarial</p>
                    </div>
                    <div class="Cont-Card InformacionCard">
                        <p></p>
                    </div>
                </div>
                <div class="Card">
                    <div class="Cont-Card PortadaCard">
                    <span class="material-icons">savings</span>
                        <p>Cuenta de ahorro</p>
                    </div>
                    <div class="Cont-Card InformacionCard">
                        <p></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- SeccionInformacion (Finalizado) -->
        <section class="SeccionInformacion">
            <h2 class="TituloInformacion">Facilitamos tus procesos</h2>

            <div class="ContenedorInformacion">
                <div class="InfoBanco">
                    <h3 class="SubtituloBanco">¿Por que escogernos?</h3>
                    <p>Nuestra forma de trabajar para nuestros usuarios es siempre en beneficio de ellos, es por eso que brindamos apoyo para aquellos que no tienen tiempo de trasladarse a su banco más cercano. Aseguramos que nuestros clientes puedan realizar sus procesos transaccionales de una manera más práctica, sencilla y totalmente segura. Simplemente cree una cuenta única en nuestro sitio web para ser autorizado y podrá comenzar a abrir cuentas bancarias.</p>
                </div>

                <div class="LogoBanco">
                    <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 1920 1080" style="enable-background:new 0 0 1920 1080;" xml:space="preserve">
	                    <text>
		                    <tspan x="0" y="0" class="Titulo">Banco</tspan>
		                    <tspan x="0" y="210" class="Titulo">Nombre</tspan>
	                    </text>
                    </svg>
                </div>
            </div>
        </section>

        <!-- SeccionServicios (Finalizado) -->
        <section class="SeccionServicios">
            <h2 class="TituloServicios">Nuestros servicios</h2>
            <div class="ContenedorServicios">
                <div class="Cont-Servicio">
                <span class="material-icons">devices</span>
                    <p>Accede a nuestra aplicación web desde el dispositivo que quieras.</p>
                </div>
                <div class="Cont-Servicio">
                <span class="material-icons">credit_score</span>
                    <p>Hasta 75 transacciones sin cargo por monto adicional.</p>
                </div>
                <div class="Cont-Servicio">
                <span class="material-icons">account_tree</span>
                    <p>Manejo de multiples cuentas: ahorro, personal y empresarial.</p>
                </div>
                <div class="Cont-Servicio">
                <span class="material-icons">watch_later</span>
                    <p>Brindamos servicio a nuestros usuarios las 24 horas del dia.</p>
                </div>
                <div class="Cont-Servicio">
                <span class="material-icons">admin_panel_settings</span>
                    <p>Trabajamos para proteger tu dinero de multiples formas distintas.</p>
                </div>
                <div class="Cont-Servicio">
                <span class="material-icons">transform</span>
                    <p>Transfiere tu dinero a la cuenta que quieras en el momento que quieras.</p>
                </div>
            </div>
        </section>
    </main>

<!-- Footer (Finalizado) -->
<?php IncluirTemplate("footer"); ?>