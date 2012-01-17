-- PESSOAS
SELECT
	p.co_nis AS nis, p.no_pessoa AS nome, p.dt_nascimento AS data_nascimento, p.co_cpf AS cpf, p.de_titulo_eleitor AS titulo_eleitor,
	p.de_zona_titulo_eleitor AS zona, p.de_secao_titulo_eleitor AS secao, o.de_ocupacao AS ocupacao, p.nu_inep_escola AS inep,
	(CASE
		WHEN p.dt_alteracao_pessoa = '1899-12-30' THEN NULL
		ELSE p.dt_alteracao_pessoa
	END) AS data_atualizacao,
	(CASE
		WHEN p.dt_inclusao_pessoa = '1899-12-30' THEN NULL
		ELSE p.dt_inclusao_pessoa
	END) AS data_inclusao,
	d.nu_domiciliar,
	r.co_nis AS responsavel_nis, p.ic_parentesco_responsavel AS reponsavel_parentesco, p.vr_renda_aposentadoria AS valor_aposentadoria,
	p.vr_renda_seguro_desemprego AS valor_seguro_desemprego,
	p.vr_renda_pensao AS valor_pensao, p.vr_outras_rendas AS valor_renda, p.ic_serie_escolar AS serie_escolar, p.ic_grau_instrucao AS grau_instrucao,
	p.ic_tipo_escola AS tipo_escola, p.ic_sexo AS genero, p.ic_raca_cor AS raca_cor, p.ic_estado_civil AS estado_civil,
	p.nu_mes_gestacao AS mes_gestacao, p.ic_amamentando AS amamentando, p.ic_cegueira AS cegueira, p.ic_mudez AS mudez, p.ic_surdez AS surdez,
        p.ic_deficiencia_mental AS deficiencia_mental, p.ic_deficiencia_fisica AS deficiencia_fisica, p.ic_outra_deficiencia AS outra_deficiencia,
        (CASE
            WHEN p.ic_sem_deficiencia = '0' THEN 1
            ELSE 0
         END) AS portador_deficiencia,
        (CASE
            WHEN p.nu_ordem_esposa_companheiro <> 99 THEN 1
            ELSE 0
         END) AS esposa_companheiro
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