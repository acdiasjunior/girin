<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));
?>
<script type="text/javascript">
    $(function() {        
        $("#flex").flexigrid({
            url: '/prefeitura/pessoas/listaPessoasDomicilio/<?php echo $this->data['Domicilio']['codigo_domiciliar'] ?>',
            dataType: 'json',
            colModel : [
                {display: 'NIS', name : 'Pessoa.nis', width : 80, sortable : true, align: 'center', hide: false},
                {display: 'Nome', name : 'Pessoa.nome', width : 250, sortable : true, align: 'left'},
                {display: 'Idade', name : 'Pessoa.idade', width : 80, sortable : true, align: 'center'}
            ],
            buttons : [
                {name: 'Incluir', bclass: 'add', onpress : actions},
                {separator: true},
                {name: 'Excluir', bclass: 'delete', onpress : actions},
                {separator: true}
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
    
        function actions(com, grid) {
            var id = $('.trSelected', grid).find('td[abbr="Pessoa.nis"]').text();
            var nome = $('.trSelected', grid).find('td[abbr="Pessoa.nome"]').text();
            switch(com)
            {
                case "Incluir":
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'pessoas', 'action' => 'cadastro')); ?>');
                    break;
                case "Excluir":
                    if(id != '')
                    {
                        if(confirm('Deseja realmente excluir?\nCliente: ' + nome))
                            $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'pessoas', 'action' => 'excluir')); ?>/' + id);
                    }
                    else
                        alert('Selecione um registro primeiro!');
                    break;
                }
            }
        });
</script>
<?php
$javascript->link(array('jquery.ui.datepicker-pt-BR', 'jquery.maskedinput-1.2.2.min', 'errormessage', 'maskinput', 'datepicker', 'autocomplete', 'consultacep'), false);

echo $this->Form->create('Domicilio');

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Endereço');
echo $this->Form->input('Domicilio.codigo_domiciliar', array('type' => 'text', 'label' => 'Cód. Domiciliar'));
echo $this->Form->input('Domicilio.cep', array('class' => 'maskcep', 'label' => 'Cep'));
echo $this->Form->input('Domicilio.tipo_logradouro', array('label' => 'Tipo'));
echo $this->Form->input('Domicilio.logradouro', array('label' => 'Logradouro'));
echo $this->Form->input('Domicilio.numero', array('label' => 'Número'));
echo $this->Form->input('Domicilio.complemento', array('label' => 'Complemento'));
echo $this->Form->input('Domicilio.regiao_id', array('label' => 'Região'));
echo $this->Form->input('Domicilio.cras_id', array('label' => 'CRAS'));
echo $this->Form->input('Domicilio.bairro_id', array('label' => 'Bairro'));
echo $this->Form->input('Domicilio.cidade', array('label' => 'Cidade'));
echo $this->Form->input('Domicilio.uf', array('label' => 'UF', 'size' => '2'));
echo $this->Html->tag('/fieldset', null);

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Informações do Domicílio');
echo $this->Form->input('Domicilio.tipo_localidade', array('options' => Domicilio::tipoLocalidade(),'label' => 'Tipo de Localidade'));
echo $this->Form->input('Domicilio.situacao_domicilio', array('options' => Domicilio::situacaoDomicilio(),'label' => 'Situação do Domicílio'));
echo $this->Form->input('Domicilio.tipo_domicilio', array('options' => Domicilio::tipoDomicilio(),'label' => 'Tipo de Domicílio'));
echo $this->Form->input('Domicilio.tipo_construcao', array('options' => Domicilio::tipoConstrucao(),'label' => 'Tipo de Construção'));
echo $this->Form->input('Domicilio.tipo_abastecimento', array('options' => Domicilio::tipoAbastecimentoAgua(),'label' => 'Tipo de abastecimento de água'));
echo $this->Form->input('Domicilio.tratamento_agua', array('options' => Domicilio::tratamentoAgua(),'label' => 'Tratamento da água'));
echo $this->Form->input('Domicilio.tipo_iluminacao', array('options' => Domicilio::tipoIluminacao(),'label' => 'Tipo de iluminação'));
echo $this->Form->input('Domicilio.escoamento_sanitario', array('options' => Domicilio::escoamentoSanitario(),'label' => 'Escoamento Sanitário'));
echo $this->Form->input('Domicilio.destino_lixo', array('options' => Domicilio::destinoLixo(),'label' => 'Destino do Lixo'));
echo $this->Form->input('Domicilio.bolsa_familia', array('options' => Domicilio::bolsaFamilia(),'label' => 'Bolsa Família'));
echo $this->Form->input('Domicilio.comodos', array('label' => 'Cômodos', 'class' => 'edit4'));
echo $this->Html->tag('/fieldset', null);

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Informações de Contato');
echo $this->Form->hidden('Domicilio.responsavel_id');
echo $this->Form->input('Responsavel.nome', array('label' => 'Pessoa Responsável', 'class' => 'nomesAutocomplete edit40'));
echo $this->Html->div('input text', $this->Form->button('?', array('type' => 'button', 'onClick' => "$('.nomesAutocomplete').autocomplete({minLength: 0}).autocomplete('search', '').autocomplete({minLength: 2});")), array('style' => 'padding: 15px 2px 5px;'));
echo $this->Html->div('', '', array('style' => 'clear: both;'));
echo $this->Form->input('Domicilio.ddd', array('label' => 'DDD'));
echo $this->Form->input('Domicilio.telefone', array('label' => 'Telefone'));
echo $this->Html->tag('/fieldset', null);

echo $this->Form->button('Fechar', array(
    'type' => 'button',
    'onClick' => "window.location.href = '" . $this->Html->url(array('controller' => 'domicilios', 'action' => 'index')) . "';"
));
echo $this->Form->button('Salvar', array('type' => 'submit'));
echo $this->Form->end();

if ($this->data) {
    echo $this->Html->tag('div', '', array('style' => 'height: 20px;'));
    echo $this->Html->tag('fieldset', null);
    echo $this->Html->tag('legend', 'Domicílio - Pessoas');
    echo '<table id="flex" style="display: none"></table>';
    echo $this->Html->tag('/fieldset', null);
}