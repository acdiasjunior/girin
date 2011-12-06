<?php

class IndicesController extends AppController {

    var $name = 'Indices';
    var $helpers = array('Javascript', 'Js');
    var $components = array('RequestHandler');

    function index() {
        //$indices = $this->Indice->query("SELECT AVG(idf) as media, MAX(idf) as maximo, MIN(idf) as minimo FROM indices;");

        /* SELECT bairros.id, bairros.nome, AVG( indices.idf ) AS idf, AVG( `vulnerabilidade` ) AS vulnerabilidade,
         *  AVG( `conhecimento` ) AS conhecimento, AVG( `trabalho` ) AS trabalho, AVG( `recursos` ) AS recursos,
         *  AVG( `desenvolvimento` )AS desenvolvimento, AVG( `habitacao` ) AS habitacao
          FROM indices
          INNER JOIN domicilios ON domicilios.codigo_domiciliar = indices.codigo_domiciliar
          INNER JOIN bairros ON bairros.id = domicilios.bairro_id
          GROUP BY bairros.id */

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
            $options['fields'][] = "AVG($indicador) AS $indicador";

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
                $retorno['total'] = $this->Domicilio->find('count', array('conditions' => array('Domicilio.pessoa_count != 0', 'Domicilio.pessoa_count IS NOT NULL')));
                break;
            case 'desatualizados':
                $retorno['desatualizados'] = $this->Domicilio->find('count', array(
                    'conditions' => array(
                        'Domicilio.pessoa_count != 0',
                        'Domicilio.pessoa_count IS NOT NULL',
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
                        'Domicilio.pessoa_count != 0',
                        'Domicilio.pessoa_count IS NOT NULL',
                        'OR' => array(
                            'Indice.modified <' => date('Y-m-d'),
                            'Indice.modified IS NULL',
                        )
                    ),
                    'limit' => $limite,
                        )
                );
                foreach ($domicilios as $codigo_domiciliar) {

                    set_time_limit(2);

                    $this->data = array();

                    $this->Domicilio->id = $codigo_domiciliar;
                    $domicilio = $this->Domicilio->read();

                    $contador = array('idade_ativa' => 0, 'idade_ativa_ocupado' => 0, 'membros' => 0);
                    $somatorio = array('valor_renda' => 0, 'valor_beneficio' => 0);

                    $dimensao = $this->Indice->dimensoes;

                    foreach ($domicilio['Pessoa'] as $pessoa) {

                        $contador['membros']++;

                        //V.5  Ausência de crianças, adolescente e jovens
                        if ($pessoa['idade'] < Pessoa::IDADE_ADULTO) {
                            $dimensao['vulnerabilidade']['v5'] = 0;

                            //V.4 Ausência de crianças e adolescente
                            if ($pessoa['idade'] < Pessoa::IDADE_JOVEM) {
                                $dimensao['vulnerabilidade']['v4'] = 0;

                                //V.3 Ausência de crianças
                                if ($pessoa['idade'] < Pessoa::IDADE_ADOLESCENTE) {
                                    $dimensao['vulnerabilidade']['v3'] = 0;
                                }
                            }
                        }

                        //V.7 Ausência de Idosos
                        if ($pessoa['idade'] >= Pessoa::IDADE_IDOSO)
                            $dimensao['vulnerabilidade']['v7'] = 0;

                        //V.9 Mais da metade dos membros encontra-se em idade ativa
                        if ($pessoa['idade'] >= Pessoa::IDADE_ADOLESCENTE)
                            $contador['idade_ativa']++;

                        //C.2 Ausência de Adultos Analfabetos Funcionais
                        if ($pessoa['idade'] >= Pessoa::IDADE_ADULTO && $pessoa['grau_instrucao'] < Pessoa::ESCOLARIDADE_4A_COMPLETA) {
                            $dimensao['conhecimento']['c2'] = 0;
                            //C.1 Ausência de Adultos Analfabetos
                            if ($pessoa['grau_instrucao'] < Pessoa::ESCOLARIDADE_ATE_4A_INCOMPLETA) {
                                $dimensao['conhecimento']['c1'] = 0;
                            }
                        }

                        //C.3 Presença de pelo menos um adulto com fundamental completo
                        if ($pessoa['idade'] >= Pessoa::IDADE_ADULTO && $pessoa['grau_instrucao'] >= Pessoa::ESCOLARIDADE_FUNDAMENTAL_COMPLETO) {
                            $dimensao['conhecimento']['c3'] = 1;

                            //C.4 Presença de pelo menos um adulto com secundário completo
                            if ($pessoa['grau_instrucao'] >= Pessoa::ESCOLARIDADE_MEDIO_COMPLETO) {
                                $dimensao['conhecimento']['c4'] = 1;

                                //C.5 Presença de pelo menos um adulto com alguma educação superior
                                if ($pessoa['grau_instrucao'] >= Pessoa::ESCOLARIDADE_SUPERIOR_INCOMPLETO) {
                                    $dimensao['conhecimento']['c5'] = 1;
                                }
                            }
                        }

                        //T.1 Mais da metade dos membros em idade ativa encontram-se ocupados
                        if ($pessoa['idade'] >= Pessoa::IDADE_ADOLESCENTE && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA)
                            $contador['idade_ativa_ocupado']++;

                        //T.2 Presença de pelo menos um ocupado no setor formal
                        if ($pessoa['tipo_trabalho'] == Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA || $pessoa['tipo_trabalho'] == Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA) {
                            $dimensao['trabalho']['t2'] = 1;
                        }

                        //T.3 Presença de pelo menos um ocupado em atividade não agrícola
                        if ($dimensao['trabalho']['t2'] == 1 || $pessoa['tipo_trabalho'] == Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA
                                || $pessoa['tipo_trabalho'] == Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA
                                || $pessoa['tipo_trabalho'] == Pessoa::TRABALHO_EMPREGADOR
                                || $pessoa['tipo_trabalho'] == Pessoa::TRABALHO_OUTRA)
                            $dimensao['trabalho']['t3'] = 1;

                        //T.4 Presença de pelo menos um ocupado com rendimento superior a 1 salário mínimo
                        if ($pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA && $pessoa['valor_renda'] > 545) {
                            $dimensao['trabalho']['t4'] = 1;

                            //T.5 Presença de pelo menos um ocupado com rendimento superior a 2 salários mínimos
                            if ($pessoa['valor_renda'] > (545 * 2)) {
                                $dimensao['trabalho']['t5'] = 1;
                            }
                        }

                        //R.2 Renda familiar per capita superior a linha de extema pobreza
                        //R.5 Renda familiar per capita superior a linha de pobreza
                        $somatorio['valor_renda'] += $pessoa['valor_renda'];
                        //R.6 Maior parte da renda familiar não advém de transferências
                        $somatorio['valor_beneficio'] += $pessoa['valor_beneficio'];

                        //D.2 Ausência de pelo menos uma criança de menos de 16 anos de trabalhando
                        if ($pessoa['idade'] < 16 && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA) {
                            $dimensao['desenvolvimento']['d2'] = 0;
                            //D.1 Ausência de pelo menos uma criança de menos de 10 anos de trabalhando
                            if ($pessoa['idade'] < 10 && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA) {
                                $dimensao['desenvolvimento']['d1'] = 0;
                            }
                        }

                        //D.5 Ausência de pelo menos uma criança de 7-17 anos fora da escola
                        if ($pessoa['idade'] >= 7 && $pessoa['idade'] <= 17 && $pessoa['frequenta_escola'] != Pessoa::ESCOLA_NAO_FREQUENTA) {
                            $dimensao['desenvolvimento']['d5'] = 0;
                            //D.4 Ausência de pelo menos uma criança de 7-14 anos fora da escola
                            if ($pessoa['idade'] >= 7 && $pessoa['idade'] <= 14 && $pessoa['frequenta_escola'] != Pessoa::ESCOLA_NAO_FREQUENTA) {
                                $dimensao['desenvolvimento']['d4'] = 0;
                                //D.3 Ausência de pelo menos uma criança de 0-6 anos fora da escola
                                if ($pessoa['idade'] <= 6 && $pessoa['frequenta_escola'] != Pessoa::ESCOLA_NAO_FREQUENTA) {
                                    $dimensao['desenvolvimento']['d3'] = 0;
                                }
                            }
                        }

                        //NAO D.6 Ausência de pelo menos uma criança com até 14 anos com mais de 2 anos de atraso
                        if ($pessoa['idade'] >= 7 && $pessoa['idade'] <= 14)
                            if ($pessoa['serie_escolar'] - $pessoa['idade'] < 0)
                                $dimensao['desenvolvimento']['d6'] = 0;

                        //D.7 Ausência de pelo menos um adolescente de 10 a 14 anos analfabeto
                        if ($pessoa['idade'] >= 10 && $pessoa['idade'] <= 14 && $pessoa['grau_instrucao'] != Pessoa::ESCOLARIDADE_ANALFABETO)
                            $dimensao['desenvolvimento']['d7'] = 0;

                        //D.8 Ausência de pelo menos um jovem de 15 a 17 anos analfabeto
                        if ($pessoa['idade'] >= 15 && $pessoa['idade'] <= 17 && $pessoa['grau_instrucao'] != Pessoa::ESCOLARIDADE_ANALFABETO)
                            $dimensao['desenvolvimento']['d8'] = 0;
                    }

                    //V.9 Mais da metade dos membros encontra-se em idade ativa
                    if ($contador['idade_ativa'] < ($contador['membros'] / 2))
                        $dimensao['vulnerabilidade']['v9'] = 0;

                    //T.1 Mais da metade dos membros em idade ativa encontram-se ocupados
                    if ($contador['idade_ativa_ocupado'] > ($contador['idade_ativa'] / 2))
                        $dimensao['trabalho']['t1'] = 1;

                    //R.5 Renda familiar per capita superior a linha de pobreza
                    if (($somatorio['valor_renda'] + $somatorio['valor_beneficio']) / $contador['membros'] < 140) {
                        $dimensao['recursos']['r5'] = 0;
                        //R.2 Renda familiar per capita superior a linha de extema pobreza
                        if (($somatorio['valor_renda'] + $somatorio['valor_beneficio']) / $contador['membros'] < 70) {
                            $dimensao['recursos']['r2'] = 0;
                        }
                    }

                    //R.6 Maior parte da renda familiar não advém de transferências
                    if ($somatorio['valor_renda'] < $somatorio['valor_beneficio'])
                        $dimensao['recursos']['r6'] = 0;

                    //H.1 Domicílio próprio
                    if ($domicilio['Domicilio']['situacao_domicilio'] != Domicilio::DOMICILIO_PROPRIO)
                        $dimensao['habitacao']['h1'] = 0;

                    //H.2 Domicílio próprio, cedido ou invadido
                    if ($domicilio['Domicilio']['situacao_domicilio'] != Domicilio::DOMICILIO_PROPRIO &&
                            $domicilio['Domicilio']['situacao_domicilio'] != Domicilio::DOMICILIO_CEDIDO &&
                            $domicilio['Domicilio']['situacao_domicilio'] != Domicilio::DOMICILIO_ALUGADO)
                        $dimensao['habitacao']['h2'] = 0;

                    //H.3 Densidade de até 2 moradores por dormitório
                    if (($contador['membros'] / $domicilio['Domicilio']['comodos']) > 2)
                        $dimensao['habitacao']['h3'] = 0;

                    //H.4 Material de construção permanente
                    if ($domicilio['Domicilio']['tipo_construcao'] != Domicilio::CONSTRUCAO_TIJOLO_ALVENARIA)
                        $dimensao['habitacao']['h4'] = 0;

                    //H.5 Acesso adequado à água
                    if ($domicilio['Domicilio']['tipo_abastecimento'] != Domicilio::ABASTECIMENTO_REDE_PUBLICA)
                        $dimensao['habitacao']['h5'] = 0;

                    //H.6 Esgotamento sanitário adequado
                    if ($domicilio['Domicilio']['escoamento_sanitario'] != Domicilio::ESCOAMENTO_REDE_PUBLICA)
                        $dimensao['habitacao']['h6'] = 0;

                    //H.7 Lixo é coletado
                    if ($domicilio['Domicilio']['destino_lixo'] != Domicilio::LIXO_COLETADO)
                        $dimensao['habitacao']['h7'] = 0;

                    //H.8 Acesso à eletricidade
                    if ($domicilio['Domicilio']['tipo_iluminacao'] != Domicilio::ILUMINACAO_RELOGIO_PROPRIO &&
                            $domicilio['Domicilio']['tipo_iluminacao'] != Domicilio::ILUMINACAO_RELOGIO_COMUNITARIO)
                        $dimensao['habitacao']['h8'] = 0;

                    //NAO V.1 Ausência de Gestantes
                    //NAO V.2 Ausência de Mães Amamentando
                    //NAO V.6 Ausência de portadores de deficiência
                    //NAO V.8 Presença de cônjuge
                    //NAO R.1 Despesa familiar per capita superior a linha de extema pobreza
                    //NAO R.3 Despesa com alimentos superior a linha de extema pobreza
                    //NAO R.4 Despesa familiar per capita superior a linha de pobreza
                    /// SALVANDO OS DADOS
                    foreach ($dimensao as $key => $value)
                        foreach ($value as $k => $v)
                            $this->data['Indice'][$k] = $v;

                    $this->data['Indice']['idf'] = array_sum($this->data['Indice']) / count($this->data['Indice']);
                    $this->data['Indice']['codigo_domiciliar'] = $codigo_domiciliar;

                    $this->data['Domicilio']['codigo_domiciliar'] = $this->data['Indice']['codigo_domiciliar'];
                    $this->data['Domicilio']['idf'] = $this->data['Indice']['idf'];

                    foreach ($dimensao as $key => $value)
                        $this->data['Indice'][$key] = array_sum($dimensao[$key]) / count($dimensao[$key]);

                    $this->data['IndicesHistorico'] = $this->data['Indice'];

                    if (!$this->Indice->saveAll($this->data)) {
                        $retorno['status'] = 0;
                    }
                }
        }
        if ($atualizar != null) {
            $retorno['desatualizados'] = $this->Domicilio->find('count', array(
                'conditions' => array(
                    'Domicilio.pessoa_count != 0',
                    'Domicilio.pessoa_count IS NOT NULL',
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