<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));

$flexigridSession = $this->params['controller'] . '.' . $this->params['action'] . '.flexigrid';
?>
<table id="flex" style="display: none"></table>
<script type="text/javascript">
    $("#flex").flexigrid({
        url: '<?php echo $this->Html->url(array('controller' => 'permissoes', 'action' => 'lista')); ?>',
        dataType: 'json',
        colModel : [
            {display: 'Cód. Permissão', name : 'Permissao.id_permissao', width : 55, sortable : true, align: 'center', hide: true},
            {display: 'Controlador', name : 'Permissao.nome_controller', width : 150, sortable : true, align: 'left'},
            {display: 'Ação', name : 'Permissao.nome_action', width : 150, sortable : true, align: 'left'},
            {display: 'Administrador', name : 'Permissao.tp_permissao_administrador', width : 70, sortable : true, align: 'center'},
            {display: 'Técnico SAS', name : 'Permissao.tp_permissao_tecnico_sas', width : 70, sortable : true, align: 'left'},
            {display: 'Coord. CRAS', name : 'Permissao.tp_permissao_coordenador_cras', width : 70, sortable : true, align: 'center'},
            {display: 'Técnico CRAS', name : 'Permissao.tp_permissao_tecnico_cras', width : 70, sortable : true, align: 'center'},
        ],
        buttons : [
            {name: 'Editar', bclass: 'edit', onpress : actions},
            {separator: true}
        ],
        sortname: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortname') : 'Permissao.nome_controller'; ?>',
        sortorder: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortorder') : 'asc'; ?>',
        usepager: true,
        useRp: true,
        rp: <?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.rp') : '15'; ?>,
        newp: <?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.page') : 1; ?>,
        rpOptions: [15,30,50,100],
        title: 'Permissões',
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
        var id = $('.trSelected').find('td[abbr="Permissao.id_permissao"]').text();
        if(id != '')
            $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'permissoes', 'action' => 'gerenciar')); ?>/' + id);
    }).disableSelection();

    function actions(com, grid) {
        var id = $('.trSelected').find('td[abbr="Permissao.id_permissao"]').text();
        switch(com)
        {
            case "Editar":
                if(id != '')
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'permissoes', 'action' => 'cadastro')); ?>/' + id);
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