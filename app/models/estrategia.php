<?php

class Estrategia extends AppModel
{

    var $name = 'Estrategia';
    var $useTable = 'estrategia';
    var $tablePrefix = 'tb_';
    var $primaryKey = 'id_estrategia';
    var $displayField = array("%s - %s", "{n}.Estrategia.codigo", "{n}.Estrategia.descricao");
    var $hasMany = array('Acao' => array(
            'foreignKey' => 'id_estrategia',
            'dependent' => true
        )
    );
    var $hasAndBelongsToMany = array(
        'Indicador' => array(
            'joinTable' => 'tb_estrategia_indicador',
            'foreignKey' => 'id_estrategia_indicador',
            'associationForeignKey' => 'id_estrategia',
        ),
        'PlanoFamiliar' => array(
            'joinTable' => 'tb_plano_familiar',
            'foreignKey' => 'id_plano_familiar',
            'associationForeignKey' => 'id_estrategia',
        ),
    );
    var $order = array('Estrategia.codigo');
    var $sequence = 'seq_estrategia';

}