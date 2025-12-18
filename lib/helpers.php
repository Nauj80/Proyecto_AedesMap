<?php

session_start();
function redirect($url)
{
    echo "<script>" .
        "window.location.href = '$url';" .
        "</script>";
}
function tieneModulo($modulo)
{
    return isset($_SESSION['modulos'])
        && in_array($modulo, $_SESSION['modulos']);
}

function tieneAccion($modulo, $accion)
{
    return isset($_SESSION['acciones'][$modulo])
        && in_array($accion, $_SESSION['acciones'][$modulo]);
}

function tienePermiso($modulo, $accion)
{
    $permiso = $modulo . ":" . $accion;

    return isset($_SESSION['permisos'])
        && in_array($permiso, $_SESSION['permisos']);
}

function dd($var)
{
    echo "<pre>";
    die(print_r($var));
}

function getUrl($modulo, $controlador, $funcion, $parametros = false, $pagina = false)
{
    $_SESSION['controller'] = $controlador;

    if ($pagina == false) {
        $pagina = "index";
    }

    $url = "$pagina.php?modulo=$modulo&controlador=$controlador&funcion=$funcion";

    if ($parametros != false) {
        foreach ($parametros as $key => $valor) {
            $url .= "&$key=$valor";
        }
    }
    return $url;
}


function resolve()
{

    $modulo = ucwords($_GET['modulo']); // modulo-> carpeta dentro del controlador
    $controlador = ucwords($_GET['controlador']); // controlador -> archivo controller dentro del modulo
    $funcion = $_GET['funcion']; // funcion -> metodo dentro de la clase del controlador
    if (is_dir("../controller/" . $modulo)) {
        if (is_file("../controller/" . $modulo . "/" . $controlador . "Controller.php")) {

            require_once("../controller/" . $modulo . "/" . $controlador . "Controller.php");

            $controlador = $controlador . "Controller";

            $objClase = new $controlador();

            if (method_exists($objClase, $funcion)) {
                // Se establece la sesión ANTES de llamar a la función que renderiza la vista.
                $objClase->$funcion();
            } else {
                echo "La funcion especificada no existe";
            }
        } else {
            echo "El controlador especificado no existe";
        }
    } else {
        echo "El modulo especificado no existe";
    }
}

function jsonResponse($success, $message, $data = null)
{
    // Asegurarnos de no enviar ninguna salida previa
    if (!headers_sent()) {
        header('Content-Type: application/json');
    }
    echo json_encode(array(
        'success' => $success,
        'message' => $message,
        'data' => $data
    ));
    // Terminar ejecución inmediatamente para evitar HTML adicional
    exit;
}
function recargarPermisos($id_rol_editado)
{
    // 1. Seguridad: Solo recargar si es MI propio rol
    // Asumo que $_SESSION['id_rol'] existe. Si usas otro nombre, cámbialo aquí.
    if (isset($_SESSION['id_rol']) && $_SESSION['id_rol'] == $id_rol_editado) {

        // 2. Buscar e incluir el LoginController
        // Usamos la misma lógica de rutas que tu función 'resolve'
        $rutaLogin = "../controller/LoginController.php";

        // Si no está en la raíz de controller, quizás está en una carpeta Login
        if (!file_exists($rutaLogin)) {
            $rutaLogin = "../controller/Login/LoginController.php";
        }

        if (file_exists($rutaLogin)) {
            require_once($rutaLogin);

            // 3. Llamar a las funciones estáticas
            // Asegúrate de haber puesto 'public static' en LoginController como hablamos antes
            LoginController::contruirPermisos();
            LoginController::permisos($id_rol_editado);
            //LoginController::recargarPermisos();
        }
    }
}