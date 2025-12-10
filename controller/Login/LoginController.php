<?php
class LoginController
{

    public function login()
    {

        $obj = new LoginModel();
        // Aceptar 'documento' (o compatibilidad con 'usu_correo') y la clave 'usu_clave' o 'contrasena'
        $documento = isset($_POST['documento']) ? trim($_POST['documento']) : (isset($_POST['usu_correo']) ? trim($_POST['usu_correo']) : '');
        $usu_clave = isset($_POST['usu_clave']) ? $_POST['usu_clave'] : (isset($_POST['contrasena']) ? $_POST['contrasena'] : '');

        if (empty($documento) || empty($usu_clave)) {
            $_SESSION['error'] = "Documento y contraseña son obligatorios";
            redirect("../view/login/Login.php");
            return;
        }

        // Usar pg_query_params para evitar inyección SQL
        $sql = 'SELECT * FROM usuarios WHERE Documento = $1 LIMIT 1';
        $params = array($documento);
        $resultado = pg_query_params($obj->getConnect(), $sql, $params);

        if ($resultado && pg_num_rows($resultado) > 0) {
            $usu = pg_fetch_assoc($resultado);

            $stored_hash = isset($usu['usu_clave']) ? $usu['usu_clave'] : '';

            // Soporte para contraseñas hasheadas y para claves en texto plano (migración)
            $valid = false;
            if (!empty($stored_hash)) {
                if (password_verify($usu_clave, $stored_hash)) {
                    $valid = true;
                } elseif ($usu_clave === $stored_hash) {
                    $valid = true;
                }
            }

            if ($valid) {
                $_SESSION['usu_nombre'] = $usu['usu_nombre'];
                $_SESSION['usu_correo'] = $usu['usu_correo'];
                $_SESSION['usu_id'] = $usu['usu_id'];
                $_SESSION['auth'] = "ok";

                redirect("../view/partials/content.php");
                return;
            }
        }

        // Si llega aquí, credenciales inválidas
        $_SESSION['error'] = "Documento o contraseña incorrectos";
        redirect("../view/login/Login.php");

    }

    public function logout()
    {

        session_destroy();

    }

}
?>