<?php

include_once '../model/Zoocriaderos/ZoocriaderoModel.php';

class ZoocriaderoController
{
    public function listar()
    {
        $objeto = new ZoocriaderoModel();
        $sql = "SELECT zoocriaderos.*, usuarios.nombre as nombre_usuario FROM zoocriaderos INNER JOIN usuarios ON zoocriaderos.id_usuario = usuarios.id_usuario";
        $zoo = $objeto->select($sql);
        $zooCria = pg_fetch_all($zoo);
        include_once '../view/zoocriaderos/ConsultarZoocriaderos.php';
    }

    public function filtro()
    {
        $objeto = new ZoocriaderoModel();
        $buscar = $_GET['buscar'];

        $sql = "SELECT zoocriaderos.*, usuarios.nombre AS nombre_usuario FROM zoocriaderos INNER JOIN usuarios ON zoocriaderos.id_usuario = usuarios.id_usuario WHERE (nombre_zoocriadero ILIKE '%$buscar%' OR direccion ILIKE '%$buscar%' OR usuarios.nombre ILIKE '%$buscar%' OR barrio ILIKE '%$buscar%')";
        $zoo = $objeto->select($sql);
        $zooCria = pg_fetch_all($zoo);
        include_once '../view/zoocriaderos/Filtro.php';
    }

    public function verDetalle()
    {
        $objeto = new ZoocriaderoModel();

        if (isset($_GET['id_zoocriadero'])) {
            $id = $_GET['id_zoocriadero'];

            $sql = "SELECT zoocriaderos.*, usuarios.nombre AS nombre_usuario 
                FROM zoocriaderos 
                INNER JOIN usuarios ON zoocriaderos.id_usuario = usuarios.id_usuario 
                WHERE id_zoocriadero = $id";

            $result = $objeto->select($sql);
            $zooCria = pg_fetch_assoc($result);

            include_once '../view/zoocriaderos/DetalleZoocriadero.php';
        }
    }

    public function editar()
    {
        $objeto = new ZoocriaderoModel();

        if (isset($_GET['id_zoocriadero'])) {
            $id = $_GET['id_zoocriadero'];

            $sql = "SELECT zoocriaderos.*, usuarios.nombre AS nombre_usuario 
                FROM zoocriaderos 
                INNER JOIN usuarios ON zoocriaderos.id_usuario = usuarios.id_usuario 
                WHERE id_zoocriadero = $id";

            $result = $objeto->select($sql);
            $zooCria = pg_fetch_assoc($result);

            include_once '../view/zoocriaderos/EditarZoocriadero.php';
        }
    }
    public function actualizar()
    {
        $objeto = new ZoocriaderoModel();
        $id = $_POST['id_zoocriadero'];
        $nombre = $_POST['nombre_zoocriadero'];
        $direccion = $_POST['direccion'];
        $barrio = $_POST['barrio'];
        $telefono = $_POST['telefono'];
        $correo = $_POST['correo'];

        $sql = "UPDATE zoocriaderos SET 
                        nombre_zoocriadero = '$nombre',
                        direccion = '$direccion',
                        barrio = '$barrio',
                        telefono = '$telefono',
                        correo = '$correo'
                        WHERE id_zoocriadero = $id";

        $result = $objeto->update($sql);

        if (!$result) {
            $error_msg = pg_last_error($objeto->getConnect());
            if (strpos($error_msg, 'telefono') !== false && strpos($error_msg, 'llave duplicada') !== false) {
                $_SESSION['error'] = 'Ya existe un zoocriadero con ese número de teléfono.';
            } elseif (strpos($error_msg, 'correo') !== false && strpos($error_msg, 'llave duplicada') !== false) {
                $_SESSION['error'] = 'Ya existe un zoocriadero con ese correo electrónico.';
            } else {
                $_SESSION['error'] = 'Error al actualizar el zoocriadero';
            }
        }

        // Redirigir de vuelta a la lista
        redirect(getUrl("Zoocriadero", "Zoocriadero", "listar"));
    }
    public function inhabilitar()
    {
        $objeto = new ZoocriaderoModel();

        if (isset($_GET['id_zoocriadero']) && isset($_GET['estado'])) {
            $id = $_GET['id_zoocriadero'];
            $estado_actual = $_GET['estado'];
            $nuevo_estado = $estado_actual == 1 ? 2 : 1; // 1=activo, 2=inactivo

            $sql = "UPDATE zoocriaderos SET id_estado_zoocriadero = $nuevo_estado WHERE id_zoocriadero = $id";
            $result = $objeto->update($sql);

            if ($result) {
                $accion = $nuevo_estado == 1 ? 'habilitado' : 'inhabilitado';
                echo json_encode(['success' => true, 'message' => "Zoocriadero $accion correctamente."]);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error al cambiar el estado del zoocriadero.']);
            }
        }
    }
    public function registrar()
    {
        $objeto = new ZoocriaderoModel();
        $sqlTipoTanque = "SELECT * FROM tipo_tanque WHERE id_estado_tipo_tanque = 1";
        $tipoTanque = $objeto->select($sqlTipoTanque);
        $tiposTanque = pg_fetch_all($tipoTanque);
        include_once '../view/zoocriaderos/RegistrarZoocriadero.php';
    }
    public function guardar()
    {
        $objeto = new ZoocriaderoModel();
        // Aquí iría la lógica para guardar un nuevo zoocriadero
        // Recoger datos del formulario, validar, y luego insertar en la base de datos
        if (isset($_SESSION['GuardadarZoocriadero'])) {
            dd($_SESSION['GuardadarZoocriadero']);
        }
    }
}
?>