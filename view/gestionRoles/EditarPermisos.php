<div class="container">
    <div class="page-inner">
        <h2>Editar Permisos del Rol</h2>
        <?php
        // Preparar un array para verificar permisos actuales
        $permisosActuales = array();
        if ($permisos) {
            foreach ($permisos as $p) {
                $permisosActuales[$p['id_modulo']][$p['id_accion']] = true;
            }
        }
        ?>
        <form method="POST" action="index.php?modulo=GestionRoles&controlador=GestionRoles&funcion=guardarPermisos">
            <input type="hidden" name="id_rol" value="<?php echo $id_rol; ?>">
            <div class="row">
                <?php foreach ($modulosDisponibles as $modulo): ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title"><?php echo htmlspecialchars($modulo['nombre']); ?></h5>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <?php 
                                    // Contador para columnas
                                    $counter = 0; 
                                    foreach ($accionesDisponibles as $accion): 
                                        if ($counter % 3 == 0 && $counter != 0) echo '</div><div class="row">';
                                    ?>
                                        <div class="col-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" 
                                                       name="permisos[<?php echo $modulo['id_modulo']; ?>][<?php echo $accion['id_accion']; ?>]" 
                                                       value="1" 
                                                       id="accion_<?php echo $modulo['id_modulo']; ?>_<?php echo $accion['id_accion']; ?>" 
                                                       <?php if (isset($permisosActuales[$modulo['id_modulo']][$accion['id_accion']])) echo 'checked'; ?>>
                                                <label class="form-check-label" for="accion_<?php echo $modulo['id_modulo']; ?>_<?php echo $accion['id_accion']; ?>">
                                                    <?php echo htmlspecialchars($accion['nombre']); ?>
                                                </label>
                                            </div>
                                        </div>
                                    <?php 
                                        $counter++;
                                    endforeach; 
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                <a href="#" onclick="volverAlListado();" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
<script>
    function volverAlListado() {
        // Función para volver al listado (adapta según tu lógica, ej. recargar la página o cargar otra vista)
        window.location.reload();
    }
</script>
