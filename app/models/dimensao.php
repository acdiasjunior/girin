<?php

class Dimensao extends AppModel {

    var $name = 'Dimensao';
    var $primaryKey = 'id_dimensao_idf';
    var $useTable = 'dimensao_idf';
    var $tablePrefix = 'tb_';
    var $displayField = 'desc_dimensao_idf';
    var $hasMany = array(
        'Indicador' => array(
            'foreignKey' => 'id_dimensao_idf',
            'dependent' => true
        )
    );
    var $sequence = 'seq_dimensao';

}