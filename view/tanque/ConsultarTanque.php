<?php
include_once '../lib/helpers.php';
include_once '../lib/helpersLogin.php';
include_once '../view/partials/header.php';
?>

<body>
    <div class="page-header">
        <h3 class="fw-bold mb-3">Consultar tanque</h3>
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
                <a href="">Tanque</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="<?php echo getUrl("Tanque", "Tanque", "listar"); ?>">Consultar tanque</a>
            </li>
        </ul>

    </div>

    <div class="row justify-content-center">

        <?php
        while ($canE = pg_fetch_assoc($canEstados)) {


            print_r(
                '
                <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">

                    <div class="h1 m-0">
                '
            );
            echo $canE["cantidad"];

            print_r(
                '
                </div>
                    <div class="text-muted">' . $canE["nombre"] . '</div>
                </div>
            </div>
        </div>
                '
            );
        }
        ?>
    </div>

    <div class="row mb-3">
        <div class="col-md-5 mb-1">
            <input type="text" class="form-control" placeholder="Nombre del Zoocriadero, Nombre del tanque o tipo de tanque"
                id="filtro" data-url="<?php echo getUrl('Tanque', 'Tanque', 'filtro', false, 'ajax'); ?>">
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Tanques</h4>
                        <a class="btn btn-primary btn-round ms-auto" href="<?php echo getUrl("Tanque", "Tanque", "getCreate"); ?>">
                            <i class="fa fa-plus"></i>
                            Crear tanque
                        </a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="table-responsive">
                        <div id="add-row_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                            <div class="row">
                                <div class="col-sm-12 col-md-6">
                                    <div class="dataTables_length" id="add-row_length"><label>Mostrar <select name="add-row_length" id="registrosPerPage" aria-controls="add-row" class="form-control form-control-sm" onchange="cambiarRegistrosPorPagina(this.value)">
                                                <option value="10" <?php echo $registrosPorPagina == 10 ? 'selected' : ''; ?>>10</option>
                                                <option value="25" <?php echo $registrosPorPagina == 25 ? 'selected' : ''; ?>>25</option>
                                                <option value="50" <?php echo $registrosPorPagina == 50 ? 'selected' : ''; ?>>50</option>
                                                <option value="100" <?php echo $registrosPorPagina == 100 ? 'selected' : ''; ?>>100</option>
                                            </select> registros</label></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="add-row" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="add-row_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 368.422px; cursor: pointer;" onclick="sortTable('zoocriadero')">Zoocriadero</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 368.422px; cursor: pointer;" onclick="sortTable('nombre_tanque')">Nombre del tanque</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 368.422px; cursor: pointer;" onclick="sortTable('tipo_tanque')">Tipo de tanque</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 368.422px; cursor: pointer;" onclick="sortTable('t.cantidad_peces')">Cantidad de peces</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 368.422px; cursor: pointer;" onclick="sortTable('t.ancho')">Ancho</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 368.422px; cursor: pointer;" onclick="sortTable('t.largo')">Largo</th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 368.422px; cursor: pointer;" onclick="sortTable('t.profundo')">Profundidad</th>
                                                <th class="sorting" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 527.906px; cursor: pointer;" onclick="sortTable('et.nombre')">Estado</th>
                                                <th style="width: 120.688px;" class="sorting" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">Zoocriadero</th>
                                                <th rowspan="1" colspan="1">Nombre del tanque</th>
                                                <th rowspan="1" colspan="1">Tipo de tanque</th>
                                                <th rowspan="1" colspan="1">Cantidad de peces</th>
                                                <th rowspan="1" colspan="1">Ancho</th>
                                                <th rowspan="1" colspan="1">Largo</th>
                                                <th rowspan="1" colspan="1">Profundidad</th>
                                                <th rowspan="1" colspan="1">Estado</th>
                                                <th rowspan="1" colspan="1">Acciones</th>
                                            </tr>
                                        </tfoot>

                                        <tbody>
                                            <?php

                                            while ($Tanque = pg_fetch_assoc($Tanques)) {

                                                print_r(
                                                    '
                                                    <tr role="row">
                                                        <td class="sorting_1">' . $Tanque["zoocriadero"] . '</td>
                                                        <td class="sorting_1">' . $Tanque["nombre"] . '</td>
                                                        <td class="sorting_1">' . $Tanque["tipo_tanque"] . '</td>
                                                        <td class="sorting_1">' . $Tanque["cantidad_peces"] . '</td>
                                                        <td class="sorting_1">' . $Tanque["ancho"] . 'm</td>
                                                        <td class="sorting_1">' . $Tanque["alto"] . 'm</td>
                                                        <td class="sorting_1">' . $Tanque["profundo"] . 'm</td>
                                                        <td>' . $Tanque["estado"] . '</td>
                                                        <td class="text-center">
                                                            <div class="form-button-action gap-3">
                                                            '
                                                );

                                                if (tieneAccion("Tanques", "Editar")) {
                                                    print_r(
                                                        '
                                                                <a class="btn btn-primary" href=' . getUrl("Tanque", "Tanque", "getUpdate", array("id" => $Tanque['id_tanque'])) . '>
                                                                    Editar
                                                                </a>
                                                                '
                                                    );

                                                    if ($Tanque['id_estado_tanque'] == 1) {
                                                        if (tieneAccion("Tanques", "Inhabilitar")) {

                                                            print_r('
                                                                    <a class="btn btn-danger btn-inhabilitar" href=' . getUrl("Tanque", "Tanque", "getDelete", array("id" => $Tanque['id_tanque'])) . '>
                                                                    Inhabilitar
                                                                    </a>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        ');
                                                        }
                                                    } elseif ($Tanque['id_estado_tanque'] == 2) {
                                                        if (tieneAccion("Tanques", "Habilitar")) {
                                                            print_r('
                                                                <form class="form-habilitar" action="');
                                                            echo getUrl("Tanque", "Tanque", "postUpdateStatus");
                                                            print_r('"
                                                                method="post" style="display: inline;">
                                                                    <input type="hidden" name="id_tanque" value="' . $Tanque['id_tanque'] . '">
                                                                    <button type="submit" class="btn btn-info">
                                                                        Habilitar
                                                                    </button>
                                                                </form>
                                                                ');
                                                        }
                                                        print_r('
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    ');
                                                    }
                                                }
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-md-5">
                                    <div class="dataTables_info" id="add-row_info" role="status" aria-live="polite">Mostrando <?php echo $registroInicio; ?> a <?php echo $registroFin; ?> de <?php echo $totalRegistros; ?> registros</div>
                                </div>
                                <div class="col-sm-12 col-md-7">
                                    <div class="dataTables_paginate paging_simple_numbers" id="add-row_paginate">
                                        <ul class="pagination">
                                            <?php
                                            // Botón Anterior
                                            if ($paginaActual > 1) {
                                                $paginaAnterior = $paginaActual - 1;
                                                echo '<li class="paginate_button page-item previous"><a href="' . getUrl("Tanque", "Tanque", "listar") . '&length=' . $registrosPorPagina . '&page=' . $paginaAnterior . '" class="page-link">Anterior</a></li>';
                                            } else {
                                                echo '<li class="paginate_button page-item previous disabled"><a href="#" class="page-link">Anterior</a></li>';
                                            }

                                            // Generar botones de páginas
                                            for ($i = 1; $i <= $totalPaginas; $i++) {
                                                if ($i == $paginaActual) {
                                                    echo '<li class="paginate_button page-item active"><a href="#" class="page-link">' . $i . '</a></li>';
                                                } else {
                                                    $sortParams = isset($_GET['sort_column']) ? '&sort_column=' . $_GET['sort_column'] . '&sort_order=' . $_GET['sort_order'] : '';
                                                    echo '<li class="paginate_button page-item"><a href="' . getUrl("Tanque", "Tanque", "listar") . '&length=' . $registrosPorPagina . '&page=' . $i . $sortParams . '" class="page-link">' . $i . '</a></li>';
                                                }
                                            }

                                            // Botón Siguiente
                                            if ($paginaActual < $totalPaginas) {
                                                $paginaSiguiente = $paginaActual + 1;
                                                $sortParams = isset($_GET['sort_column']) ? '&sort_column=' . $_GET['sort_column'] . '&sort_order=' . $_GET['sort_order'] : '';
                                                echo '<li class="paginate_button page-item next"><a href="' . getUrl("Tanque", "Tanque", "listar") . '&length=' . $registrosPorPagina . '&page=' . $paginaSiguiente . $sortParams . '" class="page-link">Siguiente</a></li>';
                                            } else {
                                                echo '<li class="paginate_button page-item next disabled"><a href="#" class="page-link">Siguiente</a></li>';
                                            }
                                            ?>
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
</body>


<script>
    function cambiarRegistrosPorPagina(valor) {
        // Redirigir a la misma página con el nuevo parámetro de límite, manteniendo sort
        var sortColumn = '<?php echo isset($_GET['sort_column']) ? $_GET['sort_column'] : 'tt.nombre'; ?>';
        var sortOrder = '<?php echo isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC'; ?>';
        var baseUrl = '<?php echo getUrl("Tanque", "Tanque", "listar"); ?>&length=' + valor + '&page=1';
        window.location.href = baseUrl + '&sort_column=' + encodeURIComponent(sortColumn) + '&sort_order=' + sortOrder;
    }

    // Variable para mantener el estado del ordenamiento
    let currentSortColumn = '<?php echo isset($_GET['sort_column']) ? $_GET['sort_column'] : 'tt.nombre'; ?>';
    let currentSortOrder = '<?php echo isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC'; ?>';

    function sortTable(column) {
        // Si hacemos clic en la misma columna, invertir el orden
        if (currentSortColumn === column) {
            currentSortOrder = currentSortOrder === 'ASC' ? 'DESC' : 'ASC';
        } else {
            currentSortColumn = column;
            currentSortOrder = 'ASC';
        }

        // Redirigir con los parámetros de sort
        var baseUrl = '<?php echo getUrl("Tanque", "Tanque", "listar"); ?>&length=<?php echo $registrosPorPagina; ?>&page=1';
        window.location.href = baseUrl + '&sort_column=' + encodeURIComponent(column) + '&sort_order=' + currentSortOrder;
    }

    document.addEventListener('DOMContentLoaded', function() {
        // Para los formularios de HABILITAR
        const formsHabilitar = document.querySelectorAll('.form-habilitar');
        formsHabilitar.forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const url = this.action;
                const formData = new FormData(this);

                fetch(url, {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success && data.data.redirect) {
                            window.location.href = data.data.redirect;
                        } else {
                            alert(data.message || 'Ocurrió un error.');
                        }
                    })
                    .catch(error => console.error('Error:', error));
            });
        });

        // Para los enlaces de INHABILITAR
        // Nota: Esto asume que el flujo de inhabilitación pasa por una página de confirmación.
        // Si se quisiera hacer con un solo clic (con confirmación JS), el enfoque sería similar al de habilitar.
    });
</script>