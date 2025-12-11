<?php

include_once("../model/Login/loginModel.php");

class LoginController
{
    public function login()
    {
        $obj = new LoginModel();

        // Validar que vengan los datos
        if (!isset($_POST['documento']) || !isset($_POST['usu_clave'])) {
            $_SESSION['error'] = "Documento y contraseña son obligatorios";
            redirect("Login.php");
            return;
        }

        $documento = trim($_POST['documento']);
        $usu_clave = trim($_POST['usu_clave']);


        // Buscar usuario solo por documento
        $sql = "SELECT * FROM usuarios WHERE documento = '$documento' LIMIT 1";
        $resultado = $obj->select($sql);

        if ($resultado && pg_num_rows($resultado) > 0) {

            $usu = pg_fetch_assoc($resultado);

            // Obtener el hash almacenado
            $stored_hash = $usu['contrasena'];

            // Verificar usando bcrypt
            if (password_verify($usu_clave, $stored_hash)) {
                $_SESSION['auth'] = "ok";
                redirect("index.php");
                return;
            }
        }

        // Si falla
        $_SESSION['error'] = "Documento o contraseña incorrectos";
        redirect("Login.php");
    }

    public function logout()
    {
        session_destroy();
        redirect("Login.php");
    }
}
?>