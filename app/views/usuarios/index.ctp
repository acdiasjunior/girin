<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));
?>
<h1>Cadastro de Usuários</h1>
<table id="flex" style="display: none"></table> 
<script type="text/javascript">
    $("#flex").flexigrid({
        url: '<?php echo $this->Html->url(array('controller' => 'usuarios', 'action' => 'lista')); ?>',
        dataType: 'json',
        colModel : [
            {display: 'Codigo', name : 'id', width : 50, sortable : true, align: 'center'}, //, hide: true},
            {display: 'Nome', name : 'nome', width : 270, sortable : true, align: 'left'},
            {display: 'Login', name : 'username', width : 230, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Incluir', bclass: 'add', onpress : actions},
            {name: 'Editar', bclass: 'edit', onpress : actions},
            {name: 'Excluir', bclass: 'delete', onpress : actions},
            {separator: true}
        ],
        sortname: "nome",
        sortorder: "asc",
        //title: 'Usuarios',
        width: 620,
        height: 270,
        singleSelect: true
    });
    
    function actions(com, grid) {
        var id = $('.trSelected', grid).find('td[abbr="id"]').text();
        var nome = $('.trSelected', grid).find('td[abbr="nome"]').text();
        switch(com)
        {
            case "Incluir":
                $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'usuarios', 'action' => 'cadastro')); ?>');
                break;
            case "Editar":
                if(id != '')
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'usuarios', 'action' => 'cadastro')); ?>/' + id);
                else
                    alert('Selecione um registro primeiro!');
                break;
            case "Excluir":
                if(id != ''){
                    if(confirm('Deseja realmente excluir?\nUsuario: ' + nome))
                        $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'usuarios', 'action' => 'excluir')); ?>/' + id);
                }else
                    alert('Selecione um registro primeiro!');
                break;
            }
        }
</script>