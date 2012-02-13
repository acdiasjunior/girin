<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));
$flexigridSession = $this->params['controller'] . '.' . $this->params['action'] . '.flexigrid';
?>
<div id="filtrarDomicilios" title="Filtrar Domicilios" style="display: none;"></div>
<script type="text/javascript">

    $(function() {
                
        $("#filtrarDomicilios").dialog({
            resizable: false,
            width: 600,
            modal: true,
            autoOpen: false,
            buttons: {
                "Filtrar Domicílios": function() {
                    $( this ).dialog( "close" );
                    gravaFiltro();
                    $('#flex').flexReload();
                },
                "Cancelar": function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });
    
    $(function() {
        $.ajaxSetup({ async: false });
        $("#filtrarDomicilios").load("<?php echo $this->Html->url(array('controller' => $this->params['controller'],'action' => 'filtro')) ?>");
        $("#filtrarDomicilios").dialog("open");
        $.ajaxSetup({ async: true });
    });
    
    function gravaFiltro() {
        $.ajax({
            url: '<?php echo $this->Html->url(array('controller' => 'usuarios', 'action' => 'gravaParametros', 'filtroDomicilios')) ?>',
            type: 'POST',
            async: false,
            data: {
                controller: '<?php echo $this->params['controller'] ?>',
                action: '<?php echo $this->params['action'] ?>',
                'Domicilio.codigo_domiciliar': $('input[id$="DomicilioCodigoDomiciliar"]').val(),
                'Domicilio.regiao_id': $('select[id$="DomicilioRegiaoId"]').val(),
                'Domicilio.cras_id': $('select[id$="DomicilioCrasId"]').val(),
                'Domicilio.bairro_id': $('select[id$="DomicilioBairroId"]').val(),
                'Responsavel.nis': $('input[id$="ResponsavelNis"]').val(),
                'Responsavel.cpf': $('input[id$="ResponsavelCpf"]').val(),
                'Responsavel.nome': $('input[id$="ResponsavelNome"]').val(),
                'Domicilio.idf': $('input[id$="DomicilioIdf"]').val(),
                'TipoBusca': $('select[id$="TipoBusca"]').val()
            }
        });
    };

</script>
<table id="flex" style="display: none"></table>
<script type="text/javascript">
    $("#flex").flexigrid({
        url: '<?php echo $this->Html->url(array('controller' => 'domicilios', 'action' => 'listaDomiciliosFiltro')); ?>',
        dataType: 'json',
        colModel : [
            {display: 'Cód. Dom.', name : 'Domicilio.codigo_domiciliar', width : 55, sortable : true, align: 'center'}, //, hide: true},
            {display: 'Responsável', name : 'Responsavel.nome', width : 210, sortable : true, align: 'left'},
            {display: 'Logradouro', name : 'Domicilio.logradouro', width : 190, sortable : true, align: 'left'},
            {display: 'Numero', name : 'Domicilio.numero', width : 40, sortable : true, align: 'center'},
            {display: 'Bairro', name : 'Bairro.nome', width : 105, sortable : true, align: 'left'},
            {display: 'IDF', name : 'Indice.idf', width : 30, sortable : true, align: 'center'},
            {display: 'Renda Familiar', name : 'Domicilio.renda_familiar', width : 70, sortable : true, align: 'center'},
            {display: 'Qtd.', name : 'Domicilio.quantidade_pessoas', width : 20, sortable : true, align: 'center'},
            {display: 'Renda per Cap.', name : 'Domicilio.renda_per_capita', width : 70, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'Prontuario', bclass: 'prontuario', onpress : actions},
            {separator: true},
            {name: 'Filtrar', bclass: 'prontuario', onpress : actions},
            {separator: true}
        ],
        searchitems : [
            {display: 'Cód. Domiciliar', name : 'Domicilio.codigo_domiciliar', isdefault: true},
            {display: 'Responsável', name : 'Responsavel.nome'},
            {display: 'IDF <=', name : 'Domicilio.idf'},
            {display: 'Logradouro', name : 'Domicilio.logradouro'},
            {display: 'Bairro', name : 'Bairro.nome'},
            {display: 'Cidade', name : 'Domicilio.cidade'}
        ],
        sortname: 'Domicilio.codigo_domiciliar',
        sortorder: 'asc',
        usepager: true,
        useRp: true,
        rp: '15',
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
        nomsg:'Nenhum item',
        autoload : false
    });

    $('#flex').dblclick( function(){
        var id = $('.trSelected').find('td[abbr="Domicilio.codigo_domiciliar"]').text();
        if(id != '')
            $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'domicilios', 'action' => 'cadastro')); ?>/' + id);
    });

    function actions(com, grid) {
        var id = $('.trSelected', grid).find('td[abbr="Domicilio.codigo_domiciliar"]').text();
        var nome = $('.trSelected', grid).find('td[abbr="Responsavel.nome"]').text();
        switch(com)
        {
            case "Prontuario":
                if(id != '')
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'prontuarios', 'action' => 'gerarProntuario')); ?>/' + id);
                else
                    alert('Selecione um registro primeiro!');
                break;
            case "Filtrar":
                $("#filtrarDomicilios").dialog("open");
                break;
            }
        }
        
</script>