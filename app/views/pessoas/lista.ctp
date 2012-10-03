<?php

$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();

foreach ($pessoas as $pessoa) {
    $data['rows'][] = array(
        'id' => $pessoa['Pessoa']['cod_nis'],
        'cell' => array(
            $pessoa['Pessoa']['cod_nis'],
            $pessoa['Pessoa']['nome'],
            $pessoa['Pessoa']['idade'] . 'a ' . $pessoa['Pessoa']['meses'] . 'm',
            $pessoa['Responsavel']['nome'],
            $pessoa['Responsavel']['cod_nis'],
        )
    );
}

echo json_encode($data);