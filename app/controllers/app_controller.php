<?php

class AppController extends Controller {

    var $components = array('Session', 'Auth', 'RequestHandler');
    var $helpers = array('Javascript', 'Js', 'Session', 'Html', 'Form', 'Formatacao');

    function temAcesso() {
        $this->loadModel('Permissao');
        $permissoes = $this->Permissao->find('first', array(
            'conditions' => array(
                'Permissao.nome_controller' => $this->params['controller'],
                'Permissao.nome_action' => $this->params['action'],
                ))
        );
        $id_grupo = $this->Session->read('Auth.Usuario.id_grupo');
        switch ($id_grupo) {
            case Usuario::GRUPO_ADMINISTRADOR:
                return;
                break;
            case Usuario::GRUPO_TECNICO_SAS:
                if ($permissoes['Permissao']['tp_acesso_tecnico_sas'] != Permissao::PERMISSAO_NENHUMA)
                    return;
                break;
            case Usuario::GRUPO_COORDENADOR_CRAS:
                if ($permissoes['Permissao']['tp_acesso_coordenador_cras'] != Permissao::PERMISSAO_NENHUMA)
                    return;
                break;
            case Usuario::GRUPO_TECNICO_CRAS:
                if ($permissoes['Permissao']['tp_acesso_tecnico_cras'] != Permissao::PERMISSAO_NENHUMA)
                    return;
                break;
        }
        
        $this->Session->setFlash('Acesso negado!');
        $this->redirect('/');
    }
	
	function temAcessoEscrita() {
		$this->loadModel('Permissao');
        $permissoes = $this->Permissao->find('first', array(
            'conditions' => array(
                'Permissao.nome_controller' => $this->params['controller'],
                'Permissao.nome_action' => $this->params['action'],
                ))
        );
        $id_grupo = $this->Session->read('Auth.Usuario.id_grupo');
        switch ($id_grupo) {
            case Usuario::GRUPO_ADMINISTRADOR:
                return true;
                break;
            case Usuario::GRUPO_TECNICO_SAS:
                if ($permissoes['Permissao']['tp_acesso_tecnico_sas'] == Permissao::PERMISSAO_ESCRITA)
                    return true;
                break;
            case Usuario::GRUPO_COORDENADOR_CRAS:
                if ($permissoes['Permissao']['tp_acesso_coordenador_cras'] == Permissao::PERMISSAO_ESCRITA)
                    return true;
                break;
            case Usuario::GRUPO_TECNICO_CRAS:
                if ($permissoes['Permissao']['tp_acesso_tecnico_cras'] == Permissao::PERMISSAO_ESCRITA)
                    return true;
                break;
        }
		return false;
	}

    function _populateLookups($models = array()) {
        if (empty($models)) {
            $rootModel = $this->{$this->modelClass};
            foreach ($rootModel->belongsTo as $model => $attr) {
                $models[] = $model;
            }
            foreach ($rootModel->hasAndBelongsToMany as $model => $attr) {
                $models[] = $model;
            }
        }
        foreach ($models as $model) {
            $name = Inflector::variable(Inflector::pluralize($model));
            $this->set($name, $rootModel->{$model}->find("list"));
        }
    }

    function beforeRender() {
        $this->disableCache();
        switch ($this->action) {
            case 'cadastro';
                $this->_populateLookups();
                break;
        }
        $this->loadModel('Page');
        $paginas = $this->Page->find('all');
        $this->set('paginas', $paginas);
    }

    function beforeFilter() {
        Security::setHash('sha256'); // substitua pelo hash que está usando
        $this->Auth->userModel = 'Usuario'; // nome do seu modelo de usuario
        //$this->Auth->fields = array('username' => 'login', 'password' => 'senha'); // campos correspondentes a usuario e senha
        $this->Auth->authorize = 'controller';
        $this->Auth->autoRedirect = false; // auto redirecionar
        $this->Auth->loginAction = array('admin' => false, 'controller' => 'usuarios', 'action' => 'login'); // controlador e action de login
        $this->Auth->loginRedirect = ('/'); // controlador e action para enviar o usuario que entrou
        $this->Auth->logoutRedirect = array('controller' => 'usuarios', 'action' => 'login');
        $this->Auth->loginError = "Login inválido."; // mensagem de erro
        $this->Auth->authError = "Área restrita, por favor faça o login."; // mensagem de acesso restrito
    }

    function isAuthorized() {
        return true;
    }

    function isUploadedFile($file) {
        if ((isset($file['error']) && $file['error'] == 0) ||
                (!empty($file['tmp_name']) && $file['tmp_name'] != 'none')) {
            return is_uploaded_file($file['tmp_name']);
        }
        return false;
    }

    /**
     * Post Model
     *
     * @var Post
     */
    var $Post;

    /**
     * User Model
     *
     * @var User
     */
    var $User;

    /**
     * Group Model
     *
     * @var Group
     */
    var $Group;

    /**
     * AuthComponent
     *
     * @var AuthComponent
     */
    var $Auth;

    /**
     * SessionComponent
     *
     * @var SessionComponent
     */
    var $Session;

    /**
     * RequestHandlerComponent
     *
     * @var RequestHandlerComponent
     */
    var $RequestHandler;

}