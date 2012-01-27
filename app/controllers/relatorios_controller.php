<?php

class RelatoriosController extends AppController {

    var $name = 'Relatorios';
    var $uses = array('Pessoa', 'Domicilio', 'Indice');
    var $helpers = array('Javascript', 'Js');
    var $components = array('RequestHandler');

    function index() {
        $this->redirect(array('controller' => 'pages', 'action' => 'display'));
    }

    function mapaIdfCsv() {
        set_time_limit(0);

        $this->autoRender = false;

        $file['name'] = 'mapaIDF.csv';
        $file['tmp'] = TMP . substr(md5(microtime()), 0, 10);

        header('Content-type: text/csv');
        header('Content-Disposition: attachment;filename="' . $file['name'] . '"');
        header('Cache-Control: max-age=0');
        flush();

        $fw = fopen($file['tmp'], 'w');
        if ($fw != false) {
            $fr = fopen($file['tmp'], "r");
            if ($fr !== false) {
                $linha[] = 'COD_DOMICILIAR';
                $linha[] = 'IDF';
                $linha[] = 'V1';
                $linha[] = 'V2';
                $linha[] = 'GEST_AMAM';
                $linha[] = 'V3';
                $linha[] = 'V4';
                $linha[] = 'V5';
                $linha[] = 'CRI_ADOL_JOV';
                $linha[] = 'V6';
                $linha[] = 'V7';
                $linha[] = 'V7';
                $linha[] = 'IDOSO_DEFI';
                $linha[] = 'V8';
                $linha[] = 'V9';
                $linha[] = 'DEP_ECONO';
                $linha[] = 'VULNERABILIDADE';
                $linha[] = 'C1';
                $linha[] = 'C2';
                $linha[] = 'ANALFABETO';
                $linha[] = 'C3';
                $linha[] = 'C4';
                $linha[] = 'C5';
                $linha[] = 'ESCOLARIDADE';
                $linha[] = 'CONHECIMENTO';
                $linha[] = 'T1';
                $linha[] = 'DISP_TRAB';
                $linha[] = 'T2';
                $linha[] = 'T3';
                $linha[] = 'QUALID_TRAB';
                $linha[] = 'T4';
                $linha[] = 'T5';
                $linha[] = 'REMUNERA';
                $linha[] = 'TRABALHO';
                $linha[] = 'R1';
                $linha[] = 'R2';
                $linha[] = 'R3';
                $linha[] = 'EXT_POB';
                $linha[] = 'R4';
                $linha[] = 'R5';
                $linha[] = 'POB';
                $linha[] = 'R6';
                $linha[] = 'CAP_GER_RENDA';
                $linha[] = 'DISPON_RECURSO';
                $linha[] = 'D1';
                $linha[] = 'D2';
                $linha[] = 'TRAB_PREC';
                $linha[] = 'D3';
                $linha[] = 'D4';
                $linha[] = 'D5';
                $linha[] = 'ACESSO_ESCOLA';
                $linha[] = 'D6';
                $linha[] = 'D7';
                $linha[] = 'D8';
                $linha[] = 'PROGR_ESC';
                $linha[] = 'DESENV_INFANTIL';
                $linha[] = 'H1';
                $linha[] = 'H2';
                $linha[] = 'PROPRIO';
                $linha[] = 'H3';
                $linha[] = 'DEFICIT_HAB';
                $linha[] = 'H4';
                $linha[] = 'ABRIGO';
                $linha[] = 'H5';
                $linha[] = 'ACESSO_AGUA';
                $linha[] = 'H6';
                $linha[] = 'SANEAMENTO';
                $linha[] = 'H7';
                $linha[] = 'LIXO';
                $linha[] = 'H8';
                $linha[] = 'ELETRICIDADE';
                $linha[] = 'COND_HABIT';
                $linha[] = 'NIS_RESP_LEGAL';
                $linha[] = 'NOME_RESPONSAVEL_LEGAL';
                $linha[] = 'RENDA_FAMILIAR';
                $linha[] = 'QUANT_PESSOAS';
                $linha[] = 'RENDA_PER_CAPITA';
                $linha[] = 'BOLSA_FAMILIA';
                $linha[] = 'TIPO_LOGRADOURO';
                $linha[] = 'LOGRADOURO';
                $linha[] = 'NUMERO';
                $linha[] = 'COMPLEMENTO';
                $linha[] = 'BAIRRO';

                $size = fputcsv($fw, $linha, ';');

                $this->loadModel('Domicilio');
                $this->Domicilio->recursive = 0;
                $domicilios = $this->Domicilio->find('all', array(
                    'conditions' => array(
                        'Domicilio.quantidade_pessoas > 0',
                    ),
                    'fields' => array(
                        'Domicilio.codigo_domiciliar',
                        'Indice.*',
                        'Responsavel.nome',
                        'Responsavel.nis',
                        'Domicilio.valor_renda_familia',
                        'Domicilio.quantidade_pessoas',
                        'Domicilio.valor_beneficio',
                        'Domicilio.tipo_logradouro',
                        'Domicilio.logradouro',
                        'Domicilio.numero',
                        'Domicilio.complemento',
                        'Bairro.nome',
                    ),
                        )
                );
                
                foreach ($domicilios as $domicilio) {

                    print fread($fr, $size);
                    flush();

                    $linha = array();

                    $linha[] = $domicilio['Domicilio']['codigo_domiciliar'];
                    $linha[] = number_format($domicilio['Indice']['idf'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['v1'];
                    $linha[] = $domicilio['Domicilio']['v2'];
                    $linha[] = number_format($domicilio['Indice']['gestacao'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['v3'];
                    $linha[] = $domicilio['Domicilio']['v4'];
                    $linha[] = $domicilio['Domicilio']['v5'];
                    $linha[] = number_format($domicilio['Indice']['criancas'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['v6'];
                    $linha[] = $domicilio['Domicilio']['v7'];
                    $linha[] = number_format($domicilio['Indice']['idosos'], 2, ',', '.');
                    $linha[] = number_format($domicilio['Indice']['vulnerabilidade'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['c1'];
                    $linha[] = $domicilio['Domicilio']['c2'];
                    $linha[] = number_format($domicilio['Indice']['analfabetismo'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['c3'];
                    $linha[] = $domicilio['Domicilio']['c4'];
                    $linha[] = $domicilio['Domicilio']['c5'];
                    $linha[] = number_format($domicilio['Indice']['escolaridade'], 2, ',', '.');
                    $linha[] = number_format($domicilio['Indice']['conhecimento'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['t1'];
                    $linha[] = number_format($domicilio['Indice']['disponibilidade'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['t2'];
                    $linha[] = $domicilio['Domicilio']['t3'];
                    $linha[] = number_format($domicilio['Indice']['qualidade'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['t4'];
                    $linha[] = $domicilio['Domicilio']['t5'];
                    $linha[] = number_format($domicilio['Indice']['remuneracao'], 2, ',', '.');
                    $linha[] = number_format($domicilio['Indice']['trabalho'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['r1'];
                    $linha[] = $domicilio['Domicilio']['r2'];
                    $linha[] = $domicilio['Domicilio']['r3'];
                    $linha[] = number_format($domicilio['Indice']['extremaPobreza'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['r4'];
                    $linha[] = $domicilio['Domicilio']['r5'];
                    $linha[] = number_format($domicilio['Indice']['pobreza'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['r6'];
                    $linha[] = number_format($domicilio['Indice']['capacidadeGeracao'], 2, ',', '.');
                    $linha[] = number_format($domicilio['Indice']['recursos'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['d1'];
                    $linha[] = $domicilio['Domicilio']['d2'];
                    $linha[] = number_format($domicilio['Indice']['trabalhoPrecoce'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['d3'];
                    $linha[] = $domicilio['Domicilio']['d4'];
                    $linha[] = $domicilio['Domicilio']['d5'];
                    $linha[] = number_format($domicilio['Indice']['acessoEscola'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['d6'];
                    $linha[] = $domicilio['Domicilio']['d7'];
                    $linha[] = $domicilio['Domicilio']['d8'];
                    $linha[] = number_format($domicilio['Indice']['progressoEscolar'], 2, ',', '.');
                    $linha[] = number_format($domicilio['Indice']['desenvolvimento'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['h1'];
                    $linha[] = $domicilio['Domicilio']['h2'];
                    $linha[] = number_format($domicilio['Indice']['propriedade'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['h3'];
                    $linha[] = number_format($domicilio['Indice']['deficit'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['h4'];
                    $linha[] = number_format($domicilio['Indice']['abrigalidade'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['h5'];
                    $linha[] = number_format($domicilio['Indice']['acessoAgua'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['h6'];
                    $linha[] = number_format($domicilio['Indice']['acessoSaneamento'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['h7'];
                    $linha[] = number_format($domicilio['Indice']['acessoColetaLixo'], 2, ',', '.');
                    $linha[] = $domicilio['Domicilio']['h8'];
                    $linha[] = number_format($domicilio['Indice']['acessoEletricidade'], 2, ',', '.');
                    $linha[] = number_format($domicilio['Indice']['habitacao'], 2, ',', '.');
                    $linha[] = $domicilio['Responsavel']['nis'];
                    $linha[] = $domicilio['Responsavel']['nome'];
                    $linha[] = $domicilio['Domicilio']['valor_renda_familia'];
                    $linha[] = $domicilio['Domicilio']['quantidade_pessoas'];
                    $linha[] = $domicilio['Domicilio']['valor_renda_familia'] / $linha[] = $domicilio['Domicilio']['quantidade_pessoas'];
                    $linha[] = $domicilio['Domicilio']['valor_beneficio'];
                    $linha[] = $domicilio['Domicilio']['tipo_logradouro'];
                    $linha[] = $domicilio['Domicilio']['logradouro'];
                    $linha[] = $domicilio['Domicilio']['numero'];
                    $linha[] = $domicilio['Domicilio']['complemento'];
                    $linha[] = $domicilio['Bairro']['nome'];
                    
                    $size = fputcsv($fw, $linha, ';');
                }

                print fread($fr, $size);

                fclose($fw);
                fclose($fr);
                ob_clean();
            } else {
                $this->Session->setFlash('Erro ao abrir o arquivo para leitura!');
                $this->redirect(array('controller' => 'indices', 'action' => 'index'));
            }
            unlink($file['tmp']);
        } else {
            $this->Session->setFlash('Erro ao abrir o arquivo para escrita!');
            $this->redirect(array('controller' => 'indices', 'action' => 'index'));
        }
    }

    function trabalhoEmprego() {
        $idade = "(YEAR(CURDATE())-YEAR(Pessoa.data_nascimento))-(RIGHT(CURDATE(),5)<RIGHT(Pessoa.data_nascimento,5))";
        $options = array(
            'recursive' => -1,
            'joins' => array(
                array('table' => 'faixas_etarias',
                    'alias' => 'FaixasEtaria',
                    'type' => 'INNER',
                    'conditions' => array(
                        'CASE WHEN ' . $idade . ' > 80 THEN FaixasEtaria.idade = 80 ELSE FaixasEtaria.idade = ' . $idade . 'END',
                    )
                ),
                array('table' => 'domicilios',
                    'alias' => 'Domicilio',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Pessoa.codigo_domiciliar = Domicilio.codigo_domiciliar',
                    )
                ),
            ),
            'fields' => array(
                'COUNT(FaixasEtaria.id) AS total',
                'Pessoa.tipo_trabalho',
                'FaixasEtaria.descricao',
                'FaixasEtaria.faixa',
            ),
            'conditions' => array(
            ),
            'group' => array(
                'Pessoa.tipo_trabalho',
                'FaixasEtaria.descricao',
            ),
            'order' => array(
                'FaixasEtaria.idade',
            ),
        );

        switch ($this->data['Relatorio']['filtro']) {
            case 'regiao_id':
                $options['fields'][] = 'Domicilio.regiao_id';
                $options['conditions'] = array(
                    'Domicilio.regiao_id' => $this->data['Relatorio']['regiao_id']
                );
                break;
            case 'cras_id':
                $options['fields'][] = 'Domicilio.cras_id';
                $options['conditions'] = array(
                    'Domicilio.cras_id' => $this->data['Relatorio']['cras_id']
                );
                break;
            case 'bairro_id':
                $options['fields'][] = 'Domicilio.bairro_id';
                $options['conditions'] = array(
                    'Domicilio.bairro_id' => $this->data['Relatorio']['bairro_id']
                );
                break;
        }


        $inicio = microtime(true);
        $pessoas = $this->Pessoa->find('all', $options);

        $faixaEtaria['tempo'] = microtime(true) - $inicio;
        $faixaEtaria['total'] = $this->Pessoa->find('count', $options);
        foreach ($pessoas as $faixa) {
            $faixaEtaria[$faixa['FaixasEtaria']['faixa']][$faixa['Pessoa']['tipo_trabalho']][$faixa['FaixasEtaria']['descricao']] = $faixa[0]['total'];
        }

        $bairros = $this->Domicilio->Bairro->find('list', array('order' => 'Bairro.nome'));
        $cras = $this->Domicilio->Cras->find('list');
        $regioes = $this->Domicilio->Regiao->find('list');

        $this->set(compact('faixaEtaria', 'bairros', 'cras', 'regioes', 'domicilios'));
    }

    function faixasEtarias() {
        $idade = "(YEAR(CURDATE())-YEAR(Pessoa.data_nascimento))-(RIGHT(CURDATE(),5)<RIGHT(Pessoa.data_nascimento,5))";
        $options = array(
            'recursive' => -1,
            'joins' => array(
                array('table' => 'faixas_etarias',
                    'alias' => 'FaixasEtaria',
                    'type' => 'INNER',
                    'conditions' => array(
                        'CASE WHEN ' . $idade . ' > 80 THEN FaixasEtaria.idade = 80 ELSE FaixasEtaria.idade = ' . $idade . 'END',
                    )
                ),
                array('table' => 'domicilios',
                    'alias' => 'Domicilio',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Pessoa.codigo_domiciliar = Domicilio.codigo_domiciliar',
                    )
                ),
            ),
            'conditions' => array(
                'Domicilio.quantidade_pessoas > 0'
            ),
            'fields' => array(
                'COUNT(FaixasEtaria.id) AS total',
                'Pessoa.genero',
                'FaixasEtaria.descricao',
                'FaixasEtaria.faixa',
            ),
            'group' => array(
                'Pessoa.genero',
                'FaixasEtaria.descricao',
            ),
            'order' => array(
                'FaixasEtaria.idade',
            ),
        );

        switch ($this->data['Relatorio']['filtro']) {
            case 'regiao_id':
                $options['fields'][] = 'Domicilio.regiao_id';
                $options['conditions'] = array(
                    'Domicilio.regiao_id' => $this->data['Relatorio']['regiao_id'],
                    'Domicilio.quantidade_pessoas > 0'
                );
                break;
            case 'cras_id':
                $options['fields'][] = 'Domicilio.cras_id';
                $options['conditions'] = array(
                    'Domicilio.cras_id' => $this->data['Relatorio']['cras_id'],
                    'Domicilio.quantidade_pessoas > 0'
                );
                break;
            case 'bairro_id':
                $options['fields'][] = 'Domicilio.bairro_id';
                $options['conditions'] = array(
                    'Domicilio.bairro_id' => $this->data['Relatorio']['bairro_id'],
                    'Domicilio.quantidade_pessoas > 0'
                );
                break;
        }

        $inicio = microtime(true);
        $pessoas = $this->Pessoa->find('all', $options);

        unset($options['order']);
        unset($options['group']);
        unset($options['fields']);

        $faixaEtaria['total'] = $this->Pessoa->find('count', $options);

        $faixaEtaria['tempo'] = microtime(true) - $inicio;

        foreach ($pessoas as $faixa) {
            $faixaEtaria
                    [$faixa['FaixasEtaria']['faixa']]
                    [$faixa['Pessoa']['genero']]
                    [$faixa['FaixasEtaria']['descricao']] = $faixa[0]['total'];
            //Totalizador por faixa etária
            //IF usado para corrigir erro de variável não setada usando +=
            if (!isset($faixaEtaria[$faixa['FaixasEtaria']['faixa']]['total']))
                $faixaEtaria[$faixa['FaixasEtaria']['faixa']]['total'] = $faixa[0]['total'];
            else
                $faixaEtaria[$faixa['FaixasEtaria']['faixa']]['total'] += $faixa[0]['total'];
            //Totalizador por faixa etária / descricao
            //IF usado para corrigir erro de variável não setada usando +=
            if (!isset($faixaEtaria[$faixa['FaixasEtaria']['faixa']][$faixa['FaixasEtaria']['descricao']]))
                $faixaEtaria[$faixa['FaixasEtaria']['faixa']][$faixa['FaixasEtaria']['descricao']] = $faixa[0]['total'];
            else
                $faixaEtaria[$faixa['FaixasEtaria']['faixa']][$faixa['FaixasEtaria']['descricao']] += $faixa[0]['total'];
            //Totalizador por faixa etária / genero
            //IF usado para corrigir erro de variável não setada usando +=
            if (!isset($faixaEtaria[$faixa['FaixasEtaria']['faixa']][$faixa['Pessoa']['genero']]['total']))
                $faixaEtaria[$faixa['FaixasEtaria']['faixa']][$faixa['Pessoa']['genero']]['total'] = $faixa[0]['total'];
            else
                $faixaEtaria[$faixa['FaixasEtaria']['faixa']][$faixa['Pessoa']['genero']]['total'] += $faixa[0]['total'];
            //Totalizador por  genero
            //IF usado para corrigir erro de variável não setada usando +=
            if (!isset($faixaEtaria[$faixa['Pessoa']['genero']]))
                $faixaEtaria[$faixa['Pessoa']['genero']] = $faixa[0]['total'];
            else
                $faixaEtaria[$faixa['Pessoa']['genero']] += $faixa[0]['total'];
        }

        $bairros = $this->Domicilio->Bairro->find('list', array(
            'order' => 'Bairro.nome'
                ));
        $cras = $this->Domicilio->Cras->find('list');
        $regioes = $this->Domicilio->Regiao->find('list');

//        $this->loadModel('Domicilio');
//        $options['fields'] = array();
        $domicilios = $this->Domicilio->find('count', array($options));
//        var_dump($domicilios); die();

        $this->set(compact('faixaEtaria', 'bairros', 'cras', 'regioes', 'domicilios'));
    }

    function valorRemuneracao() {
        $idade = "(YEAR(CURDATE())-YEAR(Pessoa.data_nascimento))-(RIGHT(CURDATE(),5)<RIGHT(Pessoa.data_nascimento,5))";
        $options = array(
            'recursive' => -1,
            'joins' => array(
                array('table' => 'faixas_etarias',
                    'alias' => 'FaixasEtaria',
                    'type' => 'INNER',
                    'conditions' => array(
                        'CASE WHEN ' . $idade . ' > 80 THEN FaixasEtaria.idade = 80 ELSE FaixasEtaria.idade = ' . $idade . 'END',
                    )
                ),
                array('table' => 'domicilios',
                    'alias' => 'Domicilio',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Pessoa.codigo_domiciliar = Domicilio.codigo_domiciliar',
                    )
                ),
            ),
            'fields' => array(
                'COUNT(FaixasEtaria.id) AS total',
                '(CASE
                    WHEN Pessoa.valor_remuneracao = 0 THEN "0 reais"
                    WHEN Pessoa.valor_remuneracao BETWEEN 0.01 AND 70 THEN "ate 70 reais"
                    WHEN Pessoa.valor_remuneracao BETWEEN 70.01 AND 140 THEN "70 a 140 reais"
                    WHEN Pessoa.valor_remuneracao BETWEEN 140.01 AND 240 THEN "140 a 240 reais"
                    WHEN Pessoa.valor_remuneracao BETWEEN 240.01 AND 545 THEN "240 a 545 reais"
                    WHEN Pessoa.valor_remuneracao > 545 THEN "acima 545 reais"
                 END) AS remuneracao',
                'FaixasEtaria.descricao',
                'FaixasEtaria.faixa',
            ),
            'group' => array(
                'remuneracao',
                'FaixasEtaria.descricao',
            ),
            'order' => array(
                'FaixasEtaria.idade',
            ),
        );

        switch ($this->data['Relatorio']['filtro']) {
            case 'regiao_id':
                $options['fields'][] = 'Domicilio.regiao_id';
                $options['conditions'] = array(
                    'Domicilio.regiao_id' => $this->data['Relatorio']['regiao_id']
                );
                break;
            case 'cras_id':
                $options['fields'][] = 'Domicilio.cras_id';
                $options['conditions'] = array(
                    'Domicilio.cras_id' => $this->data['Relatorio']['cras_id']
                );
                break;
            case 'bairro_id':
                $options['fields'][] = 'Domicilio.bairro_id';
                $options['conditions'] = array(
                    'Domicilio.bairro_id' => $this->data['Relatorio']['bairro_id']
                );
                break;
        }

        $inicio = microtime(true);
        $pessoas = $this->Pessoa->find('all', $options);

        $valorRemuneracao['tempo'] = microtime(true) - $inicio;
        $valorRemuneracao['total'] = $this->Pessoa->find('count', $options);
        foreach ($pessoas as $remuneracao) {
            $valorRemuneracao
                    [$remuneracao['FaixasEtaria']['faixa']]
                    [$remuneracao[0]['remuneracao']]
                    [$remuneracao['FaixasEtaria']['descricao']] = $remuneracao[0]['total'];
        }

        $bairros = $this->Domicilio->Bairro->find('list', array(
            'order' => 'Bairro.nome'
                ));
        $cras = $this->Domicilio->Cras->find('list');
        $regioes = $this->Domicilio->Regiao->find('list');

        $this->set(compact('valorRemuneracao', 'bairros', 'cras', 'regioes'));
    }

    function educacaoFormal() {

        $serie_escolar = '(CASE';
        $serie_escolar .= ' WHEN grau_instrucao = ' . Pessoa::ESCOLARIDADE_ANALFABETO . ' THEN "analfabeto"';
        $serie_escolar .= ' WHEN serie_escolar = ' . Pessoa::SERIE_CA_ALFABETIZACAO . ' THEN "alfabetizacao"';
        $serie_escolar .= ' WHEN serie_escolar BETWEEN ' . Pessoa::SERIE_MATERNAL_I . ' AND ' . Pessoa::SERIE_MATERNAL_III . ' THEN "maternal"';
        $serie_escolar .= ' WHEN serie_escolar BETWEEN ' . Pessoa::SERIE_JARDIM_I . ' AND ' . Pessoa::SERIE_JARDIM_III . ' THEN "jardim"';
        $serie_escolar .= ' WHEN serie_escolar BETWEEN ' . Pessoa::SERIE_1_ENSINO_FUNDAMENTAL . ' AND ' . Pessoa::SERIE_2_ENSINO_FUNDAMENTAL . ' THEN "1 a 2 ano"';
        $serie_escolar .= ' WHEN serie_escolar BETWEEN ' . Pessoa::SERIE_3_ENSINO_FUNDAMENTAL . ' AND ' . Pessoa::SERIE_4_ENSINO_FUNDAMENTAL . ' THEN "3 a 4 ano"';
        $serie_escolar .= ' WHEN serie_escolar BETWEEN ' . Pessoa::SERIE_5_ENSINO_FUNDAMENTAL . ' AND ' . Pessoa::SERIE_6_ENSINO_FUNDAMENTAL . ' THEN "5 a 6 ano"';
        $serie_escolar .= ' WHEN serie_escolar BETWEEN ' . Pessoa::SERIE_7_ENSINO_FUNDAMENTAL . ' AND ' . Pessoa::SERIE_8_ENSINO_FUNDAMENTAL . ' THEN "7 a 8 ano"';
        $serie_escolar .= ' WHEN serie_escolar = ' . Pessoa::SERIE_1_ENSINO_MEDIO . ' THEN "1 ano medio"';
        $serie_escolar .= ' WHEN serie_escolar = ' . Pessoa::SERIE_2_ENSINO_MEDIO . ' THEN "2 ano medio"';
        $serie_escolar .= ' WHEN serie_escolar = ' . Pessoa::SERIE_3_ENSINO_MEDIO . ' THEN "3 ano medio"';
        $serie_escolar .= ' WHEN grau_instrucao >= ' . Pessoa::ESCOLARIDADE_SUPERIOR_INCOMPLETO . ' THEN "ensino superior"';
        $serie_escolar .= ' WHEN serie_escolar = ' . Pessoa::SERIE_NAO_INFORMADO . ' THEN "nao informado"';
        $serie_escolar .= ' END) AS educacao_formal';

        $idade = "(YEAR(CURDATE())-YEAR(Pessoa.data_nascimento))-(RIGHT(CURDATE(),5)<RIGHT(Pessoa.data_nascimento,5))";

        $options = array(
            'recursive' => -1,
            'joins' => array(
                array('table' => 'faixas_etarias',
                    'alias' => 'FaixasEtaria',
                    'type' => 'INNER',
                    'conditions' => array(
                        'CASE WHEN ' . $idade . ' > 80 THEN FaixasEtaria.idade = 80 ELSE FaixasEtaria.idade = ' . $idade . 'END',
                    )
                ),
                array('table' => 'domicilios',
                    'alias' => 'Domicilio',
                    'type' => 'INNER',
                    'conditions' => array(
                        'Pessoa.codigo_domiciliar = Domicilio.codigo_domiciliar',
                    )
                ),
            ),
            'fields' => array(
                'COUNT(FaixasEtaria.id) AS total',
                $serie_escolar,
                'FaixasEtaria.descricao',
                'FaixasEtaria.faixa',
            ),
            'group' => array(
                'educacao_formal',
                'FaixasEtaria.descricao',
            ),
            'order' => array(
                'FaixasEtaria.idade',
            ),
            'conditions' => array(
//            'grau_instrucao >= ' => Pessoa::ESCOLARIDADE_SUPERIOR_INCOMPLETO,
            )
        );

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

        $inicio = microtime(true);
        $pessoas = $this->Pessoa->find('all', $options);

        $educacaoFormal['tempo'] = microtime(true) - $inicio;
        $educacaoFormal['total'] = $this->Pessoa->find('count', array('conditions' => array('Domicilio.quantidade_pessoas > 0',)));
        foreach ($pessoas as $educacao) {
            $educacaoFormal
                    [$educacao['FaixasEtaria']['faixa']]
                    [$educacao[0]['educacao_formal']]
                    [$educacao['FaixasEtaria']['descricao']] = $educacao[0]['total'];
            $educacaoFormal[$educacao[0]['educacao_formal']] += $educacao[0]['total'];
        }

        $bairros = $this->Domicilio->Bairro->find('list', array(
            'order' => 'Bairro.nome'
                ));
        $cras = $this->Domicilio->Cras->find('list');
        $regioes = $this->Domicilio->Regiao->find('list');

        $this->set(compact('educacaoFormal', 'bairros', 'cras', 'regioes'));
    }

}