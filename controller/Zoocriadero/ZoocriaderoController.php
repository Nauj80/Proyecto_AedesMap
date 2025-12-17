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
        /*echo '<pre>';
        echo var_dump($zooCria);*/
        include_once '../view/zoocriaderos/Filtro.php';
    }

    public function verDetalle()
    {
        $objeto = new ZoocriaderoModel();

        if (isset($_GET['id_zoocriadero'])) {
            $id = $_GET['id_zoocriadero'];

            $sql = "SELECT zoocriaderos.*, usuarios.nombre AS nombre_usuario, usuarios.apellido AS apellido_usuario, estado_zoocriadero.nombre AS estado_text
                FROM zoocriaderos 
                INNER JOIN usuarios ON zoocriaderos.id_usuario = usuarios.id_usuario 
		INNER JOIN estado_zoocriadero ON zoocriaderos.id_estado_zoocriadero = estado_zoocriadero.id_estado_zoocriadero 
                WHERE id_zoocriadero = $id";

            $result = $objeto->select($sql);
            $zooCria = pg_fetch_assoc($result);

            /*$_SESSION['console_log'][] = array(
                'pagina' => 'Zoocriadero::filtro',
                'data' => $zooCria
            );*/

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

        if ($result) {
            // Éxito: devolver JSON
            echo json_encode(array(
                'success' => true,
                'message' => 'Zoocriadero actualizado correctamente.'
            ));
        } else {
            // Error: obtener el mensaje de PostgreSQL
            $error_msg = pg_last_error($objeto->getConnect());
            $custom_message = 'Error al actualizar el zoocriadero.';

            if (strpos($error_msg, 'telefono') !== false && strpos($error_msg, 'llave duplicada') !== false) {
                $custom_message = 'Ya existe un zoocriadero con ese número de teléfono.';
            } elseif (strpos($error_msg, 'correo') !== false && strpos($error_msg, 'llave duplicada') !== false) {
                $custom_message = 'Ya existe un zoocriadero con ese correo electrónico.';
            }

            echo json_encode(array(
                'success' => false,
                'message' => $custom_message
            ));
        }
    }
    public function inhabilitar()
    {
        $objeto = new ZoocriaderoModel();

        if (isset($_POST['id_zoocriadero'])) {
            $id = $_POST['id_zoocriadero'];
            $estado_actual = $_POST['estado'];
            $nuevo_estado = $estado_actual == 1 ? 2 : 1;

            $sql = "UPDATE zoocriaderos SET id_estado_zoocriadero = $nuevo_estado WHERE id_zoocriadero = $id";
            $result = $objeto->update($sql);

            if($result){
                $_SESSION['success'] = "Zoocriadero Inhabilitado con exito";
            }else{
                $_SESSION['error'] = "No se logro inhabilitar el zoocriadero";
            }
           redirect(getUrl("Zoocriadero","Zoocriadero","listar"));
        }
    }
    public function getInhabilitar()
    {
        $objeto = new ZoocriaderoModel();

        if (isset($_GET['id_zoocriadero'])) {
            $id = $_GET['id_zoocriadero'];

            $sql = "UPDATE zoocriaderos SET id_estado_zoocriadero = 1 WHERE id_zoocriadero = $id";
            $result = $objeto->update($sql);

            if($result){
                $_SESSION['success'] = "Zoocriadero Habilitado con exito";
            }else{
                $_SESSION['error'] = "No se logro Habilitar el zoocriadero";
            }
           redirect(getUrl("Zoocriadero","Zoocriadero","listar"));
        }
    }
    public function registrar()
    {
        $objeto = new ZoocriaderoModel();

        $dir1 = $_GET['x'];
        $dir2 = $_GET['y'];
        $sqlTipoTanque = "SELECT * FROM tipo_tanque WHERE id_estado_tipo_tanque = 1";
        $tipoTanque = $objeto->select($sqlTipoTanque);
        $tiposTanque = pg_fetch_all($tipoTanque);

        $sqlusuario = "SELECT * FROM usuarios WHERE id_estado_usuario = 1";
        $usuario = $objeto->select($sqlusuario);
        $usuarios = pg_fetch_all($usuario);

        include_once '../view/zoocriaderos/RegistrarZoocriadero.php';
    }
    public function guardar()
    {
        $objeto = new ZoocriaderoModel();

        try {
            
            $nombre = $_POST['nombre'];
            $barrio = $_POST['barrio'];
            $comuna = $_POST['comuna'];
            $direccion = $_POST['direccion'];
            $telefono = $_POST['telefono'];
            $correo = $_POST['correo'];
            $latitud = $_SESSION["x"];
            $longitud = $_SESSION["y"];

            $id_encargado = (int) $_POST['id_encargado'];
            $doc_encargado = $_POST['documento_encargado'];
            $nombres_encargado = $_POST['nombres_encargado'];
            $apellidos_encargado = $_POST['apellidos_encargado'];

            $tanques = json_decode($_POST['tanques'], true);

            // =========================
            // 2. INICIAR TRANSACCIÓN
            // =========================
            pg_query($objeto->getConnect(), "BEGIN");

            // =========================
            // 3. INSERT ZOOCRIADERO
            // =========================
            $sqlZoo = "
                INSERT INTO zoocriaderos
                (
                    id_usuario,
                    nombre_zoocriadero,
                    direccion,
                    telefono,
                    comuna,
                    barrio,
                    correo,
                    id_estado_zoocriadero,
                    coordenada
                )
                VALUES
                (
                    $id_encargado,
                    '$nombre',
                    '$direccion',
                    '$telefono',
                    '$comuna',
                    '$barrio',
                    '$correo',
                    1,
                    ST_SetSRID(GeometryFromText('POINT(" . $latitud . " " . $longitud . ")'), 4326)
                )
                RETURNING id_zoocriadero
            ";

            $resultZoo = $objeto->insert($sqlZoo);

            if (!$resultZoo) {
                throw new Exception('Error al insertar zoocriadero');
            }

            $row = pg_fetch_assoc($resultZoo);
            $id_zoocriadero = $row['id_zoocriadero'];

            // =========================
            // 4. INSERT TANQUES
            // =========================
            foreach ($tanques as $tanque) {

                $id_tipo_tanque = (int) $tanque['tipo'];
                $cantidad_peces = (int) $tanque['cantidad_peces'];
                $ancho = (float) $tanque['ancho'];
                $alto = (float) $tanque['largo'];
                $profundo = (float) $tanque['profundidad'];

                $sqlTanque = "
                    INSERT INTO tanques
                    (
                        id_zoocriadero,
                        id_tipo_tanque,
                        cantidad_peces,
                        ancho,
                        alto,
                        profundo,
                        id_estado_tanque
                    )
                    VALUES
                    (
                        $id_zoocriadero,
                        $id_tipo_tanque,
                        $cantidad_peces,
                        $ancho,
                        $alto,
                        $profundo,
                        1
                    )
            ";

                if (!$objeto->insert($sqlTanque)) {
                    throw new Exception('Error al insertar tanque');
                }
            }

            // =========================
            // 5. COMMIT
            // =========================
            pg_query($objeto->getConnect(), "COMMIT");

            $_SESSION['success'] = 'Zoocriadero y tanques registrados correctamente';
        } catch (Exception $e) {

            // =========================
            // 6. ROLLBACK
            // =========================
            pg_query($objeto->getConnect(), "ROLLBACK");

            $_SESSION['error'] = 'Ocurrió un error al registrar el zoocriadero, por favor intente de nuevo';
            error_log($e->getMessage());
        }
        unset($_SESSION['x']);
        unset($_SESSION['y']);
    }
    public function tipoPermisos() {}
}
