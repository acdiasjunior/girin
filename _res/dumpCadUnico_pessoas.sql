-- PESSOAS
INSERT INTO tb_pessoa (cod_nis, cod_domiciliar, nome, cpf, teleitor_num, teleitor_zona,
                        teleitor_secao, desc_ocupacao, tp_trabalho, dt_nasc, cod_inep, cod_nis_responsavel,
                        tp_pararentesco_responsavel, vlr_remuneracao, vlr_aposentadoria, vlr_seguro_desemprego, 
                        vlr_pensao, vlr_outra_renda, serie_escolar, grau_instrucao, tp_escola, sexo, raca, est_civil,
                        qtd_mes_gestacao, amamentando, cegueira, mudez, surdez, deficiencia_mental, deficiencia_fisica, 
                        outra_deficiencia, portador_deficiencia, dt_atualizacao, dt_inclusao, esposa_companheiro)
SELECT t.* FROM
(SELECT
    DISTINCT ON (p.co_nis) p.co_nis AS cod_nis, d.nu_domiciliar AS cod_domiciliar, p.no_pessoa AS nome, p.co_cpf AS cpf,
    p.de_titulo_eleitor AS teleitor_num, p.de_zona_titulo_eleitor AS teleitor_zona, p.de_secao_titulo_eleitor AS teleitor_secao,
    substring(o.de_ocupacao FROM 1 FOR 30) AS desc_ocupacao, p.ic_situacao_mercado AS tp_trabalho,
    (CASE
        WHEN p.dt_nascimento = '1899-12-30' THEN NULL
        ELSE p.dt_nascimento
    END) AS dt_nasc,
    p.nu_inep_escola AS cod_inep, r.co_nis AS cod_nis_responsavel, COALESCE(p.ic_parentesco_responsavel,20) AS tp_pararentesco_responsavel,
    COALESCE(p.vr_remuneracao,0) AS vlr_remuneracao,
    COALESCE(p.vr_renda_aposentadoria,0) AS vlr_aposentadoria, COALESCE(p.vr_renda_seguro_desemprego,0) AS vlr_seguro_desemprego,
    COALESCE(p.vr_renda_pensao,0) AS vlr_pensao, COALESCE(p.vr_outras_rendas,0) AS vlr_outra_renda,
    COALESCE(p.ic_serie_escolar,0) AS serie_escolar, COALESCE(p.ic_grau_instrucao,0) AS grau_instrucao,
    COALESCE(p.ic_tipo_escola,0) AS tp_escola, to_number(p.ic_sexo, '9') AS sexo, p.ic_raca_cor AS raca, p.ic_estado_civil AS est_civil,
    COALESCE(p.nu_mes_gestacao,0) AS qtd_mes_gestacao,
    (CASE
        WHEN p.ic_amamentando IS NULL THEN 0
        WHEN p.ic_amamentando = '2' THEN 0
        ELSE 1
    END) AS amamentando,
    to_number(p.ic_cegueira, '9') AS cegueira, to_number(p.ic_mudez, '9') AS mudez, to_number(p.ic_surdez, '9') AS surdez,
    to_number(p.ic_deficiencia_mental, '9') AS deficiencia_mental, to_number(p.ic_deficiencia_fisica, '9') AS deficiencia_fisica, to_number(p.ic_outra_deficiencia, '9') AS outra_deficiencia,
    (CASE
        WHEN p.ic_sem_deficiencia = '0' THEN 1
        ELSE 0
     END) AS portador_deficiencia,
    (CASE
        WHEN p.dt_alteracao_pessoa = '1899-12-30' THEN NULL
        ELSE p.dt_alteracao_pessoa
    END) AS dt_atualizacao,
    (CASE
        WHEN p.dt_inclusao_pessoa = '1899-12-30' THEN NULL
        ELSE p.dt_inclusao_pessoa
    END) AS dt_inclusao,
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
    d.nu_domiciliar IN (SELECT DISTINCT(td.cod_domiciliar::numeric) FROM tb_domicilio td)
    AND p.co_nis IS NOT NULL
    AND (p.dt_exclusao_pessoa = '1899-12-30' OR p.dt_exclusao_pessoa IS NULL)
    AND p.no_pessoa IS NOT NULL
) AS t