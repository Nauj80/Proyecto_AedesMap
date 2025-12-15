<?php if ($zooCria): ?>
    <div class="row bg-blue">
        <div class="col-md-6 mb-3">
            <label class="form-label">Nombre del Zoocriadero</label>
            <input type="text" name="nombre_zoocriadero" class="form-control" value="<?= $zooCria['nombre_zoocriadero'] ?>"
                minlength="5" maxlength="100" required>
            <input type="text" hidden name="id_zoocriadero" class="form-control" value="<?= $zooCria['id_zoocriadero'] ?>">
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?= $zooCria['telefono'] ?>" minlength="10"
                maxlength="10" required>
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Dirección</label>
            <input type="text" name="direccion" class="form-control" value="<?= $zooCria['direccion'] ?>" minlength="10"
                maxlength="100" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Barrio</label>
            <input type="text" name="barrio" class="form-control" value="<?= $zooCria['barrio'] ?>" minlength="3" required>
        </div>

        <div class="col-md-6 mb-3">
            <label class="form-label">Correo</label>
            <input type="email" name="correo" class="form-control" value="<?= $zooCria['correo'] ?>" minlength="10"
                maxlength="150" required>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning">No se encontró información</div>
<?php endif; ?>