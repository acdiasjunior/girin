<?php

class Visita extends AppModel {

    var $name = 'Visita';
    var $belongsTo = array('Usuario', 'Prontuario');
	var $sequence = 'seq_visita';

}