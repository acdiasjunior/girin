<?php

class CrasController extends AppController {

    var $name = 'Cras';

    function index() {
        parent::temAcesso();
        $temAcessoExclusao = parent::temAcessoExclusao();
        $this->set(compact('temAcessoExclusao'));
    }

    function lista() {
        $this->layout = 'ajax';

        if ($this->params['form']['query'] != '')
            $conditions = array(
                sprintf('UPPER(%s) LIKE', $this->params['form']['qtype'])
                => sprintf('%%%s%%', str_replace(' ', '%', stroupper($this->params['form']['query'])))
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

        $cras = $this->paginate($this->modelClass);
        $page = $this->params['form']['page'];
        $total = $this->params['paging'][$this->modelClass]['count'];
        $this->set(compact('cras', 'page', 'total'));
    }

    function cadastro($id = null) {
        parent::temAcesso();
        if (empty($this->data)) {
            $this->data = $this->Cras->read();
            $temAcessoEscrita = parent::temAcessoEscrita();
            $this->set(compact('temAcessoEscrita'));
        } else {
            if ($this->Cras->save($this->data)) {
                $this->Session->setFlash('Cadastro salvo.');
                $this->redirect(array('controller' => $this->name, 'action' => 'index'));
            }
        }
    }

    function preencheCombo($id_regiao = null) {
        $this->layout = 'ajax';
        $this->autoRender = false;
        if ($id_regiao == null)
            $cras = $this->Cras->find('list');
        else
            $cras = $this->Cras->find('list', array('conditions' => array('Cras.id_regiao' => $id_regiao)));
        echo '<option value="">Selecione o CRAS</option>';
        foreach ($cras as $key => $value)
            echo '<option value="' . $key . '">' . $value . '</option>';
    }

    function beforeRender() {
        parent::beforeRender();
        switch ($this->action) {
            case 'cadastro';
                $this->_populateLookups(array('Bairro', 'Regiao'));
                break;
        }
    }

    function _populateLookups($models) {
        foreach ($models as $model) {
            $name = Inflector::variable(Inflector::pluralize(strtolower($model)));
            $this->set($name, $this->Cras->{$model}->find("list"));
        }
    }

}