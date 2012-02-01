<?php

class Pessoa extends AppModel {

    var $name = 'Pessoa';
    var $primaryKey = 'nis';
    var $displayField = 'nome';
    var $actsAs = array('DateFormatter');
    var $hasAndBelongsToMany = array(
        'Servico' => array(
            'foreignKey' => 'pessoa_nis',
            'associationForeignKey' => 'servico_id',
        ),
    );
    var $belongsTo = array(
        'Domicilio' => array(
            'foreignKey' => 'codigo_domiciliar',
        ),
        'Responsavel' => array(
            'className' => 'Pessoa',
            'foreignKey' => 'responsavel_nis'
        ),
    );
    var $hasMany = array(
        'Membro' => array(
            'className' => 'Pessoa',
            'foreignKey' => 'responsavel_nis'
        )
    );
    var $validate = array(
        'nis' => array(
            'rule' => 'isUnique'
        )
    );

    public function __construct($id=false, $table=null, $ds=null) {
        parent::__construct($id, $table, $ds);

        $sql_meses = "(MONTH(CURDATE()) - MONTH(`{$this->alias}`.`data_nascimento`))";
        $sql_meses .= "+ IF(((MONTH(CURDATE()) <= MONTH(`{$this->alias}`.`data_nascimento`)) AND (DAY(CURDATE()) <  DAY(`{$this->alias}`.`data_nascimento`))),11,0)";
        $sql_meses .= "+ IF(((MONTH(CURDATE()) <  MONTH(`{$this->alias}`.`data_nascimento`)) AND (DAY(CURDATE()) >= DAY(`{$this->alias}`.`data_nascimento`))),12,0)";
        $sql_meses .= "+ IF(((MONTH(CURDATE()) >  MONTH(`{$this->alias}`.`data_nascimento`)) AND (DAY(CURDATE()) <  DAY(`{$this->alias}`.`data_nascimento`))),-1,0)";

        $this->virtualFields = array(
            'idade' => "(YEAR(CURDATE())-YEAR(`{$this->alias}`.`data_nascimento`))-(RIGHT(CURDATE(),5)<RIGHT(`{$this->alias}`.`data_nascimento`,5))",
            'meses' => $sql_meses
        );
    }

    //////////////////////////// COMBOS BOXES

    /*
     * static enum: Model::function()
     * @access static
     */

    static function genero($value = null) { // 203
        $options = array(
            self::GENERO_NAO_INFORMADO => __('Não Informado', true),
            self::GENERO_MASCULINO => __('Masculino', true),
            self::GENERO_FEMININO => __('Feminino', true),
        );
        return parent::enum($value, $options);
    }

    const GENERO_NAO_INFORMADO = '';
    const GENERO_MASCULINO = '1';
    const GENERO_FEMININO = '2';

    static function estadoCivil($value = null) { // 212
        $options = array(
            self::ESTADO_CIVIL_NAO_INFORMADO => __('Não Informado', true),
            self::ESTADO_CIVIL_SOLTEIRO => __('Solteiro(a)', true),
            self::ESTADO_CIVIL_CASADO => __('Casado(a)', true),
            self::ESTADO_CIVIL_SEPARADO => __('Separado(a)', true),
            self::ESTADO_CIVIL_DIVORCIADO => __('Divorciado(a)', true),
            self::ESTADO_CIVIL_VIUVO => __('Viúvo(a)', true),
        );
        return parent::enum($value, $options);
    }

    const ESTADO_CIVIL_NAO_INFORMADO = 0;
    const ESTADO_CIVIL_SOLTEIRO = 1;
    const ESTADO_CIVIL_CASADO = 2;
    const ESTADO_CIVIL_DIVORCIADO = 3;
    const ESTADO_CIVIL_SEPARADO = 4;
    const ESTADO_CIVIL_VIUVO = 5;

    static function grauParentesco($value = null) { // 212
        $options = array(
            self::PARENTESCO_MAE => __('Mãe/responsável legal', true),
            self::PARENTESCO_ESPOSO => __('Esposo(a)', true),
            self::PARENTESCO_COMPANHEIRO => __('Companheiro(a)', true),
            self::PARENTESCO_FILHO => __('Filho(a)', true),
            self::PARENTESCO_PAI => __('Pai', true),
            self::PARENTESCO_AVO => __('Avô/Avó', true),
            self::PARENTESCO_IRMAO => __('Irmão/Irmã', true),
            self::PARENTESCO_CUNHADO => __('Cunhado(a)', true),
            self::PARENTESCO_GENRO => __('Genro/Nora', true),
            self::PARENTESCO_SOBRINHO => __('Sobrinho(a)', true),
            self::PARENTESCO_PRIMO => __('Primo(a)', true),
            self::PARENTESCO_SOGRO => __('Sogro(a)', true),
            self::PARENTESCO_NETO => __('Neto(a)', true),
            self::PARENTESCO_TIO => __('Tio(a)', true),
            self::PARENTESCO_ADOTIVO => __('Adotivo(a)', true),
            self::PARENTESCO_PADRASTO => __('Padrasto/Madrasta', true),
            self::PARENTESCO_ENTEADO => __('Enteado(a)', true),
            self::PARENTESCO_BISNETO => __('Bisneto(a)', true),
            self::PARENTESCO_SEM_PARENTESCO => __('Sem parentesco', true),
            self::PARENTESCO_OUTRO => __('Outro', true),
        );
        return parent::enum($value, $options);
    }

    const PARENTESCO_MAE = 1;
    const PARENTESCO_ESPOSO = 2;
    const PARENTESCO_COMPANHEIRO = 3;
    const PARENTESCO_FILHO = 4;
    const PARENTESCO_PAI = 5;
    const PARENTESCO_AVO = 6;
    const PARENTESCO_IRMAO = 7;
    const PARENTESCO_CUNHADO = 8;
    const PARENTESCO_GENRO = 9;
    const PARENTESCO_SOBRINHO = 10;
    const PARENTESCO_PRIMO = 11;
    const PARENTESCO_SOGRO = 12;
    const PARENTESCO_NETO = 13;
    const PARENTESCO_TIO = 14;
    const PARENTESCO_ADOTIVO = 15;
    const PARENTESCO_PADRASTO = 16;
    const PARENTESCO_ENTEADO = 17;
    const PARENTESCO_BISNETO = 18;
    const PARENTESCO_SEM_PARENTESCO = 19;
    const PARENTESCO_OUTRO = 20;

    static function serieEscolar($value = null) { // 239
        $options = array(
            self::SERIE_NAO_INFORMADO => __('Não Informado', true),
            self::SERIE_CA_ALFABETIZACAO => __('CA (Alfabetização)', true),
            self::SERIE_MATERNAL_I => __('Maternal I', true),
            self::SERIE_MATERNAL_II => __('Maternal II', true),
            self::SERIE_MATERNAL_III => __('Maternal III', true),
            self::SERIE_JARDIM_I => __('Jardim I', true),
            self::SERIE_JARDIM_II => __('Jardim II', true),
            self::SERIE_JARDIM_III => __('Jardim III', true),
            self::SERIE_1_ENSINO_FUNDAMENTAL => __('1º série do ensino fundamental', true),
            self::SERIE_2_ENSINO_FUNDAMENTAL => __('2º série do ensino fundamental', true),
            self::SERIE_3_ENSINO_FUNDAMENTAL => __('3º série do ensino fundamental', true),
            self::SERIE_4_ENSINO_FUNDAMENTAL => __('4º série do ensino fundamental', true),
            self::SERIE_5_ENSINO_FUNDAMENTAL => __('5º série do ensino fundamental', true),
            self::SERIE_6_ENSINO_FUNDAMENTAL => __('6º série do ensino fundamental', true),
            self::SERIE_7_ENSINO_FUNDAMENTAL => __('7º série do ensino fundamental', true),
            self::SERIE_8_ENSINO_FUNDAMENTAL => __('8º série do ensino fundamental', true),
            self::SERIE_1_ENSINO_MEDIO => __('1º série do ensino médio', true),
            self::SERIE_2_ENSINO_MEDIO => __('2º série do ensino médio', true),
            self::SERIE_3_ENSINO_MEDIO => __('3º série do ensino médio', true),
        );
        return parent::enum($value, $options);
    }

    const SERIE_NAO_INFORMADO = 0;
    const SERIE_MATERNAL_I = 1;
    const SERIE_MATERNAL_II = 2;
    const SERIE_MATERNAL_III = 3;
    const SERIE_JARDIM_I = 4;
    const SERIE_JARDIM_II = 5;
    const SERIE_JARDIM_III = 6;
    const SERIE_CA_ALFABETIZACAO = 7;
    const SERIE_1_ENSINO_FUNDAMENTAL = 8; //6 anos
    const SERIE_2_ENSINO_FUNDAMENTAL = 9; //7 anos
    const SERIE_3_ENSINO_FUNDAMENTAL = 10; //8 anos
    const SERIE_4_ENSINO_FUNDAMENTAL = 11; //9 anos
    const SERIE_5_ENSINO_FUNDAMENTAL = 12; //10 anos
    const SERIE_6_ENSINO_FUNDAMENTAL = 13; //11 anos
    const SERIE_7_ENSINO_FUNDAMENTAL = 14; //12 anos
    const SERIE_8_ENSINO_FUNDAMENTAL = 15; //13 anos
    const SERIE_1_ENSINO_MEDIO = 16; //14 anos
    const SERIE_2_ENSINO_MEDIO = 17;
    const SERIE_3_ENSINO_MEDIO = 18;

    static function tipoTrabalho($value = null) { // 242
        $options = array(
            self::TRABALHO_NAO_INFORMADO => __('Não Informado', true),
            self::TRABALHO_ASSALARIADO_COM_CARTEIRA => __('Assalariado com carteira de trabalho', true),
            self::TRABALHO_ASSALARIADO_SEM_CARTEIRA => __('Assalariado sem carteira de trabalho', true),
            self::TRABALHO_AUTONOMO_COM_PREVIDENCIA => __('Autônomo com previdência social', true),
            self::TRABALHO_AUTONOMO_SEM_PREVIDENCIA => __('Autônomo sem previdência social', true),
            self::TRABALHO_APOSENTADO_PENSIONISTA => __('Aposentado/Pensionista', true),
            self::TRABALHO_EMPREGADOR => __('Empregador', true),
            self::TRABALHO_EMPREGADOR_RURAL => __('Empregador rural', true),
            self::TRABALHO_TRABALHADOR_RURAL => __('Trabalhador rural', true),
            self::TRABALHO_NAO_TRABALHA => __('Não trabalha', true),
            self::TRABALHO_OUTRA => __('Outra', true),
        );
        return parent::enum($value, $options);
    }

    const TRABALHO_NAO_INFORMADO = 0;
    const TRABALHO_EMPREGADOR = 1;
    const TRABALHO_ASSALARIADO_COM_CARTEIRA = 2;
    const TRABALHO_ASSALARIADO_SEM_CARTEIRA = 3;
    const TRABALHO_AUTONOMO_COM_PREVIDENCIA = 4;
    const TRABALHO_AUTONOMO_SEM_PREVIDENCIA = 5;
    const TRABALHO_APOSENTADO_PENSIONISTA = 6;
    const TRABALHO_TRABALHADOR_RURAL = 7;
    const TRABALHO_EMPREGADOR_RURAL = 8;
    const TRABALHO_NAO_TRABALHA = 9;
    const TRABALHO_OUTRA = 10;

    static function cor($value = null) { //215
        $options = array(
            self::COR_NAO_INFORMADO => __('Não Informado', true),
            self::COR_NEGRA => __('Negra', true),
            self::COR_BRANCA => __('Branca', true),
            self::COR_PARDA => __('Parda', true),
            self::COR_AMARELA => __('Amarela', true),
            self::COR_INDIGENA => __('Indígena', true),
        );
        return parent::enum($value, $options);
    }

    const COR_NAO_INFORMADO = 0;
    const COR_BRANCA = 1;
    const COR_NEGRA = 2;
    const COR_PARDA = 3;
    const COR_AMARELA = 4;
    const COR_INDIGENA = 5;

    static function grauInstrucao($value = null) { // 238
        $options = array(
            self::ESCOLARIDADE_NAO_INFORMADO => __('Não Informado', true),
            self::ESCOLARIDADE_ANALFABETO => __('Analfabeto', true), // ANALFABETO TOTAL
            self::ESCOLARIDADE_ATE_4A_INCOMPLETA => __('Até 4º série incompleta do ensino fundamental', true), // ANALFABETO FUNCIONAL
            self::ESCOLARIDADE_4A_COMPLETA => __('Com 4º série completa do ensino fundamental', true), // NÃO ANALFABETO
            self::ESCOLARIDADE_ATE_8A_INCOMPLETA => __('De 5ª a 8ª Série incompleta do ensino fundamental', true),
            self::ESCOLARIDADE_FUNDAMENTAL_COMPLETO => __('Ensino fundamental completo', true),
            self::ESCOLARIDADE_MEDIO_INCOMPLETO => __('Ensino médio incompleto', true),
            self::ESCOLARIDADE_MEDIO_COMPLETO => __('Ensino médio completo', true),
            self::ESCOLARIDADE_ESPECIALIZACAO => __('Especialização', true),
            self::ESCOLARIDADE_SUPERIOR_INCOMPLETO => __('Superior incompleto', true),
            self::ESCOLARIDADE_SUPERIOR_COMPLETO => __('Superior completo', true),
            self::ESCOLARIDADE_MESTRADO => __('Mestrado', true),
            self::ESCOLARIDADE_DOUTORADO => __('Doutorado', true),
        );
        return parent::enum($value, $options);
    }

    const ESCOLARIDADE_NAO_INFORMADO = 0;
    const ESCOLARIDADE_ANALFABETO = 1;
    const ESCOLARIDADE_ATE_4A_INCOMPLETA = 2;
    const ESCOLARIDADE_4A_COMPLETA = 3;
    const ESCOLARIDADE_ATE_8A_INCOMPLETA = 4;
    const ESCOLARIDADE_FUNDAMENTAL_COMPLETO = 5;
    const ESCOLARIDADE_MEDIO_INCOMPLETO = 6;
    const ESCOLARIDADE_MEDIO_COMPLETO = 7;
    const ESCOLARIDADE_SUPERIOR_INCOMPLETO = 8;
    const ESCOLARIDADE_SUPERIOR_COMPLETO = 9;
    const ESCOLARIDADE_ESPECIALIZACAO = 10;
    const ESCOLARIDADE_MESTRADO = 11;
    const ESCOLARIDADE_DOUTORADO = 12;

    static function tipoEscola($value = null) { // 237
        $options = array(
            self::ESCOLA_NAO_INFORMADO => __('Não Informado', true),
            self::ESCOLA_NAO_FREQUENTA => __('Não frequenta', true),
            self::ESCOLA_PUBLICA_MUNICIPAL => __('Pública Municipal', true),
            self::ESCOLA_PUBLICA_ESTADUAL => __('Pública estadual', true),
            self::ESCOLA_PUBLICA_FEDERAL => __('Pública federal', true),
            self::ESCOLA_PARTICULAR => __('Particular', true),
            self::ESCOLA_OUTRA => __('Outra', true),
        );
        return parent::enum($value, $options);
    }

    const ESCOLA_NAO_INFORMADO = 0;
    const ESCOLA_PUBLICA_MUNICIPAL = 1;
    const ESCOLA_PUBLICA_ESTADUAL = 2;
    const ESCOLA_PUBLICA_FEDERAL = 3;
    const ESCOLA_PARTICULAR = 4;
    const ESCOLA_OUTRA = 5;
    const ESCOLA_NAO_FREQUENTA = 6;

    static function faixaEtaria($value = null) {
        $options = array(
            self::IDADE_CRIANCA => __('Criança', true),
            self::IDADE_ADOLESCENTE => __('Adolescente', true),
            self::IDADE_JOVEM => __('Jovem', true),
            self::IDADE_ADULTO => __('Adulto', true),
            self::IDADE_IDOSO => __('Idoso', true),
        );
        return parent::enum($value, $options);
    }

    const IDADE_CRIANCA = 0;
    const IDADE_ADOLESCENTE = 10;
    const IDADE_JOVEM = 15;
    const IDADE_ADULTO = 18;
    const IDADE_IDOSO = 60;
}