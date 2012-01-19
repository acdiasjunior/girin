<?php

class Domicilio extends AppModel {

    var $name = 'Domicilio';
    var $primaryKey = 'codigo_domiciliar';
    var $belongsTo = array(
        'Cras',
        'Regiao',
        'Bairro',
        'Responsavel' => array(
            'className' => 'Pessoa',
            'foreignKey' => 'nis_responsavel'
        )
    );
    var $hasOne = array(
        'Indice' => array(
            'foreignKey' => 'codigo_domiciliar',
            'dependent' => true
        ),
    );
    var $hasMany = array(
        'Prontuario' => array(
            'foreignKey' => 'codigo_domiciliar',
        ),
        'Pessoa' => array(
            'foreignKey' => 'codigo_domiciliar',
            'order' => 'data_nascimento ASC'
        )
    );
    var $validate = array(
        'codigo_domiciliar' => array(
            'rule' => 'isUnique'
        ),
    );
    var $actsAs = array('DateFormatter');

    public function __construct($id=false, $table=null, $ds=null) {
        parent::__construct($id, $table, $ds);
        $pessoa_count = '(SELECT COUNT(*) FROM pessoas WHERE `pessoas`.`codigo_domiciliar` = `Domicilio`.`codigo_domiciliar`)';
        $this->virtualFields = array(
            'renda_familiar' => "SELECT SUM(`pessoas`.`valor_renda` + `pessoas`.`valor_beneficio`) FROM `pessoas` WHERE `pessoas`.`codigo_domiciliar` = `Domicilio`.`codigo_domiciliar`",
            'renda_per_capita' => "SELECT SUM((`pessoas`.`valor_renda` + `pessoas`.`valor_beneficio`) / $pessoa_count) FROM `pessoas` WHERE `pessoas`.`codigo_domiciliar` = `Domicilio`.`codigo_domiciliar`",
            'pessoa_count' => $pessoa_count,
        );
    }

    //////////////////////////// COMBOS BOXES

    /*
     * static enum: Model::function()
     * @access static
     */

    static function bolsaFamilia($value = null) { // 211
        $options = array(
            self::BOLSA_FAMILIA_NAO => __('Não', true),
            self::BOLSA_FAMILIA_SIM => __('Sim', true),
        );
        return parent::enum($value, $options);
    }

    const BOLSA_FAMILIA_NAO = 0;
    const BOLSA_FAMILIA_SIM = 1;

    static function tipoLocalidade($value = null) {
        $options = array(
            self::LOCALIDADE_NAO_INFORMADO => __('Não Informado', true),
            self::LOCALIDADE_URBANA => __('Urbana', true),
            self::LOCALIDADE_RURAL => __('Rural', true),
        );
        return parent::enum($value, $options);
    }

    const LOCALIDADE_NAO_INFORMADO = 0;
    const LOCALIDADE_URBANA = 1;
    const LOCALIDADE_RURAL = 2;

    static function situacaoDomicilio($value = null) { // 213
        $options = array(
            self::DOMICILIO_NAO_INFORMADO => __('Não Informado', true),
            self::DOMICILIO_PROPRIO => __('Próprio', true),
            self::DOMICILIO_ALUGADO => __('Alugado', true),
            self::DOMICILIO_ARRENDADO => __('Arrendado', true),
            self::DOMICILIO_CEDIDO => __('Cedido', true),
            self::DOMICILIO_INVASAO => __('Invasão', true),
            self::DOMICILIO_FINANCIADO => __('Financiado', true),
            self::DOMICILIO_OUTRA => __('Outra', true),
        );
        return parent::enum($value, $options);
    }

    const DOMICILIO_NAO_INFORMADO = 0;
    const DOMICILIO_PROPRIO = 1;
    const DOMICILIO_ALUGADO = 2;
    const DOMICILIO_ARRENDADO = 3;
    const DOMICILIO_CEDIDO = 4;
    const DOMICILIO_INVASAO = 5;
    const DOMICILIO_FINANCIADO = 6;
    const DOMICILIO_OUTRA = 7;

    static function tipoDomicilio($value = null) { // 214
        $options = array(
            self::TIPO_DOMICILIO_NAO_INFORMADO => __('Não Informado', true),
            self::TIPO_DOMICILIO_APARTAMENTO => __('Apartamento', true),
            self::TIPO_DOMICILIO_CASA => __('Casa', true),
            self::TIPO_DOMICILIO_COMODOS => __('Cômodos', true),
            self::TIPO_DOMICILIO_OUTRO => __('Outro', true),
        );
        return parent::enum($value, $options);
    }

    const TIPO_DOMICILIO_NAO_INFORMADO = 0;
    const TIPO_DOMICILIO_CASA = 1;
    const TIPO_DOMICILIO_APARTAMENTO = 2;
    const TIPO_DOMICILIO_COMODOS = 3;
    const TIPO_DOMICILIO_OUTRO = 4;

    static function tipoConstrucao($value = null) { // 216
        $options = array(
            self::CONSTRUCAO_NAO_INFORMADO => __('Não Informado', true),
            self::CONSTRUCAO_TIJOLO_ALVENARIA => __('Tijolo/Alvenaria', true),
            self::CONSTRUCAO_ADOBE => __('Adobe', true),
            self::CONSTRUCAO_MADEIRA => __('Madeira', true),
            self::CONSTRUCAO_MATERIAL_APROVEITADO => __('Material Aproveitado', true),
            self::CONSTRUCAO_TAIPA_REVESTIDA => __('Taipa Revestida', true),
            self::CONSTRUCAO_TAIPA_NAO_REVESTIDA => __('Taipa não Revestida', true),
            self::CONSTRUCAO_OUTRO => __('Outro', true),
        );
        return parent::enum($value, $options);
    }

    const CONSTRUCAO_NAO_INFORMADO = 0;
    const CONSTRUCAO_TIJOLO_ALVENARIA = 1;
    const CONSTRUCAO_ADOBE = 2;
    const CONSTRUCAO_TAIPA_REVESTIDA = 3;
    const CONSTRUCAO_TAIPA_NAO_REVESTIDA = 4;
    const CONSTRUCAO_MADEIRA = 5;
    const CONSTRUCAO_MATERIAL_APROVEITADO = 6;
    const CONSTRUCAO_OUTRO = 7;

    static function tipoAbastecimentoAgua($value = null) { // 217
        $options = array(
            self::ABASTECIMENTO_NAO_INFORMADO => __('Não Informado', true),
            self::ABASTECIMENTO_REDE_PUBLICA => __('Rede Pública', true),
            self::ABASTECIMENTO_POCO_NASCENTE => __('Poço/Nascente', true),
            self::ABASTECIMENTO_CARRO_PIPA => __('Carro Pipa', true),
            self::ABASTECIMENTO_OUTRO => __('Outro', true),
        );
        return parent::enum($value, $options);
    }

    const ABASTECIMENTO_NAO_INFORMADO = 0;
    const ABASTECIMENTO_REDE_PUBLICA = 1;
    const ABASTECIMENTO_POCO_NASCENTE = 2;
    const ABASTECIMENTO_CARRO_PIPA = 3;
    const ABASTECIMENTO_OUTRO = 4;

    static function tratamentoAgua($value = null) { // 218
        $options = array(
            self::TRATAMENTO_NAO_INFORMADO => __('Não Informado', true),
            self::TRATAMENTO_FILTRACAO => __('Filtração', true),
            self::TRATAMENTO_FERVURA => __('Fervura', true),
            self::TRATAMENTO_CLORACAO => __('Cloração', true),
            self::TRATAMENTO_SEM_TRATAMENTO => __('Sem Tratamento', true),
            self::TRATAMENTO_OUTRO => __('Outro', true),
        );
        return parent::enum($value, $options);
    }

    const TRATAMENTO_NAO_INFORMADO = 0;
    const TRATAMENTO_FILTRACAO = 1;
    const TRATAMENTO_FERVURA = 2;
    const TRATAMENTO_CLORACAO = 3;
    const TRATAMENTO_SEM_TRATAMENTO = 4;
    const TRATAMENTO_OUTRO = 5;

    static function tipoIluminacao($value = null) { // 219
        $options = array(
            self::ILUMINACAO_NAO_INFORMADO => __('Não Informado', true),
            self::ILUMINACAO_RELOGIO_PROPRIO => __('Relógio Próprio', true),
            self::ILUMINACAO_RELOGIO_COMUNITARIO => __('Relógio Comunitário', true),
            self::ILUMINACAO_SEM_RELOGIO => __('Sem Relógio', true),
            self::ILUMINACAO_LAMPIAO => __('Lampião', true),
            self::ILUMINACAO_VELA => __('Vela', true),
            self::ILUMINACAO_OUTRO => __('Outro', true),
        );
        return parent::enum($value, $options);
    }

    const ILUMINACAO_NAO_INFORMADO = 0;
    const ILUMINACAO_RELOGIO_PROPRIO = 1;
    const ILUMINACAO_SEM_RELOGIO = 2;
    const ILUMINACAO_RELOGIO_COMUNITARIO = 3;
    const ILUMINACAO_LAMPIAO = 4;
    const ILUMINACAO_VELA = 5;
    const ILUMINACAO_OUTRO = 6;

    static function escoamentoSanitario($value = null) { // 220
        $options = array(
            self::ESCOAMENTO_NAO_INFORMADO => __('Não Informado', true),
            self::ESCOAMENTO_REDE_PUBLICA => __('Rede pública', true),
            self::ESCOAMENTO_FOSSA_SEPTICA => __('Fossa Séptica', true),
            self::ESCOAMENTO_FOSSA_RUDIMENTAR => __('Fossa Rudimentar', true),
            self::ESCOAMENTO_VALA => __('Vala', true),
            self::ESCOAMENTO_CEU_ABERTO => __('Céu Aberto', true),
            self::ESCOAMENTO_OUTRO => __('Outro', true),
        );
        return parent::enum($value, $options);
    }

    const ESCOAMENTO_NAO_INFORMADO = 0;
    const ESCOAMENTO_REDE_PUBLICA = 1;
    const ESCOAMENTO_FOSSA_RUDIMENTAR = 2;
    const ESCOAMENTO_FOSSA_SEPTICA = 3;
    const ESCOAMENTO_VALA = 4;
    const ESCOAMENTO_CEU_ABERTO = 5;
    const ESCOAMENTO_OUTRO = 6;

    static function destinoLixo($value = null) { // 221
        $options = array(
            self::LIXO_NAO_INFORMADO => __('Não Informado', true),
            self::LIXO_COLETADO => __('Coletado', true),
            self::LIXO_QUEIMADO => __('Queimado', true),
            self::LIXO_ENTERRADO => __('Enterrado', true),
            self::LIXO_CEU_ABERTO => __('Céu Aberto', true),
            self::LIXO_OUTRO => __('Outro', true),
        );
        return parent::enum($value, $options);
    }

    const LIXO_NAO_INFORMADO = 0;
    const LIXO_COLETADO = 1;
    const LIXO_QUEIMADO = 2;
    const LIXO_ENTERRADO = 3;
    const LIXO_CEU_ABERTO = 4;
    const LIXO_OUTRO = 5;
}