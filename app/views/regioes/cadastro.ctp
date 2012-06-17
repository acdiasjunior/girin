<?php

$javascript->link(array('jquery.ui.datepicker-pt-BR', 'jquery.maskedinput-1.2.2.min', 'errormessage', 'maskinput', 'datepicker'), false);

echo $this->Form->create('Regiao');

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Endereço');
echo $this->Form->input('id', array('label' => 'Cód.'));
echo $this->Form->input('descricao', array('label' => 'Descrição'));
echo $this->Html->tag('/fieldset', null);

echo $this->Form->button('Fechar', array(
    'type' => 'button',
    'onClick' => "window.location.href = '" . $this->Html->url(array('controller' => 'regioes', 'action' => 'index')) . "';"
));
if ($temAcessoEscrita) {
	echo $this->Form->button('Salvar', array('type' => 'submit'));
} else {
	?>
	<script type="text/javascript">
		$(document).ready(function () 
		{
			$('select').attr('disabled','disabled');
			$('input, textarea').attr('readonly','readonly').click(function() {
				return false;
			});
		});
	</script>
	<?php

}
echo $this->Form->end();