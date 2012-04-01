<?php

class Indice extends AppModel {

    var $name = 'Indice';
    var $primaryKey = 'codigo_domiciliar';
    var $hasOne = array(
        'Domicilio' => array(
            'foreignKey' => 'codigo_domiciliar',
            'dependent' => false
        ),
    );
    var $hasMany = array(
        'Prontuario' => array(
            'foreignKey' => 'codigo_domiciliar',
        ),
        'IndicesHistorico' => array(
            'foreignKey' => 'codigo_domiciliar',
        ),
    );
    public $indicadores = array(
        1 => 'v1', 'v2', 'v3', 'v4', 'v5', 'v6', 'v7', 'v8', 'v9', 'c1', 'c2', 'c3',
        'c4', 'c5', 't1', 't2', 't3', 't4', 't5', 'r1', 'r2', 'r3', 'r4', 'r5',
        'r6', 'd1', 'd2', 'd3', 'd4', 'd5', 'd6', 'd7', 'd8', 'h1', 'h2', 'h3',
        'h4', 'h5', 'h6', 'h7', 'h8', 'v10', 'v11', 'v12',
    );
    public $dimensoes = array(
        'vulnerabilidade' => array(
            'gestacao' => array(
                'v1' => 1,
                'v2' => 1,
            ),
            'criancas' => array(
                'v3' => 1,
                'v4' => 1,
                'v5' => 1,
            ),
            'idosos' => array(
                'v6' => 1,
                'v7' => 1,
            ),
            'dependencia' => array(
                'v8' => 1,
                'v9' => 1,
            ),
        ),
        'conhecimento' => array(
            'analfabetismo' => array(
                'c1' => 1,
                'c2' => 1,
            ),
            'escolaridade' => array(
                'c3' => 0,
                'c4' => 0,
                'c5' => 0,
            ),
        ),
        'trabalho' => array(
            'disponibilidade' => array(
                't1' => 0,
            ),
            'qualidade' => array(
                't2' => 0,
                't3' => 0,
            ),
            'remuneracao' => array(
                't4' => 0,
                't5' => 0,
            ),
        ),
        'recursos' => array(
            'extremaPobreza' => array(
                'r1' => 1,
                'r2' => 1,
                'r3' => 1,
            ),
            'pobreza' => array(
                'r4' => 1,
                'r5' => 1,
            ),
            'capacidadeGeracao' => array(
                'r6' => 1,
            ),
        ),
        'desenvolvimento' => array(
            'trabalhoPrecoce' => array(
                'd1' => 1,
                'd2' => 1,
            ),
            'acessoEscola' => array(
                'd3' => 1,
                'd4' => 1,
                'd5' => 1,
            ),
            'progressoEscolar' => array(
                'd6' => 1,
                'd7' => 1,
                'd8' => 1,
            ),
        ),
        'habitacao' => array(
            'propriedade' => array(
                'h1' => 1,
                'h2' => 1,
            ),
            'deficit' => array(
                'h3' => 1,
            ),
            'abrigalidade' => array(
                'h4' => 1,
            ),
            'acessoAgua' => array(
                'h5' => 1,
            ),
            'acessoSaneamento' => array(
                'h6' => 1,
            ),
            'acessoColetaLixo' => array(
                'h7' => 1,
            ),
            'acessoEletricidade' => array(
                'h8' => 1,
            ),
        ),
    );
    var $domicilio = array();

    function contadorMembrosIdadeAtiva() {
        $idade_ativa = 0;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            //V.9 Mais da metade dos membros encontra-se em idade ativa
            if ($pessoa['idade'] >= Pessoa::IDADE_ADOLESCENTE)
                $idade_ativa++;
        }
        return $idade_ativa;
    }

    function contadorMembrosIdadeAtivaOcupados() {
        $idade_ativa_ocupado = 0;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] >= Pessoa::IDADE_ADOLESCENTE &&
                    $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO
                    && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA)
                $idade_ativa_ocupado++;
        }
        return $idade_ativa_ocupado;
    }

    function calcularIndices($domicilio) {
        $this->domicilio = $domicilio;
        // Calculo para Dimensão - Vulnerabilidade
        $gestacao = Indice::calculoComponenteGestacao();
        $this->domicilio['Indice']['gestacao'] = $gestacao;
        $criancas = Indice::calculoComponenteCriancas();
        $this->domicilio['Indice']['criancas'] = $criancas;
        $idosos = Indice::calculoComponenteIdosos();
        $this->domicilio['Indice']['idosos'] = $idosos;
        $dependencia = Indice::calculoComponenteDependencia();
        $this->domicilio['Indice']['dependencia'] = $dependencia;
        $vulnerabilidade = ($gestacao + $criancas + $idosos + $dependencia) / 4;
        $this->domicilio['Indice']['vulnerabilidade'] = $vulnerabilidade;

        // Calculo para Dimensão - Conhecimento
        $analfabetismo = Indice::calculoComponenteAnalfabetismo();
        $this->domicilio['Indice']['analfabetismo'] = $analfabetismo;
        $escolaridade = Indice::calculoComponenteEscolaridade();
        $this->domicilio['Indice']['escolaridade'] = $escolaridade;
        $conhecimento = ($analfabetismo + $escolaridade) / 2;
        $this->domicilio['Indice']['conhecimento'] = $conhecimento;

        // Calculo para Dimensão - Trabalho
        $disponibilidade = Indice::calculoComponenteDisponibilidade();
        $this->domicilio['Indice']['disponibilidade'] = $disponibilidade;
        $qualidade = Indice::calculoComponenteQualidade();
        $this->domicilio['Indice']['qualidade'] = $qualidade;
        $remuneracao = Indice::calculoComponenteRemuneracao();
        $this->domicilio['Indice']['remuneracao'] = $remuneracao;
        $trabalho = ($disponibilidade + $qualidade + $remuneracao) / 3;
        $this->domicilio['Indice']['trabalho'] = $trabalho;

        // Calculo para Dimensao - Recursos
        $extremaPobreza = Indice::calculoComponenteExtremaPobreza();
        $this->domicilio['Indice']['extremaPobreza'] = $extremaPobreza;
        $pobreza = Indice::calculoComponentePobreza();
        $this->domicilio['Indice']['pobreza'] = $pobreza;
        $capacidadeGeracao = Indice::calculoComponenteCapacidadeGeracao();
        $this->domicilio['Indice']['capacidadeGeracao'] = $capacidadeGeracao;
        $recursos = ($extremaPobreza + $pobreza + $capacidadeGeracao) / 3;
        $this->domicilio['Indice']['recursos'] = $recursos;

        // Calculo para Dimensao - Desenvolvimento Infantil
        $trabalhoPrecoce = Indice::calculoComponenteTrabalhoPrecoce();
        $this->domicilio['Indice']['trabalhoPrecoce'] = $trabalhoPrecoce;
        $acessoEscola = Indice::calculoComponenteAcessoEscola();
        $this->domicilio['Indice']['acessoEscola'] = $acessoEscola;
        $progressoEscolar = Indice::calculoComponenteProgressoEscolar();
        $this->domicilio['Indice']['progressoEscolar'] = $progressoEscolar;
        $desenvolvimento = ($trabalhoPrecoce + $acessoEscola + $progressoEscolar) / 3;
        $this->domicilio['Indice']['desenvolvimento'] = $desenvolvimento;

        // Calculo para Dimensao - Habitação
        $propriedade = Indice::calculoComponentePropriedade();
        $this->domicilio['Indice']['propriedade'] = $propriedade;
        $deficit = Indice::calculoComponenteDeficit();
        $this->domicilio['Indice']['deficit'] = $deficit;
        $abrigalidade = Indice::calculoComponenteAbrigalidade();
        $this->domicilio['Indice']['abrigalidade'] = $abrigalidade;
        $acessoAgua = Indice::calculoComponenteAcessoAgua();
        $this->domicilio['Indice']['acessoAgua'] = $acessoAgua;
        $acessoSaneamento = Indice::calculoComponenteAcessoSaneamento();
        $this->domicilio['Indice']['acessoSaneamento'] = $acessoSaneamento;
        $acessoColetaLixo = Indice::calculoComponenteAcessoColetaLixo();
        $this->domicilio['Indice']['acessoColetaLixo'] = $acessoColetaLixo;
        $acessoEletricidade = Indice::calculoComponenteAcessoEletricidade();
        $this->domicilio['Indice']['acessoEletricidade'] = $acessoEletricidade;
        $habitacao = ($propriedade + $deficit + $abrigalidade +
                      $acessoAgua + $acessoSaneamento +
                      $acessoColetaLixo + $acessoEletricidade) / 7;
        $this->domicilio['Indice']['habitacao'] = $habitacao;

        // Calculo do IDF da Familia
        $idf = round(($vulnerabilidade + $conhecimento + $trabalho +
                $recursos + $desenvolvimento + $habitacao) / 6, 2);

        $this->domicilio['Indice']['idf'] = $idf;
        $this->domicilio['Domicilio']['idf'] = $idf;
        return $this->domicilio;
    }

    function calculoComponenteGestacao() {
        return ($this->v1() + $this->v2()) / 2;
    }

    // V.1 Ausencia de gestantes
    function v1() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['mes_gestacao'] > 0) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['v1'] = $retorno;
        return $retorno;
    }

    // V.2 Ausencia de gestantes
    function v2() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['amamentando'] == 1) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['v2'] = $retorno;
        return $retorno;
    }

    function calculoComponenteCriancas() {
        return ($this->v3() + $this->v4() + $this->v5()) / 3;
    }

    //V.3 Ausência de crianças
    function v3() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] < Pessoa::IDADE_ADOLESCENTE) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['v3'] = $retorno;
        return $retorno;
    }

    //V.4 Ausência de crianças e adolescente
    function v4() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] < Pessoa::IDADE_JOVEM) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['v4'] = $retorno;
        return $retorno;
    }

    //V.5  Ausência de crianças, adolescente e jovens
    function v5() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] < Pessoa::IDADE_ADULTO) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['v5'] = $retorno;
        return $retorno;
    }

    function calculoComponenteIdosos() {
        return ($this->v6() + $this->v7()) / 2;
    }

    //V.6 Ausência de portadores de deficiência
    function v6() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['portador_deficiencia'] == 1) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['v6'] = $retorno;
        return $retorno;
    }

    //V.7 Ausência de Idosos
    function v7() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] >= Pessoa::IDADE_IDOSO) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['v7'] = $retorno;
        return $retorno;
    }

    function calculoComponenteDependencia() {
        return ($this->v8() + $this->v9()) / 2;
    }

    // V.8 Presença de cônjuge
    function v8() {
        $retorno = 0;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['esposa_companheiro'] == 1) {
                $retorno = 1;
                break;
            }
        }
        $this->domicilio['Indice']['v8'] = $retorno;
        return $retorno;
    }

    //V.9 Mais da metade dos membros encontra-se em idade ativa
    function v9() {
        $retorno = 0;
        if ($this->domicilio['Domicilio']['quantidade_pessoas'] / 2 > $this->contadorMembrosIdadeAtiva()) {
            $retorno = 1;
        }
        $this->domicilio['Indice']['v9'] = $retorno;
        return $retorno;
    }

    function calculoComponenteAnalfabetismo() {
        return ($this->c1() + $this->c2()) / 2;
    }

    //C.1 Ausência de Adultos Analfabetos
    function c1() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] >= Pessoa::IDADE_ADULTO && $pessoa['grau_instrucao'] < Pessoa::ESCOLARIDADE_ATE_4A_INCOMPLETA) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['c1'] = $retorno;
        return $retorno;
    }

    //C.2 Ausência de Adultos Analfabetos Funcionais
    function c2() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] >= Pessoa::IDADE_ADULTO && $pessoa['grau_instrucao'] < Pessoa::ESCOLARIDADE_4A_COMPLETA) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['c2'] = $retorno;
        return $retorno;
    }

    function calculoComponenteEscolaridade() {
        return ($this->c3() + $this->c4() + $this->c5()) / 3;
    }

    //C.3 Presença de pelo menos um adulto com fundamental completo
    function c3() {
        $retorno = 0;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] >= Pessoa::IDADE_ADULTO) {
                if ($pessoa['grau_instrucao'] >= Pessoa::ESCOLARIDADE_FUNDAMENTAL_COMPLETO) {
                    $retorno = 1;
                    break;
                }
            }
        }
        $this->domicilio['Indice']['c3'] = $retorno;
        return $retorno;
    }

    //C.4 Presença de pelo menos um adulto com secundário completo
    function c4() {
        $retorno = 0;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] >= Pessoa::IDADE_ADULTO) {
                if ($pessoa['grau_instrucao'] >= Pessoa::ESCOLARIDADE_MEDIO_COMPLETO) {
                    $retorno = 1;
                    break;
                }
            }
        }
        $this->domicilio['Indice']['c4'] = $retorno;
        return $retorno;
    }

    //C.5 Presença de pelo menos um adulto com alguma educação superior
    function c5() {
        $retorno = 0;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] >= Pessoa::IDADE_ADULTO) {
                if ($pessoa['grau_instrucao'] >= Pessoa::ESCOLARIDADE_SUPERIOR_INCOMPLETO) {
                    $retorno = 1;
                    break;
                }
            }
        }
        $this->domicilio['Indice']['c5'] = $retorno;
        return $retorno;
    }

    function calculoComponenteDisponibilidade() {
        return $this->t1();
    }

    //T.1 Mais da metade dos membros em idade ativa encontram-se ocupados
    function t1() {
        $retorno = 0;
        if ($this->contadorMembrosIdadeAtivaOcupados() > $this->domicilio['Domicilio']['quantidade_pessoas'] / 2 ) {
            $retorno = 1;
        }
        $this->domicilio['Indice']['t1'] = $retorno;
        return $retorno;
    }

    function calculoComponenteQualidade() {
        return ($this->t2() + $this->t3()) / 2;
    }

    //T.2 Presença de pelo menos um ocupado no setor formal
    function t2() {
        $retorno = 0;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['tipo_trabalho'] == Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA
                    || $pessoa['tipo_trabalho'] == Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA) {
                $retorno = 1;
                break;
            }
        }
        $this->domicilio['Indice']['t2'] = $retorno;
        return $retorno;
    }

    //T.3 Presença de pelo menos um ocupado em atividade não agrícola
    function t3() {
        $retorno = 0;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA &&
                    $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO &&
                    $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_TRABALHADOR_RURAL
                    && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_EMPREGADOR_RURAL) {
                $retorno = 1;
                break;
            }
        }
        $this->domicilio['Indice']['t3'] = $retorno;
        return $retorno;
    }

    function calculoComponenteRemuneracao() {
        return ($this->t4() + $this->t5()) / 2;
    }

    //T.4 Presença de pelo menos um ocupado com rendimento superior a 1 salário mínimo
    function t4() {
        $retorno = 0;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA
                    && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO
                    && $pessoa['valor_remuneracao'] > 545) {
                $retorno = 1;
                break;
            }
        }
        $this->domicilio['Indice']['t4'] = $retorno;
        return $retorno;
    }

    //T.5 Presença de pelo menos um ocupado com rendimento superior a 2 salários mínimos
    function t5() {
        $retorno = 0;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA
                    && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO
                    && $pessoa['valor_remuneracao'] > (545 * 2)) {
                $retorno = 1;
                break;
            }
        }
        $this->domicilio['Indice']['t5'] = $retorno;
        return $retorno;
    }

    function calculoComponenteExtremaPobreza() {
        return ($this->r1() + $this->r2() + $this->r3()) / 3;
    }

    //R.1 Despesa familiar per capita superior a linha de extema pobreza
    function r1() {
        $retorno = 0;
        if ($this->domicilio['Domicilio']['quantidade_pessoas'] > 0 && $this->domicilio['Domicilio']['valor_despesa_familia'] / $this->domicilio['Domicilio']['quantidade_pessoas'] >= 70) {
            $retorno = 1;
        }
        $this->domicilio['Indice']['r1'] = $retorno;
        return $retorno;
    }

    //R.2 Renda familiar per capita superior a linha de extrema pobreza
    function r2() {
        $retorno = 0;
        if ($this->domicilio['Domicilio']['valor_renda_familia'] / $this->domicilio['Domicilio']['quantidade_pessoas'] >= 70) {
            $retorno = 1;
        }
        $this->domicilio['Indice']['r2'] = $retorno;
        return $retorno;
    }

    //R.3 Despesa com alimentos superior a linha de extema pobreza
    function r3() {
        $retorno = 0;
        if ($this->domicilio['Domicilio']['valor_despesa_alimentacao'] >= 70) {
            $retorno = 1;
        }
        $this->domicilio['Indice']['r3'] = $retorno;
        return $retorno;
    }

    function calculoComponentePobreza() {
        return ($this->r4() + $this->r5()) / 2;
    }

    //R.4 Despesa familiar per capita superior a linha de pobreza
    function r4() {
        $retorno = 0;
        if ($this->domicilio['Domicilio']['valor_despesa_familia'] / $this->domicilio['Domicilio']['quantidade_pessoas'] >= 140) {
            $retorno = 1;
        }
        $this->domicilio['Indice']['r4'] = $retorno;
        return $retorno;
    }

    //R.5 Renda familiar per capita superior a linha de pobreza
    function r5() {
        $retorno = 0;
        if ($this->domicilio['Domicilio']['valor_renda_familia'] / $this->domicilio['Domicilio']['quantidade_pessoas'] >= 140) {
            $retorno = 1;
        }
        $this->domicilio['Indice']['r5'] = $retorno;
        return $retorno;
    }

    function calculoComponenteCapacidadeGeracao() {
        return $this->r6();
    }

    //R.6 Maior parte da renda familiar não advém de transferências
    function r6() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['valor_beneficio'] > $this->domicilio['Domicilio']['valor_renda_familia']) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['r6'] = $retorno;
        return $retorno;
    }

    function calculoComponenteTrabalhoPrecoce() {
        return ($this->d1() + $this->d2()) / 2;
    }

    //D.1 Ausência de pelo menos uma criança de menos de 10 anos trabalhando
    function d1() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] < Pessoa::IDADE_ADOLESCENTE
                    && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA
                    && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['d1'] = $retorno;
        return $retorno;
    }

    //D.2 Ausência de pelo menos uma criança de menos de 16 anos de trabalhando
    function d2() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] < 16
                    && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA
                    && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['d2'] = $retorno;
        return $retorno;
    }

    function calculoComponenteAcessoEscola() {
        return ($this->d3() + $this->d4() + $this->d5()) / 3;
    }

    //D.3 Ausência de pelo menos uma criança de 0-6 anos fora da escola
    function d3() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] <= 6 && ($pessoa['tipo_escola'] == Pessoa::ESCOLA_NAO_FREQUENTA
                    || $pessoa['tipo_escola'] == Pessoa::ESCOLA_NAO_INFORMADO)) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['d3'] = $retorno;
        return $retorno;
    }

    //D.4 Ausência de pelo menos uma criança de 7-14 anos fora da escola
    function d4() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] >= 7 && $pessoa['idade'] <= 14 && ($pessoa['tipo_escola'] == Pessoa::ESCOLA_NAO_FREQUENTA
                    || $pessoa['tipo_escola'] == Pessoa::ESCOLA_NAO_INFORMADO)) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['d4'] = $retorno;
        return $retorno;
    }

    //D.5 Ausência de pelo menos uma criança de 7-17 anos fora da escola
    function d5() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] >= 7 && $pessoa['idade'] <= 17 && ($pessoa['tipo_escola'] == Pessoa::ESCOLA_NAO_FREQUENTA
                    || $pessoa['tipo_escola'] == Pessoa::ESCOLA_NAO_INFORMADO)) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['d5'] = $retorno;
        return $retorno;
    }

    function calculoComponenteProgressoEscolar() {
        return ($this->d6() + $this->d7() + $this->d8()) / 3;
    }

    //D.6 Ausência de pelo menos uma criança com até 14 anos com mais de 2 anos de atraso
    function d6() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if (($pessoa['idade'] >= 6 && $pessoa['idade'] <= 14) && ($pessoa['idade'] - $pessoa['serie_escolar']) >= 0) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['d6'] = $retorno;
        return $retorno;
    }

    //D.7 Ausência de pelo menos um adolescente de 10 a 14 anos analfabeto
    function d7() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] >= 10 && $pessoa['idade'] <= 14 && (
                    $pessoa['grau_instrucao'] == Pessoa::ESCOLARIDADE_ANALFABETO || $pessoa['grau_instrucao'] == Pessoa::ESCOLARIDADE_NAO_INFORMADO)) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['d7'] = $retorno;
        return $retorno;
    }

    //D.8 Ausência de pelo menos um jovem de 15 a 17 anos analfabeto
    function d8() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] >= 15 && $pessoa['idade'] <= 17 && (
                    $pessoa['grau_instrucao'] == Pessoa::ESCOLARIDADE_ANALFABETO || $pessoa['grau_instrucao'] == Pessoa::ESCOLARIDADE_NAO_INFORMADO)) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['d8'] = $retorno;
        return $retorno;
    }

    function calculoComponentePropriedade() {
        return ($this->h1() + $this->h2()) / 2;
    }

    //H.1 Domicílio próprio
    function h1() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['situacao_domicilio'] != Domicilio::DOMICILIO_PROPRIO) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['h1'] = $retorno;
        return $retorno;
    }

    //H.2 Domicílio próprio, cedido ou invadido
    function h2() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['situacao_domicilio'] != Domicilio::DOMICILIO_PROPRIO &&
                $this->domicilio['Domicilio']['situacao_domicilio'] != Domicilio::DOMICILIO_CEDIDO &&
                $this->domicilio['Domicilio']['situacao_domicilio'] != Domicilio::DOMICILIO_ALUGADO) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['h2'] = $retorno;
        return $retorno;
    }

    function calculoComponenteDeficit() {
        return $this->h3();
    }

    //H.3 Densidade de até 2 moradores por dormitório
    function h3() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['quantidade_pessoas'] / $this->domicilio['Domicilio']['comodos'] > 2) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['h3'] = $retorno;
        return $retorno;
    }

    function calculoComponenteAbrigalidade() {
        return $this->h4();
    }

    //H.4 Material de construção permanente
    function h4() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['tipo_construcao'] != Domicilio::CONSTRUCAO_TIJOLO_ALVENARIA) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['h4'] = $retorno;
        return $retorno;
    }

    function calculoComponenteAcessoAgua() {
        return $this->h5();
    }

    //H.5 Acesso adequado à água
    function h5() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['tipo_abastecimento'] != Domicilio::ABASTECIMENTO_REDE_PUBLICA) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['h5'] = $retorno;
        return $retorno;
    }

    function calculoComponenteAcessoSaneamento() {
        return $this->h6();
    }

    //H.6 Esgotamento sanitário adequado
    function h6() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['escoamento_sanitario'] != Domicilio::ESCOAMENTO_REDE_PUBLICA) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['h6'] = $retorno;
        return $retorno;
    }

    function calculoComponenteAcessoColetaLixo() {
        return $this->h7();
    }

    //H.7 Lixo é coletado
    function h7() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['destino_lixo'] != Domicilio::LIXO_COLETADO) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['h7'] = $retorno;
        return $retorno;
    }

    function calculoComponenteAcessoEletricidade() {
        return $this->h8();
    }

    //H.8 Acesso à eletricidade
    function h8() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['tipo_iluminacao'] != Domicilio::ILUMINACAO_RELOGIO_PROPRIO &&
                $this->domicilio['Domicilio']['tipo_iluminacao'] != Domicilio::ILUMINACAO_RELOGIO_COMUNITARIO) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['h8'] = $retorno;
        return $retorno;
    }

}