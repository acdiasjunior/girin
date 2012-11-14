<?php

class DomiciliosController extends AppController {

    var $name = 'Domicilios';
    var $helpers = array('Javascript', 'Js');
    var $components = array('RequestHandler');

    function index() {
        parent::temAcesso();
        $temAcessoExclusao = parent::temAcessoExclusao();
        $this->set(compact('temAcessoExclusao'));
        $this->set('title_for_layout', 'Listagem de Domicílios');
    }

    function lista() {

        $this->layout = 'ajax';

        $this->Domicilio->recursive = 0;

        $conditions = array(
            'Domicilio.qtd_pessoa != 0',
            'Bairro.id_cras IN(' . $this->crasUsuario() . ')',
        );

        if ($this->params['form']['query'] != '')
            switch ($this->params['form']['qtype']) {
                case 'Domicilio.vlr_idf':
                    $conditions['Domicilio.vlr_idf <='] = $this->params['form']['query'];
                    break;
                case 'Responsavel.dt_nasc':
                    $conditions['Responsavel.dt_nasc ='] = parent::converteData($this->params['form']['query'], 1);
                    break;
                default:
                    $conditions[sprintf('UPPER(%s) LIKE', $this->params['form']['qtype'])]
                            = sprintf('%%%s%%', str_replace(' ', '%', strtoupper($this->params['form']['query'])));
            }

        $this->paginate = array(
            'fields' => array(
                'Domicilio.cod_domiciliar',
                'Responsavel.nome',
                'Domicilio.end_logradouro',
                'Domicilio.end_num',
                'Bairro.nome_bairro',
                'Indice.vlr_idf',
                'Domicilio.vlr_renda_familia',
                'Domicilio.qtd_pessoa',
                'Domicilio.vlr_renda_per_capita'
            ),
            'page' => $this->params['form']['page'],
            'limit' => $this->params['form']['rp'],
            'order' => array(
                $this->params['form']['sortname'] => $this->params['form']['sortorder'],
                'Domicilio.cod_domiciliar' => 'ASC'
            ),
            'conditions' => $conditions
        );
        $domicilios = $this->paginate($this->modelClass);
        $page = $this->params['form']['page'];
        $total = $this->params['paging'][$this->modelClass]['count'];
        $this->set(compact('domicilios', 'page', 'total'));
    }

    function listaDomiciliosFiltro() {

        $this->layout = 'ajax';
        $container = 'plano_familiares.gerar.filtroDomicilios';

        $conditions = array(
            'Domicilio.qtd_pessoa != 0',
            'Bairro.id_cras IN(' . $this->crasUsuario() . ')',
        );
        if ($this->Session->read("$container.cod_domiciliar") != '')
            $conditions['Domicilio.cod_domiciliar'] = $this->Session->read("$container.cod_domiciliar");
        if ($this->Session->read("$container.id_regiao") != '')
            $conditions['Bairro.id_regiao'] = $this->Session->read("$container.id_regiao");
        if ($this->Session->read("$container.id_cras") != '')
            $conditions['Bairro.id_cras'] = $this->Session->read("$container.id_cras");
        if ($this->Session->read("$container.id_bairro") != '')
            $conditions['Domicilio.id_bairro'] = $this->Session->read("$container.id_bairro");
        if ($this->Session->read("$container.cod_nis") != '')
            $conditions['Responsavel.cod_nis'] = $this->Session->read("$container.cod_nis");
        if ($this->Session->read("$container.cpf") != '')
            $conditions['Responsavel.cpf'] = str_replace(array('.', '-'), '', $this->Session->read("$container.cpf"));
        if ($this->Session->read("$container.nome") != '')
            $conditions['UPPER(Responsavel.nome) LIKE '] = sprintf('%%%s%%', str_replace(' ', '%', strtoupper($this->Session->read("$container.nome"))));
        if ($this->Session->read("$container.vlr_idf") != '') {
            switch ($this->Session->read("$container.tp_busca")) {
                case 'menor':
                    $tp_busca = '<=';
                    break;
                case 'exatamente':
                    $tp_busca = '=';
                    break;
                case 'maior':
                    $tp_busca = '>';
                    break;
                default:
                    return;
            }
            $conditions['Indice.vlr_idf ' . $tp_busca] = $this->Session->read("$container.vlr_idf");
        }

        $this->paginate = array(
            'recursive' => -1,
            'joins' => array(
                array(
                    'table' => 'tb_indice',
                    'alias' => 'Indice',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Domicilio.cod_domiciliar = Indice.cod_domiciliar',
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
                array(
                    'table' => 'tb_pessoa',
                    'alias' => 'Responsavel',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Domicilio.cod_nis_responsavel = Responsavel.cod_nis',
                    )
                ),
            ),
            'fields' => array(
                'Domicilio.cod_domiciliar',
                'Responsavel.nome',
                'Domicilio.end_logradouro',
                'Domicilio.end_num',
                'Bairro.nome_bairro',
                'Indice.vlr_idf',
                'Domicilio.vlr_renda_familia',
                'Domicilio.qtd_pessoa',
                'Domicilio.vlr_renda_per_capita'
            ),
            'page' => $this->params['form']['page'],
            'limit' => $this->params['form']['rp'],
            'order' => array(
                $this->params['form']['sortname'] => $this->params['form']['sortorder']
            ),
            'conditions' => $conditions
        );
        $domicilios = $this->paginate('Domicilio');
        $page = $this->params['form']['page'];
		$total = $this->params['paging'][$this->modelClass]['count'];
        $this->set(compact('domicilios', 'page', 'total'));
        $this->render('lista');
    }

    function cadastro($id = null) {
        parent::temAcesso();
        if (empty($this->data)) {
            $this->Domicilio->recursive = 0;
            $this->data = $this->Domicilio->read();
            $temAcessoEscrita = parent::temAcessoEscrita();
            $this->set(compact('temAcessoEscrita'));
        } else {
            if ($this->Domicilio->save($this->data)) {
                $this->Session->setFlash('Cadastro salvo.');
                $this->redirect(array('controller' => $this->name, 'action' => 'index'));
            }
        }
    }

    function excluir($id) {
        parent::temAcesso();
        if (!empty($id)) {
            if ($this->Domicilio->Pessoa->findAllByDomicilioId($id)) {

                $this->Session->setFlash('Não foi possível excluir o domicilio.<br />Existem individuos associados.');
            } else {

                $this->PessoasFisica->delete($id);

                App::import('Model', 'Condutor');
                $this->Condutor = new Condutor();
                $this->Condutor->delete($id);

                $this->Session->setFlash('O cliente com código: ' . $id . ' foi excluído.');
            }
            $this->redirect(array('controller' => $this->name, 'action' => 'index'));
        } else {
            $this->Session->setFlash('Erro ao tentar excluir: código inexistente!');
            $this->redirect(array('controller' => $this->name, 'action' => 'index'));
        }
    }

    function listaDomiciliosBairro($id_bairro) {
        $this->layout = 'ajax';

        $conditions = array('Domicilio.id_bairro =' => $id_bairro);
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
        $domicilios = $this->paginate('Domicilio');
        $page = $this->params['form']['page'];
		$total = $this->params['paging'][$this->modelClass]['count'];
        $this->set(compact('domicilios', 'page', 'total'));
    }

    function importar($arquivo = null) {
        parent::temAcesso();
        if (empty($this->data)) {
            //Abre a tela de importação
        } else {
            if ($this->isUploadedFile($this->data['Domicilio']['arquivo'])) {

                $handle = fopen($this->data['Domicilio']['arquivo']['tmp_name'], "r");
                $header = fgetcsv($handle, 0, ';');

                while (($row = fgetcsv($handle, 0, ';')) !== FALSE) {

                    set_time_limit(1);

                    $this->data = array();

                    foreach ($header as $key => $value) {
                        $row[$key] = utf8_encode($row[$key]);
                        $row[$key] = (strtoupper($row[$key]) == 'NULL') ? null : $row[$key];
                        $this->data['Domicilio'][$value] = $row[$key];
                    }

                    // save the row
                    if (!$this->Domicilio->save($this->data, false)) {
                        echo '<pre>' . var_dump($this->data) . '</pre><br>';
                        die('Erro ao gravar o registro!');
                    }
                }
                $this->Domicilio->query('UPDATE tb_domicilio d SET id_bairro = (SELECT b.id_bairro FROM tb_bairro b WHERE d.nome_bairro = b.nome_bairro)');

                // close the file
                fclose($handle);

                $this->Session->setFlash('Todos os registros foram importados!');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash("Upload do arquivo falhou!");
            }
        }
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

    function beforeRender() {
        parent::beforeRender();
        switch ($this->action) {
            case 'cadastro';
                $this->_populateLookups(array('Bairro'));
                break;
        }
    }

    function _populateLookups($models) {
        foreach ($models as $model) {
            $name = Inflector::variable(Inflector::pluralize(strtolower($model)));
            $this->set($name, $this->Domicilio->{$model}->find("list"));
        }
    }

}