<?php

class Indicador extends AppModel {

    var $name = 'Indicador';
    var $useTable = 'indicador';
    var $tablePrefix = 'tb_';
    var $primaryKey = 'id_indicador';
    var $displayField = array("%s - %s", "{n}.Indicador.cod_indicador", "{n}.Indicador.desc_indicador");
    var $belongsTo = array(
        'Dimensao' => array(
            'foreignKey' => 'id_dimensao_idf'
        )
    );
    var $hasAndBelongsToMany = array(
        'Estrategia' => array(
            'joinTable' => 'tb_estrategia_indicador',
            'foreignKey' => 'id_indicador',
            'associationForeignKey' => 'id_estrategia',
        ),
        'PlanoFamiliar' => array(
            'joinTable' => 'tb_indicador_plano_familiar',
            'foreignKey' => 'id_indicador',
            'associationForeignKey' => 'id_plano_familiar',
        ),
    );
    var $sequence = 'seq_indicador';

}