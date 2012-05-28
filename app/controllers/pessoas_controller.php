<?php

class PessoasController extends AppController {

    var $name = 'Pessoas';
    var $helpers = array('Javascript', 'Js');
    var $components = array('RequestHandler');

    function index() {
        parent::temAcesso();
    }

    function lista() {
        $this->layout = 'ajax';

        $this->Pessoa->recursive = 0;
        
        $conditions = array(
            'Domicilio.cras_id IN(' . $this->crasUsuario() . ')',
        );

        if ($this->params['form']['query'] != '')
            $conditions[$this->params['form']['qtype'] . ' LIKE'] = '%' . str_replace(' ', '%', $this->params['form']['query']) . '%';

        $this->paginate = array(
            'page' => $this->params['form']['page'],
            'limit' => $this->params['form']['rp'],
            'order' => array(
                $this->params['form']['sortname'] => $this->params['form']['sortorder']
            ),
            'conditions' => $conditions
        );
        $pessoas = $this->paginate('Pessoa');
        $page = $this->params['form']['page'];
        $total = $this->Pessoa->find('count', array('conditions' => $conditions));
        $this->set(compact('pessoas', 'page', 'total'));
    }

    function listaNomes() {
        $options = array(
            'conditions' => array(
                'Pessoa.nome LIKE ' => '%' . str_replace(' ', '%', $this->params['form']['term']) . '%'
            )
        );
        $nomes = $this->Pessoa->find('list', $options);
        $this->set(compact('nomes'));
        $this->render('lista_nomes');
    }

    function listaNomesResponsavel() {
        $options = array(
            'conditions' => array(
                'Pessoa.responsavel_id IS NULL',
                'Pessoa.nome LIKE ' => '%' . str_replace(' ', '%', $this->params['form']['term']) . '%'
            )
        );
        $nomes = $this->Pessoa->find('list', $options);
        $this->set(compact('nomes'));
        $this->layout = 'ajax';
        $this->render('lista_nomes');
    }

    function listaNomesConjuge($sexo) {
        $options = array(
            'conditions' => array(
                'Pessoa.conjuge_id IS NULL',
                'Pessoa.sexo !=' => $sexo,
                'Pessoa.nome LIKE ' => '%' . str_replace(' ', '%', $this->params['form']['term']) . '%'
            )
        );
        $nomes = $this->Pessoa->find('list', $options);
        $this->set(compact('nomes'));
        $this->layout = 'ajax';
        $this->render('lista_nomes');
    }

    function listaMembros($responsavel_nis) {

        $this->layout = 'ajax';

        $conditions = array('Pessoa.responsavel_nis =' => $responsavel_nis, 'Pessoa.responsavel_nis != Pessoa.nis');

        if ($this->params['form']['query'] != '')
            $conditions[] = array($this->params['form']['qtype'] . ' LIKE' => '%' . str_replace(' ', '%', $this->params['form']['query']) . '%');

        $this->paginate = array(
            'page' => $this->params['form']['page'],
            'limit' => $this->params['form']['rp'],
            'order' => array(
                $this->params['form']['sortname'] => $this->params['form']['sortorder']
            ),
            'conditions' => $conditions
        );
        $membros = $this->paginate('Pessoa');
        $page = $this->params['form']['page'];
        $total = $this->Pessoa->find('count', array('conditions' => $conditions));
        $this->set(compact('membros', 'page', 'total'));
    }

    function listaPessoasDomicilio($codigo_domiciliar) {
        $this->layout = 'ajax';

        $conditions = array('Pessoa.codigo_domiciliar =' => $codigo_domiciliar);
        if ($this->params['form']['query'] != '')
            $conditions[] = array($this->params['form']['qtype'] . ' LIKE' => '%' . str_replace(' ', '%', $this->params['form']['query']) . '%');

        $this->paginate = array(
            'page' => $this->params['form']['page'],
            'limit' => $this->params['form']['rp'],
            'order' => array(
                $this->params['form']['sortname'] => $this->params['form']['sortorder']
            ),
            'conditions' => $conditions
        );
        $pessoas = $this->paginate('Pessoa');
        $page = $this->params['form']['page'];
        $total = $this->Pessoa->find('count', array('conditions' => $conditions));
        $this->set(compact('pessoas', 'page', 'total'));
    }

    function cadastro($id = null) {
        parent::temAcesso();
        if (empty($this->data)) {
            $this->data = $this->Pessoa->read();
        } else {
            if ($this->Pessoa->save($this->data)) {
                $this->Session->setFlash('Cadastro salvo.');
                $this->redirect(array('controller' => $this->name, 'action' => 'index'));
            }
        }
    }

    function excluir($id) {
        parent::temAcesso();
        if (!empty($id)) {
            $this->Pessoa->delete($id);
            $this->Session->setFlash('A pessoa com nis: ' . $id . ' foi excluído.');
        } else {
            $this->Session->setFlash('Erro ao tentar excluir: nis inexistente!');
        }
        $this->redirect(array('action' => 'index'));
    }

    function importar($arquivo = null) {
        parent::temAcesso();
        if (empty($this->data)) {
            //Abre a tela de importação
        } else {
            if ($this->isUploadedFile($this->data['Pessoa']['arquivo'])) {

                $handle = fopen($this->data['Pessoa']['arquivo']['tmp_name'], "r");
                $header = fgetcsv($handle, 0, ';');

                while (($row = fgetcsv($handle, 0, ';')) !== FALSE) {

                    set_time_limit(3);

                    $this->data = array();

                    foreach ($header as $key => $value) {
                        $row[$key] = utf8_encode($row[$key]);
                        $this->data['Pessoa'][$value] = $row[$key];
                    }

                    $this->Pessoa->save($this->data, false);
                }

                // close the file
                fclose($handle);

                $this->Session->setFlash('Todos os registros foram importados!');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash("Upload do arquivo falhou!");
            }
        }
    }

//    function listaPersonalizada() {
//        $options = array(
//            'recursive' => -1,
//            'fields' => array(
//                'Pessoa.codigo_domiciliar',
//                'Pessoa.nis',
//            ),
//            'order' => array(
//                'Pessoa.codigo_domiciliar',
//            ),
//        );
//        $pessoas = $this->Pessoa->find('all', $options);
//        foreach($pessoas as $pessoa) {
//
//        }
//        var_dump();
//        die();
//    }
//    function listaPersonalizada() {
//        //pessoas com 17 ou mais concluindo ou já concluiu ensino medio
//        //só as que estão com IDF abaixo de 0.6
//        $options['joins'] = array(
//            array('table' => 'indices',
//                'alias' => 'Indice',
//                'type' => 'RIGHT',
//                'conditions' => array(
//                    'Indice.codigo_domiciliar = Pessoa.codigo_domiciliar',
//                )
//            )
//        );
//        $options['conditions'] = array(
//            'Indice.indice <=' => 0.6,
//            'Pessoa.grau_instrucao >=' => Pessoa::ESCOLARIDADE_MEDIO_INCOMPLETO,
//            'Pessoa.idade >=' => 17
//        );
//        echo $this->Pessoa->find('count', $options);
//        die();
//    }

    function faixas() {
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
        $inicio = microtime(true);
        $pessoas = $this->Pessoa->find('all', $options);

        $faixaEtaria['tempo'] = microtime(true) - $inicio;
        $faixaEtaria['total'] = $this->Pessoa->find('count', array('conditions' => array('Domicilio.quantidade_pessoas > 0')));
        foreach ($pessoas as $faixa) {
            $faixaEtaria[$faixa['FaixasEtaria']['descricao']][$faixa['Pessoa']['tipo_trabalho']] = $faixa[0]['total'];
        }

        echo '<pre>';
        print_r($faixaEtaria);
        echo '</pre>';

//        echo 'Tempo total de processamento: ' . (microtime(true) - $inicio) . '<br /><br />';
//
//        echo '<table border="1" cellspace="0">';
//        echo '<tr>';
//        echo '<td>Pessoas<td>';
//        echo '<td>Tipo de Trabalho<td>';
//        echo '<td>Faixa Etária<td>';
//        echo '</tr>';
//        foreach ($pessoas as $faixa) {
//            echo '<tr>';
//            echo '<td>' . $faixa[0]['total'] . '<td>';
//            echo '<td>' . $faixa['Pessoa']['tipo_trabalho'] . ' - ' . Pessoa::tipoTrabalho($faixa['Pessoa']['tipo_trabalho']) . '<td>';
//            echo '<td>' . $faixa['FaixasEtaria']['descricao'] . '<td>';
//            echo '</tr>';
//        }
        die();
    }
    
    private function crasUsuario() {
        $this->loadModel('Usuario');
        $this->Usuario->id = $this->Session->read('Auth.Usuario.id');
        $cras_usuario = array();

        if ($this->Usuario->id == 1) {
            $this->loadModel('Cras');
            $cras_usuario = array_keys($this->Cras->find('list'));
        } else {
            $usuario = $this->Usuario->read();
            if (count($usuario['Cras']) > 0)
                foreach ($usuario['Cras'] as $cras)
                    $cras_usuario[] = $cras['id'];
        }

        return implode(',', $cras_usuario);
    }
}