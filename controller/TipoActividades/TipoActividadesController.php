<?php

require_once '../lib/helpers.php';
require_once '../model/TipoActividades/TipoActividadesModel.php';

class TipoActividadesController
{

    public function create()
    {
        $objeto = new TipoActividadesModel();
        include '../view/tipoActividades/create.php';
    }

    public function postCreate()
    {
        $objeto = new TipoActividadesModel();
        
        // Uso de pg_escape_string para seguridad (es crucial en esta versión)
        // Asegúrate de que $objeto->getConnect() devuelva la conexión activa
        $nombre = pg_escape_string($objeto->getConnect(), $_POST['nombre']);

        $id = $objeto->autoincrement("actividad", "id_actividad");

        // El estado 1 es 'Habilitado' o 'Activo'
        $sql = "INSERT INTO actividad VALUES(" . $id . ", '" . $nombre . "', 1)";

        $ejecutar = $objeto->insert($sql);

        if ($ejecutar) {

            // Cambio: Usar 'listar' en lugar de 'list'
            redirect(getUrl("TipoActividades", "TipoActividades", "listar"));
            
            // Cambio: Concatenación simple en lugar de sintaxis compleja
            $_SESSION['success_message'] = "La actividad '" . $nombre . "' ha sido registrada correctamente.";
        } else {
            $_SESSION['error'] = "No se pudo insertar la actividad '" . $nombre . "'.<br>Es posible que ya exista una actividad con ese nombre. Por favor, verifique la lista.";

            redirect(getUrl("TipoActividades", "TipoActividades", "create"));
        }
    }

    // RENOMBRADA DE 'list' A 'listar' por compatibilidad con PHP 5.2.5
    public function listar()
    {

        $objeto = new TipoActividadesModel();

        $sql = "SELECT a.id_actividad, a.nombre AS nombre_actividad, a.id_estado_actividad, e.nombre AS nombre_estado FROM actividad a 
        LEFT JOIN estado_actividad e ON a.id_estado_actividad = e.id_estado_actividad
        ORDER BY a.id_actividad ASC";

        // 1. Obtener el Recurso de PostgreSQL (resultado de la consulta)
        $result = $objeto->select($sql);

        // 2. Procesar el recurso a un Array PHP para la vista
        $actividades = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $actividades[] = $row;
            }
        }

        include_once '../view/tipoActividades/list.php';
    }

    public function editar()
    {
        $objeto = new TipoActividadesModel();

        if (isset($_GET['id'])) { // Usamos 'id' para la Actividad
            $id = $_GET['id'];

            // 1. Obtener los detalles de la Actividad
            $sql_actividad = "SELECT * FROM actividad WHERE id_actividad = " . $id;
            $result_actividad = $objeto->select($sql_actividad);
            $actividadDetalle = pg_fetch_assoc($result_actividad);

            // 2. Obtener la lista de Estados de Actividad (para el <select>)
            $sql_estados = "SELECT id_estado_actividad, nombre FROM estado_actividad";
            $result_estados = $objeto->select($sql_estados);
            $estadosActividad = pg_fetch_all($result_estados); // Convierte todo a un array

            // 3. Incluir la vista de edición que creamos en la respuesta anterior
            include_once '../view/tipoActividades/editar.php';
        }
    }
    
    public function actualizar()
    {
        $objeto = new TipoActividadesModel();

        $id = $_POST['id_actividad'];
        // Uso de pg_escape_string
        $nombre = pg_escape_string($objeto->getConnect(), $_POST['nombre']);
        $id_estado_actividad = $_POST['id_estado_actividad'];

        // SQL para actualizar el nombre y el estado de la actividad
        $sql = "UPDATE actividad SET 
                            nombre = '" . $nombre . "',
                            id_estado_actividad = " . $id_estado_actividad . "
                        WHERE id_actividad = " . $id;

        $result = $objeto->update($sql);

        if ($result) {
            $_SESSION['success_message'] = "Actividad actualizada con éxito";
            // Cambio: Usar 'listar' en lugar de 'list'
            redirect(getUrl("TipoActividades", "TipoActividades", "listar"));
        } else {
            $_SESSION['error'] = "No se pudo actualizar actividad";
        }
    }

    public function delete()
    {
        $objeto = new TipoActividadesModel();

        if (isset($_GET['id'])) {
            $id = $_GET['id'];

            $sql = "SELECT id_estado_actividad FROM actividad WHERE id_actividad = " . $id;

            $result = $objeto->select($sql);
            $actividadEstado = pg_fetch_assoc($result);

            $sql_estados = "SELECT id_estado_actividad, nombre FROM estado_actividad";
            $result_estados = $objeto->select($sql_estados);
            $estados = pg_fetch_all($result_estados);

            include_once '../view/tipoActividades/inhabilitar.php';
        }
    }

    public function postDelete()
    {
        $objeto = new TipoActividadesModel();

        // Aseguramos que recibimos el ID por POST (o GET)
        $id = isset($_POST['id_actividad_inhabilitar']) ? $_POST['id_actividad_inhabilitar'] : (isset($_GET['id']) ? $_GET['id'] : null);

        if (!$id) {
            $_SESSION['error'] = "Error: ID de seguimiento no proporcionado para la inhabilitación.";
            // Cambio: Usar 'listar' en lugar de 'list'
            redirect(getUrl("TipoActividades", "TipoActividades", "listar"));
            return;
        }

        // El estado 2 es el estado "Inhabilitado" o "Eliminado lógico"
        $sql = "UPDATE actividad SET id_estado_actividad = 2 WHERE id_actividad = " . $id;

        $ejecutar = $objeto->update($sql);

        if ($ejecutar) {
            // Cambio: Concatenación simple en lugar de sintaxis compleja
            $_SESSION['success_message'] = "La actividad N° " . $id . " ha sido inhabilitado correctamente.";
        } else {
            // Cambio: Concatenación simple
            $_SESSION['error'] = "No se pudo inhabilitar la actividad N° " . $id . ". Error: " . pg_last_error($objeto->getConnect());
        }

        // Cambio: Usar 'listar' en lugar de 'list'
        redirect(getUrl("TipoActividades", "TipoActividades", "listar"));
    }

    public function updateStatus()
    {
        $objeto = new TipoActividadesModel();
        $id = $_GET['id'];

        $sql = "UPDATE actividad SET id_estado_actividad = 1 WHERE id_actividad = " . $id;

        $ejecutar = $objeto->update($sql);

        if ($ejecutar) {
            // Cambio: Usar 'listar' en lugar de 'list'
            redirect(getUrl("TipoActividades", "TipoActividades", "listar"));
        } else {
            echo "No se pudo habilitar la actividad";
        }
    }
}

?>