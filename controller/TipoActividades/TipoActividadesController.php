<?php

    require_once '../lib/helpers.php';
    require_once '../model/TipoActividades/TipoActividadesModel.php';
    
    class TipoActividadesController{

        public function create(){
            $objeto = new TipoActividadesModel();
            include '../view/tipoActividades/create.php';
        }

        public function postCreate(){
            $objeto = new TipoActividadesModel();
            $nombre = $_POST['nombre'];

            $id = $objeto->autoincrement("actividad","id_actividad");
            
            $sql = "INSERT INTO actividad VALUES($id, '$nombre', 1)";
            
            $ejecutar = $objeto->insert($sql);
            
            if($ejecutar){
                
                redirect(getUrl("tipoActividades","tipoActividades","list"));
                $_SESSION['success_message'] = "La actividad '$nombre' ha sido registrada correctamente.";
            }else{
                $_SESSION['error'] = "No se pudo insertar la actividad '$nombre'.
                <br>Es posible que ya exista una actividad con ese nombre. Por favor, verifique la lista.";
                
                // Redirigir de vuelta al formulario o a la lista para mostrar el mensaje
                redirect(getUrl("TipoActividades","TipoActividades","create"));
            }
        }

        public function list(){
    
            $objeto = new TipoActividadesModel();

            $sql = "SELECT a.id_actividad, a.nombre AS nombre_actividad, a.id_estado_actividad, e.nombre AS nombre_estado FROM actividad a 
            LEFT JOIN estado_actividad e ON a.id_estado_actividad = e.id_estado_actividad
            ORDER BY a.id_actividad ASC";
            
            // 1. Obtener el Recurso de PostgreSQL (resultado de la consulta)
            $result = $objeto->select($sql);

            // 2. Procesar el recurso a un Array PHP para la vista
            $actividades = [];
            if ($result) {
                while ($row = pg_fetch_assoc($result)) {
                    $actividades[] = $row;
                }
            }

            include_once '../view/tipoActividades/list.php';
        }

        public function editar(){
            $objeto = new TipoActividadesModel();

            if (isset($_GET['id'])) { // Usamos 'id' para la Actividad
                $id = $_GET['id'];

                // 1. Obtener los detalles de la Actividad
                $sql_actividad = "SELECT * FROM actividad WHERE id_actividad = $id";
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
        public function actualizar(){
            $objeto = new TipoActividadesModel();

            $id = $_POST['id_actividad'];
            $nombre = $_POST['nombre'];
            $id_estado_actividad = $_POST['id_estado_actividad'];

            // SQL para actualizar el nombre y el estado de la actividad
            $sql = "UPDATE actividad SET 
                        nombre = '$nombre',
                        id_estado_actividad = '$id_estado_actividad'
                    WHERE id_actividad = $id";

            $result = $objeto->update($sql);

            if($result){
                $_SESSION['success_message'] = "Actividad actualizada con éxito";
                redirect(getUrl("TipoActividades","TipoActividades","list"));
            }else{
                $_SESSION['error'] = "No se pudo actualizar actividad";
            }

            
            
        }

        public function delete(){
            $objeto = new TipoActividadesModel(); 

            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                $sql = "SELECT id_estado_actividad FROM actividad";

                $result = $objeto->select($sql);
                $actividadEstado = pg_fetch_assoc($result);

                $sql_estados = "SELECT id_estado_actividad, nombre FROM estado_actividad";
                $result_estados = $objeto->select($sql_estados);
                $estados = pg_fetch_all($result_estados);

                include_once '../view/tipoActividades/inhabilitar.php';
            }
        }

        public function postDelete(){
            $objeto = new TipoActividadesModel();
            
            // Aseguramos que recibimos el ID por POST (o GET, si lo manejas desde la URL, pero la modal usa POST)
            // Asumo que la modal enviará el ID por POST
            $id = isset($_POST['id_actividad_inhabilitar']) ? $_POST['id_actividad_inhabilitar'] : (isset($_GET['id']) ? $_GET['id'] : null);

            if (!$id) {
                $_SESSION['error'] = "Error: ID de seguimiento no proporcionado para la inhabilitación.";
                redirect(getUrl("tipoActividades","tipoActividades","list"));
                return;
            }

            // El estado 2 es el estado "Inhabilitado" o "Eliminado lógico"
            $sql = "UPDATE actividad SET id_estado_actividad = 2 WHERE id_actividad = $id";

            $ejecutar = $objeto->update($sql);
            
            if($ejecutar){
                $_SESSION['success_message'] = "La actividad N° $id ha sido inhabilitado correctamente.";
            }else{
                $_SESSION['error'] = "No se pudo inhabilitar la actividad N° $id. Error: " . pg_last_error($objeto->getConnect());
            }
            
            redirect(getUrl("tipoActividades","tipoActividades","list"));

        }

        public function updateStatus(){
            $objeto = new TipoActividadesModel();
            $id = $_GET['id'];

            $sql = "UPDATE actividad SET id_estado_actividad = 1 WHERE id_actividad = $id";

            $ejecutar = $objeto->update($sql);
            
            if($ejecutar){
                redirect(getUrl("TipoActividades","TipoActividades","list"));
            }else{
                echo "No se pudo habilitar la actividad";
            }
        }
    }

?>