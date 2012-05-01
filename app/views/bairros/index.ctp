<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));

$flexigridSession = $this->params['controller'] . '.' . $this->params['action'] . '.flexigrid';
?>
<div id="excluirBairro" title="Excluir Bairro" style="display: none;">
    <h3>Deseja realmente excluir o bairro?</h3>
    <?php
    echo $this->Form->create('Bairro');
    echo $this->Form->input('id', array('label' => 'Cód.', 'readonly' => 'readonly'));
    echo $this->Form->input('nome', array('label' => 'Nome', 'readonly' => 'readonly', 'class' => 'edit25'));
    echo $this->Form->input('novo_bairro', array('options' => $bairros,'label' => 'Novo Bairro'));
    echo $this->Form->end();
    ?>
    <span>É necessário realocar os domícilios para outro bairro.</span>
</div>
<table id="flex" style="display: none"></table> 
<script type="text/javascript">
    $("#flex").flexigrid({
        url: '<?php echo $this->Html->url(array('controller' => 'bairros', 'action' => 'lista')); ?>',
        dataType: 'json',
        colModel : [
            {display: 'Cód.', name : 'Bairro.id', width : 50, sortable : true, align: 'center', hide: true},
            {display: 'Bairro', name : 'Bairro.nome', width : 200, sortable : true, align: 'left'},
            {display: 'Cras', name : 'Cras.descricao', width : 180, sortable : true, align: 'left'},
            {display: 'Região', name : 'Regiao.descricao', width : 120, sortable : true, align: 'left'},
            {display: 'Domicílios', name : 'Bairro.domicilio_count', width : 100, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Incluir', bclass: 'add', onpress : actions},
            {separator: true},
            {name: 'Editar', bclass: 'edit', onpress : actions},
            {separator: true},
            {name: 'Excluir', bclass: 'delete', onpress : actions},
            {separator: true}
        ],
        searchitems : [
            {display: 'Bairro', name : 'Bairro.nome', isdefault: true}
        ],
        sortname: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortname') : 'Bairro.nome'; ?>',
        sortorder: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortorder') : 'asc'; ?>',
        usepager: true,
        useRp: true,
        rp: <?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.rp') : '15'; ?>,
        newp: <?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.page') : 1; ?>,
        rpOptions: [15,30,50,100],
        title: 'Bairros',
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
        var id = $('.trSelected').find('td[abbr="Bairro.id"]').text();
        if(id != '')
            $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'bairros', 'action' => 'cadastro')); ?>/' + id);
    });
    //}).disableSelection();
    
    function actions(com, grid) {
        var id = $('.trSelected', grid).find('td[abbr="Bairro.id"]').text();
        var nome = $('.trSelected', grid).find('td[abbr="Bairro.nome"]').text();
        switch(com)
        {
            case "Incluir":
                $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'bairros', 'action' => 'cadastro')); ?>');
                break;
            case "Editar":
                if(id != '')
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'bairros', 'action' => 'cadastro')); ?>/' + id);
                else
                    alert('Selecione um registro primeiro!');
                break;
            case "Excluir":
                if(id != '')
                {
                    $("#BairroId").val(id);
                    $("#BairroNome").val(nome);
                    $("#excluirBairro").dialog("open");
                }
                else
                    alert('Selecione um registro primeiro!');
                break;
            }
        }
     
        $(function() {
            $("#excluirBairro").dialog({
                resizable: false,
//                height:140,
                modal: true,
                autoOpen: false,
                buttons: {
                    "Excluir Bairro": function() {
                        $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'bairros', 'action' => 'excluir')); ?>/' + $("#BairroId").val() + '/' + $("#BairroNovoBairro").val());
                    },
                    "Cancelar": function() {
                        $( this ).dialog( "close" );
                    }
                }
            });
        });
        
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