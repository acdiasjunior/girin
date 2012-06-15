<?php

class ParametrosUsuario extends AppModel {

    var $name = 'ParametrosUsuario';
    var $belongsTo = array('Parametro', 'Usuario');
	var $sequence = 'seq_parametro_usuario';

}