<?php
header('Content-Type: application/json');
echo json_encode(array(
    'registros' => $registros ? $registros : array(),
    'totalRegistros' => intval($totalRegistros),
    'totalPaginas' => intval($totalPaginas),
    'registroInicio' => intval($registroInicio),
    'registroFin' => intval($registroFin)
));
exit;
?>