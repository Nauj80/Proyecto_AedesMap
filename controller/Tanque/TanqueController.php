<?php

include_once '../model/Tanques/TanquesModel.php';
include_once '../model/TipoTanques/TipoTanquesModel.php';
include_once '../model/Zoocriaderos/ZoocriaderoModel.php';

class TanqueController
{
    public function getCreate()
    {

        $objZoocriadero = new ZoocriaderoModel();
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
        $nombre = $_POST['nombreTanque'];
        $zoocriadero = $_POST['zoocriadero'];
        $tipoTanque = $_POST['tipoTanque'];
        $cantidadPeces = $_POST['cantidadPeces'];
        $largoTanque = $_POST['largoTanque'];
        $anchoTanque = $_POST['anchoTanque'];
        $profundidadTanque = $_POST['profundidadTanque'];

        // Validar si ya existe un tanque con el mismo nombre en el mismo zoocriadero
        $sql_check = "SELECT COUNT(*) AS total FROM tanques WHERE nombre = '$nombre' AND id_zoocriadero = $zoocriadero";
        $result_check = $objeto->select($sql_check);
        $row_check = pg_fetch_assoc($result_check);

        if ($row_check['total'] > 0) {
            jsonResponse(false, "Ya existe un tanque con este nombre en el zoocriadero seleccionado.");
        } else {
            $id = $objeto->autoIncrement("tanques", "id_tanque");

            $sql = "INSERT INTO tanques VALUES ($id, $zoocriadero, $tipoTanque, $cantidadPeces,'$nombre', $anchoTanque, $largoTanque, $profundidadTanque, 1)";

            $ejecutar = $objeto->insert($sql);

            if ($ejecutar) {
                jsonResponse(true, "Tanque creado correctamente", array('redirect' => getUrl("Tanque", "Tanque", "listar")));
            } else {
                jsonResponse(false, "No se pudo registrar el tanque");
            }
        }
    }

    public function filtro()
    {
        $objeto = new TanquesModel();
        $buscar = $_GET['buscar'];

        $sql = "SELECT 
                    tanques.*,
                    zoocriaderos.nombre_zoocriadero AS zoocriadero,
                    tipo_tanque.nombre AS tipo_tanque,
                    estado_tanque.nombre AS estado
                FROM tanques
                INNER JOIN zoocriaderos 
                    ON tanques.id_zoocriadero = zoocriaderos.id_zoocriadero
                INNER JOIN tipo_tanque 
                    ON tanques.id_tipo_tanque = tipo_tanque.id_tipo_tanque
                INNER JOIN estado_tanque 
                    ON tanques.id_estado_tanque = estado_tanque.id_estado_tanque
                WHERE (
                    zoocriaderos.nombre_zoocriadero ILIKE '%$buscar%' OR
                    tanques.nombre ILIKE '%$buscar%' OR
                    tipo_tanque.nombre ILIKE '%$buscar%' OR
                    estado_tanque.nombre ILIKE '%$buscar%'
                );
                ";
        $busq = $objeto->select($sql);
        $busqueda = pg_fetch_all($busq);

        include_once '../view/Tanque/Filtro.php';
    }

    public function listar()
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
        $allowedColumns = array('zoocriadero', 'nombre', 'tipo_tanque');
        if (!in_array($sortColumn, $allowedColumns)) {
            $sortColumn = 't.id_tanque';
        }

        // Obtener el total de registros
        $sqlTotal = 'SELECT COUNT(*) as total FROM tanques t, estado_tanque et WHERE t.id_estado_tanque = et.id_estado_tanque';
        $resultTotal = $objeto->select($sqlTotal);
        $totalRegistros = pg_fetch_assoc($resultTotal);
        $totalRegistros = $totalRegistros['total'];


        // Obtener los registros de la página actual
        $sql = 'SELECT t.*, z.nombre_zoocriadero as zoocriadero, tt.nombre as tipo_tanque, et.nombre AS estado FROM tanques t, zoocriaderos z, tipo_tanque tt, estado_tanque et WHERE t.id_estado_tanque = et.id_estado_tanque AND t.id_zoocriadero = z.id_zoocriadero AND t.id_tipo_tanque = tt.id_tipo_tanque ORDER BY ' . $sortColumn . ' ' . $sortOrder . ' LIMIT ' . $registrosPorPagina . ' OFFSET ' . $offset;
        $Tanques = $objeto->select($sql);

        // Calcular total de páginas
        $totalPaginas = ceil($totalRegistros / $registrosPorPagina);

        $sqlTCanEstados = 'SELECT es.nombre, COUNT(*) AS cantidad FROM tanques t INNER JOIN estado_tanque es ON es.id_estado_tanque = t.id_estado_tanque GROUP BY es.nombre';
        $canEstados = $objeto->select($sqlTCanEstados);


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

        $sql = "SELECT * FROM zoocriaderos";
        $zoocriadero = $objeto->select($sql);

        $sql = "SELECT * FROM tipo_tanque";
        $tipoTanque = $objeto->select($sql);

        $sql = "SELECT * FROM estado_tanque";
        $estadoTanque = $objeto->select($sql);


        include_once '../view/tanque/EditarTanque.php';
    }

    public function postUpdate()
    {
        $obj = new TanquesModel();

        $id = $_POST['id_tanque'];
        $nombre = $_POST['nombreTanque'];
        $zoocriadero = $_POST['zoocriadero'];
        $tipoTanque = $_POST['tipoTanque'];
        $cantidadPeces = $_POST['cantidadPeces'];
        $largoTanque = $_POST['largoTanque'];
        $anchoTanque = $_POST['anchoTanque'];
        $profundidadTanque = $_POST['profundidadTanque'];
        $estadoTanque = $_POST['estadoTanque'];

        // Validar si ya existe un tanque con el mismo nombre en el mismo zoocriadero
        $sql_check = "SELECT COUNT(*) AS total FROM tanques WHERE nombre = '$nombre' AND id_zoocriadero = $zoocriadero";
        $result_check = $obj->select($sql_check);
        $row_check = pg_fetch_assoc($result_check);

        if ($row_check['total'] > 0) {
            jsonResponse(false, "Ya existe un tanque con este nombre en el zoocriadero seleccionado.");
        } else {
            $sql = "UPDATE tanques SET id_zoocriadero = $zoocriadero, id_tipo_tanque = $tipoTanque, cantidad_peces = $cantidadPeces, nombre = '$nombre', ancho = $anchoTanque, alto = $largoTanque, profundo = $profundidadTanque, id_estado_tanque = $estadoTanque WHERE id_tanque = $id";

            $ejecutar = $obj->update($sql);

            if ($ejecutar) {
                jsonResponse(true, "Tanque actualizado correctamente", array('redirect' => getUrl("Tanque", "Tanque", "listar")));
            } else {
                jsonResponse(false, "Hubo un problema al actualizar el tanque");
            }
        }
    }
    public function getDelete()
    {
        $objeto = new TanquesModel();
        $id = $_GET['id'];
        $sql = "SELECT * FROM tanques WHERE id_tanque = $id";
        $Tanque = $objeto->select($sql);

        $sql = "SELECT * FROM zoocriaderos";
        $zoocriadero = $objeto->select($sql);

        $sql = "SELECT * FROM tipo_tanque";
        $tipoTanque = $objeto->select($sql);

        $sql = "SELECT * FROM estado_tanque";
        $estadoTanque = $objeto->select($sql);

        include_once '../view/tanque/EliminarTanque.php';
    }

    public function postDelete()
    {
        $objeto = new TanquesModel();
        $id = $_POST['id_tanque'];

        $sql = "UPDATE tanques SET id_estado_tanque = 2 WHERE id_tanque = $id";
        $tipoTanque = $objeto->update($sql);

        if ($tipoTanque) {
            jsonResponse(true, "Tipo tanque inhabilitado correctamente", array('redirect' => getUrl("Tanque", "Tanque", "listar")));
        } else {
            jsonResponse(false, "Hubo un problema al inhabilitar el tipo de tanque");
        }
    }

    public function postUpdateStatus()
    {
        $objeto = new TanquesModel();
        // Se busca el id del tanque en 'id_tanque' o 'id' para compatibilidad
        $id = isset($_POST['id_tanque']) ? $_POST['id_tanque'] : (isset($_POST['id']) ? $_POST['id'] : null);

        if (!$id) jsonResponse(false, "No se proporcionó el ID del tanque.");
        $sql = "UPDATE tanques SET id_estado_tanque = 1 where id_tanque = $id";
        $tipoTanque = $objeto->update($sql);
        if ($tipoTanque) {
            jsonResponse(true, "Tanque habilitado correctamente", array('redirect' => getUrl("Tanque", "Tanque", "listar")));
        } else {
            jsonResponse(false, "Hubo un problema al habilitar el tanque");
        }
    }
}
