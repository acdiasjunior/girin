<?php

$javascript->link(array('jquery.ui.datepicker-pt-BR', 'jquery.maskedinput-1.2.2.min', 'errormessage', 'autocomplete', 'consultacep'), false);

echo $this->Html->tag('h1', 'Cadastro de Usuários');

echo $this->Form->create('Usuario');

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Identificação');
echo $this->Form->input('id');
echo $this->Form->input('nome', array('label' => 'Nome completo'));
echo $this->Html->tag('/fieldset', null);

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Informações Login');
echo $this->Form->input('username', array('label' => 'Login'));
if(!isset($this->data['Usuario']))
    echo $this->Form->input('password', array('label' => 'Senha'));
echo $this->Html->tag('/fieldset', null);

if($this->Session->read('Auth.Usuario.id') == 1) {
    echo $this->Html->tag('fieldset', null);
    echo $this->Html->tag('legend', 'Acesso a Dados');
    echo $this->Form->input('Cras', array('multiple' => 'checkbox'));
    echo $this->Html->tag('/fieldset', null);
}

echo $this->Form->button('Fechar', array(
    'type' => 'button',
    'onClick' => "window.location.href = '" . $this->Html->url(array('controller' => 'usuarios', 'action' => 'index')) . "';"
    ));
echo $this->Form->button('Salvar', array('type' => 'submit'));
echo $this->Form->end();
