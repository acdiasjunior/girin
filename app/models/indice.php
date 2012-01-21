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
                //'r1' => 1,
                'r2' => 1,
            //'r3' => 1,
            ),
            'pobreza' => array(
                //'r4' => 1,
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
            //T.1 Mais da metade dos membros em idade ativa encontram-se ocupados
            if ($pessoa['idade'] >= Pessoa::IDADE_ADOLESCENTE &&
                    $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO
                    && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA)
                $contador['idade_ativa_ocupado']++;
        }

        return $idade_ativa_ocupado;
    }

    function calcularIndices($domicilio) {
        $this->domicilio = $domicilio;
        // Calculo para Dimensão - Vulnerabilidade
        $gestacao = Indice::calculoComponenteGestacao();
        $criancas = Indice::calculoComponenteCriancas();
        $idosos = Indice::calculoComponenteIdosos();
        $dependencia = Indice::calculoComponenteDependencia();
        $vulnerabilidade = ($gestacao + $criancas + $idosos + $dependencia) / 4;
        $this->domicilio['Indice']['vulnerabilidade'] = $vulnerabilidade;

        // Calculo para Dimensão - Conhecimento
        $analfabetismo = Indice::calculoComponenteAnalfabetismo();
        $escolaridade = Indice::calculoComponenteEscolaridade();
        $conhecimento = ($analfabetismo + $vulnerabilidade) / 2;
        $this->domicilio['Indice']['conhecimento'] = $conhecimento;

        // Calculo para Dimensão - Trabalho
        $disponibilidade = Indice::calculoComponenteDisponibilidade();
        $qualidade = Indice::calculoComponenteQualidade();
        $remuneracao = Indice::calculoComponenteRemuneracao();
        $trabalho = ($disponibilidade + $qualidade + $remuneracao) / 3;
        $this->domicilio['Indice']['trabalho'] = $trabalho;

        // Calculo para Dimensao - Recursos
        $extremaPobreza = Indice::calculoComponenteExtremaPobreza();
        $pobreza = Indice::calculoComponentePobreza();
        $capacidadeGeracao = Indice::calculoComponenteCapacidadeGeracao();
        $recursos = ($extremaPobreza + $pobreza + $capacidadeGeracao) / 3;
        $this->domicilio['Indice']['recursos'] = $recursos;

        // Calculo para Dimensao - Desenvolvimento Infantil
        $trabalhoPrecoce = Indice::calculoComponenteTrabalhoPrecoce();
        $acessoEscola = Indice::calculoComponenteAcessoEscola();
        $progressoEscolar = Indice::calculoComponenteProgressoEscolar();
        $desenvolvimento = ($trabalhoPrecoce + $acessoEscola + $progressoEscolar) / 3;
        $this->domicilio['Indice']['desenvolvimento'] = $desenvolvimento;

        // Calculo para Dimensao - Habitação
        $propriedade = Indice::calculoComponentePropriedade();
        $deficit = Indice::calculoComponenteDeficit();
        $abrigalidade = Indice::calculoComponenteAbrigalidade();
        $acessoAgua = Indice::calculoComponenteAcessoAgua();
        $acessoSaneamento = Indice::calculoComponenteAcessoSaneamento();
        $acessoColetaLixo = Indice::calculoComponenteAcessoColetaLixo();
        $acessoEletricidade = Indice::calculoComponenteAcessoEletricidade();
        $habitacao = ($propriedade + $deficit + $abrigalidade +
                $acessoAgua + $acessoSaneamento +
                $acessoColetaLixo + $acessoEletricidade) / 7;
        $this->domicilio['Indice']['habitacao'] = $habitacao;

        // Calculo do IDF da Familia
        $idf = ($vulnerabilidade + $conhecimento + $trabalho +
                $recursos + $desenvolvimento + $habitacao) / 6;

        $this->domicilio['Indice']['idf'] = $idf;
        return $this->domicilio;
    }

    function calculoComponenteGestacao() {

        // V.1 Ausencia de gestantes
        function v1($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['mes_gestacao'] > 0) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['v1'] = $retorno;
            return $retorno;
        }

        // V.2 Ausencia de gestantes
        function v2($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['amamentando'] == 1) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['v2'] = $retorno;
            return $retorno;
        }

        return (v1($this) + v2($this)) / 2;
    }

    function calculoComponenteCriancas() {

        //V.3 Ausência de crianças
        function v3($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] < Pessoa::IDADE_ADOLESCENTE) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['v3'] = $retorno;
            return $retorno;
        }

        //V.4 Ausência de crianças e adolescente
        function v4($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] < Pessoa::IDADE_JOVEM) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['v4'] = $retorno;
            return $retorno;
        }

        //V.5  Ausência de crianças, adolescente e jovens
        function v5($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] < Pessoa::IDADE_ADULTO) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['v5'] = $retorno;
            return $retorno;
        }

        return (v3($this) + v4($this) + v5($this)) / 3;
    }

    function calculoComponenteIdosos() {

        //V.6 Ausência de portadores de deficiência
        function v6($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['portador_deficiencia'] == 1) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['v6'] = $retorno;
            return $retorno;
        }

        //V.7 Ausência de Idosos
        function v7($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] >= Pessoa::IDADE_IDOSO) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['v7'] = $retorno;
            return $retorno;
        }

        return (v6($this) + v7($this)) / 2;
    }

    function calculoComponenteDependencia() {

        // V.8 Presença de cônjuge
        function v8($indice) {
            $retorno = 0;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['esposa_companheiro'] == 1) {
                    $retorno = 1;
                    break;
                }
            }
            $indice->domicilio['Indice']['v8'] = $retorno;
            return $retorno;
        }

        //V.9 Mais da metade dos membros encontra-se em idade ativa
        function v9($indice) {
            $retorno = 0;
            if ($indice->domicilio['Domicilio']['quantidade_pessoas'] / 2 < $indice->contadorMembrosIdadeAtiva()) {
                $retorno = 1;
            }
            $indice->domicilio['Indice']['v9'] = $retorno;
            return $retorno;
        }

        return (v8($this) + v9($this)) / 2;
    }

    function calculoComponenteAnalfabetismo() {

        //C.1 Ausência de Adultos Analfabetos
        function c1($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] >= Pessoa::IDADE_ADULTO && $pessoa['grau_instrucao'] < Pessoa::ESCOLARIDADE_ATE_4A_INCOMPLETA) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['c1'] = $retorno;
            return $retorno;
        }

        //C.2 Ausência de Adultos Analfabetos Funcionais
        function c2($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] >= Pessoa::IDADE_ADULTO && $pessoa['grau_instrucao'] < Pessoa::ESCOLARIDADE_4A_COMPLETA) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['c2'] = $retorno;
            return $retorno;
        }

        return (c1($this) + c2($this)) / 2;
    }

    function calculoComponenteEscolaridade() {

        //C.3 Presença de pelo menos um adulto com fundamental completo
        function c3($indice) {
            $retorno = 0;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] >= Pessoa::IDADE_ADULTO) {
                    if ($pessoa['grau_instrucao'] >= Pessoa::ESCOLARIDADE_FUNDAMENTAL_COMPLETO) {
                        $retorno = 1;
                        break;
                    }
                }
            }
            $indice->domicilio['Indice']['c3'] = $retorno;
            return $retorno;
        }

        //C.4 Presença de pelo menos um adulto com secundário completo
        function c4($indice) {
            $retorno = 0;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] >= Pessoa::IDADE_ADULTO) {
                    if ($pessoa['grau_instrucao'] >= Pessoa::ESCOLARIDADE_MEDIO_COMPLETO) {
                        $retorno = 1;
                        break;
                    }
                }
            }
            $indice->domicilio['Indice']['c4'] = $retorno;
            return $retorno;
        }

        //C.5 Presença de pelo menos um adulto com alguma educação superior
        function c5($indice) {
            $retorno = 0;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] >= Pessoa::IDADE_ADULTO) {
                    if ($pessoa['grau_instrucao'] >= Pessoa::ESCOLARIDADE_SUPERIOR_INCOMPLETO) {
                        $retorno = 1;
                        break;
                    }
                }
            }
            $indice->domicilio['Indice']['c5'] = $retorno;
            return $retorno;
        }

        return (c3($this) + c4($this) + c5($this)) / 3;
    }

    function calculoComponenteDisponibilidade() {

        //T.1 Mais da metade dos membros em idade ativa encontram-se ocupados
        function t1($indice) {
            $retorno = 0;
            if ($indice->domicilio['Domicilio']['quantidade_pessoas'] / 2 < $indice->contadorMembrosIdadeAtivaOcupados()) {
                $retorno = 1;
            }
            $indice->domicilio['Indice']['t1'] = $retorno;
            return $retorno;
        }

        return t1($this);
    }

    function calculoComponenteQualidade() {

        //T.2 Presença de pelo menos um ocupado no setor formal
        function t2($indice) {
            $retorno = 0;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['tipo_trabalho'] == Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA
                        || $pessoa['tipo_trabalho'] == Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA) {
                    $retorno = 1;
                    break;
                }
            }
            $indice->domicilio['Indice']['t2'] = $retorno;
            return $retorno;
        }

        //T.3 Presença de pelo menos um ocupado em atividade não agrícola
        function t3($indice) {
            $retorno = 0;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA &&
                        $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO &&
                        $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_TRABALHADOR_RURAL
                        && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_EMPREGADOR_RURAL) {
                    $retorno = 1;
                    break;
                }
            }
            $indice->domicilio['Indice']['t3'] = $retorno;
            return $retorno;
        }

        return (t2($this) + t3($this)) / 2;
    }

    function calculoComponenteRemuneracao() {

        //T.4 Presença de pelo menos um ocupado com rendimento superior a 1 salário mínimo
        function t4($indice) {
            $retorno = 0;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA
                        && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO
                        && $pessoa['valor_renda'] > 545) {
                    $retorno = 1;
                    break;
                }
            }
            $indice->domicilio['Indice']['t4'] = $retorno;
            return $retorno;
        }

        //T.5 Presença de pelo menos um ocupado com rendimento superior a 2 salários mínimos
        function t5($indice) {
            $retorno = 0;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA
                        && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO
                        && $pessoa['valor_renda'] > (545 * 2)) {
                    $retorno = 1;
                    break;
                }
            }
            $indice->domicilio['Indice']['t5'] = $retorno;
            return $retorno;
        }

        return (t4($this) + t5($this)) / 2;
    }

    function calculoComponenteExtremaPobreza() {

        //R.1 Despesa familiar per capita superior a linha de extema pobreza
        function r1($indice) {
            $retorno = 0;
            if ($indice->domicilio['Domicilio']['valor_despesa_familia'] / $indice->domicilio['Domicilio']['quantidade_pessoas'] >= 70) {
                $retorno = 1;
            }
            $indice->domicilio['Indice']['r1'] = $retorno;
            return $retorno;
        }

        //R.2 Renda familiar per capita superior a linha de  pobreza
        function r2($indice) {
            $retorno = 0;
            if ($indice->domicilio['Domicilio']['valor_renda_familia'] / $indice->domicilio['Domicilio']['quantidade_pessoas'] >= 70) {
                $retorno = 1;
            }
            $indice->domicilio['Indice']['r2'] = $retorno;
            return $retorno;
        }

        //R.3 Despesa com alimentos superior a linha de extema pobreza
        function r3($indice) {
            $retorno = 0;
            if ($indice->domicilio['Domicilio']['valor_despesa_alimentacao'] >= 70) {
                $retorno = 1;
            }
            $indice->domicilio['Indice']['r3'] = $retorno;
            return $retorno;
        }

        return (r1($this) + r2($this) + r3($this)) / 3;
    }

    function calculoComponentePobreza() {

        //R.4 Despesa familiar per capita superior a linha de pobreza
        function r4($indice) {
            $retorno = 0;
            if ($indice->domicilio['Domicilio']['valor_despesa_familia'] / $indice->domicilio['Domicilio']['quantidade_pessoas'] >= 140) {
                $retorno = 1;
            }
            $indice->domicilio['Indice']['r4'] = $retorno;
            return $retorno;
        }

        //R.5 Renda familiar per capita superior a linha de pobreza
        function r5($indice) {
            $retorno = 0;
            if ($indice->domicilio['Domicilio']['valor_renda_familia'] >= 140) {
                $retorno = 1;
            }
            $indice->domicilio['Indice']['r5'] = $retorno;
            return $retorno;
        }

        return (r4($this) + r5($this)) / 2;
    }

    function calculoComponenteCapacidadeGeracao() {

        //R.6 Maior parte da renda familiar não advém de transferências
        function r6($indice) {
            $retorno = 0;
            if ($indice->domicilio['Domicilio']['valor_renda_familia'] > $indice->domicilio['Domicilio']['valor_beneficio_familia']) {
                $retorno = 1;
            }
            $indice->domicilio['Indice']['r6'] = $retorno;
            return $retorno;
        }

        return r6($this);
    }

    function calculoComponenteTrabalhoPrecoce() {

        //D.1 Ausência de pelo menos uma criança de menos de 10 anos trabalhando
        function d1($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] < Pessoa::IDADE_ADOLESCENTE
                        && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA
                        && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['d1'] = $retorno;
            return $retorno;
        }

        //D.2 Ausência de pelo menos uma criança de menos de 16 anos de trabalhando
        function d2($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] < 16
                        && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA
                        && $pessoa['tipo_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['d2'] = $retorno;
            return $retorno;
        }

        return (d1($this) + d2($this)) / 2;
    }

    function calculoComponenteAcessoEscola() {

        //D.3 Ausência de pelo menos uma criança de 0-6 anos fora da escola
        function d3($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] <= 6 && ($pessoa['tipo_escola'] == Pessoa::ESCOLA_NAO_FREQUENTA
                        || $pessoa['tipo_escola'] == Pessoa::ESCOLA_NAO_INFORMADO)) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['d3'] = $retorno;
            return $retorno;
        }

        //D.4 Ausência de pelo menos uma criança de 7-14 anos fora da escola
        function d4($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] >= 7 && $pessoa['idade'] <= 14 && ($pessoa['tipo_escola'] == Pessoa::ESCOLA_NAO_FREQUENTA
                        || $pessoa['tipo_escola'] == Pessoa::ESCOLA_NAO_INFORMADO)) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['d4'] = $retorno;
            return $retorno;
        }

        //D.5 Ausência de pelo menos uma criança de 7-17 anos fora da escola
        function d5($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] >= 7 && $pessoa['idade'] <= 17 && ($pessoa['tipo_escola'] == Pessoa::ESCOLA_NAO_FREQUENTA
                        || $pessoa['tipo_escola'] == Pessoa::ESCOLA_NAO_INFORMADO)) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['d5'] = $retorno;
            return $retorno;
        }

        return (d3($this) + d4($this) + d5($this)) / 3;
    }

    function calculoComponenteProgressoEscolar() {

        //D.6 Ausência de pelo menos uma criança com até 14 anos com mais de 2 anos de atraso
        function d6($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if (($pessoa['idade'] >= 6 && $pessoa['idade'] <= 14) && ($pessoa['idade'] - $pessoa['serie_escolar']) >= 0) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['d6'] = $retorno;
            return $retorno;
        }

        //D.7 Ausência de pelo menos um adolescente de 10 a 14 anos analfabeto
        function d7($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] >= 10 && $pessoa['idade'] <= 14 && (
                        $pessoa['grau_instrucao'] == Pessoa::ESCOLARIDADE_ANALFABETO || $pessoa['grau_instrucao'] == Pessoa::ESCOLARIDADE_NAO_INFORMADO)) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['d7'] = $retorno;
            return $retorno;
        }

        //D.8 Ausência de pelo menos um jovem de 15 a 17 anos analfabeto
        function d8($indice) {
            $retorno = 1;
            foreach ($indice->domicilio['Pessoa'] as $pessoa) {
                if ($pessoa['idade'] >= 15 && $pessoa['idade'] <= 17 && (
                        $pessoa['grau_instrucao'] == Pessoa::ESCOLARIDADE_ANALFABETO || $pessoa['grau_instrucao'] == Pessoa::ESCOLARIDADE_NAO_INFORMADO)) {
                    $retorno = 0;
                    break;
                }
            }
            $indice->domicilio['Indice']['d8'] = $retorno;
            return $retorno;
        }

        return (d6($this) + d7($this) + d8($this)) / 3;
    }

    function calculoComponentePropriedade() {

        //H.1 Domicílio próprio
        function h1($indice) {
            $retorno = 1;
            if ($indice->domicilio['situacao_domicilio'] != Domicilio::DOMICILIO_PROPRIO) {
                $retorno = 0;
            }
            $indice->domicilio['Indice']['h1'] = $retorno;
            return $retorno;
        }

        //H.2 Domicílio próprio, cedido ou invadido
        function h2($indice) {
            $retorno = 1;
            if ($indice->domicilio['situacao_domicilio'] != Domicilio::DOMICILIO_PROPRIO &&
                    $indice->domicilio['situacao_domicilio'] != Domicilio::DOMICILIO_CEDIDO &&
                    $indice->domicilio['situacao_domicilio'] != Domicilio::DOMICILIO_ALUGADO) {
                $retorno = 0;
            }
            $indice->domicilio['Indice']['h2'] = $retorno;
            return $retorno;
        }

        return (h1($this) + h2($this)) / 2;
    }

    function calculoComponenteDeficit() {

        //H.3 Densidade de até 2 moradores por dormitório
        function h3($indice) {
            $retorno = 1;
            if ($indice->domicilio['quantidade_pessoas'] / $indice->domicilio['comodos'] > 2) {
                $retorno = 0;
            }
            $indice->domicilio['Indice']['h3'] = $retorno;
            return $retorno;
        }

        return h3($this);
    }

    function calculoComponenteAbrigalidade() {

        //H.4 Material de construção permanente
        function h4($indice) {
            $retorno = 1;
            if ($indice->domicilio['tipo_construcao'] != Domicilio::CONSTRUCAO_TIJOLO_ALVENARIA) {
                $retorno = 0;
            }
            $indice->domicilio['Indice']['h4'] = $retorno;
            return $retorno;
        }

        return h4($this);
    }

    function calculoComponenteAcessoAgua() {

        //H.5 Acesso adequado à água
        function h5($indice) {
            $retorno = 1;
            if ($indice->domicilio['tipo_abastecimento'] != Domicilio::ABASTECIMENTO_REDE_PUBLICA) {
                $retorno = 0;
            }
            $indice->domicilio['Indice']['h5'] = $retorno;
            return $retorno;
        }

        return h5($this);
    }

    function calculoComponenteAcessoSaneamento() {

        //H.6 Esgotamento sanitário adequado
        function h6($indice) {
            $retorno = 1;
            if ($indice->domicilio['escoamento_sanitario'] != Domicilio::ESCOAMENTO_REDE_PUBLICA) {
                $retorno = 0;
            }
            $indice->domicilio['Indice']['h6'] = $retorno;
            return $retorno;
        }

        return h6($this);
    }

    function calculoComponenteAcessoColetaLixo() {

        //H.7 Lixo é coletado
        function h7($indice) {
            $retorno = 1;
            if ($indice->domicilio['destino_lixo'] != Domicilio::LIXO_COLETADO) {
                $retorno = 0;
            }
            $indice->domicilio['Indice']['h7'] = $retorno;
            return $retorno;
        }

        return h7($this);
    }

    function calculoComponenteAcessoEletricidade() {

        //H.8 Acesso à eletricidade
        function h8($indice) {
            $retorno = 1;
            if ($indice->domicilio['tipo_iluminacao'] != Domicilio::ILUMINACAO_RELOGIO_PROPRIO &&
                    $indice->domicilio['tipo_iluminacao'] != Domicilio::ILUMINACAO_RELOGIO_COMUNITARIO) {
                $retorno = 0;
            }
            $indice->domicilio['Indice']['h8'] = $retorno;
            return $retorno;
        }

        return h8($this);
    }

}