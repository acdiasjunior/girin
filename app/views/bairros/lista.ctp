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
            $bairro['Cras']['descricao'],
            $bairro['Regiao']['descricao'],
            $bairro['Bairro']['domicilio_count'],
        )
    );
}

echo json_encode($data);