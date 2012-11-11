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
                }
            }
        });
    });
    
    $(function() {
        $.ajaxSetup({ async: false });
        $("#filtrarDomicilios").load("<?php echo $this->Html->url(array('controller' => $this->params['controller'], 'action' => 'filtro')) ?>");
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
                'Domicilio.cod_domiciliar': $('input[id$="DomicilioCodigoDomiciliar"]').val(),
                'Domicilio.id_regiao': $('select[id$="DomicilioIdRegiao"]').val(),
                'Domicilio.id_cras': $('select[id$="DomicilioIdCras"]').val(),
                'Domicilio.id_bairro': $('select[id$="DomicilioIdBairro"]').val(),
                'Responsavel.cod_nis': $('input[id$="ResponsavelCodNis"]').val(),
                'Responsavel.cpf': $('input[id$="ResponsavelCpf"]').val(),
                'Responsavel.nome': $('input[id$="ResponsavelNome"]').val(),
                'Domicilio.vlr_idf': $('input[id$="DomicilioVlrIdf"]').val(),
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
            {display: 'Cód. Dom.', name : 'Domicilio.cod_domiciliar', width : 55, sortable : true, align: 'center'}, //, hide: true},
            {display: 'Responsável', name : 'Responsavel.nome', width : 210, sortable : true, align: 'left'},
            {display: 'Logradouro', name : 'Domicilio.end_logradouro', width : 190, sortable : true, align: 'left'},
            {display: 'Numero', name : 'Domicilio.end_num', width : 40, sortable : true, align: 'center'},
            {display: 'Bairro', name : 'Bairro.nome_bairro', width : 105, sortable : true, align: 'left'},
            {display: 'vlr_idf', name : 'Indice.vlr_idf', width : 30, sortable : true, align: 'center'},
            {display: 'Renda Familiar', name : 'Domicilio.vlr_renda_familiar', width : 70, sortable : true, align: 'center'},
            {display: 'Qtd.', name : 'Domicilio.qtd_pessoa', width : 20, sortable : true, align: 'center'},
            {display: 'Renda per Cap.', name : 'Domicilio.vlr_renda_per_capita', width : 70, sortable : true, align: 'center'}
        ],
        buttons : [
            {name: 'PlanoFamiliar', bclass: 'plano_familiar', onpress : actions},
            {separator: true},
            {name: 'Filtrar', bclass: 'plano_familiar', onpress : actions},
            {separator: true}
        ],
        sortname: 'Domicilio.cod_domiciliar',
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
        var id = $('.trSelected').find('td[abbr="Domicilio.cod_domiciliar"]').text();
        if(id != '')
            $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'domicilios', 'action' => 'cadastro')); ?>/' + id);
    });

    function actions(com, grid) {
        var id = $('.trSelected', grid).find('td[abbr="Domicilio.cod_domiciliar"]').text();
        var nome = $('.trSelected', grid).find('td[abbr="Responsavel.nome"]').text();
        switch(com)
        {
            case "PlanoFamiliar":
                if(id != '')
                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'plano_familiares', 'action' => 'gerarPlanoFamiliar')); ?>/' + id);
                else
                    alert('Selecione um registro primeiro!');
                break;
            case "Filtrar":
                $("#filtrarDomicilios").dialog("open");
                break;
            }
        }
        
</script>