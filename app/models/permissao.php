<?php

class Permissao extends AppModel
{

    var $name = 'Permissao';
    var $primaryKey = 'id_permissao';
    var $useTable = 'permissao';
    var $tablePrefix = 'tb_';
    var $sequence = 'seq_permissao';

    //////////////////////////// COMBOS BOXES

    /*
     * static enum: Model::function()
     * @access static
     */

    static function permissaoAcesso($value = null)
    {
        $options = array(
            self::PERMISSAO_NENHUMA => __('Nenhuma', true),
            self::PERMISSAO_LEITURA => __('Leitura', true),
            self::PERMISSAO_ESCRITA => __('Escrita', true),
        );
        return parent::enum($value, $options);
    }

    const PERMISSAO_NENHUMA = 0;
    const PERMISSAO_LEITURA = 1;
    const PERMISSAO_ESCRITA = 2;

    static function permissaoAcessoSimples($value = null)
    {
        $options = array(
            self::PERMISSAO_NAO => __('Não', true),
            self::PERMISSAO_SIM => __('Sim', true),
        );
        return parent::enum($value, $options);
    }

    const PERMISSAO_NAO = 0;
    const PERMISSAO_SIM = 1;

}