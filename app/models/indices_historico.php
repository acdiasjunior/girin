<?php

class IndicesHistorico extends AppModel {

    var $name = 'IndicesHistorico';
    var $belongsTo = array(
        'Indice' => array(
            'foreignKey' => 'codigo_domiciliar',
        )
    );
	var $sequence = 'seq_indice_historico';

}