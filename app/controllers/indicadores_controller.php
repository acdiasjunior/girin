<?php

class IndicadoresController extends AppController {

    var $name = 'Indicadores';

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

        $indicadores = $this->paginate('Indicador');
        $page = $this->params['form']['page'];
        $total = $this->Indicador->find('count', array('conditions' => $conditions));
        $this->set(compact('indicadores', 'page', 'total'));
    }

    function cadastro($id = null) {
        parent::temAcesso();
        if (empty($this->data)) {
            $this->data = $this->Indicador->read();
            $temAcessoEscrita = parent::temAcessoEscrita();
            $this->set(compact('temAcessoEscrita'));
        } else {
            if ($this->Indicador->save($this->data)) {
                $this->Session->setFlash('Cadastro salvo.');
                $this->redirect(array('controller' => $this->name, 'action' => 'index'));
            }
        }
    }
    
    function excluir($id) {
        parent::temAcesso();
        if (!empty($id)) {
            $this->Indicador->delete($id);
            $this->Session->setFlash('O indicador com código: ' . $id . ' foi excluída.');
        } else {
            $this->Session->setFlash('Erro ao tentar excluir: id inexistente!');
        }
        $this->redirect(array('action' => 'index'));
    }

    function beforeRender() {
        parent::beforeRender();
        switch ($this->action) {
            case 'cadastro';
                $this->_populateLookups(array('Dimensao', 'Estrategia'));
                break;
        }
    }

    function _populateLookups($models) {
        foreach ($models as $model) {
            $name = Inflector::variable(Inflector::pluralize(strtolower($model)));
            $this->set($name, $this->Indicador->{$model}->find("list"));
        }
    }

}