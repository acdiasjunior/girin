<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));
?>
<script type="text/javascript">
    $(function() {
        $("#flex").flexigrid({
            url: '/prefeitura/pessoas/listaPessoasDomicilio/<?php echo $this->data['Domicilio']['cod_domiciliar'] ?>',
            dataType: 'json',
            colModel : [
                {display: 'NIS', name : 'Pessoa.cod_nis', width : 80, sortable : true, align: 'center', hide: false},
                {display: 'Nome', name : 'Pessoa.nome', width : 250, sortable : true, align: 'left'},
                {display: 'Idade', name : 'Pessoa.idade', width : 80, sortable : true, align: 'center'}
            ],
            searchitems : [
                {display: 'Nome', name : 'Pessoa.nome', isdefault: true}
            ],
            sortname: "Pessoa.nome",
            sortorder: "asc",
            usepager: true,
            useRp: true,
            rp: 15,
            rpOptions: [10,15,20,25,40],
            //title: 'Domicílio - Pessoas',
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
            var id = $('.trSelected').find('td[abbr="Pessoa.nis"]').text();
            if(id != '')
                $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'pessoas', 'action' => 'cadastro')); ?>/' + id);
        }).disableSelection();
    });
</script>
<?php
$javascript->link(array('jquery.ui.datepicker-pt-BR', 'jquery.maskedinput-1.2.2.min', 'errormessage', 'maskinput', 'datepicker', 'autocomplete', 'consultacep'), false);

echo $this->Form->create('Domicilio');

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Endereço');
echo $this->Form->input('Domicilio.cod_domiciliar', array('type' => 'text', 'label' => 'Cód. Domiciliar'));
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
echo $this->Html->tag('legend', 'Informações do Domicílio');
echo $this->Form->input('Domicilio.tp_localidade', array('options' => Domicilio::tipoLocalidade(), 'label' => 'Tipo de Localidade'));
echo $this->Form->input('Domicilio.tp_situacao_domicilio', array('options' => Domicilio::situacaoDomicilio(), 'label' => 'Situação do Domicílio'));
echo $this->Form->input('Domicilio.tp_domicilio', array('options' => Domicilio::tipoDomicilio(), 'label' => 'Tipo de Domicílio'));
echo $this->Form->input('Domicilio.tp_construcao', array('options' => Domicilio::tipoConstrucao(), 'label' => 'Tipo de Construção'));
echo $this->Form->input('Domicilio.tp_abastecimento', array('options' => Domicilio::tipoAbastecimentoAgua(), 'label' => 'Tipo de abastecimento de água'));
echo $this->Form->input('Domicilio.tp_tratamento_agua', array('options' => Domicilio::tratamentoAgua(), 'label' => 'Tratamento da água'));
echo $this->Form->input('Domicilio.tp_iluminacao', array('options' => Domicilio::tipoIluminacao(), 'label' => 'Tipo de iluminação'));
echo $this->Form->input('Domicilio.tp_escoamento_sanitario', array('options' => Domicilio::escoamentoSanitario(), 'label' => 'Escoamento Sanitário'));
echo $this->Form->input('Domicilio.tp_destino_lixo', array('options' => Domicilio::destinoLixo(), 'label' => 'Destino do Lixo'));
echo $this->Form->input('Domicilio.st_bolsa_familia', array('options' => Domicilio::bolsaFamilia(), 'label' => 'Bolsa Família'));
echo $this->Form->input('Domicilio.qtd_comodo', array('label' => 'Cômodos', 'class' => 'edit4'));
echo $this->Html->tag('/fieldset', null);

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Informações de Contato');
echo $this->Form->hidden('Domicilio.nis_responsavel');
echo $this->Form->input('Responsavel.nome', array('label' => 'Pessoa Responsável', 'class' => 'nomesAutocomplete edit40'));
//echo $this->Html->div('input text', $this->Form->button('?', array('type' => 'button', 'onClick' => "$('.nomesAutocomplete').autocomplete({minLength: 0}).autocomplete('search', '').autocomplete({minLength: 2});")), array('style' => 'padding: 15px 2px 5px;'));
echo $this->Html->div('', '', array('style' => 'clear: both;'));
echo $this->Form->input('Domicilio.tel_ddd', array('label' => 'DDD'));
echo $this->Form->input('Domicilio.tel_num', array('label' => 'Telefone'));
echo $this->Html->tag('/fieldset', null);

echo $this->Form->button('Fechar', array(
    'type' => 'button',
    'onClick' => "window.location.href = '" . $this->Html->url(array('controller' => 'domicilios', 'action' => 'index')) . "';"
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

echo $this->Html->tag('div', '', array('style' => 'height: 20px;'));
echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Domicílio - Pessoas');
echo '<table id="flex" style="display: none"></table>';
echo $this->Html->tag('/fieldset', null);