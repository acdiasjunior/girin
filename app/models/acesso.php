<?php

class Acesso extends AppModel {

    var $name = 'Acesso';
    var $primaryKey = 'id_acesso';
    var $belongsTo = array(
        'Usuario' => array(
            'foreignKey' => 'id_usuario'
        )
    );

}