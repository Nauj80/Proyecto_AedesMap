<?php
include_once 'modales/verDetalle.php';
include_once 'modales/editar.php';
?>
<?php
if (empty($zooCria)) {  // Cambié a empty() para detectar null o array vacío
    ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        No se encontraron resultados para la búsqueda
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php
} else {
    foreach ($zooCria as $zoocriadero) {
        ?>
        <tr>
            <td><?= $zoocriadero['nombre_zoocriadero'] ?></td>
            <td><?= $zoocriadero['nombre_usuario'] ?></td>
            <td><?= $zoocriadero['direccion'] ?></td>
            <td><?= $zoocriadero['telefono'] ?></td>
            <td><?= $zoocriadero['barrio'] ?></td>
            <td><?= $zoocriadero['correo'] ?></td>
            <?php
            // Verificar si tiene alguna acción
            if (tieneAccion("Zoocriaderos", "Ver_detalle") || tieneAccion("Zoocriaderos", "Editar") || tieneAccion("Zoocriaderos", "Inhabilitar")) {
                ?>
                <td class="text-center">
                    <div class="d-flex gap-2 justify-content-center flex-nowrap">
                        <?php
                        if (tieneAccion("Zoocriaderos", "Ver_detalle")) {
                            ?>
                            <button id="verDetalle" type="button" class="btn btn-success btn-sm btn-ver-detalle" data-bs-toggle="modal"
                                data-bs-target="#modalVerDetalle"
                                data-url="<?= getUrl("Zoocriadero", "Zoocriadero", "verDetalle", array("id_zoocriadero" => $zoocriadero['id_zoocriadero']), "ajax"); ?>">
                                Ver Detalle
                            </button>
                        <?php } ?>
                        <?php
                        if (tieneAccion("Zoocriaderos", "Editar")) {
                            ?>
                            <button type="button" class="btn btn-warning btn-sm btn-Editar" data-bs-toggle="modal"
                                data-bs-target="#modalEditarZoocriadero"
                                data-url="<?= getUrl("Zoocriadero", "Zoocriadero", "editar", array("id_zoocriadero" => $zoocriadero['id_zoocriadero']), "ajax"); ?>">
                                Editar
                            </button>
                        <?php } ?>
                        <?php
                        if (tieneAccion("Zoocriaderos", "Inhabilitar")) {
                            $texto = $zoocriadero['id_estado_zoocriadero'] == 1 ? 'Inhabilitar' : 'Habilitar';
                            ?>
                            <a href="#" class="btn btn-danger btn-sm"
                                onclick="inhabilitar(<?= $zoocriadero['id_zoocriadero'] ?>, <?= $zoocriadero['id_estado_zoocriadero'] ?>); return false;">
                                <?= $texto ?>
                            </a>
                            <?php
                        } ?>
                    </div>
                </td>
            <?php } ?>
        </tr>
        <?php
    }
}
?>