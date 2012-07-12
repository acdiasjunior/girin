<?php

$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();

foreach ($cras as $cra) {
    $data['rows'][] = array(
        'id_cras' => $cra['Cras']['id_cras'],
        'cell' => array(
            $cra['Cras']['id_cras'],
            $cra['Cras']['desc_cras'],
            $cra['Cras']['end_logradouro'],
            $cra['Cras']['end_num'],
            $cra['Bairro']['nome_bairro'],
            $cra['Cras']['end_cidade'],
            $cra['Cras']['end_estado'],
            $cra['Regiao']['descricao'],
        )
    );
}

echo json_encode($data);