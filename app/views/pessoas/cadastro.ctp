<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));
?>
<script type="text/javascript">
    $(function() {
        $("#flex").flexigrid({
            url: '/prefeitura/pessoas/listaPessoasDomicilio/<?php echo $this->data['Pessoa']['cod_domiciliar'] ?>',
            dataType: 'json',
            colModel : [
                {display: 'NIS', name : 'Pessoa.cod_nis', width : 80, sortable : true, align: 'center', hide: false},
                {display: 'Nome', name : 'Pessoa.nome', width : 250, sortable : true, align: 'left'},
                {display: 'Idade', name : 'Pessoa.dt_nasc', width : 80, sortable : true, align: 'center'}
            ],
            searchitems : [
                {display: 'Nome', name : 'Pessoa.nome', isdefault: true}
            ],
            sortname: "Pessoa.nome",
            sortorder: "asc",
            usepager: true,
            useRp: true,
            rp: 10,
            rpOptions: [10,15,20,25,40],
            width: 700,
            height: 150,
            singleSelect: true,
            errormsg:'Erro de conexão',
            pagestat:'Exibindo de {from} a {to} de um total de {total} registros.',
            pagetext:'Página',
            outof:'de',
            findtext:'Busca',
            procmsg:'Processando, por favor aguarde ...',
            nomsg:'Nenhum item'
        });

        $('#flex').dblclick( function(){
            var id = $('.trSelected').find('td[abbr="Pessoa.cod_nis"]').text();
            if(id != '')
                $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'pessoas', 'action' => 'cadastro')); ?>/' + id);
        });

    });
</script><?php
$javascript->link(array('jquery.ui.datepicker-pt-BR', 'jquery.maskedinput-1.2.2.min', 'errormessage', 'maskinput', 'datepicker', 'autocomplete'), false);

echo $this->Form->create('Pessoa');

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Identificação');
echo $this->Form->input('Pessoa.cod_nis', array('label' => 'NIS', 'type' => 'text', 'class' => 'edit14'));
echo $this->Form->input('Pessoa.nome', array('label' => 'Nome', 'class' => 'edit40'));
echo $this->Form->hidden('Pessoa.cod_nis_responsavel');
if (!$this->data['Pessoa']['portador_deficiencia']) {
    echo $this->Form->input('Responsavel.nome', array('label' => 'Responsável Legal', 'class' => 'nomeResponsavelAutocomplete edit40'));
    echo $this->Form->input('Pessoa.tp_parentesco_responsavel', array('label' => 'Parentesco', 'type' => 'select', 'options' => Pessoa::grauParentesco()));
}
echo $this->Html->div('', '', array('style' => 'clear: both;'));
echo $this->Form->input('Pessoa.dt_nasc', array('label' => 'Data Nascimento', 'type' => 'text', 'class' => 'maskdata data'));
echo $this->Form->input('Pessoa.idade', array('label' => 'Idade', 'value' => $this->data['Pessoa']['idade'] . ' anos ' . $this->data['Pessoa']['meses'] . ' meses'));
echo $this->Form->input('Pessoa.sexo', array('label' => 'Sexo', 'type' => 'select', 'options' => Pessoa::sexo()));
echo $this->Html->tag('/fieldset', null);

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Documentação');
echo $this->Form->input('Pessoa.cpf', array('label' => 'CPF', 'class' => 'maskcpf edit14'));
echo $this->Form->input('Pessoa.teleitor_num', array('label' => 'Título Eleitor', 'class' => 'edit14'));
echo $this->Form->input('Pessoa.teleitor_zona', array('label' => 'Zona', 'class' => 'edit8'));
echo $this->Form->input('Pessoa.teleitor_secao', array('label' => 'Seção', 'type' => 'text'));
echo $this->Form->input('Pessoa.cod_inep', array('label' => 'Inep', 'type' => 'text'));
echo $this->Html->tag('/fieldset', null);

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Informações Pessoais');
echo $this->Form->input('Pessoa.est_civil', array('options' => Pessoa::estadoCivil(), 'label' => 'Estado Civil'));
echo $this->Form->input('Pessoa.raca', array('options' => Pessoa::cor(), 'label' => 'Cor'));
echo $this->Html->div('', '', array('style' => 'clear: both;'));
echo $this->Form->input('Pessoa.grau_instrucao', array('options' => Pessoa::grauInstrucao(), 'label' => 'Grau de instrução'));
echo $this->Form->input('Pessoa.serie_escolar', array('options' => Pessoa::serieEscolar(), 'label' => 'Série Escolar'));
echo $this->Form->input('Pessoa.tp_escola', array('options' => Pessoa::tipoEscola(), 'label' => 'Tipo de Escola'));
echo $this->Html->div('', '', array('style' => 'clear: both;'));
echo $this->Form->input('Pessoa.tp_trabalho', array('options' => Pessoa::tipoTrabalho(), 'label' => 'Tipo de Trabalho'));
echo $this->Form->input('Pessoa.desc_ocupacao', array('label' => 'Ocupação'));
echo $this->Form->input('Pessoa.vlr_remuneracao', array('label' => 'Remuneração Mensal'));
echo $this->Form->input('Pessoa.vlr_aposentadoria', array('label' => 'Valor Aposentadoria'));
echo $this->Form->input('Pessoa.vlr_pensao', array('label' => 'Valor Pensão'));
echo $this->Form->input('Pessoa.vlr_seguro_desemprego', array('label' => 'Seguro desemprego'));
echo $this->Form->input('Pessoa.vlr_outras_rendas', array('label' => 'Valor Outras Rendas'));
echo $this->Form->input('Pessoa.vlr_beneficio', array('label' => 'Valor Benefício'));
echo $this->Html->tag('/fieldset', null);

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Domicílio');
echo $this->Form->input('Domicilio.cod_domiciliar', array('label' => 'Cód. Domiciliar'));
echo $this->Form->input('Domicilio.end_cep', array('class' => 'maskcep', 'label' => 'Cep'));
echo $this->Form->input('Domicilio.end_tipo', array('label' => 'Tipo'));
echo $this->Form->input('Domicilio.end_logradouro', array('label' => 'Logradouro'));
echo $this->Form->input('Domicilio.end_num', array('label' => 'Número'));
echo $this->Form->input('Domicilio.end_compl', array('label' => 'Complemento'));
echo $this->Form->input('Domicilio.id_bairro', array('type' => 'select', 'options' => $bairros, 'label' => 'Bairro'));
echo $this->Form->input('Domicilio.end_cidade', array('label' => 'Cidade'));
echo $this->Form->input('Domicilio.end_estado', array('label' => 'UF', 'size' => '2'));
echo $this->Html->tag('/fieldset', null);

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Complementares');
echo $this->Form->input('Pessoa.qtd_mes_gestacao', array('label' => 'Mês de Gestação'));
echo $this->Form->input('Pessoa.amamentando', array('label' => 'Amamentando'));
echo $this->Form->input('Pessoa.esposa_companheiro', array('label' => 'Presença de esposa ou companheiro?'));
echo $this->Form->input('Pessoa.portador_deficiencia', array('label' => 'Portador deficiência?'));
if ($this->data['Pessoa']['portador_deficiencia']) {
    echo $this->Form->input('Pessoa.cegueira', array('label' => 'Cegueira'));
    echo $this->Form->input('Pessoa.surdez', array('label' => 'Surdez'));
    echo $this->Form->input('Pessoa.mudez', array('label' => 'Mudez'));
    echo $this->Form->input('Pessoa.deficiencia_mental', array('label' => 'Deficiência Mental'));
    echo $this->Form->input('Pessoa.deficiencia_fisica', array('label' => 'Deficiência Física'));
    echo $this->Form->input('Pessoa.outra_deficiencia', array('label' => 'Outra Deficiência'));
}
echo $this->Html->tag('/fieldset', null);

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Observações');
echo $this->Html->div('', '', array('style' => 'clear: both;'));
echo $this->Form->input('observacao', array('label' => 'Observações', 'rows' => '5', 'cols' => '70'));
echo $this->Html->tag('/fieldset', null);

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Informações do Registro');
echo $this->Form->input('entrevistador', array('label' => 'Entrevistador', 'class' => 'edit40'));
echo $this->Html->div('', '', array('style' => 'clear: both;'));
echo $this->Form->input('data_pequisa', array('label' => 'Data da Pesquisa', 'type' => 'text', 'class' => 'maskdata data'));
echo $this->Form->input('data_inclusao', array('label' => 'Data da Inclusão', 'type' => 'text', 'class' => 'maskdata data'));
echo $this->Form->input('data_atualizacao', array('label' => 'Data da Atualização', 'type' => 'text', 'class' => 'maskdata data'));
echo $this->Html->tag('/fieldset', null);

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Serviços Associados');
echo $this->Form->input('Servico', array('multiple' => 'checkbox', 'label' => ''));
echo $this->Html->tag('/fieldset', null);

echo $this->Form->button('Fechar', array(
    'type' => 'button',
    'onClick' => "window.location.href = '" . $this->Html->url(array('controller' => 'pessoas', 'action' => 'index')) . "';"
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

echo $this->Html->tag('div', '', array('style' => 'height: 20px;'));
echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Pessoa - Membros');
echo '<table id="flex" style="display: none"></table>';
echo $this->Html->tag('/fieldset', null);