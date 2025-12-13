<div class="mt-3 container">
    <div class="display-4 mb-4 border-bottom pb-2">
        Historial de Seguimientos por Tanque 🗓️
    </div>
    
    <div class="table-responsive mt-5">
        <table class="table table-stripper table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Fecha</th>
                    <th>Zoocriadero</th>
                    <th>Tipo tanque</th>
                    <th>Tanque</th>
                    <th>Auxiliar</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    foreach($seguimientos as $seguimiento){
                        echo "<tr>";
                            echo "<td>".$seguimiento['id_seguimiento']."</td>";
                            echo "<td>".$seguimiento['fecha']."</td>";
                            echo "<td>".$seguimiento['nombre_zoocriadero']."</td>";
                            echo "<td>".$seguimiento['nombre_tipo_tanque']."</td>";
                            echo "<td>".$seguimiento['nombre_tanque']."</td>";
                            echo "<td>".$seguimiento['nombre_responsable']."</td>";
                            echo "<td>";

                                echo "<div class='d-flex flex-wrap gap-1'>";
                                    echo "<a href='".getUrl("ActividadesSeguimiento","Actividades","getUpdate",array("id"=>$seguimiento['id_seguimiento']))."' class='btn btn-primary btn-sm'>Editar</a>";
                                    echo "<a href='".getUrl("ActividadesSeguimiento","Actividades","detalle",array("id"=>$seguimiento['id_seguimiento']))."' class='btn btn-info btn-sm'>Detalle</a>";
                                    
                                    if ($seguimiento['id_estado'] == 1) {
                                        echo "<a href='".getUrl("ActividadesSeguimiento","Actividades","delete",array("id"=>$seguimiento['id_seguimiento']))."' class='btn btn-danger btn-sm'>Inhabilitar</a>";
                                    } elseif ($seguimiento['id_estado'] == 2){
                                        echo "<a href='".getUrl("ActividadesSeguimiento","Actividades","updateStatus",array("id"=>$seguimiento['id_seguimiento']))."' class='btn btn-success btn-sm'>Habilitar</a>";
                                    }
                                echo "</div>";
                            echo "</td>";
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>