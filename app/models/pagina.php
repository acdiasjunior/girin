<?php

class Pagina extends AppModel {

    var $name = 'Pagina';
    var $primaryKey = 'id_pagina';
    var $useTable = 'pagina';
    var $tablePrefix = 'tb_';
    var $displayField = 'desc_titulo';
    var $sequence = 'seq_pagina';

}