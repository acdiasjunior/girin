<?php

$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();

foreach ($plano_familiares as $plano_familiar) {
    $data['rows'][] = array(
        'id' => $plano_familiar['PlanoFamiliar']['id'],
        'cell' => array(
            $plano_familiar['PlanoFamiliar']['id'],
            str_pad($plano_familiar['PlanoFamiliar']['numero_plano_familiar'], 4, '0', STR_PAD_LEFT),
            $plano_familiar['Domicilio']['cod_domiciliar'],
            $plano_familiar['Domicilio']['Cras']['desc_cras'],
            round($plano_familiar['Indice']['vlr_idf'], 2),
            $plano_familiar['Usuario']['nome'],
            date('d/m/Y H:i:s', strtotime($plano_familiar['PlanoFamiliar']['created'])),
        )
    );
}

echo json_encode($data);