<?php
/*
 *
 */
?><script type="text/javascript">

    $(function() {
        
        $('.filtro').parent().hide();
        if($('#RelatorioFiltro').val() != '')
            $('.' + $('#RelatorioFiltro').val()).parent().show();
        
        $('#RelatorioFiltro').change(function(){
            $('.filtro').val('').parent().hide();
            $('.' + $(this).val()).parent().show();
        });
    });

</script>
<?php
echo $this->Form->create('Relatorio', array('url' => array('controller' => $this->params['controller'], 'action' => $this->params['action'])));

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Selecione o filtro para busca');
echo $this->Form->input('filtro', array('options' => array('regiao_id' => 'Região', 'id_cras' => 'Cras', 'id_bairro' => 'Bairro'), 'empty' => 'Selecione o tipo de filtro'));
echo $this->Form->input('regiao_id', array('options' => $regioes, 'empty' => 'Selecione a Região', 'class' => 'filtro regiao_id'));
echo $this->Form->input('id_cras', array('options' => $cras, 'empty' => 'Selecione o CRAS', 'class' => 'filtro id_cras'));
echo $this->Form->input('id_bairro', array('options' => $bairros, 'empty' => 'Selecione o bairro', 'class' => 'filtro id_bairro'));
echo $this->Html->tag('/fieldset', null);

echo $this->Form->end('Filtrar');