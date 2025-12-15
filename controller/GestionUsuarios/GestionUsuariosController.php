<?php

include_once '../model/GestionUsuarios/GestionUsuariosModel.php';

class GestionUsuariosController
{
    public function list()
    {
        $obj = new GestionUsuariosModel();
        $usuarios = $obj->getAll();
        include_once '../view/gestionUsuarios/ConsultarUsuario.php';
    }

    public function getCreate()
    {
        $obj = new GestionUsuariosModel();
        $roles = $obj->select("SELECT * FROM roles ORDER BY id_rol");
        $estados = $obj->select("SELECT * FROM estado_usuario ORDER BY id_estado_usuario");
        include_once '../view/gestionUsuarios/CrearUsuario.php';
    }

    public function postCreate()
    {
        $obj = new GestionUsuariosModel();
        $documento = trim($_POST['documento'] ?? '');
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $password = $_POST['password'] ?? '';
        $id_rol = isset($_POST['id_rol']) ? $_POST['id_rol'] : null;

        if (empty($documento) || empty($nombre) || empty($apellido) || empty($telefono) || empty($correo) || empty($password) || empty($id_rol)) {
            jsonResponse(false, 'Todos los campos son obligatorios');
        }

        // Validar que documento y telefono sean solo dígitos
        if (!ctype_digit($documento)) {
            jsonResponse(false, 'El documento debe contener solo dígitos');
        }
        if (!ctype_digit($telefono)) {
            jsonResponse(false, 'El teléfono debe contener solo dígitos');
        }

        // Verificar unicidad de documento, correo y telefono
        $exDoc = $obj->getByDocumento($documento);
        if ($exDoc && pg_num_rows($exDoc) > 0) {
            jsonResponse(false, 'El documento ya está registrado');
        }

        $exCorreo = $obj->getByCorreo($correo);
        if ($exCorreo && pg_num_rows($exCorreo) > 0) {
            jsonResponse(false, 'El correo ya está registrado');
        }

        // Verificar telefono unico
        $sqlTel = "SELECT * FROM usuarios WHERE telefono = $1";
        $resTel = pg_query_params($obj->getConnect(), $sqlTel, array($telefono));
        if ($resTel && pg_num_rows($resTel) > 0) {
            jsonResponse(false, 'El teléfono ya está registrado');
        }

        

        $hash = password_hash($password, PASSWORD_DEFAULT);

        $data = [
            'documento' => $documento,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'correo' => $correo,
            'contrasena' => $hash,
            'id_rol' => $id_rol,
            'id_estado_usuario' => 1,
        ];

        $insert = $obj->create($data);

        if ($insert) {
            jsonResponse(true, 'Usuario creado correctamente', ['redirect' => getUrl('GestionUsuarios', 'GestionUsuarios', 'list')]);
        } else {
            jsonResponse(false, 'No se pudo crear el usuario');
        }
    }

    public function getUpdate()
    {
        $obj = new GestionUsuariosModel();
        $id = $_GET['id'];
        $res = $obj->getById($id);
        $usuario = pg_fetch_assoc($res);
        $roles = $obj->select("SELECT * FROM roles ORDER BY id_rol");
        $estados = $obj->select("SELECT * FROM estado_usuario ORDER BY id_estado_usuario");
        include_once '../view/gestionUsuarios/EditarUsuario.php';
    }

    public function postUpdate()
    {
        $obj = new GestionUsuariosModel();
        $id = $_POST['id'];
        $documento = trim($_POST['documento'] ?? '');
        $nombre = trim($_POST['nombre'] ?? '');
        $apellido = trim($_POST['apellido'] ?? '');
        $telefono = trim($_POST['telefono'] ?? '');
        $correo = trim($_POST['correo'] ?? '');
        $id_rol = isset($_POST['id_rol']) ? $_POST['id_rol'] : null;
        $id_estado_usuario = isset($_POST['id_estado_usuario']) ? $_POST['id_estado_usuario'] : null;

        if (empty($id) || empty($documento) || empty($nombre) || empty($apellido) || empty($telefono) || empty($correo) || empty($id_rol) || empty($id_estado_usuario)) {
            jsonResponse(false, 'Todos los campos (excepto contraseña) son obligatorios');
        }

        // Validar que documento y telefono sean solo dígitos
        if (!ctype_digit($documento)) {
            jsonResponse(false, 'El documento debe contener solo dígitos');
        }
        if (!ctype_digit($telefono)) {
            jsonResponse(false, 'El teléfono debe contener solo dígitos');
        }

        // Validar unicidad documento, correo y telefono (excluyendo al propio registro)
        $exDoc = $obj->getByDocumento($documento);
        if ($exDoc && pg_num_rows($exDoc) > 0) {
            $row = pg_fetch_assoc($exDoc);
            if ($row['id_usuario'] != $id) jsonResponse(false, 'El documento ya está registrado por otro usuario');
        }

        $exCorreo = $obj->getByCorreo($correo);
        if ($exCorreo && pg_num_rows($exCorreo) > 0) {
            $row = pg_fetch_assoc($exCorreo);
            if ($row['id_usuario'] != $id) jsonResponse(false, 'El correo ya está registrado por otro usuario');
        }

        $sqlTel = "SELECT * FROM usuarios WHERE telefono = $1";
        $resTel = pg_query_params($obj->getConnect(), $sqlTel, array($telefono));
        if ($resTel && pg_num_rows($resTel) > 0) {
            $row = pg_fetch_assoc($resTel);
            if ($row['id_usuario'] != $id) jsonResponse(false, 'El teléfono ya está registrado por otro usuario');
        }

        

        $data = [
            'documento' => $documento,
            'nombre' => $nombre,
            'apellido' => $apellido,
            'telefono' => $telefono,
            'correo' => $correo,
            'id_rol' => $id_rol,
        ];

        // Si viene contraseña, actualizarla (opcional)
        if (!empty($_POST['password'])) {
            $data['contrasena'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
        }

        $data['id_estado_usuario'] = $id_estado_usuario;

        $update = $obj->updateById($id, $data);

        if ($update) {
            jsonResponse(true, 'Usuario actualizado correctamente', ['redirect' => getUrl('GestionUsuarios', 'GestionUsuarios', 'list')]);
        } else {
            jsonResponse(false, 'No se pudo actualizar el usuario');
        }
    }

    public function getDelete()
    {
        $obj = new GestionUsuariosModel();
        $id = $_GET['id'];
        $res = $obj->getById($id);
        $usuario = pg_fetch_assoc($res);
        include_once '../view/gestionUsuarios/EliminarUsuario.php';
    }

    // Devuelve datos del usuario (y opciones de selects) en JSON para uso en modal
    public function getData()
    {
        $obj = new GestionUsuariosModel();
        // Aceptar id tanto en GET como en POST para mayor flexibilidad (AJAX puede usar POST)
        $id = $_REQUEST['id'] ?? null;
        if (!$id) jsonResponse(false, 'ID de usuario faltante');

        $res = $obj->getById($id);
        if (!$res || pg_num_rows($res) == 0) jsonResponse(false, 'Usuario no encontrado');

        $usuario = pg_fetch_assoc($res);

        // Roles
        $rolesRes = $obj->select("SELECT * FROM roles ORDER BY id_rol");
        $rolesHtml = '';
        while ($r = pg_fetch_assoc($rolesRes)) {
            $sel = ($r['id_rol'] == $usuario['id_rol']) ? ' selected' : '';
            $rolesHtml .= '<option value="' . $r['id_rol'] . '"' . $sel . '>' . $r['nombre'] . '</option>';
        }

        // Estados
        $estadosRes = $obj->select("SELECT * FROM estado_usuario ORDER BY id_estado_usuario");
        $estadosHtml = '';
        while ($s = pg_fetch_assoc($estadosRes)) {
            $sel = ($s['id_estado_usuario'] == $usuario['id_estado_usuario']) ? ' selected' : '';
            $estadosHtml .= '<option value="' . $s['id_estado_usuario'] . '"' . $sel . '>' . $s['nombre'] . '</option>';
        }

        jsonResponse(true, '', ['user' => $usuario, 'roles' => $rolesHtml, 'estados' => $estadosHtml]);
    }

    public function postDelete()
    {
        $obj = new GestionUsuariosModel();
        $id = $_POST['id'];

        // Usamos inhabilitación por estado (id_estado_usuario = 2) si existe la tabla de estados
        $res = $obj->setEstado($id, 2);

        if ($res) {
            jsonResponse(true, 'Usuario inhabilitado correctamente', ['redirect' => getUrl('GestionUsuarios', 'GestionUsuarios', 'list')]);
        } else {
            // como fallback intentar borrado físico
            $del = $obj->delete($id);
            if ($del) {
                jsonResponse(true, 'Usuario eliminado correctamente', ['redirect' => getUrl('GestionUsuarios', 'GestionUsuarios', 'list')]);
            } else {
                jsonResponse(false, 'No se pudo eliminar o inhabilitar el usuario');
            }
        }
    }
}

?>