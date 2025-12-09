<?php

include_once '../model/Zoocriaderos/ZoocriaderoModel.php';

class ZoocriaderoController
{
    public function listar()
    {
        $objeto = new ZoocriaderoModel();
        $sql = "SELECT * FROM zoocriaderos";
        $zoo = $objeto->select($sql);
        include_once '../view/zoocriaderos/ConsultarZoocriaderos.php';
    }
}
?>