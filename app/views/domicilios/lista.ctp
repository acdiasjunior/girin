<?php

$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();

foreach($domicilios as $domicilio)
{
    $data['rows'][] = array(
        'id' => $domicilio['Domicilio']['cod_domiciliar'],
        'cell' => array(
            $domicilio['Domicilio']['cod_domiciliar'],
            $domicilio['Responsavel']['nome'],
            $domicilio['Domicilio']['end_logradouro'],
            $domicilio['Domicilio']['end_num'],
            $domicilio['Bairro']['nome_bairro'],
            round($domicilio['Indice']['idf'],2),
            'R$ ' . number_format($domicilio['Domicilio']['vlr_renda_familia'],2,',','.'),
            $domicilio['Domicilio']['qtd_pessoa'],
            'R$ ' . number_format($domicilio['Domicilio']['vlr_renda_per_capita'],2,',','.'),
        )
    );
}

echo json_encode($data);