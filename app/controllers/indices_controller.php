<?php

class IndicesController extends AppController {

    var $name = 'Indices';
    var $helpers = array('Javascript', 'Js');
    var $components = array('RequestHandler');
    var $pessoa_count = '(SELECT COUNT(*) FROM pessoas WHERE pessoas.codigo_domiciliar = Domicilio.codigo_domiciliar)';

    function index() {
        $joins = array(
            array('table' => 'domicilios',
                'alias' => 'Domicilio',
                'type' => 'INNER',
                'conditions' => array(
                    'Indice.codigo_domiciliar = Domicilio.codigo_domiciliar',
                )
            ),
            array('table' => 'regioes',
                'alias' => 'Regiao',
                'type' => 'LEFT',
                'conditions' => array(
                    'Regiao.id = Domicilio.regiao_id',
                )
            ),
            array('table' => 'bairros',
                'alias' => 'Bairro',
                'type' => 'LEFT',
                'conditions' => array(
                    'Bairro.id = Domicilio.bairro_id',
                )
            ),
            array('table' => 'cras',
                'alias' => 'Cras',
                'type' => 'LEFT',
                'conditions' => array(
                    'Cras.id = Domicilio.cras_id',
                )
            ),
        );
        $fields = array(
            'AVG(Indice.idf) AS idf_media',
            'MAX(Indice.idf) AS idf_max',
            'MIN(Indice.idf) AS idf_min',
            'AVG(Indice.vulnerabilidade) AS vulnerabilidade',
            'AVG(Indice.conhecimento) AS conhecimento',
            'AVG(Indice.trabalho) AS trabalho',
            'AVG(Indice.recursos) AS recursos',
            'AVG(Indice.desenvolvimento) AS desenvolvimento',
            'AVG(Indice.habitacao) AS habitacao',
        );
        $conditions = array();

        foreach ($this->Indice->indicadores as $indicador)
            $fields[] = "AVG($indicador) AS $indicador";

        switch ($this->data['Relatorio']['filtro']) {
            case 'regiao_id':
                $conditions = array(
                    'Domicilio.regiao_id' => $this->data['Relatorio']['regiao_id']
                );
                break;
            case 'cras_id':
                $conditions = array(
                    'Domicilio.cras_id' => $this->data['Relatorio']['cras_id']
                );
                break;
            case 'bairro_id':
                $conditions = array(
                    'Domicilio.bairro_id' => $this->data['Relatorio']['bairro_id']
                );
                break;
        }

        $options = array(
            'recursive' => -1,
            'joins' => $joins,
            'fields' => $fields,
            'conditions' => $conditions,
        );

        $inicio = microtime(true);
        $indices = $this->Indice->find('all', $options);

        $fields = array(
            'COUNT(*) AS total',
            '(CASE
                    WHEN Indice.idf <= 0.6 THEN "ate06"
                    WHEN Indice.idf > 0.6 AND Indice.idf <= 0.7 THEN "de06a07"
                    WHEN Indice.idf > 0.7 AND Indice.idf <= 0.8 THEN "de07a08"
                    WHEN Indice.idf > 0.8 AND Indice.idf <= 0.9 THEN "de08a09"
                    WHEN Indice.idf > 0.9 THEN "maior09"
                 END) AS idf',
        );
        $group = array('idf');

        $options = array(
            'recursive' => -1,
            'joins' => $joins,
            'fields' => $fields,
            'conditions' => $conditions,
            'group' => $group,
        );

        $totais = array(
            'total' => 0
        );

        foreach ($this->Indice->find('all', $options) as $total) {
            $totais[$total[0]['idf']] = $total[0]['total'];
            $totais['total'] += $total[0]['total'];
        }

        $indices['tempo'] = microtime(true) - $inicio;

        $this->set(compact('indices', 'totais'));
    }

    function atualizarIndices($atualizar = null) {
        $this->loadModel('Domicilio');
        $retorno['status'] = 1;
        switch ($atualizar) {
            case 'total':
                $retorno['total'] = $this->Domicilio->find('count', array('conditions' => array($this->pessoa_count . ' > 0')));
                break;
            case 'desatualizados':
                $retorno['desatualizados'] = $this->Domicilio->find('count', array(
                    'conditions' => array(
                        $this->pessoa_count . ' > 0',
                        'OR' => array(
                            'Indice.modified <' => date('Y-m-d'),
                            'Indice.modified IS NULL',
                        )
                    )
                        ));
                break;
            case 'atualizar':
                if (isset($this->params['form']['limit']))
                    $limite = $this->params['form']['limit'];

                $domicilios = $this->Domicilio->find('list', array(
                    'joins' => array(
                        array('table' => 'indices',
                            'alias' => 'Indice',
                            'type' => 'LEFT',
                            'conditions' => array(
                                'Domicilio.codigo_domiciliar = Indice.codigo_domiciliar',
                            )
                        )
                    ),
                    'conditions' => array(
                        $this->pessoa_count . ' > 0',
                        'OR' => array(
                            'Indice.modified <' => date('Y-m-d'),
                            'Indice.modified IS NULL',
                        )
                    ),
                    'limit' => $limite,
                        )
                );

                foreach ($domicilios as $codigo_domiciliar) {

                    $this->data = array();

                    $this->Domicilio->id = $codigo_domiciliar;
                    $domicilio = $this->Domicilio->read();

                    $contador = array('idade_ativa' => 0, 'idade_ativa_ocupado' => 0, 'membros' => 0);
                    $somatorio = array('valor_renda' => 0, 'valor_beneficio' => 0);

                    $dimensao = $this->Indice->dimensoes;
                    $this->Indice->calcularIndices($domicilio);

                    foreach ($domicilio['Pessoa'] as $pessoa) {
                        foreach ($dimensao as $nome => $componentes)
                            foreach ($componentes as $nomeComponente => $indicadores)
                                foreach ($indicadores as $indicador => $padrao)
                                    if ($dimensao[$nome][$nomeComponente][$indicador] == $padrao) {
                                        $retorno = $this->calculaIndicadorPessoa($pessoa, $indicador, $dimensao[$nome][$nomeComponente][$indicador]);
                                        $dimensao[$nome][$nomeComponente][$indicador] = $retorno['valor'];
                                    }

                        $contador['membros']++;
                        //V.9 Mais da metade dos membros encontra-se em idade ativa
                        if ($pessoa['idade'] >= Pessoa::IDADE_ADOLESCENTE)
                            $contador['idade_ativa']++;
                        //T.1 Mais da metade dos membros em idade ativa encontram-se ocupados
                        if ($pessoa['idade'] >= Pessoa::IDADE_ADOLESCENTE &&
                                $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO
                                && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA)
                            $contador['idade_ativa_ocupado']++;
                        //R.2 Renda familiar per capita superior a linha de extema pobreza
                        //R.5 Renda familiar per capita superior a linha de pobreza
                        $somatorio['valor_renda'] += $pessoa['valor_renda'];
                        //R.6 Maior parte da renda familiar não advém de transferências
                        $somatorio['valor_beneficio'] += $pessoa['valor_beneficio'];
                    }

                    foreach ($dimensao['habitacao'] as $indicador => $valor) {
                        $retorno = $this->calculaIndicadorDomicilio($domicilio['Domicilio'], $indicador, $dimensao[$nome][$indicador]);
                        $dimensao['habitacao'][$indicador] = $retorno['valor'];
                    }

                    //H.3 Densidade de até 2 moradores por dormitório
                    if (($contador['membros'] / $domicilio['Domicilio']['comodos']) > 2)
                        $dimensao['habitacao']['deficit']['h3'] = 0;

                    //V.9 Mais da metade dos membros encontra-se em idade ativa
                    if ($contador['idade_ativa'] < ($contador['membros'] / 2))
                        $dimensao['vulnerabilidade']['dependencia']['v9'] = 0;

                    //T.1 Mais da metade dos membros em idade ativa encontram-se ocupados
                    if ($contador['idade_ativa_ocupado'] > ($contador['idade_ativa'] / 2))
                        $dimensao['trabalho']['disponibilidade']['t1'] = 1;

                                       
                    /// SALVANDO OS DADOS
                    // Totalizar as medias por componente e Dimensao
                    $somatorio['idf'] = 0;
                    $contador['idf'] = 0;
                    foreach ($dimensao as $nomeDimensao => $componentes) {
                        $somatorio[$nomeDimensao] = 0;
                        $contador[$nomeDimensao] = 0;
                        foreach ($componentes as $nomeComponente => $indicadores) {
                            $this->data['Indice'][$nomeComponente] = array_sum($dimensao[$nomeDimensao][$nomeComponente]) / count($dimensao[$nomeDimensao][$nomeComponente]);
                            $somatorio[$nomeDimensao] += $this->data['Indice'][$nomeComponente];
                            $contador[$nomeDimensao]++;
                            foreach($indicadores as $nomeIndicador => $valor)
                                $this->data['Indice'][$nomeIndicador] = $valor;
                        }
                        $this->data['Indice'][$nomeDimensao] = $somatorio[$nomeDimensao] / $contador[$nomeDimensao];
                        $somatorio['idf'] += $this->data['Indice'][$nomeDimensao];
                        $contador['idf']++;
                    }

                    $this->data['Indice']['idf'] = $somatorio['idf'] / $contador['idf'];
                    $this->data['Indice']['codigo_domiciliar'] = $codigo_domiciliar;
                    $this->data['Domicilio']['idf'] = $this->data['Indice']['idf'];
                    //$this->data['IndicesHistorico'] = $this->data['Indice'];

                    if (!$this->Indice->save($this->data)) {
                        $retorno['status'] = 0;
                    }
                }
        }

        if ($atualizar != null) {
            $retorno['desatualizados'] = $this->Domicilio->find('count', array(
                'conditions' => array(
                    $this->pessoa_count . ' > 0',
                    'OR' => array(
                        'Indice.modified <' => date('Y-m-d'),
                        'Indice.modified IS NULL',
                    )
                )
                    ));
            echo json_encode($retorno);
            die();
        }
    }

    public function calculaIndicadorPessoa($pessoa, $indicador, $valor = null, $idade_min = null, $idade_max = null) {
        $usuario = false;
        if (($idade_min == null && $idade_max == null) || ($pessoa['idade'] >= $idade_min && $pessoa['idade'] < $idade_max)) {
            switch ($indicador) {
                
                
                
                
                
            }
        }
        return array('valor' => $valor,
            'nome' => $pessoa['nome'],
            'nis' => $pessoa['nis'],
            'usuario' => $usuario
        );
    }

    public function calculaIndicadorDomicilio($domicilio, $indicador, $valor = null) {

        $vulnerabilidade = false;

        switch ($indicador) {
            case 'h1': //H.1 Domicílio próprio
                if ($domicilio['situacao_domicilio'] != Domicilio::DOMICILIO_PROPRIO) {
                    $valor = 0;
                    $vulnerabilidade = true;
                }
                break;
            case 'h2': //H.2 Domicílio próprio, cedido ou invadido
                if ($domicilio['situacao_domicilio'] != Domicilio::DOMICILIO_PROPRIO &&
                        $domicilio['situacao_domicilio'] != Domicilio::DOMICILIO_CEDIDO &&
                        $domicilio['situacao_domicilio'] != Domicilio::DOMICILIO_ALUGADO) {
                    $valor = 0;
                    $vulnerabilidade = true;
                }
                break;
            case 'h4': //H.4 Material de construção permanente
                if ($domicilio['tipo_construcao'] != Domicilio::CONSTRUCAO_TIJOLO_ALVENARIA) {
                    $valor = 0;
                    $vulnerabilidade = true;
                }
                break;
            case 'h5': //H.5 Acesso adequado à água
                if ($domicilio['tipo_abastecimento'] != Domicilio::ABASTECIMENTO_REDE_PUBLICA) {
                    $valor = 0;
                    $vulnerabilidade = true;
                }
                break;
            case 'h6': //H.6 Esgotamento sanitário adequado
                if ($domicilio['escoamento_sanitario'] != Domicilio::ESCOAMENTO_REDE_PUBLICA) {
                    $valor = 0;
                    $vulnerabilidade = true;
                }
                break;
            case 'h7': //H.7 Lixo é coletado
                if ($domicilio['destino_lixo'] != Domicilio::LIXO_COLETADO) {
                    $valor = 0;
                    $vulnerabilidade = true;
                }
                break;
            case 'h8': //H.8 Acesso à eletricidade
                if ($domicilio['tipo_iluminacao'] != Domicilio::ILUMINACAO_RELOGIO_PROPRIO &&
                        $domicilio['tipo_iluminacao'] != Domicilio::ILUMINACAO_RELOGIO_COMUNITARIO) {
                    $valor = 0;
                    $vulnerabilidade = true;
                }
                break;
        }
        return array('valor' => $valor, 'vulnerabilidade' => $vulnerabilidade);
    }

    function beforeRender() {
        parent::beforeRender();
        $this->loadModel('Bairro');
        $this->loadModel('Cras');
        $this->loadModel('Regiao');
        $bairros = $this->Bairro->find('list', array('order' => 'Bairro.nome'));
        $cras = $this->Cras->find('list');
        $regioes = $this->Regiao->find('list');
        $this->set(compact('bairros', 'cras', 'regioes'));
    }

    function beforeFilter() {
        // executa o beforeFilter do AppController
        parent::beforeFilter();
        // adicione ao método allow as actions que quer permitir sem o usuário estar logado
        $this->Auth->allow(array('atualizarIndices'));
    }

}