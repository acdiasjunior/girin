<?php
echo $this->Html->css(array('flexigrid'));
echo $javascript->link(array('flexigrid.pack', 'button'));
$flexigridSession = $this->params['controller'] . '.' . $this->params['action'] . '.flexigrid';
?>
<div id="filtrarDomicilios" title="Filtrar Domicilios" style="display: none;">
    <h3>Gerar Prontuário - Filtro</h3>
    <?php
    echo $this->Form->create('Prontuario', array('url' => array('controller' => $this->params['controller'], 'action' => $this->params['action'])));

    echo $this->Html->tag('fieldset', null);
    echo $this->Html->tag('legend', 'Selecione o filtro para busca');
    echo $this->Form->input('filtro', array('options' => array('regiao_id' => 'Região', 'cras_id' => 'Cras', 'bairro_id' => 'Bairro'), 'empty' => 'Selecione o tipo de filtro'));
    echo $this->Form->input('domicilio_regiao_id', array('options' => $regioes, 'empty' => 'Selecione a Região', 'class' => 'filtro regiao_id'));
    echo $this->Form->input('domicilio_cras_id', array('options' => $cras, 'empty' => 'Selecione o CRAS', 'class' => 'filtro cras_id'));
    echo $this->Form->input('domicilio_bairro_id', array('options' => $bairros, 'empty' => 'Selecione o bairro', 'class' => 'filtro bairro_id'));
    echo $this->Html->div('', '', array('style' => 'clear: both;'));
    echo $this->Form->input('domicilio_codigo_domiciliar', array('label' => 'Código Domicíliar'));
    echo $this->Form->input('responsavel_nis', array('label' => 'NIS Responsável Legal'));
    echo $this->Form->input('responsavel_cpf', array('label' => 'CPF Responsável Legal'));
    echo $this->Html->div('', '', array('style' => 'clear: both;'));
    echo $this->Form->input('responsavel_nome', array('label' => 'Nome Responsável Legal', 'class' => 'edit30'));
    echo $this->Html->div('', '', array('style' => 'clear: both;'));
    echo $this->Form->input('domicilio_idf', array('label' => 'IDF'));
    echo $this->Form->input('tipo_busca', array('label' => 'Tipo de busca', 'options' => array('<=' => 'Menor ou Igual que', '=' => 'Exatamente', '>' => 'Acima de')));
    echo $this->Html->tag('/fieldset', null);

    echo $this->Form->end();
    ?>
    <span>Selecione os filtros para os domícilios.</span>
</div>
<script type="text/javascript">

    $(function() {
        
        $('.filtro').parent().hide();
        if($('#ProntuarioFiltro').val() != '')
            $('.' + $('#ProntuarioFiltro').val()).parent().show();
        
        $('#ProntuarioFiltro').change(function(){
            $('.filtro').val('').parent().hide();
            $('.' + $(this).val()).parent().show();
        });
        
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
//                    $(location).attr('href','<?php echo $this->Html->url(array('controller' => $this->params['controller'], 'action' => $this->params['action'])); ?>');
                },
                "Cancelar": function() {
                    $( this ).dialog( "close" );
                }
            }
        });
    });
    
    $(function() {
        $("#filtrarDomicilios").dialog("open");
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
            {display: 'Qtd.', name : 'Domicilio.pessoa_count', width : 20, sortable : true, align: 'center'},
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
        sortname: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortname') : 'Domicilio.codigo_domiciliar'; ?>',
        sortorder: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.sortorder') : 'asc'; ?>',
        page: <?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.page') : 1; ?>,
        pages: 1000,
        usepager: true,
        useRp: true,
        rp: <?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.rp') : '15'; ?>,
        rpOptions: [15,30,50,100],
        qtype: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.qtype') : 'Domicilio.codigo_domiciliar'; ?>',
        query: '<?php echo ($this->Session->check($flexigridSession)) ? $this->Session->read($flexigridSession . '.query') : ''; ?>',
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
        nomsg:'Nenhum item'
    });

    $('#flex').dblclick( function(){
        var id = $('.trSelected').find('td[abbr="Domicilio.codigo_domiciliar"]').text();
        if(id != '')
            $(location).attr('href','<?php echo $this->Html->url(array('controller' => 'domicilios', 'action' => 'cadastro')); ?>/' + id);
    });
    //}).disableSelection();

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
        
        window.onbeforeunload = function() {
            $.ajax({
                url: '<?php echo $this->Html->url(array('controller' => 'usuarios', 'action' => 'gravaParametros', 'flexigrid')) ?>',
                type: 'POST',
                async: false,
                data: {
                    controller: '<?php echo $this->params['controller'] ?>',
                    action: '<?php echo $this->params['action'] ?>',
                    rp: $(".flexigrid .pGroup select").val(),
                    qtype: $(".flexigrid .sDiv select").val(),
                    query: $(".flexigrid .qsbox").val(),
                    page: $('.flexigrid .pcontrol :input').val(),
                    sortname: $('.flexigrid .sorted').attr('abbr'),
                    sortorder: $('.flexigrid .sorted div').attr('class').substr(1,5)
                }
            });
        };
        
        /*
        'domicilio_regiao_id', array('options' => $regioes, 'empty' => 'Selecione a Região', 'class' => 'filtro regiao_id'));
    echo $this->Form->input('domicilio_cras_id', array('options' => $cras, 'empty' => 'Selecione o CRAS', 'class' => 'filtro cras_id'));
    echo $this->Form->input('domicilio_bairro_id', array('options' => $bairros, 'empty' => 'Selecione o bairro', 'class' => 'filtro bairro_id'));
    echo $this->Html->div('', '', array('style' => 'clear: both;'));
    echo $this->Form->input('domicilio_codigo_domiciliar', array('label' => 'Código Domicíliar'));
    echo $this->Form->input('responsavel_nis', array('label' => 'NIS Responsável Legal'));
    echo $this->Form->input('responsavel_cpf', array('label' => 'CPF Responsável Legal'));
    echo $this->Html->div('', '', array('style' => 'clear: both;'));
    echo $this->Form->input('responsavel_nome', array('label' => 'Nome Responsável Legal', 'class' => 'edit30'));
    echo $this->Html->div('', '', array('style' => 'clear: both;'));
    echo $this->Form->input('domicilio_idf', array('label' => 'IDF'));
    echo $this->Form->input('tipo_busca'
         */
</script>