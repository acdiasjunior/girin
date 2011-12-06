<?php

class Usuario extends AppModel {

    var $name = 'Usuario';
    var $displayField = 'nome';
    var $hasMany = array('Acesso', 'Prontuario', 'Visita', 'ParametrosUsuario');
    var $hasOne = array(
        'UltimoAcesso' => array(
            'className' => 'Acesso',
            'order' => 'login DESC',
        )
    );

}