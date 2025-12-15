<?php
include_once 'modales/formEditar.php';
include_once 'modales/inhabilitar.php';
?>

<div class="mt-3">
    <div class="display-4">
        Lista de tipo de actividades
    </div>
    <div class="table-responsive mt-5">
        <?php if (isset($_SESSION['success_message'])): /* ... Mensajes de éxito ... */ endif; ?>
        <?php if (isset($_SESSION['error'])): /* ... Mensajes de error ... */ endif; ?>

        <table class="table table-stripper table-hover">
            <thead>
                <th>Id</th>
                <th>Nombre actividad</th>
                <th>Estado</th>
                <?php
                    // Muestra la columna "Acciones" si tiene AL MENOS UN permiso
                    if (tieneAccion("Tipo de actividades", "Editar") || tieneAccion("Tipo de actividades", "Inhabilitar") || tieneAccion("Tipo de actividades", "Habilitar")) {
                        ?>
                        <th>Acciones</th>
                        <?php
                    }
                ?>
            </thead>
            <tbody>
                <?php
                    $modulo = "Tipo de actividades"; // Definimos el módulo para claridad
                    foreach($actividades as $actividad){
                        echo "<tr>";
                            echo "<td>".$actividad['id_actividad']."</td>";
                            echo "<td>".$actividad['nombre_actividad']."</td>";
                            echo "<td>".$actividad['nombre_estado']."</td>";
                            
                            // Solo mostrar la columna TD si tiene algún permiso
                            if (tieneAccion($modulo, "Editar") || tieneAccion($modulo, "Inhabilitar") || tieneAccion($modulo, "Habilitar")) {
                                echo "<td>";
                                    echo "<div class='d-flex flex-wrap gap-1'>";
                                    
                                        // Botón Editar
                                        if (tieneAccion($modulo, "Editar")) {
                                            echo "<button type='button' class='btn btn-primary btn-md btn-editar-actividad' 
                                                data-url='".getUrl("tipoActividades","tipoActividades","editar",array("id"=>$actividad['id_actividad']), "ajax")."'>
                                                Editar
                                            </button>";
                                        }

                                        if ($actividad['id_estado_actividad'] == 1) {
                                            // Botón Inhabilitar
                                            if (tieneAccion($modulo, "Inhabilitar")) {
                                                echo "<button type='button' 
                                                    class='btn btn-danger btn-md' 
                                                    data-bs-toggle='modal' 
                                                    data-bs-target='#modalInhabilitarActividad' 
                                                    data-id='" . $actividad['id_actividad'] . "'>
                                                    Inhabilitar
                                                </button>";
                                            }
                                        } elseif ($actividad['id_estado_actividad'] == 2) {
                                            // Botón Habilitar
                                            if (tieneAccion($modulo, "Habilitar")) {
                                                echo "<a href='".getUrl("tipoActividades","tipoActividades","updateStatus",array("id"=>$actividad['id_actividad']))."' class='btn btn-success'>Habilitar</a>";
                                            }
                                        }
                                    echo "</div>";
                                echo "</td>";
                            }
                        echo "</tr>";
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>