<?php

$data->total = count($usuarios);
$i = 0;

foreach ($usuarios as $usuario) {
    $data->rows[$i] = array(
        'cell' => array(
            $usuario['Usuario']['id_usuario'],
            $usuario['Usuario']['nome_usuario'],
            $usuario['Usuario']['username'],
            Usuario::grupoUsuario($usuario['Usuario']['id_grupo']),
        )
    );
    $i++;
}

echo json_encode($data);