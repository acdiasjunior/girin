<?php

class Indicador extends AppModel {

    var $name = 'Indicador';
    var $displayField = array("%s - %s", "{n}.Indicador.codigo", "{n}.Indicador.descricao");
    var $belongsTo = array(
        'Dimensao' => array(
            'foreignKey' => 'id_dimensao_idf'
        )
    );
    var $hasAndBelongsToMany = array('Estrategia', 'Prontuario');
    var $sequence = 'seq_indicador';

}