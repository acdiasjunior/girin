<?php

class UsuariosController extends AppController {

    var $name = 'Usuarios';

    function index() {
        parent::temAcesso();
        if ($this->Session->read('Auth.Usuario.id_grupo') != Usuario::GRUPO_ADMINISTRADOR) {
            $this->Session->setFlash('Somente administradores podem<br />cadastrar usuários!');
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
        parent::temAcesso();
        if (empty($this->data)) {
            if ($id == null && $this->Session->read('Auth.Usuario.id') != 1)
                $id = $this->Session->read('Auth.Usuario.id');
            if ($id == 1) {
                $this->Session->setFlash('Alteração do Usuário Admistrador desabilitada!');
                $this->redirect(array('controller' => 'pages'));
            }
            if ($id != $this->Session->read('Auth.Usuario.id') && $this->Session->read('Auth.Usuario.id_grupo') != Usuario::GRUPO_ADMINISTRADOR) {
                $this->Session->setFlash('Somente administradores podem alterar os outros cadastros.');
                $this->redirect(array('controller' => 'pages'));
            }
            $this->Usuario->id = $id;
            $this->data = $this->Usuario->read();
        } else {
            $this->beforeSave();
            if ($this->Usuario->save($this->data)) {
                if ($this->Session->read('Auth.Usuario.id_grupo') == Usuario::GRUPO_ADMINISTRADOR)
                    $this->redirect(array('controller' => $this->name, 'action' => 'index'));
                else
                    $this->redirect(array('controller' => 'pages'));
            }
        }
    }

    function excluir($id) {
        parent::temAcesso();
        if ($this->Session->read('Auth.Usuario.id_grupo') != Usuario::GRUPO_ADMINISTRADOR) {
            $this->Session->setFlash('Somente administradores podem<br />excluir usuários!');
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
        if (!(empty($this->data)) && $this->Auth->user()) {
            $this->Usuario->Acesso->create();
            $this->Usuario->Acesso->set('id_usuario', $this->Session->read('Auth.Usuario.id'));
            $this->Usuario->Acesso->set('dt_login', date('Y-m-d H:i:s'));
            $this->Usuario->Acesso->set('cod_ip', $this->RequestHandler->getClientIP());
            $this->Usuario->Acesso->save();
            $this->redirect($this->Auth->redirect());
        }
    }
    
    // Usado para mudar senha pelo proprio usuario
    function mudarSenha() {
        if (!empty($this->data['Usuario']['nova_senha'])) {
            $this->Usuario->id = $this->Session->read('Auth.Usuario.id');
            $this->Usuario->set('password', $this->Auth->password($this->data['Usuario']['nova_senha']));
            if ($this->Usuario->save($this->data))
                $this->Session->setFlash('Senha alterada!');
            else
                $this->Session->setFlash('Erro ao gravar a nova senha!');
            $this->redirect('/');
        }
    }
    
    // Usado pelo admin para mudar senha do usuario
    function mudarSenhaUsuario() {
        if (!empty($this->data)) {
            $this->Usuario->set('password', $this->Auth->password($this->data['Usuario']['nova_senha']));
            if ($this->Usuario->save($this->data)) {
                $this->Session->setFlash('Senha alterada com sucesso!');
            } else {
                $this->Session->setFlash('Erro ao alterar senha do usuário!');
            }
            $this->redirect(array('controller' => $this->name, 'action' => 'index'));
        }
        $this->render('admin_index');
    }

    function logout() {
        $this->redirect($this->Auth->logout());
    }
    
    function gravaParametros($container) {
        $this->autoRender = false;
        $controller = array_shift($this->params['form']);
        $action = array_shift($this->params['form']);
        $this->Session->delete("$controller.$action.$container");
        foreach($this->params['form'] as $key => $value) {
            $this->Session->write("$controller.$action.$container.$key", $value);
        }
    }

    function beforeFilter() {
        $this->Auth->autoRedirect = false;
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

}
