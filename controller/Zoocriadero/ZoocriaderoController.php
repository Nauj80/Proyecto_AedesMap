<?php

include_once '../model/Zoocriaderos/ZoocriaderoModel.php';

class ZoocriaderoController
{
    public function listar()
    {
        $objeto = new ZoocriaderoModel();
        $sql = "SELECT * FROM zoocriaderos";
        $zoo = $objeto->select($sql);
        $zooCria = pg_fetch_all($zoo);
        include_once '../view/zoocriaderos/ConsultarZoocriaderos.php';
    }
}
?>