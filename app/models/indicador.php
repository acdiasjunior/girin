<?php

class Indicador extends AppModel
{

    var $name = 'Indicador';
    var $useTable = 'indicador';
    var $tablePrefix = 'tb_';
    var $primaryKey = 'id_indicador';
    var $displayField = array("%s - %s", "{n}.Indicador.codigo", "{n}.Indicador.descricao");
    var $belongsTo = array(
        'Dimensao' => array(
            'foreignKey' => 'id_dimensao_idf'
        )
    );
    var $hasAndBelongsToMany = array('Estrategia', 'PlanoFamiliar');
    var $sequence = 'seq_indicador';

}