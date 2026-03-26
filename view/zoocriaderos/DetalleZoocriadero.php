<?php if ($zooCria): ?>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Nombre:</strong> <?= $zooCria['nombre_zoocriadero'] ?></p>
            <p><strong>Encargado:</strong> <?= $zooCria['nombre_usuario'] ?></p>
            <p><strong>Dirección:</strong> <?= $zooCria['direccion'] ?></p>
        </div>
        <div class="col-md-6">
            <p><strong>Teléfono:</strong> <?= $zooCria['telefono'] ?></p>
            <p><strong>Barrio:</strong> <?= $zooCria['barrio'] ?></p>
            <p><strong>Correo:</strong> <?= $zooCria['correo'] ?></p>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning">No se encontró información</div>
<?php endif; ?>