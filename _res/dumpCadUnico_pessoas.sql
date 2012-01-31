-- PESSOAS
SELECT
    p.co_nis AS nis, d.nu_domiciliar AS codigo_domiciliar, p.no_pessoa AS nome, p.co_cpf AS cpf,
    p.de_titulo_eleitor AS titulo_eleitor, p.de_zona_titulo_eleitor AS zona, p.de_secao_titulo_eleitor AS secao,
    o.de_ocupacao AS ocupacao, p.ic_situacao_mercado AS tipo_trabalho,
    (CASE
        WHEN p.dt_nascimento = '1899-12-30' THEN '00/00/0000'
        ELSE to_char(p.dt_nascimento, 'DD/MM/YYYY')
    END) AS data_nascimento,
    p.nu_inep_escola AS inep, r.co_nis AS responsavel_nis, COALESCE(p.ic_parentesco_responsavel,20) AS responsavel_parentesco,
    COALESCE(p.vr_remuneracao,0) AS valor_remuneracao,
    COALESCE(p.vr_renda_aposentadoria,0) AS valor_aposentadoria, COALESCE(p.vr_renda_seguro_desemprego,0) AS valor_seguro_desemprego,
    COALESCE(p.vr_renda_pensao,0) AS valor_pensao, COALESCE(p.vr_outras_rendas,0) AS valor_outras_rendas,
    COALESCE(p.ic_serie_escolar,0) AS serie_escolar, COALESCE(p.ic_grau_instrucao,0) AS grau_instrucao,
    COALESCE(p.ic_tipo_escola,0) AS tipo_escola, p.ic_sexo AS genero, p.ic_raca_cor AS raca_cor, p.ic_estado_civil AS estado_civil,
    COALESCE(p.nu_mes_gestacao,0) AS mes_gestacao,
    (CASE
        WHEN p.ic_amamentando IS NULL THEN 0
        WHEN p.ic_amamentando = '2' THEN 0
        ELSE 1
    END) AS amamentando,
    p.ic_cegueira AS cegueira, p.ic_mudez AS mudez, p.ic_surdez AS surdez,
    p.ic_deficiencia_mental AS deficiencia_mental, p.ic_deficiencia_fisica AS deficiencia_fisica, p.ic_outra_deficiencia AS outra_deficiencia,
    (CASE
        WHEN p.ic_sem_deficiencia = '0' THEN 1
        ELSE 0
     END) AS portador_deficiencia,
    (CASE
        WHEN p.dt_alteracao_pessoa = '1899-12-30' THEN '00/00/0000'
        ELSE to_char(p.dt_alteracao_pessoa, 'DD/MM/YYYY')
    END) AS data_atualizacao,
    (CASE
        WHEN p.dt_inclusao_pessoa = '1899-12-30' THEN '00/00/0000'
        ELSE to_char(p.dt_inclusao_pessoa, 'DD/MM/YYYY')
    END) AS data_inclusao,
    (CASE
        WHEN p.nu_ordem_esposa_companheiro <> 99 THEN 1
        ELSE 0
     END) AS esposa_companheiro
FROM cubtb027_pessoa AS p
LEFT JOIN
    cubtb027_pessoa AS r
    ON p.nu_responsavel = r.nu_pessoa
INNER JOIN
    cubtb013_domicilio AS d
    ON p.co_domicilio = d.co_domicilio
LEFT JOIN
    cubtb038_ocupacao AS o
    ON p.co_ocupacao = o.co_ocupacao
WHERE
    p.co_domicilio IN
    (SELECT d.co_domicilio FROM cubtb013_domicilio AS d
        WHERE d.dt_pesquisa >= '2009-09-01'
            AND (d.dt_exclusao_domicilio = '1899-12-30' OR d.dt_exclusao_domicilio IS NULL)
            AND d.qt_pessoas > 0
            AND d.ic_situacao_cadastral = 'A'
            AND d.ic_domicilio_valido = 't'
            AND TRIM(d.no_logradouro_domicilio) <> '' AND d.no_logradouro_domicilio IS NOT NULL
            AND (SELECT COUNT(*) FROM cubtb027_pessoa p WHERE p.co_domicilio = d.co_domicilio) = d.qt_pessoas
    )
    AND p.co_nis IS NOT NULL
    AND (p.dt_exclusao_pessoa = '1899-12-30' OR p.dt_exclusao_pessoa IS NULL)