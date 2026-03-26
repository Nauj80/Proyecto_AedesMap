
    <div class="page-header">
        <h3 class="fw-bold mb-3">Crear usuario</h3>
    </div>

    <div class="row justify-content-center mt-4 form-panel">
        <div class="col-12 col-md-8 col-lg-6">
            
            <div class="card form-card">
                <div class="card-body">
                    <form class="form-horizontal" action="index.php?modulo=GestionUsuarios&controlador=GestionUsuarios&funcion=postCreate" method="post" novalidate>
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label required">Documento</label>
                            <div class="col-sm-9">
                                <input name="documento" class="form-control numeric" inputmode="numeric" pattern="\d*" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label required">Nombre</label>
                            <div class="col-sm-9">
                                <input name="nombre" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label required">Apellido</label>
                            <div class="col-sm-9">
                                <input name="apellido" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label required">Teléfono</label>
                            <div class="col-sm-9">
                                <input name="telefono" class="form-control numeric" inputmode="numeric" pattern="\d*" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label required">Correo</label>
                            <div class="col-sm-9">
                                <input name="correo" type="email" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label required">Contraseña</label>
                            <div class="col-sm-9">
                                <input name="password" type="password" class="form-control" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label required">Rol</label>
                            <div class="col-sm-9">
                                <select name="id_rol" class="form-control" required>
                                    <option value="">-- Seleccionar --</option>
                                    <?php while ($r = pg_fetch_assoc($roles)) {
                                        echo '<option value="' . $r['id_rol'] . '">' . $r['nombre'] . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3 form-actions">
                                <button class="btn btn-primary" type="submit">Crear</button>
                                <a href="<?php echo getUrl('GestionUsuarios','GestionUsuarios','listar'); ?>" class="btn btn-secondary ms-2">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
