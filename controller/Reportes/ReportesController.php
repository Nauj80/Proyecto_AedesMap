<?php
require_once '../model/ReportesModel.php';

class ReportesController {

    public function index() {

        $model = new ReportesModel();

        $fecha_inicio = $_GET['fecha_inicio'] ?? null;
        $fecha_fin    = $_GET['fecha_fin'] ?? null;
        $zoocriadero  = $_GET['zoocriadero'] ?? null;

        $reportes = $model->getSeguimiento(
            $fecha_inicio,
            $fecha_fin,
            $zoocriadero
        );

        include_once '../view/reportes/index.php';
    }
}