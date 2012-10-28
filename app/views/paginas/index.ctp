<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));

$flexigridSession = $this->params['controller'] . '.' . $this->params['action'] . '.flexigrid';
?>
<table id="flex" style="display: none"></table>
<script type="text/javascript">
    $("#flex").flexigrid({
        url: '<?php echo $this->Html->url(array('controller' => 'paginas', 'action' => 'lista')); ?>',
        dataType: 'json',
        colModel : [
            {display: 'Cód.', name : 'Pagina.id_pagina', width : 50, sortable : true, align: 'center'}, //, hide: true},
            {display: 'Link', name : 'Pagina.nome_link', width : 150, sortable : true, align: 'left'},
            {display: 'Título', name : 'Pagina.desc_titulo', width : 230, sortable : true, align: 'left'}
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
            {display: 'Link', name : 'Pagina.nome_link', isdefault: true}
        ],
        sortname: "Pagina.nome_link",
        sortorder: "asc",
        usepager: true,
        useRp: true,
        rp: 15,
        rpOptions: [15,30,50,100],
        title: 'Páginas',
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
        var id = $('.trSelected').find('td[abbr="Pagina.id_pagina"]').text();
        if(id != '')
            $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'paginas', 'action' => 'cadastro')); ?>/' + id);
    });
    //}).disableSelection();

    function actions(com, grid) {
        var id = $('.trSelected', grid).find('td[abbr="Pagina.id_pagina"]').text();
        var nome = $('.trSelected', grid).find('td[abbr="Pagina.nome_link"]').text();
        switch(com)
        {
            case "Incluir":
                $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'paginas', 'action' => 'cadastro')); ?>');
                break;
            case "Editar":
                if(id != '')
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'paginas', 'action' => 'cadastro')); ?>/' + id);
                else
                    alert('Selecione um registro primeiro!');
                break;
            case "Excluir":
                if(id != '')
                {
                    if(confirm('Deseja realmente excluir?\nLink: ' + nome))
                        $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'paginas', 'action' => 'excluir')); ?>/' + id);
                }
                else
                    alert('Selecione um registro primeiro!');
                break;
            }
        }
</script>