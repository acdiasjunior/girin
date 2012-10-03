<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));

$flexigridSession = $this->params['controller'] . '.' . $this->params['action'] . '.flexigrid';
?>
<table id="flex" style="display: none"></table>
<script type="text/javascript">
    $("#flex").flexigrid({
        url: '<?php echo $this->Html->url(array('controller' => 'domicilios', 'action' => 'lista')); ?>',
        dataType: 'json',
        colModel : [
            {display: 'Cód. Dom.', name : 'Domicilio.cod_domiciliar', width : 55, sortable : true, align: 'center'}, //, hide: true},
            {display: 'Responsável', name : 'Responsavel.nome', width : 210, sortable : true, align: 'left'},
            {display: 'Logradouro', name : 'Domicilio.end_logradouro', width : 190, sortable : true, align: 'left'},
            {display: 'Numero', name : 'Domicilio.end_num', width : 40, sortable : true, align: 'center'},
            {display: 'Bairro', name : 'Bairro.nome_bairro', width : 105, sortable : true, align: 'left'},
            {display: 'vlr_idf', name : 'Indice.vlr_idf', width : 30, sortable : true, align: 'center'},
            {display: 'Renda Familiar', name : 'Domicilio.vlr_renda_familia', width : 70, sortable : true, align: 'center'},
            {display: 'Qtd.', name : 'Domicilio.qtd_pessoa', width : 20, sortable : true, align: 'center'},
            {display: 'Renda per Cap.', name : 'Domicilio.vlr_renda_per_capita', width : 70, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Editar', bclass: 'edit', onpress : actions},
            {separator: true},
            {name: 'PlanoFamiliar', bclass: 'plano_familiar', onpress : actions},
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
            {display: 'IDF <=', name : 'Domicilio.vlr_idf'},
            {display: 'Logradouro', name : 'Domicilio.end_logradouro'},
            {display: 'Bairro', name : 'Bairro.nome_bairro'},
            {display: 'Data Nascimento Resp.', name : 'Responsavel.dt_nasc'}
        ],
        sortname: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortname') : 'Domicilio.cod_domiciliar'; ?>',
        sortorder: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortorder') : 'asc'; ?>',
        usepager: true,
        useRp: true,
        rp: <?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.rp') : '15'; ?>,
        newp: <?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.page') : 1; ?>,
        rpOptions: [15,30,50,100],
        title: 'Domicílios',
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
        var id = $('.trSelected').find('td[abbr="Domicilio.cod_domiciliar"]').text();
        if(id != '')
            $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'domicilios', 'action' => 'cadastro')); ?>/' + id);
    });
    //}).disableSelection();

    function actions(com, grid) {
        var id = $('.trSelected', grid).find('td[abbr="Domicilio.cod_domiciliar"]').text();
        var nome = $('.trSelected', grid).find('td[abbr="Responsavel.nome"]').text();
        switch(com)
        {
            case "Incluir":
                $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'domicilios', 'action' => 'cadastro')); ?>');
                break;
            case "Editar":
                if(id != '')
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'domicilios', 'action' => 'cadastro')); ?>/' + id);
                else
                    alert('Selecione um registro primeiro!');
                break;
            case "Excluir":
                if(id != '')
                {
                    if(confirm('Deseja realmente excluir?\nResponsável Legal: ' + nome))
                        $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'domicilios', 'action' => 'excluir')); ?>/' + id);
                }
                else
                    alert('Selecione um registro primeiro!');
                break;
            case "PlanoFamiliar":
                if(id != '')
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'plano_familiares', 'action' => 'gerarPlanoFamiliar')); ?>/' + id);
                else
                    alert('Selecione um registro primeiro!');
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