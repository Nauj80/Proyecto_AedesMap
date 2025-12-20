<?php

include_once '../model/Reportes/ReportesModel.php';

class ReportesController
{
    public function listSeguimientoActividad()
    {
        include_once '../view/reportes/seguimientoActividad.php';
    }

    public function filtro()
    {
        $model = new ReportesModel();

        // Obtener parámetros
        $buscar = isset($_GET['buscar']) ? trim($_GET['buscar']) : '';
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '';
        $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '';
        $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
        $length = isset($_GET['length']) ? intval($_GET['length']) : 10;
        $sortColumn = isset($_GET['sortColumn']) ? $_GET['sortColumn'] : 's.id_seguimiento';
        $sortOrder = isset($_GET['sortOrder']) ? $_GET['sortOrder'] : 'DESC';

        // Asegurar que page sea al menos 1
        if ($page < 1) {
            $page = 1;
        }

        // Calcular offset
        $offset = ($page - 1) * $length;

        // Construir WHERE para filtros
        $whereConditions = array();

        if (!empty($buscar)) {
            $buscarEscaped = pg_escape_string($model->getConnect(), $buscar);
            $whereConditions[] = "(z.nombre_zoocriadero ILIKE '%{$buscarEscaped}%' 
                               OR t.nombre ILIKE '%{$buscarEscaped}%' 
                               OR u.nombre ILIKE '%{$buscarEscaped}%' 
                               OR u.apellido ILIKE '%{$buscarEscaped}%')";
        }

        if (!empty($fechaInicio)) {
            $fechaInicioEscaped = pg_escape_string($model->getConnect(), $fechaInicio);
            $whereConditions[] = "s.fecha >= '{$fechaInicioEscaped}'";
        }

        if (!empty($fechaFin)) {
            $fechaFinEscaped = pg_escape_string($model->getConnect(), $fechaFin);
            $whereConditions[] = "s.fecha <= '{$fechaFinEscaped}'";
        }

        $whereClause = !empty($whereConditions) ? "WHERE " . implode(" AND ", $whereConditions) : "";

        // Validar columna de ordenamiento
        $columnasPermitidas = array(
            's.id_seguimiento',
            'z.nombre_zoocriadero',
            't.nombre',
            'u.documento',
            'u.nombre',
            's.fecha',
            'es.nombre'
        );

        if (!in_array($sortColumn, $columnasPermitidas)) {
            $sortColumn = 's.id_seguimiento';
        }

        $sortOrder = strtoupper($sortOrder) === 'DESC' ? 'DESC' : 'ASC';

        // Consulta para contar total
        $sqlCount = "SELECT COUNT(DISTINCT s.id_seguimiento) as total
        FROM seguimiento s
        INNER JOIN estado_seguimiento es ON es.id_estado_seguimiento = s.id_estado_seguimiento
        INNER JOIN seguimiento_detalle sd ON sd.id_seguimiento = s.id_seguimiento
        INNER JOIN tanques t ON t.id_tanque = s.id_tanque
        INNER JOIN zoocriaderos z ON z.id_zoocriadero = t.id_zoocriadero
        INNER JOIN usuarios u ON u.id_usuario = s.id_usuario
        $whereClause";

        $resultCount = $model->select($sqlCount);
        $rowCount = pg_fetch_assoc($resultCount);
        $totalRegistros = intval($rowCount['total']);

        // Calcular total de páginas
        $totalPaginas = $totalRegistros > 0 ? intval(ceil($totalRegistros / $length)) : 1;

        // Consulta para obtener datos
        $sql = "SELECT
        s.id_seguimiento,
        s.fecha AS fecha_seguimiento,
        es.nombre AS estado_seguimiento,
        u.documento,
        u.nombre,
        u.apellido,
        z.nombre_zoocriadero,
        t.nombre AS nombre_tanque
        FROM seguimiento s
        INNER JOIN estado_seguimiento es ON es.id_estado_seguimiento = s.id_estado_seguimiento
        INNER JOIN seguimiento_detalle sd ON sd.id_seguimiento = s.id_seguimiento
        INNER JOIN tanques t ON t.id_tanque = s.id_tanque
        INNER JOIN zoocriaderos z ON z.id_zoocriadero = t.id_zoocriadero
        INNER JOIN usuarios u ON u.id_usuario = s.id_usuario
        $whereClause
        GROUP BY s.id_seguimiento, s.fecha, es.nombre, u.documento, u.nombre, u.apellido, z.nombre_zoocriadero, t.nombre
        ORDER BY $sortColumn $sortOrder
        LIMIT $length OFFSET $offset";

        $result = $model->select($sql);
        $registros = pg_fetch_all($result);

        // Calcular registros inicio y fin
        $registroInicio = $totalRegistros > 0 ? $offset + 1 : 0;
        $registroFin = min($offset + $length, $totalRegistros);

        // Debug - puedes comentar esto después
        error_log("Page: $page, Length: $length, Offset: $offset, Total: $totalRegistros, TotalPaginas: $totalPaginas");

        include_once '../view/reportes/FiltroReporteActividad.php';
    }
    public function descargarSeguimiento()
    {
        /* =====================================================
           LIMPIAR CUALQUIER SALIDA PREVIA (CLAVE)
           ===================================================== */
        if (ob_get_length()) {
            ob_end_clean();
        }

        $model = new ReportesModel();

        /* =====================================================
           PARÁMETROS (PHP 5.2)
           ===================================================== */
        $buscar = isset($_GET['filtro']) ? trim($_GET['filtro']) : '';
        $fechaInicio = isset($_GET['fechaInicio']) ? $_GET['fechaInicio'] : '';
        $fechaFin = isset($_GET['fechaFin']) ? $_GET['fechaFin'] : '';

        /* =====================================================
           WHERE DINÁMICO
           ===================================================== */
        $where = array();

        if ($buscar != '') {
            $b = pg_escape_string($model->getConnect(), $buscar);
            $where[] = "(z.nombre_zoocriadero ILIKE '%$b%'
                  OR t.nombre ILIKE '%$b%'
                  OR u.nombre ILIKE '%$b%'
                  OR u.apellido ILIKE '%$b%')";
        }

        if ($fechaInicio != '') {
            $fi = pg_escape_string($model->getConnect(), $fechaInicio);
            $where[] = "s.fecha >= '$fi'";
        }

        if ($fechaFin != '') {
            $ff = pg_escape_string($model->getConnect(), $fechaFin);
            $where[] = "s.fecha <= '$ff'";
        }

        $whereSql = count($where) ? 'WHERE ' . implode(' AND ', $where) : '';

        /* =====================================================
           SQL COMPLETO
           ===================================================== */
        $sql = "
    SELECT
        z.id_zoocriadero,
        z.nombre_zoocriadero,
        ez.nombre AS estado_zoocriadero,

        u.documento,
        u.nombre,
        u.apellido,
        r.nombre AS nombre_rol,

        s.id_seguimiento,
        s.fecha AS fecha_seguimiento,

        t.nombre AS tanque_nombre,

        sd.id_seguimiento_detalle,
        a.nombre AS nombre_actividad,
        sd.num_alevines,
        sd.num_muertos,
        sd.num_machos,
        sd.ph,
        sd.temperatura,
        sd.cloro,
        sd.observaciones

    FROM seguimiento s
    INNER JOIN seguimiento_detalle sd ON sd.id_seguimiento = s.id_seguimiento
    INNER JOIN actividad a ON a.id_actividad = sd.id_actividad
    INNER JOIN tanques t ON t.id_tanque = s.id_tanque
    INNER JOIN zoocriaderos z ON z.id_zoocriadero = t.id_zoocriadero
    INNER JOIN estado_zoocriadero ez ON ez.id_estado_zoocriadero = z.id_estado_zoocriadero
    INNER JOIN usuarios u ON u.id_usuario = s.id_usuario
    INNER JOIN roles r ON r.id_rol = u.id_rol
    $whereSql
    ORDER BY z.id_zoocriadero, s.fecha DESC
    ";

        $result = $model->select($sql);
        $rows = pg_fetch_all($result);

        /* =====================================================
           HEADERS EXCEL (NO FALLAN)
           ===================================================== */
        $filename = 'Reporte_Seguimiento_' . date('Y-m-d_H-i-s') . '.xls';

        header('Content-Type: text/csv; charset=UTF-8');
        header("Content-Disposition: attachment; filename=\"$filename\"");

        echo chr(239) . chr(187) . chr(191); // BOM UTF-8

        /* =====================================================
           CONTENIDO EXCEL (HTML)
           ===================================================== */
        echo '<table border="1" cellpadding="5" cellspacing="0">';

        echo '<tr>
            <th colspan="19" style="background:#D9EDF7;font-size:16px;">
                REPORTE DE SEGUIMIENTO DE ZOOCRIADEROS
            </th>
          </tr>';

        echo '<tr>
            <td colspan="19"><strong>Generado:</strong> ' . date('Y-m-d H:i:s') . '</td>
          </tr>';

        echo '<tr style="background:#F2F2F2;font-weight:bold;">
        <th>ID Zoocriadero</th>
        <th>Zoocriadero</th>
        <th>Estado</th>
        <th>Documento</th>
        <th>Nombres</th>
        <th>Apellidos</th>
        <th>Rol</th>
        <th>ID Seguimiento</th>
        <th>Fecha</th>
        <th>Tanque</th>
        <th>ID Detalle</th>
        <th>Actividad</th>
        <th>Alevines</th>
        <th>Muertos</th>
        <th>Machos</th>
        <th>PH</th>
        <th>Temperatura</th>
        <th>Cloro</th>
        <th>Observaciones</th>
    </tr>';

        if ($rows) {
            foreach ($rows as $r) {
                echo '<tr>';
                echo '<td>' . $r['id_zoocriadero'] . '</td>';
                echo '<td>' . $r['nombre_zoocriadero'] . '</td>';
                echo '<td>' . $r['estado_zoocriadero'] . '</td>';
                echo '<td>' . $r['documento'] . '</td>';
                echo '<td>' . $r['nombre'] . '</td>';
                echo '<td>' . $r['apellido'] . '</td>';
                echo '<td>' . $r['nombre_rol'] . '</td>';
                echo '<td>' . $r['id_seguimiento'] . '</td>';
                echo '<td>' . $r['fecha_seguimiento'] . '</td>';
                echo '<td>' . $r['tanque_nombre'] . '</td>';
                echo '<td>' . $r['id_seguimiento_detalle'] . '</td>';
                echo '<td>' . $r['nombre_actividad'] . '</td>';
                echo '<td>' . $r['num_alevines'] . '</td>';
                echo '<td>' . $r['num_muertos'] . '</td>';
                echo '<td>' . $r['num_machos'] . '</td>';
                echo '<td>' . $r['ph'] . '</td>';
                echo '<td>' . $r['temperatura'] . '</td>';
                echo '<td>' . $r['cloro'] . '</td>';
                echo '<td>' . $r['observaciones'] . '</td>';
                echo '</tr>';
            }
        }

        echo '</table>';
        exit;
    }


}