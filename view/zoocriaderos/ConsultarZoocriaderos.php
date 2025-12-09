<div class="container mt-4">

    <div class="row mb-3">
        <div class="col-md-4 mb-3">
            <input type="text" class="form-control" placeholder="Buscar...">
        </div>
        <div class="col-md-4">
            <button class="btn btn-primary w-100">Buscar</button>
        </div>
    </div>


    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead class="thead-dark">
                <tr>
                    <th>Nombre Zoocriadero</th>
                    <th>Encargado</th>
                    <th>Dirección</th>
                    <th>Telefono</th>
                    <th>Barrio</th>
                    <th>Correo</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($zooCria as $zoocriadero) {
                    ?>
                    <tr>
                        <td><?= $zoocriadero['nombre_zoocriadero'] ?></td>
                        <td><?= $zoocriadero['nombre_usuario'] ?></td>
                        <td><?= $zoocriadero['direccion'] ?></td>
                        <td><?= $zoocriadero['telefono'] ?></td>
                        <td><?= $zoocriadero['barrio'] ?></td>
                        <td><?= $zoocriadero['correo'] ?></td>
                        <td class="d-flex gap-3">
                            <a id="Consultar"
                                href="<?= getUrl("Zoocriadero", "Zoocriadero", "consultar", ["id_zoocriadero" => $zoocriadero['id_zoocriadero']]); ?>"
                                class="btn btn-success">Consultar</a>
                            <a id="Actualizar"
                                href="<?= getUrl("Zoocriadero", "Zoocriadero", "editar", ["id_zoocriadero" => $zoocriadero['id_zoocriadero']]); ?>"
                                class="btn btn-warning">Editar</a>
                            <a id="Inhabilitar"
                                href="<?= getUrl("Zoocriadero", "Zoocriadero", "Inhabilitar", ["id_zoocriadero" => $zoocriadero['id_zoocriadero']]); ?>"
                                class="btn btn-danger">Inhabilitar</a>
                        </td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>

</div>