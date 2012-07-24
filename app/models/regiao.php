<?php

class Regiao extends AppModel {

    var $name = 'Regiao';
    var $displayField = 'descricao';
    var $order = 'descricao';
    var $hasMany = array(
        'Cras' => array(
            'foreignKey' => 'id_regiao',
            'dependent' => true
        ),
        'Bairro' => array(
            'foreignKey' => 'id_regiao',
            'dependent' => true
        ),
        'Domicilio' => array(
            'foreignKey' => 'id_regiao',
            'dependent' => true
        ),
    );
    var $recursive = 0;
    var $sequence = 'seq_regiao';

}