<?php
include_once '../lib/helpers.php';
include_once '../lib/helpersLogin.php';
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
    include_once '../view/partials/content.php';
}
echo "</div>";
echo "</div>";
include_once '../view/partials/footer.php';
echo "</div>";
echo "</div>";
include_once '../view/partials/scripts.php';
?>
<!--
<?php if (isset($_SESSION['console_log'])) { ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const botones = document.querySelectorAll('.btn-ver-detalle'); // Todos los botones con la clase
            botones.forEach(function (btn) {
                btn.addEventListener('click', function () {
                    console.group('🧠 DEBUG GLOBAL PHP');

                    <?php foreach ($_SESSION['console_log'] as $log) { ?>
                        console.log('📄 <?= isset($log['pagina']) ? $log['pagina'] : 'sin_pagina' ?>');

                        <?php if (isset($log['sql'])) { ?>
                            console.log('🧾 SQL:', <?= json_encode($log['sql']) ?>);
                        <?php } ?>

                        <?php if (isset($log['data'])) { ?>
                            console.table(<?= json_encode($log['data']) ?>);
                        <?php } ?>
                    <?php } ?>

                    console.groupEnd();
                });
            });
        });
    </script>
    <?php unset($_SESSION['console_log']);
} ?>
-->

<?php
echo "</body>";
echo "</html>";
?>