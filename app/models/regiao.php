<?php

class Regiao extends AppModel
{

    var $name = 'Regiao';
    var $useTable = 'regiao';
    var $tablePrefix = 'tb_';
    var $primaryKey = 'id_regiao';
    var $displayField = 'desc_regiao';
    var $order = 'desc_regiao';
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