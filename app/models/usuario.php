<?php

class Usuario extends AppModel {

    var $name = 'Usuario';
    var $displayField = 'nome';
    var $hasMany = array('Acesso', 'Prontuario', 'Visita', 'ParametrosUsuario');
    var $hasAndBelongsToMany = array('Cras');

    public function crasUsuario() {
        $this->id = $this->Session->read('Auth.Usuario.id');
        $cras_usuario = '';

        if ($this->id == 1) {
            $this->loadModel('Cras');
            $cras_usuario = array_keys($this->Cras->find('list'));
        } else {
            $usuario = $this->Usuario->read();
            foreach ($usuario['Cras'] as $cras)
                $cras_usuario[] = $cras['id'];
        }

        return implode(',', $cras_usuario);
    }

}