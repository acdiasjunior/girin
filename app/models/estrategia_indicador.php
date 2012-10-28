<?php

class EstrategiaIndicador extends AppModel {

    var $name = 'EstrategiaIndicador';
    var $useTable = 'estrategia_indicador';
    var $tablePrefix = 'tb_';
    var $primaryKey = 'id_estrategia_indicador';
    var $belongsTo = array(
        'Indicador' => array(
            'foreignKey' => 'id_indicador'
        ),
        'Estrategia' => array(
            'foreignKey' => 'id_estrategia'
        )
    );
}