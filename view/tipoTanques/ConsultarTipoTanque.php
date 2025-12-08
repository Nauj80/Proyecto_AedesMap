<?php
include_once '../lib/helpers.php';
include_once '../lib/helpersLogin.php';
include_once '../view/partials/header.php';
?>

<body>
    <div class="page-header">
        <h3 class="fw-bold mb-3">Consultar tipo de tanque</h3>
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
                <a href="">Tipo de tanque</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
            <li class="nav-item">
                <a href="<?php echo getUrl("TipoTanques", "TipoTanques", "list"); ?>">Consultar tipo de tanque</a>
            </li>
        </ul>

    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex align-items-center">
                        <h4 class="card-title">Tipos de Tanques</h4>
                        <a class="btn btn-primary btn-round ms-auto" href="<?php echo getUrl("TipoTanques", "TipoTanques", "getCreate"); ?>">
                            <i class="fa fa-plus"></i>
                            Crear Tipo de tanque
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
                                <div class="col-sm-12 col-md-6">
                                    <div id="add-row_filter" class="dataTables_filter"><label>Buscar:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="add-row"></label></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="add-row" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="add-row_info">
                                        <thead>
                                            <tr role="row">
                                                <th class="sorting_asc" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Name: activate to sort column descending" style="width: 368.422px; cursor: pointer;" onclick="sortTable('tt.nombre')">Nombre</th>
                                                <th class="sorting" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-label="Position: activate to sort column ascending" style="width: 527.906px; cursor: pointer;" onclick="sortTable('ett.nombre')">Estado</th>
                                                <th style="width: 120.688px;" class="sorting" tabindex="0" aria-controls="add-row" rowspan="1" colspan="1" aria-label="Action: activate to sort column ascending">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th rowspan="1" colspan="1">Nombre</th>
                                                <th rowspan="1" colspan="1">Estado</th>
                                                <th rowspan="1" colspan="1">Acciones</th>
                                            </tr>
                                        </tfoot>

                                        <tbody>
                                            <?php

                                            while ($tipoTanque = pg_fetch_assoc($tipoTanques)) {
                                                $tipoTanque['id'] % 2 == 0 ? $colorTabla = "odd" : $colorTabla = "odd";

                                                print_r(
                                                    '
                                                    <tr role="row" class="' . $colorTabla . '">
                                                        <td class="sorting_1">' . $tipoTanque["nombre"] . '</td>
                                                        <td>' . $tipoTanque["estado"] . '</td>
                                                        <td>
                                                            <div class="form-button-action">
                                                                <a type="button" class="btn btn-link btn-primary btn-lg" href=' . getUrl("TipoTanques", "TipoTanques", "getUpdate", array("id" => $tipoTanque['id'])) . '>
                                                                    <i class="fa fa-edit"></i>
                                                                </a>
                                                                '
                                                );
                                                if ($tipoTanque['id_estado'] == 1) {

                                                    print_r('
                                                                <a type="button" class="btn btn-link btn-danger btn-lg" href=' . getUrl("TipoTanques", "TipoTanques", "getDelete", array("id" => $tipoTanque['id'])) . '>
                                                                    <i class="fa fa-times"></i>
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    ');
                                                } elseif ($tipoTanque['id_estado'] == 2) {
                                                    print_r('
                                                                <form action="index.php?modulo=TipoTanques&controlador=TipoTanques&funcion=postUpdateStatus" method="post" style="display: inline;" class="btn-lg">
                                                                    <input type="hidden" name="id" value="' . $tipoTanque['id'] . '">
                                                                    <button type="submit" class="btn btn-link btn-success" style="border: none; background: none; padding: 0;">
                                                                        <i class="fa fa-check"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    ');
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
                                                echo '<li class="paginate_button page-item previous"><a href="' . getUrl("TipoTanques", "TipoTanques", "list") . '&length=' . $registrosPorPagina . '&page=' . $paginaAnterior . '" class="page-link">Anterior</a></li>';
                                            } else {
                                                echo '<li class="paginate_button page-item previous disabled"><a href="#" class="page-link">Anterior</a></li>';
                                            }

                                            // Generar botones de páginas
                                            for ($i = 1; $i <= $totalPaginas; $i++) {
                                                if ($i == $paginaActual) {
                                                    echo '<li class="paginate_button page-item active"><a href="#" class="page-link">' . $i . '</a></li>';
                                                } else {
                                                    $sortParams = isset($_GET['sort_column']) ? '&sort_column=' . $_GET['sort_column'] . '&sort_order=' . $_GET['sort_order'] : '';
                                                    echo '<li class="paginate_button page-item"><a href="' . getUrl("TipoTanques", "TipoTanques", "list") . '&length=' . $registrosPorPagina . '&page=' . $i . $sortParams . '" class="page-link">' . $i . '</a></li>';
                                                }
                                            }

                                            // Botón Siguiente
                                            if ($paginaActual < $totalPaginas) {
                                                $paginaSiguiente = $paginaActual + 1;
                                                $sortParams = isset($_GET['sort_column']) ? '&sort_column=' . $_GET['sort_column'] . '&sort_order=' . $_GET['sort_order'] : '';
                                                echo '<li class="paginate_button page-item next"><a href="' . getUrl("TipoTanques", "TipoTanques", "list") . '&length=' . $registrosPorPagina . '&page=' . $paginaSiguiente . $sortParams . '" class="page-link">Siguiente</a></li>';
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

</html>

<script>
    function cambiarRegistrosPorPagina(valor) {
        // Redirigir a la misma página con el nuevo parámetro de límite, manteniendo sort
        var sortColumn = '<?php echo isset($_GET['sort_column']) ? $_GET['sort_column'] : 'tt.nombre'; ?>';
        var sortOrder = '<?php echo isset($_GET['sort_order']) ? $_GET['sort_order'] : 'ASC'; ?>';
        var baseUrl = '<?php echo getUrl("TipoTanques", "TipoTanques", "list"); ?>&length=' + valor + '&page=1';
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
        var baseUrl = '<?php echo getUrl("TipoTanques", "TipoTanques", "list"); ?>&length=<?php echo $registrosPorPagina; ?>&page=1';
        window.location.href = baseUrl + '&sort_column=' + encodeURIComponent(column) + '&sort_order=' + currentSortOrder;
    }
</script>