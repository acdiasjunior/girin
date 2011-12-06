<?php

class BairrosController extends AppController {

    var $name = 'Bairros';

    function index() {

    }

    function lista() {
        $this->layout = 'ajax';

        if ($this->params['form']['query'] != '')
            $conditions = array(
                $this->params['form']['qtype'] . ' LIKE' => '%' . str_replace(' ', '%', $this->params['form']['query']) . '%'
            );
        else
            $conditions = array();

        $this->paginate = array(
            'page' => $this->params['form']['page'],
            'limit' => $this->params['form']['rp'],
            'order' => array(
                $this->params['form']['sortname'] => $this->params['form']['sortorder']
            ),
            'conditions' => $conditions
        );

        $bairros = $this->paginate('Bairro');
        $page = $this->params['form']['page'];
        $total = $this->Bairro->find('count', array('conditions' => $conditions));
        $this->set(compact('bairros', 'page', 'total'));
    }

    function cadastro($id = null) {
        if (empty($this->data)) {
            $this->data = $this->Bairro->read();
        } else {
            if ($this->Bairro->save($this->data)) {
                $this->Bairro->query('UPDATE domicilios SET cras_id = (SELECT cras_id FROM bairros WHERE bairros.id = domicilios.bairro_id), regiao_id = (SELECT regiao_id FROM bairros WHERE bairros.id = domicilios.bairro_id)');
                $this->Session->setFlash('Cadastro salvo.');
                $this->redirect(array('controller' => $this->name, 'action' => 'index'));
            }
        }
    }

    function listaBairrosCras($cras_id) {
        $this->layout = 'ajax';

        $conditions = array('Bairro.cras_id =' => $cras_id);
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
        $bairros = $this->paginate('Bairro');
        $page = $this->params['form']['page'];
        $total = $this->Bairro->find('count', array('conditions' => $conditions));
        $this->set(compact('bairros', 'page', 'total'));
    }

    function preencheCombo($cras_id = null) {
        $this->layout = 'ajax';
        $this->autoRender = false;
        if ($cras_id == null)
            $cras = $this->Bairro->find('list');
        else
            $cras = $this->Bairro->find('list', array('conditions' => array('Bairro.cras_id' => $cras_id)));
        echo '<option value="">Selecione o Bairro</option>';
        foreach ($cras as $key => $value)
            echo '<option value="' . $key . '">' . $value . '</option>';
    }

    function excluir($id) {
        if (!empty($id)) {
            $this->Bairro->delete($id);
            $this->Session->setFlash('O bairro com código: ' . $id . ' foi excluído.');
            $this->redirect(array('controller' => $this->name, 'action' => 'index'));
        } else {
            $this->Session->setFlash('Erro ao tentar excluir: código inexistente!');
            $this->redirect(array('controller' => $this->name, 'action' => 'index'));
        }
    }

}