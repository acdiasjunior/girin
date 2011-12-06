<?php

class UsuariosController extends AppController {

    var $name = 'Usuarios';
    var $scaffold;

    function index() {
        if ($this->Session->read('Auth.Usuario.id') != 1) {
            $this->Session->setFlash('Somente o Administrador pode<br />cadastrar usuários!');
            $this->redirect(array('controller' => 'pages'));
        }
    }

    function lista() {
        $this->layout = 'ajax';
        $this->Usuario->order = array(
            $this->params['form']['sortname'] => $this->params['form']['sortorder']
        );
        $data = $this->Usuario->find('all', array('conditions' => array('Usuario.id <>' => 1)));
        $this->set('usuarios', $data);
    }

    function cadastro($id = null) {
        if (empty($this->data)) {
            if ($id == null && $this->Session->read('Auth.Usuario.id') != 1)
                $id = $this->Session->read('Auth.Usuario.id');
            if ($id == 1) {
                $this->Session->setFlash('Alteração do Usuário Admistrador desabilitada!');
                $this->redirect(array('controller' => 'pages'));
            }
            if ($id != $this->Session->read('Auth.Usuario.id') && $this->Session->read('Auth.Usuario.id') != 1) {
                $this->Session->setFlash('Somente o Administrador pode alterar os outros cadastros.');
                $this->redirect(array('controller' => 'pages'));
            }
            $this->Usuario->id = $id;
            $this->data = $this->Usuario->read();
        } else {
            $this->beforeSave();
            if ($this->Usuario->save($this->data)) {
                if ($this->Session->read('Auth.Usuario.id') == 1)
                    $this->redirect(array('controller' => $this->name, 'action' => 'index'));
                else
                    $this->redirect(array('controller' => 'pages'));
            }
        }
    }

    function excluir($id) {
        if ($this->Session->read('Auth.Usuario.id') != 1) {
            $this->Session->setFlash('Somente o Administrador pode<br />excluir usuários!');
            $this->redirect(array('controller' => 'pages'));
        } else {
            if (!empty($id)) {
                $this->Usuario->delete($id);
                $this->Session->setFlash('O usuario com id: ' . $id . ' foi excluído.');
                $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash('Erro ao tentar excluir: ID inexistente!');
                $this->redirect(array('action' => 'index'));
            }
        }
    }

    function login() {
//        $data = $this->Auth->password('prefeitura');
//        $this->set('pass', $data);
    }

    function logout() {
//        $this->Usuario->UltimoAcesso->create();
//        $this->Usuario->UltimoAcesso->set('id', $this->Usuario->field('ultimo_acesso_id'))
//                ->set('logout', date('Y-m-d H:i:s'));
//        if ($this->Usuario->UltimoAcesso->save())
//            $this->Usuario->create()
//                    ->set('id', $this->Session->read('Auth.Usuario.id'))
//                    ->set('ultimo_acesso_id', $this->Usuario->UltimoAcesso->id)
//                    ->save();
        $this->redirect($this->Auth->logout());
    }

    function beforeFilter() {
        // executa o beforeFilter do AppController
        parent::beforeFilter();
        // adicione ao método allow as actions que quer permitir sem o usuário estar logado
        $this->Auth->allow(array('login', 'logout'));
    }

    function beforeSave() {
        if (!empty($this->data['Usuario']['passwd'])) {
            $this->data['Usuario']['password'] = $this->Auth->password($this->data['Usuario']['passwd']);
        }
        return true;
    }
    
    function beforeRender() {
//        if ($this->Session->check('Auth.Usuario')) {
//            $this->Usuario->UltimoAcesso->create();
//            $this->Usuario->UltimoAcesso->set('usuario_id', $this->Session->read('Auth.Usuario.id'));
//            $this->Usuario->UltimoAcesso->set('login', date('Y-m-d H:i:s'));
//            $this->Usuario->UltimoAcesso->set('ip', $this->RequestHandler->getClientIP());
//            if ($this->Usuario->UltimoAcesso->save()) {
//                $this->Usuario->create();
//                $this->Usuario->set('id', $this->Session->read('Auth.Usuario.id'));
//                $this->Usuario->set('ultimo_acesso_id', $this->Usuario->UltimoAcesso->id);
//                $this->Usuario->save();
//            }
//            $this->redirect('/');
//        }
        parent::beforeRender();
    }

}
