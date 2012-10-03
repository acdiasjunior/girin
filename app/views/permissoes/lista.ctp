<?php

$data = array();
$data['page'] = $page;
$data['total'] = $total;
$data['rows'] = array();

foreach ($permissoes as $permissao) {
    $data['rows'][] = array(
        'id' => $permissao['Permissao']['id_permissao'],
        'cell' => array(
            $permissao['Permissao']['id_permissao'],
            $permissao['Permissao']['nome_controller'],
            $permissao['Permissao']['nome_action'],
            $permissao['Permissao']['tp_acesso_simples'] ?
                Permissao::permissaoAcessoSimples($permissao['Permissao']['tp_acesso_administrador']) :
                Permissao::permissaoAcesso($permissao['Permissao']['tp_acesso_administrador']),
            $permissao['Permissao']['tp_acesso_simples'] ?
                Permissao::permissaoAcessoSimples($permissao['Permissao']['tp_acesso_tecnico_sas']) :
                Permissao::permissaoAcesso($permissao['Permissao']['tp_acesso_tecnico_sas']),
            $permissao['Permissao']['tp_acesso_simples'] ?
                Permissao::permissaoAcessoSimples($permissao['Permissao']['tp_acesso_coordenador_cras']) :
                Permissao::permissaoAcesso($permissao['Permissao']['tp_acesso_coordenador_cras']),
            $permissao['Permissao']['tp_acesso_simples'] ?
                Permissao::permissaoAcessoSimples($permissao['Permissao']['tp_acesso_tecnico_cras']) :
                Permissao::permissaoAcesso($permissao['Permissao']['tp_acesso_tecnico_cras']),
        )
    );
}

echo json_encode($data);