<?php
include_once 'modales/verDetalle.php';
include_once 'modales/editar.php';
include_once 'modales/inhabilitar.php';

// Mostrar error si existe
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
    echo $_SESSION['error'];
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
    echo '</div>';
    unset($_SESSION['error']);
}

if (isset($_SESSION['success'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
    echo $_SESSION['success'];
    echo '<button type="button" class="btn-close" data-bs-dismiss="alert"></button>';
    echo '</div>';
    unset($_SESSION['success']);
}
?>
<div class="container mt-2">
    <!-- Titulo del modulo -->
    <div class="row mb-1">
        <div class="col text-left">
            <h2 class="font-monospace fw-bold fs-1"> Listado de Zoocriaderos</h2>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-5 mb-1">
            <input type="text" class="form-control" placeholder="Nombre del Zoocriadero, Encargado, Barrio, Dirección"
                id="filtro" data-url="<?php echo getUrl('Zoocriadero', 'Zoocriadero', 'filtro', false, 'ajax'); ?>">
        </div>
    </div>

    <!-- Contenedor para mensajes de éxito/error -->
    <div id="mensajeActualizacion" class="mt-3" style="display: none;"></div>

    <?php if (empty($zooCria)) { ?>
        <!-- Mostrar mensaje si no hay resultados -->
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            No se encontraron resultados para la búsqueda
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php } else { ?>
        <!-- Mostrar tabla solo si hay resultados -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="thead-custom" style="background-color: #1a87f4 !important;">
                    <tr>
                        <th>Nombre Zoocriadero</th>
                        <th>Encargado</th>
                        <th>Dirección</th>
                        <?php
                        // Verificar si tiene alguna acción para mostrar la columna
                        if (tieneAccion("Zoocriaderos", "Ver_detalle") || tieneAccion("Zoocriaderos", "Editar") || tieneAccion("Zoocriaderos", "Inhabilitar")) {
                            ?>
                            <th>Acciones</th>
                            <?php
                        }
                        ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($zooCria as $zoocriadero) {
                        ?>
                        <tr>
                            <td><?= $zoocriadero['nombre_zoocriadero'] ?></td>
                            <td><?= $zoocriadero['nombre_usuario']." ".$zoocriadero['apellido_usuario'] ?></td>
                            <td><?= $zoocriadero['direccion'] ?></td>
                            <?php
                            // Verificar si tiene alguna acción para mostrar las botones
                            if (tieneAccion("Zoocriaderos", "Ver_detalle") || tieneAccion("Zoocriaderos", "Editar") || tieneAccion("Zoocriaderos", "Inhabilitar")) {
                                ?>
                                <td class="text-center">
                                    <div class="d-flex gap-2 justify-content-center flex-nowrap">
                                        <?php
                                        if (tieneAccion("Zoocriaderos", "Ver_detalle")) {
                                            ?>
                                            <?php
                                            if (tieneAccion("Zoocriaderos", "Editar")) {
                                                ?>
                                                <button type="button" class="btn btn- btn-md btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalEditarZoocriadero"
                                                    data-url="<?= getUrl("Zoocriadero", "Zoocriadero", "editar", array("id_zoocriadero" => $zoocriadero['id_zoocriadero']), "ajax"); ?>">
                                                    Editar
                                                </button>
                                            <?php } ?>
                                            <button id="verDetalle" type="button" class="btn btn-info btn-md btn-ver-detalle"
                                                data-bs-toggle="modal" data-bs-target="#modalVerDetalle"
                                                data-url="<?= getUrl("Zoocriadero", "Zoocriadero", "verDetalle", array("id_zoocriadero" => $zoocriadero['id_zoocriadero']), "ajax"); ?>">
                                                Ver Detalle
                                            </button>
                                        <?php } ?>
                                        <?php
                                        if (tieneAccion("Zoocriaderos", "Inhabilitar")) {
                                            $texto = $zoocriadero['id_estado_zoocriadero'] == 1 ? 'Inhabilitar' : 'Habilitar';
                                            if($texto == "Inhabilitar"){
                                                ?>
                                                <button type="button" class="btn btn-danger btn-md"
                                                    data-id="<?php echo $zoocriadero['id_zoocriadero']?>"
                                                    data-estado="<?php echo $zoocriadero['id_estado_zoocriadero']?>"      
                                                    data-bs-toggle="modal" data-bs-target="#modalInhabilitarZoo">
                                                    <?php echo $texto ?>
                                                </button>
                                            <?php }else{ ?>
                                                <a type="button" class="btn btn-success btn-md" href="<?php echo getUrl("Zoocriadero","Zoocriadero","getInhabilitar", array("id_zoocriadero" => $zoocriadero['id_zoocriadero'])); ?>"><?php echo $texto ?></a>
                                          <?php  } ?>
                                            <?php
                                        } ?>
                                    </div>
                                </td>
                            <?php } ?>
                        </tr>
                        <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    <?php } ?>
</div>