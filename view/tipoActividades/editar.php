<?php 
if ($actividadDetalle): 
?>
<div class="mt-3 container">
    <h5 class="text-info mb-3">Nombre y estado:</h5>
    
    <form class="form-validable" 
          action="<?php echo getUrl("TipoActividades","TipoActividades","actualizar")?>" 
          method="post">
        
        <input type="hidden" name="id_actividad" value="<?= $actividadDetalle['id_actividad'] ?>">

        <div class="row g-4 justify-content-center"> 
            <div class="col-12 col-lg-8">
                
                <label for="nombre"><span class="text-black">*</span> Nombre de la actividad</label>
                <input type="text" name="nombre" id="nombre" class='form-control' placeholder="(Ej: Limpieza)" required data-tipo="text" 
                       value="<?= $actividadDetalle['nombre'] ?>">
                <div id="nombreFeedback" class="invalid-feedback">
                    El campo es requerido.
                </div>
                
                <div class="mt-4">
                    <label class="form-label"><span class="text-black">*</span> Estado de la Actividad</label>
                    <select name="id_estado_actividad" class="form-control" required>
                        <?php 
                        foreach ($estadosActividad as $estado): 
                            $selected = ($estado['id_estado_actividad'] == $actividadDetalle['id_estado_actividad']) ? 'selected' : '';
                        ?>
                        <option value="<?= $estado['id_estado_actividad'] ?>" <?= $selected ?>>
                            <?= $estado['nombre'] ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
        </div> 
        
        <div class="row mt-5">
            <div class="col-12 text-center">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-edit me-2"></i> Guardar Cambios
                </button>
            </div>
        </div>
        
    </form>
</div>
<?php else: ?>
    <div class="mt-3 container">
        <div class="alert alert-danger">No se encontró la información del Tipo de Actividad para editar.</div>
    </div>
<?php endif; ?>