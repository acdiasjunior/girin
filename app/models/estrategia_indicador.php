<?php

class EstrategiaIndicador extends AppModel {

    var $name = 'EstrategiaIndicador';
    var $useTable = 'estrategias_indicadores';
    var $belongsTo = array('Estrategia', 'Indicador');
	var $sequence = 'seq_estrategia_indicador';

}