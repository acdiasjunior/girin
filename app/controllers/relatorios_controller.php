<?php

class RelatoriosController extends AppController {

    var $name = 'Relatorios';
    var $uses = array('Pessoa', 'Domicilio', 'Indice');
    var $helpers = array('Javascript', 'Js');
    var $components = array('RequestHandler');

    function index() {
        parent::temAcesso();
        $this->redirect(array('controller' => 'pages', 'action' => 'display'));
    }

    function mapaIdfCsv() {
        parent::temAcesso();
        set_time_limit(0);

        $this->autoRender = false;

        $file['name'] = 'mapaIDF.csv';
        $file['tmp'] = TMP . substr(md5(microtime()), 0, 10);

        $this->loadModel('Domicilio');
        $quant = $this->Domicilio->find('count');

        header('Content-type: text/csv');
        header('Content-Disposition: attachment;filename="' . $file['name'] . '"');
        header('Cache-Control: max-age=0');
        header("Content-length: " . $quant * 380);
        flush();

        $fw = fopen($file['tmp'], 'w');
        if ($fw != false) {
            $fr = fopen($file['tmp'], "r");
            if ($fr !== false) {
                $linha = array('COD_DOMICILIAR', 'VLR_IDF', 'V1', 'V2', 'GEST_AMAM', 'V3', 'V4', 'V5', 'CRI_ADOL_JOV', 'V6', 'V7',
                    'IDOSO_DEFI', 'V8', 'V9', 'DEP_ECONO', 'VULNERABILIDADE', 'C1', 'C2', 'ANALFABETO', 'C3', 'C4', 'C5', 'ESCOLARIDADE',
                    'CONHECIMENTO', 'T1', 'DISP_TRAB', 'T2', 'T3', 'QUALID_TRAB', 'T4', 'T5', 'REMUNERA', 'TRABALHO', 'R1', 'R2',
                    'R3', 'EXT_POB', 'R4', 'R5', 'POB', 'R6', 'CAP_GER_RENDA', 'DISPON_RECURSO', 'D1', 'D2', 'TRAB_PREC', 'D3',
                    'D4', 'D5', 'ACESSO_ESCOLA', 'D6', 'D7', 'D8', 'PROGR_ESC', 'DESENV_INFANTIL', 'H1', 'H2', 'PROPRIO', 'H3',
                    'DEFICIT_HAB', 'H4', 'ABRIGO', 'H5', 'ACESSO_AGUA', 'H6', 'SANEAMENTO', 'H7', 'LIXO', 'H8', 'ELETRICIDADE',
                    'COND_HABIT', 'NIS_RESP_LEGAL', 'NOME_RESPONSAVEL_LEGAL', 'RENDA_FAMILIAR', 'QUANT_PESSOAS', 'RENDA_PER_CAPITA',
                    'BOLSA_FAMILIA', 'tp_LOGRADOURO', 'LOGRADOURO', 'NUMERO', 'COMPLEMENTO', 'BAIRRO', 'CRAS', 'REGIAO');

                $size = fputcsv($fw, $linha, ';');

                $cache = 200;

                for ($i = 1; $i <= ceil($quant / $cache); $i++) {
                    $this->paginate = array(
                        'fields' => array(
                            'Domicilio.cod_domiciliar',
                            'Indice.*',
                            'Responsavel.nome',
                            'Responsavel.nis',
                            'Domicilio.vlr_renda_familia',
                            'Domicilio.qtd_pessoa',
                            'Domicilio.vlr_beneficio',
                            'Domicilio.end_tipo',
                            'Domicilio.end_logradouro',
                            'Domicilio.end_num',
                            'Domicilio.end_compl',
                            'Bairro.nome_bairro',
                            'Cras.desc_cras',
                            'Regiao.descricao'
                        ),
                        'page' => $i,
                        'limit' => $cache,
                        'order' => array(
                            'Domicilio.cod_domiciliar' => 'asc'
                        )
                    );
                    $domicilios = $this->paginate('Domicilio');

                    foreach ($domicilios as $domicilio) {

                        print fread($fr, $size);
                        flush();

                        $linha = array();
                        $linha[] = $domicilio['Domicilio']['cod_domiciliar'];
                        $linha[] = number_format($domicilio['Indice']['vlr_idf'], 5, ',', '.');
                        $linha[] = $domicilio['Indice']['v1'];
                        $linha[] = $domicilio['Indice']['v2'];
                        $linha[] = number_format($domicilio['Indice']['gestacao'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['v3'];
                        $linha[] = $domicilio['Indice']['v4'];
                        $linha[] = $domicilio['Indice']['v5'];
                        $linha[] = number_format($domicilio['Indice']['criancas'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['v6'];
                        $linha[] = $domicilio['Indice']['v7'];
                        $linha[] = number_format($domicilio['Indice']['idosos'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['v8'];
                        $linha[] = $domicilio['Indice']['v9'];
                        $linha[] = number_format($domicilio['Indice']['dependencia'], 2, ',', '.');
                        $linha[] = number_format($domicilio['Indice']['vulnerabilidade'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['c1'];
                        $linha[] = $domicilio['Indice']['c2'];
                        $linha[] = number_format($domicilio['Indice']['analfabetismo'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['c3'];
                        $linha[] = $domicilio['Indice']['c4'];
                        $linha[] = $domicilio['Indice']['c5'];
                        $linha[] = number_format($domicilio['Indice']['escolaridade'], 2, ',', '.');
                        $linha[] = number_format($domicilio['Indice']['conhecimento'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['t1'];
                        $linha[] = number_format($domicilio['Indice']['disponibilidade'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['t2'];
                        $linha[] = $domicilio['Indice']['t3'];
                        $linha[] = number_format($domicilio['Indice']['qualidade'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['t4'];
                        $linha[] = $domicilio['Indice']['t5'];
                        $linha[] = number_format($domicilio['Indice']['renda'], 2, ',', '.');
                        $linha[] = number_format($domicilio['Indice']['trabalho'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['r1'];
                        $linha[] = $domicilio['Indice']['r2'];
                        $linha[] = $domicilio['Indice']['r3'];
                        $linha[] = number_format($domicilio['Indice']['extremaPobreza'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['r4'];
                        $linha[] = $domicilio['Indice']['r5'];
                        $linha[] = number_format($domicilio['Indice']['pobreza'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['r6'];
                        $linha[] = number_format($domicilio['Indice']['capacidadeGeracao'], 2, ',', '.');
                        $linha[] = number_format($domicilio['Indice']['recursos'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['d1'];
                        $linha[] = $domicilio['Indice']['d2'];
                        $linha[] = number_format($domicilio['Indice']['trabalhoPrecoce'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['d3'];
                        $linha[] = $domicilio['Indice']['d4'];
                        $linha[] = $domicilio['Indice']['d5'];
                        $linha[] = number_format($domicilio['Indice']['acessoEscola'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['d6'];
                        $linha[] = $domicilio['Indice']['d7'];
                        $linha[] = $domicilio['Indice']['d8'];
                        $linha[] = number_format($domicilio['Indice']['progressoEscolar'], 2, ',', '.');
                        $linha[] = number_format($domicilio['Indice']['desenvolvimento'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['h1'];
                        $linha[] = $domicilio['Indice']['h2'];
                        $linha[] = number_format($domicilio['Indice']['propriedade'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['h3'];
                        $linha[] = number_format($domicilio['Indice']['deficit'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['h4'];
                        $linha[] = number_format($domicilio['Indice']['abrigalidade'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['h5'];
                        $linha[] = number_format($domicilio['Indice']['acessoAgua'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['h6'];
                        $linha[] = number_format($domicilio['Indice']['acessoSaneamento'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['h7'];
                        $linha[] = number_format($domicilio['Indice']['acessoColetaLixo'], 2, ',', '.');
                        $linha[] = $domicilio['Indice']['h8'];
                        $linha[] = number_format($domicilio['Indice']['acessoEletricidade'], 2, ',', '.');
                        $linha[] = number_format($domicilio['Indice']['habitacao'], 2, ',', '.');
                        $linha[] = $domicilio['Responsavel']['cod_nis'];
                        $linha[] = $domicilio['Responsavel']['nome'];
                        $linha[] = number_format($domicilio['Domicilio']['vlr_renda_familia'], 2, ',', '.');
                        $linha[] = $domicilio['Domicilio']['qtd_pessoa'];
                        $linha[] = number_format(($domicilio['Domicilio']['vlr_renda_familia'] / $domicilio['Domicilio']['qtd_pessoa']), 2, ',', '.');
                        $linha[] = number_format($domicilio['Domicilio']['vlr_beneficio'], 2, ',', '.');
                        $linha[] = $domicilio['Domicilio']['end_tipo'];
                        $linha[] = $domicilio['Domicilio']['end_logradouro'];
                        $linha[] = $domicilio['Domicilio']['end_num'];
                        $linha[] = $domicilio['Domicilio']['end_compl'];
                        $linha[] = $domicilio['Bairro']['nome_bairro'];
                        $linha[] = $domicilio['Cras']['desc_cras'];
                        $linha[] = $domicilio['Regiao']['descricao'];

                        $size = fputcsv($fw, $linha, ';');
                    }
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
        parent::temAcesso();
        $idade = '(SELECT EXTRACT(year from AGE(NOW(), "Pessoa"."dt_nasc")))';
        $options = array(
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'tb_domicilio',
                    'alias' => 'Domicilio',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Pessoa.cod_domiciliar = Domicilio.cod_domiciliar',
                    )
                ),
                array(
                    'table' => 'tb_bairro',
                    'alias' => 'Bairro',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Bairro.id_bairro = Domicilio.id_bairro',
                    )
                ),
            ),
            'fields' => array(
                $idade . ' AS idade',
                'COUNT(' . $idade . ') AS total',
                'Pessoa.tp_trabalho'
            ),
            'conditions' => array(
                'Domicilio.qtd_pessoa > 0',
                'Bairro.id_cras IN(' . $this->crasUsuario() . ')',
            ),
            'group' => array(
                'Pessoa.tp_trabalho',
                $idade
            ),
            'order' => array(
                $idade,
            ),
        );

        switch ($this->data['Relatorio']['filtro']) {
            case 'id_regiao':
                $options['fields'][] = 'Bairro.id_regiao';
                $options['conditions']['Bairro.id_regiao'] = $this->data['Relatorio']['id_regiao'];
                $options['group'][] = 'Bairro.id_regiao';
                break;
            case 'id_cras':
                $options['fields'][] = 'Bairro.id_cras';
                $options['conditions']['Bairro.id_cras'] = $this->data['Relatorio']['id_cras'];
                $options['group'][] = 'Bairro.id_cras';
                break;
            case 'id_bairro':
                $options['fields'][] = 'Domicilio.id_bairro';
                $options['conditions']['Domicilio.id_bairro'] = $this->data['Relatorio']['id_bairro'];
                $options['group'][] = 'Domicilio.id_bairro';
                break;
        }

        $inicio = microtime(true);
        $pessoas = $this->Pessoa->find('all', $options);

        $faixaEtaria['total'] = $this->Pessoa->find('count', $options);

        foreach ($pessoas as $faixa) {
            if ($faixa[0]['idade'] < 65) {
                $faixaEtaria[$this->faixaEtaria($faixa[0]['idade'])]
                        [$faixa['Pessoa']['tp_trabalho']][$faixa[0]['idade']]
                        = (int) $faixa[0]['total'];
            } else {
                $faixaEtaria[$this->faixaEtaria(65)]
                        [$faixa['Pessoa']['tp_trabalho']][65]
                        += (int) $faixa[0]['total'];
            }

            if (isset($faixaEtaria[$faixa['Pessoa']['tp_trabalho']])) {
                $faixaEtaria[$faixa['Pessoa']['tp_trabalho']] += (int) $faixa[0]['total'];
            } else {
                $faixaEtaria[$faixa['Pessoa']['tp_trabalho']] = (int) $faixa[0]['total'];
            }
        }

        $faixaEtaria['tempo'] = microtime(true) - $inicio;
        $bairros = $this->Domicilio->Bairro->find('list', array('order' => 'Bairro.nome_bairro'));
        $cras = $this->Domicilio->Bairro->Cras->find('list');
        $regioes = $this->Domicilio->Bairro->Regiao->find('list');

        $this->set(compact('faixaEtaria', 'bairros', 'cras', 'regioes', 'domicilios'));
    }

    function faixasEtarias() {
        parent::temAcesso();
        $idade = '(SELECT EXTRACT(year from AGE(NOW(), "Pessoa"."dt_nasc")))';
        $options = array(
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'tb_domicilio',
                    'alias' => 'Domicilio',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Pessoa.cod_domiciliar = Domicilio.cod_domiciliar',
                    )
                ),
                array(
                    'table' => 'tb_bairro',
                    'alias' => 'Bairro',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Bairro.id_bairro = Domicilio.id_bairro',
                    )
                ),
            ),
            'conditions' => array(
                'Domicilio.qtd_pessoa > 0',
                'Domicilio.id_cras IN(' . $this->crasUsuario() . ')',
            ),
            'fields' => array(
                $idade . ' AS idade',
                'COUNT(' . $idade . ') AS total',
                'Pessoa.sexo',
            ),
            'group' => array(
                'Pessoa.sexo',
                $idade,
            ),
            'order' => array(
                $idade,
            ),
        );

        switch ($this->data['Relatorio']['filtro']) {
            case 'id_regiao':
                $options['fields'][] = 'Bairro.id_regiao';
                $options['conditions']['Bairro.id_regiao'] = $this->data['Relatorio']['id_regiao'];
                $options['group'][] = 'Bairro.id_regiao';
                break;
            case 'id_cras':
                $options['fields'][] = 'Bairro.id_cras';
                $options['conditions']['Bairro.id_cras'] = $this->data['Relatorio']['id_cras'];
                $options['group'][] = 'Bairro.id_cras';
                break;
            case 'id_bairro':
                $options['fields'][] = 'Domicilio.id_bairro';
                $options['conditions']['Domicilio.id_bairro'] = $this->data['Relatorio']['id_bairro'];
                $options['group'][] = 'Domicilio.id_bairro';
                break;
        }

        $inicio = microtime(true);
        $pessoas = $this->Pessoa->find('all', $options);

        $faixaEtaria['total'] = 0;

        foreach ($pessoas as $faixa) {
            $total = (int) $faixa[0]['total'];
            $faixaEtaria['total'] += $total;
            if ($faixa[0]['idade'] < 65) {
                $faixaEtaria
                        [$this->faixaEtaria($faixa[0]['idade'])]
                        [$faixa['Pessoa']['sexo']]
                        [$faixa[0]['idade']] = $total;
            } else {
                $faixaEtaria
                        [$this->faixaEtaria(65)]
                        [$faixa['Pessoa']['sexo']]
                        [65] += $total;
            }

            //Totalizador por faixa etária
            //IF usado para corrigir erro de variável não setada usando +=
            if (!isset($faixaEtaria[$this->faixaEtaria($faixa[0]['idade'])]['total']))
                $faixaEtaria[$this->faixaEtaria($faixa[0]['idade'])]['total'] = $faixa[0]['total'];
            else
                $faixaEtaria[$this->faixaEtaria($faixa[0]['idade'])]['total'] += $faixa[0]['total'];

            //Totalizador por faixa etária
            if (!isset($faixaEtaria[$this->faixaEtaria($faixa[0]['idade'])]['idade'][$faixa[0]['idade']]['total']))
                $faixaEtaria[$this->faixaEtaria($faixa[0]['idade'])]['idade'][$faixa[0]['idade']] = $faixa[0]['total'];
            else
                $faixaEtaria[$this->faixaEtaria($faixa[0]['idade'])]['idade'][$faixa[0]['idade']] += $faixa[0]['total'];

            //Totalizador por faixa etária / sexo
            //IF usado para corrigir erro de variável não setada usando +=
            if (!isset($faixaEtaria[$this->faixaEtaria($faixa[0]['idade'])][$faixa['Pessoa']['sexo']]['total']))
                $faixaEtaria[$this->faixaEtaria($faixa[0]['idade'])][$faixa['Pessoa']['sexo']]['total'] = $faixa[0]['total'];
            else
                $faixaEtaria[$this->faixaEtaria($faixa[0]['idade'])][$faixa['Pessoa']['sexo']]['total'] += $faixa[0]['total'];

            //Totalizador por  sexo
            //IF usado para corrigir erro de variável não setada usando +=
            if (!isset($faixaEtaria[$faixa['Pessoa']['sexo']]))
                $faixaEtaria[$faixa['Pessoa']['sexo']] = $faixa[0]['total'];
            else
                $faixaEtaria[$faixa['Pessoa']['sexo']] += $faixa[0]['total'];
        }

        $faixaEtaria['tempo'] = microtime(true) - $inicio;

        $bairros = $this->Domicilio->Bairro->find('list', array(
            'order' => 'Bairro.nome_bairro'
                ));
        $cras = $this->Domicilio->Cras->find('list');
        $regioes = $this->Domicilio->Regiao->find('list');

        $this->set(compact('faixaEtaria', 'bairros', 'cras', 'regioes'));
    }

    function valorRenda() {
        parent::temAcesso();
        $idade = '(SELECT EXTRACT(year from AGE(NOW(), "Pessoa"."dt_nasc")))';
        $options = array(
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'tb_domicilio',
                    'alias' => 'Domicilio',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Pessoa.cod_domiciliar = Domicilio.cod_domiciliar',
                    )
                ),
                array(
                    'table' => 'tb_bairro',
                    'alias' => 'Bairro',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Bairro.id_bairro = Domicilio.id_bairro',
                    )
                ),
            ),
            'fields' => array(
                'COUNT(' . $idade . ') AS total',
                '(CASE
                    WHEN "Pessoa"."vlr_renda_total" = 0 THEN \'0 reais\'
                    WHEN "Pessoa"."vlr_renda_total" BETWEEN 0.01 AND 70 THEN \'ate 70 reais\'
                    WHEN "Pessoa"."vlr_renda_total" BETWEEN 70.01 AND 140 THEN \'70 a 140 reais\'
                    WHEN "Pessoa"."vlr_renda_total" BETWEEN 140.01 AND 240 THEN \'140 a 240 reais\'
                    WHEN "Pessoa"."vlr_renda_total" BETWEEN 240.01 AND 545 THEN \'240 a 545 reais\'
                    WHEN "Pessoa"."vlr_renda_total" > 545 THEN \'acima 545 reais\'
                 END) AS remuneracao',
                $idade . ' AS idade',
            ),
            'conditions' => array(
                'Domicilio.qtd_pessoa > 0',
                'Domicilio.id_cras IN(' . $this->crasUsuario() . ')',
            ),
            'group' => array(
                'remuneracao',
                $idade,
            ),
            'order' => array(
                $idade,
            ),
        );

        switch ($this->data['Relatorio']['filtro']) {
            case 'id_regiao':
                $options['fields'][] = 'Bairro.id_regiao';
                $options['conditions']['Bairro.id_regiao'] = $this->data['Relatorio']['id_regiao'];
                $options['group'][] = 'Bairro.id_regiao';
                break;
            case 'id_cras':
                $options['fields'][] = 'Bairro.id_cras';
                $options['conditions']['Bairro.id_cras'] = $this->data['Relatorio']['id_cras'];
                $options['group'][] = 'Bairro.id_cras';
                break;
            case 'id_bairro':
                $options['fields'][] = 'Domicilio.id_bairro';
                $options['conditions']['Domicilio.id_bairro'] = $this->data['Relatorio']['id_bairro'];
                $options['group'][] = 'Domicilio.id_bairro';
                break;
        }

        $inicio = microtime(true);
        $pessoas = $this->Pessoa->find('all', $options);

        $valorRenda['total'] = 0;
        foreach ($pessoas as $renda) {
            $valorRenda['total'] += (int) $renda[0]['total'];
            if ($renda[0]['idade'] < 65) {
                $valorRenda
                        [$this->faixaEtaria($renda[0]['idade'])]
                        [$renda[0]['remuneracao']]
                        [$renda[0]['idade']] = (int) $renda[0]['total'];
            } else {
                $valorRenda
                        [$this->faixaEtaria(65)]
                        [$renda[0]['remuneracao']]
                        [65] += (int) $renda[0]['total'];
            }

            if (isset($valorRenda[$renda[0]['remuneracao']])) {
                $valorRenda[$renda[0]['remuneracao']] += (int) $renda[0]['total'];
            } else {
                $valorRenda[$renda[0]['remuneracao']] = (int) $renda[0]['total'];
            }
        }

        $valorRenda['tempo'] = microtime(true) - $inicio;

        $bairros = $this->Domicilio->Bairro->find('list', array(
            'order' => 'Bairro.nome_bairro'
                ));
        $cras = $this->Domicilio->Cras->find('list');
        $regioes = $this->Domicilio->Regiao->find('list');

        $this->set(compact('valorRenda', 'bairros', 'cras', 'regioes'));
    }

    function educacaoFormal() {
        parent::temAcesso();

        $serie_escolar = '(CASE';
        $serie_escolar .= ' WHEN grau_instrucao = ' . Pessoa::ESCOLARIDADE_ANALFABETO . ' THEN \'analfabeto\'';
        $serie_escolar .= ' WHEN serie_escolar = ' . Pessoa::SERIE_CA_ALFABETIZACAO . ' THEN \'alfabetizacao\'';
        $serie_escolar .= ' WHEN serie_escolar BETWEEN ' . Pessoa::SERIE_MATERNAL_I . ' AND ' . Pessoa::SERIE_MATERNAL_III . ' THEN \'maternal\'';
        $serie_escolar .= ' WHEN serie_escolar BETWEEN ' . Pessoa::SERIE_JARDIM_I . ' AND ' . Pessoa::SERIE_JARDIM_III . ' THEN \'jardim\'';
        $serie_escolar .= ' WHEN serie_escolar BETWEEN ' . Pessoa::SERIE_1_ENSINO_FUNDAMENTAL . ' AND ' . Pessoa::SERIE_2_ENSINO_FUNDAMENTAL . ' THEN \'1 a 2 ano\'';
        $serie_escolar .= ' WHEN serie_escolar BETWEEN ' . Pessoa::SERIE_3_ENSINO_FUNDAMENTAL . ' AND ' . Pessoa::SERIE_4_ENSINO_FUNDAMENTAL . ' THEN \'3 a 4 ano\'';
        $serie_escolar .= ' WHEN serie_escolar BETWEEN ' . Pessoa::SERIE_5_ENSINO_FUNDAMENTAL . ' AND ' . Pessoa::SERIE_6_ENSINO_FUNDAMENTAL . ' THEN \'5 a 6 ano\'';
        $serie_escolar .= ' WHEN serie_escolar BETWEEN ' . Pessoa::SERIE_7_ENSINO_FUNDAMENTAL . ' AND ' . Pessoa::SERIE_8_ENSINO_FUNDAMENTAL . ' THEN \'7 a 8 ano\'';
        $serie_escolar .= ' WHEN serie_escolar = ' . Pessoa::SERIE_1_ENSINO_MEDIO . ' THEN \'1 ano medio\'';
        $serie_escolar .= ' WHEN serie_escolar = ' . Pessoa::SERIE_2_ENSINO_MEDIO . ' THEN \'2 ano medio\'';
        $serie_escolar .= ' WHEN serie_escolar = ' . Pessoa::SERIE_3_ENSINO_MEDIO . ' THEN \'3 ano medio\'';
        $serie_escolar .= ' WHEN grau_instrucao >= ' . Pessoa::ESCOLARIDADE_SUPERIOR_INCOMPLETO . ' THEN \'ensino superior\'';
        $serie_escolar .= ' WHEN serie_escolar = ' . Pessoa::SERIE_NAO_INFORMADO . ' THEN \'nao informado\'';
        $serie_escolar .= ' END) AS educacao_formal';

        $idade = '(SELECT EXTRACT(year from AGE(NOW(), "Pessoa"."dt_nasc")))';

        $options = array(
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'tb_domicilio',
                    'alias' => 'Domicilio',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Pessoa.cod_domiciliar = Domicilio.cod_domiciliar',
                    )
                ),
                array(
                    'table' => 'tb_bairro',
                    'alias' => 'Bairro',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Bairro.id_bairro = Domicilio.id_bairro',
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
                'FaixasEtaria.faixa',
            ),
            'conditions' => array(
                'Domicilio.qtd_pessoa > 0',
                'Domicilio.id_cras IN(' . $this->crasUsuario() . ')',
            ),
            'order' => array(
                'FaixasEtaria.faixa',
            ),
        );

        switch ($this->data['Relatorio']['filtro']) {
            case 'id_regiao':
                $options['fields'][] = 'Bairro.id_regiao';
                $options['conditions']['Bairro.id_regiao'] = $this->data['Relatorio']['id_regiao'];
                $options['group'][] = 'Bairro.id_regiao';
                break;
            case 'id_cras':
                $options['fields'][] = 'Bairro.id_cras';
                $options['conditions']['Bairro.id_cras'] = $this->data['Relatorio']['id_cras'];
                $options['group'][] = 'Bairro.id_cras';
                break;
            case 'id_bairro':
                $options['fields'][] = 'Domicilio.id_bairro';
                $options['conditions']['Domicilio.id_bairro'] = $this->data['Relatorio']['id_bairro'];
                $options['group'][] = 'Domicilio.id_bairro';
                break;
        }

        $inicio = microtime(true);
        $pessoas = $this->Pessoa->find('all', $options);

        $educacaoFormal['total'] = $this->Pessoa->find('count', array('conditions' => array('Domicilio.qtd_pessoa > 0',)));

        foreach ($pessoas as $educacao) {
            $educacaoFormal
                    [$educacao['FaixasEtaria']['faixa']]
                    [$educacao[0]['educacao_formal']]
                    [$educacao['FaixasEtaria']['descricao']] = $educacao[0]['total'];
            $educacaoFormal[$educacao[0]['educacao_formal']] += $educacao[0]['total'];
        }

        $educacaoFormal['tempo'] = microtime(true) - $inicio;

        $bairros = $this->Domicilio->Bairro->find('list', array(
            'order' => 'Bairro.nome_bairro'
                ));
        $cras = $this->Domicilio->Cras->find('list');
        $regioes = $this->Domicilio->Regiao->find('list');

        $this->set(compact('educacaoFormal', 'bairros', 'cras', 'regioes'));
    }

    private function crasUsuario() {
        $this->loadModel('Usuario');
        $this->Usuario->id = $this->Session->read('Auth.Usuario.id_usuario');
        $cras_usuario = array();

        if ($this->Usuario->id == 1) {
            $this->loadModel('Cras');
            $cras_usuario = array_keys($this->Cras->find('list'));
        } else {
            $usuario = $this->Usuario->read();
            if (count($usuario['Cras']) > 0)
                foreach ($usuario['Cras'] as $cras)
                    $cras_usuario[] = $cras['id_cras'];
        }

        return implode(',', $cras_usuario);
    }

    private function faixaEtaria($idade) {
        if ($idade < 10)
            return 'Criança';
        else if ($idade < 15)
            return 'Adolescente';
        else if ($idade < 18)
            return 'Jovem';
        else if ($idade < 60)
            return 'Adulto';
        return 'Idoso';
    }

}