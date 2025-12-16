<?php
$conn = pg_connect("host=localhost port=5432 dbname=zoocriadero user=postgres password=12345");

$dir1 = $_GET['x'];
$dir2 = $_GET['y'];

$sqlconsult = "SELECT id_zoocriadero, astext(coordenada) AS geom FROM zoocriaderos";
$queryConsult = pg_query($conn, $sqlconsult);

$encontro = false;

while ($resultado = pg_fetch_array($queryConsult)) {

    $astext = $resultado['geom'];
    $astext = str_replace(array('POINT(', ')'), '', $astext);
    list($astext_x, $astext_y) = explode(' ', $astext);

    
    $tol = 100;

    if (
        ($dir1 >= $astext_x - $tol && $dir1 <= $astext_x + $tol) &&
        ($dir2 >= $astext_y - $tol && $dir2 <= $astext_y + $tol)
    ) {
        $id = $resultado['id_zoocriadero'];

        $sql1 = "SELECT nombre_zoocriadero FROM zoocriaderos WHERE id_zoocriadero = $id";
        $query1 = pg_query($conn, $sql1);
        $array1 = pg_fetch_array($query1);

        echo "✔ Punto encontrado\n";
        echo "Nombre: " . $array1['nombre_zoocriadero'];

        $encontro = true;
        break;
    }
}

if (!$encontro) {
    echo "No se encontraron puntos cercanos";
}
?>