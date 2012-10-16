<?php

class PermissoesController extends AppController {

    var $name = 'Permissoes';

    function index() {
        parent::temAcesso();
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

        $permissoes = $this->paginate('Permissao');
        $page = $this->params['form']['page'];
        $total = $this->Permissao->find('count', array('conditions' => $conditions));
        $this->set(compact('permissoes', 'page', 'total'));
    }

    function gerenciar($id = null) {
        parent::temAcesso();
        if (empty($this->data)) {
            $this->data = $this->Permissao->read();
        } else {
            if ($this->Permissao->save($this->data)) {
                $this->Session->setFlash('Cadastro salvo.');
                $this->redirect(array('controller' => $this->name, 'action' => 'index'));
            }
        }
    }

}