<?php

class Usuario extends AppModel {

    var $name = 'Usuario';
    var $displayField = 'nome';
    var $hasMany = array(
        'Acesso' => array(
            'foreignKey' => 'id_usuario',
            'dependent' => true
        ),
        'Prontuario',
        'Visita',
        'ParametrosUsuario'
    );
    var $hasAndBelongsToMany = array('Cras');

}