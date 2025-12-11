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

        $sql = "SELECT *, usuarios.nombre as nombre_usuario FROM zoocriaderos INNER JOIN usuarios ON zoocriaderos.id_usuario = usuarios.id_usuario WHERE nombre_zoocriadero LIKE '%$buscar%' OR direccion LIKE '%$buscar%'";
        $zoo = $objeto->select($sql);
        $zooCria = pg_fetch_all($zoo);
        include_once '../view/zoocriaderos/Filtro.php';
    }
}
?>