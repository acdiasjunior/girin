<?php

class Estrategia extends AppModel {

    var $name = 'Estrategia';
    var $useTable = 'estrategia';
    var $tablePrefix = 'tb_';
    var $primaryKey = 'id_estrategia';
    var $displayField = array("%s - %s", "{n}.Estrategia.cod_estrategia", "{n}.Estrategia.desc_estrategia");
    var $hasMany = array('Acao' => array(
            'foreignKey' => 'id_estrategia',
            'dependent' => true
        )
    );
    var $hasAndBelongsToMany = array(
        'Indicador' => array(
            'joinTable' => 'tb_estrategia_indicador',
            'foreignKey' => 'id_estrategia',
            'associationForeignKey' => 'id_indicador',
        ),
        'PlanoFamiliar' => array(
            'joinTable' => 'tb_estrategia_plano_familiar',
            'foreignKey' => 'id_estrategia',
            'associationForeignKey' => 'id_plano_familiar',
        ),
    );
    var $order = array('Estrategia.cod_estrategia');
    var $sequence = 'seq_estrategia';

}