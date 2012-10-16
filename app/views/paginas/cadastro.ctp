<?php

echo $javascript->link(array('ckeditor/ckeditor'));
echo $javascript->link(array('ckeditor/adapters/jquery'));
?>
<script type="text/javascript">
    $().ready(function() {

        var options = {
            extraPlugins : 'autogrow',
            autoGrow_maxHeight : 600,
            // Remove the Resize plugin as it does not make sense to use it in conjunction with the AutoGrow plugin.
            removePlugins : 'resize'
        }

        $('#PaginaDescConteudo').ckeditor(options);
    });
</script>
<?php

echo $this->Form->create('Pagina', array('url' => array('controller' => 'paginas', 'action' => 'cadastro')));

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Dados da página');
echo $this->Form->hidden('id_pagina');
echo $this->Form->input('nome_link', array('label' => 'Link'));
echo $this->Form->input('desc_titulo', array('label' => 'Título'));
echo $this->Html->div('', '', array('style' => 'clear: both;'));
echo $this->Form->input('desc_conteudo', array('type' => 'textarea', 'label' => 'Conteúdo', 'style' => 'width: 850px; height: 600px;'));
echo $this->Html->tag('/fieldset', null);

echo $this->Form->button('Fechar', array(
    'type' => 'button',
    'onClick' => "window.location.href = '" . $this->Html->url(array('controller' => 'paginas', 'action' => 'index')) . "';"
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