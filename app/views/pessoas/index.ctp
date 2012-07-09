<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));

$flexigridSession = $this->params['controller'] . '.' . $this->params['action'] . '.flexigrid';
?>
<table id="flex" style="display: none"></table> 
<script type="text/javascript">
    $("#flex").flexigrid({
        url: '<?php echo $this->Html->url(array('controller' => 'pessoas', 'action' => 'lista')); ?>',
        dataType: 'json',
        colModel : [
            {display: 'NIS', name : 'Pessoa.nis', width : 80, sortable : true, align: 'center'}, //, hide: true},
            {display: 'Nome', name : 'Pessoa.nome', width : 240, sortable : true, align: 'left'},
            {display: 'Idade', name : 'Pessoa.data_nascimento', width : 45, sortable : true, align: 'center'},
            {display: 'Responsável Legal', name : 'Responsavel.nome', width : 240, sortable : true, align: 'left'},
            {display: 'NIS Responsável', name : 'Responsavel.nis', width : 80, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Editar', bclass: 'edit', onpress : actions},
            {separator: true},
			<?php
			if($temAcessoExclusao) {
				echo " {name: 'Excluir', bclass: 'delete', onpress : actions},";
				echo " {separator: true}";
			}
			?>
        ],
        searchitems : [
            {display: 'NIS', name : 'Pessoa.nis'},
            {display: 'Nome', name : 'Pessoa.nome', isdefault: true},
            {display: 'Data Nascimento', name : 'Pessoa.data_nascimento'},
            {display: 'Responsável', name : 'Responsavel.nome'},
            {display: 'NIS Responsável', name : 'Responsavel.nis'}
        ],
        sortname: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortname') : 'Pessoa.nome'; ?>',
        sortorder: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortorder') : 'asc'; ?>',
        usepager: true,
        useRp: true,
        rp: <?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.rp') : '15'; ?>,
        newp: <?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.page') : 1; ?>,
        rpOptions: [15,30,50,100],
        title: 'Cadastro - Pessoas',
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
        var id = $('.trSelected').find('td[abbr="Pessoa.nis"]').text();
        if(id != '')
            $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'pessoas', 'action' => 'cadastro')); ?>/' + id);
    });
    //}).disableSelection();
    
    function actions(com, grid) {
        var id = $('.trSelected', grid).find('td[abbr="Pessoa.nis"]').text();
        var nome = $('.trSelected', grid).find('td[abbr="nome"]').text();
        switch(com)
        {
            case "Incluir":
                $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'pessoas', 'action' => 'cadastro')); ?>');
                break;
            case "Editar":
                if(id != '')
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'pessoas', 'action' => 'cadastro')); ?>/' + id);
                else
                    alert('Selecione um registro primeiro!');
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