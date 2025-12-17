<?php if ($zooCria): ?>
    <div class="row">
        <div class="col-md-6">
            <p><strong>Nombre:</strong> <?= $zooCria['nombre_zoocriadero'] ?></p>
            <p><strong>Dirección:</strong> <?= $zooCria['direccion'] ?></p>
            <p><strong>Comuna:</strong> <?= $zooCria['comuna'] ?></p>
            <p><strong>Correo:</strong> <?= $zooCria['correo'] ?></p>
        </div>
        <div class="col-md-6">
            <p><strong>Estado Zoocriadero:</strong> <?= $zooCria['estado_text'] ?></p>
            <p><strong>Barrio:</strong> <?= $zooCria['barrio'] ?></p>
            <p><strong>Teléfono:</strong> <?= $zooCria['telefono'] ?></p>
            <p><strong>Encargado:</strong> <?php echo $zooCria['nombre_usuario']." ".$zooCria['apellido_usuario'] ?></p>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning">No se encontró información</div>
<?php endif; ?>