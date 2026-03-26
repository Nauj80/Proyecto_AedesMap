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
        $sql = "SELECT * FROM roles WHERE id_estado_rol = 1 AND nombre ILIKE '%$buscar%' ";
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

        // Incluir la vista directamente (sin output buffering, ya que no está disponible en 5.2.5)
        include '../view/gestionRoles/EditarPermisos.php';
    }
}