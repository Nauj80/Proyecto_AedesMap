<?php
if (!extension_loaded("MapScript")) {
    dl('php_mapscript.' . PHP_SHLIB_SUFFIX);
}
$PROJECT_ROOT_URL = '/Proyecto_AedesMap';
// Ajusta estas rutas según tu instalación si es necesario
// `MAPSERV_PATH` debe ser la URL al ejecutable MapServer (no ruta de fichero)
$MAPSERV_PATH = '/cgi-bin/mapserv.exe';
// `MAPFILE_PATH` es la ruta de fichero absoluta al .map en el servidor
$MAPFILE_PATH = 'C:/ms4w/Apache/htdocs/Proyecto_AedesMap/web/assets/mapa/cali.map';
// `MISC_URL` apunta a la carpeta pública donde están los assets JS/CSS/IMG
$MISC_URL = $PROJECT_ROOT_URL . '/web/assets/mapa/misc';

$mapObject = ms_newMapObj($MAPFILE_PATH);
$mapImage = $mapObject->draw();
$urlImage = $mapImage->saveWebImage();

$mapLegend = $mapObject->drawLegend();
$urlLegend = $mapLegend->saveWebImage(MS_GIF, 0, 0, -1);

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <title>Visor D</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?php echo $MISC_URL ?>/img/dc.css">
    <script src="<?php echo $MISC_URL ?>/lib/mscross-1.1.9.js" type="text/javascript"></script>

    <style type="text/css">
        .contenedor {
            justify-content: center;
            display: flex;
            /* flex-direction: column; */
            align-items: center;
            gap: 20px;
        }

        #Layer1 {
            position: absolute;
            z-index: 101;
            right: 40px;
            bottom: 0;
        }

        #Layer2 {
            /* position: absolute;
            width: 141px; */
            height: fit-content;
            /*
            margin-left: 10px;
            z-index: 102;
            right: 210px;
            top: 276px; */
        }

        #Layer2>* {
            padding-left: 20px;
        }
    </style>
</head>

<body>
    <div class="contenedor">
        <div class="col">
            <div id="Layer2">
                <form name="select_layers">
                    <p align="left">
                        <input checked onclick="chgLayers()" type="checkbox" name="layer[0]" value="Cali">
                        <Strong>Cali</Strong>
                    </p>
                    <p align="left">
                        <input checked onclick="chgLayers()" type="checkbox" name="layer[1]" value="Barrios">
                        <Strong>Barrios</Strong>
                    </p>
                    <p align="left">
                        <input checked onclick="chgLayers()" type="checkbox" name="layer[2]" value="Comunas">
                        <Strong>Comunas</Strong>
                    </p>
                    <p align="left">
                        <input checked onclick="chgLayers()" type="checkbox" name="layer[3]" value="Cali2">
                        <Strong>Manzanas</Strong>
                    </p>
                    <p align="left">
                        <input checked onclick="chgLayers()" type="checkbox" name="layer[4]" value="Malla_Vial">
                        <Strong>Malla vial</Strong>
                    </p>
                </form>
            </div>



            <div id="leyendas">
                <img src="<?php echo $urlLegend ?>" border=1>
            </div>
        </div>
        <div class="col">

            <div class="mscross" style="overflow:hidden; width: 750px; height:700px; -moz-user-select:none; position:relative;" id="dc_main">
                <!-- Fallback: imagen renderizada por MapScript en servidor -->
                <img src="<?php echo $urlImage ?>" alt="Mapa" style="width:100%;height:100%;object-fit:cover;" id="dc_fallback">
                <div id="Layer1">
                    <div style="overflow: auto; width: 140px; height: 140px; -moz-user-select:none; position:relative; z-index:100;" id="dc_main2">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        //<![CDATA[

        myMap1 = new msMap(document.getElementById("dc_main"), "standardRight");
        myMap1.setCgi("<?php echo $MAPSERV_PATH; ?>");
        myMap1.setMapFile("<?php echo $MAPFILE_PATH; ?>");
        myMap1.setFullExtent(1050867.55, 1075491.88, 858820.55);
        myMap1.setLayers("Cali Puntos");

        myMap2 = new msMap(document.getElementById("dc_main2"));
        myMap2.setActionNone();
        myMap2.setFullExtent(1050867.55, 1075491.88, 858820.55);
        myMap2.setMapFile("<?php echo $MAPFILE_PATH; ?>");
        myMap2.setLayers("Cali");
        myMap1.setReferenceMap(myMap2);

        var insertarZoo = new msTool("InsertarCoordenadas", insertZ, "<?php echo $MISC_URL ?>/img/marker-gold.png", queryI);

        var consultarZoo = new msTool("Obtener Informacion", consultarZ, "<?php echo $MISC_URL ?>/img/marker-blue.png", queryII);

        myMap1.getToolbar(0).addMapTool(insertarZoo);
        myMap1.getToolbar(0).addMapTool(consultarZoo);

        myMap1.redraw();
        myMap2.redraw();

        // Oculta el fallback si la librería JS renderizó el mapa correctamente
        try {
            var fb = document.getElementById('dc_fallback');
            if (fb) fb.style.display = 'none';
        } catch (e) {}

        chgLayers();
        var selectlayer = -1;

        function chgLayers() {

            var list = "Layers ";

            var objForm = document.forms[0];

            for (let i = 0; i < document.forms[0].length; i++) {
                if (objForm.elements["layer[" + i + "]"].checked) {
                    list = list + objForm.elements["layer[" + i + "]"].value + " ";
                }

            }

            myMap1.setLayers(list);
            myMap1.redraw();
        }

        function objetoAjaX() {
            var xmlhttp = false;
            try {
                xmlhttp = new ActiveXObject("MSxml2.XMLHTTP");
            } catch (e) {
                try {
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (E) {
                    xmlhttp = false;
                }
            }
            if (!xmlhttp && typeof XMLHttpRequest != "undefined") {
                xmlhttp = new XMLHttpRequest();
            }
            return xmlhttp;
        }

        var seleccionado = false;

        function insertZ(e, map) {
            map.getTagMap().style.cursor = "crosshair";
            seleccionado = true;
        }

        function consultarZ(e, map) {
            map.getTagMap().style.cursor = "crosshair";
            seleccionado = true;
        }

        function queryI(event, map, x, y, xx, yy) {
            if (seleccionado) {
                alert("Coordenadas mapa: x:" + x + " y " + y + " reales: x " + xx + " y " + yy);
                consulta1 = objetoAjaX();
                consulta1.open("GET", "<?php echo $PROJECT_ROOT_URL ?>/view/mapa/Insertar_punto.php?x=" + xx + "&y=" + yy, true);
                consulta1.onreadystatechange = function() {
                    if (consulta1.readyState == 4) {
                        var result = consulta1.responseText;
                        alert(result);
                    }
                }
                consulta1.send(null);
                seleccionado = false;
                map.getTagMap().style.cursor = "default";
            }
        }

        function queryII(event, map, x, y, xx, yy) {
            if (seleccionado) {
                consulta2 = objetoAjaX();
                consulta2.open("GET", "<?php echo $PROJECT_ROOT_URL ?>/view/mapa/consulta.php?x=" + xx + "&y=" + yy, true);
                consulta2.onreadystatechange = function() {
                    if (consulta2.readyState == 4) {
                        var result = consulta2.responseText;
                        alert(result);
                    }
                }
                consulta2.send(null);
                seleccionado = false;
                map.getTagMap().style.cursor = "default";
            }
        }
        //]]
    </script>

</body>

</html>