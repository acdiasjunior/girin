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
                //'v1' => 1,
                //'v2' => 1,
            ),
            'criancas' => array(
                'v3' => 1,
                'v4' => 1,
                'v5' => 1,
            ),
            'idosos' => array(
                //'v6' => 1,
                'v7' => 1,
            ),
            'dependencia' => array(
                //'v8' => 1,
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
        $gestacao = v1($this->domicilio) + v2($this->domicilio) / 2;
    }
    
    // Ausencia de gestantes
    static function v1(array $domicilio) {
        foreach($domicilio['Pessoa'] as $pessoa) {
            if($pessoa['mes_gestacao'] > 0) {
                $retorno = 0;
            }
        }
        $retorno = 1;
        return $this->domicilio['Indice']['v1'] = $retorno;
    }
    
    // Ausencia de gestantes
    static function v1(array $domicilio) {
        foreach($domicilio['Pessoa'] as $pessoa) {
            if($pessoa['amamentando'] == 1) {
                $retorno = 0;
            }
        }
        $retorno = 1;
        return $this->domicilio['Indice']['v2'] = $retorno;
    }

}