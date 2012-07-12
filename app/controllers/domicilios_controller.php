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

        $conditions = array(
            'Domicilio.quantidade_pessoas != 0',
            'Domicilio.id_cras IN(' . $this->crasUsuario() . ')',
        );

        if ($this->params['form']['query'] != '')
            switch ($this->params['form']['qtype']) {
                case 'Domicilio.idf':
                    $conditions['Domicilio.idf <='] = $this->params['form']['query'];
                    break;
                case 'Responsavel.data_nascimento':
                    $conditions['Responsavel.data_nascimento ='] = parent::converteData($this->params['form']['query'], 1);
                    break;
                default:
                    $conditions[$this->params['form']['qtype'] . ' LIKE'] = '%' . str_replace(' ', '%', $this->params['form']['query']) . '%';
            }

        $this->paginate = array(
            'fields' => array(
                'Domicilio.codigo_domiciliar',
                'Responsavel.nome',
                'Domicilio.logradouro',
                'Domicilio.numero',
                'Bairro.nome_bairro',
                'Indice.idf',
                'Domicilio.valor_renda_familia',
                'Domicilio.quantidade_pessoas',
                'Domicilio.renda_per_capita'
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
        $total = $this->Domicilio->find('count', array('conditions' => $conditions));
        $this->set(compact('domicilios', 'page', 'total'));
    }

    function listaDomiciliosFiltro() {

        $this->layout = 'ajax';
        $container = 'prontuarios.gerar.filtroDomicilios';

        $conditions = array(
            'Domicilio.quantidade_pessoas != 0',
            'Domicilio.id_cras IN(' . $this->crasUsuario() . ')',
        );

        if ($this->Session->read("$container.Domicilio_codigo_domiciliar") != '')
            $conditions['Domicilio.codigo_domiciliar'] = $this->Session->read("$container.Domicilio_codigo_domiciliar");
        if ($this->Session->read("$container.Domicilio_regiao_id") != '')
            $conditions['Domicilio.regiao_id'] = $this->Session->read("$container.Domicilio_regiao_id");
        if ($this->Session->read("$container.Domicilio_id_cras") != '')
            $conditions['Domicilio.id_cras'] = $this->Session->read("$container.Domicilio_id_cras");
        if ($this->Session->read("$container.Domicilio_id_bairro") != '')
            $conditions['Domicilio.id_bairro'] = $this->Session->read("$container.Domicilio_id_bairro");
        if ($this->Session->read("$container.Responsavel_nis") != '')
            $conditions['Responsavel.nis'] = $this->Session->read("$container.Responsavel_nis");
        if ($this->Session->read("$container.Responsavel_cpf") != '')
            $conditions['Responsavel.cpf'] = str_replace(array('.', '-'), '', $this->Session->read("$container.Responsavel_cpf"));
        if ($this->Session->read("$container.Responsavel_nome") != '')
            $conditions['Responsavel.nome LIKE '] = '%' . $this->Session->read("$container.Responsavel_nome") . '%';
        if ($this->Session->read("$container.Domicilio_idf") != '') {
            switch ($this->Session->read("$container.TipoBusca")) {
                case 'menor':
                    $tipo_busca = '<=';
                    break;
                case 'exatamente':
                    $tipo_busca = '=';
                    break;
                case 'maior':
                    $tipo_busca = '>';
                    break;
                default:
                    return;
            }
            $conditions['Indice.idf ' . $tipo_busca] = $this->Session->read("$container.Domicilio_idf");
        }

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
        $total = $this->Domicilio->find('count', array('conditions' => $conditions));
        $this->set(compact('domicilios', 'page', 'total'));
        $this->render('lista');
    }

    function cadastro($id = null) {
        parent::temAcesso();
        if (empty($this->data)) {
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
        $total = $this->Domicilio->find('count', array('conditions' => $conditions));
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
                        $this->data['Domicilio'][$value] = $row[$key];
                    }

                    // save the row
                    if (!$this->Domicilio->save($this->data, false)) {
                        echo '<pre>' . var_dump($this->data) . '</pre><br>';
                        die('Erro ao gravar o registro!');
                    }
                }
                $this->Domicilio->query('UPDATE domicilios d SET id_bairro = (SELECT b.id FROM bairros b WHERE d.bairro_nome = b.nome)');
                $this->Domicilio->query('UPDATE domicilios SET id_cras = (SELECT id_cras FROM bairros WHERE bairros.id = domicilios.id_bairro), regiao_id = (SELECT regiao_id FROM bairros WHERE bairros.id = domicilios.id_bairro)');

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
        $this->Usuario->id = $this->Session->read('Auth.Usuario.id');
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

}