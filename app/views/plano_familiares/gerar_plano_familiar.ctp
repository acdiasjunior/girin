<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * * região, cras ou bairro
 * codigo domiciliar
 * responsavel legal
 * cpf
 * idf familiar (opções: exatamente, até, entre ou acima) > exibir balão com autopreenchimento com níveis D1 a D5.
 */
?>
<script type="text/javascript">

    $(function() {

        $('.filtro').parent().hide();
        if($('#PlanoFamiliarFiltro').val() != '')
            $('.' + $('#PlanoFamiliarFiltro').val()).parent().show();

        $('#PlanoFamiliarFiltro').change(function(){
            $('.filtro').val('').parent().hide();
            $('.' + $(this).val()).parent().show();
        });
    });

</script>
<?php

echo $this->Form->create('PlanoFamiliar', array('url' => array('controller' => $this->params['controller'], 'action' => $this->params['action'])));

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Selecione o filtro para busca');
echo $this->Form->input('filtro', array('options' => array('id_regiao' => 'Região', 'id_cras' => 'Cras', 'id_bairro' => 'Bairro'), 'empty' => 'Selecione o tipo de filtro'));
echo $this->Form->input('id_regiao', array('options' => $regioes, 'empty' => 'Selecione a Região', 'class' => 'filtro id_regiao'));
echo $this->Form->input('id_cras', array('options' => $cras, 'empty' => 'Selecione o CRAS', 'class' => 'filtro id_cras'));
echo $this->Form->input('id_bairro', array('options' => $bairros, 'empty' => 'Selecione o bairro', 'class' => 'filtro id_bairro'));
echo $this->Html->div('', '', array('style' => 'clear: both;'));
echo $this->Form->input('cod_domiciliar', array('label' => 'Código Domicíliar'));
echo $this->Form->input('cod_nis_responsavel', array('label' => 'NIS Responsável Legal'));
echo $this->Form->input('cpf_responsavel', array('label' => 'CPF Responsável Legal'));
echo $this->Html->div('', '', array('style' => 'clear: both;'));
echo $this->Form->input('vlr_idf', array('label' => 'vlr_idf'));
echo $this->Form->input('tipo', array('label' => 'Tipo de busca', 'options' => array('<=' => 'Menor ou Igual que', '=' => 'Exatamente', '>' => 'Acima de')));
echo $this->Html->tag('/fieldset', null);

echo $this->Form->end('Filtrar');