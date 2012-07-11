<h3>Gerar Prontuário - Filtro</h3>
<?php
echo $this->Form->create('Prontuario', array('url' => array('controller' => $this->params['controller'], 'action' => $this->params['action'])));

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Selecione o filtro para busca');
echo $this->Form->input('filtro', array('options' => array('regiao_id' => 'Região', 'cras_id' => 'Cras', 'id_bairro' => 'Bairro'), 'empty' => 'Selecione o tipo de filtro'));
echo $this->Form->input('domicilio_regiao_id', array('options' => $regioes, 'empty' => 'Selecione a Região', 'class' => 'filtro regiao_id'));
echo $this->Form->input('domicilio_cras_id', array('options' => $cras, 'empty' => 'Selecione o CRAS', 'class' => 'filtro cras_id'));
echo $this->Form->input('domicilio_id_bairro', array('options' => $bairros, 'empty' => 'Selecione o bairro', 'class' => 'filtro id_bairro'));
echo $this->Html->div('', '', array('style' => 'clear: both;'));
echo $this->Form->input('domicilio_codigo_domiciliar', array('label' => 'Código Domicíliar'));
echo $this->Form->input('responsavel_nis', array('label' => 'NIS Responsável Legal'));
echo $this->Form->input('responsavel_cpf', array('label' => 'CPF Responsável Legal'));
echo $this->Html->div('', '', array('style' => 'clear: both;'));
echo $this->Form->input('responsavel_nome', array('label' => 'Nome Responsável Legal', 'class' => 'edit30'));
echo $this->Html->div('', '', array('style' => 'clear: both;'));
echo $this->Form->input('domicilio_idf', array('label' => 'IDF'));
echo $this->Form->input('tipo_busca', array('label' => 'Tipo de busca', 'options' => array('menor' => 'Menor que', 'exatamente' => 'Exatamente', 'maior' => 'Maior que')));
echo $this->Html->tag('/fieldset', null);

echo $this->Form->end();
?>
<span>Selecione os filtros para os domícilios.</span>
<script type="text/javascript">

    $('.filtro').parent().hide();
    if($('#ProntuarioFiltro').val() != '')
        $('.' + $('#ProntuarioFiltro').val()).parent().show();
        
    $('#ProntuarioFiltro').change(function(){
        $('.filtro').val('').parent().hide();
        $('.' + $(this).val()).parent().show();
    });
        
</script>