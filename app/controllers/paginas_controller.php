<?php

class PaginasController extends AppController {

    var $name = 'Paginas';
    var $uses = array('Page');

    function index() {
        $temAcessoExclusao = parent::temAcessoExclusao();
		$this->set(compact('temAcessoExclusao'));
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

        $paginas = $this->paginate('Page');
        $page = $this->params['form']['page'];
        $total = $this->Page->find('count', array('conditions' => $conditions));
        $this->set(compact('paginas', 'page', 'total'));
    }

    function cadastro($id = null) {
        if (empty($this->data)) {
            $this->Page->id = $id;
            $this->data = $this->Page->read();
			$temAcessoEscrita = parent::temAcessoEscrita();
			$this->set(compact('temAcessoEscrita'));
        } else {
            if ($this->Page->save($this->data)) {
                $this->Session->setFlash('Cadastro salvo.');
                $this->redirect(array('controller' => 'pages', 'action' => 'conheca'));
            }
        }
    }

}
