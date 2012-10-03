<?php

class Visita extends AppModel
{

    var $name = 'Visita';
    var $useTable = 'visita';
    var $tablePrefix = 'tb_';
    var $primaryKey = 'id_visita';
    var $belongsTo = array('Usuario', 'PlanoFamiliar');
    var $sequence = 'seq_visita';

}