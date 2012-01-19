-- PESSOAS
SELECT
	p.co_nis AS nis, d.nu_domiciliar AS codigo_domiciliar, p.no_pessoa AS nome, p.dt_nascimento AS data_nascimento, p.co_cpf AS cpf,
        p.de_titulo_eleitor AS titulo_eleitor, p.de_zona_titulo_eleitor AS zona, p.de_secao_titulo_eleitor AS secao, o.de_ocupacao AS ocupacao,
        p.nu_inep_escola AS inep,
	(CASE
		WHEN p.dt_alteracao_pessoa = '1899-12-30' THEN NULL
		ELSE p.dt_alteracao_pessoa
	END) AS data_atualizacao,
	(CASE
		WHEN p.dt_inclusao_pessoa = '1899-12-30' THEN NULL
		ELSE p.dt_inclusao_pessoa
	END) AS data_inclusao,
	r.co_nis AS responsavel_nis, p.ic_parentesco_responsavel AS reponsavel_parentesco, p.vr_remuneracao AS valor_remuneracao,
        p.vr_renda_aposentadoria AS valor_aposentadoria, p.vr_renda_seguro_desemprego AS valor_seguro_desemprego,
	p.vr_renda_pensao AS valor_pensao, p.vr_outras_rendas AS valor_outras_rendas, p.ic_serie_escolar AS serie_escolar, p.ic_grau_instrucao AS grau_instrucao,
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

-- DOMICILIOS
-- bolsa_familia, `idf`, `data_pesquisa`, `data_inclusao`, `data_atualizacao`, `entrevistador`
SELECT
    DISTINCT ON (d.nu_domiciliar) d.nu_domiciliar AS codigo_domiciliar, (SELECT DISTINCT(p.co_nis) FROM cubfn002_recuperar_nu_ordem(p.nu_responsavel::bigint)) AS responsavel_nis,
    d.co_cep_domicilio AS cep, d.ic_tipo_logradouro AS tipo_logradouro, d.no_logradouro_domicilio AS logradouro, d.co_logradouro_domicilio AS numero, d.de_complemento_logradouro_domicilio AS complemento,
    d.no_bairro_domicilio AS bairro, d.nu_ddd_domicilio AS ddd, d.nu_telefone_domicilio AS telefone, d.ic_tipo_localidade AS tipo_localidade, d.ic_situacao_domicilio AS situacao_domicilio,
    d.ic_tipo_domicilio AS tipo_domicilio, d.ic_tipo_construcao AS tipo_construcao, d.ic_tipo_abastecimento_agua AS tipo_abastecimento, d.ic_tratamento_agua AS tratamento_agua,
    d.ic_tipo_iluminacao AS tipo_iluminacao, d.ic_escoamento_sanitario AS escoamento_sanitario, d.ic_destino_lixo AS destino_lixo, d.qt_comodos AS comodos,
    despesas.despesa_aluguel, despesas.valor_despesa_prestacao,	despesas.valor_despesa_alimentacao, despesas.valor_despesa_agua, despesas.valor_despesa_luz,
    despesas.valor_despesa_transporte, despesas.valor_despesa_medicamento, despesas.valor_despesa_gas, despesas.valor_outras_despesas,
    rendas.valor_remuneracao, rendas.valor_aposentadoria_pensao, rendas.valor_seguro_desemprego, rendas.valor_pensao_alimenticia, rendas.valor_outras_rendas,
    (COALESCE(valor_remuneracao,0) + COALESCE(valor_aposentadoria_pensao,0) +
        COALESCE(valor_seguro_desemprego,0) + COALESCE(valor_pensao_alimenticia,0) +
        COALESCE(valor_outras_rendas,0)) AS valor_renda_familia
FROM cubtb013_domicilio AS d
INNER JOIN
    cubtb027_pessoa AS p ON p.co_domicilio = d.co_domicilio
INNER JOIN
(SELECT
	d.co_domicilio,
	SUM(p.vr_despesa_aluguel) AS despesa_aluguel,
	SUM(p.vr_prestacao_habitacional) AS valor_despesa_prestacao,
	SUM(p.vr_despesa_alimentacao) AS valor_despesa_alimentacao,
	SUM(p.vr_despesa_agua) AS valor_despesa_agua,
	SUM(p.vr_despesa_luz) AS valor_despesa_luz,
	SUM(p.vr_despesa_transporte) AS valor_despesa_transporte,
	SUM(p.vr_despesa_medicamento) AS valor_despesa_medicamento,
	SUM(p.vr_despesa_gas) AS valor_despesa_gas,
	SUM(p.vr_outras_despesas) AS valor_outras_despesas
    FROM cubtb027_pessoa p
    INNER JOIN
             cubtb013_domicilio d ON p.co_domicilio = d.co_domicilio
    GROUP BY
	d.co_domicilio
) AS despesas ON despesas.co_domicilio = d.co_domicilio
INNER JOIN
(SELECT
	d.co_domicilio,
        SUM(p.vr_remuneracao) AS valor_remuneracao,
        SUM(p.vr_renda_aposentadoria) AS valor_aposentadoria_pensao,
        SUM(p.vr_renda_seguro_desemprego) AS valor_seguro_desemprego,
        SUM(p.vr_renda_pensao) AS valor_pensao_alimenticia,
        SUM(p.vr_outras_rendas) AS valor_outras_rendas
    FROM cubtb027_pessoa p
    INNER JOIN
             cubtb013_domicilio d ON p.co_domicilio = d.co_domicilio
    GROUP BY
	d.co_domicilio
) AS rendas ON rendas.co_domicilio = d.co_domicilio
WHERE d.co_domicilio IN (SELECT
                                d.co_domicilio
                        FROM cubtb027_pessoa AS p
                        INNER JOIN
                                cubtb013_domicilio AS d
                                ON p.co_domicilio = d.co_domicilio
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
                        )
