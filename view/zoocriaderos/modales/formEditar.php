<!--<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label">Nombre del Zoocriadero</label>
        <input type="text" name="nombre_zoocriadero" class="form-control" value="<?= $zooCria['nombre_zoocriadero'] ?>"
            required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" class="form-control" value="<?= $zooCria['telefono'] ?>" required>
    </div>

    <div class="col-md-12 mb-3">
        <label class="form-label">Dirección</label>
        <input type="text" name="direccion" class="form-control" value="<?= $zooCria['direccion'] ?>" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Barrio</label>
        <input type="text" name="barrio" class="form-control" value="<?= $zooCria['barrio'] ?>" required>
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Correo</label>
        <input type="email" name="correo" class="form-control" value="<?= $zooCria['correo'] ?>" required>
    </div>
</div>

<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
    <button type="submit" class="btn btn-warning">
        <i class="fas fa-save"></i> Guardar Cambios
    </button>
</div> -->
<!-- Modal Editar Zoocriadero -->
<div class="modal fade" id="modalEditarZoocriadero" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title">
                    <i class="fas fa-edit"></i> Editar Zoocriadero
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <form id="formEditarZoocriadero" method="POST">

                <div class="modal-body" id="contenidoEditar">
                    <!-- AQUÍ JS INYECTARÁ LOS CAMPOS DEL FORMULARIO -->
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>