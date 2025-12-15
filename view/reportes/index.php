<div class="page-inner">

    <h2 class="mb-4">📊 Reporte Seguimiento Zoocriaderos</h2>

    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" class="row g-3">

                <input type="hidden" name="modulo" value="Reportes">
                <input type="hidden" name="controlador" value="Reportes">
                <input type="hidden" name="funcion" value="index">

                <div class="col-md-3">
                    <label class="form-label">Fecha inicio</label>
                    <input type="date" name="fecha_inicio" class="form-control">
                </div>

                <div class="col-md-3">
                    <label class="form-label">Fecha fin</label>
                    <input type="date" name="fecha_fin" class="form-control">
                </div>

                <div class="col-md-4">
                    <label class="form-label">Zoocriadero (ID)</label>
                    <input type="number" name="zoocriadero" class="form-control" placeholder="Ej: 1">
                </div>

                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-primary w-100">Filtrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Zoocriadero</th>
                        <th>Tanque</th>
                        <th>Actividad</th>
                        <th>Fecha</th>
                        <th>Alevines</th>
                        <th>Muertes</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($reportes)): ?>
                        <?php foreach ($reportes as $r): ?>
                            <tr>
                                <td><?= $r['nombre_zoocriadero'] ?></td>
                                <td><?= $r['id_tanque'] ?></td>
                                <td><?= $r['actividad'] ?></td>
                                <td><?= $r['fecha'] ?></td>
                                <td><?= $r['num_alevines'] ?></td>
                                <td><?= $r['num_muertes'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No hay resultados
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>