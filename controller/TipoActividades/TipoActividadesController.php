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
            }else{
                echo "No se pudo insertar la actividad";
            }
        }

        public function list(){
    
            $objeto = new TipoActividadesModel();

            $sql = "SELECT a.id_actividad, a.nombre AS nombre_actividad, a.id_estado_actividad, e.nombre AS nombre_estado FROM actividad a LEFT JOIN estado_actividad e ON a.id_estado_actividad = e.id_estado_actividad";
            $actividades = $objeto->select($sql);

            include_once '../view/tipoActividades/list.php';
        }

        public function delete(){
            $objeto = new TipoActividadesModel();
            $id = $_GET['id'];

            $sql = "UPDATE actividad SET id_estado_actividad = 2 WHERE id_actividad = $id";

            $ejecutar = $objeto->update($sql);
            
            if($ejecutar){
                redirect(getUrl("TipoActividades","TipoActividades","list"));
            }else{
                echo "No se pudo inhabilitar la actividad";
            }

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