<?php
if ($roles != false || !empty($roles)) {
    foreach ($roles as $rol) {
        ?>
        <tr>
            <td><?= $rol['id_rol'] ?></td>
            <td><?= $rol['nombre'] ?></td>
            <td class="text-center">
                <div class="d-flex gap-2 justify-content-center flex-nowrap">
                    <?php
                    if (tienePermiso("Gestión de roles", "Editar")) {
                        ?>
                        <a type="button" class="btn btn-info btn-md btn-Editar"
                            href="<?= getUrl("GestionRoles", "GestionRoles", "editar", array("id_rol" => $rol['id_rol'])); ?>">
                            Editar
                        </a>
                    <?php } ?>
                </div>
            </td>
        </tr>
        <?php
    }
} else {
    ?>
    <tr>
        <td colspan="3" class="text-center">No se encontraron roles que coincidan con la búsqueda.</td>
    </tr>
    <?php
}
?>