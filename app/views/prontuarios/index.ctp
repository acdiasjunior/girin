<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));

$flexigridSession = $this->params['controller'] . '.' . $this->params['action'] . '.flexigrid';
?>
<table id="flex" style="display: none"></table> 
<script type="text/javascript">
    $("#flex").flexigrid({
        url: '<?php echo $this->Html->url(array('controller' => 'prontuarios', 'action' => 'lista')); ?>',
        dataType: 'json',
        colModel : [
            {display: 'ID', name : 'Prontuario.id', width : 40, sortable : true, align: 'center'}, //, hide: true},
            {display: 'Núm.', name : 'Prontuario.numero_prontuario', width : 60, sortable : true, align: 'center'},
            {display: 'Cód. Domiciliar', name : 'Domicilio.codigo_domiciliar', width : 80, sortable : true, align: 'center'},
            {display: 'Cras', name : 'Cras.nome', width : 160, sortable : true, align: 'left'},
            {display: 'IDF', name : 'Indice.indice', width : 40, sortable : true, align: 'center'},
            {display: 'Usuário', name : 'Usuario.nome', width : 220, sortable : true, align: 'left'},
            {display: 'Data', name : 'Prontuario.created', width : 110, sortable : true, align: 'center'}
            /*
             * $prontuario['Prontuario']['id'],
            $prontuario['Prontuario']['numero'],
            $prontuario['Domicilio']['codigo_domiciliar'],
            round($prontuario['Indice']['idf'],2),
            $prontuario['Usuario']['nome'],
            $prontuario['Prontuario']['created'],
             */
        ],
        buttons : [
            {name: 'Exibir', bclass: 'show', onpress : actions},
            {separator: true},
            {name: 'Gerar PDF', bclass: 'pdf', onpress : actions},
            {separator: true},
			<?php
			if($temAcessoExclusao) {
				echo " {name: 'Excluir', bclass: 'delete', onpress : actions},";
				echo " {separator: true}";
			}
			?>
        ],
        searchitems : [
            {display: 'Cód. Domiciliar', name : 'Domicilio.codigo_domiciliar', isdefault: true},
            {display: 'Responsável', name : 'Responsavel.nome'},
            {display: 'Logradouro', name : 'Domicilio.logradouro'},
            {display: 'Bairro', name : 'Bairro.nome'},
            {display: 'Cidade', name : 'Domicilio.cidade'}
        ],
        sortname: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortname') : 'Domicilio.codigo_domiciliar'; ?>',
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
        var id = $('.trSelected').find('td[abbr="Prontuario.id"]').text();
        if(id != '')
            $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'prontuarios', 'action' => 'exibirProntuario')); ?>/' + id);
    });
    //}).disableSelection();
    
    function actions(com, grid) {
        var id = $('.trSelected', grid).find('td[abbr="Prontuario.id"]').text();
        var nome = $('.trSelected', grid).find('td[abbr="Usuario.nome"]').text();
        switch(com)
        {
            case "Exibir":
                if(id != '')
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'prontuarios', 'action' => 'exibirProntuario')); ?>/' + id);
                else
                    alert('Selecione um registro primeiro!');
                break;
            case "Gerar PDF":
                if(id != '')
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'prontuarios', 'action' => 'gerarPDF')); ?>/' + id);
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