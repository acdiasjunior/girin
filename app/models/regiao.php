<?php

class Regiao extends AppModel {

    var $name = 'Regiao';
    var $displayField = 'descricao';
    var $order = 'descricao';
    var $hasMany = array(
        'Cras' => array(
            'foreignKey' => 'id_bairro',
            'dependent' => true
        ),
        'Bairro',
        'Domicilio'
    );
    var $recursive = 0;
    var $sequence = 'seq_regiao';

}