<?php
if (empty($busqueda)) {  // Cambié a empty() para detectar null o array vacío
?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        No se encontraron resultados para la búsqueda
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php
} else {
    foreach ($busqueda as $tanque) {
        
    ?>
        <tr>
            <td class="sorting_1"><?php echo $tanque["zoocriadero"]; ?></td>
            <td class="sorting_1"><?php echo $tanque["nombre"]; ?></td>
            <td class="sorting_1"><?php echo $tanque["tipo_tanque"]; ?></td>
            <td class="sorting_1"><?php echo $tanque["cantidad_peces"]; ?></td>
            <td class="sorting_1"><?php echo $tanque["ancho"]; ?></td>
            <td class="sorting_1"><?php echo $tanque["alto"]; ?></td>
            <td class="sorting_1"><?php echo $tanque["profundo"]; ?></td>
            <td class="sorting_1"><?php echo $tanque["estado"]; ?></td>

                <td class="text-center">
                    <div class="form-button-action gap-3">

                        <?php
                        if (tieneAccion("Tanques", "Editar")) {
                        ?>
                            <a class="btn btn-primary" href=' <?php echo getUrl("Tanque", "Tanque", "getUpdate", array("id" => $tanque['id_tanque'])) ?>'>
                                Editar
                            </a>
                        <?php } ?>

                        <?php
                        if ($tanque['id_estado_tanque'] == 1) {
                            if (tieneAccion("Tanques", "Inhabilitar")) {
                        ?>
                                <a class="btn btn-danger" href='<?php echo getUrl("Tanque", "Tanque", "getDelete", array("id" => $tanque['id_tanque'])) ?>'>
                                    Inhabilitar
                                </a>
                            <?php
                            }
                        } else if ($tanque['id_estado_tanque'] == 2) {
                            ?>
                            <?php
                            if (tieneAccion("Tanques", "Habilitar")) {
                            ?>
                                <form class="form-habilitar" action="<?php echo getUrl("Tanque", "Tanque", "postUpdateStatus") ?>" method="post">
                                    <input type="hidden" name="id_tanque" value="<?php echo $tanque['id_tanque'] ?>">
                                    <button type="submit" class="btn btn-info">
                                        Habilitar
                                    </button>
                                </form>
                        <?php
                            }
                        }
                        ?>


                    </div>
                </td>
            <?php } ?>
        </tr>
<?php
}
?>