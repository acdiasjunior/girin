-- PESSOAS
SELECT
	p.co_nis AS nis, d.nu_domiciliar AS codigo_domiciliar, p.no_pessoa AS nome, p.dt_nascimento AS data_nascimento, p.co_cpf AS cpf,
        p.de_titulo_eleitor AS titulo_eleitor, p.de_zona_titulo_eleitor AS zona, p.de_secao_titulo_eleitor AS secao, o.de_ocupacao AS ocupacao,
        p.nu_inep_escola AS inep, r.co_nis AS responsavel_nis, COALESCE(p.ic_parentesco_responsavel,20) AS reponsavel_parentesco,
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
		WHEN p.dt_alteracao_pessoa = '1899-12-30' THEN NULL
		ELSE p.dt_alteracao_pessoa
	END) AS data_atualizacao,
	(CASE
		WHEN p.dt_inclusao_pessoa = '1899-12-30' THEN NULL
		ELSE p.dt_inclusao_pessoa
	END) AS data_inclusao,
        (CASE
            WHEN p.nu_ordem_esposa_companheiro <> 99 THEN 1
            ELSE 0
         END) AS esposa_companheiro,
         p.dt_exclusao_pessoa AS data_exclusao
FROM cubtb027_pessoa AS p
LEFT JOIN
	cubtb027_pessoa AS r
	ON p.nu_pessoa = r.nu_pessoa
INNER JOIN
	cubtb013_domicilio AS d
	ON p.co_domicilio = d.co_domicilio
LEFT JOIN
	cubtb038_ocupacao AS o
	ON p.co_ocupacao = o.co_ocupacao
WHERE
    p.dt_alteracao_pessoa > (now() - interval '2 YEAR') AND
    p.co_nis IS NOT NULL AND
    (p.dt_exclusao_pessoa = '1899-12-30' OR
    p.dt_exclusao_pessoa IS NULL) AND
    p.nu_pessoa IN (
        SELECT DISTINCT ON (id) u.id FROM
            ((SELECT
                DISTINCT ON (c.co_cpf) c.nu_pessoa AS id
                FROM cubtb027_pessoa AS c
                ORDER BY c.co_cpf, c.dt_alteracao_pessoa DESC)
            UNION
            (SELECT
                d.nu_pessoa AS id
                FROM cubtb027_pessoa AS d
                WHERE d.co_cpf IS NULL)) AS u
        )
