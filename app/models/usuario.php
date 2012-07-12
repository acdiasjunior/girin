<?php

class Usuario extends AppModel {

    var $name = 'Usuario';
    var $displayField = 'nome';
    var $hasMany = array(
        'Acesso' => array(
            'foreignKey' => 'id_usuario',
            'dependent' => true
        ),
        'Prontuario',
        'Visita',
        'ParametrosUsuario'
    );
    var $hasAndBelongsToMany = array(
        'Cras' => array(
            'joinTable' => 'tb_cras_usuario',
            'foreignKey' => 'id_cras',
            'associationForeignKey' => 'id_usuario',
        )
    );
    var $sequence = 'seq_usuario';

    //////////////////////////// COMBOS BOXES

    /*
     * static enum: Model::function()
     * @access static
     */

    static function grupoUsuario($value = null) {
        $options = array(
            self::GRUPO_ADMINISTRADOR => __('Administrador', true),
            self::GRUPO_TECNICO_SAS => __('Técnico SAS', true),
            self::GRUPO_COORDENADOR_CRAS => __('Coordenador CRAS', true),
            self::GRUPO_TECNICO_CRAS => __('Técnico CRAS', true),
        );
        return parent::enum($value, $options);
    }

    const GRUPO_ADMINISTRADOR = 1;
    const GRUPO_TECNICO_SAS = 2;
    const GRUPO_COORDENADOR_CRAS = 3;
    const GRUPO_TECNICO_CRAS = 4;

}