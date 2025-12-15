<?php

    require_once '../lib/helpers.php';
    require_once '../model/Actividades/ActividadesModel.php';
    
    class ActividadesController{

        public function create(){

            $objeto = new ActividadesModel(); 
            
            $sql_zoos = "SELECT id_zoocriadero, nombre_zoocriadero FROM zoocriaderos WHERE id_estado_zoocriadero = 1";
            $sql_actividades = "SELECT id_actividad, nombre FROM actividad WHERE id_estado_actividad = 1";
            
            
            $result_zoos = $objeto->select($sql_zoos);
            $result_actividades = $objeto->select($sql_actividades);

           
            $zoocriaderos = [];
            if ($result_zoos) {
                while ($row = pg_fetch_assoc($result_zoos)) {
                    $zoocriaderos[] = $row;
                }
            }

            
            $actividades = [];
            if ($result_actividades) {
                while ($row = pg_fetch_assoc($result_actividades)) {
                    $actividades[] = $row;
                }
            }

            include '../view/ActividadesSeguimiento/create.php';
        }

        public function getTanquesByZoo() {
    
            $id_zoocriadero = $_GET['id_zoocriadero'];
            
            $objeto = new ActividadesModel(); 
            $tanques = [];
            
            $sql = "SELECT t.id_tanque, t.nombre AS nombre_tanque, tt.nombre AS nombre_tipo FROM tanques t JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id_tipo_tanque WHERE id_zoocriadero = $id_zoocriadero AND id_estado_tanque = 1";

            
            $result = $objeto->select($sql);
            
         
            if ($result) {
                while ($row = pg_fetch_assoc($result)) {
                    $tanques[] = $row;
                }
            }
               
            foreach($tanques as $tan){
                echo "<option value='".$tan['id_tanque']."'>".$tan['nombre_tanque']." (".$tan['nombre_tipo'].")</option>";
            }
        }

        public function getCantidadPecesByTanque(){

            header('Content-Type: application/json');
            $id_tanque = $_GET['id_tanque'];
            $objeto = new ActividadesModel();
            $response = ['success' => false, 'cantidad' => 0]; 

            $sql = "SELECT cantidad_peces FROM tanques WHERE id_tanque = $id_tanque";

            
            $result = $objeto->select($sql);

            
            if ($result && pg_num_rows($result) > 0) {
                 $data = pg_fetch_assoc($result);
                 $response['cantidad'] = (int)($data['cantidad_peces']);
                 $response['success'] = true;
            }
            
            echo json_encode($response);
        }

        public function postCreate(){
    
            $objeto = new ActividadesModel();

            try {
                
                $fecha_actual = date('Y-m-d'); 
                $id_zoocriadero = $_POST['id_zoocriadero'];
                $id_tanque = $_POST['id_tanque'];
                
                if (!isset($_SESSION['usuario']['id'])) {
                    $_SESSION['error'] = "Error de sesión: ID de usuario no encontrado.";
                    redirect(getUrl("Login","Login","logout"));
                    return;
                }
                $id_responsable = $_SESSION['usuario']['id']; 

                $id_actividad = $_POST['id_actividad'];

                
                $ph = $_POST['ph'];
                $temperatura = $_POST['temperatura'];
                $cloro = $_POST['cloro'];
                
                
                $num_alevines = (int)$_POST['num_alevines'];
                $num_muertes_hembras = (int)$_POST['num_muertes_hembras'];
                $num_muertes_machos = (int)$_POST['num_muertes_machos'];
                $observaciones = $_POST['observaciones'];
                
                $cantidad_inicial = (int)$_POST['cantidad_inicial_tanque'];
                
                $num_muertes_total = $num_muertes_hembras + $num_muertes_machos;
                
                $poblacion_final = $cantidad_inicial + $num_alevines - $num_muertes_total;
                
                if ($id_responsable === 0 || $id_tanque === 0 || $id_zoocriadero === 0) {
                    $_SESSION['error'] = "ERROR: Faltan datos esenciales (Zoocriadero, Tanque o Sesión de Usuario).";
                    return;
                }

                $id_seguimiento = $objeto->autoincrement("seguimiento", "id_seguimiento"); 


                $sql_seg = "INSERT INTO seguimiento (id_seguimiento, id_tanque, id_usuario, fecha, id_estado_seguimiento) 
                            VALUES($id_seguimiento, $id_tanque, $id_responsable, '$fecha_actual', 1)";
                
                $ejecutar_seg = $objeto->insert($sql_seg);


                if($ejecutar_seg) {
                
                    $id_detalle = $objeto->autoincrement("seguimiento_detalle", "id_seguimiento_detalle");

                    $sql_det = "INSERT INTO seguimiento_detalle (
                        id_seguimiento_detalle, id_seguimiento, id_actividad, num_alevines, num_muertos, num_machos, num_hembras, 
                        observaciones, ph, temperatura, cloro, total
                    ) VALUES (
                        $id_detalle, $id_seguimiento, $id_actividad, $num_alevines, $num_muertes_total, $num_muertes_machos, $num_muertes_hembras, 
                        '$observaciones', $ph, $temperatura, $cloro, $poblacion_final
                    )";
                        
                    $ejecutar_det = $objeto->insert($sql_det);
                        
                    if($ejecutar_det){ 

                        $sql_update_tanque = "UPDATE tanques SET cantidad_peces = $poblacion_final WHERE id_tanque = $id_tanque";
                        $ejecutar_update = $objeto->update($sql_update_tanque);

                        if($ejecutar_update) {
                            $_SESSION['success_message'] = "El seguimiento fue registrado y la poblacion del tanque actualizada a: $poblacion_final";
                            redirect(getUrl("ActividadesSeguimiento","Actividades","list")); 

                        } else {
                            $_SESSION['error'] = "El seguimiento fue registrado con éxito";"Error: Se registró el seguimiento, pero falló la actualización de la población del tanque.";
                        }
                                        
                    } else {
                        $_SESSION['error'] = "Error al insertar el detalle del seguimiento.";
                    }
                        
                } else {
                    $_SESSION['error'] = "No se pudo insertar el registro principal de seguimiento.";
                }

            } catch (\Exception $e) {
                echo("Error interno del servidor: " . $e->getMessage());
            }
        }

        public function list(){
    
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

            $seguimientos = [];
            if ($result) {
                while ($row = pg_fetch_assoc($result)) {
                    $seguimientos[] = $row;
                }
            }

            include_once '../view/ActividadesSeguimiento/list.php';
        }

        public function filtro(){
            $objeto = new ActividadesModel();
            $buscar = $_GET['buscar'];

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
                t.nombre ILIKE '%$buscar%' OR             
                z.nombre_zoocriadero ILIKE '%$buscar%' OR 
                u.nombre ILIKE '%$buscar%' OR
                u.apellido ILIKE '%$buscar%' OR               
                a.nombre ILIKE '%$buscar%' OR
                tt.nombre ILIKE '%$buscar%'               
            ORDER BY
                s.fecha DESC, s.id_seguimiento DESC";

    
            $result = $objeto->select($sql);

            $seguimientos = [];
            if ($result) {
                while ($row = pg_fetch_assoc($result)) {
                    $seguimientos[] = $row;
                }
            }
            include_once '../view/actividadesSeguimiento/filtro.php';
        }

        public function detalle(){
            $objeto = new ActividadesModel();

            if (isset($_GET['id'])) {
                $id = $_GET['id'];

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
                    s.id_seguimiento = $id";

                $result = $objeto->select($sql);
                $seguimientoDetalle = pg_fetch_assoc($result);

                include_once '../view/actividadesSeguimiento/detalle.php';
            }
        }

        public function editar(){
            $objeto = new ActividadesModel(); 

            if (isset($_GET['id'])) {
                $id = $_GET['id'];

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
                    s.id_seguimiento = $id";

                $result = $objeto->select($sql);
                $seguimientoDetalle = pg_fetch_assoc($result);

                $sql_estados = "SELECT id_estado_seguimiento, nombre FROM estado_seguimiento";
                $result_estados = $objeto->select($sql_estados);
                $estados = pg_fetch_all($result_estados);

                include_once '../view/actividadesSeguimiento/editar.php';
            }
        }

        public function actualizar(){
            $objeto = new ActividadesModel();
            
            $id = $_POST['id_seguimiento'];
            $id_estado = $_POST['id_estado'];
            $cloro = $_POST['cloro'];
            $ph = $_POST['ph'];
            $temperatura = $_POST['temperatura'];
            $num_alevines = $_POST['num_alevines'];
            $num_muertes_hembras = $_POST['num_muertes_hembras'];
            $num_muertes_machos = $_POST['num_muertes_machos'];
            $observaciones = $_POST['observaciones'];
            $id_seguimiento_detalle = $_POST['id_seguimiento_detalle']; 

            $sql_detalle_antiguo = "SELECT num_alevines, num_hembras, num_machos
                            FROM seguimiento_detalle
                            WHERE id_seguimiento_detalle = $id_seguimiento_detalle";

            $result_detalle_antiguo = $objeto->select($sql_detalle_antiguo);
            $detalle_antiguo = pg_fetch_assoc($result_detalle_antiguo);

            $sql_data_tanque = "SELECT t.id_tanque, t.cantidad_peces 
                        FROM seguimiento s
                        JOIN tanques t ON s.id_tanque = t.id_tanque
                        WHERE s.id_seguimiento = $id";

            $result_data_tanque = $objeto->select($sql_data_tanque);
            $data_tanque = pg_fetch_assoc($result_data_tanque);
            
            if ($data_tanque && $detalle_antiguo) {
                $id_tanque = $data_tanque['id_tanque'];
                $poblacion_actual_db = (int)$data_tanque['cantidad_peces']; 
                
                // --- 🛑 LÓGICA DE COMPENSACIÓN 🛑 ---
                // 1. Valores Antiguos del Detalle (para 'deshacer' su efecto)
                $dif_alevines_antiguo = (int)$detalle_antiguo['num_alevines'];
                $dif_muertes_antiguo = (int)$detalle_antiguo['num_hembras'] + (int)$detalle_antiguo['num_machos'];

                // Población base (población actual del tanque MINUS el efecto de este registro ANTES de la edición)
                $poblacion_base = $poblacion_actual_db - $dif_alevines_antiguo + $dif_muertes_antiguo;

                // 2. Valores Nuevos del Detalle (para aplicar el nuevo efecto)
                $muertes_totales_nuevo = $num_muertes_hembras + $num_muertes_machos;
                
                // CÁLCULO FINAL: base + nuevo efecto
                $nueva_poblacion = $poblacion_base + $num_alevines - $muertes_totales_nuevo;

                // Si la población no puede ser negativa
                if ($nueva_poblacion < 0) {
                    $nueva_poblacion = 0;
                }

                // --- PASO CLAVE 4: Actualizar la tabla tanques ---

                $sql_tanque_update = "UPDATE tanques SET 
                                        cantidad_peces = '$nueva_poblacion'
                                    WHERE id_tanque = $id_tanque";

                $result = $objeto->update($sql_tanque_update);

                if(!$result){
                    $_SESSION['error'] = "la población del tanque no pudo ser actualizada";
                }else{
                    $_SESSION['success_message'] = "la población del tanque actualizada a: $nueva_poblacion";
                }
                
            }

            $sql_seguimiento = "UPDATE seguimiento SET 
                                    id_estado_seguimiento = '$id_estado'
                                WHERE id_seguimiento = $id";

            $objeto->update($sql_seguimiento);


            $sql_detalle = "UPDATE seguimiento_detalle SET 
                                cloro = '$cloro',
                                ph = '$ph',
                                temperatura = '$temperatura',
                                num_alevines = '$num_alevines',
                                num_hembras = '$num_muertes_hembras',
                                num_machos = '$num_muertes_machos',
                                observaciones = '$observaciones',
                                total = '$nueva_poblacion'
                            WHERE id_seguimiento_detalle = $id_seguimiento_detalle"; 
                            

            $result = $objeto->update($sql_detalle);

            if (!$result) {
                $_SESSION['error'] = 'Error al actualizar el seguimiento: ' . pg_last_error($objeto->getConnect());
            } else {
                $_SESSION['success_message'] = 'El seguimiento se ha actualizado correctamente.';
            }

            redirect(getUrl("ActividadesSeguimiento", "Actividades", "list")); 
        }

        public function delete(){
            $objeto = new ActividadesModel(); 

            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                $sql = "SELECT id_estado_seguimiento FROM seguimiento";

                $result = $objeto->select($sql);
                $seguimientoEstado = pg_fetch_assoc($result);

                $sql_estados = "SELECT id_estado_seguimiento, nombre FROM estado_seguimiento";
                $result_estados = $objeto->select($sql_estados);
                $estados = pg_fetch_all($result_estados);

                include_once '../view/actividadesSeguimiento/inhabilitar.php';
            }
        }

        public function postDelete(){
            $objeto = new ActividadesModel();
            
            // Aseguramos que recibimos el ID por POST (o GET, si lo manejas desde la URL, pero la modal usa POST)
            // Asumo que la modal enviará el ID por POST
            $id = isset($_POST['id_seguimiento_inhabilitar']) ? $_POST['id_seguimiento_inhabilitar'] : (isset($_GET['id']) ? $_GET['id'] : null);

            if (!$id) {
                $_SESSION['error'] = "Error: ID de seguimiento no proporcionado para la inhabilitación.";
                redirect(getUrl("ActividadesSeguimiento","Actividades","list"));
                return;
            }

            // El estado 2 es el estado "Inhabilitado" o "Eliminado lógico"
            $sql = "UPDATE seguimiento SET id_estado_seguimiento = 2 WHERE id_seguimiento = $id";

            $ejecutar = $objeto->update($sql);
            
            if($ejecutar){
                $_SESSION['success_message'] = "El seguimiento N° $id ha sido inhabilitado correctamente.";
            }else{
                $_SESSION['error'] = "No se pudo inhabilitar el seguimiento N° $id. Error: " . pg_last_error($objeto->getConnect());
            }
            
            redirect(getUrl("ActividadesSeguimiento","Actividades","list"));

        }

        public function updateStatus(){
            $objeto = new ActividadesModel();
            $id = $_GET['id'];

            $sql = "UPDATE seguimiento SET id_estado_seguimiento = 1 WHERE id_seguimiento = $id";

            $ejecutar = $objeto->update($sql);
            
            if($ejecutar){
                redirect(getUrl("ActividadesSeguimiento","Actividades","list"));
            }else{
                echo "No se pudo habilitar el seguimiento";
            }
        }
    }

?>