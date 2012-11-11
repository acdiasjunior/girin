<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));

$flexigridSession = $this->params['controller'] . '.' . $this->params['action'] . '.flexigrid';
?>
<table id="flex" style="display: none"></table>
<script type="text/javascript">
    $("#flex").flexigrid({
        url: '<?php echo $this->Html->url(array('controller' => 'plano_familiares', 'action' => 'lista')); ?>',
        dataType: 'json',
        colModel : [
            {display: 'ID', name : 'PlanoFamiliar.id_plano_familiar', width : 40, sortable : true, align: 'center'}, //, hide: true},
            {display: 'Núm.', name : 'PlanoFamiliar.num_plano_familiar', width : 60, sortable : true, align: 'center'},
            {display: 'Cód. Domiciliar', name : 'Domicilio.cod_domiciliar', width : 80, sortable : true, align: 'center'},
            {display: 'Cras', name : 'Cras.desc_cras', width : 160, sortable : true, align: 'left'},
            {display: 'vlr_idf', name : 'Indice.vlr_idf', width : 40, sortable : true, align: 'center'},
            {display: 'Usuário', name : 'Usuario.nome_usuario', width : 220, sortable : true, align: 'left'},
            {display: 'Data', name : 'PlanoFamiliar.created', width : 110, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Exibir', bclass: 'show', onpress : actions},
            {separator: true},
            {name: 'Gerar PDF', bclass: 'pdf', onpress : actions},
            {separator: true},
<?php
if ($temAcessoExclusao) {
    echo " {name: 'Excluir', bclass: 'delete', onpress : actions},";
    echo " {separator: true}";
}
?>
        ],
        searchitems : [
            {display: 'Cód. Domiciliar', name : 'Domicilio.cod_domiciliar', isdefault: true},
            {display: 'Responsável', name : 'Responsavel.nome'},
            {display: 'Logradouro', name : 'Domicilio.end_logradouro'},
            {display: 'Bairro', name : 'Bairro.nome_bairro'},
            {display: 'Cidade', name : 'Domicilio.end_cidade'}
        ],
        sortname: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortname') : 'PlanoFamiliar.id_plano_familiar'; ?>',
        sortorder: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortorder') : 'asc'; ?>',
        usepager: true,
        useRp: true,
        rp: <?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.rp') : '15'; ?>,
        newp: <?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.page') : 1; ?>,
        rpOptions: [15,30,50,100],
        title: 'Prontuários',
        width: 920,
        height: 370,
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
        var id = $('.trSelected').find('td[abbr="PlanoFamiliar.id_plano_familiar"]').text();
        if(id != '')
            $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'plano_familiares', 'action' => 'exibirPlanoFamiliar')); ?>/' + id);
    });
    //}).disableSelection();

    function actions(com, grid) {
        var id = $('.trSelected', grid).find('td[abbr="PlanoFamiliar.id_plano_familiar"]').text();
        switch(com)
        {
            case "Exibir":
                if(id != '')
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'plano_familiares', 'action' => 'exibirPlanoFamiliar')); ?>/' + id);
                else
                    alert('Selecione um registro primeiro!');
                break;
            case "Gerar PDF":
                if(id != '')
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'plano_familiares', 'action' => 'gerarPDF')); ?>/' + id);
                else
                    alert('Selecione um registro primeiro!');
                break;
            default:
                break;
            }
        }

        window.onbeforeunload = function() {
            $.ajax({
                url: '<?php echo $this->Html->url(array('controller' => 'usuarios', 'action' => 'gravaParametros', 'flexigrid')) ?>',
                type: 'POST',
                async: false,
                data: {
                    controller: '<?php echo $this->params['controller'] ?>',
                    action: '<?php echo $this->params['action'] ?>',
                    rp: $(".flexigrid .pGroup select").val(),
                    page: $('.flexigrid .pcontrol :input').val(),
                    sortname: $('.flexigrid .sorted').attr('abbr'),
                    sortorder: $('.flexigrid .sorted div').attr('class').substr(1,5)
                }
            });
        };
</script>