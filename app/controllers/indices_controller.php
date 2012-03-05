<?php

class IndicesController extends AppController {

    var $name = 'Indices';
    var $helpers = array('Javascript', 'Js');
    var $components = array('RequestHandler');

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
                    WHEN "Indice"."idf" <= 0.62 THEN \'ate06\'
                    WHEN "Indice"."idf" > 0.62 AND "Indice"."idf" <= 0.7 THEN \'de06a07\'
                    WHEN "Indice"."idf" > 0.7 AND "Indice"."idf" <= 0.8 THEN \'de07a08\'
                    WHEN "Indice"."idf" > 0.8 AND "Indice"."idf" <= 0.9 THEN \'de08a09\'
                    WHEN "Indice"."idf" > 0.9 THEN \'maior09\'
                 END) AS indice',
        );
        $group = array('indice');

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
            $totais[$total[0]['indice']] = $total[0]['total'];
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
                $retorno['total'] = $this->Domicilio->find('count', array('conditions' => array('Domicilio.quantidade_pessoas > 0')));
                break;
            case 'desatualizados':
                $retorno['desatualizados'] = $this->Domicilio->find('count', array(
                    'conditions' => array(
                        'Domicilio.quantidade_pessoas > 0',
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
                        'Domicilio.quantidade_pessoas > 0',
                        'OR' => array(
                            'Indice.modified <' => date('Y-m-d'),
                            'Indice.modified IS NULL',
                        )
                    ),
                    'limit' => $limite,
                        )
                );

                foreach ($domicilios as $codigo_domiciliar) {

                    $this->Domicilio->id = $codigo_domiciliar;
                    $domicilio = array();
                    $domicilio = $this->Domicilio->read();
                    $domicilio = $this->Indice->calcularIndices($domicilio);

                    $this->data['Indice'] = $domicilio['Indice'];
                    $this->data['Indice']['codigo_domiciliar'] = $codigo_domiciliar;
                    $this->data['Indice']['modified'] = date("Y-m-d H:i:s");

                    if (!$this->Indice->save($this->data)) {
                        $retorno['status'] = 0;
                    }
                }
        }

        if ($atualizar != null) {
            $retorno['desatualizados'] = $this->Domicilio->find('count', array(
                'conditions' => array(
                    'Domicilio.quantidade_pessoas > 0',
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