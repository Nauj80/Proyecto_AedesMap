<?php

    // Asumiendo que esta es la estructura correcta de datos que sí estás seleccionando
    foreach ($seguimientos as $seguimiento) {
    ?>
    <tr>
        <td><?= $seguimiento['id_seguimiento'] ?></td>
        <td><?= $seguimiento['fecha'] ?></td>
        <td><?= $seguimiento['nombre_zoocriadero'] ?></td>
        <td><?= $seguimiento['nombre_tipo_tanque'] ?></td>
        <td><?= $seguimiento['nombre_tanque'] ?></td>
        <td><?= $seguimiento['nombre_responsable'] . " " .$seguimiento['apellido_responsable'] ?></td>
        
        <td>
            <div class='d-flex flex-wrap gap-1'>
                <a href='<?php echo getUrl("ActividadesSeguimiento","Actividades","getUpdate",array("id"=>$seguimiento['id_seguimiento']))?>' class='btn btn-primary btn-sm'>Editar</a>
                
                <a href='<?php echo getUrl("ActividadesSeguimiento","Actividades","detalle",array("id"=>$seguimiento['id_seguimiento']))?>' class='btn btn-info btn-sm'>Detalle</a>
                
                <?php if ($seguimiento['id_estado'] == 1) { ?>
                    <a href='<?php echo getUrl("ActividadesSeguimiento","Actividades","delete",array("id"=>$seguimiento['id_seguimiento']))?>' class='btn btn-danger btn-sm'>Inhabilitar</a>
                <?php } elseif ($seguimiento['id_estado'] == 2){ ?>
                    <a href='<?php echo getUrl("ActividadesSeguimiento","Actividades","updateStatus",array("id"=>$seguimiento['id_seguimiento']))?>' class='btn btn-success btn-sm'>Habilitar</a>
                <?php } ?>
            </div>
        </td>
        
    </tr>
    <?php
    }
?>