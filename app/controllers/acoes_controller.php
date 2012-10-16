<?php

class AcoesController extends AppController {

    var $name = 'Acoes';

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

        $acoes = $this->paginate('Acao');
        $page = $this->params['form']['page'];
        $total = $this->Acao->find('count', array('conditions' => $conditions));
        $this->set(compact('acoes', 'page', 'total'));
    }

    function cadastro($id = null) {
        parent::temAcesso();
        if (empty($this->data)) {
            $this->data = $this->Acao->read();
            $temAcessoEscrita = parent::temAcessoEscrita();
            $this->set(compact('temAcessoEscrita'));
        } else {
            if ($this->Acao->save($this->data)) {
                $this->Session->setFlash('Cadastro salvo.');
                $this->redirect(array('controller' => $this->name, 'action' => 'index'));
            }
        }
    }

    function excluir($id) {
        parent::temAcesso();
        if (!empty($id)) {
            $this->Acao->delete($id);
            $this->Session->setFlash('A ação com código: ' . $id . ' foi excluída.');
        } else {
            $this->Session->setFlash('Erro ao tentar excluir: id inexistente!');
        }
        $this->redirect(array('action' => 'index'));
    }

    function autoComplete($campo = null) {
        $this->layout = 'ajax';
        if ($campo != null) {
            $this->Acao->displayField = $campo;
            $nomes = $this->Acao->find('list', array('conditions' => array('Acao.' . $campo . ' LIKE ' => '%' . str_replace(' ', '%', $this->params['form']['term']) . '%'), 'group' => array($campo)));
        } else {
            $nomes = array();
        }
        $this->set(compact('nomes'));
    }

}