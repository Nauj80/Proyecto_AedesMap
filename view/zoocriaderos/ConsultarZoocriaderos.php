<?php
include_once 'modales/verDetalle.php';
include_once 'modales/editar.php';

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
<div class="container mt-4">

    <!-- Titulo del modulo -->
    <div class="row mb-4">
        <div class="col text-left">
            <h2 class="font-monospace fw-bold fs-1"> Listado de Zoocriaderos <i class="fas fa-fish"></i></h2>
        </div>
    </div>

    <div class="row mb-3">
        <div class="col-md-4 mb-3">
            <input type="text" class="form-control" placeholder="Buscar..." id="filtro"
                data-url="<?php echo getUrl("Zoocriadero", "Zoocriadero", "filtro", false, pagina: "ajax"); ?>">
        </div>
    </div>


    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre Zoocriadero</th>
                    <th>Encargado</th>
                    <th>Dirección</th>
                    <th>Telefono</th>
                    <th>Barrio</th>
                    <th>Correo</th>
                    <?php
                    //mirar si tiene algunas de las aciones que estan por dentro si no para no mostrar nada
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
                        <td><?= $zoocriadero['nombre_usuario'] ?></td>
                        <td><?= $zoocriadero['direccion'] ?></td>
                        <td><?= $zoocriadero['telefono'] ?></td>
                        <td><?= $zoocriadero['barrio'] ?></td>
                        <td><?= $zoocriadero['correo'] ?></td>
                        <?php
                        //mirar si tiene algunas de las aciones que estan por dentro si no para no mostrar nada
                        if (tieneAccion("Zoocriaderos", "Ver_detalle") || tieneAccion("Zoocriaderos", "Editar") || tieneAccion("Zoocriaderos", "Inhabilitar")) {
                            ?>
                            <td class="text-center">
                                <div class="d-flex gap-2 justify-content-center flex-nowrap">
                                    <?php
                                    if (tieneAccion("Zoocriaderos", "Ver_detalle")) {
                                        ?>
                                        <button type="button" class="btn btn-success btn-sm btn-ver-detalle" data-bs-toggle="modal"
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
                ?>
            </tbody>
        </table>
    </div>
</div>