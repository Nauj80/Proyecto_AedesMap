<?php if (isset($seguimientoDetalle) && $seguimientoDetalle): ?>
    
    <h5 class="mt-2 mb-3 border-bottom pb-1 text-info">Identificación del Seguimiento</h5>
    <div class="row g-3">
        <div class="col-md-6">
            <p><strong>ID Seguimiento:</strong> <?= $seguimientoDetalle['id_seguimiento'] ?></p>
            <p><strong>Fecha de Registro:</strong> <?= $seguimientoDetalle['fecha'] ?></p>
            <p><strong>Zoocriadero:</strong> <?= $seguimientoDetalle['nombre_zoocriadero'] ?></p>
        </div>
        <div class="col-md-6">
            <p>
                <strong>Estado:</strong> 
                <?php 
                    $estado = $seguimientoDetalle['nombre_estado'];
                    // Definir clase de color basada en el estado (ej. Habilitado/Activo = success, Inhabilitado/Finalizado = secondary/warning)
                    $class = ($estado == 'Habilitado' || $estado == 'Activo') ? 'success' : 'danger';
                ?>
                <span class="badge bg-<?= $class ?>"><?= $estado ?></span>
            </p>
            <p><strong>Auxiliar Responsable:</strong> <?= $seguimientoDetalle['nombre_responsable'] . ' ' . $seguimientoDetalle['apellido_responsable'] ?></p>
            <p><strong>Tipo de Tanque:</strong> <?= $seguimientoDetalle['nombre_tipo_tanque'] ?></p>
            <p><strong>Nombre del Tanque:</strong> <?= $seguimientoDetalle['nombre_tanque'] ?></p>
        </div>
    </div>

    <h5 class="mt-4 mb-3 border-bottom pb-1 text-info">Parámetros de Calidad del Agua</h5>
    <div class="row g-3">
        <div class="col-md-4">
            <p><strong>pH:</strong> <?= $seguimientoDetalle['ph'] ?></p>
        </div>
        <div class="col-md-4">
            <p><strong>Temperatura (°C):</strong> <?= $seguimientoDetalle['temperatura'] ?></p>
        </div>
        <div class="col-md-4">
            <p><strong>Cloro (ppm):</strong> <?= $seguimientoDetalle['cloro'] ?></p>
        </div>
    </div>
    
    <h5 class="mt-4 mb-3 border-bottom pb-1 text-info">Actividad y Nacimientos</h5>
    <div class="row g-3">
        <div class="col-md-4">
            <p><strong>Actividad Realizada:</strong> <?= $seguimientoDetalle['nombre_actividad'] ?></p>
        </div>
        <div class="col-md-4">
            <p><strong>N° Alevines (Nacimientos):</strong> <?= $seguimientoDetalle['num_alevines'] ?></p>
        </div>
    </div>

    <h5 class="mt-4 mb-3 border-bottom pb-1 text-info">Muertes</h5>
    <div class="row g-3">
        <div class="col-md-6">
            <p><strong>N° Muertes Hembras:</strong> <?= $seguimientoDetalle['num_muertes_hembras'] ?></p>
        </div>
        <div class="col-md-6">
            <p><strong>N° Muertes Machos:</strong> <?= $seguimientoDetalle['num_muertes_machos'] ?></p>
        </div>
    </div>

    <h5 class="mt-4 mb-3 border-bottom pb-1 text-info">Observaciones</h5>
    <div class="row g-3">
        <div class="col-12">
            <p class="alert alert-light border"><?= $seguimientoDetalle['observaciones'] ?></p>
        </div>
    </div>
    
<?php else: ?>
    <div class="alert alert-warning">No se encontró información detallada para este seguimiento.</div>
<?php endif; ?>