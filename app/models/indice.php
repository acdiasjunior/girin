<?php

class Indice extends AppModel {

    var $name = 'Indice';
    var $useTable = 'indice';
    var $tablePrefix = 'tb_';
    var $primaryKey = 'cod_domiciliar';
    var $hasOne = array(
        'Domicilio' => array(
            'foreignKey' => 'cod_domiciliar',
            'dependent' => false
        ),
    );
    var $hasMany = array(
        'PlanoFamiliar' => array(
            'foreignKey' => 'cod_domiciliar',
        ),
    );
    public $indicadores = array(
        1 => 'vlr_indicador_v1', 'vlr_indicador_v2', 'vlr_indicador_v3', 'vlr_indicador_v4',
        'vlr_indicador_v5', 'vlr_indicador_v6', 'vlr_indicador_v7', 'vlr_indicador_v8',
        'vlr_indicador_v9', 'vlr_indicador_c1', 'vlr_indicador_c2', 'vlr_indicador_c3',
        'vlr_indicador_c4', 'vlr_indicador_c5', 'vlr_indicador_t1', 'vlr_indicador_t2',
        'vlr_indicador_t3', 'vlr_indicador_t4', 'vlr_indicador_t5', 'vlr_indicador_r1',
        'vlr_indicador_r2', 'vlr_indicador_r3', 'vlr_indicador_r4', 'vlr_indicador_r5',
        'vlr_indicador_r6', 'vlr_indicador_d1', 'vlr_indicador_d2', 'vlr_indicador_d3',
        'vlr_indicador_d4', 'vlr_indicador_d5', 'vlr_indicador_d6', 'vlr_indicador_d7',
        'vlr_indicador_d8', 'vlr_indicador_h1', 'vlr_indicador_h2', 'vlr_indicador_h3',
        'vlr_indicador_h4', 'vlr_indicador_h5', 'vlr_indicador_h6', 'vlr_indicador_h7',
        'vlr_indicador_h8', 'vlr_indicador_v10', 'vlr_indicador_v11', 'vlr_indicador_v12'
    );
    public $dimensoes = array(
        'vlr_dimensao_vulnerabilidade' => array(
            'vlr_componente_gestacao' => array(
                'vlr_indicador_v1' => 1,
                'vlr_indicador_v2' => 1,
            ),
            'vlr_componente_crianca' => array(
                'vlr_indicador_v3' => 1,
                'vlr_indicador_v4' => 1,
                'vlr_indicador_v5' => 1,
            ),
            'vlr_componente_idoso' => array(
                'vlr_indicador_v6' => 1,
                'vlr_indicador_v7' => 1,
            ),
            'vlr_componente_dependencia' => array(
                'vlr_indicador_v8' => 1,
                'vlr_indicador_v9' => 1,
            ),
        ),
        'vlr_dimensao_conhecimento' => array(
            'vlr_componente_analfabetismo' => array(
                'vlr_indicador_c1' => 1,
                'vlr_indicador_c2' => 1,
            ),
            'vlr_componente_escolaridade' => array(
                'vlr_indicador_c3' => 0,
                'vlr_indicador_c4' => 0,
                'vlr_indicador_c5' => 0,
            ),
        ),
        'vlr_dimensao_trabalho' => array(
            'vlr_componente_disponibilidade' => array(
                'vlr_indicador_t1' => 0,
            ),
            'vlr_componente_qualidade' => array(
                'vlr_indicador_t2' => 0,
                'vlr_indicador_t3' => 0,
            ),
            'vlr_componente_remuneracao' => array(
                'vlr_indicador_t4' => 0,
                'vlr_indicador_t5' => 0,
            ),
        ),
        'vlr_dimensao_recurso' => array(
            'vlr_componente_extrema_pobreza' => array(
                'vlr_indicador_r1' => 1,
                'vlr_indicador_r2' => 1,
                'vlr_indicador_r3' => 1,
            ),
            'vlr_componente_pobreza' => array(
                'vlr_indicador_r4' => 1,
                'vlr_indicador_r5' => 1,
            ),
            'vlr_componente_capacidade_geracao' => array(
                'vlr_indicador_r6' => 1,
            ),
        ),
        'vlr_dimensao_desenvolvimento' => array(
            'vlr_componente_trabalho_precoce' => array(
                'vlr_indicador_d1' => 1,
                'vlr_indicador_d2' => 1,
            ),
            'vlr_componente_acesso_escola' => array(
                'vlr_indicador_d3' => 1,
                'vlr_indicador_d4' => 1,
                'vlr_indicador_d5' => 1,
            ),
            'vlr_componente_progresso_escolar' => array(
                'vlr_indicador_d6' => 1,
                'vlr_indicador_d7' => 1,
                'vlr_indicador_d8' => 1,
            ),
        ),
        'vlr_dimensao_habitacao' => array(
            'vlr_componente_propriedade' => array(
                'vlr_indicador_h1' => 1,
                'vlr_indicador_h2' => 1,
            ),
            'vlr_componente_deficit' => array(
                'vlr_indicador_h3' => 1,
            ),
            'vlr_componente_abrigalidade' => array(
                'vlr_indicador_h4' => 1,
            ),
            'vlr_componente_acesso_agua' => array(
                'vlr_indicador_h5' => 1,
            ),
            'vlr_componente_acesso_escoamento' => array(
                'vlr_indicador_h6' => 1,
            ),
            'vlr_componente_acesso_coleta_lixo' => array(
                'vlr_indicador_h7' => 1,
            ),
            'vlr_componente_acesso_eletricidade' => array(
                'vlr_indicador_h8' => 1,
            ),
        ),
    );
    var $domicilio = array();
    var $sequence = 'seq_indice';

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
                    $pessoa['tp_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO
                    && $pessoa['tp_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA)
                $idade_ativa_ocupado++;
        }
        return $idade_ativa_ocupado;
    }

    function calcularIndices($domicilio) {
        $this->domicilio = $domicilio;
        // Calculo para Dimensão - Vulnerabilidade
        $vlr_componente_gestacao = Indice::calculoComponenteGestacao();
        $this->domicilio['Indice']['vlr_componente_gestacao'] = $vlr_componente_gestacao;
        $vlr_componente_crianca = Indice::calculoComponenteCriancas();
        $this->domicilio['Indice']['vlr_componente_crianca'] = $vlr_componente_crianca;
        $vlr_componente_idoso = Indice::calculoComponenteIdosos();
        $this->domicilio['Indice']['vlr_componente_idoso'] = $vlr_componente_idoso;
        $vlr_componente_dependencia = Indice::calculoComponenteDependencia();
        $this->domicilio['Indice']['vlr_componente_dependencia'] = $vlr_componente_dependencia;
        $vlr_dimensao_vulnerabilidade = ($vlr_componente_gestacao + $vlr_componente_crianca + $vlr_componente_idoso + $vlr_componente_dependencia) / 4;
        $this->domicilio['Indice']['vlr_dimensao_vulnerabilidade'] = $vlr_dimensao_vulnerabilidade;

        // Calculo para Dimensão - Conhecimento
        $vlr_componente_analfabetismo = Indice::calculoComponenteAnalfabetismo();
        $this->domicilio['Indice']['vlr_componente_analfabetismo'] = $vlr_componente_analfabetismo;
        $vlr_componente_escolaridade = Indice::calculoComponenteEscolaridade();
        $this->domicilio['Indice']['vlr_componente_escolaridade'] = $vlr_componente_escolaridade;
        $vlr_dimensao_conhecimento = ($vlr_componente_analfabetismo + $vlr_componente_escolaridade) / 2;
        $this->domicilio['Indice']['vlr_dimensao_conhecimento'] = $vlr_dimensao_conhecimento;

        // Calculo para Dimensão - Trabalho
        $vlr_componente_disponibilidade = Indice::calculoComponenteDisponibilidade();
        $this->domicilio['Indice']['vlr_componente_disponibilidade'] = $vlr_componente_disponibilidade;
        $vlr_componente_qualidade = Indice::calculoComponenteQualidade();
        $this->domicilio['Indice']['vlr_componente_qualidade'] = $vlr_componente_qualidade;
        $vlr_componente_remuneracao = Indice::calculoComponenteRemuneracao();
        $this->domicilio['Indice']['vlr_componente_remuneracao'] = $vlr_componente_remuneracao;
        $vlr_dimensao_trabalho = ($vlr_componente_disponibilidade + $vlr_componente_qualidade + $vlr_componente_remuneracao) / 3;
        $this->domicilio['Indice']['vlr_dimensao_trabalho'] = $vlr_dimensao_trabalho;

        // Calculo para Dimensao - Recursos
        $vlr_componente_extrema_pobreza = Indice::calculoComponenteExtremaPobreza();
        $this->domicilio['Indice']['vlr_componente_extrema_pobreza'] = $vlr_componente_extrema_pobreza;
        $vlr_componente_pobreza = Indice::calculoComponentePobreza();
        $this->domicilio['Indice']['vlr_componente_pobreza'] = $vlr_componente_pobreza;
        $vlr_componente_capacidade_geracao = Indice::calculoComponenteCapacidadeGeracao();
        $this->domicilio['Indice']['vlr_componente_capacidade_geracao'] = $vlr_componente_capacidade_geracao;
        $vlr_dimensao_recurso = ($vlr_componente_extrema_pobreza + $vlr_componente_pobreza + $vlr_componente_capacidade_geracao) / 3;
        $this->domicilio['Indice']['vlr_dimensao_recurso'] = $vlr_dimensao_recurso;

        // Calculo para Dimensao - Desenvolvimento Infantil
        $vlr_componente_trabalho_precoce = Indice::calculoComponenteTrabalhoPrecoce();
        $this->domicilio['Indice']['vlr_componente_trabalho_precoce'] = $vlr_componente_trabalho_precoce;
        $vlr_componente_acesso_escola = Indice::calculoComponenteAcessoEscola();
        $this->domicilio['Indice']['vlr_componente_acesso_escola'] = $vlr_componente_acesso_escola;
        $vlr_componente_progresso_escolar = Indice::calculoComponenteProgressoEscolar();
        $this->domicilio['Indice']['vlr_componente_progresso_escolar'] = $vlr_componente_progresso_escolar;
        $vlr_dimensao_desenvolvimento = ($vlr_componente_trabalho_precoce + $vlr_componente_acesso_escola + $vlr_componente_progresso_escolar) / 3;
        $this->domicilio['Indice']['vlr_dimensao_desenvolvimento'] = $vlr_dimensao_desenvolvimento;

        // Calculo para Dimensao - Habitação
        $vlr_componente_propriedade = Indice::calculoComponentePropriedade();
        $this->domicilio['Indice']['vlr_componente_propriedade'] = $vlr_componente_propriedade;
        $vlr_componente_deficit = Indice::calculoComponenteDeficit();
        $this->domicilio['Indice']['vlr_componente_deficit'] = $vlr_componente_deficit;
        $vlr_componente_abrigalidade = Indice::calculoComponenteAbrigalidade();
        $this->domicilio['Indice']['vlr_componente_abrigalidade'] = $vlr_componente_abrigalidade;
        $vlr_componente_acesso_agua = Indice::calculoComponenteAcessoAgua();
        $this->domicilio['Indice']['vlr_componente_acesso_agua'] = $vlr_componente_acesso_agua;
        $vlr_componente_acesso_escoamento = Indice::calculoComponenteAcessoEscoamento();
        $this->domicilio['Indice']['vlr_componente_acesso_escoamento'] = $vlr_componente_acesso_escoamento;
        $vlr_componente_acesso_coleta_lixo = Indice::calculoComponenteAcessoColetaLixo();
        $this->domicilio['Indice']['vlr_componente_acesso_coleta_lixo'] = $vlr_componente_acesso_coleta_lixo;
        $vlr_componente_acesso_eletricidade = Indice::calculoComponenteAcessoEletricidade();
        $this->domicilio['Indice']['vlr_componente_acesso_eletricidade'] = $vlr_componente_acesso_eletricidade;
        $vlr_dimensao_habitacao = ($vlr_componente_propriedade + $vlr_componente_deficit + $vlr_componente_abrigalidade +
                $vlr_componente_acesso_agua + $vlr_componente_acesso_escoamento +
                $vlr_componente_acesso_coleta_lixo + $vlr_componente_acesso_eletricidade) / 7;
        $this->domicilio['Indice']['vlr_dimensao_habitacao'] = $vlr_dimensao_habitacao;

        // Calculo do IDF da Familia
        $idf = round(($vlr_dimensao_vulnerabilidade + $vlr_dimensao_conhecimento + $vlr_dimensao_trabalho +
                $vlr_dimensao_recurso + $vlr_dimensao_desenvolvimento + $vlr_dimensao_habitacao) / 6, 2);

        $this->domicilio['Indice']['vlr_idf'] = $idf;
        $this->domicilio['Domicilio']['vlr_idf'] = $idf;
        return $this->domicilio;
    }

    function calculoComponenteGestacao() {
        return ($this->v1() + $this->v2()) / 2;
    }

    // V.1 Ausencia de gestantes
    function v1() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['qtd_mes_gestacao'] > 0) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['vlr_indicador_v1'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_v2'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_v3'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_v4'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_v5'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_v6'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_v7'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_v8'] = $retorno;
        return $retorno;
    }

    //V.9 Mais da metade dos membros encontra-se em idade ativa
    function v9() {
        $retorno = 0;
        if ($this->domicilio['Domicilio']['qtd_pessoa'] / 2 < $this->contadorMembrosIdadeAtiva()) {
            $retorno = 1;
        }
        $this->domicilio['Indice']['vlr_indicador_v9'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_c1'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_c2'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_c3'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_c4'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_c5'] = $retorno;
        return $retorno;
    }

    function calculoComponenteDisponibilidade() {
        return $this->t1();
    }

    //T.1 Mais da metade dos membros em idade ativa encontram-se ocupados
    function t1() {
        $retorno = 0;
        if ($this->contadorMembrosIdadeAtivaOcupados() > $this->domicilio['Domicilio']['qtd_pessoa'] / 2) {
            $retorno = 1;
        }
        $this->domicilio['Indice']['vlr_indicador_t1'] = $retorno;
        return $retorno;
    }

    function calculoComponenteQualidade() {
        return ($this->t2() + $this->t3()) / 2;
    }

    //T.2 Presença de pelo menos um ocupado no setor formal
    function t2() {
        $retorno = 0;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['tp_trabalho'] == Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA
                    || $pessoa['tp_trabalho'] == Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA) {
                $retorno = 1;
                break;
            }
        }
        $this->domicilio['Indice']['vlr_indicador_t2'] = $retorno;
        return $retorno;
    }

    //T.3 Presença de pelo menos um ocupado em atividade não agrícola
    function t3() {
        $retorno = 0;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['tp_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA &&
                    $pessoa['tp_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO &&
                    $pessoa['tp_trabalho'] != Pessoa::TRABALHO_TRABALHADOR_RURAL
                    && $pessoa['tp_trabalho'] != Pessoa::TRABALHO_EMPREGADOR_RURAL) {
                $retorno = 1;
                break;
            }
        }
        $this->domicilio['Indice']['vlr_indicador_t3'] = $retorno;
        return $retorno;
    }

    function calculoComponenteRemuneracao() {
        return ($this->t4() + $this->t5()) / 2;
    }

    //T.4 Presença de pelo menos um ocupado com rendimento superior a 1 salário mínimo
    function t4() {
        $retorno = 0;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['tp_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA
                    && $pessoa['tp_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO
                    && $pessoa['vlr_remuneracao'] > 545) {
                $retorno = 1;
                break;
            }
        }
        $this->domicilio['Indice']['vlr_indicador_t4'] = $retorno;
        return $retorno;
    }

    //T.5 Presença de pelo menos um ocupado com rendimento superior a 2 salários mínimos
    function t5() {
        $retorno = 0;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['tp_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA
                    && $pessoa['tp_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO
                    && $pessoa['vlr_remuneracao'] > (545 * 2)) {
                $retorno = 1;
                break;
            }
        }
        $this->domicilio['Indice']['vlr_indicador_t5'] = $retorno;
        return $retorno;
    }

    function calculoComponenteExtremaPobreza() {
        return ($this->r1() + $this->r2() + $this->r3()) / 3;
    }

    //R.1 Despesa familiar per capita superior a linha de extema vlr_componente_pobreza
    function r1() {
        $retorno = 0;
        if ($this->domicilio['Domicilio']['qtd_pessoa'] > 0 && $this->domicilio['Domicilio']['vlr_despesa_familia'] / $this->domicilio['Domicilio']['qtd_pessoa'] >= 70) {
            $retorno = 1;
        }
        $this->domicilio['Indice']['vlr_indicador_r1'] = $retorno;
        return $retorno;
    }

    //R.2 Renda familiar per capita superior a linha de extrema vlr_componente_pobreza
    function r2() {
        $retorno = 0;
        if ($this->domicilio['Domicilio']['vlr_renda_familia'] / $this->domicilio['Domicilio']['qtd_pessoa'] >= 70) {
            $retorno = 1;
        }
        $this->domicilio['Indice']['vlr_indicador_r2'] = $retorno;
        return $retorno;
    }

    //R.3 Despesa com alimentos superior a linha de extema vlr_componente_pobreza
    function r3() {
        $retorno = 0;
        if ($this->domicilio['Domicilio']['vlr_despesa_alimentacao'] >= 70) {
            $retorno = 1;
        }
        $this->domicilio['Indice']['vlr_indicador_r3'] = $retorno;
        return $retorno;
    }

    function calculoComponentePobreza() {
        return ($this->r4() + $this->r5()) / 2;
    }

    //R.4 Despesa familiar per capita superior a linha de vlr_componente_pobreza
    function r4() {
        $retorno = 0;
        if ($this->domicilio['Domicilio']['vlr_despesa_familia'] / $this->domicilio['Domicilio']['qtd_pessoa'] >= 140) {
            $retorno = 1;
        }
        $this->domicilio['Indice']['vlr_indicador_r4'] = $retorno;
        return $retorno;
    }

    //R.5 Renda familiar per capita superior a linha de vlr_componente_pobreza
    function r5() {
        $retorno = 0;
        if ($this->domicilio['Domicilio']['vlr_renda_familia'] / $this->domicilio['Domicilio']['qtd_pessoa'] >= 140) {
            $retorno = 1;
        }
        $this->domicilio['Indice']['vlr_indicador_r5'] = $retorno;
        return $retorno;
    }

    function calculoComponenteCapacidadeGeracao() {
        return $this->r6();
    }

    //R.6 Maior parte da renda familiar não advém de transferências
    function r6() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['vlr_beneficio'] > $this->domicilio['Domicilio']['vlr_renda_familia']) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['vlr_indicador_r6'] = $retorno;
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
                    && $pessoa['tp_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA
                    && $pessoa['tp_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['vlr_indicador_d1'] = $retorno;
        return $retorno;
    }

    //D.2 Ausência de pelo menos uma criança de menos de 16 anos de trabalhando
    function d2() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] < 16
                    && $pessoa['tp_trabalho'] != Pessoa::TRABALHO_NAO_TRABALHA
                    && $pessoa['tp_trabalho'] != Pessoa::TRABALHO_NAO_INFORMADO) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['vlr_indicador_d2'] = $retorno;
        return $retorno;
    }

    function calculoComponenteAcessoEscola() {
        return ($this->d3() + $this->d4() + $this->d5()) / 3;
    }

    //D.3 Ausência de pelo menos uma criança de 0-6 anos fora da escola
    function d3() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] <= 6 && ($pessoa['tp_escola'] == Pessoa::ESCOLA_NAO_FREQUENTA
                    || $pessoa['tp_escola'] == Pessoa::ESCOLA_NAO_INFORMADO)) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['vlr_indicador_d3'] = $retorno;
        return $retorno;
    }

    //D.4 Ausência de pelo menos uma criança de 7-14 anos fora da escola
    function d4() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] >= 7 && $pessoa['idade'] <= 14 && ($pessoa['tp_escola'] == Pessoa::ESCOLA_NAO_FREQUENTA
                    || $pessoa['tp_escola'] == Pessoa::ESCOLA_NAO_INFORMADO)) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['vlr_indicador_d4'] = $retorno;
        return $retorno;
    }

    //D.5 Ausência de pelo menos uma criança de 7-17 anos fora da escola
    function d5() {
        $retorno = 1;
        foreach ($this->domicilio['Pessoa'] as $pessoa) {
            if ($pessoa['idade'] >= 7 && $pessoa['idade'] <= 17 && ($pessoa['tp_escola'] == Pessoa::ESCOLA_NAO_FREQUENTA
                    || $pessoa['tp_escola'] == Pessoa::ESCOLA_NAO_INFORMADO)) {
                $retorno = 0;
                break;
            }
        }
        $this->domicilio['Indice']['vlr_indicador_d5'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_d6'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_d7'] = $retorno;
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
        $this->domicilio['Indice']['vlr_indicador_d8'] = $retorno;
        return $retorno;
    }

    function calculoComponentePropriedade() {
        return ($this->h1() + $this->h2()) / 2;
    }

    //H.1 Domicílio próprio
    function h1() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['tp_situacao_domicilio'] != Domicilio::DOMICILIO_PROPRIO) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['vlr_indicador_h1'] = $retorno;
        return $retorno;
    }

    //H.2 Domicílio próprio, cedido ou invadido
    function h2() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['tp_situacao_domicilio'] != Domicilio::DOMICILIO_PROPRIO &&
                $this->domicilio['Domicilio']['tp_situacao_domicilio'] != Domicilio::DOMICILIO_CEDIDO &&
                $this->domicilio['Domicilio']['tp_situacao_domicilio'] != Domicilio::DOMICILIO_ALUGADO) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['vlr_indicador_h2'] = $retorno;
        return $retorno;
    }

    function calculoComponenteDeficit() {
        return $this->h3();
    }

    //H.3 Densidade de até 2 moradores por dormitório
    function h3() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['qtd_pessoa'] / $this->domicilio['Domicilio']['qtd_comodo'] > 2) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['vlr_indicador_h3'] = $retorno;
        return $retorno;
    }

    function calculoComponenteAbrigalidade() {
        return $this->h4();
    }

    //H.4 Material de construção permanente
    function h4() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['tp_construcao'] != Domicilio::CONSTRUCAO_TIJOLO_ALVENARIA) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['vlr_indicador_h4'] = $retorno;
        return $retorno;
    }

    function calculoComponenteAcessoAgua() {
        return $this->h5();
    }

    //H.5 Acesso adequado à água
    function h5() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['tp_abastecimento'] != Domicilio::ABASTECIMENTO_REDE_PUBLICA) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['vlr_indicador_h5'] = $retorno;
        return $retorno;
    }

    function calculoComponenteAcessoEscoamento() {
        return $this->h6();
    }

    //H.6 Esgotamento sanitário adequado
    function h6() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['tp_escoamento_sanitario'] != Domicilio::ESCOAMENTO_REDE_PUBLICA) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['vlr_indicador_h6'] = $retorno;
        return $retorno;
    }

    function calculoComponenteAcessoColetaLixo() {
        return $this->h7();
    }

    //H.7 Lixo é coletado
    function h7() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['tp_destino_lixo'] != Domicilio::LIXO_COLETADO) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['vlr_indicador_h7'] = $retorno;
        return $retorno;
    }

    function calculoComponenteAcessoEletricidade() {
        return $this->h8();
    }

    //H.8 Acesso à eletricidade
    function h8() {
        $retorno = 1;
        if ($this->domicilio['Domicilio']['tp_iluminacao'] != Domicilio::ILUMINACAO_RELOGIO_PROPRIO &&
                $this->domicilio['Domicilio']['tp_iluminacao'] != Domicilio::ILUMINACAO_RELOGIO_COMUNITARIO) {
            $retorno = 0;
        }
        $this->domicilio['Indice']['vlr_indicador_h8'] = $retorno;
        return $retorno;
    }

}