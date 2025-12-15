<?php

include_once '../model/Mastermodel.php';

class GestionUsuariosModel extends MasterModel
{
    private $table = 'usuarios';

    public function getAll()
    {
        // CAMBIO 1: Concatenación para mayor seguridad en 5.2.5 (en lugar de {$this->table})
        $sql = "SELECT u.id_usuario, u.documento, u.nombre, u.apellido, u.telefono, u.correo, u.id_rol, r.nombre AS rol, u.id_estado_usuario, e.nombre AS estado FROM " . $this->table . " u LEFT JOIN roles r ON u.id_rol = r.id_rol LEFT JOIN estado_usuario e ON u.id_estado_usuario = e.id_estado_usuario ORDER BY u.id_usuario DESC";
        return $this->select($sql);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE id_usuario = $1";
        // CAMBIO 2: Sintaxis de array largo para pg_query_params
        return pg_query_params($this->getConnect(), $sql, array($id));
    }

    public function getByDocumento($documento)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE documento = $1";
        return pg_query_params($this->getConnect(), $sql, array($documento));
    }

    public function getByCorreo($correo)
    {
        $sql = "SELECT * FROM " . $this->table . " WHERE correo = $1";
        return pg_query_params($this->getConnect(), $sql, array($correo));
    }

    public function create($data)
    {
        $sql = "INSERT INTO " . $this->table . " (documento, nombre, apellido, telefono, correo, contrasena, id_rol, id_estado_usuario) VALUES ($1,$2,$3,$4,$5,$6,$7,$8)";
        
        // CAMBIO 3: Sintaxis de array largo
        $params = array(
            $data['documento'],
            $data['nombre'],
            $data['apellido'],
            $data['telefono'],
            $data['correo'],
            $data['contrasena'],
            // CAMBIO 4: Usar isset() para verificar y asignar valores
            isset($data['id_rol']) ? $data['id_rol'] : null,
            isset($data['id_estado_usuario']) ? $data['id_estado_usuario'] : 1
        );

        return pg_query_params($this->getConnect(), $sql, $params);
    }

    public function updateById($id, $data)
    {
        // CAMBIO 5: Sintaxis de array largo para la inicialización
        $fields = array();
        $params = array();
        $i = 1;

        foreach ($data as $key => $value) {
            // Este foreach usa la sintaxis estándar y es compatible
            $fields[] = "$key = $$i";
            $params[] = $value;
            $i++;
        }

        $params[] = $id; // last param for WHERE
        $sql = "UPDATE " . $this->table . " SET " . implode(', ', $fields) . " WHERE id_usuario = $$i";

        return pg_query_params($this->getConnect(), $sql, $params);
    }

    public function setEstado($id, $estado)
    {
        $sql = "UPDATE " . $this->table . " SET id_estado_usuario = $1 WHERE id_usuario = $2";
        return pg_query_params($this->getConnect(), $sql, array($estado, $id));
    }

    public function delete($id)
    {
        $sql = "DELETE FROM " . $this->table . " WHERE id_usuario = $1";
        return pg_query_params($this->getConnect(), $sql, array($id));
    }
}

?>