<?php

class RegioesController extends AppController {

    var $name = 'Regioes';

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
                => sprintf('%%%s%%', str_replace(' ', '%', strtoupper($this->params['form']['query'])))
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

        $regioes = $this->paginate($this->modelClass);
        $page = $this->params['form']['page'];
        $total = $this->params['paging'][$this->modelClass]['count'];
        $this->set(compact('regioes', 'page', 'total'));
    }

    function cadastro($id = null) {
        parent::temAcesso();
        if (empty($this->data)) {
            $this->data = $this->Regiao->read();
            $temAcessoEscrita = parent::temAcessoEscrita();
            $this->set(compact('temAcessoEscrita'));
        } else {
            if ($this->Regiao->save($this->data)) {
                $this->Session->setFlash('Cadastro salvo.');
                $this->redirect(array('controller' => $this->name, 'action' => 'index'));
            }
        }
    }
    
    function excluir($id) {
        parent::temAcesso();
        if (!empty($id)) {
            $this->Regiao->delete($id);
            $this->Session->setFlash('A região com código: ' . $id . ' foi excluída.');
        } else {
            $this->Session->setFlash('Erro ao tentar excluir: id inexistente!');
        }
        $this->redirect(array('action' => 'index'));
    }

}