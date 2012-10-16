<?php

$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();

foreach ($regioes as $regiao) {
    $data['rows'][] = array(
        'id' => $regiao['Regiao']['id_regiao'],
        'cell' => array(
            $regiao['Regiao']['id_regiao'],
            $regiao['Regiao']['desc_regiao'],
        )
    );
}

echo json_encode($data);