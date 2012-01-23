-- DOMICILIOS
-- bolsa_familia, `idf`, `data_pesquisa`, `data_inclusao`, `data_atualizacao`, `entrevistador`
SELECT
    DISTINCT ON (d.nu_domiciliar) d.nu_domiciliar AS codigo_domiciliar,
    (SELECT DISTINCT(p.co_nis) FROM cubtb027_pessoa WHERE nu_pessoa = nu_responsavel AND co_domicilio = p.co_domicilio AND (dt_exclusao_pessoa IS NULL OR dt_exclusao_pessoa = '1899-12-30')) AS nis_responsavel,
    d.co_cep_domicilio AS cep, d.ic_tipo_logradouro AS tipo_logradouro, d.no_logradouro_domicilio AS logradouro, d.co_logradouro_domicilio AS numero, d.de_complemento_logradouro_domicilio AS complemento,
    d.no_bairro_domicilio AS bairro_nome, d.nu_ddd_domicilio AS ddd, d.nu_telefone_domicilio AS telefone, d.ic_tipo_localidade AS tipo_localidade, d.ic_situacao_domicilio AS situacao_domicilio,
    d.ic_tipo_domicilio AS tipo_domicilio, d.ic_tipo_construcao AS tipo_construcao, d.ic_tipo_abastecimento_agua AS tipo_abastecimento, d.ic_tratamento_agua AS tratamento_agua,
    d.ic_tipo_iluminacao AS tipo_iluminacao, d.ic_escoamento_sanitario AS escoamento_sanitario, d.ic_destino_lixo AS destino_lixo, d.qt_pessoas AS quantidade_pessoas, d.qt_comodos AS comodos,
    -- Despesas
    COALESCE(despesas.valor_despesa_aluguel,0), COALESCE(despesas.valor_despesa_prestacao,0), COALESCE(despesas.valor_despesa_alimentacao,0),
    COALESCE(despesas.valor_despesa_agua,0), COALESCE(despesas.valor_despesa_luz,0),
    COALESCE(despesas.valor_despesa_transporte,0), COALESCE(despesas.valor_despesa_medicamento,0), COALESCE(despesas.valor_despesa_gas,0),
    COALESCE(despesas.valor_outras_despesas,0),
    (COALESCE(valor_despesa_aluguel,0) + COALESCE(valor_despesa_prestacao,0) + COALESCE(valor_despesa_alimentacao,0) + COALESCE(valor_despesa_agua,0) +
    COALESCE(valor_despesa_luz,0) + COALESCE(valor_despesa_transporte,0) + COALESCE(valor_despesa_medicamento,0) + COALESCE(valor_despesa_gas,0) +
    COALESCE(valor_outras_despesas,0)) AS valor_despesa_familia,
    -- Rendas
    COALESCE(rendas.valor_remuneracao,0), COALESCE(rendas.valor_aposentadoria_pensao,0), COALESCE(rendas.valor_seguro_desemprego,0), COALESCE(rendas.valor_pensao_alimenticia,0),
    COALESCE(rendas.valor_outras_rendas,0),
    (COALESCE(valor_remuneracao,0) + COALESCE(valor_aposentadoria_pensao,0) +
        COALESCE(valor_seguro_desemprego,0) + COALESCE(valor_pensao_alimenticia,0) +
        COALESCE(valor_outras_rendas,0)) AS valor_renda_familia,
    (CASE
            WHEN d.dt_alteracao_domicilio = '1899-12-30' THEN NULL
            ELSE d.dt_alteracao_domicilio
    END) AS data_atualizacao,
    (CASE
            WHEN d.dt_inclusao_domicilio = '1899-12-30' THEN NULL
            ELSE d.dt_inclusao_domicilio
    END) AS data_inclusao,
    (CASE
            WHEN d.dt_pesquisa = '1899-12-30' THEN NULL
            ELSE d.dt_pesquisa
    END) AS data_pesquisa
FROM cubtb013_domicilio AS d
INNER JOIN
    cubtb027_pessoa AS p ON p.co_domicilio = d.co_domicilio
INNER JOIN
(SELECT
	d.co_domicilio,
	SUM(p.vr_despesa_aluguel) AS valor_despesa_aluguel,
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
