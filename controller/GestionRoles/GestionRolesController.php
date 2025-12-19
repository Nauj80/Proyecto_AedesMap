<?php

include_once("../model/GestionRoles/GestionRolesModel.php");
class GestionRolesController
{
    public function listar()
    {
        $objeto = new GestionRolesModel();
        $sql = "SELECT * FROM roles WHERE id_estado_rol = 1";
        $roles = $objeto->select($sql);
        $roles = pg_fetch_all($roles);
        include_once '../view/gestionRoles/ConsultarRoles.php';
    }
    public function filtro()
    {
        $objeto = new GestionRolesModel();
        $buscar = $_GET['buscar'];

        // Se agrega la condición OR para el id_rol y se convierte a TEXT para permitir búsquedas parciales
        $sql = "SELECT * FROM roles 
            WHERE id_estado_rol = 1 
            AND (nombre ILIKE '%$buscar%' OR CAST(id_rol AS TEXT) ILIKE '%$buscar%')";

        $roles = $objeto->select($sql);
        $roles = pg_fetch_all($roles);
        include_once '../view/gestionRoles/Filtro.php';
    }
    public function editar()
    {
        $objeto = new GestionRolesModel();
        $id_rol = isset($_GET['id_rol']) ? (int) $_GET['id_rol'] : 0;
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
        ORDER BY m.nombre, a.nombre
        ";
        $permiso = $objeto->select($sql);
        $permisos = pg_fetch_all($permiso);

        //consulta para traer todos los acciones
        $sql = "SELECT * FROM acciones";
        $permiso = $objeto->select($sql);
        $accionesDisponibles = pg_fetch_all($permiso);

        //consulta para traer todos los modulos
        $sql = "SELECT * FROM modulos";
        $permiso = $objeto->select($sql);
        $modulosDisponibles = pg_fetch_all($permiso);

        $_SESSION['id_rol'] = $id_rol;
        $sql = "SELECT * FROM roles WHERE id_estado_rol = 1";
        $roles = $objeto->select($sql);
        $roles = pg_fetch_all($roles);

        include '../view/gestionRoles/EditarPermisos.php';
    }
    public function guardarPermisos()
    {
        $objeto = new GestionRolesModel();

        // 1. Recibir y validar el ID del rol
        $id_rol = isset($_POST['id_rol']) ? (int) $_POST['id_rol'] : 0;

        if ($id_rol > 0) {


            // ELIMINAR LOS PERMISOS ANTIGUOS

            $sqlDelete = "DELETE FROM permisos WHERE id_rol = $id_rol";
            // Asumo que tu modelo tiene un método para ejecutar (insert/update/delete)
            // Si no se llama 'execute', cámbialo por el que uses (ej: 'delete', 'query', etc.)
            $objeto->delete($sqlDelete);



            // INSERTAR LOS NUEVOS PERMISOS

            if (isset($_POST['permisos']) && is_array($_POST['permisos'])) {

                // Opción A: Insertar uno por uno (Más fácil de entender)
                /*
                foreach ($_POST['permisos'] as $id_modulo => $acciones) {
                    foreach ($acciones as $id_accion => $valor) {
                        $sqlInsert = "INSERT INTO permisos (id_rol, id_modulo, id_accion) 
                                      VALUES ($id_rol, $id_modulo, $id_accion)";
                        $objeto->select($sqlInsert);
                    }
                }
                */

                // Opción B: Insert Masivo (Mucho más eficiente para la base de datos)
                $values = array();
                foreach ($_POST['permisos'] as $id_modulo => $acciones) {
                    foreach ($acciones as $id_accion => $valor) {
                        // Aseguramos que sean enteros para evitar inyecciones
                        $m = (int) $id_modulo;
                        $a = (int) $id_accion;
                        $values[] = "($id_rol, $m, $a)";
                    }
                }

                if (!empty($values)) {
                    // Unimos todos los valores con comas
                    $sqlValues = implode(', ', $values);

                    $sqlInsert = "INSERT INTO permisos (id_rol, id_modulo, id_accion) VALUES $sqlValues";
                    $objeto->select($sqlInsert);
                }
            }
        }
        // 3. Redireccionar al listado o mostrar mensaje de éxito
        $_SESSION['success'] = "Permisos actualizados correctamente.";
        recargarPermisos($id_rol);
        redirect(getUrl("GestionRoles", "GestionRoles", "listar"));
    }
}