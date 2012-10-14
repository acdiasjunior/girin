<?php

$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();

foreach ($bairros as $bairro) {
    $data['rows'][] = array(
        'id_bairro' => $bairro['Bairro']['id_bairro'],
        'cell' => array(
            $bairro['Bairro']['id_bairro'],
            $bairro['Bairro']['nome_bairro'],
            $bairro['Cras']['desc_cras'],
            $bairro['Regiao']['desc_regiao'],
            $bairro['Bairro']['domicilio_count'],
        )
    );
}

echo json_encode($data);