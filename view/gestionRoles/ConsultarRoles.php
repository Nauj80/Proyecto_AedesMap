<div class="container mt-4">
    <!-- Titulo del modulo -->
    <div class="row mb-4">
        <div class="col text-left">
            <h2 class="font-monospace fw-bold fs-1">Listado de Roles</h2>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4 mb-3">
            <input type="text" class="form-control" placeholder="Buscar..." id="filtro"
                data-url="<?php echo getUrl('GestionRoles', 'GestionRoles', 'filtro', false, 'ajax'); ?>">
        </div>
    </div>

    <!-- Contenedor para mensajes de éxito/error -->
    <div id="mensajeActualizacion" class="mt-3" style="display: none;"></div>

    <?php if (empty($roles)) { ?>
        <!-- Mostrar mensaje si no hay resultados -->
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            No se encontraron resultados para la búsqueda
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php } else { ?>
        <!-- Mostrar tabla solo si hay resultados -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-custom">
                    <tr>
                        <th>ID</th>
                        <th>NOMBRE</th>
                        <th>ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
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
                                        <a type="button" class="btn btn-info btn-sm btn-Editar"
                                            href="<?= getUrl("GestionRoles", "GestionRoles", "editar", array("id_rol" => $rol['id_rol'])); ?>">
                                            Editar
                                        </a>
                                    <?php } ?>
                                </div>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>