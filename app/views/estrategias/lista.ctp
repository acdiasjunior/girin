<?php

$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();

foreach ($estrategias as $estrategia) {
    $data['rows'][] = array(
        'id' => $estrategia['Estrategia']['id_estrategia'],
        'cell' => array(
            $estrategia['Estrategia']['id_estrategia'],
            $estrategia['Estrategia']['cod_estrategia'],
            $estrategia['Estrategia']['desc_estrategia'],
        )
    );
}

echo json_encode($data);