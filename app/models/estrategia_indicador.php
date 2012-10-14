<?php

class EstrategiaIndicador extends AppModel {

    var $name = 'EstrategiaIndicador';
    var $useTable = 'estrategia_indicador';
    var $tablePrefix = 'tb_';
    var $primaryKey = 'id_estrategia_indicador';
    var $belongsTo = array(
        'Estrategia' => array(
            'foreignKey' => 'id_estrategia_indicador',
        ),
        'Indicador' => array(
            'foreignKey' => 'id_estrategia_indicador',
        ),
    );
    var $sequence = 'seq_estrategia_indicador';

}