<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));

$flexigridSession = $this->params['controller'] . '.' . $this->params['action'] . '.flexigrid';
?>
<div id="alterarSenha" title="Alterar Senha do Usuário" style="display: none;">
    <?php
    echo $this->Form->create('Usuario', array('action' => 'mudarSenhaUsuario'));
    echo $this->Form->hidden('id');
    echo $this->Form->input('nova_senha', array('label' => 'Senha', 'value' => '', 'type' => 'password'));
    echo $this->Form->end();
    ?>
    <span>Insira a nova senha para o usuário.</span>
</div>
<h1>Cadastro de Usuários</h1>
<table id="flex" style="display: none"></table> 
<script type="text/javascript">
    $("#flex").flexigrid({
        url: '<?php echo $this->Html->url(array('controller' => 'usuarios', 'action' => 'lista')); ?>',
        dataType: 'json',
        colModel : [
            {display: 'Codigo', name : 'id', width : 50, sortable : true, align: 'center'}, //, hide: true},
            {display: 'Nome', name : 'nome', width : 160, sortable : true, align: 'left'},
            {display: 'Login', name : 'username', width : 160, sortable : true, align: 'left'},
            {display: 'Grupo', name : 'id_grupo', width : 160, sortable : true, align: 'left'}
        ],
        buttons : [
            {name: 'Incluir', bclass: 'add', onpress : actions},
            {name: 'Editar', bclass: 'edit', onpress : actions},
            <?php
			if($temAcessoExclusao) {
				echo " {name: 'Excluir', bclass: 'delete', onpress : actions},";
			}
			?>
            {separator: true},
            {name: 'Senha', bclass: 'edit', onpress : actions}
        ],
        sortname: "nome",
        sortorder: "asc",
        //title: 'Usuarios',
        width: 620,
        height: 270,
        singleSelect: true
    });
    
    $('#flex').dblclick( function(){
        var id = $('.trSelected', grid).find('td[abbr="id"]').text();
        if(id != '')
            $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'usuarios', 'action' => 'cadastro')); ?>/' + id);
    }).disableSelection();
    
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
            case "Senha":
                if(id != '')
                {
                    $("#UsuarioId").val(id);
                    $("#alterarSenha").dialog("open");
                }
                else
                    alert('Selecione um registro primeiro!');
                break;
            }
        }
        
        $(function() {
            $("#alterarSenha").dialog({
                resizable: false,
                modal: true,
                autoOpen: false,
                buttons: {
                    "Alterar Senha": function() {
                        $('#UsuarioMudarSenhaUsuarioForm').submit();
                    },
                    "Cancelar": function() {
                        $(this).dialog( "close" );
                    }
                }
            });
        });
</script>