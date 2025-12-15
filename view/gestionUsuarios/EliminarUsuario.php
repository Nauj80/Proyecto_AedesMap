    <div class="page-header">
        <h3 class="fw-bold mb-3">Eliminar usuario</h3>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <p>¿Está seguro que desea inhabilitar al usuario <strong><?php echo $usuario['documento'] . ' - ' . $usuario['nombre']; ?></strong>?</p>
                    <form action="index.php?modulo=GestionUsuarios&controlador=GestionUsuarios&funcion=postDelete" method="post">
                        <input type="hidden" name="id" value="<?php echo $usuario['id_usuario']; ?>">
                        <button class="btn btn-danger" type="submit">Eliminar</button>
                        <a class="btn btn-secondary" href="<?php echo getUrl('GestionUsuarios','GestionUsuarios','listar'); ?>">Cancelar</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
