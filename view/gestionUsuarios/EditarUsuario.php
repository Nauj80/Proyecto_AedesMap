
    <div class="page-header">
        <h3 class="fw-bold mb-3">Editar un usuario</h3>
    </div>

    <div class="row justify-content-center mt-4 form-panel">
        <div class="col-12 col-md-8 col-lg-6">
            <div class="card form-card">
                <div class="card-body">
                    <form class="form-horizontal" action="index.php?modulo=GestionUsuarios&controlador=GestionUsuarios&funcion=postUpdate" method="post" novalidate>
                        <input type="hidden" name="id" value="<?php echo $usuario['id_usuario']; ?>">

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label required">Documento</label>
                            <div class="col-sm-9">
                                <input name="documento" class="form-control numeric" inputmode="numeric" pattern="\d*" value="<?php echo $usuario['documento']; ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label required">Nombre</label>
                            <div class="col-sm-9">
                                <input name="nombre" class="form-control" value="<?php echo $usuario['nombre']; ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label required">Apellido</label>
                            <div class="col-sm-9">
                                <input name="apellido" class="form-control" value="<?php echo $usuario['apellido']; ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label required">Teléfono</label>
                            <div class="col-sm-9">
                                <input name="telefono" class="form-control numeric" inputmode="numeric" pattern="\d*" value="<?php echo $usuario['telefono']; ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label required">Correo</label>
                            <div class="col-sm-9">
                                <input name="correo" type="email" class="form-control" value="<?php echo $usuario['correo']; ?>" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label required">Rol</label>
                            <div class="col-sm-9">
                                <select name="id_rol" class="form-control" required>
                                    <option value="">-- Seleccionar --</option>
                                    <?php while ($r = pg_fetch_assoc($roles)) {
                                        $sel = ($usuario['id_rol'] == $r['id_rol']) ? 'selected' : '';
                                        echo '<option value="' . $r['id_rol'] . '" ' . $sel . '>' . $r['nombre'] . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label required">Estado</label>
                            <div class="col-sm-9">
                                <select name="id_estado_usuario" class="form-control" required>
                                    <?php while ($s = pg_fetch_assoc($estados)) {
                                        $sel = ($usuario['id_estado_usuario'] == $s['id_estado_usuario']) ? 'selected' : '';
                                        echo '<option value="' . $s['id_estado_usuario'] . '" ' . $sel . '>' . $s['nombre'] . '</option>';
                                    } ?>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label">Nueva contraseña</label>
                            <div class="col-sm-9">
                                <input name="password" type="password" class="form-control" placeholder="Dejar en blanco para no cambiar">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-9 offset-sm-3 form-actions">
                                <button class="btn btn-primary" type="submit">Actualizar</button>
                                <a href="<?php echo getUrl('GestionUsuarios','GestionUsuarios','listar'); ?>" class="btn btn-secondary ms-2">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>