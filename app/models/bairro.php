<?php

class Bairro extends AppModel {

    var $name = 'Bairro';
    var $primaryKey = 'id_bairro';
    var $useTable = 'bairro';
    var $tablePrefix = 'tb_';
    var $displayField = 'nome_bairro';
    var $order = 'nome_bairro';
    var $hasMany = array(
        'Domicilio' => array(
            'foreignKey' => 'id_bairro',
            'dependent' => true
        ),
        'Cras' => array(
            'foreignKey' => 'id_bairro',
            'dependent' => true
        )
    );
    var $belongsTo = array(
        'Cras' => array(
            'foreignKey' => 'id_cras'
        ),
        'Regiao' => array(
            'foreignKey' => 'id_regiao'
        )
    );
    var $sequence = 'seq_bairro';

    public function __construct($id = false, $table = null, $ds = null) {
        parent::__construct($id, $table, $ds);
        $this->virtualFields = array(
            'domicilio_count' => 'SELECT COUNT(*) FROM tb_domicilio WHERE tb_domicilio.id_bairro = Bairro.id_bairro'
        );
    }

}