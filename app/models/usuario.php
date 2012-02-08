<?php

class Usuario extends AppModel {

    var $name = 'Usuario';
    var $displayField = 'nome';
    var $hasMany = array('Acesso', 'Prontuario', 'Visita', 'ParametrosUsuario');
    var $hasAndBelongsToMany = array('Cras');

}