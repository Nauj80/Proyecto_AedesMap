    <div class="page-header">
        <h3 class="fw-bold mb-3">Gestión de usuarios</h3>
        <ul class="breadcrumbs mb-3">
            <li class="nav-home">
                <a href="index.php">
                    <i class="icon-home"></i>
                </a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="">Usuarios</a>
            </li>
        </ul>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Usuarios</h4>
                        <a class="btn btn-primary btn-round ms-auto" href="<?php echo getUrl('GestionUsuarios', 'GestionUsuarios', 'getCreate'); ?>">
                            <i class="fa fa-plus"></i>
                            Crear usuario
                        </a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <table class="display table table-striped table-hover table-bordered table-sm">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Documento</th>
                                    <th>Nombre</th>
                                    <th>Teléfono</th>
                                    <th>Correo</th>
                                    <th>Rol</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($u = pg_fetch_assoc($usuarios)) {
                                    echo '<tr>' .
                                        '<td>' . $u['id_usuario'] . '</td>' .
                                        '<td>' . $u['documento'] . '</td>' .
                                        '<td>' . $u['nombre'] . ' ' . $u['apellido'] . '</td>' .
                                        '<td>' . $u['telefono'] . '</td>' .
                                        '<td>' . $u['correo'] . '</td>' .
                                        '<td>' . ($u['rol']) . '</td>' .
                                        '<td>' . ($u['estado']) . '</td>' .
                                        '<td>' .
                                        '<div class="d-flex gap-2 user-action-buttons">' .
                                            '<button type="button" class="btn btn-edit" data-id="' . $u['id_usuario'] . '" data-href="' . getUrl('GestionUsuarios', 'GestionUsuarios', 'getUpdate', array('id' => $u['id_usuario'])) . '" style="background:#1976d2;color:#fff;border:0;padding:10px 22px;border-radius:8px;font-weight:700;min-width:140px;text-align:center;display:inline-block;text-decoration:none;font-size:16px;box-shadow:0 8px 20px rgba(25,118,210,0.12)" aria-label="Editar">Editar</button>' .
                                            ($u['id_estado_usuario'] == 2 ?
                                                '<button type="button" class="btn btn-enable" data-id="' . $u['id_usuario'] . '" data-href="' . getUrl('GestionUsuarios', 'GestionUsuarios', 'postEnable', array('id' => $u['id_usuario'])) . '" style="background:#28a745;color:#fff;border:0;padding:10px 22px;border-radius:8px;font-weight:700;min-width:140px;text-align:center;display:inline-block;text-decoration:none;font-size:16px;box-shadow:0 8px 20px rgba(40,167,69,0.12)" aria-label="Habilitar">Habilitar</button>' :
                                                '<button type="button" class="btn btn-disable" data-id="' . $u['id_usuario'] . '" data-href="' . getUrl('GestionUsuarios', 'GestionUsuarios', 'getDelete', array('id' => $u['id_usuario'])) . '" style="background:#ef5350;color:#fff;border:0;padding:10px 22px;border-radius:8px;font-weight:700;min-width:140px;text-align:center;display:inline-block;text-decoration:none;font-size:16px;box-shadow:0 8px 20px rgba(239,83,80,0.12)" aria-label="Inhabilitar">Inhabilitar</button>') .
                                        '</div>' .
                                        '</td>' .
                                        '</tr>';
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div class="modal fade" id="modalEditUser" tabindex="-1" aria-labelledby="modalEditUserLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalEditUserLabel">Editar usuario</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <!-- El formulario será inyectado via JS -->
                    <div id="modalEditBody">Cargando...</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Confirmación de Inhabilitar -->
    <div class="modal fade" id="modalConfirmDisable" tabindex="-1" aria-labelledby="modalConfirmDisableLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalConfirmDisableLabel">Confirmar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <p>¿Desea inhabilitar este usuario?</p>
            <div class="d-flex justify-content-end">
              <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" id="confirmDisableBtn" class="btn btn-danger">Inhabilitar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Confirm Habilitar Modal -->
    <div class="modal fade" id="modalConfirmEnable" tabindex="-1" aria-labelledby="modalConfirmEnableLabel" aria-hidden="true">
      <div class="modal-dialog modal-sm modal-dialog-centered">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modalConfirmEnableLabel">Confirmar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
          </div>
          <div class="modal-body">
            <p>¿Desea habilitar este usuario?</p>
            <div class="d-flex justify-content-end">
              <button type="button" class="btn btn-secondary me-2" data-bs-dismiss="modal">Cancelar</button>
              <button type="button" id="confirmEnableBtn" class="btn btn-success">Habilitar</button>
            </div>
          </div>
        </div>
      </div>
    </div>
