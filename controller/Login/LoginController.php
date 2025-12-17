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
            $id_rol = $usu['id_rol'];
            // Obtener el hash almacenado
            $stored_hash = $usu['contrasena'];

            // Verificar usando bcrypt
            if ($stored_hash === sha1(trim($usu_clave))) {
                $_SESSION['auth'] = "ok";
                $this->contruirPermisos();
                $this->permisos($id_rol);

                $_SESSION['usuario'] = array(
                    'id' => $usu['id_usuario'],
                    'documento' => $usu['documento'],
                    'nombre' => $usu['nombre'],
                    'apellido' => $usu['apellido'],
                    'telefono' => $usu['telefono'],
                    'correo' => $usu['correo']
                );

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

    private function permisos($id_rol)
    {
        $sql = "
            SELECT 
            r.id_rol,
            r.nombre AS rol,
            m.id_modulo,
            m.nombre AS modulo,
            a.id_accion,
            a.nombre AS accion
            FROM permisos p
            INNER JOIN roles r        ON p.id_rol = r.id_rol
            INNER JOIN modulos m      ON p.id_modulo = m.id_modulo
            INNER JOIN acciones a     ON p.id_accion = a.id_accion
            WHERE p.id_rol = $id_rol
            ORDER BY m.nombre, a.nombre";

        $obj = new LoginModel();
        $result = $obj->select($sql);

        while ($row = pg_fetch_assoc($result)) {

            $modulo = $row['modulo'];
            $accion = $row['accion'];

            // Guardar módulo
            if (!in_array($modulo, $_SESSION['modulos'])) {
                $_SESSION['modulos'][] = $modulo;
            }
            
            // Guardar acción por módulo
            $_SESSION['acciones'][$modulo][] = $accion;
            
            // Guardar permisos (módulo + acción)
            $_SESSION['permisos'][] = $modulo . ":" . $accion;
        }
    }
    private function contruirPermisos()
    {
        $_SESSION['modulos'] = array();
        $_SESSION['acciones'] = array();
        $_SESSION['permisos'] = array();
    }
}
?>