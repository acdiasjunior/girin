<?php

$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();

foreach($domicilios as $domicilio)
{
    $data['rows'][] = array(
        'id' => $domicilio['Domicilio']['codigo_domiciliar'],
        'cell' => array(
            $domicilio['Domicilio']['codigo_domiciliar'],
            $domicilio['Responsavel']['nome'],
            $domicilio['Domicilio']['logradouro'],
            $domicilio['Domicilio']['numero'],
            $domicilio['Bairro']['nome'],
            round($domicilio['Indice']['idf'],2),
            'R$ ' . number_format($domicilio['Domicilio']['valor_renda_familia'],2,',','.'),
            $domicilio['Domicilio']['quantidade_pessoas'],
            'R$ ' . number_format($domicilio['Domicilio']['renda_per_capita'],2,',','.'),
        )
    );
}

echo json_encode($data);