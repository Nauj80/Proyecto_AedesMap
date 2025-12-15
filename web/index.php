<?php
include_once '../lib/helpers.php';
include_once '../lib/helpersLogin.php';

// Si es un POST con modulo, solo resolver (para AJAX) - ANTES de cualquier output
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['modulo'])) {
    resolve();
    exit;
}

// Si es un GET con modulo pero no es POST, también puede ser AJAX en algunos casos
// Pero aquí incluimos el header porque es una solicitud GET normal
include_once '../view/partials/header.php';

echo "<body>";
echo "<div class='wrapper'>";
include_once '../view/partials/sidebar.php';
echo "<div class='main-panel'>";
include_once '../view/partials/navbar.php';
echo "<div class='container'>";
echo "<div class='page-inner'>";
if (isset($_GET['modulo'])) {
    resolve();
} else {
    include_once '../view/Mapa/visorD2.php';
}
echo "</div>";
echo "</div>";
include_once '../view/partials/footer.php';
echo "</div>";
echo "</div>";
include_once '../view/partials/scripts.php';
echo "</body>";
echo "</html>";
