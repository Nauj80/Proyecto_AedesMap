<?php
include_once 'modales/verDetalle.php';
include_once 'modales/editar.php';
?>
<?php
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
        //mirar si tiene algunas de las aciones que estan por dentro si no para no mostrar nada
        if (tieneAccion("Zoocriaderos", "Ver_detalle") || tieneAccion("Zoocriaderos", "Editar") || tieneAccion("Zoocriaderos", "Inhabilitar")) {
            ?>
            <td class="d-flex gap-3">
                <?php
                if (tieneAccion("Zoocriaderos", "Ver_detalle")) {
                    ?>
                    <button type="button" class="btn btn-success btn-ver-detalle" data-bs-toggle="modal"
                        data-bs-target="#modalVerDetalle"
                        data-url="<?= getUrl("Zoocriadero", "Zoocriadero", "verDetalle", array("id_zoocriadero" => $zoocriadero['id_zoocriadero']), "ajax"); ?>">
                        Ver Detalle
                    </button>
                <?php } ?>
                <?php
                if (tieneAccion("Zoocriaderos", "Editar")) {
                    ?>
                    <button type="button" class="btn btn-warning btn-Editar" data-bs-toggle="modal"
                        data-bs-target="#modalEditarZoocriadero"
                        data-url="<?= getUrl("Zoocriadero", "Zoocriadero", "editar", array("id_zoocriadero" => $zoocriadero['id_zoocriadero']), "ajax"); ?>">
                        Editar
                    </button>
                <?php } ?>
                <?php
                if (tieneAccion("Zoocriaderos", "Inhabilitar")) {
                    ?>
                    <a id="Inhabilitar"
                        href="<?= getUrl("Zoocriadero", "Zoocriadero", "Inhabilitar", ["id_zoocriadero" => $zoocriadero['id_zoocriadero']]); ?>"
                        class="btn btn-danger">Inhabilitar</a>
                <?php } ?>
            </td>
        <?php } ?>
    </tr>
    <?php
}
?>