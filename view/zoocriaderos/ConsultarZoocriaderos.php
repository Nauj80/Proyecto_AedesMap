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
?>
<div class="container mt-4">

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
            </tbody>
        </table>
    </div>
</div>