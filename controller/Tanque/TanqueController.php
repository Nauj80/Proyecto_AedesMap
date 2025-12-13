<?php

include_once '../model/Tanques/TanquesModel.php';
include_once '../model/TipoTanques/TipoTanquesModel.php';
include_once '../model/Zoocriaderos/ZoocriaderosModel.php';

class TanqueController
{
    public function getCreate()
    {

        $objZoocriadero = new ZoocriaderosModel();
        $sqlZoo = "SELECT * FROM zoocriaderos z WHERE z.id_estado_zoocriadero=1";
        $zoocriadero = $objZoocriadero->select($sqlZoo);
        $objTipoTanque = new TanquesModel();
        $sqlTipoTanque = "SELECT * FROM tipo_tanque tt WHERE tt.id_estado_tipo_tanque=1";
        $tipoTanque = $objTipoTanque->select($sqlTipoTanque);

        include_once '../view/tanque/CrearTanque.php';
    }

    public function postCreate()
    {
        $objeto = new TanquesModel();
        $zoocriadero = $_POST['zoocriadero'];
        $tipoTanque = $_POST['tipoTanque'];
        $cantidadPeces = $_POST['cantidadPeces'];
        $altoTanque = $_POST['altoTanque'];
        $anchoTanque = $_POST['anchoTanque'];
        $profundidadTanque = $_POST['profundidadTanque'];

        $id = $objeto->autoIncrement("tanques", "id_tanque");

        $sql = "INSERT INTO tanques VALUES ($id, $zoocriadero, $tipoTanque, $cantidadPeces, $anchoTanque, $altoTanque, $profundidadTanque, 1)";

        $ejecutar = $objeto->insert($sql);

        if ($ejecutar) {
            jsonResponse(true, "Tanque creado correctamente", ['redirect' => getUrl("Tanque", "Tanque", "list")]);
        } else {
            jsonResponse(false, "No se pudo registrar el tanque");
        }
    }

    public function list()
    {
        $objeto = new TanquesModel();

        // Obtener el límite de registros por página (por defecto 10)
        $registrosPorPagina = isset($_GET['length']) ? (int)$_GET['length'] : 10;

        // Obtener la página actual (por defecto 1)
        $paginaActual = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($paginaActual < 1) $paginaActual = 1;

        // Calcular el offset
        $offset = ($paginaActual - 1) * $registrosPorPagina;

        // Obtener parámetro de ordenamiento (por defecto nombre ascendente)
        $sortColumn = isset($_GET['sort_column']) ? $_GET['sort_column'] : 't.id_tanque';
        $sortOrder = isset($_GET['sort_order']) && strtoupper($_GET['sort_order']) === 'DESC' ? 'DESC' : 'ASC';

        // Validar que solo sean columnas permitidas
        $allowedColumns = ['t.id_tanque', 'zoocriadero', 'tipo_tanque'];
        if (!in_array($sortColumn, $allowedColumns)) {
            $sortColumn = 't.id_tanque';
        }

        // Obtener el total de registros
        $sqlTotal = 'SELECT COUNT(*) as total FROM tanques t, estado_tanque et WHERE t.id_estado_tanque = et.id_estado_tanque';
        $resultTotal = $objeto->select($sqlTotal);
        $totalRegistros = pg_fetch_assoc($resultTotal)['total'];

        // Obtener los registros de la página actual
        $sql = 'SELECT t.*, z.nombre_zoocriadero as zoocriadero, tt.nombre as tipo_tanque, et.nombre AS estado FROM tanques t, zoocriaderos z, tipo_tanque tt, estado_tanque et WHERE t.id_estado_tanque = et.id_estado_tanque AND t.id_zoocriadero = z.id_zoocriadero AND t.id_tipo_tanque = tt.id_tipo_tanque ORDER BY ' . $sortColumn . ' ' . $sortOrder . ' LIMIT ' . $registrosPorPagina . ' OFFSET ' . $offset;
        $Tanques = $objeto->select($sql);

        // Calcular total de páginas
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

        // Variables para la vista
        $registroInicio = ($totalRegistros > 0) ? $offset + 1 : 0;
        $registroFin = min($offset + $registrosPorPagina, $totalRegistros);

        include_once '../view/tanque/ConsultarTanque.php';
    }

    public function getUpdate()
    {
        $objeto = new TanquesModel();
        $id = $_GET['id'];

        $sql = "SELECT * FROM tanques WHERE id_tanque = $id";

        $Tanque = $objeto->select($sql);

        include_once '../view/tanque/EditarTanque.php';
    }

    public function postUpdate()
    {
        $obj = new TanquesModel();

        $id = $_POST['id'];
        $zoocriadero = $_POST['zoocriadero'];
        $tipoTanque = $_POST['tipoTanque'];
        $cantidadPeces = $_POST['cantidadPeces'];
        $altoTanque = $_POST['altoTanque'];
        $anchoTanque = $_POST['anchoTanque'];
        $profundidadTanque = $_POST['profundidadTanque'];

        $sql = "UPDATE tipo_tanque SET nombre = '$' WHERE id_tipo_tanque = $id";

        $ejecutar = $obj->update($sql);

        if ($ejecutar) {
            jsonResponse(true, "Tanque actualizado correctamente", ['redirect' => getUrl("Tanque", "Tanque", "list")]);
        } else {
            jsonResponse(false, "Hubo un problema al actualizar el tanque");
        }
    }
    public function getDelete()
    {
        $objeto = new TanquesModel();
        $id = $_GET['id'];
        $sql = "SELECT * FROM tanques WHERE id_tanque = $id";

        $Tanque = $objeto->select($sql);

        include_once '../view/tanque/EliminarTanque.php';
    }

    public function postDelete()
    {
        $objeto = new TanquesModel();
        $id = $_POST['id'];

        $sql = "UPDATE tanques SET id_estado_tanque = 2 WHERE id_tanque = $id";
        $tipoTanque = $objeto->update($sql);

        if ($tipoTanque) {
            jsonResponse(true, "Tipo tanque inhabilitado correctamente", ['redirect' => getUrl("TipoTanques", "TipoTanques", "list")]);
        } else {
            jsonResponse(false, "Hubo un problema al inhabilitar el tipo de tanque");
        }
    }

    public function postUpdateStatus()
    {
        $objeto = new TanquesModel();
        $id = $_POST['id'];
        $sql = "UPDATE tanques SET id_estado_tanque = 1 where id_tanque = $id";
        $tipoTanque = $objeto->update($sql);
        if ($tipoTanque) {
            jsonResponse(true, "Tanque habilitado correctamente", ['redirect' => getUrl("Tanque", "Tanque", "list")]);
        } else {
            jsonResponse(false, "Hubo un problema al habilitar el tanque");
        }
    }
}
