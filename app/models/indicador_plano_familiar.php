<?php

class IndicadorPlanoFamiliar extends AppModel {

    var $name = 'IndicadorPlanoFamiliar';
    var $useTable = 'indicador_plano_familiar';
    var $tablePrefix = 'tb_';
    var $primaryKey = 'id_indicador_plano_familiar';
    var $belongsTo = array(
        'PlanoFamiliar' => array(
            'foreignKey' => 'id_plano_familiar'
        ),
        'Indicador' => array(
            'foreignKey' => 'id_indicador'
        )
    );
}