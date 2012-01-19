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
    private $domicilio = array();

    static function calcularIndices(array $domicilio) {
        $this->domicilio = $domicilio;

        // Calculo para Dimensão - Vulnerabilidade
        $gestacao = $this->calculoComponenteGestacao();
        $criancas = $this->calculoComponenteCriancas();
        $idosos = $this->calculoComponenteIdosos();
        $dependencia = $this->calculoComponenteDependencia();
        $vulnerabilidade = ($gestacao + $criancas + $idosos + $dependencia) / 4;

        // Calculo para Dimensão - Conhecimento
        $analfabetismo = $this->calculoComponenteAnalfabetismo();
        $escolaridade = $this->calculoComponenteEscolaridade();
    }

    private function calculoComponenteGestacao() {

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

        return (v1() + v2()) / 2;
    }

    private function calculoComponenteCriancas() {

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

        return (v3() + v4() + v5()) / 3;
    }

    private function calculoComponenteIdosos() {

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

        return (v6() + v7()) / 2;
    }

    private function calculoComponenteDependencia() {

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

        // V.9 IMPLEMENTAR CALCULO DE FUNÇÃO GENERICA COM TOTALIZADORES PARA ESTA FUNÇÃO E DEMAIS

        return (v8() + v9()) / 2;
    }

    private function calculoComponenteAnalfabetismo() {

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

        return (c1() + c2()) / 2;
    }

    private function calculoComponenteEscolaridade() {

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

        return (c3() + c4() + c5()) / 3;
    }

}