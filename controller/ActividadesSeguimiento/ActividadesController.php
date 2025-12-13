<?php

    require_once '../lib/helpers.php';
    require_once '../model/Actividades/ActividadesModel.php';
    
    class ActividadesController{

        public function create(){

            $objeto = new ActividadesModel(); 
        
            $sql_zoos = "SELECT id_zoocriadero, nombre_zoocriadero FROM zoocriaderos WHERE id_estado_zoocriadero = 1";
            
            $zoocriaderos = $objeto->select($sql_zoos);

            $sql_actividades = "SELECT id_actividad, nombre FROM actividad WHERE id_estado_actividad = 1";

            $actividades = $objeto->select($sql_actividades);

            include '../view/ActividadesSeguimiento/create.php';
        }

        public function getTanquesByZoo() {
    
            $id_zoocriadero = $_GET['id_zoocriadero'];
            
            $objeto = new ActividadesModel(); 
            $tanques = [];

            
                $sql = "SELECT t.id_tanque, t.nombre AS nombre_tanque, tt.nombre AS nombre_tipo FROM tanques t JOIN tipo_tanque tt ON t.id_tipo_tanque = tt.id_tipo_tanque WHERE id_zoocriadero = $id_zoocriadero AND id_estado_tanque = 1";

                $tanques = $objeto->select($sql);
             
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

                $data = $objeto->select($sql);

                $response['cantidad'] = (int)($data[0]['cantidad_peces']);
            
            echo json_encode($response);
        }

        public function postCreate(){
    
            $objeto = new ActividadesModel();

            try {
                
                $fecha_actual = date('Y-m-d'); 
                $id_zoocriadero = $_POST['id_zoocriadero'];
                $id_tanque = $_POST['id_tanque'];
                $id_responsable = 1; 
                $id_actividad = $_POST['id_actividad'];

                // Parámetros
                $ph = $_POST['ph'];
                $temperatura = $_POST['temperatura'];
                $cloro = $_POST['cloro'];
                
                // Conteo
                $num_alevines = (int)$_POST['num_alevines'];
                $num_muertes_hembras = (int)$_POST['num_muertes_hembras'];
                $num_muertes_machos = (int)$_POST['num_muertes_machos'];
                $observaciones = $_POST['observaciones'];
                
                // 🌟 NUEVA VARIABLE: Cantidad Inicial Precargada por AJAX
                $cantidad_inicial = (int)$_POST['cantidad_inicial_tanque'];
                
                // Cálculos
                $num_muertes_total = $num_muertes_hembras + $num_muertes_machos;
                
                // 🌟 NUEVO CÁLCULO CRUCIAL: Población Final
                $poblacion_final = $cantidad_inicial + $num_alevines - $num_muertes_total;
                
                if ($id_responsable === 0 || $id_tanque === 0 || $id_zoocriadero === 0) {
                    echo("Error: Faltan datos esenciales (Zoocriadero, Tanque o Sesión de Usuario).");
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
                            echo("El seguimiento fue registrado y la poblacion del tanque actualizada a: $poblacion_final");
                            redirect(getUrl("ActividadesSeguimiento","Actividades","list")); 

                        } else {
                            echo("Error: Se registró el seguimiento, pero falló la actualización de la población del tanque.");
                        }
                                    
                    } else {
                        echo("Error al insertar el detalle del seguimiento.");
                    }
                        
                } else {
                    echo("No se pudo insertar el registro principal de seguimiento.");
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

            $seguimientos = $objeto->select($sql);

            include_once '../view/ActividadesSeguimiento/list.php';
        }

        public function delete(){
            $objeto = new ActividadesModel();
            $id = $_GET['id'];

            $sql = "UPDATE seguimiento SET id_estado_seguimiento = 2 WHERE id_seguimiento = $id";

            $ejecutar = $objeto->update($sql);
            
            if($ejecutar){
                redirect(getUrl("ActividadesSeguimiento","Actividades","list"));
            }else{
                echo "No se pudo inhabilitar el seguimiento";
            }

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