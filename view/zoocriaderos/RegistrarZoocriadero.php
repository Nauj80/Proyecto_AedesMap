<style>
    .form-container {
        background: transparent;
        padding: 30px;
        margin: 20px auto;
        max-width: 1200px;
    }

    .section-title {
        color: #667eea;
        border-bottom: 3px solid #667eea;
        padding-bottom: 10px;
        margin-bottom: 25px;
        font-weight: 600;
    }

    .tanque-card {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 20px;
        background: #f8f9fa;
        position: relative;
        transition: all 0.3s ease;
    }

    .tanque-card:hover {
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        border-color: #667eea;
    }

    .tanque-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        padding: 10px 15px;
        border-radius: 8px;
        margin-bottom: 15px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .btn-counter {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        font-size: 20px;
        font-weight: bold;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.3s ease;
    }

    .btn-counter:hover {
        transform: scale(1.1);
    }

    .counter-display {
        font-size: 32px;
        font-weight: bold;
        color: #667eea;
        min-width: 60px;
        text-align: center;
    }

    .btn-remove-tanque {
        position: absolute;
        top: 10px;
        right: 10px;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .form-label {
        font-weight: 600;
        color: #495057;
    }

    .btn-submit {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 12px 40px;
        font-size: 18px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    }

    .empty-state {
        text-align: center;
        padding: 40px;
        color: #6c757d;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 20px;
        opacity: 0.3;
    }

    .modal-info-adicional {
        max-width: 60%;
    }

    .info-card {
        background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        border-radius: 10px;
        padding: 20px;
        margin-bottom: 15px;
        border-left: 4px solid #667eea;
    }

    .info-card h5 {
        color: #667eea;
        margin-bottom: 10px;
        font-weight: 600;
    }

    .info-item {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        padding: 8px;
        background: white;
        border-radius: 5px;
    }

    .info-item i {
        color: #667eea;
        margin-right: 10px;
        width: 20px;
    }

    @media (max-width: 768px) {
        .modal-info-adicional {
            max-width: 95%;
        }
    }
</style>


<div class="container">
    <div class="form-container">
        <div class="row mb-4">
            <div class="col text-center">
                <h2 class="font-monospace fw-bold fs-1"> Registrar Zoocriadero <i class="fas fa-fish"></i></h2>
            </div>
        </div>

        <form id="formZoocriadero"
            data-url="<?php echo getUrl("Zoocriadero", "Zoocriadero", "guardar", false, "ajax"); ?>">
            <!-- Información del Zoocriadero -->
            <div class="mb-5">
                <h4 class="section-title">
                    <i class="fas fa-building"></i> Información del Zoocriadero
                </h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nombreZoo" class="form-label">
                            <i class="fas fa-tag"></i> Nombre del Zoocriadero *
                        </label>
                        <input type="text" class="form-control" id="nombreZoo" name="nombreZoo" required minlength="3"
                            maxlength="100" placeholder="ej: Zoocriadero La Paz">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="barrio" class="form-label">
                            <i class="fas fa-map-marker-alt"></i> Barrio *
                        </label>
                        <input type="text" class="form-control" id="barrio" name="barrio" required minlength="3"
                            maxlength="50" placeholder="ej:Los olivos">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="comuna" class="form-label">
                            <i class="fas fa-city"></i> Comuna *
                        </label>
                        <input type="text" class="form-control" id="comuna" name="comuna" value="Comuna 13" readonly>
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">
                            <i class="fas fa-location-dot"></i> Dirección Completa *
                        </label>
                        <div class="row g-2">
                            <div class="col-md-2">
                                <select class="form-select" id="tipoVia" name="tipoVia" required>
                                    <option value="">Tipo</option>
                                    <option value="Calle">Calle</option>
                                    <option value="Carrera">Carrera</option>
                                    <option value="Avenida">Avenida</option>
                                    <option value="Avenida Calle">Av. Calle</option>
                                    <option value="Avenida Carrera">Av. Carrera</option>
                                    <option value="Diagonal">Diagonal</option>
                                    <option value="Transversal">Transversal</option>
                                    <option value="Circular">Circular</option>
                                    <option value="Autopista">Autopista</option>
                                    <option value="Variante">Variante</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="numeroVia" name="numeroVia"
                                    placeholder="# Vía" required pattern="[0-9A-Za-z\s]+" maxlength="10">
                                <small class="text-muted d-block" style="font-size: 0.7rem;">Ej: 5, 10A, 6N</small>
                            </div>
                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                <span class="fw-bold">#</span>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="numeroPlaca" name="numeroPlaca"
                                    placeholder="# Placa" required pattern="[0-9A-Za-z\s]+" maxlength="10">
                                <small class="text-muted d-block" style="font-size: 0.7rem;">Ej: 20, 15B</small>
                            </div>
                            <div class="col-md-1 d-flex align-items-center justify-content-center">
                                <span class="fw-bold" id="separadorComplemento">-</span>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="complemento" name="complemento"
                                    placeholder="# Casa" required pattern="[0-9A-Za-z\s]+" maxlength="10">
                                <small class="text-muted d-block" style="font-size: 0.7rem;">Ej: 15, 30A</small>
                            </div>
                            <div class="col-md-2">
                                <input type="text" class="form-control" id="adicional" name="adicional"
                                    placeholder="Adicional" pattern="[0-9A-Za-z\s\-]+" maxlength="30">
                                <small class="text-muted d-block" style="font-size: 0.7rem;">Ej: Apto 301</small>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <strong>Vista previa:</strong>
                                <span id="vistaPrevia" class="text-primary fw-bold">Completa los campos para ver la
                                    dirección</span>
                            </small>
                        </div>
                        <div class="mt-1">
                            <small class="text-muted" id="ejemploDireccion">
                                <i class="fas fa-info-circle"></i> Selecciona el tipo de vía
                            </small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="telefono" class="form-label">
                            <i class="fas fa-phone"></i> Teléfono *
                        </label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" required
                            pattern="[0-9]{10}" maxlength="10" placeholder="ej:3001234567">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="correo" class="form-label">
                            <i class="fas fa-envelope"></i> Correo Electrónico *
                        </label>
                        <input type="email" class="form-control" id="correo" name="correo" required maxlength="100"
                            placeholder="ej:juanPerez@gmail.com">
                    </div>
                    <div class="col-12 mb-3">
                        <button type="button" class="btn btn-info w-100" data-bs-toggle="modal"
                            data-bs-target="#modalMapa">
                            <i class="fas fa-map-location-dot"></i> Agregar Ubicación del Zoocriadero
                        </button>
                    </div>
                </div>
            </div>

            <!-- Información del Encargado -->
            <div class="mb-5">
                <h4 class="section-title">
                    <i class="fas fa-user-tie"></i> Información del Encargado
                </h4>

                <div class="row">
                    <!-- Documento -->
                    <div class="col-md-4 mb-3">
                        <label for="documentoEncargado" class="form-label">
                            <i class="fas fa-id-card"></i> Documento *
                        </label>
                        <input type="text" class="form-control" id="documentoEncargado" name="documentoEncargado"
                            list="listaUsuarios" required minlength="6" maxlength="15">

                        <datalist id="listaUsuarios">
                            <?php foreach ($usuarios as $u): ?>
                                <option value="<?= $u['documento'] ?>">
                                    <?= $u['nombre'] . ' ' . $u['apellido'] ?>
                                </option>
                            <?php endforeach; ?>
                        </datalist>
                    </div>

                    <!-- Nombres -->
                    <div class="col-md-4 mb-3">
                        <label for="nombresEncargado" class="form-label">
                            <i class="fas fa-user"></i> Nombres *
                        </label>
                        <input type="text" class="form-control" id="nombresEncargado" name="nombresEncargado" readonly>


                    </div>
                    <div class="col-md-4 mb-3" hidden>
                        <label for="idEncargado" class="form-label">
                            <i class="fas fa-user"></i> ID *
                        </label>
                        <input type="text" hidden value="" name="idEncargado" id="idEncargado" required>
                    </div>

                    <!-- Apellidos -->
                    <div class="col-md-4 mb-3">
                        <label for="apellidosEncargado" class="form-label">
                            <i class="fas fa-user"></i> Apellidos *
                        </label>
                        <input type="text" class="form-control" id="apellidosEncargado" name="apellidosEncargado"
                            readonly>
                    </div>
                </div>
            </div>

            <!-- Tanques -->
            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h4 class="section-title mb-0">
                        <i class="fas fa-water"></i> Tanques del Zoocriadero
                    </h4>
                    <div class="d-flex align-items-center gap-3">
                        <button type="button" class="btn btn-danger btn-counter" id="btnRestar">
                            <i class="fas fa-minus"></i>
                        </button>
                        <div class="counter-display" id="contadorTanques">0</div>
                        <button type="button" class="btn btn-success btn-counter" id="btnSumar">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>

                <div id="contenedorTanques">
                    <div class="empty-state">
                        <i class="fas fa-fish"></i>
                        <p class="mb-0">Aún no hay tanques registrados</p>
                        <small class="text-muted">Usa los botones (+) para agregar tanques</small>
                    </div>
                </div>
            </div>

            <!-- Botón Submit -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary btn-submit">
                    <i class="fas fa-save"></i> Registrar Zoocriadero
                </button>
            </div>
        </form>
    </div>
    <!-- Modal Success -->
    <div class="modal fade" id="modalSuccess" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content shadow-lg border-0 rounded-4">

                <div class="modal-header bg-success text-white rounded-top-4 border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-circle-check me-2"></i> Zoocriadero Registrado
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center px-4 py-4">
                    <div class="mb-3">
                        <i class="fas fa-check-circle text-success" style="font-size: 3rem;"></i>
                    </div>
                    <p class="fs-6 text-muted mb-0">
                        <?= $_SESSION['success'] ?? '' ?>
                    </p>
                </div>

                <div class="modal-footer border-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-success px-4 rounded-pill" data-bs-dismiss="modal">
                        Aceptar
                    </button>
                </div>

            </div>
        </div>
    </div>


    <!-- Modal Error -->
    <div class="modal fade" id="modalError" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm">
            <div class="modal-content shadow-lg border-0 rounded-4">

                <div class="modal-header bg-danger text-white rounded-top-4 border-0">
                    <h5 class="modal-title fw-bold">
                        <i class="fas fa-triangle-exclamation me-2"></i> Probelma al Registrar
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body text-center px-4 py-4">
                    <div class="mb-3">
                        <i class="fas fa-xmark-circle text-danger" style="font-size: 3rem;"></i>
                    </div>
                    <p class="fs-6 text-muted mb-0">
                        <?= $_SESSION['error'] ?? '' ?>
                    </p>
                </div>

                <div class="modal-footer border-0 justify-content-center pb-4">
                    <button type="button" class="btn btn-danger px-4 rounded-pill" data-bs-dismiss="modal">
                        Cerrar
                    </button>
                </div>

            </div>
        </div>
    </div>

</div>
<?php if (isset($_SESSION['success'])) { ?>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                const modal = new bootstrap.Modal(
                    document.getElementById('modalSuccess')
                );
                modal.show();
            }, 1000); // 2000 ms = 2 segundos
        });
    </script>
    <?php
    unset($_SESSION['success']);
} ?>

<?php if (isset($_SESSION['error'])) { ?>
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            setTimeout(() => {
                const modal = new bootstrap.Modal(
                    document.getElementById('modalError')
                );
                modal.show();
            }, 1000); // 2 segundos
        });
    </script>
    <?php
    unset($_SESSION['error']);
} ?>

<!-- Modal Mapa -->
<div class="modal fade" id="modalMapa" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-info-adicional">
        <div class="modal-content">
            <div class="modal-header"
                style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <h5 class="modal-title">
                    <i class="fas fa-map-location-dot"></i> Ubicación del Zoocriadero
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="latitud" class="form-label">
                            <i class="fas fa-map-pin"></i> Latitud
                        </label>
                        <input type="text" class="form-control" id="latitud" name="latitud" placeholder="Ej: 9.451647"
                            readonly>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="longitud" class="form-label">
                            <i class="fas fa-map-pin"></i> Longitud
                        </label>
                        <input type="text" class="form-control" id="longitud" name="longitud"
                            placeholder="Ej: -16.531985" readonly>
                    </div>
                </div>

                <div id="mapaUbicacion"
                    style="width: 100%; height: 400px; border-radius: 8px; border: 2px solid #e9ecef;"></div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times"></i> Cancelar
                </button>
                <button type="button" class="btn btn-success" id="btnGuardarUbicacion">
                    <i class="fas fa-check"></i> Guardar Ubicación
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let numeroTanques = 0;
    let mapa = null;
    let marcador = null;
    let ubicacionSeleccionada = {
        lat: +(Math.random() * 20).toFixed(5),          // 0 a 20
        lng: -+(Math.random() * 70).toFixed(6)          // -0 a -20
    };

    // Actualizar vista previa de dirección en tiempo real
    function actualizarVistaPrevia() {
        const tipoVia = document.getElementById('tipoVia').value;
        const numeroVia = document.getElementById('numeroVia').value;
        const numeroPlaca = document.getElementById('numeroPlaca').value;
        const complemento = document.getElementById('complemento').value;
        const adicional = document.getElementById('adicional').value;

        if (tipoVia && numeroVia && numeroPlaca && complemento) {
            const direccion = `${tipoVia} ${numeroVia} # ${numeroPlaca} - ${complemento}${adicional ? ' ' + adicional : ''}`;
            document.getElementById('vistaPrevia').textContent = direccion;
        } else {
            document.getElementById('vistaPrevia').textContent = 'Completa los campos para ver la dirección';
        }
    }

    // Cambiar ejemplos según tipo de vía
    function actualizarEjemplos() {
        const tipoVia = document.getElementById('tipoVia').value;
        const ejemploDireccion = document.getElementById('ejemploDireccion');

        const ejemplos = {
            'Calle': 'Ejemplo: Calle 5 # 20 - 15 Apto 301',
            'Carrera': 'Ejemplo: Carrera 10 # 15 - 30 Casa 2',
            'Avenida': 'Ejemplo: Avenida 6N # 25 - 40 Local 5',
            'Avenida Calle': 'Ejemplo: Avenida Calle 5 # 20 - 15',
            'Avenida Carrera': 'Ejemplo: Avenida Carrera 10 # 15 - 30',
            'Diagonal': 'Ejemplo: Diagonal 15 # 10 - 25',
            'Transversal': 'Ejemplo: Transversal 8 # 12 - 18',
            'Circular': 'Ejemplo: Circular 2 # 15 - 20',
            'Autopista': 'Ejemplo: Autopista Sur # 50 - 10',
            'Variante': 'Ejemplo: Variante # 20 - 15'
        };

        if (tipoVia && ejemplos[tipoVia]) {
            ejemploDireccion.innerHTML = `<i class="fas fa-info-circle"></i> ${ejemplos[tipoVia]}`;
        } else {
            ejemploDireccion.innerHTML = '<i class="fas fa-info-circle"></i> Selecciona el tipo de vía';
        }
    }

    // Event listeners para actualizar vista previa
    document.getElementById('tipoVia').addEventListener('change', function () {
        actualizarVistaPrevia();
        actualizarEjemplos();
    });
    document.getElementById('numeroVia').addEventListener('input', actualizarVistaPrevia);
    document.getElementById('numeroPlaca').addEventListener('input', actualizarVistaPrevia);
    document.getElementById('complemento').addEventListener('input', actualizarVistaPrevia);
    document.getElementById('adicional').addEventListener('input', actualizarVistaPrevia);

    // Botón sumar tanque
    document.getElementById('btnSumar').addEventListener('click', function () {
        numeroTanques++;
        actualizarContador();
        agregarTanque();
    });

    // Botón restar tanque
    document.getElementById('btnRestar').addEventListener('click', function () {
        if (numeroTanques > 0) {
            eliminarUltimoTanque();
            numeroTanques--;
            actualizarContador();
        }
    });

    function actualizarContador() {
        document.getElementById('contadorTanques').textContent = numeroTanques;
    }

    function agregarTanque() {
        const contenedor = document.getElementById('contenedorTanques');
        const emptyState = contenedor.querySelector('.empty-state');
        if (emptyState) {
            emptyState.remove();
        }

        const tanqueHTML = `
            <div class="tanque-card" id="tanque-${numeroTanques}" data-tanque="${numeroTanques}">
                <button type="button" class="btn btn-danger btn-sm btn-remove-tanque" onclick="eliminarTanque(${numeroTanques})">
                    <i class="fas fa-times"></i>
                </button>
                
                <div class="tanque-header">
                    <h5 class="mb-0">
                        <i class="fas fa-water"></i> Tanque #${numeroTanques}
                    </h5>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-fish"></i> Tipo de Tanque *
                        </label>
                        <select class="form-select" name="tanques[${numeroTanques}][tipo]" required>
                            <option value="">Seleccione un tipo</option>
                            <?php foreach ($tiposTanque as $tipo) { ?>
                                <option value="<?= $tipo['id_tipo_tanque'] ?>"><?= htmlspecialchars($tipo['nombre']) ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">
                            <i class="fas fa-fish-fins"></i> Cantidad de Peces *
                        </label>
                        <input type="number" class="form-control" name="tanques[${numeroTanques}][cantidad_peces]" required min="1" max="100000">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            <i class="fas fa-arrows-left-right"></i> Ancho (m) *
                        </label>
                        <input type="number" class="form-control" name="tanques[${numeroTanques}][ancho]" required min="0.1" max="100" step="0.01">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            <i class="fas fa-arrows-up-down"></i> Largo (m) *
                        </label>
                        <input type="number" class="form-control" name="tanques[${numeroTanques}][largo]" required min="0.1" max="100" step="0.01">
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">
                            <i class="fas fa-arrow-down"></i> Profundidad (m) *
                        </label>
                        <input type="number" class="form-control" name="tanques[${numeroTanques}][profundidad]" required min="0.1" max="10" step="0.01">
                    </div>
                </div>
            </div>
        `;

        contenedor.insertAdjacentHTML('beforeend', tanqueHTML);
    }

    function eliminarTanque(numero) {
        const tanque = document.getElementById(`tanque-${numero}`);
        if (tanque) {
            tanque.remove();
            numeroTanques--;
            actualizarContador();
            renumerarTanques();

            const contenedor = document.getElementById('contenedorTanques');
            if (contenedor.children.length === 0) {
                contenedor.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-fish"></i>
                        <p class="mb-0">Aún no hay tanques registrados</p>
                        <small class="text-muted">Usa los botones (+) para agregar tanques</small>
                    </div>
                `;
            }
        }
    }

    function eliminarUltimoTanque() {
        const tanques = document.querySelectorAll('.tanque-card');
        if (tanques.length > 0) {
            tanques[tanques.length - 1].remove();

            if (tanques.length === 1) {
                const contenedor = document.getElementById('contenedorTanques');
                contenedor.innerHTML = `
                    <div class="empty-state">
                        <i class="fas fa-fish"></i>
                        <p class="mb-0">Aún no hay tanques registrados</p>
                        <small class="text-muted">Usa los botones (+) para agregar tanques</small>
                    </div>
                `;
            }
        }
    }

    function renumerarTanques() {
        const tanques = document.querySelectorAll('.tanque-card');
        tanques.forEach((tanque, index) => {
            const nuevoNumero = index + 1;
            tanque.id = `tanque-${nuevoNumero}`;
            tanque.dataset.tanque = nuevoNumero;
            tanque.querySelector('.tanque-header h5').innerHTML = `<i class="fas fa-water"></i> Tanque #${nuevoNumero}`;

            const inputs = tanque.querySelectorAll('input, select');
            inputs.forEach(input => {
                const name = input.name;
                if (name) {
                    input.name = name.replace(/\[\d+\]/, `[${nuevoNumero}]`);
                }
            });

            const btnEliminar = tanque.querySelector('.btn-remove-tanque');
            btnEliminar.setAttribute('onclick', `eliminarTanque(${nuevoNumero})`);
        });
        numeroTanques = tanques.length;
        actualizarContador();
    }

    // Submit formulario zoocriadero
    document.getElementById('formZoocriadero').addEventListener('submit', function (e) {
        e.preventDefault();

        let url = $(this).data('url');
        const formData = new FormData(this);

        // Construir dirección completa
        const direccionCompleta = `${formData.get('tipoVia')} ${formData.get('numeroVia')} # ${formData.get('numeroPlaca')} - ${formData.get('complemento')}${formData.get('adicional') ? ' ' + formData.get('adicional') : ''}`;

        const datos = {
            zoocriadero: {
                nombre: formData.get('nombreZoo'),
                barrio: formData.get('barrio'),
                comuna: formData.get('comuna'),
                direccion: direccionCompleta,
                telefono: formData.get('telefono'),
                correo: formData.get('correo'),
                latitud: ubicacionSeleccionada.lat,
                longitud: ubicacionSeleccionada.lng
            },
            encargado: {
                documento: formData.get('documentoEncargado'),
                nombres: formData.get('nombresEncargado'),
                apellidos: formData.get('apellidosEncargado')
            },
            tanques: []
        };

        // Recoger datos de tanques
        const tanques = document.querySelectorAll('.tanque-card');
        tanques.forEach((tanque, index) => {
            const numero = index + 1;
            datos.tanques.push({
                tipo: formData.get(`tanques[${numero}][tipo]`),
                cantidad_peces: formData.get(`tanques[${numero}][cantidad_peces]`),
                ancho: formData.get(`tanques[${numero}][ancho]`),
                largo: formData.get(`tanques[${numero}][largo]`),
                profundidad: formData.get(`tanques[${numero}][profundidad]`)
            });
        });

        // Validaciones
        if (datos.tanques.length === 0) {
            alert('Por favor, agrega al menos un tanque.');
            return;
        }

        $.ajax({
            url: url,
            type: "POST",
            data: {
                // Datos del zoocriadero
                nombre: formData.get('nombreZoo'),
                barrio: formData.get('barrio'),
                comuna: formData.get('comuna'),
                direccion: direccionCompleta,
                telefono: formData.get('telefono'),
                correo: formData.get('correo'),
                latitud: ubicacionSeleccionada.lat,
                longitud: ubicacionSeleccionada.lng,

                // Datos del encargado
                id_encargado: formData.get('idEncargado'),
                documento_encargado: formData.get('documentoEncargado'),
                nombres_encargado: formData.get('nombresEncargado'),
                apellidos_encargado: formData.get('apellidosEncargado'),

                // Tanques como JSON string
                tanques: JSON.stringify(datos.tanques)
            },
            success: function () {
                window.location.href = "<?= getUrl('Zoocriadero', 'Zoocriadero', 'registrar'); ?>";
            }
        });
    });
    // Array de usuarios enviado desde PHP
    const usuarios = <?= json_encode($usuarios) ?>;

    const inputDocumento = document.getElementById('documentoEncargado');
    const inputNombres = document.getElementById('nombresEncargado');
    const inputApellidos = document.getElementById('apellidosEncargado');
    const inputIdEncargado = document.getElementById('idEncargado');

    inputDocumento.addEventListener('input', function () {
        const documento = this.value.trim();
        const usuario = usuarios.find(u => u.documento == documento);

        if (usuario) {

            inputNombres.value = usuario.nombre;
            inputApellidos.value = usuario.apellido;
            inputIdEncargado.value = usuario.id_usuario;
        } else {
            inputNombres.value = '';
            inputApellidos.value = '';
            inputIdEncargado.value = '';
        }
    });

</script>