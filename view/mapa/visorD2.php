<?php
if (!extension_loaded("MapScript")) {
    dl('php_mapscript.' . PHP_SHLIB_SUFFIX);
}
$PROJECT_ROOT_URL = '/Proyecto_AedesMap';
$MAPSERV_PATH = '/cgi-bin/mapserv.exe';
$MAPFILE_PATH = 'C:/ms4w/Apache/htdocs/Proyecto_AedesMap/web/assets/mapa/cali.map';
$MISC_URL = $PROJECT_ROOT_URL . '/web/assets/mapa/misc';

$mapObject = ms_newMapObj($MAPFILE_PATH);
$mapImage = $mapObject->draw();
$urlImage = $mapImage->saveWebImage();

$mapLegend = $mapObject->drawLegend();
$urlLegend = $mapLegend->saveWebImage(MS_GIF, 0, 0, -1);
?>

<link rel="stylesheet" type="text/css" href="<?php echo $MISC_URL ?>/img/dc.css" />
<script type="text/javascript">
    window.MSCROSS_BASE = '<?php echo $MISC_URL ?>';
</script>
<script src="<?php echo $MISC_URL ?>/lib/mscross-1.1.9.js"></script>

<style>
    #app {
        display: flex;
        height: 100vh;
        width: 50vw;
    }

    /* CONTENIDO PRINCIPAL derecha */
    main.content-area {
        background: #f9fafc;
        flex-grow: 1;
        height: 100%;
        display: flex;
        flex-direction: column;
        user-select: none;
    }


    /* SECCIÓN MAPAS + SIDEBAR CONTROLES */
    section.map-wrapper {
        margin-top: 1rem;
        display: flex;
        gap: 1.75rem;
        flex-grow: 1;
        min-height: 0;
        overflow: hidden;
    }

    /* MAPA PRINCIPAL */
    #dc_main {
        flex-grow: 1;
        border-radius: 16px;
        position: relative;
        overflow: hidden;
    }

    /* #dc_main img#dc_fallback {
        width: 100%;
        height: 100%;
        object-fit: contain;
        border-radius: 16px;
        user-select: none;
        pointer-events: none;
    } */

    /* ocultar Layer1 dentro del mapa porque genera conflicto */
    #Layer1 {
        display: none !important;
    }

    /* SIDEBAR controles (mapa referencia + capas) */
    aside.sidebar-controls {
        width: 320px;
        display: flex;
        flex-direction: column;
        gap: 2rem;
        overflow-y: auto;
        scrollbar-width: thin;
    }

    /* Cards sidebar */
    .card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgb(103 109 203 / 0.15);
        padding: 1rem 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .card h2 {
        font-weight: 700;
        font-size: 1.15rem;
        margin: 0;
        color: #3b3f6c;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        user-select: text;
    }

    .card h2 svg {
        fill: #615be2;
        width: 22px;
        height: 22px;
        flex-shrink: 0;
    }

    /* mapa referencia */
    #dc_main2 {
        width: 150px !important;
        height: 180px !important;
        border-radius: 10px;
        box-shadow: 0 6px 16px rgb(103 109 203 / 0.25);
        overflow: hidden;
        user-select: none;
    }

    /* formulario capas */
    form[name="select_layers"] {
        display: flex;
        flex-direction: column;
    }

    form label {
        cursor: pointer;
        font-weight: 600;
        font-size: 1rem;
        color: #3b3f6c;
        display: flex;
        align-items: center;
        gap: 10px;
        user-select: none;
    }

    /* checkbox styling */
    input[type="checkbox"] {
        appearance: none;
        width: 20px;
        height: 20px;
        border: 2px solid #615be2;
        border-radius: 6px;
        cursor: pointer;
        position: relative;
        flex-shrink: 0;
        transition: background-color 0.2s ease, border-color 0.2s ease;
    }

    input[type="checkbox"]:checked {
        background-color: #615be2;
        border-color: #615be2;
    }

    input[type="checkbox"]:checked::after {
        content: '';
        position: absolute;
        top: 3px;
        left: 7px;
        width: 4px;
        height: 10px;
        border: solid white;
        border-width: 0 2.5px 2.5px 0;
        transform: rotate(45deg);
    }

    #leyendas img {
        object-fit: contain;
        border-radius: 10px;
        border: 1px solid #e0e0e0;
        user-select: none;
    }


    .toolbarP>div {
        opacity: 1 !important;
        background-color: #7e79dfff !important;
    }

    /* Responsive */
    @media (max-width: 960px) {
        nav.navbar {
            width: 220px;
        }

        main.content-area {
            padding: 1rem;
        }

        aside.sidebar-controls {
            width: 260px;
        }

        section.map-wrapper {
            flex-direction: column;
            overflow-y: auto;
        }

        #dc_main {
            min-height: 360px;
        }
    }
</style>


<!-- CONTENIDO -->
<main class="content-area" role="main" aria-label="Contenido principal del visor">


    <section class="map-wrapper" aria-label="Mapa principal y controles de capas">
        <div class="mscross" style="overflow:hidden; width: 1600px; height:600px; -moz-user-select:none; position:relative;" id="dc_main">
            <!-- Fallback: imagen renderizada por MapScript en servidor -->
            <img src="<?php echo $urlImage ?>" alt="Mapa" style="width:100%;height:100%;object-fit:cover;" id="dc_fallback">

        </div>

        <aside class="sidebar-controls" aria-label="Controles laterales del visor">
            <section class="card" aria-label="Mapa referencia">
                <h2>
                    <svg aria-hidden="true" focusable="false" viewBox="0 0 24 24">
                        <path d="M3 5v14h18V5H3zm16 12H5V7h14v10z" />
                    </svg>
                    Mapa de Referencia
                </h2>

                <div style="overflow: auto; width: 140px; height: 140px; -moz-user-select:none; position:relative; z-index:100;" id="dc_main2">
                </div>

            </section>

            <section class="card" aria-label="Selección de capas">
                <h2>
                    <svg aria-hidden="true" focusable="false" viewBox="0 0 24 24">
                        <path d="M3 6l9-4 9 4-9 4-9-4zm0 4.5l9 4 9-4-9-4-9 4zm0 5l9 4 9-4-9-4-9 4z" />
                    </svg>
                    Capas del Mapa
                </h2>
                <div class="row">

                    <form name="select_layers" class="col-2">
                        <p align="left">
                            <input checked onclick="chgLayers()" type="checkbox" name="layer[5]" value="Puntos">
                        </p>
                        <p align="left">
                            <input checked onclick="chgLayers()" type="checkbox" name="layer[4]" value="Malla_Vial">
                        </p>
                        <p align="left">
                            <input checked onclick="chgLayers()" type="checkbox" name="layer[3]" value="Cali2">
                        </p>
                        <p align="left">
                            <input checked onclick="chgLayers()" type="checkbox" name="layer[1]" value="Barrios">
                        </p>
                        <p align="left">
                            <input checked onclick="chgLayers()" type="checkbox" name="layer[2]" value="Comunas">
                        </p>
                        <p align="left">
                            <input checked onclick="chgLayers()" type="checkbox" name="layer[0]" value="Cali">
                        </p>
                    </form>
                    <div id="leyendas" class="col-4" aria-label="Leyenda del mapa">
                        <img src="<?php echo $urlLegend ?>" alt="Leyenda de símbolos" />
                    </div>
                </div>

            </section>
        </aside>
    </section>
</main>

<script>
    // Código JS sin cambios funcionales que tienes

    var myMap1 = new msMap(document.getElementById("dc_main"), "standardLeft");
    myMap1.setCgi("<?php echo $MAPSERV_PATH; ?>");
    myMap1.setMapFile("<?php echo $MAPFILE_PATH; ?>");
    myMap1.setFullExtent(1050867.55, 1077991.88, 865820.55);
    myMap1.setLayers("Cali Puntos Barrios Comunas Cali2 Malla_vial");

    var myMap2 = new msMap(document.getElementById("dc_main2"));
    myMap2.setActionNone();
    myMap2.setFullExtent(1050867.55, 1075491.88, 858820.55);
    myMap2.setMapFile("<?php echo $MAPFILE_PATH; ?>");
    myMap2.setLayers("Cali");
    myMap1.setReferenceMap(myMap2);

    var insertarZoo = new msTool("InsertarCoordenadas", insertZ, "<?php echo $MISC_URL ?>/img/ubicacion.png", queryI);
    var consultarZoo = new msTool("Obtener Informacion", consultarZ, "<?php echo $MISC_URL ?>/img/punto-de-informacion.png", queryII);

    myMap1.getToolbar(0).addMapTool(insertarZoo);
    myMap1.getToolbar(0).addMapTool(consultarZoo);


    myMap1.redraw();
    myMap2.redraw();

    try {
        var fb = document.getElementById('dc_fallback');
        if (fb) fb.style.display = 'none';
    } catch (e) {}

    chgLayers();

    var seleccionado = false;

    function chgLayers() {
        var list = "Layers ";
        var objForm = document.forms[0];
        for (let i = 0; i < objForm.length; i++) {
            if (objForm.elements["layer[" + i + "]"].checked) {
                list += objForm.elements["layer[" + i + "]"].value + " ";
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
        if (!xmlhttp && typeof XMLHttpRequest !== "undefined") {
            xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
    }

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
           
            const urlRegistro = "<?php echo getUrl('Zoocriadero', 'Zoocriadero', 'registrar', array('x' => '')); ?>" + xx + "&y=" + yy;
            // Redirigimos al usuario a la página de registro.
            window.location.href = urlRegistro;
            seleccionado = false;
            map.getTagMap().style.cursor = "default";
        }
    }

    function queryII(event, map, x, y, xx, yy) {
        if (seleccionado) {
            var consulta2 = objetoAjaX();
            consulta2.open("GET", "<?php echo $PROJECT_ROOT_URL ?>/view/mapa/consulta.php?x=" + xx + "&y=" + yy, true);
            consulta2.onreadystatechange = function() {
                if (consulta2.readyState == 4) {
                    alert(consulta2.responseText);
                }
            };
            consulta2.send(null);
            seleccionado = false;
            map.getTagMap().style.cursor = "default";
        }
    }
</script>