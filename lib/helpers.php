<?php
// lib/helpers.php

// Iniciar sesión solo si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function redirect($url)
{
    echo "<script>" .
        "window.location.href = '$url';" .
        "</script>";
}

function dd($var)
{
    echo "<pre>";
    die(print_r($var));
}

function getUrl($modulo, $controlador, $funcion, $parametros = false, $pagina = false)
{
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
    $modulo = ucwords($_GET['modulo']);
    $controlador = ucwords($_GET['controlador']);
    $funcion = $_GET['funcion'];

    if (is_dir("../controller/" . $modulo)) {
        if (is_file("../controller/" . $modulo . "/" . $controlador . "Controller.php")) {
            require_once("../controller/" . $modulo . "/" . $controlador . "Controller.php");
            $controlador = $controlador . "Controller";
            $objClase = new $controlador();

            if (method_exists($objClase, $funcion)) {
                $objClase->$funcion();
            } else {
                echo "La función especificada no existe";
            }
        } else {
            echo "El controlador especificado no existe";
        }
    } else {
        echo "El módulo especificado no existe";
    }
}
?>