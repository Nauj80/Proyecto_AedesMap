<div class="container">
    <div class="page-inner">
        
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h2>Editar Permisos del Rol</h2>
        </div>

        <!-- FILA DE HERRAMIENTAS: BUSCADOR Y SELECTOR -->
        <div class="row mb-4">
            <!-- Columna 1: Buscador -->
            <div class="col-md-6 mb-3 mb-md-0">
                <div class="input-group">
                    <input type="text" id="buscadorPermisos" class="form-control form-control-lg" placeholder="Buscar módulo o acción (ej: 'Zoocriadero', 'Consultar')...">
                </div>
            </div>

            <!-- Columna 2: Selector de Rol -->
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-secondary text-white">Cambiar Rol:
                    </span>
                    <select class="form-control form-control-lg" id="selectorRol" onchange="cambiarRol(this)">
                        <option value="" disabled>Seleccione un rol...</option>
                        <?php 
                        if (isset($roles) && $roles) {
                            foreach ($roles as $r) {
                                // Verificamos si es el rol actual para marcarlo como seleccionado
                                $selected = ($r['id_rol'] == $id_rol) ? 'selected' : '';
                                echo '<option value="' . $r['id_rol'] . '" ' . $selected . '>' . htmlspecialchars($r['nombre']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
        </div>

        <?php
        // Preparar un array para verificar permisos actuales de forma rápida
        $permisosActuales = array();
        if (isset($permisos) && $permisos) {
            foreach ($permisos as $p) {
                $permisosActuales[$p['id_modulo']][$p['id_accion']] = true;
            }
        }
        ?>
        
        <form method="POST" action="index.php?modulo=GestionRoles&controlador=GestionRoles&funcion=guardarPermisos">
            <!-- Input oculto con el ID del rol que estamos editando -->
            <input type="hidden" name="id_rol" value="<?php echo $id_rol; ?>">
            
            <!-- CONTENEDOR DE TARJETAS -->
            <div class="row" id="contenedorModulos">
                <?php if(isset($modulosDisponibles) && $modulosDisponibles): ?>
                    <?php foreach ($modulosDisponibles as $modulo): ?>
                        <!-- Agregamos la clase 'modulo-item' para identificarlo con JS -->
                        <div class="col-md-6 col-lg-4 mb-4 modulo-item">
                            <div class="card h-100 shadow-sm border-0">
                                <div class="card-header bg-light">
                                    <h5 class="card-title mb-0 text-primary font-weight-bold">
                                        <i class="fas fa-layer-group mr-2"></i> 
                                        <?php echo htmlspecialchars($modulo['nombre']); ?>
                                    </h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <?php 
                                        $counter = 0; 
                                        if(isset($accionesDisponibles) && $accionesDisponibles):
                                            foreach ($accionesDisponibles as $accion): 
                                                // Salto de línea cada 3 elementos para mantener orden
                                                if ($counter % 3 == 0 && $counter != 0) echo '</div><div class="row mt-2">';
                                        ?>
                                            <div class="col-4">
                                                <div class="form-check p-0">
                                                    <div class="custom-control custom-checkbox">
                                                        <input class="form-check-input" type="checkbox" 
                                                               name="permisos[<?php echo $modulo['id_modulo']; ?>][<?php echo $accion['id_accion']; ?>]" 
                                                               value="1" 
                                                               id="accion_<?php echo $modulo['id_modulo']; ?>_<?php echo $accion['id_accion']; ?>" 
                                                               <?php if (isset($permisosActuales[$modulo['id_modulo']][$accion['id_accion']])) echo 'checked'; ?>>
                                                        <label class="form-check-label text-muted small" for="accion_<?php echo $modulo['id_modulo']; ?>_<?php echo $accion['id_accion']; ?>" style="cursor: pointer;">
                                                            <?php echo htmlspecialchars($accion['nombre']); ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php 
                                                $counter++;
                                            endforeach; 
                                        endif;
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- MENSAJE SI NO HAY RESULTADOS EN BÚSQUEDA -->
            <div id="noResultados" class="alert alert-warning text-center" style="display: none;">
                <i class="fas fa-exclamation-circle"></i> No se encontraron módulos o acciones con ese nombre.
            </div>

            <!-- BOTONES DE ACCIÓN -->
            <div class="text-center mt-4 pb-5">
                <button type="submit" class="btn btn-primary btn-lg px-5">
                    <i class="fas fa-save mr-2"></i> Guardar Cambios
                </button>
                <a href="<?php echo getUrl("GestionRoles", "GestionRoles", "listar"); ?>" class="btn btn-secondary btn-lg px-5">
                    Cancelar
                </a>
            </div>
        </form>
    </div>
</div>

<!-- SCRIPTS DE FUNCIONALIDAD -->
<script>
document.addEventListener("DOMContentLoaded", function() {
    // --- LÓGICA DEL BUSCADOR ---
    const buscador = document.getElementById('buscadorPermisos');
    const items = document.querySelectorAll('.modulo-item');
    const noResultados = document.getElementById('noResultados');

    if(buscador){
        buscador.addEventListener('keyup', function(e) {
            const termino = e.target.value.toLowerCase();
            let visibles = 0;

            items.forEach(function(item) {
                // Buscamos texto dentro de todo el bloque (título del módulo + nombres de acciones)
                const texto = item.innerText.toLowerCase();
                
                if (texto.includes(termino)) {
                    item.style.display = ''; // Mostrar
                    visibles++;
                } else {
                    item.style.display = 'none'; // Ocultar
                }
            });

            // Mostrar mensaje si no hay nada visible
            if (visibles === 0) {
                noResultados.style.display = 'block';
            } else {
                noResultados.style.display = 'none';
            }
        });
    }
});

// --- LÓGICA DE CAMBIO DE ROL ---
function cambiarRol(selectObject) {
    var idRolSeleccionado = selectObject.value;
    if (idRolSeleccionado) {
        // Construimos la URL base usando PHP y le concatenamos el ID seleccionado
        var baseUrl = "<?php echo getUrl('GestionRoles', 'GestionRoles', 'editar'); ?>";
        
        // Redireccionamos
        window.location.href = baseUrl + "&id_rol=" + idRolSeleccionado;
    }
}
</script>