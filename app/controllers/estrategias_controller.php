<?php

class EstrategiasController extends AppController {

    var $name = 'Estrategias';

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

        $estrategias = $this->paginate('Estrategia');
        $page = $this->params['form']['page'];
        $total = $this->Estrategia->find('count', array('conditions' => $conditions));
        $this->set(compact('estrategias', 'page', 'total'));
    }

    function cadastro($id = null) {
        parent::temAcesso();
        if (empty($this->data)) {
            $this->data = $this->Estrategia->read();
            $temAcessoEscrita = parent::temAcessoEscrita();
            $this->set(compact('temAcessoEscrita'));
            $this->Estrategia->Indicador->displayField = array("%s - %s", "{n}.Indicador.cod_indicador", "{n}.Indicador.desc_label_indicador");
        } else {
            if ($this->Estrategia->save($this->data)) {
                $this->Session->setFlash('Cadastro salvo.');
                $this->redirect(array('controller' => $this->name, 'action' => 'index'));
            }
        }
    }
    
    function excluir($id) {
        parent::temAcesso();
        if (!empty($id)) {
            $this->Estrategia->delete($id);
            $this->Session->setFlash('A estratégia com código: ' . $id . ' foi excluída.');
        } else {
            $this->Session->setFlash('Erro ao tentar excluir: id inexistente!');
        }
        $this->redirect(array('action' => 'index'));
    }
    
    function beforeRender() {
        parent::beforeRender();
        switch ($this->action) {
            case 'cadastro';
                $this->_populateLookups(array('Indicador'));
                break;
        }
    }

    function _populateLookups($models) {
        foreach ($models as $model) {
            $name = Inflector::variable(Inflector::pluralize(strtolower($model)));
            $this->set($name, $this->Estrategia->{$model}->find("list"));
        }
    }

}