<?php

class PlanoFamiliar extends AppModel {

    var $name = 'PlanoFamiliar';
    var $useTable = 'plano_familiar';
    var $tablePrefix = 'tb_';
    var $primaryKey = 'id_plano_familiar';
    var $belongsTo = array(
        'Domicilio' => array(
            'foreignKey' => 'cod_domiciliar',
        ),
        'Indice' => array(
            'foreignKey' => 'cod_domiciliar',
        ),
        'Usuario' => array(
            'foreignKey' => 'id_usuario',
        )
    );
    var $hasAndBelongsToMany = array(
        'Estrategia' => array(
            'joinTable' => 'tb_estrategia_plano_familiar',
            'foreignKey' => 'id_plano_familiar',
            'associationForeignKey' => 'id_estrategia',
        ),
        'Indicador' => array(
            'joinTable' => 'tb_indicador_plano_familiar',
            'foreignKey' => 'id_plano_familiar',
            'associationForeignKey' => 'id_indicador',
        ),
    );
    var $actsAs = array('DateFormatter');
    var $sequence = 'seq_plano_familiar';

}