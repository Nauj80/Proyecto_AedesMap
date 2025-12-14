<?php

include_once '../model/TipoTanques/TipoTanquesModel.php';

class TipoTanquesController
{
    public function getCreate()
    {
        include_once '../view/tipoTanques/CrearTipoTanque.php';
    }

    public function postCreate()
    {

        $objeto = new TipoTanquesModel();
        $nombre = $_POST['nombreTipoTanque'];

        $id = $objeto->autoIncrement("tipo_tanque", "id_tipo_tanque");

        $sql = "INSERT INTO tipo_tanque VALUES($id, 1, '$nombre')";

        $ejecutar = $objeto->insert($sql);

        if ($ejecutar) {
            jsonResponse(true, "Tipo de tanque creado correctamente", array('redirect' => getUrl("TipoTanques", "TipoTanques", "listar")));
        } else {
            jsonResponse(false, "No se pudo registrar el tipo de tanque");
        }
    }

    public function listar()
    {
        $objeto = new TipoTanquesModel();

        // Obtener el límite de registros por página (por defecto 10)
        $registrosPorPagina = isset($_GET['length']) ? (int)$_GET['length'] : 10;

        // Obtener la página actual (por defecto 1)
        $paginaActual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($paginaActual < 1) $paginaActual = 1;

        // Calcular el offset
        $offset = ($paginaActual - 1) * $registrosPorPagina;

        // Obtener parámetro de ordenamiento (por defecto nombre ascendente)
        $sortColumn = isset($_GET['sort_column']) ? $_GET['sort_column'] : 'tt.nombre';
        $sortOrder = isset($_GET['sort_order']) && strtoupper($_GET['sort_order']) === 'DESC' ? 'DESC' : 'ASC';

        // Validar que solo sean columnas permitidas
        $allowedColumns = array('tt.nombre', 'ett.nombre');
        if (!in_array($sortColumn, $allowedColumns)) {
            $sortColumn = 'tt.nombre';
        }

        // Obtener el total de registros
        $sqlTotal = 'SELECT COUNT(*) as total FROM tipo_tanque tt, estado_tipo_tanque ett WHERE tt.id_estado_tipo_tanque = ett.id_estado_tipo_tanque';
        $resultTotal = $objeto->select($sqlTotal);
        $totalRegistros = pg_fetch_assoc($resultTotal);
        $totalRegistros = $totalRegistros['total'];


        // Obtener los registros de la página actual
        $sql = 'SELECT tt.*, ett.nombre AS estado FROM tipo_tanque tt, estado_tipo_tanque ett WHERE tt.id_estado_tipo_tanque = ett.id_estado_tipo_tanque ORDER BY ' . $sortColumn . ' ' . $sortOrder . ' LIMIT ' . $registrosPorPagina . ' OFFSET ' . $offset;
        $tipoTanques = $objeto->select($sql);

        // Calcular total de páginas
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

        // Variables para la vista
        $registroInicio = ($totalRegistros > 0) ? $offset + 1 : 0;
        $registroFin = min($offset + $registrosPorPagina, $totalRegistros);

        $sqlTCanEstados = 'SELECT es.nombre, COUNT(*) AS cantidad FROM tipo_tanque t INNER JOIN estado_tipo_tanque es ON es.id_estado_tipo_tanque = t.id_estado_tipo_tanque GROUP BY es.nombre';
        $canEstados = $objeto->select($sqlTCanEstados);

        include_once '../view/tipoTanques/ConsultarTipoTanque.php';
    }

    public function getUpdate()
    {
        $objeto = new TipoTanquesModel();
        $id = $_GET['id'];

        $sql = "SELECT * FROM tipo_tanque WHERE id_tipo_tanque = $id";
        $tipoTanque = $objeto->select($sql);

        $sql = "SELECT * FROM estado_tipo_tanque";
        $estadoTipoTanque = $objeto->select($sql);

        include_once '../view/tipoTanques/EditarTipoTanque.php';
    }

    public function postUpdate()
    {
        $obj = new TipoTanquesModel();

        $id = $_POST['id'];
        $nombre = $_POST['nombreTipoTanque'];
        $estado = $_POST['estadoTipoTanque'];


        $sql = "UPDATE tipo_tanque SET nombre = '$nombre', id_estado_tipo_tanque = $estado WHERE id_tipo_tanque = $id";

        $ejecutar = $obj->update($sql);

        if ($ejecutar) {
            jsonResponse(true, "Tipo de tanque actualizado correctamente", array('redirect' => getUrl("TipoTanques", "TipoTanques", "listar")));
        } else {
            jsonResponse(false, "Hubo un problema al actualizar el tipo de tanque");
        }
    }
    public function getDelete()
    {
        $objeto = new TipoTanquesModel();
        $id = $_GET['id'];
        $sql = "SELECT * FROM tipo_tanque WHERE id_tipo_tanque = $id";

        $tipoTanque = $objeto->select($sql);

        include_once '../view/tipoTanques/EliminarTipoTanque.php';
    }

    public function postDelete()
    {
        $objeto = new TipoTanquesModel();
        $id = $_POST['id'];

        $sql = "UPDATE tipo_tanque SET id_estado_tipo_tanque = 2 WHERE id_tipo_tanque = $id";
        $tipoTanque = $objeto->update($sql);

        if ($tipoTanque) {
            jsonResponse(true, "Tipo de tanque inhabilitado correctamente", array('redirect' => getUrl("TipoTanques", "TipoTanques", "listar")));
        } else {
            jsonResponse(false, "Hubo un problema al inhabilitar el tipo de tanque");
        }
    }

    public function postUpdateStatus()
    {
        $objeto = new TipoTanquesModel();
        $id = $_POST['id'];
        $sql = "UPDATE tipo_tanque SET id_estado_tipo_tanque = 1 where id_tipo_tanque = $id";
        $tipoTanque = $objeto->update($sql);
        if ($tipoTanque) {
            jsonResponse(true, "Tipo de tanque habilitado correctamente", array('redirect' => getUrl("TipoTanques", "TipoTanques", "listar")));
        } else {
            jsonResponse(false, "Hubo un problema al habilitar el tipo de tanque");
        }
    }
}
