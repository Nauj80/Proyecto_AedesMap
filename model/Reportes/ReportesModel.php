<?php
include_once '../model/MasterModel.php';

class ReportesModel extends MasterModel
{
    public function selectWithParams($sql, $params = array())
    {
        if (empty($params)) {
            return pg_query($this->getConnect(), $sql);
        } else {
            return pg_query_params($this->getConnect(), $sql, $params);
        }
    }
}
