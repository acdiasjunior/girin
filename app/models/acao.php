<?php

class Acao extends AppModel {

    var $name = 'Acao';
    var $primaryKey = 'id_acao';
    var $displayField = 'desc_acao';
    var $useTable = 'acao';
    var $tablePrefix = 'tb_';
    var $order = array('Acao.cod_acao');
    var $sequence = 'seq_acao';
    var $belongsTo = array(
        'Estrategia' => array(
            'foreignKey' => 'id_estrategia'
        )
    );

    //////////////////////////// COMBOS BOXES

    /*
     * static enum: Model::function()
     * @access static
     */

    static function responsavel($value = null) {
        $options = array(
            self::RESPONSAVEL_AGENTE_LOCAL_DA_FAMILIA => __('Agente Local da Família', true),
            self::RESPONSAVEL_EQUIPE_CRAS => __('Equipe CRAS', true),
            self::RESPONSAVEL_TECNICO_CRAS => __('Técnico CRAS', true),
        );
        return parent::enum($value, $options);
    }

    const RESPONSAVEL_AGENTE_LOCAL_DA_FAMILIA = 1;
    const RESPONSAVEL_EQUIPE_CRAS = 2;
    const RESPONSAVEL_TECNICO_CRAS = 3;

    static function atividade($value = null) {
        $options = array(
            self::ATIVIDADE_AGENDA_CASA => __('Agenda em Casa', true),
            self::ATIVIDADE_ACOMPANHAMENTO_REDE => __('Acompanhamento Rede', true),
            self::ATIVIDADE_ACOMPANHAMENTO_SOCIOFAMILIAR => __('Acompamhamento Sociofamiliar', true),
            self::ATIVIDADE_ARTICULACAO_COM_A_REDE => __('Articulação com a rede', true),
            self::ATIVIDADE_ATENDIMENTO_INDIVIDUAL => __('Atendimento Individual', true),
            self::ATIVIDADE_BUSCA_ATIVA => __('Busca Ativa', true),
            self::ATIVIDADE_CADASTRAMENTO => __('Cadastramento', true),
            self::ATIVIDADE_CADASTRAMENTO_NO_SISTEMA => __('Cadastramento no Sistema', true),
            self::ATIVIDADE_ENCAMINHAMENTO_REDE => __('Encaminhamento Rede', true),
            self::ATIVIDADE_GRUPO_SOCIOEDUCATIVO => __('Grupo socioeducativo', true),
            self::ATIVIDADE_LEVANTAMENTO_SISTEMA => __('Levantamento no Sistema', true),
            self::ATIVIDADE_VISITA_DOMICILIAR => __('Visita Domiciliar', true),
        );
        return parent::enum($value, $options);
    }

    const ATIVIDADE_AGENDA_CASA = 1;
    const ATIVIDADE_ACOMPANHAMENTO_REDE = 2;
    const ATIVIDADE_ACOMPANHAMENTO_SOCIOFAMILIAR = 3;
    const ATIVIDADE_ARTICULACAO_COM_A_REDE = 4;
    const ATIVIDADE_ATENDIMENTO_INDIVIDUAL = 5;
    const ATIVIDADE_BUSCA_ATIVA = 6;
    const ATIVIDADE_CADASTRAMENTO = 7;
    const ATIVIDADE_CADASTRAMENTO_NO_SISTEMA = 8;
    const ATIVIDADE_ENCAMINHAMENTO_REDE = 9;
    const ATIVIDADE_GRUPO_SOCIOEDUCATIVO = 10;
    const ATIVIDADE_LEVANTAMENTO_SISTEMA = 11;
    const ATIVIDADE_VISITA_DOMICILIAR = 12;

    static function usuarios($value = null) {
        $options = array(
            self::USUARIOS_ADOLESCENTES => __('Adolescente(s)', true),
            self::USUARIOS_ADULTOS => __('Adulto(s) ', true),
            self::USUARIOS_CRIANCAS => __('Criança(s)', true),
            self::USUARIOS_CRIANCAS_OU_ADOLESCENTES => __('Criança(s) e/ou Adolescente(s)', true),
            self::USUARIOS_FAMILIAS => __('Família(s)', true),
            self::USUARIOS_MULHER => __('Mulher', true),
            self::USUARIOS_MULHER_GESTANTE => __('Mulher gestante / lactante', true),
            self::USUARIOS_ADULTO_FUNDAMENTAL => __('Adulto(s) com Ensino Fundamental completo.', true),
            self::USUARIOS_ADULTO_MEDIO_INCOMPLETO => __('Adulto(s) com Ensino Fundamental e Médio incompletos', true),
            self::USUARIOS_ADULTO_MEDIO_COMPLETO => __('Adulto(s) com Ensino Médio completo ou em curso.', true),
            self::USUARIOS_PESSOA_ABUSO_ALCOOL => __('Pessoa em situação de abuso de álcool, crack e outras drogas', true),
            self::USUARIOS_PESSOA_MEDIDA_SOCIOEDUCATIVA => __('Pessoa em situação de cumprimento de medida socioeducativa, privação de liberdade ou de direitos', true),
            self::USUARIOS_PESSOA_VIOLACAO_DIREITOS => __('Pessoa em situação de violação de direitos e familia', true),
            self::USUARIOS_ADULTO_ANALFABETO => __('Adulto(s) analfabeto(s)', true),
            self::USUARIOS_DEFICIENTE_IDOSO => __('Pessoas com deficiência e idosos', true),
        );
        return parent::enum($value, $options);
    }

    const USUARIOS_ADOLESCENTES = 1;
    const USUARIOS_ADULTOS = 2;
    const USUARIOS_CRIANCAS = 3;
    const USUARIOS_CRIANCAS_OU_ADOLESCENTES = 4;
    const USUARIOS_FAMILIAS = 5;
    const USUARIOS_MULHER = 6;
    const USUARIOS_MULHER_GESTANTE = 7;
    const USUARIOS_ADULTO_FUNDAMENTAL = 8;
    const USUARIOS_ADULTO_MEDIO_INCOMPLETO = 9;
    const USUARIOS_ADULTO_MEDIO_COMPLETO = 10;
    const USUARIOS_PESSOA_ABUSO_ALCOOL = 11;
    const USUARIOS_PESSOA_MEDIDA_SOCIOEDUCATIVA = 12;
    const USUARIOS_PESSOA_VIOLACAO_DIREITOS = 13;
    const USUARIOS_ADULTO_ANALFABETO = 14;
    const USUARIOS_DEFICIENTE_IDOSO = 15;

    static function rede($value = null) {
        $options = array(
            self::REDE_PROTECAO_ATENDIMENTO => __('Rede de Atendimento', true),
            self::REDE_PROTECAO_ABUSO_DROGAS => __('Proteção ao abuso de drogas', true),
            self::REDE_PROTECAO_CRIANCA_ADOLESCENTE => __('Proteção à Criança e Adolescente', true),
            self::REDE_PROTECAO_DEFICIENCIA => __('Proteção às pessoas com deficiência', true),
            self::REDE_PROTECAO_IDOSOS => __('Proteção às pessoas idosas', true),
            self::REDE_PROTECAO_JURIDICA => __('Proteção Juridica', true),
            self::REDE_PROTECAO_SOCIOASSISTENCIAL => __('Proteção Socioassistencial', true),
            self::REDE_PROTECAO_SOCIOHABITACIONAL => __('Proteção Sociohabitacional', true),
            self::REDE_PROTECAO_TRABALHO => __('Proteção trabalho, emprego e renda', true),
        );
        return parent::enum($value, $options);
    }

    const REDE_PROTECAO_ATENDIMENTO = 1;
    const REDE_PROTECAO_ABUSO_DROGAS = 2;
    const REDE_PROTECAO_CRIANCA_ADOLESCENTE = 3;
    const REDE_PROTECAO_DEFICIENCIA = 4;
    const REDE_PROTECAO_IDOSOS = 5;
    const REDE_PROTECAO_JURIDICA = 6;
    const REDE_PROTECAO_SOCIOASSISTENCIAL = 7;
    const REDE_PROTECAO_SOCIOHABITACIONAL = 8;
    const REDE_PROTECAO_TRABALHO = 9;

    static function pontoSocioassistencial($value = null) {
        $options = array(
            self::PONTO_SOCIO_CRAS => __('CRAS', true),
            self::PONTO_SOCIO_CREAS => __('CREAS', true),
            self::PONTO_SOCIO_PSE => __('PSE', true),
            self::PONTO_SOCIO_CONVIVENCIA => __('Serviço de Convivência', true),
            self::PONTO_SOCIO_SOCIOASSISTENCIAL => __('Serviço Socioassistencial', true),
            self::PONTO_SOCIO_SOCIOEDUCATIVO => __('Serviço Socioeducativo', true),
        );
        return parent::enum($value, $options);
    }

    const PONTO_SOCIO_CRAS = 1;
    const PONTO_SOCIO_CREAS = 2;
    const PONTO_SOCIO_PSE = 3;
    const PONTO_SOCIO_CONVIVENCIA = 4;
    const PONTO_SOCIO_SOCIOASSISTENCIAL = 5;
    const PONTO_SOCIO_SOCIOEDUCATIVO = 6;

    static function sistemaSetorialApoio($value = null) {
        $options = array(
            self::SISTEMA_SETORIAL_NAO_APLICAVEL => __('N/A', true),
            self::SISTEMA_SETORIAL_SERVICO_CONVIVENCIA => __('Serviço Convivência', true),
            self::SISTEMA_SETORIAL_SISTEMA_QUALIFICACAO => __('Sistema de Qualificação Profissional', true),
            self::SISTEMA_SETORIAL_SISTEMA_EDUCACIONAL => __('Sistema Educacional', true),
            self::SISTEMA_SETORIAL_SISTEMA_HABITACIONAL => __('Sistema Habitacional e Urbano', true),
            self::SISTEMA_SETORIAL_SISTEMA_JUDICIARIO => __('Sistema Judiciário', true),
            self::SISTEMA_SETORIAL_UNIDADE_SAUDE => __('Sistema Saúde', true),
        );
        return parent::enum($value, $options);
    }

    const SISTEMA_SETORIAL_NAO_APLICAVEL = 0;
    const SISTEMA_SETORIAL_SERVICO_CONVIVENCIA = 1;
    const SISTEMA_SETORIAL_SISTEMA_QUALIFICACAO = 2;
    const SISTEMA_SETORIAL_SISTEMA_EDUCACIONAL = 3;
    const SISTEMA_SETORIAL_SISTEMA_HABITACIONAL = 4;
    const SISTEMA_SETORIAL_SISTEMA_JUDICIARIO = 5;
    const SISTEMA_SETORIAL_UNIDADE_SAUDE = 6;

    static function sistemaLogistico($value = null) {
        $options = array(
            self::SISTEMA_LOGISTICO_NAO_APLICAVEL => __('N/A', true),
            self::SISTEMA_LOGISTICO_CADUNICO => __('CadÚnico', true),
            self::SISTEMA_LOGISTICO_PROGRAMACAO_LOCAL => __('Programação Local', true),
            self::SISTEMA_LOGISTICO_VEICULO => __('Veículo', true),
        );
        return parent::enum($value, $options);
    }

    const SISTEMA_LOGISTICO_NAO_APLICAVEL = 0;
    const SISTEMA_LOGISTICO_CADUNICO = 1;
    const SISTEMA_LOGISTICO_PROGRAMACAO_LOCAL = 2;
    const SISTEMA_LOGISTICO_VEICULO = 3;

}