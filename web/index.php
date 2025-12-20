<?php
include_once '../lib/helpers.php';
include_once '../lib/helpersLogin.php';

/* =================================================================
   BLOQUE DE DESCARGAS (EVITA CARGAR HTML/DISEÑO)
   ================================================================= */
if (isset($_GET['modulo']) && $_GET['modulo'] == 'Reportes') {

    // CASO 1: Descarga de Actividades
    if (isset($_GET['funcion']) && $_GET['funcion'] == 'descargarSeguimiento') {
        require_once '../controller/Reportes/ReportesController.php';
        $controller = new ReportesController();
        $controller->descargarSeguimiento();
        exit;
    }

    // CASO 2: Descarga de Nacidos y Muertes (Tanques)
    if (isset($_GET['funcion']) && $_GET['funcion'] == 'descargarSeguimientoTanques') {
        require_once '../controller/Reportes/NacidosMuertesController.php';
        $controller = new NacidosMuertesController();
        $controller->descargarSeguimientoTanques();
        exit;
    }
}

/* =================================================================
   BLOQUE PARA PETICIONES AJAX (FILTROS)
   ================================================================= */
if (isset($_GET['ajax']) && $_GET['ajax'] == 'true') {
    resolve();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_GET['modulo'])) {
    resolve();
    exit;
}

/* =================================================================
   BLOQUE DE DISEÑO NORMAL (VISTAS)
   ================================================================= */
include_once '../view/partials/header.php';

echo '<body>';
echo '<div class="wrapper">';

include_once '../view/partials/sidebar.php';

echo '<div class="main-panel">';
include_once '../view/partials/navbar.php';

echo '<div class="container">';
echo '<div class="page-inner">';

if (isset($_GET['modulo'])) {
    resolve();
} else {
    include_once '../view/Mapa/visorD2.php';
}

echo '</div>';
echo '</div>';

include_once '../view/partials/footer.php';

echo '</div>';
echo '</div>';

include_once '../view/partials/scripts.php';

echo '</body>';
echo '</html>';