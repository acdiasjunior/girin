<?php

$javascript->link(array('jquery.ui.datepicker-pt-BR', 'jquery.maskedinput-1.2.2.min', 'errormessage', 'maskinput', 'datepicker'), false);

echo $this->Form->create('Domicilio', array('type' => 'file'));

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Arquivo CSV');
echo $this->Form->file('Domicilio.arquivo');
echo $this->Html->tag('/fieldset', null);

echo $this->Form->end('Importar Registros');