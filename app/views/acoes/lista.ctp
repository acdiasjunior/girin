<?php

$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();

foreach ($acoes as $acao) {
    $data['rows'][] = array(
        'id_acao' => $acao['Acao']['id_acao'],
        'cell' => array(
            $acao['Acao']['id_acao'],
            $acao['Acao']['cod_acao'],
            $acao['Acao']['desc_acao'],
        )
    );
}

echo json_encode($data);