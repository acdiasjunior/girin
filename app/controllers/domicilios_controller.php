<?php

class DomiciliosController extends AppController {

    var $name = 'Domicilios';
    var $helpers = array('Javascript', 'Js');
    var $components = array('RequestHandler');
    var $pessoa_count = '(SELECT COUNT(*) FROM pessoas WHERE `pessoas`.`codigo_domiciliar` = `Domicilio`.`codigo_domiciliar`)';

    function index() {
        $this->set('title_for_layout', 'Listagem de Domicílios');
    }

    function lista() {

        $this->layout = 'ajax';

        $conditions = array(
            $this->pessoa_count . ' != 0',
        );

        if ($this->params['form']['query'] != '')
            if ($this->params['form']['qtype'] == 'Domicilio.idf')
                $conditions['Domicilio.idf <='] = $this->params['form']['query'];
            else
                $conditions[$this->params['form']['qtype'] . ' LIKE'] = '%' . str_replace(' ', '%', $this->params['form']['query']) . '%';

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

    function listaDomiciliosFiltro() {

        $this->layout = 'ajax';
        $container = 'prontuarios.gerar.filtroDomicilios';

        $conditions = array(
            $this->pessoa_count . ' != 0',
        );

        if ($this->Session->read("$container.Domicilio_codigo_domiciliar") != '')
            $conditions['Domicilio.codigo_domiciliar'] = $this->Session->read("$container.Domicilio_codigo_domiciliar");
        if ($this->Session->read("$container.Domicilio_regiao_id") != '')
            $conditions['Domicilio.regiao_id'] = $this->Session->read("$container.Domicilio_regiao_id");
        if ($this->Session->read("$container.Domicilio_cras_id") != '')
            $conditions['Domicilio.cras_id'] = $this->Session->read("$container.Domicilio_cras_id");
        if ($this->Session->read("$container.Domicilio_bairro_id") != '')
            $conditions['Domicilio.bairro_id'] = $this->Session->read("$container.Domicilio_bairro_id");
        if ($this->Session->read("$container.Domicilio_responsavel_nis") != '')
            $conditions['Responsavel.nis'] = $this->Session->read("$container.Domicilio_responsavel_nis");
        if ($this->Session->read("$container.Domicilio_responsavel_cpf") != '')
            $conditions['Responsavel.cpf'] = $this->Session->read("$container.Domicilio_responsavel_cpf");
        if ($this->Session->read("$container.Domicilio_responsavel_nome") != '')
            $conditions['Responsavel.nome'] = $this->Session->read("$container.Domicilio_responsavel_nome");
        if ($this->Session->read("$container.Domicilio_idf") != '')
            $conditions['Domicilio.idf ' . $this->Session->read("$container.TipoBusca")] = $this->Session->read("$container.Domicilio_idf");

        if ($this->params['form']['query'] != '')
            if ($this->params['form']['qtype'] == 'Domicilio.idf')
                $conditions['Domicilio.idf <='] = $this->params['form']['query'];
            else
                $conditions[$this->params['form']['qtype'] . ' LIKE'] = '%' . str_replace(' ', '%', $this->params['form']['query']) . '%';

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

                    $this->Domicilio->create();
                    $this->Domicilio->set($this->data);

                    if (!$this->Domicilio->validates()) {
                        die('erro na validacao de um registro');
                    }

                    // save the row
                    if ($this->data['Domicilio']['logradouro'] != '') {
                        if (!$this->Domicilio->save($this->data, false)) {
                            echo '<pre>' . var_dump($this->data) . '</pre><br>';
                            die('Erro ao gravar o registro!');
                        }
                    }
                }

                $this->Domicilio->query('UPDATE domicilios SET cras_id = (SELECT cras_id FROM bairros WHERE bairros.id = domicilios.bairro_id), regiao_id = (SELECT regiao_id FROM bairros WHERE bairros.id = domicilios.bairro_id)');
                /*$this->Domicilio->query("UPDATE domicilios SET tipo_logradouro = 'RUA' WHERE tipo_logradouro = 'R';
                        UPDATE domicilios SET tipo_logradouro = 'AVENIDA' WHERE tipo_logradouro = 'AV';
                        UPDATE domicilios SET tipo_logradouro = 'TRAVESSA' WHERE tipo_logradouro = 'TV';
                        UPDATE domicilios SET tipo_logradouro = 'ESTRADA' WHERE tipo_logradouro = 'EST';
                        UPDATE domicilios SET tipo_logradouro = 'FAZENDA' WHERE tipo_logradouro = 'FAZ';
                        UPDATE domicilios SET tipo_logradouro = 'SITIO' WHERE tipo_logradouro = 'SIT';
                        UPDATE domicilios SET tipo_logradouro = 'PC' WHERE tipo_logradouro = 'PC';
                        UPDATE domicilios SET tipo_logradouro = 'ALAMEDA' WHERE tipo_logradouro = 'AL';
                        UPDATE domicilios SET tipo_logradouro = 'QTS' WHERE tipo_logradouro = 'QTS';
                        UPDATE domicilios SET tipo_logradouro = 'RODOVIA' WHERE tipo_logradouro = 'ROD';
                        UPDATE domicilios SET tipo_logradouro = 'R L' WHERE tipo_logradouro = 'R L';
                        UPDATE domicilios SET tipo_logradouro = 'TRAVESSA' WHERE tipo_logradouro = 'TR';
                        UPDATE domicilios SET tipo_logradouro = 'LD' WHERE tipo_logradouro = 'LD';
                        UPDATE domicilios SET tipo_logradouro = 'VILA' WHERE tipo_logradouro = 'VL';
                        UPDATE domicilios SET tipo_logradouro = 'GALERIA' WHERE tipo_logradouro = 'GAL';
                        UPDATE domicilios SET tipo_logradouro = 'AVENIDA' WHERE tipo_logradouro = 'A';
                        UPDATE domicilios SET tipo_logradouro = 'TRAVESSA' WHERE tipo_logradouro = 'TRV';
                        UPDATE domicilios SET tipo_logradouro = 'CONJUNTO' WHERE tipo_logradouro = 'CJ';");*/

                // close the file
                fclose($handle);

                $this->Session->setFlash('Todos os registros foram importados!');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash("Upload do arquivo falhou!");
            }
        }
    }

}