<?php

class PaginasController extends AppController {

    var $name = 'Paginas';

    function index() {
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

        $paginas = $this->paginate('Pagina');
        $page = $this->params['form']['page'];
        $total = $this->Pagina->find('count', array('conditions' => $conditions));
        $this->set(compact('paginas', 'page', 'total'));
    }

    function cadastro($id = null) {
        if (empty($this->data)) {
            $this->Pagina->id = $id;
            $this->data = $this->Pagina->read();
            $temAcessoEscrita = parent::temAcessoEscrita();
            $this->set(compact('temAcessoEscrita'));
        } else {
            if ($this->Pagina->save($this->data)) {
                $this->Session->setFlash('Cadastro salvo.');
                $this->redirect(array('controller' => 'pages', 'action' => 'conheca'));
            }
        }
    }
    
    function excluir($id) {
        parent::temAcesso();
        if (!empty($id)) {
            $this->Pagina->delete($id);
            $this->Session->setFlash('A página com código: ' . $id . ' foi excluída.');
        } else {
            $this->Session->setFlash('Erro ao tentar excluir: id inexistente!');
        }
        $this->redirect(array('action' => 'index'));
    }

}
