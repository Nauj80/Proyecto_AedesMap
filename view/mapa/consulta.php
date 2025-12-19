<?php
header('Content-Type: application/json');

$conn = pg_connect("host=localhost port=5432 dbname=zoocriadero user=postgres password=123");

if (!$conn) {
    echo json_encode(array('error' => 'Error de conexión'));
    exit;
}

$dir1 = isset($_GET['x']) ? floatval($_GET['x']) : 0;
$dir2 = isset($_GET['y']) ? floatval($_GET['y']) : 0;

$sqlconsult = "SELECT id_zoocriadero, astext(coordenada) AS geom FROM zoocriaderos";
$queryConsult = pg_query($conn, $sqlconsult);

$encontro = false;
$data = array();

while ($resultado = pg_fetch_assoc($queryConsult)) {
    $astext = $resultado['geom'];
    $astext = str_replace(array('POINT(', ')'), '', $astext);
    list($astext_x, $astext_y) = explode(' ', $astext);

    $tol = 100;

    if (
        ($dir1 >= $astext_x - $tol && $dir1 <= $astext_x + $tol) &&
        ($dir2 >= $astext_y - $tol && $dir2 <= $astext_y + $tol)
    ) {
        $id = intval($resultado['id_zoocriadero']);

        $sql1 = "SELECT zoocriaderos.*, estado_zoocriadero.nombre AS estado_nombre 
                 FROM zoocriaderos INNER JOIN estado_zoocriadero ON zoocriaderos.id_estado_zoocriadero = estado_zoocriadero.id_estado_zoocriadero
                 WHERE id_zoocriadero = $id";
        $query1 = pg_query($conn, $sql1);

        if ($query1) {
            $detalle = pg_fetch_assoc($query1);

            $data = array(
                'encontrado' => true,
                'nombre' => $detalle['nombre_zoocriadero'],
                'estado' => $detalle['estado_nombre'],
                'direccion' => $detalle['direccion'],
                'barrio' => $detalle['barrio'],
                'comuna' => $detalle['comuna'],
                'telefono' => $detalle['telefono'],
                'correo' => $detalle['correo']
            );

            $encontro = true;
            break;
        }
    }
}

if (!$encontro) {
    $data = array('encontrado' => false);
}

pg_close($conn);
echo json_encode($data);
?>