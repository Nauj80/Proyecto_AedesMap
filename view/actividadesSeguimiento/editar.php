<?php 
if ($seguimientoDetalle): 
?>
<form action="<?php echo getUrl("ActividadesSeguimiento", "Actividades", "actualizar", false, "ajax"); ?>" 
      method="POST" 
      id="form-editar-seguimiento">
    
    <input type="hidden" name="id_seguimiento" value="<?= $seguimientoDetalle['id_seguimiento'] ?>">
    <input type="hidden" name="id_seguimiento_detalle" value="<?= $seguimientoDetalle['id_seguimiento_detalle'] ?>">

    <div class="row">
        <h5 class="text-info mb-3">Datos Generales del Seguimiento</h5>
        <div class="col-md-6 mb-3">
            <label class="form-label">Tanque</label>
            <input type="text" class="form-control" value="<?= $seguimientoDetalle['nombre_tanque'] ?> (<?= $seguimientoDetalle['nombre_tipo_tanque'] ?>)" disabled>
        </div>
        
        <div class="col-md-6 mb-3">
            <label class="form-label">Actividad Registrada</label>
            <input type="text" class="form-control" value="<?= $seguimientoDetalle['nombre_actividad'] ?>" disabled>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label"><span class="text-black">*</span> Estado Actual</label>
            <select name="id_estado" class="form-control" required>
                <?php 
                foreach ($estados as $estado): 
                    $selected = ($estado['id_estado_seguimiento'] == $seguimientoDetalle['id_estado']) ? 'selected' : '';
                ?>
                    <option value="<?= $estado['id_estado_seguimiento'] ?>" <?= $selected ?>>
                        <?= $estado['nombre'] ?>
                    </option>
                <?php endforeach; ?>
                
            </select>
        </div>
    </div>

    <hr>
    <div class="row">
        <h5 class="text-info mb-3">Parámetros de Calidad del Agua</h5>
        
        <div class="col-md-4 mb-3">
            <label class="form-label"><span class="text-black">*</span> Cloro</label>
            <input type="number" step="0.01" name="cloro" class="form-control" value="<?= $seguimientoDetalle['cloro'] ?>">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label"><span class="text-black">*</span> PH</label>
            <input type="number" step="0.1" name="ph" class="form-control" value="<?= $seguimientoDetalle['ph'] ?>">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label"><span class="text-black">*</span> Temperatura (°C)</label>
            <input type="number" step="0.1" name="temperatura" class="form-control" value="<?= $seguimientoDetalle['temperatura'] ?>">
        </div>
    </div>
    
    <hr>
    <div class="row">
        <h5 class="text-info mb-3">Nacimientos y Muertes</h5>
        
        <div class="col-md-4 mb-3">
            <label class="form-label"><span class="text-black">*</span> N° Alevines (Nacimientos)</label>
            <input type="number" name="num_alevines" class="form-control" value="<?= $seguimientoDetalle['num_alevines'] ?>">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label"><span class="text-black">*</span> N° Muertes Hembras</label>
            <input type="number" name="num_muertes_hembras" class="form-control" value="<?= $seguimientoDetalle['num_muertes_hembras'] ?>">
        </div>

        <div class="col-md-4 mb-3">
            <label class="form-label"><span class="text-black">*</span > N° Muertes Machos</label>
            <input type="number" name="num_muertes_machos" class="form-control" value="<?= $seguimientoDetalle['num_muertes_machos'] ?>">
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12 mb-3">
            <label class="form-label"><span class="text-black">* </span>Observaciones</label>
            <textarea name="observaciones" class="form-control" rows="3"><?= $seguimientoDetalle['observaciones'] ?></textarea>
        </div>
    </div>

    <div class="modal-footer mt-4">
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </div>

</form>

<?php else: ?>
    <div class="alert alert-warning">No se encontró información del Seguimiento para editar.</div>
<?php endif; ?>