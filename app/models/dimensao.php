<?php

class Dimensao extends AppModel {

    var $name = 'Dimensao';
    var $displayField = 'descricao';
    var $hasMany = array('Indicador');
	var $sequence = 'seq_dimensao';

}