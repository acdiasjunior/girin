--
-- PostgreSQL database dump
--

-- Started on 2012-10-03 02:15:05

SET statement_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = off;
SET check_function_bodies = false;
SET client_min_messages = warning;
SET escape_string_warning = off;

--
-- TOC entry 383 (class 2612 OID 95407662)
-- Name: plpgsql; Type: PROCEDURAL LANGUAGE; Schema: -; Owner: juniordias
--

CREATE PROCEDURAL LANGUAGE plpgsql;


ALTER PROCEDURAL LANGUAGE plpgsql OWNER TO juniordias;

SET search_path = public, pg_catalog;

--
-- TOC entry 1570 (class 1259 OID 95448615)
-- Dependencies: 6
-- Name: seq_acao; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_acao
    START WITH 189
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_acao OWNER TO juniordias;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 1571 (class 1259 OID 95448617)
-- Dependencies: 1896 1897 1898 1899 1900 1901 6
-- Name: acoes; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE acoes (
    id integer DEFAULT nextval('seq_acao'::regclass) NOT NULL,
    estrategia_id integer NOT NULL,
    codigo character varying(10) NOT NULL,
    descricao character varying(2048) NOT NULL,
    responsavel smallint,
    usuarios smallint,
    atividade smallint,
    rede smallint,
    ponto_socioassistencial smallint,
    sistema_setorial_apoio smallint,
    sistema_logistico smallint,
    prazo_minimo integer,
    prazo_maximo integer,
    encaminhamento character varying(1024) DEFAULT NULL::character varying,
    pactuacao_familia character varying(255) DEFAULT NULL::character varying,
    observacoes character varying(1024) DEFAULT NULL::character varying,
    CONSTRAINT acoes_prazo_maximo_check CHECK ((prazo_maximo >= 0)),
    CONSTRAINT acoes_prazo_minimo_check CHECK ((prazo_minimo >= 0))
);


ALTER TABLE public.acoes OWNER TO juniordias;

--
-- TOC entry 1572 (class 1259 OID 95448629)
-- Dependencies: 6
-- Name: seq_bairro; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_bairro
    START WITH 195
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_bairro OWNER TO juniordias;

--
-- TOC entry 1573 (class 1259 OID 95448631)
-- Dependencies: 1902 6
-- Name: bairros; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE bairros (
    id integer DEFAULT nextval('seq_bairro'::regclass) NOT NULL,
    regiao_id integer,
    cras_id integer,
    nome character varying(50) NOT NULL
);


ALTER TABLE public.bairros OWNER TO juniordias;

--
-- TOC entry 1574 (class 1259 OID 95448637)
-- Dependencies: 6
-- Name: seq_cras; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_cras
    START WITH 12
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_cras OWNER TO juniordias;

--
-- TOC entry 1575 (class 1259 OID 95448639)
-- Dependencies: 1903 1904 1905 1906 1907 1908 1909 1910 6
-- Name: cras; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE cras (
    id integer DEFAULT nextval('seq_cras'::regclass) NOT NULL,
    descricao character varying(80) NOT NULL,
    tipo_logradouro character varying(20) DEFAULT NULL::character varying,
    logradouro character varying(80) DEFAULT NULL::character varying,
    numero character varying(10) DEFAULT NULL::character varying,
    complemento character varying(30) DEFAULT NULL::character varying,
    bairro_id integer,
    regiao_id integer,
    cidade character varying(80) DEFAULT NULL::character varying,
    uf character varying(2) DEFAULT NULL::character varying,
    telefone character varying(14) DEFAULT NULL::character varying
);


ALTER TABLE public.cras OWNER TO juniordias;

--
-- TOC entry 1576 (class 1259 OID 95448652)
-- Dependencies: 6
-- Name: seq_cras_usuario; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_cras_usuario
    START WITH 44
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_cras_usuario OWNER TO juniordias;

--
-- TOC entry 1577 (class 1259 OID 95448654)
-- Dependencies: 1911 6
-- Name: cras_usuarios; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE cras_usuarios (
    id integer DEFAULT nextval('seq_cras_usuario'::regclass) NOT NULL,
    cras_id integer NOT NULL,
    usuario_id integer NOT NULL
);


ALTER TABLE public.cras_usuarios OWNER TO juniordias;

--
-- TOC entry 1578 (class 1259 OID 95448659)
-- Dependencies: 6
-- Name: seq_dimensao; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_dimensao
    START WITH 7
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_dimensao OWNER TO juniordias;

--
-- TOC entry 1579 (class 1259 OID 95448661)
-- Dependencies: 1912 6
-- Name: dimensoes; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE dimensoes (
    id integer DEFAULT nextval('seq_dimensao'::regclass) NOT NULL,
    descricao character varying(50) NOT NULL,
    coluna character varying(20) NOT NULL
);


ALTER TABLE public.dimensoes OWNER TO juniordias;

--
-- TOC entry 1580 (class 1259 OID 95448665)
-- Dependencies: 1913 1914 1915 1916 1917 1918 1919 1920 1921 1922 1923 1924 1925 1926 1927 1928 1929 1930 1931 1932 1933 1934 1935 1936 1937 1938 1939 1940 1941 1942 1943 1944 1945 1946 6
-- Name: domicilios; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE domicilios (
    codigo_domiciliar character varying(12) NOT NULL,
    nis_responsavel character varying(15) DEFAULT NULL::character varying,
    cep character varying(10) DEFAULT NULL::character varying,
    tipo_logradouro character varying(20) DEFAULT NULL::character varying,
    logradouro character varying(80) DEFAULT NULL::character varying,
    numero character varying(10) DEFAULT NULL::character varying,
    complemento character varying(30) DEFAULT NULL::character varying,
    bairro_id integer,
    bairro_nome character varying(60) DEFAULT NULL::character varying,
    cras_id integer,
    regiao_id integer,
    cidade character varying(80) DEFAULT NULL::character varying,
    uf character varying(2) DEFAULT NULL::character varying,
    ddd character varying(3) DEFAULT NULL::character varying,
    telefone character varying(10) DEFAULT NULL::character varying,
    tipo_localidade smallint,
    situacao_domicilio smallint,
    tipo_domicilio smallint,
    tipo_construcao smallint,
    tipo_abastecimento smallint,
    tratamento_agua smallint,
    tipo_iluminacao smallint,
    escoamento_sanitario smallint,
    destino_lixo smallint,
    bolsa_familia smallint,
    comodos integer,
    valor_despesa_aluguel numeric(10,2) DEFAULT NULL::numeric,
    valor_despesa_prestacao numeric(10,2) DEFAULT NULL::numeric,
    valor_despesa_alimentacao numeric(10,2) DEFAULT NULL::numeric,
    valor_despesa_agua numeric(10,2) DEFAULT NULL::numeric,
    valor_despesa_luz numeric(10,2) DEFAULT NULL::numeric,
    valor_despesa_transporte numeric(10,2) DEFAULT NULL::numeric,
    valor_despesa_medicamento numeric(10,2) DEFAULT NULL::numeric,
    valor_despesa_gas numeric(10,2) DEFAULT NULL::numeric,
    valor_outras_despesas numeric(10,2) DEFAULT NULL::numeric,
    idf numeric(3,2),
    data_pesquisa date,
    data_inclusao date,
    data_atualizacao date,
    entrevistador character varying(60) DEFAULT NULL::character varying,
    quantidade_pessoas integer,
    valor_despesa_familia numeric(10,2) DEFAULT NULL::numeric,
    valor_remuneracao numeric(10,2) DEFAULT NULL::numeric,
    valor_aposentadoria_pensao numeric(10,2) DEFAULT NULL::numeric,
    valor_seguro_desemprego numeric(10,2) DEFAULT NULL::numeric,
    valor_pensao_alimenticia numeric(10,2) DEFAULT NULL::numeric,
    valor_outras_rendas numeric(10,2) DEFAULT NULL::numeric,
    valor_renda_familia numeric(10,2) DEFAULT NULL::numeric,
    valor_beneficio numeric(10,2) DEFAULT NULL::numeric,
    CONSTRAINT domicilios_bairro_id_check CHECK ((bairro_id >= 0)),
    CONSTRAINT domicilios_cras_id_check CHECK ((cras_id >= 0)),
    CONSTRAINT domicilios_regiao_id_check CHECK ((regiao_id >= 0)),
    CONSTRAINT domicilios_situacao_domicilio_check CHECK ((situacao_domicilio >= 0)),
    CONSTRAINT domicilios_tipo_localidade_check CHECK ((tipo_localidade >= 0))
);


ALTER TABLE public.domicilios OWNER TO juniordias;

--
-- TOC entry 1581 (class 1259 OID 95448702)
-- Dependencies: 6
-- Name: seq_estrategia; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_estrategia
    START WITH 20
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_estrategia OWNER TO juniordias;

--
-- TOC entry 1582 (class 1259 OID 95448704)
-- Dependencies: 1947 6
-- Name: estrategias; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE estrategias (
    id integer DEFAULT nextval('seq_estrategia'::regclass) NOT NULL,
    codigo character varying(5) NOT NULL,
    descricao character varying(1024) NOT NULL,
    idade_min integer,
    idade_max integer
);


ALTER TABLE public.estrategias OWNER TO juniordias;

--
-- TOC entry 1583 (class 1259 OID 95448711)
-- Dependencies: 6
-- Name: seq_estrategia_indicador; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_estrategia_indicador
    START WITH 103
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_estrategia_indicador OWNER TO juniordias;

--
-- TOC entry 1584 (class 1259 OID 95448713)
-- Dependencies: 1948 1949 1950 6
-- Name: estrategias_indicadores; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE estrategias_indicadores (
    id integer DEFAULT nextval('seq_estrategia_indicador'::regclass) NOT NULL,
    estrategia_id integer NOT NULL,
    indicador_id integer NOT NULL,
    CONSTRAINT estrategias_indicadores_estrategia_id_check CHECK ((estrategia_id >= 0)),
    CONSTRAINT estrategias_indicadores_indicador_id_check CHECK ((indicador_id >= 0))
);


ALTER TABLE public.estrategias_indicadores OWNER TO juniordias;

--
-- TOC entry 1585 (class 1259 OID 95448719)
-- Dependencies: 6
-- Name: seq_estrategia_prontuario; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_estrategia_prontuario
    START WITH 109
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_estrategia_prontuario OWNER TO juniordias;

--
-- TOC entry 1586 (class 1259 OID 95448721)
-- Dependencies: 1951 1952 1953 6
-- Name: estrategias_prontuarios; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE estrategias_prontuarios (
    id integer DEFAULT nextval('seq_estrategia_prontuario'::regclass) NOT NULL,
    estrategia_id integer NOT NULL,
    prontuario_id integer NOT NULL,
    CONSTRAINT estrategias_prontuarios_estrategia_id_check CHECK ((estrategia_id >= 0)),
    CONSTRAINT estrategias_prontuarios_prontuario_id_check CHECK ((prontuario_id >= 0))
);


ALTER TABLE public.estrategias_prontuarios OWNER TO juniordias;

--
-- TOC entry 1587 (class 1259 OID 95448727)
-- Dependencies: 6
-- Name: seq_faixa_etaria; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_faixa_etaria
    START WITH 82
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_faixa_etaria OWNER TO juniordias;

--
-- TOC entry 1588 (class 1259 OID 95448729)
-- Dependencies: 1954 6
-- Name: faixas_etarias; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE faixas_etarias (
    id integer DEFAULT nextval('seq_faixa_etaria'::regclass) NOT NULL,
    idade integer NOT NULL,
    descricao character varying(20) NOT NULL,
    faixa character varying(20) NOT NULL
);


ALTER TABLE public.faixas_etarias OWNER TO juniordias;

--
-- TOC entry 1589 (class 1259 OID 95448733)
-- Dependencies: 6
-- Name: seq_indicador; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_indicador
    START WITH 45
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_indicador OWNER TO juniordias;

--
-- TOC entry 1590 (class 1259 OID 95448735)
-- Dependencies: 1955 1956 6
-- Name: indicadores; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE indicadores (
    id integer DEFAULT nextval('seq_indicador'::regclass) NOT NULL,
    dimensao_id integer NOT NULL,
    codigo character varying(5) NOT NULL,
    descricao character varying(255) NOT NULL,
    label character varying(255) NOT NULL,
    coluna character varying(3) NOT NULL,
    CONSTRAINT indicadores_dimensao_id_check CHECK ((dimensao_id >= 0))
);


ALTER TABLE public.indicadores OWNER TO juniordias;

--
-- TOC entry 1591 (class 1259 OID 95448743)
-- Dependencies: 6
-- Name: seq_indicador_prontuario; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_indicador_prontuario
    START WITH 340
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_indicador_prontuario OWNER TO juniordias;

--
-- TOC entry 1592 (class 1259 OID 95448745)
-- Dependencies: 1957 1958 1959 6
-- Name: indicadores_prontuarios; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE indicadores_prontuarios (
    id integer DEFAULT nextval('seq_indicador_prontuario'::regclass) NOT NULL,
    indicador_id integer NOT NULL,
    prontuario_id integer NOT NULL,
    CONSTRAINT indicadores_prontuarios_indicador_id_check CHECK ((indicador_id >= 0)),
    CONSTRAINT indicadores_prontuarios_prontuario_id_check CHECK ((prontuario_id >= 0))
);


ALTER TABLE public.indicadores_prontuarios OWNER TO juniordias;

--
-- TOC entry 1593 (class 1259 OID 95448751)
-- Dependencies: 6
-- Name: indices; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE indices (
    codigo_domiciliar character varying(12) NOT NULL,
    idf numeric(3,2),
    vulnerabilidade double precision,
    gestacao double precision,
    v1 smallint,
    v2 smallint,
    criancas double precision,
    v3 smallint,
    v4 smallint,
    v5 smallint,
    idosos double precision,
    v6 smallint,
    v7 smallint,
    dependencia double precision,
    v8 smallint,
    v9 smallint,
    conhecimento double precision,
    analfabetismo double precision,
    c1 smallint,
    c2 smallint,
    escolaridade double precision,
    c3 smallint,
    c4 smallint,
    c5 smallint,
    trabalho double precision,
    disponibilidade double precision,
    t1 smallint,
    qualidade double precision,
    t2 smallint,
    t3 smallint,
    remuneracao double precision,
    t4 smallint,
    t5 smallint,
    recursos double precision,
    extremapobreza double precision,
    r1 smallint,
    r2 smallint,
    r3 smallint,
    pobreza double precision,
    r4 smallint,
    r5 smallint,
    capacidadegeracao double precision,
    r6 smallint,
    desenvolvimento double precision,
    trabalhoprecoce double precision,
    d1 smallint,
    d2 smallint,
    acessoescola double precision,
    d3 smallint,
    d4 smallint,
    d5 smallint,
    progressoescolar double precision,
    d6 smallint,
    d7 smallint,
    d8 smallint,
    habitacao double precision,
    propriedade double precision,
    h1 smallint,
    h2 smallint,
    deficit double precision,
    h3 smallint,
    abrigalidade double precision,
    h4 smallint,
    acessoagua double precision,
    h5 smallint,
    acessosaneamento double precision,
    h6 smallint,
    acessocoletalixo double precision,
    h7 smallint,
    acessoeletricidade double precision,
    h8 smallint,
    v10 smallint,
    v11 smallint,
    v12 smallint,
    modified timestamp without time zone
);


ALTER TABLE public.indices OWNER TO juniordias;

--
-- TOC entry 1594 (class 1259 OID 95448754)
-- Dependencies: 6
-- Name: seq_indice_historico; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_indice_historico
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_indice_historico OWNER TO juniordias;

--
-- TOC entry 1595 (class 1259 OID 95448756)
-- Dependencies: 1960 6
-- Name: indices_historicos; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE indices_historicos (
    id integer DEFAULT nextval('seq_indice_historico'::regclass) NOT NULL,
    codigo_domiciliar character varying(12) NOT NULL,
    idf numeric(3,2),
    vulnerabilidade double precision,
    v1 smallint,
    v2 smallint,
    v3 smallint,
    v4 smallint,
    v5 smallint,
    v6 smallint,
    v7 smallint,
    v8 smallint,
    v9 smallint,
    conhecimento double precision,
    c1 smallint,
    c2 smallint,
    c3 smallint,
    c4 smallint,
    c5 smallint,
    trabalho double precision,
    t1 smallint,
    t2 smallint,
    t3 smallint,
    t4 smallint,
    t5 smallint,
    recursos double precision,
    r1 smallint,
    r2 smallint,
    r3 smallint,
    r4 smallint,
    r5 smallint,
    r6 smallint,
    desenvolvimento double precision,
    d1 smallint,
    d2 smallint,
    d3 smallint,
    d4 smallint,
    d5 smallint,
    d6 smallint,
    d7 smallint,
    d8 smallint,
    habyteaacao double precision,
    h1 smallint,
    h2 smallint,
    h3 smallint,
    h4 smallint,
    h5 smallint,
    h6 smallint,
    h7 smallint,
    h8 smallint,
    v10 smallint,
    v11 smallint,
    v12 smallint,
    created timestamp without time zone
);


ALTER TABLE public.indices_historicos OWNER TO juniordias;

--
-- TOC entry 1596 (class 1259 OID 95448760)
-- Dependencies: 6
-- Name: seq_page; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_page
    START WITH 3
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_page OWNER TO juniordias;

--
-- TOC entry 1597 (class 1259 OID 95448762)
-- Dependencies: 1961 6
-- Name: pages; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE pages (
    id integer DEFAULT nextval('seq_page'::regclass) NOT NULL,
    link character varying(30) NOT NULL,
    titulo character varying(60) NOT NULL,
    conteudo text NOT NULL,
    created timestamp without time zone,
    modified timestamp without time zone
);


ALTER TABLE public.pages OWNER TO juniordias;

--
-- TOC entry 1598 (class 1259 OID 95448769)
-- Dependencies: 1962 1963 1964 1965 6
-- Name: parametros; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE parametros (
    id integer NOT NULL,
    descricao character varying(40) DEFAULT NULL::character varying,
    "default" character varying(20) DEFAULT NULL::character varying,
    controller character varying(30) DEFAULT NULL::character varying,
    action character varying(30) DEFAULT NULL::character varying
);


ALTER TABLE public.parametros OWNER TO juniordias;

--
-- TOC entry 1599 (class 1259 OID 95448776)
-- Dependencies: 6
-- Name: seq_parametro_usuario; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_parametro_usuario
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_parametro_usuario OWNER TO juniordias;

--
-- TOC entry 1600 (class 1259 OID 95448778)
-- Dependencies: 1966 1967 6
-- Name: parametros_usuarios; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE parametros_usuarios (
    id integer DEFAULT nextval('seq_parametro_usuario'::regclass) NOT NULL,
    parametro_id integer NOT NULL,
    usuario_id integer NOT NULL,
    valor character varying(20) DEFAULT NULL::character varying
);


ALTER TABLE public.parametros_usuarios OWNER TO juniordias;

--
-- TOC entry 1601 (class 1259 OID 95448783)
-- Dependencies: 1968 1969 1970 1971 1972 1973 1974 1975 1976 1977 1978 1979 1980 1981 1982 1983 1984 1985 1986 1987 1988 1989 1990 1991 1992 1993 1994 1995 1996 1997 6
-- Name: pessoas; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE pessoas (
    nis character varying(15) NOT NULL,
    nome character varying(100) NOT NULL,
    codigo_domiciliar character varying(12) DEFAULT NULL::character varying,
    cpf character varying(14) DEFAULT NULL::character varying,
    titulo_eleitor character varying(18) DEFAULT NULL::character varying,
    zona character varying(10) DEFAULT NULL::character varying,
    secao character varying(10) DEFAULT NULL::character varying,
    ocupacao character varying(30) DEFAULT NULL::character varying,
    inep character varying(12) DEFAULT NULL::character varying,
    responsavel_nis character varying(15) DEFAULT NULL::character varying,
    responsavel_parentesco smallint,
    valor_remuneracao numeric(10,2) DEFAULT 0.00 NOT NULL,
    valor_aposentadoria numeric(10,2) DEFAULT 0.00 NOT NULL,
    valor_pensao numeric(10,2) DEFAULT 0.00 NOT NULL,
    valor_seguro_desemprego numeric(10,2) DEFAULT 0.00 NOT NULL,
    valor_beneficio numeric(10,2) DEFAULT 0.00 NOT NULL,
    data_nascimento date,
    serie_escolar smallint,
    tipo_trabalho smallint,
    raca_cor smallint,
    genero smallint,
    estado_civil smallint,
    grau_instrucao smallint,
    tipo_escola smallint,
    observacoes text,
    data_pesquisa date,
    data_inclusao date,
    data_atualizacao date,
    entrevistador character varying(60) DEFAULT NULL::character varying,
    valor_outras_rendas numeric(10,2) DEFAULT 0.00,
    mes_gestacao smallint,
    amamentando smallint DEFAULT (0)::smallint NOT NULL,
    cegueira smallint DEFAULT (0)::smallint NOT NULL,
    surdez smallint DEFAULT (0)::smallint NOT NULL,
    mudez smallint DEFAULT (0)::smallint NOT NULL,
    deficiencia_mental smallint DEFAULT (0)::smallint NOT NULL,
    deficiencia_fisica smallint DEFAULT (0)::smallint NOT NULL,
    outra_deficiencia smallint DEFAULT (0)::smallint NOT NULL,
    portador_deficiencia smallint DEFAULT (0)::smallint NOT NULL,
    esposa_companheiro smallint DEFAULT (0)::smallint NOT NULL,
    valor_somatorio_renda numeric(10,2),
    CONSTRAINT pessoas_estado_civil_check CHECK ((estado_civil >= 0)),
    CONSTRAINT pessoas_grau_instrucao_check CHECK ((grau_instrucao >= 0)),
    CONSTRAINT pessoas_raca_cor_check CHECK ((raca_cor >= 0)),
    CONSTRAINT pessoas_serie_escolar_check CHECK ((serie_escolar >= 0)),
    CONSTRAINT pessoas_tipo_escola_check CHECK ((tipo_escola >= 0)),
    CONSTRAINT pessoas_tipo_trabalho_check CHECK ((tipo_trabalho >= 0))
);


ALTER TABLE public.pessoas OWNER TO juniordias;

--
-- TOC entry 1602 (class 1259 OID 95448819)
-- Dependencies: 6
-- Name: seq_pessoa_servico; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_pessoa_servico
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_pessoa_servico OWNER TO juniordias;

--
-- TOC entry 1603 (class 1259 OID 95448821)
-- Dependencies: 1998 6
-- Name: pessoas_servicos; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE pessoas_servicos (
    id integer DEFAULT nextval('seq_pessoa_servico'::regclass) NOT NULL,
    pessoa_nis character varying(15) NOT NULL,
    servico_id integer NOT NULL
);


ALTER TABLE public.pessoas_servicos OWNER TO juniordias;

--
-- TOC entry 1604 (class 1259 OID 95448825)
-- Dependencies: 6
-- Name: seq_prontuario; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_prontuario
    START WITH 23
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_prontuario OWNER TO juniordias;

--
-- TOC entry 1605 (class 1259 OID 95448827)
-- Dependencies: 1999 2000 6
-- Name: prontuarios; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE prontuarios (
    id integer DEFAULT nextval('seq_prontuario'::regclass) NOT NULL,
    codigo_domiciliar character varying(12) NOT NULL,
    numero_prontuario integer NOT NULL,
    usuario_id integer NOT NULL,
    created timestamp without time zone NOT NULL,
    CONSTRAINT prontuarios_numero_prontuario_check CHECK ((numero_prontuario >= 0))
);


ALTER TABLE public.prontuarios OWNER TO juniordias;

--
-- TOC entry 1606 (class 1259 OID 95448832)
-- Dependencies: 6
-- Name: seq_regiao; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_regiao
    START WITH 9
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_regiao OWNER TO juniordias;

--
-- TOC entry 1607 (class 1259 OID 95448834)
-- Dependencies: 2001 6
-- Name: regioes; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE regioes (
    id integer DEFAULT nextval('seq_regiao'::regclass) NOT NULL,
    descricao character varying(30) NOT NULL
);


ALTER TABLE public.regioes OWNER TO juniordias;

--
-- TOC entry 1608 (class 1259 OID 95448838)
-- Dependencies: 6
-- Name: seq_acesso; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_acesso
    START WITH 264
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_acesso OWNER TO juniordias;

--
-- TOC entry 1609 (class 1259 OID 95448840)
-- Dependencies: 6
-- Name: seq_grupo; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_grupo
    START WITH 2
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_grupo OWNER TO juniordias;

--
-- TOC entry 1610 (class 1259 OID 95448842)
-- Dependencies: 6
-- Name: seq_permissao; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_permissao
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_permissao OWNER TO juniordias;

--
-- TOC entry 1611 (class 1259 OID 95448844)
-- Dependencies: 6
-- Name: seq_servico; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_servico
    START WITH 19
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_servico OWNER TO juniordias;

--
-- TOC entry 1612 (class 1259 OID 95448846)
-- Dependencies: 6
-- Name: seq_usuario; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_usuario
    START WITH 18
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_usuario OWNER TO juniordias;

--
-- TOC entry 1613 (class 1259 OID 95448848)
-- Dependencies: 6
-- Name: seq_visita; Type: SEQUENCE; Schema: public; Owner: juniordias
--

CREATE SEQUENCE seq_visita
    START WITH 1
    INCREMENT BY 1
    NO MAXVALUE
    NO MINVALUE
    CACHE 1;


ALTER TABLE public.seq_visita OWNER TO juniordias;

--
-- TOC entry 1614 (class 1259 OID 95448850)
-- Dependencies: 2002 2003 2004 2005 2006 6
-- Name: servicos; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE servicos (
    id integer DEFAULT nextval('seq_servico'::regclass) NOT NULL,
    tipo_servico smallint,
    descricao character varying(60) DEFAULT NULL::character varying,
    descricao_detalhada character varying(200) DEFAULT NULL::character varying,
    faixa_etaria character varying(60) DEFAULT NULL::character varying,
    horario character varying(40) DEFAULT NULL::character varying,
    per_capita double precision,
    capacidade integer
);


ALTER TABLE public.servicos OWNER TO juniordias;

--
-- TOC entry 1615 (class 1259 OID 95448858)
-- Dependencies: 2007 2008 6
-- Name: tb_acesso; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE tb_acesso (
    id_acesso integer DEFAULT nextval('seq_acesso'::regclass) NOT NULL,
    id_usuario integer NOT NULL,
    cod_ip character varying(15) DEFAULT NULL::character varying,
    dt_login timestamp without time zone
);


ALTER TABLE public.tb_acesso OWNER TO juniordias;

--
-- TOC entry 1616 (class 1259 OID 95448863)
-- Dependencies: 2009 2010 6
-- Name: tb_permissao; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
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


ALTER TABLE public.tb_permissao OWNER TO juniordias;

--
-- TOC entry 1617 (class 1259 OID 95448867)
-- Dependencies: 2011 6
-- Name: usuarios; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE usuarios (
    id integer DEFAULT nextval('seq_usuario'::regclass) NOT NULL,
    nome character varying(50) NOT NULL,
    username character varying(20) NOT NULL,
    password character varying(64) NOT NULL,
    created timestamp without time zone,
    modified timestamp without time zone,
    id_grupo smallint
);


ALTER TABLE public.usuarios OWNER TO juniordias;

--
-- TOC entry 1618 (class 1259 OID 95448871)
-- Dependencies: 2012 2013 2014 6
-- Name: visitas; Type: TABLE; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE TABLE visitas (
    id integer DEFAULT nextval('seq_visita'::regclass) NOT NULL,
    usuario_id integer NOT NULL,
    prontuario_id integer NOT NULL,
    data date,
    observacoes character varying(1024) DEFAULT NULL::character varying,
    created timestamp without time zone,
    CONSTRAINT visitas_prontuario_id_check CHECK ((prontuario_id >= 0))
);


ALTER TABLE public.visitas OWNER TO juniordias;

--
-- TOC entry 2100 (class 2606 OID 95448881)
-- Dependencies: 1615 1615
-- Name: acessos_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY tb_acesso
    ADD CONSTRAINT acessos_pkey PRIMARY KEY (id_acesso);


--
-- TOC entry 2016 (class 2606 OID 95448883)
-- Dependencies: 1571 1571
-- Name: acoes_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY acoes
    ADD CONSTRAINT acoes_pkey PRIMARY KEY (id);


--
-- TOC entry 2019 (class 2606 OID 95448885)
-- Dependencies: 1573 1573
-- Name: bairros_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY bairros
    ADD CONSTRAINT bairros_pkey PRIMARY KEY (id);


--
-- TOC entry 2024 (class 2606 OID 95448887)
-- Dependencies: 1575 1575
-- Name: cras_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY cras
    ADD CONSTRAINT cras_pkey PRIMARY KEY (id);


--
-- TOC entry 2027 (class 2606 OID 95448889)
-- Dependencies: 1577 1577 1577 1577
-- Name: cras_usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY cras_usuarios
    ADD CONSTRAINT cras_usuarios_pkey PRIMARY KEY (id, cras_id, usuario_id);


--
-- TOC entry 2031 (class 2606 OID 95448891)
-- Dependencies: 1579 1579
-- Name: dimensoes_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY dimensoes
    ADD CONSTRAINT dimensoes_pkey PRIMARY KEY (id);


--
-- TOC entry 2033 (class 2606 OID 95448893)
-- Dependencies: 1580 1580
-- Name: domicilios_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY domicilios
    ADD CONSTRAINT domicilios_pkey PRIMARY KEY (codigo_domiciliar);


--
-- TOC entry 2044 (class 2606 OID 95448895)
-- Dependencies: 1584 1584 1584 1584
-- Name: estrategias_indicadores_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY estrategias_indicadores
    ADD CONSTRAINT estrategias_indicadores_pkey PRIMARY KEY (id, estrategia_id, indicador_id);


--
-- TOC entry 2040 (class 2606 OID 95448897)
-- Dependencies: 1582 1582
-- Name: estrategias_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY estrategias
    ADD CONSTRAINT estrategias_pkey PRIMARY KEY (id);


--
-- TOC entry 2047 (class 2606 OID 95448899)
-- Dependencies: 1586 1586 1586 1586
-- Name: estrategias_prontuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY estrategias_prontuarios
    ADD CONSTRAINT estrategias_prontuarios_pkey PRIMARY KEY (id, estrategia_id, prontuario_id);


--
-- TOC entry 2053 (class 2606 OID 95448901)
-- Dependencies: 1588 1588
-- Name: faixas_etarias_pk; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY faixas_etarias
    ADD CONSTRAINT faixas_etarias_pk PRIMARY KEY (id);


--
-- TOC entry 2055 (class 2606 OID 95448903)
-- Dependencies: 1590 1590
-- Name: indicadores_coluna_key; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY indicadores
    ADD CONSTRAINT indicadores_coluna_key UNIQUE (coluna);


--
-- TOC entry 2058 (class 2606 OID 95448905)
-- Dependencies: 1590 1590
-- Name: indicadores_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY indicadores
    ADD CONSTRAINT indicadores_pkey PRIMARY KEY (id);


--
-- TOC entry 2061 (class 2606 OID 95448907)
-- Dependencies: 1592 1592 1592 1592
-- Name: indicadores_prontuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY indicadores_prontuarios
    ADD CONSTRAINT indicadores_prontuarios_pkey PRIMARY KEY (id, indicador_id, prontuario_id);


--
-- TOC entry 2069 (class 2606 OID 95448909)
-- Dependencies: 1595 1595
-- Name: indices_historicos_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY indices_historicos
    ADD CONSTRAINT indices_historicos_pkey PRIMARY KEY (id);


--
-- TOC entry 2066 (class 2606 OID 95448911)
-- Dependencies: 1593 1593
-- Name: indices_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY indices
    ADD CONSTRAINT indices_pkey PRIMARY KEY (codigo_domiciliar);


--
-- TOC entry 2071 (class 2606 OID 95448913)
-- Dependencies: 1597 1597
-- Name: pages_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY pages
    ADD CONSTRAINT pages_pkey PRIMARY KEY (id);


--
-- TOC entry 2073 (class 2606 OID 95448915)
-- Dependencies: 1598 1598
-- Name: parametros_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY parametros
    ADD CONSTRAINT parametros_pkey PRIMARY KEY (id);


--
-- TOC entry 2076 (class 2606 OID 95448917)
-- Dependencies: 1600 1600 1600 1600
-- Name: parametros_usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY parametros_usuarios
    ADD CONSTRAINT parametros_usuarios_pkey PRIMARY KEY (id, parametro_id, usuario_id);


--
-- TOC entry 2085 (class 2606 OID 95448919)
-- Dependencies: 1601 1601
-- Name: pessoas_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY pessoas
    ADD CONSTRAINT pessoas_pkey PRIMARY KEY (nis);


--
-- TOC entry 2089 (class 2606 OID 95448921)
-- Dependencies: 1603 1603 1603 1603
-- Name: pessoas_servicos_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY pessoas_servicos
    ADD CONSTRAINT pessoas_servicos_pkey PRIMARY KEY (id, pessoa_nis, servico_id);


--
-- TOC entry 2103 (class 2606 OID 95448923)
-- Dependencies: 1616 1616
-- Name: pk_permissao; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY tb_permissao
    ADD CONSTRAINT pk_permissao PRIMARY KEY (id_permissao);


--
-- TOC entry 2093 (class 2606 OID 95448925)
-- Dependencies: 1605 1605
-- Name: prontuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY prontuarios
    ADD CONSTRAINT prontuarios_pkey PRIMARY KEY (id);


--
-- TOC entry 2096 (class 2606 OID 95448927)
-- Dependencies: 1607 1607
-- Name: regioes_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY regioes
    ADD CONSTRAINT regioes_pkey PRIMARY KEY (id);


--
-- TOC entry 2098 (class 2606 OID 95448929)
-- Dependencies: 1614 1614
-- Name: servicos_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY servicos
    ADD CONSTRAINT servicos_pkey PRIMARY KEY (id);


--
-- TOC entry 2105 (class 2606 OID 95448931)
-- Dependencies: 1617 1617
-- Name: usuarios_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT usuarios_pkey PRIMARY KEY (id);


--
-- TOC entry 2107 (class 2606 OID 95448933)
-- Dependencies: 1617 1617
-- Name: usuarios_username_key; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY usuarios
    ADD CONSTRAINT usuarios_username_key UNIQUE (username);


--
-- TOC entry 2109 (class 2606 OID 95448935)
-- Dependencies: 1618 1618
-- Name: visitas_pkey; Type: CONSTRAINT; Schema: public; Owner: juniordias; Tablespace: 
--

ALTER TABLE ONLY visitas
    ADD CONSTRAINT visitas_pkey PRIMARY KEY (id);


--
-- TOC entry 2022 (class 1259 OID 95448940)
-- Dependencies: 1575
-- Name: cras_bairro_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX cras_bairro_id_idx ON cras USING btree (bairro_id);


--
-- TOC entry 2025 (class 1259 OID 95448941)
-- Dependencies: 1575
-- Name: cras_regiao_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX cras_regiao_id_idx ON cras USING btree (regiao_id);


--
-- TOC entry 2034 (class 1259 OID 95448944)
-- Dependencies: 1580
-- Name: domicilios_regiao_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX domicilios_regiao_id_idx ON domicilios USING btree (regiao_id);


--
-- TOC entry 2041 (class 1259 OID 95448945)
-- Dependencies: 1584
-- Name: estrategias_indicadores_estrategia_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX estrategias_indicadores_estrategia_id_idx ON estrategias_indicadores USING btree (estrategia_id);


--
-- TOC entry 2042 (class 1259 OID 95448946)
-- Dependencies: 1584
-- Name: estrategias_indicadores_indicador_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX estrategias_indicadores_indicador_id_idx ON estrategias_indicadores USING btree (indicador_id);


--
-- TOC entry 2045 (class 1259 OID 95448947)
-- Dependencies: 1586
-- Name: estrategias_prontuarios_estrategia_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX estrategias_prontuarios_estrategia_id_idx ON estrategias_prontuarios USING btree (estrategia_id);


--
-- TOC entry 2048 (class 1259 OID 95448948)
-- Dependencies: 1586
-- Name: estrategias_prontuarios_prontuario_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX estrategias_prontuarios_prontuario_id_idx ON estrategias_prontuarios USING btree (prontuario_id);


--
-- TOC entry 2049 (class 1259 OID 95448949)
-- Dependencies: 1588
-- Name: faixas_etarias_descricao_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX faixas_etarias_descricao_idx ON faixas_etarias USING btree (descricao);


--
-- TOC entry 2050 (class 1259 OID 95448950)
-- Dependencies: 1588
-- Name: faixas_etarias_faixa_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX faixas_etarias_faixa_idx ON faixas_etarias USING btree (faixa);


--
-- TOC entry 2051 (class 1259 OID 95448951)
-- Dependencies: 1588
-- Name: faixas_etarias_idade_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX faixas_etarias_idade_idx ON faixas_etarias USING btree (idade);


--
-- TOC entry 2020 (class 1259 OID 95628866)
-- Dependencies: 1573
-- Name: fki_cras; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX fki_cras ON bairros USING btree (cras_id);


--
-- TOC entry 2028 (class 1259 OID 95628887)
-- Dependencies: 1577
-- Name: fki_cras2; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX fki_cras2 ON cras_usuarios USING btree (cras_id);


--
-- TOC entry 2035 (class 1259 OID 95448952)
-- Dependencies: 1580
-- Name: fki_domicilios_bairro; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX fki_domicilios_bairro ON domicilios USING btree (bairro_id);


--
-- TOC entry 2036 (class 1259 OID 95448953)
-- Dependencies: 1580
-- Name: fki_domicilios_cras; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX fki_domicilios_cras ON domicilios USING btree (cras_id);


--
-- TOC entry 2037 (class 1259 OID 95448954)
-- Dependencies: 1580
-- Name: fki_domicilios_regiao; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX fki_domicilios_regiao ON domicilios USING btree (regiao_id);


--
-- TOC entry 2038 (class 1259 OID 95448955)
-- Dependencies: 1580
-- Name: fki_domicilios_responsavel; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX fki_domicilios_responsavel ON domicilios USING btree (nis_responsavel);


--
-- TOC entry 2017 (class 1259 OID 95628854)
-- Dependencies: 1571
-- Name: fki_estrategia; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX fki_estrategia ON acoes USING btree (estrategia_id);


--
-- TOC entry 2078 (class 1259 OID 95448956)
-- Dependencies: 1601
-- Name: fki_pessoas_domicilios; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX fki_pessoas_domicilios ON pessoas USING btree (codigo_domiciliar);


--
-- TOC entry 2079 (class 1259 OID 95448957)
-- Dependencies: 1601
-- Name: fki_pessoas_responsavel; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX fki_pessoas_responsavel ON pessoas USING btree (nis);


--
-- TOC entry 2021 (class 1259 OID 95628860)
-- Dependencies: 1573
-- Name: fki_regiao; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX fki_regiao ON bairros USING btree (regiao_id);


--
-- TOC entry 2101 (class 1259 OID 95628848)
-- Dependencies: 1615
-- Name: fki_usuario; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX fki_usuario ON tb_acesso USING btree (id_usuario);


--
-- TOC entry 2029 (class 1259 OID 95628916)
-- Dependencies: 1577
-- Name: fki_usuario2; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX fki_usuario2 ON cras_usuarios USING btree (usuario_id);


--
-- TOC entry 2056 (class 1259 OID 95448958)
-- Dependencies: 1590
-- Name: indicadores_dimensao_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX indicadores_dimensao_id_idx ON indicadores USING btree (dimensao_id);


--
-- TOC entry 2059 (class 1259 OID 95448959)
-- Dependencies: 1592
-- Name: indicadores_prontuarios_indicador_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX indicadores_prontuarios_indicador_id_idx ON indicadores_prontuarios USING btree (indicador_id);


--
-- TOC entry 2062 (class 1259 OID 95448960)
-- Dependencies: 1592
-- Name: indicadores_prontuarios_prontuario_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX indicadores_prontuarios_prontuario_id_idx ON indicadores_prontuarios USING btree (prontuario_id);


--
-- TOC entry 2067 (class 1259 OID 95448961)
-- Dependencies: 1595
-- Name: indices_historicos_codigo_domiciliar_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX indices_historicos_codigo_domiciliar_idx ON indices_historicos USING btree (codigo_domiciliar);


--
-- TOC entry 2063 (class 1259 OID 95448962)
-- Dependencies: 1593
-- Name: indices_idf_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX indices_idf_idx ON indices USING btree (idf);


--
-- TOC entry 2064 (class 1259 OID 95448963)
-- Dependencies: 1593
-- Name: indices_modified_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX indices_modified_idx ON indices USING btree (modified);


--
-- TOC entry 2074 (class 1259 OID 95448964)
-- Dependencies: 1600
-- Name: parametros_usuarios_parametro_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX parametros_usuarios_parametro_id_idx ON parametros_usuarios USING btree (parametro_id);


--
-- TOC entry 2077 (class 1259 OID 95448965)
-- Dependencies: 1600
-- Name: parametros_usuarios_usuario_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX parametros_usuarios_usuario_id_idx ON parametros_usuarios USING btree (usuario_id);


--
-- TOC entry 2080 (class 1259 OID 95448966)
-- Dependencies: 1601
-- Name: pessoas_codigo_domiciliar_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX pessoas_codigo_domiciliar_idx ON pessoas USING btree (codigo_domiciliar);


--
-- TOC entry 2081 (class 1259 OID 95448967)
-- Dependencies: 1601
-- Name: pessoas_data_nascimento_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX pessoas_data_nascimento_idx ON pessoas USING btree (data_nascimento);


--
-- TOC entry 2082 (class 1259 OID 95448968)
-- Dependencies: 1601
-- Name: pessoas_genero_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX pessoas_genero_idx ON pessoas USING btree (genero);


--
-- TOC entry 2083 (class 1259 OID 95448969)
-- Dependencies: 1601
-- Name: pessoas_grau_instrucao_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX pessoas_grau_instrucao_idx ON pessoas USING btree (grau_instrucao);


--
-- TOC entry 2086 (class 1259 OID 95448970)
-- Dependencies: 1601
-- Name: pessoas_responsavel_nis_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX pessoas_responsavel_nis_idx ON pessoas USING btree (responsavel_nis);


--
-- TOC entry 2087 (class 1259 OID 95448971)
-- Dependencies: 1603
-- Name: pessoas_servicos_pessoa_nis_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX pessoas_servicos_pessoa_nis_idx ON pessoas_servicos USING btree (pessoa_nis);


--
-- TOC entry 2090 (class 1259 OID 95448972)
-- Dependencies: 1603
-- Name: pessoas_servicos_servico_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX pessoas_servicos_servico_id_idx ON pessoas_servicos USING btree (servico_id);


--
-- TOC entry 2091 (class 1259 OID 95448973)
-- Dependencies: 1605
-- Name: prontuarios_codigo_domiciliar_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX prontuarios_codigo_domiciliar_idx ON prontuarios USING btree (codigo_domiciliar);


--
-- TOC entry 2094 (class 1259 OID 95448974)
-- Dependencies: 1605
-- Name: prontuarios_usuario_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX prontuarios_usuario_id_idx ON prontuarios USING btree (usuario_id);


--
-- TOC entry 2110 (class 1259 OID 95448975)
-- Dependencies: 1618
-- Name: visitas_prontuario_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX visitas_prontuario_id_idx ON visitas USING btree (prontuario_id);


--
-- TOC entry 2111 (class 1259 OID 95448976)
-- Dependencies: 1618
-- Name: visitas_usuario_id_idx; Type: INDEX; Schema: public; Owner: juniordias; Tablespace: 
--

CREATE INDEX visitas_usuario_id_idx ON visitas USING btree (usuario_id);


--
-- TOC entry 2114 (class 2606 OID 95628867)
-- Dependencies: 1575 1573 2018
-- Name: fk_bairro; Type: FK CONSTRAINT; Schema: public; Owner: juniordias
--

ALTER TABLE ONLY cras
    ADD CONSTRAINT fk_bairro FOREIGN KEY (bairro_id) REFERENCES bairros(id);


--
-- TOC entry 2116 (class 2606 OID 95628882)
-- Dependencies: 1577 2023 1575
-- Name: fk_cras; Type: FK CONSTRAINT; Schema: public; Owner: juniordias
--

ALTER TABLE ONLY cras_usuarios
    ADD CONSTRAINT fk_cras FOREIGN KEY (cras_id) REFERENCES cras(id);


--
-- TOC entry 2118 (class 2606 OID 95448977)
-- Dependencies: 1573 1580 2018
-- Name: fk_domicilios_bairro; Type: FK CONSTRAINT; Schema: public; Owner: juniordias
--

ALTER TABLE ONLY domicilios
    ADD CONSTRAINT fk_domicilios_bairro FOREIGN KEY (bairro_id) REFERENCES bairros(id);


--
-- TOC entry 2119 (class 2606 OID 95448982)
-- Dependencies: 1575 2023 1580
-- Name: fk_domicilios_cras; Type: FK CONSTRAINT; Schema: public; Owner: juniordias
--

ALTER TABLE ONLY domicilios
    ADD CONSTRAINT fk_domicilios_cras FOREIGN KEY (cras_id) REFERENCES cras(id);


--
-- TOC entry 2120 (class 2606 OID 95448987)
-- Dependencies: 1607 2095 1580
-- Name: fk_domicilios_regioes; Type: FK CONSTRAINT; Schema: public; Owner: juniordias
--

ALTER TABLE ONLY domicilios
    ADD CONSTRAINT fk_domicilios_regioes FOREIGN KEY (regiao_id) REFERENCES regioes(id);


--
-- TOC entry 2121 (class 2606 OID 95448992)
-- Dependencies: 2084 1580 1601
-- Name: fk_domicilios_responsavel; Type: FK CONSTRAINT; Schema: public; Owner: juniordias
--

ALTER TABLE ONLY domicilios
    ADD CONSTRAINT fk_domicilios_responsavel FOREIGN KEY (nis_responsavel) REFERENCES pessoas(nis);


--
-- TOC entry 2112 (class 2606 OID 95628849)
-- Dependencies: 1571 1582 2039
-- Name: fk_estrategia; Type: FK CONSTRAINT; Schema: public; Owner: juniordias
--

ALTER TABLE ONLY acoes
    ADD CONSTRAINT fk_estrategia FOREIGN KEY (estrategia_id) REFERENCES estrategias(id);


--
-- TOC entry 2122 (class 2606 OID 95448997)
-- Dependencies: 1580 1593 2032
-- Name: fk_indices_domicilios; Type: FK CONSTRAINT; Schema: public; Owner: juniordias
--

ALTER TABLE ONLY indices
    ADD CONSTRAINT fk_indices_domicilios FOREIGN KEY (codigo_domiciliar) REFERENCES domicilios(codigo_domiciliar);


--
-- TOC entry 2123 (class 2606 OID 95449002)
-- Dependencies: 1601 1580 2032
-- Name: fk_pessoas_domicilios; Type: FK CONSTRAINT; Schema: public; Owner: juniordias
--

ALTER TABLE ONLY pessoas
    ADD CONSTRAINT fk_pessoas_domicilios FOREIGN KEY (codigo_domiciliar) REFERENCES domicilios(codigo_domiciliar);


--
-- TOC entry 2124 (class 2606 OID 95449007)
-- Dependencies: 1601 2084 1601
-- Name: fk_pessoas_responsavel; Type: FK CONSTRAINT; Schema: public; Owner: juniordias
--

ALTER TABLE ONLY pessoas
    ADD CONSTRAINT fk_pessoas_responsavel FOREIGN KEY (nis) REFERENCES pessoas(nis);


--
-- TOC entry 2113 (class 2606 OID 95628855)
-- Dependencies: 2095 1607 1573
-- Name: fk_regiao; Type: FK CONSTRAINT; Schema: public; Owner: juniordias
--

ALTER TABLE ONLY bairros
    ADD CONSTRAINT fk_regiao FOREIGN KEY (regiao_id) REFERENCES regioes(id);


--
-- TOC entry 2115 (class 2606 OID 95628872)
-- Dependencies: 1607 2095 1575
-- Name: fk_regiao; Type: FK CONSTRAINT; Schema: public; Owner: juniordias
--

ALTER TABLE ONLY cras
    ADD CONSTRAINT fk_regiao FOREIGN KEY (regiao_id) REFERENCES regioes(id);


--
-- TOC entry 2125 (class 2606 OID 95628843)
-- Dependencies: 1617 2104 1615
-- Name: fk_usuario; Type: FK CONSTRAINT; Schema: public; Owner: juniordias
--

ALTER TABLE ONLY tb_acesso
    ADD CONSTRAINT fk_usuario FOREIGN KEY (id_usuario) REFERENCES usuarios(id);


--
-- TOC entry 2117 (class 2606 OID 95628911)
-- Dependencies: 2104 1617 1577
-- Name: fk_usuario; Type: FK CONSTRAINT; Schema: public; Owner: juniordias
--

ALTER TABLE ONLY cras_usuarios
    ADD CONSTRAINT fk_usuario FOREIGN KEY (usuario_id) REFERENCES usuarios(id);


--
-- TOC entry 2129 (class 0 OID 0)
-- Dependencies: 6
-- Name: public; Type: ACL; Schema: -; Owner: juniordias
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM juniordias;
GRANT ALL ON SCHEMA public TO juniordias;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2012-10-03 02:15:28

--
-- PostgreSQL database dump complete
--

