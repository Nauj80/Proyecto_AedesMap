<?php

include_once '../model/Zoocriaderos/ZoocriaderoModel.php';

class ZoocriaderoController
{
    public function listar()
    {
        $objeto = new ZoocriaderoModel();
        $sql = "SELECT *, usuarios.nombre as nombre_usuario FROM zoocriaderos INNER JOIN usuarios ON zoocriaderos.id_usuario = usuarios.id_usuario";
        $zoo = $objeto->select($sql);
        $zooCria = pg_fetch_all($zoo);
        include_once '../view/zoocriaderos/ConsultarZoocriaderos.php';
    }

    public function filtro()
    {
        $objeto = new ZoocriaderoModel();
        $buscar = $_GET['buscar'];

        $sql = "SELECT zoocriaderos.*, usuarios.nombre AS nombre_usuario FROM zoocriaderos INNER JOIN usuarios ON zoocriaderos.id_usuario = usuarios.id_usuario WHERE (nombre_zoocriadero LIKE '%$buscar%' OR direccion LIKE '%$buscar%' OR usuarios.nombre LIKE '%$buscar%' OR barrio LIKE '%$buscar%');";
        $zoo = $objeto->select($sql);
        $zooCria = pg_fetch_all($zoo);
        include_once '../view/zoocriaderos/Filtro.php';
    }

    public function verDetalle()
    {
        $objeto = new ZoocriaderoModel();

        if (isset($_GET['id_zoocriadero'])) {
            $id = $_GET['id_zoocriadero'];

            $sql = "SELECT *, usuarios.nombre as nombre_usuario 
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
        $id = $_POST['id_zoocriadero'];

        $sql = "SELECT *, usuarios.nombre as nombre_usuario 
                FROM zoocriaderos 
                INNER JOIN usuarios ON zoocriaderos.id_usuario = usuarios.id_usuario 
                WHERE id_zoocriadero = $id";
        $result = $objeto->select($sql);
        $zoo = pg_fetch_assoc($result);

        include_once '../view/zoocriaderos/EditarZoocriadero.php';
    }
    /*
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

                if ($result) {
                    echo json_encode(['success' => true, 'message' => 'Actualizado correctamente']);
                } else {
                    echo json_encode(['success' => false, 'message' => 'Error al actualizar']);
                }
            }

            public function inhabilitar()
            {
                $objeto = new ZoocriaderoModel();
                $id = $_POST['id_zoocriadero'];

                $sql = "UPDATE zoocriaderos SET estado = 'inactivo' WHERE id_zoocriadero = $id";
                $result = $objeto->update($sql);

                if ($result) {
                    echo json_encode(['success' => true]);
                } else {
                    echo json_encode(['success' => false]);
                }
            }*/
}
?>