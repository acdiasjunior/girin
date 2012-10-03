<?php

class Acesso extends AppModel
{

    var $name = 'Acesso';
    var $primaryKey = 'id_acesso';
    var $useTable = 'acesso';
    var $tablePrefix = 'tb_';
    var $belongsTo = array(
        'Usuario' => array(
            'foreignKey' => 'id_usuario'
        )
    );
    var $sequence = 'seq_acesso';

}