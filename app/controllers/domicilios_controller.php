<?php

class DomiciliosController extends AppController {

    var $name = 'Domicilios';
    var $helpers = array('Javascript', 'Js');
    var $components = array('RequestHandler');

    function index() {
        $this->set('title_for_layout', 'Listagem de Domicílios');
    }

    function lista() {

        $this->layout = 'ajax';

        $conditions = array(
            'Domicilio.quantidade_pessoas != 0',
            'Domicilio.cras_id IN(' . $this->crasUsuario() . ')',
        );

        if ($this->params['form']['query'] != '')
            if ($this->params['form']['qtype'] == 'Domicilio.idf')
                $conditions['Domicilio.idf <='] = $this->params['form']['query'];
            else
                $conditions[$this->params['form']['qtype'] . ' LIKE'] = '%' . str_replace(' ', '%', $this->params['form']['query']) . '%';

        $this->paginate = array(
            'fields' => array(
                'Domicilio.codigo_domiciliar',
                'Responsavel.nome',
                'Domicilio.logradouro',
                'Domicilio.numero',
                'Bairro.nome',
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
        );

        if ($this->Session->read("$container.Domicilio_codigo_domiciliar") != '')
            $conditions['Domicilio.codigo_domiciliar'] = $this->Session->read("$container.Domicilio_codigo_domiciliar");
        if ($this->Session->read("$container.Domicilio_regiao_id") != '')
            $conditions['Domicilio.regiao_id'] = $this->Session->read("$container.Domicilio_regiao_id");
        if ($this->Session->read("$container.Domicilio_cras_id") != '')
            $conditions['Domicilio.cras_id'] = $this->Session->read("$container.Domicilio_cras_id");
        if ($this->Session->read("$container.Domicilio_bairro_id") != '')
            $conditions['Domicilio.bairro_id'] = $this->Session->read("$container.Domicilio_bairro_id");
        if ($this->Session->read("$container.Responsavel_nis") != '')
            $conditions['Responsavel.nis'] = $this->Session->read("$container.Responsavel_nis");
        if ($this->Session->read("$container.Responsavel_cpf") != '')
            $conditions['Responsavel.cpf'] = $this->Session->read("$container.Responsavel_cpf");
        if ($this->Session->read("$container.Responsavel_nome") != '')
            $conditions['Responsavel.nome'] = $this->Session->read("$container.Responsavel_nome");
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
        
        print_r($conditions); die();

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
        if (empty($this->data)) {
            $this->data = $this->Domicilio->read();
        } else {
            if ($this->Domicilio->save($this->data)) {
                $this->Session->setFlash('Cadastro salvo.');
                $this->redirect(array('controller' => $this->name, 'action' => 'index'));
            }
        }
    }

    function excluir($id) {
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

    function listaDomiciliosBairro($bairro_id) {
        $this->layout = 'ajax';

        $conditions = array('Domicilio.bairro_id =' => $bairro_id);
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
                $this->Domicilio->query('UPDATE domicilios d SET bairro_id = (SELECT b.id FROM bairros b WHERE d.bairro_nome = b.nome)');
                $this->Domicilio->query('UPDATE domicilios SET cras_id = (SELECT cras_id FROM bairros WHERE bairros.id = domicilios.bairro_id), regiao_id = (SELECT regiao_id FROM bairros WHERE bairros.id = domicilios.bairro_id)');

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
                    $cras_usuario[] = $cras['id'];
        }

        return implode(',', $cras_usuario);
    }

}