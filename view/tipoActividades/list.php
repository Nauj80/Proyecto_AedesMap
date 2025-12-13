<div class="mt-3">
    <div class="display-4">
        Lista de tipo de actividades
    </div>
    <div class="mt-5">

        <table class="table table-stripper table-hover">
            <head>
                <th>Id</th>
                <th>Nombre actividad</th>
                <th>Estado</th>
                <th>Acciones</th>
            </head>
            <body>
                <?php

                    foreach($actividades as $actividad){
                        echo "<tr>";
                            echo "<td>".$actividad['id_actividad']."</td>";
                            echo "<td>".$actividad['nombre_actividad']."</td>";
                            echo "<td>".$actividad['nombre_estado']."</td>";
                            echo "<td>";
                                
                                echo "<div class='d-flex flex-wrap gap-1'>";
                                    echo "<a href='".getUrl("tipoActividades","tipoActividades","getUpdate",array("id"=>$actividad['id_actividad']))."' class='btn btn-primary'>Editar</a>"; echo" ";

                                    if ($actividad['id_estado_actividad'] == 1) {
                                        echo "<a href='".getUrl("tipoActividades","tipoActividades","delete",array("id"=>$actividad['id_actividad']))."' class='btn btn-danger'>Inhabilitar</a>";

                                    } elseif ($actividad['id_estado_actividad'] == 2) {
                                        echo "<a href='".getUrl("tipoActividades","tipoActividades","updateStatus",array("id"=>$actividad['id_actividad']))."' class='btn btn-success'>Habilitar</a>";
                                    }
                                echo "</div>";
                            echo "</td>";
                        echo "</tr>";    
                    }

                ?>
            </body>
        </table>
    </div>
</div>