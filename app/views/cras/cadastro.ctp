<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));
?>
<script type="text/javascript">
    $(function() {
        $("#flex").flexigrid({
            url: '/prefeitura/bairros/listaBairrosCras/<?php echo $this->data['Cras']['id_cras'] ?>',
            dataType: 'json',
            colModel : [
                {display: 'Cód.', name : 'Bairro.id_bairro', width : 80, sortable : true, align: 'center', hide: false},
                {display: 'Nome', name : 'Bairro.nome_bairro', width : 350, sortable : true, align: 'left'},
                {display: 'Domicílios', name : 'Bairro.domicilio_count', width : 40, sortable : true, align: 'center'},
            ],
            buttons : [
                {name: 'Incluir', bclass: 'add', onpress : actions},
                {separator: true},
                {name: 'Excluir', bclass: 'delete', onpress : actions},
                {separator: true}
            ],
            searchitems : [
                {display: 'Nome', name : 'Bairro.nome_bairro', isdefault: true}
            ],
            sortname: "Bairro.nome_bairro",
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
            var id = $('.trSelected').find('td[abbr="Bairro.id_bairro"]').text();
            if(id != '')
                $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'bairros', 'action' => 'cadastro')); ?>/' + id);
        }).disableSelection();

        function actions(com, grid) {
            var id = $('.trSelected', grid).find('td[abbr="Bairro.id_bairro"]').text();
            var nome = $('.trSelected', grid).find('td[abbr="Bairro.nome_bairro"]').text();
            switch(com)
            {
                case "Incluir":
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'bairros', 'action' => 'cadastro')); ?>');
                    break;
                case "Excluir":
                    if(id != '')
                    {
                        if(confirm('Deseja realmente excluir?\nBairro: ' + nome))
                            $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'bairros', 'action' => 'excluir')); ?>/' + id);
                    }
                    else
                        alert('Selecione um registro primeiro!');
                    break;
                }
            }
        });
</script>
<?php
$javascript->link(array('jquery.ui.datepicker-pt-BR', 'jquery.maskedinput-1.2.2.min', 'errormessage', 'maskinput', 'datepicker'), false);

echo $this->Form->create('Cras');

echo $this->Html->tag('fieldset', null);
echo $this->Html->tag('legend', 'Endereço');
echo $this->Form->input('Cras.id_cras', array('label' => 'Cód.'));
echo $this->Form->input('Cras.desc_cras', array('label' => 'Descrição'));
echo $this->Form->input('Cras.end_tipo', array('label' => 'Tipo'));
echo $this->Form->input('Cras.end_logradouro', array('label' => 'Logradouro'));
echo $this->Form->input('Cras.end_num', array('label' => 'Número'));
echo $this->Form->input('Cras.end_compl', array('label' => 'Complemento'));
echo $this->Form->input('Cras.id_bairro', array('type' => 'select', 'options' => $bairros, 'label' => 'Bairro'));
echo $this->Form->input('Cras.id_regiao', array('type' => 'select', 'options' => $regioes, 'label' => 'Região'));
echo $this->Form->input('Cras.end_cidade', array('label' => 'Cidade'));
echo $this->Form->input('Cras.end_estado', array('label' => 'UF', 'size' => '2'));
echo $this->Form->input('Cras.tel_num', array('label' => 'Telefone'));
echo $this->Html->tag('/fieldset', null);

echo $this->Form->button('Fechar', array(
    'type' => 'button',
    'onClick' => "window.location.href = '" . $this->Html->url(array('controller' => 'cras', 'action' => 'index')) . "';"
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

if ($this->data) {
    echo $this->Html->tag('div', '', array('style' => 'height: 20px;'));
    echo $this->Html->tag('fieldset', null);
    echo $this->Html->tag('legend', 'Cras - Bairros');
    echo '<table id="flex" style="display: none"></table>';
    echo $this->Html->tag('/fieldset', null);
}