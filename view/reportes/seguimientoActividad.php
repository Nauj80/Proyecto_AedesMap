<div class="row mb-3">
    <div class="col-md-5 mb-2">
        <input type="text" class="form-control" placeholder="Filtra por zoocriadero, encargado, tanque..." id="filtro"
            data-url="<?php echo getUrl('Reportes', 'Reportes', 'filtro', false, 'ajax'); ?>">
    </div>
    <div class="col-md-7">
        <div class="row g-2">
            <div class="col-sm-4">
                <input type="date" class="form-control" id="fechaInicio" placeholder="Fecha Inicio">
            </div>
            <div class="col-sm-4">
                <input type="date" class="form-control" id="fechaFin" placeholder="Fecha Fin">
            </div>
            <div class="col-sm-4">
                <button class="btn btn-primary w-100" id="btnBuscar">
                    <i class="fa fa-search"></i> Buscar
                </button>
            </div>
        </div>
        <small class="text-danger d-none" id="errorFechas">La fecha inicio debe ser menor a la fecha fin</small>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="d-flex align-items-center">
                    <h4 class="card-title">Listado de Actividades</h4>
                    <button class="btn btn-success btn-round ms-auto" id="btnDescargar">
                        <i class="fa fa-download"></i> Descargar Reporte
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <div id="add-row_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">

                        <div class="row">
                            <div class="col-sm-12 col-md-6">
                                <div class="dataTables_length" id="add-row_length">
                                    <label>Mostrar
                                        <select name="add-row_length" id="registrosPerPage" aria-controls="add-row"
                                            class="form-control form-control-sm">
                                            <option value="10" selected>10</option>
                                            <option value="20">20</option>
                                            <option value="50">50</option>
                                            <option value="100">100</option>
                                        </select> registros
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12">
                                <table id="add-row" class="display table table-striped table-hover dataTable"
                                    role="grid" aria-describedby="add-row_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting_asc" tabindex="0" aria-controls="add-row" rowspan="1"
                                                colspan="1" style="cursor: pointer;">ID Seguimiento</th>
                                            <th class="sorting" tabindex="0" aria-controls="add-row" rowspan="1"
                                                colspan="1" style="cursor: pointer;">Zoocriadero</th>
                                            <th class="sorting" tabindex="0" aria-controls="add-row" rowspan="1"
                                                colspan="1" style="cursor: pointer;">Tanque</th>
                                            <th class="sorting" tabindex="0" aria-controls="add-row" rowspan="1"
                                                colspan="1" style="cursor: pointer;">Documento Encargado</th>
                                            <th class="sorting" tabindex="0" aria-controls="add-row" rowspan="1"
                                                colspan="1" style="cursor: pointer;">Encargado</th>
                                            <th class="sorting" tabindex="0" aria-controls="add-row" rowspan="1"
                                                colspan="1" style="cursor: pointer;">Fecha</th>
                                            <th class="sorting" tabindex="0" aria-controls="add-row" rowspan="1"
                                                colspan="1" style="cursor: pointer;">Estado</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th rowspan="1" colspan="1">ID Seguimiento</th>
                                            <th rowspan="1" colspan="1">Zoocriadero</th>
                                            <th rowspan="1" colspan="1">Tanque</th>
                                            <th rowspan="1" colspan="1">Documento Encargado</th>
                                            <th rowspan="1" colspan="1">Encargado</th>
                                            <th rowspan="1" colspan="1">Fecha</th>
                                            <th rowspan="1" colspan="1">Estado</th>
                                        </tr>
                                    </tfoot>
                                    <tbody id="tableBody">

                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 col-md-5">
                                <div class="dataTables_info" id="add-row_info" role="status" aria-live="polite">
                                    Mostrando <span id="registroInicio">1</span> a <span id="registroFin">5</span> de
                                    <span id="totalRegistros">5</span> registros
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-7">
                                <div class="dataTables_paginate paging_simple_numbers" id="add-row_paginate">
                                    <ul class="pagination" id="pagination">
                                        <li class="paginate_button page-item previous disabled">
                                            <a href="#" class="page-link">Anterior</a>
                                        </li>
                                        <li class="paginate_button page-item active">
                                            <a href="#" class="page-link">1</a>
                                        </li>
                                        <li class="paginate_button page-item">
                                            <a href="#" class="page-link">2</a>
                                        </li>
                                        <li class="paginate_button page-item">
                                            <a href="#" class="page-link">3</a>
                                        </li>
                                        <li class="paginate_button page-item next">
                                            <a href="#" class="page-link">Siguiente</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Variables globales
    var currentPage = 1;
    var registrosPerPage = 10;
    var currentSortColumn = 's.id_seguimiento';
    var currentSortOrder = 'DESC';
    var isLoading = false;

    // Elementos del DOM
    var fechaInicio = document.getElementById('fechaInicio');
    var fechaFin = document.getElementById('fechaFin');
    var btnBuscar = document.getElementById('btnBuscar');
    var errorFechas = document.getElementById('errorFechas');
    var filtroInput = document.getElementById('filtro');
    var registrosPerPageSelect = document.getElementById('registrosPerPage');
    var urlFiltro = filtroInput.getAttribute('data-url');

    function validarFechas() {
        if (fechaInicio.value && fechaFin.value) {
            var inicio = new Date(fechaInicio.value);
            var fin = new Date(fechaFin.value);

            if (inicio > fin) {
                errorFechas.classList.remove('d-none');
                return false;
            } else {
                errorFechas.classList.add('d-none');
                return true;
            }
        }
        errorFechas.classList.add('d-none');
        return true;
    }

    // Event listeners
    fechaInicio.addEventListener('change', validarFechas);
    fechaFin.addEventListener('change', validarFechas);

    btnBuscar.addEventListener('click', function () {
        if (validarFechas()) {
            currentPage = 1;
            cargarDatos();
        }
    });

    // Filtro con debounce
    var timeoutId = null;
    filtroInput.addEventListener('keyup', function () {
        if (timeoutId !== null) {
            clearTimeout(timeoutId);
        }

        timeoutId = setTimeout(function () {
            currentPage = 1;
            cargarDatos();
            timeoutId = null;
        }, 800);
    });

    // Cambiar registros por página
    registrosPerPageSelect.addEventListener('change', function () {
        registrosPerPage = parseInt(this.value);
        currentPage = 1;
        cargarDatos();
    });

    // Función para ordenar tabla
    function sortTable(column) {
        if (currentSortColumn === column) {
            currentSortOrder = currentSortOrder === 'ASC' ? 'DESC' : 'ASC';
        } else {
            currentSortColumn = column;
            currentSortOrder = 'ASC';
        }
        currentPage = 1;
        cargarDatos();
    }

    // Event listeners para headers
    document.addEventListener('DOMContentLoaded', function () {
        var headers = document.querySelectorAll('#add-row thead th');
        var columns = [
            's.id_seguimiento',
            'z.nombre_zoocriadero',
            't.nombre',
            'u.documento',
            'u.nombre',
            's.fecha',
            'es.nombre'
        ];

        for (var i = 0; i < headers.length; i++) {
            headers[i].setAttribute('data-column', columns[i]);
            headers[i].addEventListener('click', function () {
                sortTable(this.getAttribute('data-column'));
            });
        }

        // Cargar datos iniciales
        cargarDatos();
    });

    // Función principal para cargar datos
    function cargarDatos() {
        if (isLoading) {
            return;
        }

        isLoading = true;

        var tbody = document.getElementById('tableBody');
        tbody.innerHTML = '<tr><td colspan="7" class="text-center"><i class="fa fa-spinner fa-spin"></i> Cargando...</td></tr>';

        // Construir URL con parámetros GET
        var params = 'buscar=' + encodeURIComponent(filtroInput.value) +
            '&fechaInicio=' + encodeURIComponent(fechaInicio.value) +
            '&fechaFin=' + encodeURIComponent(fechaFin.value) +
            '&page=' + currentPage +
            '&length=' + registrosPerPage +
            '&sortColumn=' + encodeURIComponent(currentSortColumn) +
            '&sortOrder=' + currentSortOrder;

        var url = urlFiltro + '&' + params;

        console.log('URL de carga:', url);

        // Usar XMLHttpRequest para compatibilidad con navegadores antiguos
        var xhr = new XMLHttpRequest();
        xhr.open('GET', url, true);

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                isLoading = false;
                if (xhr.status === 200) {
                    try {
                        var data = JSON.parse(xhr.responseText);
                        console.log('Datos recibidos:', data);
                        actualizarTabla(data.registros);
                        actualizarPaginacion(data.totalRegistros, data.totalPaginas);
                        actualizarInfoRegistros(data.registroInicio, data.registroFin, data.totalRegistros);
                    } catch (e) {
                        console.error('Error al parsear JSON:', e);
                        tbody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error al procesar los datos</td></tr>';
                    }
                } else {
                    console.error('Error en la petición:', xhr.status);
                    tbody.innerHTML = '<tr><td colspan="7" class="text-center text-danger">Error al cargar los datos</td></tr>';
                }
            }
        };

        xhr.send();
    }

    // Función para actualizar tabla
    function actualizarTabla(registros) {
        var tbody = document.getElementById('tableBody');
        tbody.innerHTML = '';

        if (!registros || registros.length === 0) {
            tbody.innerHTML = '<tr><td colspan="7" class="text-center">No se encontraron registros</td></tr>';
            return;
        }

        for (var i = 0; i < registros.length; i++) {
            var registro = registros[i];

            var badgeClass = 'bg-secondary';
            if (registro.estado_seguimiento === 'Completado') {
                badgeClass = 'bg-success';
            } else if (registro.estado_seguimiento === 'En Proceso') {
                badgeClass = 'bg-warning';
            } else if (registro.estado_seguimiento === 'Pendiente') {
                badgeClass = 'bg-info';
            }

            var nombreCompleto = registro.nombre + ' ' + registro.apellido;

            var tr = document.createElement('tr');
            tr.setAttribute('role', 'row');
            tr.innerHTML = '<td class="sorting_1">' + registro.id_seguimiento + '</td>' +
                '<td>' + registro.nombre_zoocriadero + '</td>' +
                '<td>' + registro.nombre_tanque + '</td>' +
                '<td>' + registro.documento + '</td>' +
                '<td>' + nombreCompleto + '</td>' +
                '<td>' + registro.fecha_seguimiento + '</td>' +
                '<td><span class="badge ' + badgeClass + '">' + registro.estado_seguimiento + '</span></td>';
            tbody.appendChild(tr);
        }
    }

    // Función para actualizar info de registros
    function actualizarInfoRegistros(registroInicio, registroFin, totalRegistros) {
        document.getElementById('registroInicio').textContent = registroInicio;
        document.getElementById('registroFin').textContent = registroFin;
        document.getElementById('totalRegistros').textContent = totalRegistros;
    }

    // Función para actualizar paginación
    // Función para actualizar paginación
    function actualizarPaginacion(totalRegistros, totalPaginas) {
        var pagination = document.getElementById('pagination');
        pagination.innerHTML = '';

        console.log('Actualizando paginación - Página actual:', currentPage, 'Total páginas:', totalPaginas, 'Total registros:', totalRegistros);

        // Si no hay páginas, mostrar solo el botón deshabilitado
        if (totalPaginas === 0 || totalPaginas === 1) {
            totalPaginas = 1;
        }

        // Botón Anterior
        var prevLi = document.createElement('li');
        prevLi.className = 'paginate_button page-item previous' + (currentPage === 1 ? ' disabled' : '');
        var prevA = document.createElement('a');
        prevA.href = '#';
        prevA.className = 'page-link';
        prevA.textContent = 'Anterior';
        prevA.onclick = function (e) {
            e.preventDefault();
            if (currentPage > 1) {
                cambiarPagina(currentPage - 1);
            }
            return false;
        };
        prevLi.appendChild(prevA);
        pagination.appendChild(prevLi);

        // Botones de páginas (máximo 5 botones visibles)
        var maxPagesToShow = 5;
        var startPage = Math.max(1, currentPage - Math.floor(maxPagesToShow / 2));
        var endPage = Math.min(totalPaginas, startPage + maxPagesToShow - 1);

        // Ajustar startPage si estamos cerca del final
        if (endPage - startPage < maxPagesToShow - 1) {
            startPage = Math.max(1, endPage - maxPagesToShow + 1);
        }

        // Mostrar primera página si no está en el rango
        if (startPage > 1) {
            var firstLi = document.createElement('li');
            firstLi.className = 'paginate_button page-item';
            var firstA = document.createElement('a');
            firstA.href = '#';
            firstA.className = 'page-link';
            firstA.textContent = '1';
            firstA.onclick = function (e) {
                e.preventDefault();
                cambiarPagina(1);
                return false;
            };
            firstLi.appendChild(firstA);
            pagination.appendChild(firstLi);

            // Agregar puntos suspensivos si hay espacio
            if (startPage > 2) {
                var dotsLi = document.createElement('li');
                dotsLi.className = 'paginate_button page-item disabled';
                var dotsSpan = document.createElement('span');
                dotsSpan.className = 'page-link';
                dotsSpan.textContent = '...';
                dotsLi.appendChild(dotsSpan);
                pagination.appendChild(dotsLi);
            }
        }

        // Crear botones de páginas
        for (var i = startPage; i <= endPage; i++) {
            var li = document.createElement('li');
            li.className = 'paginate_button page-item' + (i === currentPage ? ' active' : '');
            var a = document.createElement('a');
            a.href = '#';
            a.className = 'page-link';
            a.textContent = i;
            a.setAttribute('data-page', i);
            a.onclick = function (e) {
                e.preventDefault();
                var page = parseInt(this.getAttribute('data-page'));
                cambiarPagina(page);
                return false;
            };
            li.appendChild(a);
            pagination.appendChild(li);
        }

        // Mostrar última página si no está en el rango
        if (endPage < totalPaginas) {
            // Agregar puntos suspensivos si hay espacio
            if (endPage < totalPaginas - 1) {
                var dotsLi = document.createElement('li');
                dotsLi.className = 'paginate_button page-item disabled';
                var dotsSpan = document.createElement('span');
                dotsSpan.className = 'page-link';
                dotsSpan.textContent = '...';
                dotsLi.appendChild(dotsSpan);
                pagination.appendChild(dotsLi);
            }

            var lastLi = document.createElement('li');
            lastLi.className = 'paginate_button page-item';
            var lastA = document.createElement('a');
            lastA.href = '#';
            lastA.className = 'page-link';
            lastA.textContent = totalPaginas;
            lastA.onclick = function (e) {
                e.preventDefault();
                cambiarPagina(totalPaginas);
                return false;
            };
            lastLi.appendChild(lastA);
            pagination.appendChild(lastLi);
        }

        // Botón Siguiente
        var nextLi = document.createElement('li');
        nextLi.className = 'paginate_button page-item next' + (currentPage >= totalPaginas ? ' disabled' : '');
        var nextA = document.createElement('a');
        nextA.href = '#';
        nextA.className = 'page-link';
        nextA.textContent = 'Siguiente';
        nextA.onclick = function (e) {
            e.preventDefault();
            if (currentPage < totalPaginas) {
                cambiarPagina(currentPage + 1);
            }
            return false;
        };
        nextLi.appendChild(nextA);
        pagination.appendChild(nextLi);
    }

    // Función para cambiar de página
    function cambiarPagina(page) {
        if (page < 1) {
            page = 1;
        }
        console.log('Cambiando a página:', page);
        currentPage = page;
        cargarDatos();
    }

    // Función para cambiar de página
    function cambiarPagina(page) {
        if (page < 1) return;
        currentPage = page;
        cargarDatos();
    }

    // Botón de descargar
    document.getElementById('btnDescargar').addEventListener('click', function () {
        var params = 'filtro=' + encodeURIComponent(filtroInput.value) +
            '&fechaInicio=' + encodeURIComponent(fechaInicio.value) +
            '&fechaFin=' + encodeURIComponent(fechaFin.value) +
            '&sortColumn=' + encodeURIComponent(currentSortColumn) +
            '&sortOrder=' + currentSortOrder;

        var urlDescarga = '<?php echo getUrl("Reportes", "Reportes", "descargarSeguimiento"); ?>&' + params;
        window.location.href = urlDescarga;

        console.log('Descargando reporte...');
    });
    // Botón de descargar
    document.getElementById('btnDescargar').addEventListener('click', function () {

        var btn = this;
        var originalText = btn.innerHTML;

        // Feedback visual
        btn.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Descargando...';
        btn.disabled = true;

        // Construir parámetros
        var params =
            'filtro=' + encodeURIComponent(filtroInput.value) +
            '&fechaInicio=' + encodeURIComponent(fechaInicio.value) +
            '&fechaFin=' + encodeURIComponent(fechaFin.value) +
            '&sortColumn=' + encodeURIComponent(currentSortColumn) +
            '&sortOrder=' + encodeURIComponent(currentSortOrder) +
            '&_ts=' + new Date().getTime(); // evita cache

        // URL de descarga
        var urlDescarga =
            '<?php echo getUrl("Reportes", "Reportes", "descargarSeguimiento"); ?>&' + params;

        console.log('Descargando:', urlDescarga);

        // Abrir descarga en nueva pestaña
        window.open(urlDescarga, '_blank');

        // Restaurar botón
        setTimeout(function () {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }, 1200);
    });
</script>

<style>
    /* Estilos adicionales */
    .page-header {
        margin-bottom: 2rem;
    }

    .breadcrumbs {
        list-style: none;
        padding: 0;
        display: flex;
        align-items: center;
        margin: 0;
    }

    .breadcrumbs li {
        display: inline-flex;
        align-items: center;
    }

    .breadcrumbs .separator {
        margin: 0 0.5rem;
    }

    .table th {
        cursor: pointer;
        user-select: none;
    }

    .table th:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    .dataTables_length select {
        width: auto;
        display: inline-block;
        margin: 0 5px;
    }

    #errorFechas {
        display: block;
        margin-top: 5px;
    }

    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.875rem;
    }

    @media (max-width: 768px) {
        .card-header .btn {
            margin-top: 10px;
        }

        .table {
            font-size: 0.875rem;
        }

        .badge {
            font-size: 0.75rem;
        }
    }
</style>