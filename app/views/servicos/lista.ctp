<?php

$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();

foreach ($servicos as $servico) {
    $data['rows'][] = array(
        'id' => $servico['Servico']['id_servico'],
        'cell' => array(
            $servico['Servico']['id_servico'],
            Servico::tipoServico($servico['Servico']['tp_servico']),
            $servico['Servico']['nome_servico'],
            $servico['Servico']['faixa_etaria'],
            $servico['Servico']['qtd_capacidade'],
        )
    );
}

echo json_encode($data);