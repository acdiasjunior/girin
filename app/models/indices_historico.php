<?php

class IndicesHistorico extends AppModel
{

    var $name = 'IndicesHistorico';
    var $useTable = 'indice_historico';
    var $tablePrefix = 'tb_';
    var $primaryKey = 'id_indice_historico';
    var $belongsTo = array(
        'Indice' => array(
            'foreignKey' => 'cod_domiciliar',
        )
    );
    var $sequence = 'seq_indice_historico';

}