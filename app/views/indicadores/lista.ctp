<?php

$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();

foreach ($indicadores as $indicador) {
    $data['rows'][] = array(
        'id' => $indicador['Indicador']['id_indicador'],
        'cell' => array(
            $indicador['Indicador']['id_indicador'],
            $indicador['Dimensao']['desc_dimensao_idf'],
            $indicador['Indicador']['cod_indicador'],
            $indicador['Indicador']['desc_indicador'],
            $indicador['Indicador']['desc_label_indicador'],
        )
    );
}

echo json_encode($data);