<?php
ob_start(); // OBLIGATORIO: evita errores de headers

include_once '../model/Reportes/ReportesModel.php';

class NacidosMuertesController
{
    /* ==========================
       VISTA PRINCIPAL
    ========================== */
    function listSeguimientoTanques()
    {
        error_log('[INFO] Cargando vista principal de reporte');
        include_once '../view/reportes/NacidosMuertosReporte.php';
    }

    /* ==========================
       FILTRO + PAGINACIÓN (AJAX)
    ========================== */
    function filtroTanques()
    {
        error_log('[INFO] Ejecutando filtroTanques()');

        $model = new ReportesModel();

        $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '';
        $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '';

        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        if ($page < 1)
            $page = 1;

        $length = isset($_GET['length']) ? intval($_GET['length']) : 10;
        $offset = ($page - 1) * $length;

        $sortColumn = isset($_GET['sortColumn']) ? $_GET['sortColumn'] : 't.id_tanque';
        $sortOrder = isset($_GET['sortOrder']) ? strtoupper($_GET['sortOrder']) : 'ASC';
        if ($sortOrder !== 'DESC')
            $sortOrder = 'ASC';

        /* WHERE dinámico - PHP 5.2 usa array() */
        $where = array();

        if ($buscar !== '') {
            $b = pg_escape_string($model->getConnect(), $buscar);
            $where[] = "(z.nombre_zoocriadero ILIKE '%$b%' OR t.nombre ILIKE '%$b%')";
        }

        $whereSql = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

        /* Fechas */
        $dateCondition = '';
        if ($fechaInicio != '' && $fechaFin != '') {
            $dateCondition = "AND s.fecha BETWEEN '$fechaInicio' AND '$fechaFin'";
        } elseif ($fechaInicio != '') {
            $dateCondition = "AND s.fecha >= '$fechaInicio'";
        } elseif ($fechaFin != '') {
            $dateCondition = "AND s.fecha <= '$fechaFin'";
        }

        /* TOTAL */
        $sqlCount = "
            SELECT COUNT(DISTINCT t.id_tanque) total
            FROM tanques t
            INNER JOIN zoocriaderos z ON z.id_zoocriadero = t.id_zoocriadero
            $whereSql
        ";

        $resCount = $model->select($sqlCount);
        $totalRegistros = 0;
        if ($resCount) {
            $rowC = pg_fetch_row($resCount, 0);
            $totalRegistros = intval($rowC[0]);
        }

        $totalPaginas = ceil($totalRegistros / $length);
        if ($totalPaginas < 1)
            $totalPaginas = 1;

        /* DATOS */
        $sql = "
            SELECT
                z.id_zoocriadero,
                z.nombre_zoocriadero,
                t.id_tanque,
                t.nombre AS nombre_tanque,
                COALESCE(SUM(sd.num_alevines),0) total_nacidos,
                COALESCE(SUM(sd.num_muertos),0) total_fallecidos
            FROM tanques t
            INNER JOIN zoocriaderos z ON z.id_zoocriadero = t.id_zoocriadero
            LEFT JOIN seguimiento s ON s.id_tanque = t.id_tanque $dateCondition
            LEFT JOIN seguimiento_detalle sd ON sd.id_seguimiento = s.id_seguimiento
            $whereSql
            GROUP BY z.id_zoocriadero, z.nombre_zoocriadero, t.id_tanque, t.nombre
            ORDER BY $sortColumn $sortOrder
            LIMIT $length OFFSET $offset
        ";

        error_log('[SQL FILTRO] ' . $sql);

        $resData = $model->select($sql);
        $registros = array();
        if ($resData) {
            while ($row = pg_fetch_assoc($resData)) {
                $registros[] = $row;
            }
        }

        /* Cálculos para la vista */
        $registroInicio = ($totalRegistros > 0) ? $offset + 1 : 0;
        $registroFin = ($offset + $length > $totalRegistros) ? $totalRegistros : ($offset + $length);

        include_once '../view/reportes/FiltroReporteTanques.php';
    }

    public function descargarSeguimientoTanques()
    {
        /* =====================================================
           LIMPIAR CUALQUIER SALIDA PREVIA (CLAVE)
           ===================================================== */
        if (ob_get_length()) {
            ob_end_clean();
        }

        $model = new ReportesModel();

        /* =====================================================
           PARÁMETROS (Coincidiendo con el JS de Tanques)
           ===================================================== */
        $buscar = isset($_GET['filtro']) ? trim($_GET['filtro']) : '';
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '';
        $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '';

        /* =====================================================
           WHERE DINÁMICO
           ===================================================== */
        $where = array();
        if ($buscar !== '') {
            $b = pg_escape_string($model->getConnect(), $buscar);
            $where[] = "(z.nombre_zoocriadero ILIKE '%$b%' OR t.nombre ILIKE '%$b%')";
        }

        $dateCondition = '';
        if ($fechaInicio != '' && $fechaFin != '') {
            $dateCondition = "AND s.fecha BETWEEN '$fechaInicio' AND '$fechaFin'";
        } elseif ($fechaInicio != '') {
            $dateCondition = "AND s.fecha >= '$fechaInicio'";
        } elseif ($fechaFin != '') {
            $dateCondition = "AND s.fecha <= '$fechaFin'";
        }

        $whereSql = count($where) > 0 ? 'WHERE ' . implode(' AND ', $where) : '';

        /* =====================================================
           SQL DE TANQUES (Agrupado por Tanque)
           ===================================================== */
        $sql = "
            SELECT
                z.id_zoocriadero,
                z.nombre_zoocriadero,
                t.id_tanque,
                t.nombre AS nombre_tanque,
                COALESCE(SUM(sd.num_alevines),0) total_nacidos,
                COALESCE(SUM(sd.num_muertos),0) total_fallecidos
            FROM tanques t
            INNER JOIN zoocriaderos z ON z.id_zoocriadero = t.id_zoocriadero
            LEFT JOIN seguimiento s ON s.id_tanque = t.id_tanque $dateCondition
            LEFT JOIN seguimiento_detalle sd ON sd.id_seguimiento = s.id_seguimiento
            $whereSql
            GROUP BY z.id_zoocriadero, z.nombre_zoocriadero, t.id_tanque, t.nombre
            ORDER BY z.nombre_zoocriadero ASC, t.nombre ASC
        ";

        $result = $model->select($sql);
        $rows = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $rows[] = $row;
            }
        }

        /* =====================================================
           HEADERS EXCEL (Misma lógica que ReportesController)
           ===================================================== */
        $filename = 'Reporte_Nacidos_Muertos_Tanques_' . date('Y-m-d_H-i-s') . '.xls';

        header('Content-Type: application/vnd.ms-excel; charset=UTF-8');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        echo chr(239) . chr(187) . chr(191); // BOM UTF-8 para tildes

        /* =====================================================
           CONTENIDO EXCEL (HTML)
           ===================================================== */
        echo '<table border="1" cellpadding="5" cellspacing="0">';

        echo '<tr>
                <th colspan="6" style="background:#D9EDF7;font-size:16px;">
                    REPORTE DE NACIDOS Y MUERTOS POR TANQUE
                </th>
              </tr>';

        echo '<tr>
                <td colspan="6"><strong>Generado:</strong> ' . date('Y-m-d H:i:s') . '</td>
              </tr>';

        echo '<tr style="background:#F2F2F2;font-weight:bold;">
                <th>ID Zoocriadero</th>
                <th>Zoocriadero</th>
                <th>ID Tanque</th>
                <th>Tanque</th>
                <th>Total Nacidos (Alevines)</th>
                <th>Total Fallecidos (Muertos)</th>
            </tr>';

        if ($rows) {
            foreach ($rows as $r) {
                echo '<tr>';
                echo '<td>' . $r['id_zoocriadero'] . '</td>';
                echo '<td>' . htmlspecialchars($r['nombre_zoocriadero']) . '</td>';
                echo '<td>' . $r['id_tanque'] . '</td>';
                echo '<td>' . htmlspecialchars($r['nombre_tanque']) . '</td>';
                echo '<td style="color:green;">' . $r['total_nacidos'] . '</td>';
                echo '<td style="color:red;">' . $r['total_fallecidos'] . '</td>';
                echo '</tr>';
            }
        } else {
            echo '<tr><td colspan="6" style="text-align:center;">No hay datos para exportar</td></tr>';
        }

        echo '</table>';
        exit;
    }
}
?>