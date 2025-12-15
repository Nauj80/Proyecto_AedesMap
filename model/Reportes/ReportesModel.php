<?php
require_once '../lib/conf/connection.php';

class ReportesModel {

    public function getSeguimiento($inicio = null, $fin = null, $zoo = null) {

        $conn = connection();

        $sql = "
            SELECT 
                z.nombre_zoocriadero,
                t.id_tanque,
                a.nombre AS actividad,
                s.fecha,
                sd.num_alevines,
                sd.num_muertes
            FROM seguimiento s
            INNER JOIN tanques t ON s.id_tanque = t.id_tanque
            INNER JOIN zoocriaderos z ON t.id_zoocriadero = z.id_zoocriadero
            INNER JOIN seguimiento_detalle sd ON s.id_seguimiento = sd.id_seguimiento
            INNER JOIN actividad a ON sd.id_actividad = a.id_actividad
            WHERE 1=1
        ";

        if ($inicio && $fin) {
            $sql .= " AND s.fecha BETWEEN '$inicio' AND '$fin'";
        }

        if ($zoo) {
            $sql .= " AND z.id_zoocriadero = $zoo";
        }

        $query = pg_query($conn, $sql);
        return pg_fetch_all($query);
    }
}