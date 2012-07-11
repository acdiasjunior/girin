<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));

$flexigridSession = $this->params['controller'] . '.' . $this->params['action'] . '.flexigrid';
?>
<table id="flex" style="display: none"></table> 
<script type="text/javascript">
    $("#flex").flexigrid({
        url: '<?php echo $this->Html->url(array('controller' => 'acoes', 'action' => 'lista')); ?>',
        dataType: 'json',
        colModel : [
            {display: 'ID', name : 'Acao.id_acao', width : 50, sortable : true, align: 'center', hide: true},
            {display: 'Codigo', name : 'Acao.cod_acao', width : 50, sortable : true, align: 'center'},
            {display: 'Meta', name : 'Acao.desc_acao', width : 800, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Incluir', bclass: 'add', onpress : actions},
            {separator: true},
            {name: 'Editar', bclass: 'edit', onpress : actions},
            {separator: true},
<?php
if ($temAcessoExclusao) {
    echo " {name: 'Excluir', bclass: 'delete', onpress : actions},";
    echo " {separator: true}";
}
?>
        ],
        searchitems : [
            {display: 'Ação', name : 'Acao.desc_acao', isdefault: true}
        ],
        sortname: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortname') : 'Acao.cod_acao'; ?>',
        sortorder: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortorder') : 'asc'; ?>',
        usepager: true,
        useRp: true,
        rp: <?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.rp') : '15'; ?>,
        newp: <?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.page') : 1; ?>,
        rpOptions: [15,30,50,100],
        title: 'Metas',
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
        var id = $('.trSelected').find('td[abbr="Acao.id_acao"]').text();
        if(id != '')
            $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'acoes', 'action' => 'cadastro')); ?>/' + id);
    });
    //}).disableSelection();
    
    function actions(com, grid) {
        var id = $('.trSelected', grid).find('td[abbr="Acao.id_acao"]').text();
        var meta = $('.trSelected', grid).find('td[abbr="Acao.desc_acao"]').text();
        switch(com)
        {
            case "Incluir":
                $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'acoes', 'action' => 'cadastro')); ?>');
                break;
            case "Editar":
                if(id != '')
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'acoes', 'action' => 'cadastro')); ?>/' + id);
                else
                    alert('Selecione um registro primeiro!');
                break;
            case "Excluir":
                if(id != '')
                {
                    if(confirm('Deseja realmente excluir?\nAção: ' + meta))
                        $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'acoes', 'action' => 'excluir')); ?>/' + id);
                }
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