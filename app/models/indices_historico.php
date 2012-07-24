<?php

class IndicesHistorico extends AppModel {

    var $name = 'IndicesHistorico';
    var $belongsTo = array(
        'Indice' => array(
            'foreignKey' => 'cod_domiciliar',
        )
    );
    var $sequence = 'seq_indice_historico';

}