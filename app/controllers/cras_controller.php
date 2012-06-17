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
      
        $cras = $this->paginate('Cras');
        $page = $this->params['form']['page'];
        $total = $this->Cras->find('count', array('conditions' => $conditions));
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

    function preencheCombo($regiao_id = null) {
        $this->layout = 'ajax';
        $this->autoRender = false;
        if ($regiao_id == null)
            $cras = $this->Cras->find('list');
        else
            $cras = $this->Cras->find('list', array('conditions' => array('Cras.regiao_id' => $regiao_id)));
        echo '<option value="">Selecione o CRAS</option>';
        foreach ($cras as $key => $value)
            echo '<option value="' . $key . '">' . $value . '</option>';
    }

}