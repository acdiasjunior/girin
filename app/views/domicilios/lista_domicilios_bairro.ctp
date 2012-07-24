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
            $domicilio['Domicilio']['qtd_pessoa'],
        )
    );
}

echo json_encode($data);