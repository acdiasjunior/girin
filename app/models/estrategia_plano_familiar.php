<?php

class EstrategiaPlanoFamiliar extends AppModel {

    var $name = 'EstrategiaPlanoFamiliar';
    var $useTable = 'estrategia_plano_familiar';
    var $tablePrefix = 'tb_';
    var $primaryKey = 'id_estrategia_plano_familiar';
    var $belongsTo = array(
        'PlanoFamiliar' => array(
            'foreignKey' => 'id_plano_familiar'
        ),
        'Estrategia' => array(
            'foreignKey' => 'id_estrategia'
        )
    );
}