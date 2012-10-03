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
    var $hasAndBelongsToMany = array('Indicador', 'PlanoFamiliar');
    var $order = array('Estrategia.codigo');
    var $sequence = 'seq_estrategia';

}