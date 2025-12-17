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
            <td><?= $zoocriadero['nombre_usuario']." ".$zoocriadero['apellido_usuario'] ?></td>
            <td><?= $zoocriadero['direccion'] ?></td>
            <?php
            // Verificar si tiene alguna acción
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
                                <button type="button" class="btn btn-primary btn-md btn-Editar" data-bs-toggle="modal"
                                    data-bs-target="#modalEditarZoocriadero"
                                    data-url="<?= getUrl("Zoocriadero", "Zoocriadero", "editar", array("id_zoocriadero" => $zoocriadero['id_zoocriadero']), "ajax"); ?>">
                                    Editar
                                </button>
                            <?php } ?>
                            <button id="verDetalle" type="button" class="btn btn-info btn-md btn-ver-detalle" data-bs-toggle="modal"
                                data-bs-target="#modalVerDetalle"
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
                                    <a type="button" class="btn btn-success btn-md" href="<?php getUrl("Zoocriadero","Zoocriadero","getInhabilitar", array("id_zoocriadero" => $zoocriadero['id_zoocriadero'])); ?>"><?php echo $texto ?></a>
                                <?php  } ?>
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