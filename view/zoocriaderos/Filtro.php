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
        <td class="d-flex gap-3">
            <a id="Consultar"
                href="<?= getUrl("Zoocriadero", "Zoocriadero", "consultar", ["id_zoocriadero" => $zoocriadero['id_zoocriadero']]); ?>"
                class="btn btn-success">Ver Detalle</a>
            <a id="Actualizar"
                href="<?= getUrl("Zoocriadero", "Zoocriadero", "editar", ["id_zoocriadero" => $zoocriadero['id_zoocriadero']]); ?>"
                class="btn btn-warning">Editar</a>
            <a id="Inhabilitar"
                href="<?= getUrl("Zoocriadero", "Zoocriadero", "Inhabilitar", ["id_zoocriadero" => $zoocriadero['id_zoocriadero']]); ?>"
                class="btn btn-danger">Inhabilitar</a>
        </td>
    </tr>
    <?php
}
?>