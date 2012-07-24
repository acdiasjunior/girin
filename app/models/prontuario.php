<?php

class Prontuario extends AppModel {

    var $name = 'Prontuario';
    var $hasMany = array('Visita');
    var $belongsTo = array(
        'Domicilio' => array(
            'foreignKey' => 'cod_domiciliar',
        ),
        'Indice' => array(
            'foreignKey' => 'cod_domiciliar',
        ),
        'Usuario',
    );
    var $hasAndBelongsToMany = array('Estrategia', 'Indicador');
    var $actsAs = array('DateFormatter');
    var $sequence = 'seq_prontuario';

}