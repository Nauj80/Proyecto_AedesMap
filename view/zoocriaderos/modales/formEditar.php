<form id="formEditar" action="<?= getUrl("Zoocriadero", "Zoocriadero", "actualizar", false, "ajax"); ?>" method="POST">
    <input type="hidden" name="id_zoocriadero" value="<?= $zoo['id_zoocriadero'] ?>">
    
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label">Nombre del Zoocriadero</label>
            <input type="text" name="nombre_zoocriadero" class="form-control" value="<?= $zoo['nombre_zoocriadero'] ?>" required>
        </div>
        
        <div class="col-md-6 mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?= $zoo['telefono'] ?>" required>
        </div>
        
        <div class="col-md-12 mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control" value="<?= $zoo['direccion'] ?>" required>
        </div>
        
        <div class="col-md-6 mb-3">
            <label class="form-label">Barrio</label>
            <input type="text" name="barrio" class="form-control" value="<?= $zoo['barrio'] ?>" required>
        </div>
        
        <div class="col-md-6 mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control" value="<?= $zoo['correo'] ?>" required>
        </div>
    </div>
    
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-warning">
            <i class="fas fa-save"></i> Guardar Cambios
        </button>
    </div>
</form>