<?php

class Cras extends AppModel {

    var $name = 'Cras';
    var $primaryKey = 'id_cras';
    var $useTable = 'cras';
    var $tablePrefix = 'tb_';
    var $displayField = 'desc_cras';
    var $order = 'Cras.desc_cras';
    var $hasMany = array(
        'Domicilio' => array(
            'foreignKey' => 'id_cras',
            'dependent' => true
        ),
        'Bairro' => array(
            'foreignKey' => 'id_cras',
            'dependent' => true
        )
    );
    var $belongsTo = array(
        'Bairro' => array(
            'foreignKey' => 'id_bairro'
        ),
        'Regiao' => array(
            'foreignKey' => 'id_regiao'
        )
    );
    var $hasAndBelongsToMany = array(
        'Usuario' => array(
            'joinTable' => 'tb_cras_usuario',
            'foreignKey' => 'id_usuario',
            'associationForeignKey' => 'id_cras',
        )
    );
    var $recursive = 0;
    var $sequence = 'seq_cras';

}