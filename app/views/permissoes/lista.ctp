<?php

$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();

foreach($permissoes as $permissao)
{
    $data['rows'][] = array(
        'id' => $permissao['Permissao']['id_permissao'],
        'cell' => array(
            $permissao['Permissao']['id_permissao'],
            $permissao['Permissao']['nome_controller'],
            $permissao['Permissao']['nome_action'],
            Permissao::permissaoAcesso($permissao['Permissao']['tp_acesso_administrador']),
            Permissao::permissaoAcesso($permissao['Permissao']['tp_acesso_tecnico_sas']),
            Permissao::permissaoAcesso($permissao['Permissao']['tp_acesso_coordenador_cras']),
            Permissao::permissaoAcesso($permissao['Permissao']['tp_acesso_tecnico_cras']),
        )
    );
}

echo json_encode($data);