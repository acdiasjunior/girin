<?php

$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();

foreach ($paginas as $pagina) {
    $data['rows'][] = array(
        'id' => $pagina['Pagina']['id_pagina'],
        'cell' => array(
            $pagina['Pagina']['id_pagina'],
            $pagina['Pagina']['nome_link'],
            $pagina['Pagina']['desc_titulo'],
        )
    );
}

echo json_encode($data);