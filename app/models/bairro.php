<?php

class Bairro extends AppModel {

    var $name = 'Bairro';
    var $displayField = 'nome';
    var $order = 'nome';
    var $hasMany = array('Domicilio', 'Cras');
    var $belongsTo = array('Cras', 'Regiao');

}