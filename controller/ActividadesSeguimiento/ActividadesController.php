<?php

require_once '../lib/helpers.php';
require_once '../model/Actividades/ActividadesModel.php';

class ActividadesController
{

    public function create()
    {
        $objeto = new ActividadesModel();

        $sql_zoos = "SELECT id_zoocriadero, nombre_zoocriadero FROM zoocriaderos WHERE id_estado_zoocriadero = 1";
        $sql_actividades = "SELECT id_actividad, nombre FROM actividad WHERE id_estado_actividad = 1";


        $result_zoos = $objeto->select($sql_zoos);
        $result_actividades = $objeto->select($sql_actividades);


        $zoocriaderos = array();
        if ($result_zoos) {
            while ($row = pg_fetch_assoc($result_zoos)) {
                $zoocriaderos[] = $row;
            }
        }


        $actividades = array();
        if ($result_actividades) {
            while ($row = pg_fetch_assoc($result_actividades)) {
                $actividades[] = $row;
            }
        }

        include '../view/ActividadesSeguimiento/create.php';
    }

    public function getTanquesByZoo()
    {
        // Seguridad: Asegurar que el valor es un entero
        $id_zoocriadero = (int)$_GET['id_zoocriadero'];

        $objeto = new ActividadesModel();
        $tanques = array();

        $sql = "SELECT t.id_tanque, t.nombre AS nombre_tanque, tt.nombre AS nombre_tipo 
                FROM tanques t 
                JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id_tipo_tanque 
                WHERE id_zoocriadero = " . $id_zoocriadero . " AND id_estado_tanque = 1";


        $result = $objeto->select($sql);


        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $tanques[] = $row;
            }
        }
        
        // El output en esta función es HTML directo para un select (AJAX)
        foreach ($tanques as $tan) {
            echo "<option value='" . $tan['id_tanque'] . "'>" . $tan['nombre_tanque'] . " (" . $tan['nombre_tipo'] . ")</option>";
        }
    }

    public function getCantidadPecesByTanque()
    {

        header('Content-Type: application/json');
        // Seguridad: Asegurar que el valor es un entero
        $id_tanque = (int)$_GET['id_tanque'];
        
        $objeto = new ActividadesModel();
        $response = array('success' => false, 'cantidad' => 0);

        $sql = "SELECT cantidad_peces FROM tanques WHERE id_tanque = " . $id_tanque;


        $result = $objeto->select($sql);


        if ($result && pg_num_rows($result) > 0) {
            $data = pg_fetch_assoc($result);
            $response['cantidad'] = (int)($data['cantidad_peces']);
            $response['success'] = true;
        }

        echo json_encode($response);
    }

    public function postCreate()
    {

        $objeto = new ActividadesModel();

        // En PHP 5.2, se debe manejar la excepción con 'catch' si el código lo usa,
        // pero la sintaxis de 'try...catch' es compatible desde PHP 5.0.
        try {
            $conexion = $objeto->getConnect();
            
            $fecha_actual = date('Y-m-d');
            
            // Conversión a int y escape
            $id_zoocriadero = (int)$_POST['id_zoocriadero'];
            $id_tanque = (int)$_POST['id_tanque'];
            $id_actividad = (int)$_POST['id_actividad'];
            
            $ph = pg_escape_string($conexion, $_POST['ph']);
            $temperatura = pg_escape_string($conexion, $_POST['temperatura']);
            $cloro = pg_escape_string($conexion, $_POST['cloro']);

            $num_alevines = (int)$_POST['num_alevines'];
            $num_muertes_hembras = (int)$_POST['num_muertes_hembras'];
            $num_muertes_machos = (int)$_POST['num_muertes_machos'];
            // Escape de string largo
            $observaciones = pg_escape_string($conexion, $_POST['observaciones']);

            $cantidad_inicial = (int)$_POST['cantidad_inicial_tanque'];

            $num_muertes_total = $num_muertes_hembras + $num_muertes_machos;

            $poblacion_final = $cantidad_inicial + $num_alevines - $num_muertes_total;
            
            // --- VALIDACIÓN DE SESIÓN Y DATOS ---
            if (!isset($_SESSION['usuario']['id'])) {
                $_SESSION['error'] = "Error de sesión: ID de usuario no encontrado.";
                redirect(getUrl("Login", "Login", "logout"));
                return;
            }
            $id_responsable = (int)$_SESSION['usuario']['id'];
            
            if ($id_responsable === 0 || $id_tanque === 0 || $id_zoocriadero === 0) {
                $_SESSION['error'] = "ERROR: Faltan datos esenciales (Zoocriadero, Tanque o Sesión de Usuario).";
                // Añadir redirección para que el error sea visible
                redirect(getUrl("ActividadesSeguimiento", "Actividades", "create")); 
                return;
            }

            // --- INSERCIÓN EN SEGUIMIENTO (PADRE) ---
            $id_seguimiento = $objeto->autoincrement("seguimiento", "id_seguimiento");
            
            $sql_seg = "INSERT INTO seguimiento (id_seguimiento, id_tanque, id_usuario, fecha, id_estado_seguimiento) 
                        VALUES(" . $id_seguimiento . ", " . $id_tanque . ", " . $id_responsable . ", '" . $fecha_actual . "', 1)";

            $ejecutar_seg = $objeto->insert($sql_seg);


            if ($ejecutar_seg) {

                // --- INSERCIÓN EN SEGUIMIENTO_DETALLE (HIJO) ---
                $id_detalle = $objeto->autoincrement("seguimiento_detalle", "id_seguimiento_detalle");

                $sql_det = "INSERT INTO seguimiento_detalle (
                            id_seguimiento_detalle, id_seguimiento, id_actividad, num_alevines, num_muertos, num_machos, num_hembras, 
                            observaciones, ph, temperatura, cloro, total
                        ) VALUES (
                            " . $id_detalle . ", " . $id_seguimiento . ", " . $id_actividad . ", " . $num_alevines . ", " . $num_muertes_total . ", " . $num_muertes_machos . ", " . $num_muertes_hembras . ", 
                            '" . $observaciones . "', " . $ph . ", " . $temperatura . ", " . $cloro . ", " . $poblacion_final . "
                        )";

                $ejecutar_det = $objeto->insert($sql_det);

                if ($ejecutar_det) {

                    // --- ACTUALIZACIÓN DE LA POBLACIÓN DEL TANQUE ---
                    $sql_update_tanque = "UPDATE tanques SET cantidad_peces = " . $poblacion_final . " WHERE id_tanque = " . $id_tanque;
                    $ejecutar_update = $objeto->update($sql_update_tanque);

                    if ($ejecutar_update) {
                        $_SESSION['success_message'] = "El seguimiento fue registrado y la poblacion del tanque actualizada a: " . $poblacion_final;
                        redirect(getUrl("ActividadesSeguimiento", "Actividades", "listar"));
                    } else {
                        // El detalle se insertó, pero el tanque no se actualizó (esto es un problema grave)
                        $_SESSION['error'] = "Error: Se registró el seguimiento, pero falló la actualización de la población del tanque. Población calculada: " . $poblacion_final;
                        redirect(getUrl("ActividadesSeguimiento", "Actividades", "listar")); 
                    }
                } else {
                    $_SESSION['error'] = "Error al insertar el detalle del seguimiento. " . pg_last_error($conexion);
                    redirect(getUrl("ActividadesSeguimiento", "Actividades", "create")); 
                }
            } else {
                $_SESSION['error'] = "No se pudo insertar el registro principal de seguimiento. " . pg_last_error($conexion);
                redirect(getUrl("ActividadesSeguimiento", "Actividades", "create")); 
            }
        } catch (Exception $e) {
            // Este catch es para errores graves de PHP, no de base de datos
            $_SESSION['error'] = "Error interno del servidor: " . $e->getMessage();
            redirect(getUrl("ActividadesSeguimiento", "Actividades", "create"));
        }
    }

    public function listar()
    {

        $objeto = new ActividadesModel();

        $sql = "SELECT
                     s.id_seguimiento,
                     s.fecha,
                     s.id_estado_seguimiento AS id_estado,
                     t.nombre AS nombre_tanque,
                     u.nombre AS nombre_responsable,
                     u.apellido AS apellido_responsable,
                     z.nombre_zoocriadero, 
                     tt.nombre AS nombre_tipo_tanque,
                     a.nombre AS nombre_actividad,
                     t.cantidad_peces AS poblacion_actual 
                 FROM
                     seguimiento s
                 JOIN
                     tanques t ON s.id_tanque = t.id_tanque
                 JOIN
                     usuarios u ON s.id_usuario = u.id_usuario
                 JOIN
                     zoocriaderos z ON t.id_zoocriadero = z.id_zoocriadero 
                 JOIN
                     tipo_tanque tt ON t.id_tipo_tanque = tt.id_tipo_tanque
                 JOIN
                     seguimiento_detalle sd ON s.id_seguimiento = sd.id_seguimiento 
                 JOIN
                     actividad a ON sd.id_actividad = a.id_actividad
                 ORDER BY
                     s.fecha DESC, s.id_seguimiento DESC";

        $result = $objeto->select($sql);

        $seguimientos = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $seguimientos[] = $row;
            }
        }

        include_once '../view/ActividadesSeguimiento/list.php';
    }

    public function filtro()
    {
        $objeto = new ActividadesModel();
        // Escape para prevención de inyección SQL en la cláusula LIKE
        $buscar = pg_escape_string($objeto->getConnect(), $_GET['buscar']);

        $sql = "SELECT
                s.id_seguimiento,
                s.fecha,
                s.id_estado_seguimiento AS id_estado,
                t.nombre AS nombre_tanque,
                u.nombre AS nombre_responsable,
                u.apellido AS apellido_responsable,
                z.nombre_zoocriadero, 
                tt.nombre AS nombre_tipo_tanque,
                a.nombre AS nombre_actividad,
                t.cantidad_peces AS poblacion_actual 
            FROM
                seguimiento s
            JOIN
                tanques t ON s.id_tanque = t.id_tanque
            JOIN
                usuarios u ON s.id_usuario = u.id_usuario
            JOIN
                zoocriaderos z ON t.id_zoocriadero = z.id_zoocriadero 
            JOIN
                tipo_tanque tt ON t.id_tipo_tanque = tt.id_tipo_tanque
            JOIN
                seguimiento_detalle sd ON s.id_seguimiento = sd.id_seguimiento 
            JOIN
                actividad a ON sd.id_actividad = a.id_actividad
            WHERE
                t.nombre ILIKE '%" . $buscar . "%' OR 
                z.nombre_zoocriadero ILIKE '%" . $buscar . "%' OR 
                u.nombre ILIKE '%" . $buscar . "%' OR
                u.apellido ILIKE '%" . $buscar . "%' OR 
                a.nombre ILIKE '%" . $buscar . "%' OR
                tt.nombre ILIKE '%" . $buscar . "%'             
            ORDER BY
                s.fecha DESC, s.id_seguimiento DESC";


        $result = $objeto->select($sql);

        $seguimientos = array();
        if ($result) {
            while ($row = pg_fetch_assoc($result)) {
                $seguimientos[] = $row;
            }
        }
        include_once '../view/actividadesSeguimiento/filtro.php';
    }

    public function detalle()
    {
        $objeto = new ActividadesModel();
        // Conversión a int
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id > 0) {

            $sql = "SELECT
                        s.id_seguimiento,
                        s.fecha,
                        s.id_estado_seguimiento AS id_estado,
                        e.nombre AS nombre_estado,
                        t.nombre AS nombre_tanque,
                        u.nombre AS nombre_responsable,
                        u.apellido AS apellido_responsable,
                        z.nombre_zoocriadero, 
                        tt.nombre AS nombre_tipo_tanque,
                        a.nombre AS nombre_actividad,
                        t.cantidad_peces AS poblacion_actual,
                        sd.id_seguimiento_detalle, 
                        sd.cloro,
                        sd.ph,
                        sd.temperatura,
                        sd.num_alevines,
                        sd.num_hembras AS num_muertes_hembras,
                        sd.num_machos AS num_muertes_machos,
                        sd.observaciones
                    FROM
                        seguimiento s
                    JOIN
                        estado_seguimiento e ON s.id_estado_seguimiento = e.id_estado_seguimiento
                    JOIN
                        tanques t ON s.id_tanque = t.id_tanque
                    JOIN
                        usuarios u ON s.id_usuario = u.id_usuario
                    JOIN
                        zoocriaderos z ON t.id_zoocriadero = z.id_zoocriadero 
                    JOIN
                        tipo_tanque tt ON t.id_tipo_tanque = tt.id_tipo_tanque
                    JOIN
                        seguimiento_detalle sd ON s.id_seguimiento = sd.id_seguimiento 
                    JOIN
                        actividad a ON sd.id_actividad = a.id_actividad
                    WHERE
                        s.id_seguimiento = " . $id;

            $result = $objeto->select($sql);
            $seguimientoDetalle = pg_fetch_assoc($result);

            include_once '../view/actividadesSeguimiento/detalle.php';
        }
    }

    public function editar()
    {
        $objeto = new ActividadesModel();
        // Conversión a int
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id > 0) {
            $sql = "SELECT
                        s.id_seguimiento,
                        s.fecha,
                        s.id_estado_seguimiento AS id_estado,
                        e.nombre AS nombre_estado,
                        t.nombre AS nombre_tanque,
                        u.nombre AS nombre_responsable,
                        u.apellido AS apellido_responsable,
                        z.nombre_zoocriadero, 
                        tt.nombre AS nombre_tipo_tanque,
                        a.nombre AS nombre_actividad,
                        t.cantidad_peces AS poblacion_actual,
                        sd.id_seguimiento_detalle, 
                        sd.cloro,
                        sd.ph,
                        sd.temperatura,
                        sd.num_alevines,
                        sd.num_hembras AS num_muertes_hembras,
                        sd.num_machos AS num_muertes_machos,
                        sd.observaciones
                    FROM
                        seguimiento s
                    JOIN
                        estado_seguimiento e ON s.id_estado_seguimiento = e.id_estado_seguimiento
                    JOIN
                        tanques t ON s.id_tanque = t.id_tanque
                    JOIN
                        usuarios u ON s.id_usuario = u.id_usuario
                    JOIN
                        zoocriaderos z ON t.id_zoocriadero = z.id_zoocriadero 
                    JOIN
                        tipo_tanque tt ON t.id_tipo_tanque = tt.id_tipo_tanque
                    JOIN
                        seguimiento_detalle sd ON s.id_seguimiento = sd.id_seguimiento 
                    JOIN
                        actividad a ON sd.id_actividad = a.id_actividad
                    WHERE
                        s.id_seguimiento = " . $id;

            $result = $objeto->select($sql);
            $seguimientoDetalle = pg_fetch_assoc($result);

            $sql_estados = "SELECT id_estado_seguimiento, nombre FROM estado_seguimiento";
            $result_estados = $objeto->select($sql_estados);
            $estados = pg_fetch_all($result_estados);

            include_once '../view/actividadesSeguimiento/editar.php';
        }
    }

    public function actualizar()
    {
        $objeto = new ActividadesModel();
        $conexion = $objeto->getConnect();
        
        // 1. RECEPCIÓN Y ESCAPE DE VARIABLES
        $id = (int)$_POST['id_seguimiento'];
        $id_estado = (int)$_POST['id_estado'];
        $cloro = pg_escape_string($conexion, $_POST['cloro']);
        $ph = pg_escape_string($conexion, $_POST['ph']);
        $temperatura = pg_escape_string($conexion, $_POST['temperatura']);
        $num_alevines = (int)$_POST['num_alevines'];
        $num_muertes_hembras = (int)$_POST['num_muertes_hembras'];
        $num_muertes_machos = (int)$_POST['num_muertes_machos'];
        $observaciones = pg_escape_string($conexion, $_POST['observaciones']);
        $id_seguimiento_detalle = (int)$_POST['id_seguimiento_detalle'];
        $muertes_totales_nuevo = $num_muertes_hembras + $num_muertes_machos;

        // 2. OBTENER DATOS ANTIGUOS
        $sql_detalle_antiguo = "SELECT num_alevines, num_hembras, num_machos
                                FROM seguimiento_detalle
                                WHERE id_seguimiento_detalle = " . $id_seguimiento_detalle;

        $result_detalle_antiguo = $objeto->select($sql_detalle_antiguo);
        $detalle_antiguo = pg_fetch_assoc($result_detalle_antiguo);

        // 3. OBTENER DATOS DEL TANQUE
        $sql_data_tanque = "SELECT t.id_tanque, t.cantidad_peces 
                            FROM seguimiento s
                            JOIN tanques t ON s.id_tanque = t.id_tanque
                            WHERE s.id_seguimiento = " . $id;

        $result_data_tanque = $objeto->select($sql_data_tanque);
        $data_tanque = pg_fetch_assoc($result_data_tanque);

        $nueva_poblacion = 0; // Inicializar

        if ($data_tanque && $detalle_antiguo) {
            $id_tanque = (int)$data_tanque['id_tanque'];
            $poblacion_actual_db = (int)$data_tanque['cantidad_peces'];

            // --- LÓGICA DE COMPENSACIÓN ---
            // 1. Efecto Antiguo (lo que el registro ANTERIORMENTE le SUMÓ o RESTÓ al total)
            $dif_alevines_antiguo = (int)$detalle_antiguo['num_alevines'];
            $dif_muertes_antiguo = (int)$detalle_antiguo['num_hembras'] + (int)$detalle_antiguo['num_machos'];

            // 2. Población Base: Población actual del tanque MENOS el efecto del registro que vamos a editar.
            // (población_actual_db - (lo que el registro agregó) + (lo que el registro quitó))
            $poblacion_base = $poblacion_actual_db - $dif_alevines_antiguo + $dif_muertes_antiguo;

            // 3. Nuevo Cálculo: Población Base MÁS el nuevo efecto
            $nueva_poblacion = $poblacion_base + $num_alevines - $muertes_totales_nuevo;

            // Evitar población negativa
            if ($nueva_poblacion < 0) {
                $nueva_poblacion = 0;
            }

            // --- 4. ACTUALIZAR TANQUES ---
            $sql_tanque_update = "UPDATE tanques SET 
                                        cantidad_peces = " . $nueva_poblacion . "
                                    WHERE id_tanque = " . $id_tanque;

            $result_tanque = $objeto->update($sql_tanque_update);

            if (!$result_tanque) {
                $_SESSION['error'] = "Error grave: la población del tanque no pudo ser actualizada (" . pg_last_error($conexion) . ")";
                redirect(getUrl("ActividadesSeguimiento", "Actividades", "editar", array('id' => $id)));
                return;
            } else {
                $_SESSION['success_message'] = "La población del tanque fue actualizada a: " . $nueva_poblacion . ". ";
            }
        } else {
            $_SESSION['error'] = "Error: No se pudo obtener la información del tanque o del detalle antiguo.";
            redirect(getUrl("ActividadesSeguimiento", "Actividades", "editar", array('id' => $id)));
            return;
        }

        // --- 5. ACTUALIZAR SEGUIMIENTO (PADRE) ---
        $sql_seguimiento = "UPDATE seguimiento SET 
                                 id_estado_seguimiento = " . $id_estado . "
                             WHERE id_seguimiento = " . $id;

        $objeto->update($sql_seguimiento);


        // --- 6. ACTUALIZAR SEGUIMIENTO_DETALLE (HIJO) ---
        $sql_detalle = "UPDATE seguimiento_detalle SET 
                             cloro = '" . $cloro . "',
                             ph = '" . $ph . "',
                             temperatura = '" . $temperatura . "',
                             num_alevines = " . $num_alevines . ",
                             num_hembras = " . $num_muertes_hembras . ",
                             num_machos = " . $num_muertes_machos . ",
                             observaciones = '" . $observaciones . "',
                             total = " . $nueva_poblacion . "
                         WHERE id_seguimiento_detalle = " . $id_seguimiento_detalle;


        $result_detalle = $objeto->update($sql_detalle);

        if (!$result_detalle) {
            $_SESSION['error'] = $_SESSION['success_message'] . 'Error al actualizar el detalle del seguimiento: ' . pg_last_error($conexion);
        } else {
            $_SESSION['success_message'] = $_SESSION['success_message'] . 'El detalle del seguimiento se ha actualizado correctamente.';
        }

        redirect(getUrl("ActividadesSeguimiento", "Actividades", "listar"));
    }

    public function delete()
    {
        $objeto = new ActividadesModel();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id > 0) {
            
            // Este select no es correcto, debe ser WHERE id_seguimiento = $id
            $sql = "SELECT id_estado_seguimiento FROM seguimiento WHERE id_seguimiento = " . $id; 

            $result = $objeto->select($sql);
            $seguimientoEstado = pg_fetch_assoc($result);
            
            // Asegurarse de que el registro existe antes de cargar la vista
            if (!$seguimientoEstado) {
                 $_SESSION['error'] = "Seguimiento N° " . $id . " no encontrado para inhabilitar.";
                 redirect(getUrl("ActividadesSeguimiento", "Actividades", "listar"));
                 return;
            }

            $sql_estados = "SELECT id_estado_seguimiento, nombre FROM estado_seguimiento";
            $result_estados = $objeto->select($sql_estados);
            $estados = pg_fetch_all($result_estados);

            include_once '../view/actividadesSeguimiento/inhabilitar.php';
        }
    }

    public function postDelete()
    {
        $objeto = new ActividadesModel();
        $conexion = $objeto->getConnect();
        
        // Obtener ID, preferiblemente de POST
        $id = isset($_POST['id_seguimiento_inhabilitar']) ? (int)$_POST['id_seguimiento_inhabilitar'] : 0;

        if ($id === 0) {
            $_SESSION['error'] = "Error: ID de seguimiento no proporcionado para la inhabilitación.";
            redirect(getUrl("ActividadesSeguimiento", "Actividades", "listar"));
            return;
        }

        // El estado 2 es el estado "Inhabilitado" o "Eliminado lógico"
        $sql = "UPDATE seguimiento SET id_estado_seguimiento = 2 WHERE id_seguimiento = " . $id;

        $ejecutar = $objeto->update($sql);

        if ($ejecutar) {
            $_SESSION['success_message'] = "El seguimiento N° " . $id . " ha sido inhabilitado correctamente.";
        } else {
            $_SESSION['error'] = "No se pudo inhabilitar el seguimiento N° " . $id . ". Error: " . pg_last_error($conexion);
        }

        redirect(getUrl("ActividadesSeguimiento", "Actividades", "listar"));
    }

    public function updateStatus()
    {
        $objeto = new ActividadesModel();
        $conexion = $objeto->getConnect();
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

        if ($id === 0) {
             $_SESSION['error'] = "Error: ID de seguimiento no proporcionado para la habilitación.";
             redirect(getUrl("ActividadesSeguimiento", "Actividades", "listar"));
             return;
        }

        $sql = "UPDATE seguimiento SET id_estado_seguimiento = 1 WHERE id_seguimiento = " . $id;

        $ejecutar = $objeto->update($sql);

        if ($ejecutar) {
             $_SESSION['success_message'] = "El seguimiento N° " . $id . " ha sido habilitado correctamente.";
             redirect(getUrl("ActividadesSeguimiento", "Actividades", "listar"));
        } else {
             $_SESSION['error'] = "No se pudo habilitar el seguimiento N° " . $id . ". Error: " . pg_last_error($conexion);
             redirect(getUrl("ActividadesSeguimiento", "Actividades", "listar"));
        }
    }
}