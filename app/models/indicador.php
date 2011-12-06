<?php

class Indicador extends AppModel {

    var $name = 'Indicador';
    var $displayField = 'descricao';
    var $belongsTo = array('Dimensao');
    var $hasAndBelongsToMany = array('Estrategia', 'Prontuario');
    
}