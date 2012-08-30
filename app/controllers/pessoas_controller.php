<?php

class PessoasController extends AppController {

    var $name = 'Pessoas';
    var $helpers = array('Javascript', 'Js');
    var $components = array('RequestHandler');

    function index() {
        parent::temAcesso();
        $temAcessoExclusao = parent::temAcessoExclusao();
        $this->set(compact('temAcessoExclusao'));
    }

    function lista() {
        $this->layout = 'ajax';

        $this->Pessoa->recursive = 0;

        $conditions = array(
            'Domicilio.id_cras IN(' . $this->crasUsuario() . ')',
        );

        if ($this->params['form']['query'] != '')
            switch ($this->params['form']['qtype']) {
                case 'Pessoa.dt_nasc':
                    $conditions['Pessoa.dt_nasc ='] = parent::converteData($this->params['form']['query'], 1);
                    break;
                default:
                    $conditions[$this->params['form']['qtype'] . ' LIKE'] = '%' . str_replace(' ', '%', $this->params['form']['query']) . '%';
            }


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
                'Pessoa.cod_nis_responsavel IS NULL',
                'Pessoa.nome LIKE ' => '%' . str_replace(' ', '%', $this->params['form']['term']) . '%'
            )
        );
        $nomes = $this->Pessoa->find('list', $options);
        $this->set(compact('nomes'));
        $this->layout = 'ajax';
        $this->render('lista_nomes');
    }

    function listaMembros($cod_nis_responsavel) {

        $this->layout = 'ajax';

        $conditions = array('Pessoa.cod_nis_responsavel =' => $cod_nis_responsavel, 'Pessoa.cod_nis_responsavel != Pessoa.nis');

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

    function listaPessoasDomicilio($cod_domiciliar) {
        $this->layout = 'ajax';

        $conditions = array('Pessoa.cod_domiciliar =' => $cod_domiciliar);
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
            $temAcessoEscrita = parent::temAcessoEscrita();
            $this->set(compact('temAcessoEscrita'));
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