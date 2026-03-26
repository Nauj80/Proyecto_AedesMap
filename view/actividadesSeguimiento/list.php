<?php
include_once 'modales/verDetalle.php';
include_once 'modales/formEditar.php';
include_once 'modales/inhabilitar.php';
?>

<div class="mt-3 container">
    <div class="display-4 mb-4 border-bottom pb-2">
        Historial de Seguimientos por Tanque 🗓️
    </div>
    
    <div class="table-responsive mt-5">

        <?php 
        // CAMBIO: Usamos la sintaxis tradicional con llaves {}
        if (isset($_SESSION['success_message'])) { 
            // Aquí iría el código para mostrar el mensaje de éxito (ej: un alert de Bootstrap)
            // Ya que el código de éxito no está pegado, asumo que va aquí:
            echo '<div class="alert alert-success">' . $_SESSION['success_message'] . '</div>';
            unset($_SESSION['success_message']); // Limpiar mensaje después de mostrar
        } 
        ?>
        <?php 
        // CAMBIO: Usamos la sintaxis tradicional con llaves {}
        if (isset($_SESSION['error'])) { 
            // Aquí iría el código para mostrar el mensaje de error:
            echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
            unset($_SESSION['error']); // Limpiar mensaje después de mostrar
        } 
        ?>

        <div class="row mb-3">
            <div class="col-md-4 mb-3">
                <input type="text" class="form-control" placeholder="Buscar..." id="filtro"
                    data-url="<?php echo getUrl("ActividadesSeguimiento", "Actividades", "filtro", false, "ajax"); ?>">
            </div>
        </div>

        <table class="table table-stripper table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Fecha</th>
                    <th>Zoocriadero</th>
                    <th>Tipo tanque</th>
                    <th>Tanque</th>
                    <th>Auxiliar</th>
                    <?php
                        // Nota: El uso de 'tieneAccion' es correcto aquí
                        if (tieneAccion("Actividades en tanques", "Editar") || tieneAccion("Actividades en tanques", "Ver_detalle") || tieneAccion("Actividades en tanques", "Inhabilitar") || tieneAccion("Actividades en tanques", "Habilitar")) {
                            echo "<th>Acciones</th>";
                        }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                    $modulo = "Actividades en tanques"; // Definimos el módulo
                    foreach($seguimientos as $seguimiento){
                        echo "<tr>";
                            echo "<td>".$seguimiento['id_seguimiento']."</td>";
                            echo "<td>".$seguimiento['fecha']."</td>";
                            echo "<td>".$seguimiento['nombre_zoocriadero']."</td>";
                            echo "<td>".$seguimiento['nombre_tipo_tanque']."</td>";
                            echo "<td>".$seguimiento['nombre_tanque']."</td>";
                            echo "<td>".$seguimiento['nombre_responsable']." ".$seguimiento['apellido_responsable']."</td>";
                            
                            // Solo mostrar la columna TD si tiene algún permiso
                            if (tieneAccion($modulo, "Editar") || tieneAccion($modulo, "Ver_detalle") || tieneAccion($modulo, "Inhabilitar") || tieneAccion($modulo, "Habilitar")) {
                                echo "<td>";
                                    echo "<div class='d-flex flex-wrap gap-1'>";
                                        
                                        // Botón Editar
                                        if (tieneAccion($modulo, "Editar")) {
                                            echo "<button type='button' class='btn btn-primary btn-sm btn-editar-seguimiento' 
                                                data-url='".getUrl("ActividadesSeguimiento","Actividades","editar",array("id"=>$seguimiento['id_seguimiento']), "ajax")."'>
                                                    Editar
                                                </button>";
                                        }
                                        
                                        // Botón Detalle
                                        if (tieneAccion($modulo, "Ver_detalle")) {
                                            echo "<button type='button' class='btn btn-info btn-sm btn-ver-seguimiento' 
                                                data-url='".getUrl("ActividadesSeguimiento","Actividades","detalle",array("id"=>$seguimiento['id_seguimiento']), "ajax")."'>
                                                    Detalle
                                                </button>";
                                        }
                                        
                                        if ($seguimiento['id_estado'] == 1) {
                                            // Botón Inhabilitar
                                            if (tieneAccion($modulo, "Inhabilitar")) {
                                                echo "<button type='button' 
                                                        class='btn btn-danger btn-sm' 
                                                        data-bs-toggle='modal' 
                                                        data-bs-target='#modalInhabilitarSeguimiento' 
                                                        data-id='" . $seguimiento['id_seguimiento'] . "'>
                                                        Inhabilitar
                                                    </button>";
                                            }
                                        } elseif ($seguimiento['id_estado'] == 2){
                                            // Botón Habilitar
                                            if (tieneAccion($modulo, "Habilitar")) {
                                                echo "<a href='".getUrl("ActividadesSeguimiento","Actividades","updateStatus",array("id"=>$seguimiento['id_seguimiento']))."' class='btn btn-success btn-sm'>Habilitar</a>";
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