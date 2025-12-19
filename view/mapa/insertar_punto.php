<?php

//include_once "lib/conf/connection.php";
$conn = pg_connect("host=localhost port=5432 dbname=zoocriadero user=postgres password=12345");

$dir1 = $_GET['x'];
$dir2 = $_GET['y'];
//$id = $_GET['cedu'];

$nombre = $_GET['nombre'];

$sql = "INSERT INTO zoocriaderos (coordenada) VALUES (ST_SetSRID(GeometryFromText('POINT(" . $dir1 . " " . $dir2 . ")'), 4326))";
$query = pg_query($sql);
if ($query == false) {
    echo "<alert> 'No se inserto' </alert>";
} else {
    echo "<alert> 'Si se inserto' </alert>";
}
