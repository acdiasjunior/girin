<?php

echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));
echo $javascript->link(array('jquery.ui.datepicker-pt-BR', 'jquery.maskedinput-1.2.2.min', 'errormessage', 'maskinput', 'datepicker', 'autocomplete'));

$simples = $this->data['Permissao']['tp_acesso_simples'];

echo $this->Form->create('Permissao');

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Permissões da Tela');
echo $this->Form->hidden('Permissao.id_permissao');
echo $this->Form->input('Permissao.nome_controller', array('label' => 'Controlador', 'readonly' => 'readonly'));
echo $this->Form->input('Permissao.nome_action', array('label' => 'Ação', 'readonly' => 'readonly'));
echo $this->Form->input('Permissao.tp_acesso_administrador', array('options' => $simples ? Permissao::permissaoAcessoSimples() : Permissao::permissaoAcesso(),'label' => 'Administrador'));
echo $this->Form->input('Permissao.tp_acesso_tecnico_sas', array('options' => $simples ? Permissao::permissaoAcessoSimples() : Permissao::permissaoAcesso(),'label' => 'Técnico SAS'));
echo $this->Form->input('Permissao.tp_acesso_coordenador_cras', array('options' => $simples ? Permissao::permissaoAcessoSimples() : Permissao::permissaoAcesso(),'label' => 'Coordenador CRAS'));
echo $this->Form->input('Permissao.tp_acesso_tecnico_cras', array('options' => $simples ? Permissao::permissaoAcessoSimples() : Permissao::permissaoAcesso(),'label' => 'Técnico CRAS'));
echo $this->Html->tag('/fieldset', null);

echo $this->Form->button('Fechar', array(
    'type' => 'button',
    'onClick' => "window.location.href = '" . $this->Html->url(array('controller' => 'permissoes', 'action' => 'index')) . "';"
));
if ($temAcessoEscrita)
	echo $this->Form->button('Salvar', array('type' => 'submit'));
echo $this->Form->end();
