<?php
// controller/Login/LoginController.php

include_once("../model/Login/loginModel.php");

class LoginController
{
    public function login()
    {
        $obj = new LoginModel();

        $documento = isset($_POST['documento']) ? trim($_POST['documento']) :
            (isset($_POST['usu_correo']) ? trim($_POST['usu_correo']) : '');
        $usu_clave = isset($_POST['usu_clave']) ? $_POST['usu_clave'] :
            (isset($_POST['contrasena']) ? $_POST['contrasena'] : '');

        if (empty($documento) || empty($usu_clave)) {
            $_SESSION['error'] = "Documento y contraseña son obligatorios";
            redirect("../view/login/Login.php");
            return;
        }

        $sql = "SELECT * FROM usuarios WHERE documento = '$documento' LIMIT 1";
        $resultado = $obj->select($sql);

        if ($resultado && pg_num_rows($resultado) > 0) {
            $usu = pg_fetch_assoc($resultado);
            $stored_hash = isset($usu['usu_clave']) ? $usu['usu_clave'] : '';

            $valid = false;
            dd($stored_hash);
            if (!empty($stored_hash)) {
                if (password_verify($usu_clave, $stored_hash)) {
                    $valid = true;
                } elseif ($usu_clave === $stored_hash) {
                    $valid = true;
                }
            }

            if ($valid) {
                $_SESSION['logueado'] = true;
            }
            $_SESSION['auth'] = "ok";
            redirect("index.php");
            return;
        }

        $_SESSION['error'] = "Documento o contraseña incorrectos";
        redirect("../view/login/Login.php");
    }

    public function logout()
    {
        // Limpiar todas las variables de sesión
        $_SESSION = array();

        // Destruir la sesión
        session_destroy();

        // CORREGIDO: Ruta correcta desde web/ajax.php
        redirect("../view/login/Login.php");
    }
}
?>