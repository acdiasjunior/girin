--
-- PostgreSQL database dump
--

-- Started on 2012-10-03 02:16:30

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 372 (class 2612 OID 16386)
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: postgres
--

CREATE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO postgres;

SET search_path = public, pg_catalog;

--
-- TOC entry 1582 (class 1259 OID 17412)
-- Dependencies: 6
-- Name: seq_acao; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_acao
    START WITH 189
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_acao OWNER TO programacaolocal;

--
-- TOC entry 1583 (class 1259 OID 17414)
-- Dependencies: 6
-- Name: seq_acesso; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_acesso
    START WITH 264
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_acesso OWNER TO programacaolocal;

--
-- TOC entry 1584 (class 1259 OID 17416)
-- Dependencies: 6
-- Name: seq_bairro; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_bairro
    START WITH 195
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_bairro OWNER TO programacaolocal;

--
-- TOC entry 1585 (class 1259 OID 17418)
-- Dependencies: 6
-- Name: seq_cras; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_cras
    START WITH 12
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_cras OWNER TO programacaolocal;

--
-- TOC entry 1586 (class 1259 OID 17420)
-- Dependencies: 6
-- Name: seq_cras_usuario; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_cras_usuario
    START WITH 44
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_cras_usuario OWNER TO programacaolocal;

--
-- TOC entry 1587 (class 1259 OID 17422)
-- Dependencies: 6
-- Name: seq_dimensao; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_dimensao
    START WITH 7
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_dimensao OWNER TO programacaolocal;

--
-- TOC entry 1559 (class 1259 OID 17276)
-- Dependencies: 6
-- Name: seq_estrategia; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_estrategia
    START WITH 20
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_estrategia OWNER TO programacaolocal;

--
-- TOC entry 1561 (class 1259 OID 17285)
-- Dependencies: 6
-- Name: seq_estrategia_indicador; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_estrategia_indicador
    START WITH 103
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_estrategia_indicador OWNER TO programacaolocal;

--
-- TOC entry 1563 (class 1259 OID 17293)
-- Dependencies: 6
-- Name: seq_estrategia_prontuario; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_estrategia_prontuario
    START WITH 109
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_estrategia_prontuario OWNER TO programacaolocal;

--
-- TOC entry 1565 (class 1259 OID 17301)
-- Dependencies: 6
-- Name: seq_faixa_etaria; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_faixa_etaria
    START WITH 82
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_faixa_etaria OWNER TO programacaolocal;

--
-- TOC entry 1588 (class 1259 OID 17424)
-- Dependencies: 6
-- Name: seq_grupo; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_grupo
    START WITH 2
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_grupo OWNER TO programacaolocal;

--
-- TOC entry 1566 (class 1259 OID 17307)
-- Dependencies: 6
-- Name: seq_indicador; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_indicador
    START WITH 45
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_indicador OWNER TO programacaolocal;

--
-- TOC entry 1568 (class 1259 OID 17317)
-- Dependencies: 6
-- Name: seq_indicador_prontuario; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_indicador_prontuario
    START WITH 340
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_indicador_prontuario OWNER TO programacaolocal;

--
-- TOC entry 1571 (class 1259 OID 17328)
-- Dependencies: 6
-- Name: seq_indice_historico; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_indice_historico
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_indice_historico OWNER TO programacaolocal;

--
-- TOC entry 1572 (class 1259 OID 17334)
-- Dependencies: 6
-- Name: seq_pagina; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_pagina
    START WITH 3
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_pagina OWNER TO programacaolocal;

--
-- TOC entry 1574 (class 1259 OID 17350)
-- Dependencies: 6
-- Name: seq_parametro_usuario; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_parametro_usuario
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_parametro_usuario OWNER TO programacaolocal;

--
-- TOC entry 1589 (class 1259 OID 17426)
-- Dependencies: 6
-- Name: seq_permissao; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_permissao
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_permissao OWNER TO programacaolocal;

--
-- TOC entry 1576 (class 1259 OID 17393)
-- Dependencies: 6
-- Name: seq_pessoa_servico; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_pessoa_servico
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_pessoa_servico OWNER TO programacaolocal;

--
-- TOC entry 1578 (class 1259 OID 17399)
-- Dependencies: 6
-- Name: seq_prontuario; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_prontuario
    START WITH 23
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_prontuario OWNER TO programacaolocal;

--
-- TOC entry 1580 (class 1259 OID 17406)
-- Dependencies: 6
-- Name: seq_regiao; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_regiao
    START WITH 9
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_regiao OWNER TO programacaolocal;

--
-- TOC entry 1590 (class 1259 OID 17428)
-- Dependencies: 6
-- Name: seq_servico; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_servico
    START WITH 19
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_servico OWNER TO programacaolocal;

--
-- TOC entry 1591 (class 1259 OID 17430)
-- Dependencies: 6
-- Name: seq_usuario; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_usuario
    START WITH 18
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_usuario OWNER TO programacaolocal;

--
-- TOC entry 1592 (class 1259 OID 17432)
-- Dependencies: 6
-- Name: seq_visita; Type: SEQUENCE; Schema: public; Owner: programacaolocal
--

CREATE SEQUENCE seq_visita
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_visita OWNER TO programacaolocal;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1594 (class 1259 OID 17442)
-- Dependencies: 1933 1934 1935 1936 1937 1938 6
-- Name: tb_acao; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_acao (
    id_acao integer DEFAULT nextval('seq_acao'::regclass) NOT NULL,
    id_estrategia integer NOT NULL,
    cod_acao character varying(10) NOT NULL,
    desc_acao character varying(2048) NOT NULL,
    cod_responsavel smallint,
    cod_usuario smallint,
    cod_atividade smallint,
    cod_rede smallint,
    cod_ponto_socioassistencial smallint,
    cod_sistema_setorial_apoio smallint,
    cod_sistema_logistico smallint,
    qtd_prazo_minimo integer,
    qtd_prazo_maximo integer,
    desc_encaminhamento character varying(1024) DEFAULT NULL::character varying,
    desc_pactuacao_familia character varying(255) DEFAULT NULL::character varying,
    desc_observacao character varying(1024) DEFAULT NULL::character varying,
    CONSTRAINT acoes_prazo_maximo_check CHECK ((qtd_prazo_maximo >= 0)),
    CONSTRAINT acoes_prazo_minimo_check CHECK ((qtd_prazo_minimo >= 0))
);


ALTER TABLE public.tb_acao OWNER TO programacaolocal;

--
-- TOC entry 1595 (class 1259 OID 17454)
-- Dependencies: 1939 1940 6
-- Name: tb_acesso; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_acesso (
    id_acesso integer DEFAULT nextval('seq_acesso'::regclass) NOT NULL,
    id_usuario integer NOT NULL,
    cod_ip character varying(15) DEFAULT NULL::character varying,
    dt_login timestamp without time zone
);


ALTER TABLE public.tb_acesso OWNER TO programacaolocal;

--
-- TOC entry 1596 (class 1259 OID 17459)
-- Dependencies: 1941 6
-- Name: tb_bairro; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_bairro (
    id_bairro integer DEFAULT nextval('seq_bairro'::regclass) NOT NULL,
    id_regiao integer,
    id_cras integer,
    nome_bairro character varying(50) NOT NULL
);


ALTER TABLE public.tb_bairro OWNER TO programacaolocal;

--
-- TOC entry 1597 (class 1259 OID 17463)
-- Dependencies: 1942 1943 1944 1945 1946 1947 1948 1949 6
-- Name: tb_cras; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_cras (
    id_cras integer DEFAULT nextval('seq_cras'::regclass) NOT NULL,
    desc_cras character varying(80) NOT NULL,
    end_tipo character varying(20) DEFAULT NULL::character varying,
    end_logradouro character varying(80) DEFAULT NULL::character varying,
    end_num character varying(10) DEFAULT NULL::character varying,
    end_compl character varying(30) DEFAULT NULL::character varying,
    id_bairro integer,
    id_regiao integer,
    end_cidade character varying(80) DEFAULT NULL::character varying,
    end_estado character varying(2) DEFAULT NULL::character varying,
    tel_num character varying(14) DEFAULT NULL::character varying
);


ALTER TABLE public.tb_cras OWNER TO programacaolocal;

--
-- TOC entry 1598 (class 1259 OID 17474)
-- Dependencies: 1950 6
-- Name: tb_cras_usuario; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_cras_usuario (
    id_cras_usuario integer DEFAULT nextval('seq_cras_usuario'::regclass) NOT NULL,
    id_cras integer NOT NULL,
    id_usuario integer NOT NULL
);


ALTER TABLE public.tb_cras_usuario OWNER TO programacaolocal;

--
-- TOC entry 1599 (class 1259 OID 17478)
-- Dependencies: 1951 6
-- Name: tb_dimensao_idf; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_dimensao_idf (
    id_dimensao_idf integer DEFAULT nextval('seq_dimensao'::regclass) NOT NULL,
    desc_dimensao_idf character varying(50) NOT NULL,
    desc_coluna_idf character varying(20) NOT NULL
);


ALTER TABLE public.tb_dimensao_idf OWNER TO programacaolocal;

--
-- TOC entry 1600 (class 1259 OID 17482)
-- Dependencies: 1952 1953 1954 1955 1956 1957 1958 1959 1960 1961 1962 1963 1964 1965 1966 1967 1968 1969 1970 1971 1972 1973 1974 1975 1976 1977 1978 1979 1980 1981 1982 1983 1984 1985 6
-- Name: tb_domicilio; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_domicilio (
    cod_domiciliar character varying(12) NOT NULL,
    cod_nis_responsavel character varying(15) DEFAULT NULL::character varying,
    end_cep character varying(10) DEFAULT NULL::character varying,
    end_tipo character varying(20) DEFAULT NULL::character varying,
    end_logradouro character varying(80) DEFAULT NULL::character varying,
    end_num character varying(10) DEFAULT NULL::character varying,
    end_compl character varying(30) DEFAULT NULL::character varying,
    id_bairro integer,
    nome_bairro character varying(60) DEFAULT NULL::character varying,
    id_cras integer,
    id_regiao integer,
    end_cidade character varying(80) DEFAULT NULL::character varying,
    end_estado character varying(2) DEFAULT NULL::character varying,
    tel_ddd character varying(3) DEFAULT NULL::character varying,
    tel_num character varying(10) DEFAULT NULL::character varying,
    tp_localidade smallint,
    tp_situacao_domicilio smallint,
    tp_domicilio smallint,
    tp_construcao smallint,
    tp_abastecimento smallint,
    tp_tratamento_agua smallint,
    tp_iluminacao smallint,
    tp_escoamento_sanitario smallint,
    tp_destino_lixo smallint,
    st_bolsa_familia smallint,
    qtd_comodo integer,
    vlr_despesa_aluguel numeric(10,2) DEFAULT NULL::numeric,
    vlr_despesa_prestacao numeric(10,2) DEFAULT NULL::numeric,
    vlr_despesa_alimentacao numeric(10,2) DEFAULT NULL::numeric,
    vlr_despesa_agua numeric(10,2) DEFAULT NULL::numeric,
    vlr_despesa_luz numeric(10,2) DEFAULT NULL::numeric,
    vlr_despesa_transporte numeric(10,2) DEFAULT NULL::numeric,
    vlr_despesa_medicamento numeric(10,2) DEFAULT NULL::numeric,
    vlr_despesa_gas numeric(10,2) DEFAULT NULL::numeric,
    vlr_outras_despesas numeric(10,2) DEFAULT NULL::numeric,
    vlr_idf numeric(3,2),
    dt_pesquisa date,
    dt_inclusao date,
    dt_atualizacao date,
    nome_entrevistador character varying(60) DEFAULT NULL::character varying,
    qtd_pessoa integer,
    vlr_despesa_familia numeric(10,2) DEFAULT NULL::numeric,
    vlr_remuneracao numeric(10,2) DEFAULT NULL::numeric,
    vlr_aposentadoria_pensao numeric(10,2) DEFAULT NULL::numeric,
    vlr_seguro_desemprego numeric(10,2) DEFAULT NULL::numeric,
    vlr_pensao_alimenticia numeric(10,2) DEFAULT NULL::numeric,
    vlr_outras_rendas numeric(10,2) DEFAULT NULL::numeric,
    vlr_renda_familia numeric(10,2) DEFAULT NULL::numeric,
    vlr_beneficio numeric(10,2) DEFAULT NULL::numeric,
    CONSTRAINT domicilios_bairro_id_check CHECK ((id_bairro >= 0)),
    CONSTRAINT domicilios_cras_id_check CHECK ((id_cras >= 0)),
    CONSTRAINT domicilios_regiao_id_check CHECK ((id_regiao >= 0)),
    CONSTRAINT domicilios_situacao_domicilio_check CHECK ((tp_situacao_domicilio >= 0)),
    CONSTRAINT domicilios_tipo_localidade_check CHECK ((tp_localidade >= 0))
);


ALTER TABLE public.tb_domicilio OWNER TO programacaolocal;

--
-- TOC entry 1560 (class 1259 OID 17278)
-- Dependencies: 1880 6
-- Name: tb_estrategia; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_estrategia (
    id_estrategia integer DEFAULT nextval('seq_estrategia'::regclass) NOT NULL,
    cod_estrategia character varying(5) NOT NULL,
    desc_estrategia character varying(1024) NOT NULL,
    idade_minima integer,
    idade_maxima integer
);


ALTER TABLE public.tb_estrategia OWNER TO programacaolocal;

--
-- TOC entry 1562 (class 1259 OID 17287)
-- Dependencies: 1881 1882 1883 6
-- Name: tb_estrategia_indicador; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_estrategia_indicador (
    id_estrategia_indicador integer DEFAULT nextval('seq_estrategia_indicador'::regclass) NOT NULL,
    id_estrategia integer NOT NULL,
    id_indicador integer NOT NULL,
    CONSTRAINT estrategias_indicadores_estrategia_id_check CHECK ((id_estrategia >= 0)),
    CONSTRAINT estrategias_indicadores_indicador_id_check CHECK ((id_indicador >= 0))
);


ALTER TABLE public.tb_estrategia_indicador OWNER TO programacaolocal;

--
-- TOC entry 1564 (class 1259 OID 17295)
-- Dependencies: 1884 1885 1886 6
-- Name: tb_estrategia_plano_familiar; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_estrategia_plano_familiar (
    id_estrategia_prontuario integer DEFAULT nextval('seq_estrategia_prontuario'::regclass) NOT NULL,
    id_estrategia integer NOT NULL,
    id_plano_familiar integer NOT NULL,
    CONSTRAINT estrategias_prontuarios_estrategia_id_check CHECK ((id_estrategia >= 0)),
    CONSTRAINT estrategias_prontuarios_prontuario_id_check CHECK ((id_plano_familiar >= 0))
);


ALTER TABLE public.tb_estrategia_plano_familiar OWNER TO programacaolocal;

--
-- TOC entry 1567 (class 1259 OID 17309)
-- Dependencies: 1887 1888 6
-- Name: tb_indicador; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_indicador (
    id_indicador integer DEFAULT nextval('seq_indicador'::regclass) NOT NULL,
    id_dimensao_idf integer NOT NULL,
    cod_indicador character varying(5) NOT NULL,
    desc_indicador character varying(255) NOT NULL,
    desc_label_indicador character varying(255) NOT NULL,
    cod_coluna_indicador character varying(3) NOT NULL,
    CONSTRAINT indicadores_dimensao_id_check CHECK ((id_dimensao_idf >= 0))
);


ALTER TABLE public.tb_indicador OWNER TO programacaolocal;

--
-- TOC entry 1569 (class 1259 OID 17319)
-- Dependencies: 1889 1890 1891 6
-- Name: tb_indicador_plano_familiar; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_indicador_plano_familiar (
    id integer DEFAULT nextval('seq_indicador_prontuario'::regclass) NOT NULL,
    indicador_id integer NOT NULL,
    plano_familiar_id integer NOT NULL,
    CONSTRAINT indicadores_prontuarios_indicador_id_check CHECK ((indicador_id >= 0)),
    CONSTRAINT indicadores_prontuarios_prontuario_id_check CHECK ((plano_familiar_id >= 0))
);


ALTER TABLE public.tb_indicador_plano_familiar OWNER TO programacaolocal;

--
-- TOC entry 1570 (class 1259 OID 17325)
-- Dependencies: 6
-- Name: tb_indice; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_indice (
    cod_domiciliar character varying(12) NOT NULL,
    vlr_idf numeric(3,2),
    vlr_dimensao_vulnerabilidade double precision,
    vlr_componente_gestacao double precision,
    vlr_indicador_v1 smallint,
    vlr_indicador_v2 smallint,
    vlr_componente_crianca double precision,
    vlr_indicador_v3 smallint,
    vlr_indicador_v4 smallint,
    vlr_indicador_v5 smallint,
    vlr_componente_idoso double precision,
    vlr_indicador_v6 smallint,
    vlr_indicador_v7 smallint,
    vlr_componente_depedencia double precision,
    vlr_indicador_v8 smallint,
    vlr_indicador_v9 smallint,
    vlr_dimensao_conhecimento double precision,
    vlr_componente_analfabetismo double precision,
    vlr_indicador_c1 smallint,
    vlr_indicador_c2 smallint,
    vlr_componente_escolaridade double precision,
    vlr_indicador_c3 smallint,
    vlr_indicador_c4 smallint,
    vlr_indicador_c5 smallint,
    vlr_dimensao_trabalho double precision,
    vlr_componente_disponibilidade double precision,
    vlr_indicador_t1 smallint,
    vlr_componente_qualidade double precision,
    vlr_indicador_t2 smallint,
    vlr_indicador_t3 smallint,
    vlr_componente_remuneracao double precision,
    vlr_indicador_t4 smallint,
    vlr_indicador_t5 smallint,
    vlr_dimensao_recurso double precision,
    vlr_componente_extrema_pobreza double precision,
    vlr_indicador_r1 smallint,
    vlr_indicador_r2 smallint,
    vlr_indicador_r3 smallint,
    vlr_componente_pobreza double precision,
    vlr_indicador_r4 smallint,
    vlr_indicador_r5 smallint,
    vlr_componente_capacidade_geracao double precision,
    vlr_indicador_r6 smallint,
    vlr_dimensao_desenvolvimento double precision,
    vlr_componente_trabalho_precoce double precision,
    vlr_indicador_d1 smallint,
    vlr_indicador_d2 smallint,
    vlr_componente_acesso_escola double precision,
    vlr_indicador_d3 smallint,
    vlr_indicador_d4 smallint,
    vlr_indicador_d5 smallint,
    vlr_componente_progresso_escolar double precision,
    vlr_indicador_d6 smallint,
    vlr_indicador_d7 smallint,
    vlr_indicador_d8 smallint,
    vlr_dimensao_habitacao double precision,
    vlr_componente_propriedade double precision,
    vlr_indicador_h1 smallint,
    vlr_indicador_h2 smallint,
    vlr_componente_deficit double precision,
    vlr_indicador_h3 smallint,
    vlr_componente_abrigalidade double precision,
    vlr_indicador_h4 smallint,
    vlr_componente_acesso_agua double precision,
    vlr_indicador_h5 smallint,
    vlr_componente_acesso_escoamento double precision,
    vlr_indicador_h6 smallint,
    vlr_componente_acesso_coleta_lixo double precision,
    vlr_indicador_h7 smallint,
    vlr_componente_acesso_eletricidade double precision,
    vlr_indicador_h8 smallint,
    vlr_indicador_v10 smallint,
    vlr_indicador_v11 smallint,
    vlr_indicador_v12 smallint,
    modified timestamp without time zone
);


ALTER TABLE public.tb_indice OWNER TO programacaolocal;

--
-- TOC entry 1573 (class 1259 OID 17336)
-- Dependencies: 1892 6
-- Name: tb_pagina; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_pagina (
    id_pagina integer DEFAULT nextval('seq_pagina'::regclass) NOT NULL,
    nome_link character varying(30) NOT NULL,
    desc_titulo character varying(60) NOT NULL,
    desc_conteudo text NOT NULL,
    created timestamp without time zone,
    modified timestamp without time zone
);


ALTER TABLE public.tb_pagina OWNER TO programacaolocal;

--
-- TOC entry 1601 (class 1259 OID 17519)
-- Dependencies: 1986 1987 6
-- Name: tb_permissao; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_permissao (
    id_permissao integer DEFAULT nextval('seq_permissao'::regclass) NOT NULL,
    nome_controller character varying(50) NOT NULL,
    nome_action character varying(50),
    tp_acesso_administrador smallint,
    tp_acesso_tecnico_sas smallint,
    tp_acesso_coordenador_cras smallint,
    tp_acesso_tecnico_cras smallint,
    tp_acesso_simples boolean DEFAULT false NOT NULL
);


ALTER TABLE public.tb_permissao OWNER TO programacaolocal;

--
-- TOC entry 1575 (class 1259 OID 17357)
-- Dependencies: 1893 1894 1895 1896 1897 1898 1899 1900 1901 1902 1903 1904 1905 1906 1907 1908 1909 1910 1911 1912 1913 1914 1915 1916 1917 1918 1919 1920 1921 1922 1923 6
-- Name: tb_pessoa; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_pessoa (
    cod_nis character varying(15) NOT NULL,
    nome character varying(100) NOT NULL,
    cod_domiciliar character varying(12) DEFAULT NULL::character varying,
    cpf character varying(14) DEFAULT NULL::character varying,
    teleitor_num character varying(18) DEFAULT NULL::character varying,
    teleitor_zona character varying(10) DEFAULT NULL::character varying,
    teleitor_secao character varying(10) DEFAULT NULL::character varying,
    desc_ocupacao character varying(30) DEFAULT NULL::character varying,
    cod_inep character varying(12) DEFAULT NULL::character varying,
    cod_nis_responsavel character varying(15) DEFAULT NULL::character varying,
    tp_pararentesco_responsavel smallint,
    vlr_remuneracao numeric(10,2) DEFAULT 0.00 NOT NULL,
    vlr_aposentadoria numeric(10,2) DEFAULT 0.00 NOT NULL,
    vlr_pensao numeric(10,2) DEFAULT 0.00 NOT NULL,
    vlr_seguro_desemprego numeric(10,2) DEFAULT 0.00 NOT NULL,
    vlr_beneficio numeric(10,2) DEFAULT 0.00 NOT NULL,
    dt_nasc date,
    serie_escolar smallint,
    tp_trabalho smallint,
    raca smallint,
    sexo smallint,
    est_civil smallint,
    grau_instrucao smallint,
    tp_escola smallint,
    observacao text,
    data_pesquisa date,
    dt_inclusao date,
    dt_atualizacao date,
    nome_entrevistador character varying(60) DEFAULT NULL::character varying,
    vlr_outra_renda numeric(10,2) DEFAULT 0.00,
    qtd_mes_gestacao smallint,
    amamentando smallint DEFAULT (0)::smallint NOT NULL,
    cegueira smallint DEFAULT (0)::smallint NOT NULL,
    surdez smallint DEFAULT (0)::smallint NOT NULL,
    mudez smallint DEFAULT (0)::smallint NOT NULL,
    deficiencia_mental smallint DEFAULT (0)::smallint NOT NULL,
    deficiencia_fisica smallint DEFAULT (0)::smallint NOT NULL,
    outra_deficiencia smallint DEFAULT (0)::smallint NOT NULL,
    portador_deficiencia smallint DEFAULT (0)::smallint NOT NULL,
    esposa_companheiro smallint DEFAULT (0)::smallint NOT NULL,
    vlr_renda_total numeric(10,2) DEFAULT 0.00 NOT NULL,
    CONSTRAINT pessoas_estado_civil_check CHECK ((est_civil >= 0)),
    CONSTRAINT pessoas_grau_instrucao_check CHECK ((grau_instrucao >= 0)),
    CONSTRAINT pessoas_raca_cor_check CHECK ((raca >= 0)),
    CONSTRAINT pessoas_serie_escolar_check CHECK ((serie_escolar >= 0)),
    CONSTRAINT pessoas_tipo_escola_check CHECK ((tp_escola >= 0)),
    CONSTRAINT pessoas_tipo_trabalho_check CHECK ((tp_trabalho >= 0))
);


ALTER TABLE public.tb_pessoa OWNER TO programacaolocal;

--
-- TOC entry 1577 (class 1259 OID 17395)
-- Dependencies: 1924 6
-- Name: tb_pessoa_servico; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_pessoa_servico (
    id_pessoa_servico integer DEFAULT nextval('seq_pessoa_servico'::regclass) NOT NULL,
    cod_nis_pessoa character varying(15) NOT NULL,
    id_servico integer NOT NULL
);


ALTER TABLE public.tb_pessoa_servico OWNER TO programacaolocal;

--
-- TOC entry 1579 (class 1259 OID 17401)
-- Dependencies: 1925 1926 6
-- Name: tb_plano_familiar; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_plano_familiar (
    id_plano_familiar integer DEFAULT nextval('seq_prontuario'::regclass) NOT NULL,
    cod_domiciliar character varying(12) NOT NULL,
    num_plano_familiar integer NOT NULL,
    id_usuario integer NOT NULL,
    created timestamp without time zone NOT NULL,
    CONSTRAINT prontuarios_numero_prontuario_check CHECK ((num_plano_familiar >= 0))
);


ALTER TABLE public.tb_plano_familiar OWNER TO programacaolocal;

--
-- TOC entry 1581 (class 1259 OID 17408)
-- Dependencies: 1927 6
-- Name: tb_regiao; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_regiao (
    id_regiao integer DEFAULT nextval('seq_regiao'::regclass) NOT NULL,
    desc_regiao character varying(30) NOT NULL
);


ALTER TABLE public.tb_regiao OWNER TO programacaolocal;

--
-- TOC entry 1593 (class 1259 OID 17434)
-- Dependencies: 1928 1929 1930 1931 1932 6
-- Name: tb_servico; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_servico (
    id_servico integer DEFAULT nextval('seq_servico'::regclass) NOT NULL,
    tp_servico smallint,
    nome_servico character varying(60) DEFAULT NULL::character varying,
    desc_servico character varying(200) DEFAULT NULL::character varying,
    faixa_etaria character varying(60) DEFAULT NULL::character varying,
    horario character varying(40) DEFAULT NULL::character varying,
    vlr_per_capita double precision,
    qtd_capacidade integer
);


ALTER TABLE public.tb_servico OWNER TO programacaolocal;

--
-- TOC entry 1602 (class 1259 OID 17524)
-- Dependencies: 1988 6
-- Name: tb_usuario; Type: TABLE; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE TABLE tb_usuario (
    id_usuario integer DEFAULT nextval('seq_usuario'::regclass) NOT NULL,
    nome_usuario character varying(50) NOT NULL,
    username character varying(20) NOT NULL,
    password character varying(64) NOT NULL,
    created timestamp without time zone,
    modified timestamp without time zone,
    id_grupo smallint
);


ALTER TABLE public.tb_usuario OWNER TO programacaolocal;

--
-- TOC entry 2039 (class 2606 OID 17538)
-- Dependencies: 1595 1595
-- Name: acessos_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_acesso
    ADD CONSTRAINT acessos_pkey PRIMARY KEY (id_acesso);


--
-- TOC entry 2036 (class 2606 OID 17540)
-- Dependencies: 1594 1594
-- Name: acoes_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_acao
    ADD CONSTRAINT acoes_pkey PRIMARY KEY (id_acao);


--
-- TOC entry 2042 (class 2606 OID 17542)
-- Dependencies: 1596 1596
-- Name: bairros_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_bairro
    ADD CONSTRAINT bairros_pkey PRIMARY KEY (id_bairro);


--
-- TOC entry 2047 (class 2606 OID 17544)
-- Dependencies: 1597 1597
-- Name: cras_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_cras
    ADD CONSTRAINT cras_pkey PRIMARY KEY (id_cras);


--
-- TOC entry 2050 (class 2606 OID 17546)
-- Dependencies: 1598 1598 1598 1598
-- Name: cras_usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_cras_usuario
    ADD CONSTRAINT cras_usuarios_pkey PRIMARY KEY (id_cras_usuario, id_cras, id_usuario);


--
-- TOC entry 2054 (class 2606 OID 17548)
-- Dependencies: 1599 1599
-- Name: dimensoes_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_dimensao_idf
    ADD CONSTRAINT dimensoes_pkey PRIMARY KEY (id_dimensao_idf);


--
-- TOC entry 2056 (class 2606 OID 17550)
-- Dependencies: 1600 1600
-- Name: domicilios_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_domicilio
    ADD CONSTRAINT domicilios_pkey PRIMARY KEY (cod_domiciliar);


--
-- TOC entry 1994 (class 2606 OID 17552)
-- Dependencies: 1562 1562 1562 1562
-- Name: estrategias_indicadores_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_estrategia_indicador
    ADD CONSTRAINT estrategias_indicadores_pkey PRIMARY KEY (id_estrategia_indicador, id_estrategia, id_indicador);


--
-- TOC entry 1990 (class 2606 OID 17554)
-- Dependencies: 1560 1560
-- Name: estrategias_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_estrategia
    ADD CONSTRAINT estrategias_pkey PRIMARY KEY (id_estrategia);


--
-- TOC entry 1997 (class 2606 OID 17556)
-- Dependencies: 1564 1564 1564 1564
-- Name: estrategias_prontuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_estrategia_plano_familiar
    ADD CONSTRAINT estrategias_prontuarios_pkey PRIMARY KEY (id_estrategia_prontuario, id_estrategia, id_plano_familiar);


--
-- TOC entry 2000 (class 2606 OID 17560)
-- Dependencies: 1567 1567
-- Name: indicadores_coluna_key; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_indicador
    ADD CONSTRAINT indicadores_coluna_key UNIQUE (cod_coluna_indicador);


--
-- TOC entry 2003 (class 2606 OID 17562)
-- Dependencies: 1567 1567
-- Name: indicadores_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_indicador
    ADD CONSTRAINT indicadores_pkey PRIMARY KEY (id_indicador);


--
-- TOC entry 2006 (class 2606 OID 17564)
-- Dependencies: 1569 1569 1569 1569
-- Name: indicadores_prontuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_indicador_plano_familiar
    ADD CONSTRAINT indicadores_prontuarios_pkey PRIMARY KEY (id, indicador_id, plano_familiar_id);


--
-- TOC entry 2011 (class 2606 OID 17568)
-- Dependencies: 1570 1570
-- Name: indices_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_indice
    ADD CONSTRAINT indices_pkey PRIMARY KEY (cod_domiciliar);


--
-- TOC entry 2013 (class 2606 OID 17570)
-- Dependencies: 1573 1573
-- Name: pages_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_pagina
    ADD CONSTRAINT pages_pkey PRIMARY KEY (id_pagina);


--
-- TOC entry 2021 (class 2606 OID 17576)
-- Dependencies: 1575 1575
-- Name: pessoas_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_pessoa
    ADD CONSTRAINT pessoas_pkey PRIMARY KEY (cod_nis);


--
-- TOC entry 2025 (class 2606 OID 17578)
-- Dependencies: 1577 1577 1577 1577
-- Name: pessoas_servicos_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_pessoa_servico
    ADD CONSTRAINT pessoas_servicos_pkey PRIMARY KEY (id_pessoa_servico, cod_nis_pessoa, id_servico);


--
-- TOC entry 2063 (class 2606 OID 17580)
-- Dependencies: 1601 1601
-- Name: pk_permissao; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_permissao
    ADD CONSTRAINT pk_permissao PRIMARY KEY (id_permissao);


--
-- TOC entry 2029 (class 2606 OID 17582)
-- Dependencies: 1579 1579
-- Name: prontuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_plano_familiar
    ADD CONSTRAINT prontuarios_pkey PRIMARY KEY (id_plano_familiar);


--
-- TOC entry 2032 (class 2606 OID 17584)
-- Dependencies: 1581 1581
-- Name: regioes_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_regiao
    ADD CONSTRAINT regioes_pkey PRIMARY KEY (id_regiao);


--
-- TOC entry 2034 (class 2606 OID 17586)
-- Dependencies: 1593 1593
-- Name: servicos_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_servico
    ADD CONSTRAINT servicos_pkey PRIMARY KEY (id_servico);


--
-- TOC entry 2065 (class 2606 OID 17588)
-- Dependencies: 1602 1602
-- Name: usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_usuario
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id_usuario);


--
-- TOC entry 2067 (class 2606 OID 17590)
-- Dependencies: 1602 1602
-- Name: usuarios_username_key; Type: CONSTRAINT; Schema: public; Owner: programacaolocal; Tablespace: 
--

ALTER TABLE ONLY tb_usuario
    ADD CONSTRAINT usuarios_username_key UNIQUE (username);


--
-- TOC entry 2045 (class 1259 OID 17593)
-- Dependencies: 1597
-- Name: cras_bairro_id_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX cras_bairro_id_idx ON tb_cras USING btree (id_bairro);


--
-- TOC entry 2048 (class 1259 OID 17594)
-- Dependencies: 1597
-- Name: cras_regiao_id_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX cras_regiao_id_idx ON tb_cras USING btree (id_regiao);


--
-- TOC entry 2057 (class 1259 OID 17595)
-- Dependencies: 1600
-- Name: domicilios_regiao_id_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX domicilios_regiao_id_idx ON tb_domicilio USING btree (id_regiao);


--
-- TOC entry 1991 (class 1259 OID 17596)
-- Dependencies: 1562
-- Name: estrategias_indicadores_estrategia_id_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX estrategias_indicadores_estrategia_id_idx ON tb_estrategia_indicador USING btree (id_estrategia);


--
-- TOC entry 1992 (class 1259 OID 17597)
-- Dependencies: 1562
-- Name: estrategias_indicadores_indicador_id_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX estrategias_indicadores_indicador_id_idx ON tb_estrategia_indicador USING btree (id_indicador);


--
-- TOC entry 1995 (class 1259 OID 17598)
-- Dependencies: 1564
-- Name: estrategias_prontuarios_estrategia_id_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX estrategias_prontuarios_estrategia_id_idx ON tb_estrategia_plano_familiar USING btree (id_estrategia);


--
-- TOC entry 1998 (class 1259 OID 17599)
-- Dependencies: 1564
-- Name: estrategias_prontuarios_prontuario_id_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX estrategias_prontuarios_prontuario_id_idx ON tb_estrategia_plano_familiar USING btree (id_plano_familiar);


--
-- TOC entry 2043 (class 1259 OID 17603)
-- Dependencies: 1596
-- Name: fki_cras; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX fki_cras ON tb_bairro USING btree (id_cras);


--
-- TOC entry 2051 (class 1259 OID 17604)
-- Dependencies: 1598
-- Name: fki_cras2; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX fki_cras2 ON tb_cras_usuario USING btree (id_cras);


--
-- TOC entry 2058 (class 1259 OID 17605)
-- Dependencies: 1600
-- Name: fki_domicilios_bairro; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX fki_domicilios_bairro ON tb_domicilio USING btree (id_bairro);


--
-- TOC entry 2059 (class 1259 OID 17606)
-- Dependencies: 1600
-- Name: fki_domicilios_cras; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX fki_domicilios_cras ON tb_domicilio USING btree (id_cras);


--
-- TOC entry 2060 (class 1259 OID 17607)
-- Dependencies: 1600
-- Name: fki_domicilios_regiao; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX fki_domicilios_regiao ON tb_domicilio USING btree (id_regiao);


--
-- TOC entry 2061 (class 1259 OID 17608)
-- Dependencies: 1600
-- Name: fki_domicilios_responsavel; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX fki_domicilios_responsavel ON tb_domicilio USING btree (cod_nis_responsavel);


--
-- TOC entry 2037 (class 1259 OID 17609)
-- Dependencies: 1594
-- Name: fki_estrategia; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX fki_estrategia ON tb_acao USING btree (id_estrategia);


--
-- TOC entry 2014 (class 1259 OID 17610)
-- Dependencies: 1575
-- Name: fki_pessoas_domicilios; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX fki_pessoas_domicilios ON tb_pessoa USING btree (cod_domiciliar);


--
-- TOC entry 2015 (class 1259 OID 17611)
-- Dependencies: 1575
-- Name: fki_pessoas_responsavel; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX fki_pessoas_responsavel ON tb_pessoa USING btree (cod_nis);


--
-- TOC entry 2044 (class 1259 OID 17612)
-- Dependencies: 1596
-- Name: fki_regiao; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX fki_regiao ON tb_bairro USING btree (id_regiao);


--
-- TOC entry 2040 (class 1259 OID 17613)
-- Dependencies: 1595
-- Name: fki_usuario; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX fki_usuario ON tb_acesso USING btree (id_usuario);


--
-- TOC entry 2052 (class 1259 OID 17614)
-- Dependencies: 1598
-- Name: fki_usuario2; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX fki_usuario2 ON tb_cras_usuario USING btree (id_usuario);


--
-- TOC entry 2001 (class 1259 OID 17615)
-- Dependencies: 1567
-- Name: indicadores_dimensao_id_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX indicadores_dimensao_id_idx ON tb_indicador USING btree (id_dimensao_idf);


--
-- TOC entry 2004 (class 1259 OID 17616)
-- Dependencies: 1569
-- Name: indicadores_prontuarios_indicador_id_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX indicadores_prontuarios_indicador_id_idx ON tb_indicador_plano_familiar USING btree (indicador_id);


--
-- TOC entry 2007 (class 1259 OID 17617)
-- Dependencies: 1569
-- Name: indicadores_prontuarios_prontuario_id_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX indicadores_prontuarios_prontuario_id_idx ON tb_indicador_plano_familiar USING btree (plano_familiar_id);


--
-- TOC entry 2008 (class 1259 OID 17619)
-- Dependencies: 1570
-- Name: indices_idf_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX indices_idf_idx ON tb_indice USING btree (vlr_idf);


--
-- TOC entry 2009 (class 1259 OID 17620)
-- Dependencies: 1570
-- Name: indices_modified_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX indices_modified_idx ON tb_indice USING btree (modified);


--
-- TOC entry 2016 (class 1259 OID 17623)
-- Dependencies: 1575
-- Name: pessoas_codigo_domiciliar_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX pessoas_codigo_domiciliar_idx ON tb_pessoa USING btree (cod_domiciliar);


--
-- TOC entry 2017 (class 1259 OID 17624)
-- Dependencies: 1575
-- Name: pessoas_data_nascimento_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX pessoas_data_nascimento_idx ON tb_pessoa USING btree (dt_nasc);


--
-- TOC entry 2018 (class 1259 OID 17625)
-- Dependencies: 1575
-- Name: pessoas_genero_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX pessoas_genero_idx ON tb_pessoa USING btree (sexo);


--
-- TOC entry 2019 (class 1259 OID 17626)
-- Dependencies: 1575
-- Name: pessoas_grau_instrucao_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX pessoas_grau_instrucao_idx ON tb_pessoa USING btree (grau_instrucao);


--
-- TOC entry 2022 (class 1259 OID 17627)
-- Dependencies: 1575
-- Name: pessoas_responsavel_nis_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX pessoas_responsavel_nis_idx ON tb_pessoa USING btree (cod_nis_responsavel);


--
-- TOC entry 2023 (class 1259 OID 17628)
-- Dependencies: 1577
-- Name: pessoas_servicos_pessoa_nis_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX pessoas_servicos_pessoa_nis_idx ON tb_pessoa_servico USING btree (cod_nis_pessoa);


--
-- TOC entry 2026 (class 1259 OID 17629)
-- Dependencies: 1577
-- Name: pessoas_servicos_servico_id_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX pessoas_servicos_servico_id_idx ON tb_pessoa_servico USING btree (id_servico);


--
-- TOC entry 2027 (class 1259 OID 17630)
-- Dependencies: 1579
-- Name: prontuarios_codigo_domiciliar_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX prontuarios_codigo_domiciliar_idx ON tb_plano_familiar USING btree (cod_domiciliar);


--
-- TOC entry 2030 (class 1259 OID 17631)
-- Dependencies: 1579
-- Name: prontuarios_usuario_id_idx; Type: INDEX; Schema: public; Owner: programacaolocal; Tablespace: 
--

CREATE INDEX prontuarios_usuario_id_idx ON tb_plano_familiar USING btree (id_usuario);


--
-- TOC entry 2086 (class 2606 OID 17634)
-- Dependencies: 1597 1596 2041
-- Name: fk_bairro; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_cras
    ADD CONSTRAINT fk_bairro FOREIGN KEY (id_bairro) REFERENCES tb_bairro(id_bairro);


--
-- TOC entry 2084 (class 2606 OID 17639)
-- Dependencies: 1597 1596 2046
-- Name: fk_cras; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_bairro
    ADD CONSTRAINT fk_cras FOREIGN KEY (id_cras) REFERENCES tb_cras(id_cras);


--
-- TOC entry 2088 (class 2606 OID 17644)
-- Dependencies: 1598 2046 1597
-- Name: fk_cras; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_cras_usuario
    ADD CONSTRAINT fk_cras FOREIGN KEY (id_cras) REFERENCES tb_cras(id_cras);


--
-- TOC entry 2072 (class 2606 OID 17818)
-- Dependencies: 1599 1567 2053
-- Name: fk_dimensao; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_indicador
    ADD CONSTRAINT fk_dimensao FOREIGN KEY (id_dimensao_idf) REFERENCES tb_dimensao_idf(id_dimensao_idf);


--
-- TOC entry 2080 (class 2606 OID 17778)
-- Dependencies: 1600 1579 2055
-- Name: fk_domicilio; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_plano_familiar
    ADD CONSTRAINT fk_domicilio FOREIGN KEY (cod_domiciliar) REFERENCES tb_domicilio(cod_domiciliar);


--
-- TOC entry 2090 (class 2606 OID 17649)
-- Dependencies: 1600 2041 1596
-- Name: fk_domicilios_bairro; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_domicilio
    ADD CONSTRAINT fk_domicilios_bairro FOREIGN KEY (id_bairro) REFERENCES tb_bairro(id_bairro);


--
-- TOC entry 2091 (class 2606 OID 17654)
-- Dependencies: 2046 1597 1600
-- Name: fk_domicilios_cras; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_domicilio
    ADD CONSTRAINT fk_domicilios_cras FOREIGN KEY (id_cras) REFERENCES tb_cras(id_cras);


--
-- TOC entry 2092 (class 2606 OID 17659)
-- Dependencies: 1581 2031 1600
-- Name: fk_domicilios_regioes; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_domicilio
    ADD CONSTRAINT fk_domicilios_regioes FOREIGN KEY (id_regiao) REFERENCES tb_regiao(id_regiao);


--
-- TOC entry 2093 (class 2606 OID 17664)
-- Dependencies: 1600 2020 1575
-- Name: fk_domicilios_responsavel; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_domicilio
    ADD CONSTRAINT fk_domicilios_responsavel FOREIGN KEY (cod_nis_responsavel) REFERENCES tb_pessoa(cod_nis);


--
-- TOC entry 2082 (class 2606 OID 17669)
-- Dependencies: 1594 1560 1989
-- Name: fk_estrategia; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_acao
    ADD CONSTRAINT fk_estrategia FOREIGN KEY (id_estrategia) REFERENCES tb_estrategia(id_estrategia);


--
-- TOC entry 2070 (class 2606 OID 17798)
-- Dependencies: 1564 1989 1560
-- Name: fk_estrategia; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_estrategia_plano_familiar
    ADD CONSTRAINT fk_estrategia FOREIGN KEY (id_estrategia) REFERENCES tb_estrategia(id_estrategia);


--
-- TOC entry 2068 (class 2606 OID 17808)
-- Dependencies: 1560 1989 1562
-- Name: fk_estrategia; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_estrategia_indicador
    ADD CONSTRAINT fk_estrategia FOREIGN KEY (id_estrategia) REFERENCES tb_estrategia(id_estrategia);


--
-- TOC entry 2073 (class 2606 OID 17788)
-- Dependencies: 1567 1569 2002
-- Name: fk_indicador; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_indicador_plano_familiar
    ADD CONSTRAINT fk_indicador FOREIGN KEY (indicador_id) REFERENCES tb_indicador(id_indicador);


--
-- TOC entry 2069 (class 2606 OID 17813)
-- Dependencies: 1567 2002 1562
-- Name: fk_indicador; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_estrategia_indicador
    ADD CONSTRAINT fk_indicador FOREIGN KEY (id_indicador) REFERENCES tb_indicador(id_indicador);


--
-- TOC entry 2075 (class 2606 OID 17674)
-- Dependencies: 1570 1600 2055
-- Name: fk_indices_domicilios; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_indice
    ADD CONSTRAINT fk_indices_domicilios FOREIGN KEY (cod_domiciliar) REFERENCES tb_domicilio(cod_domiciliar);


--
-- TOC entry 2078 (class 2606 OID 17768)
-- Dependencies: 1575 1577 2020
-- Name: fk_pessoa; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_pessoa_servico
    ADD CONSTRAINT fk_pessoa FOREIGN KEY (cod_nis_pessoa) REFERENCES tb_pessoa(cod_nis);


--
-- TOC entry 2076 (class 2606 OID 17679)
-- Dependencies: 1600 2055 1575
-- Name: fk_pessoas_domicilios; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_pessoa
    ADD CONSTRAINT fk_pessoas_domicilios FOREIGN KEY (cod_domiciliar) REFERENCES tb_domicilio(cod_domiciliar);


--
-- TOC entry 2077 (class 2606 OID 17684)
-- Dependencies: 1575 1575 2020
-- Name: fk_pessoas_responsavel; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_pessoa
    ADD CONSTRAINT fk_pessoas_responsavel FOREIGN KEY (cod_nis) REFERENCES tb_pessoa(cod_nis);


--
-- TOC entry 2074 (class 2606 OID 17793)
-- Dependencies: 1579 2028 1569
-- Name: fk_plano_familiar; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_indicador_plano_familiar
    ADD CONSTRAINT fk_plano_familiar FOREIGN KEY (plano_familiar_id) REFERENCES tb_plano_familiar(id_plano_familiar);


--
-- TOC entry 2071 (class 2606 OID 17803)
-- Dependencies: 1564 2028 1579
-- Name: fk_plano_familiar; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_estrategia_plano_familiar
    ADD CONSTRAINT fk_plano_familiar FOREIGN KEY (id_plano_familiar) REFERENCES tb_plano_familiar(id_plano_familiar);


--
-- TOC entry 2085 (class 2606 OID 17689)
-- Dependencies: 1581 2031 1596
-- Name: fk_regiao; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_bairro
    ADD CONSTRAINT fk_regiao FOREIGN KEY (id_regiao) REFERENCES tb_regiao(id_regiao);


--
-- TOC entry 2087 (class 2606 OID 17694)
-- Dependencies: 1597 1581 2031
-- Name: fk_regiao; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_cras
    ADD CONSTRAINT fk_regiao FOREIGN KEY (id_regiao) REFERENCES tb_regiao(id_regiao);


--
-- TOC entry 2079 (class 2606 OID 17773)
-- Dependencies: 2033 1593 1577
-- Name: fk_servico; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_pessoa_servico
    ADD CONSTRAINT fk_servico FOREIGN KEY (id_servico) REFERENCES tb_servico(id_servico);


--
-- TOC entry 2083 (class 2606 OID 17699)
-- Dependencies: 2064 1602 1595
-- Name: fk_usuario; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_acesso
    ADD CONSTRAINT fk_usuario FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario);


--
-- TOC entry 2089 (class 2606 OID 17704)
-- Dependencies: 1598 1602 2064
-- Name: fk_usuario; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_cras_usuario
    ADD CONSTRAINT fk_usuario FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario);


--
-- TOC entry 2081 (class 2606 OID 17783)
-- Dependencies: 1579 1602 2064
-- Name: fk_usuario; Type: FK CONSTRAINT; Schema: public; Owner: programacaolocal
--

ALTER TABLE ONLY tb_plano_familiar
    ADD CONSTRAINT fk_usuario FOREIGN KEY (id_usuario) REFERENCES tb_usuario(id_usuario);


--
-- TOC entry 2097 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: programacaolocal
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM programacaolocal;
GRANT ALL ON SCHEMA public TO programacaolocal;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2012-10-03 02:16:31

--
-- PostgreSQL database dump complete
--

