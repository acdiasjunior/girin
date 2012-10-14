<?php

class BairrosController extends AppController {

    var $name = 'Bairros';

    function index() {
        parent::temAcesso();
        $bairros = $this->Bairro->find('list');
        $temAcessoExclusao = parent::temAcessoExclusao();
        $this->set(compact('temAcessoExclusao', 'bairros'));
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
        parent::temAcesso();
        if (empty($this->data)) {
            $this->data = $this->Bairro->read();
            $temAcessoEscrita = parent::temAcessoEscrita();
            $this->set(compact('temAcessoEscrita'));
        } else {
            if ($this->Bairro->save($this->data)) {
                $this->Bairro->query('UPDATE tb_domicilio SET id_cras = (SELECT id_cras FROM tb_bairro WHERE tb_bairro.id_bairro = tb_domicilio.id_bairro), id_regiao = (SELECT id_regiao FROM tb_bairro WHERE tb_bairro.id_bairro = tb_domicilio.id_bairro)');
                $this->Session->setFlash('Cadastro salvo.');
                $this->redirect(array('controller' => $this->name, 'action' => 'index'));
            }
        }
    }

    function listaBairrosCras($id_cras) {
        $this->layout = 'ajax';

        $conditions = array('Bairro.id_cras =' => $id_cras);
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

    function preencheCombo($id_cras = null) {
        $this->layout = 'ajax';
        $this->autoRender = false;
        if ($id_cras == null)
            $cras = $this->Bairro->find('list');
        else
            $cras = $this->Bairro->find('list', array('conditions' => array('Bairro.id_cras' => $id_cras)));
        echo '<option value="">Selecione o Bairro</option>';
        foreach ($cras as $key => $value)
            echo '<option value="' . $key . '">' . $value . '</option>';
    }

    function excluir($id, $novo_bairro = null) {
        parent::temAcesso();
        if (!empty($id)) {
            $this->Bairro->delete($id);
            $this->Session->setFlash('O bairro com código: ' . $id . ' foi excluído.');
            $this->redirect(array('controller' => $this->name, 'action' => 'index'));
            if ($novo_bairro != null) {
                $this->loadModel('Domicilio');
                $this->Domicilio->updateAll(array('Domicilio.id_bairro' => $novo_bairro), array('Domicilio.id_bairro' => $id));
                $this->Domicilio->query('UPDATE tb_domicilio SET id_cras = (SELECT id_cras FROM tb_bairro WHERE tb_bairro.id_bairro = tb_domicilio.id_bairro), id_regiao = (SELECT id_regiao FROM tb_bairro WHERE tb_bairro.id_bairro = tb_domicilio.id_bairro)');
            }
        } else {
            $this->Session->setFlash('Erro ao tentar excluir: código inexistente!');
            $this->redirect(array('controller' => $this->name, 'action' => 'index'));
        }
    }

}