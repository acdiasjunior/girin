<?php

class CrasUsuario extends AppModel
{

    var $name = 'CrasUsuario';
    var $primaryKey = 'id_cras_usuario';
    var $useTable = 'cras_usuario';
    var $tablePrefix = 'tb_';
    var $belongsTo = array(
        'Cras' => array(
            'foreignKey' => 'id_cras',
        ),
        'Usuario' => array(
            'foreignKey' => 'id_usuario',
        ),
    );
    var $sequence = 'seq_cras_usuario';

}