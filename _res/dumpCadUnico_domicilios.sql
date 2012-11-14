-- DOMICILIOS
INSERT INTO tb_domicilio (cod_domiciliar, cod_nis_responsavel, end_cep, end_tipo, end_logradouro, end_num, end_compl, nome_bairro,
                            tel_ddd, tel_num, tp_localidade, tp_situacao_domicilio, tp_domicilio, tp_construcao, tp_abastecimento,
                            tp_tratamento_agua, tp_iluminacao, tp_escoamento_sanitario, tp_destino_lixo, qtd_pessoa, qtd_comodo,
                            vlr_despesa_aluguel, vlr_despesa_prestacao, vlr_despesa_alimentacao, vlr_despesa_agua, vlr_despesa_luz,
                            vlr_despesa_transporte, vlr_despesa_medicamento, vlr_despesa_gas, vlr_outras_despesas, vlr_despesa_familia,
                            vlr_remuneracao, vlr_aposentadoria_pensao, vlr_seguro_desemprego, vlr_pensao_alimenticia, vlr_outras_rendas,
                            vlr_renda_familia, dt_atualizacao, dt_inclusao, dt_pesquisa)
SELECT t.* FROM (
    SELECT
        DISTINCT ON (d.nu_domiciliar) d.nu_domiciliar AS cod_domiciliar,
        (SELECT DISTINCT(pp.co_nis) FROM cubtb027_pessoa pp INNER JOIN cubtb013_domicilio dd ON dd.co_domicilio = pp.co_domicilio
            WHERE pp.nu_responsavel = pp.nu_pessoa AND dd.nu_domiciliar = d.nu_domiciliar AND (dt_exclusao_pessoa IS NULL OR dt_exclusao_pessoa = '1899-12-30') LIMIT 1) AS cod_nis_responsavel,
        d.co_cep_domicilio AS end_cep, d.ic_tipo_logradouro AS end_tipo, d.no_logradouro_domicilio AS end_logradouro, d.co_logradouro_domicilio AS end_num, d.de_complemento_logradouro_domicilio AS end_compl,
        d.no_bairro_domicilio AS nome_bairro, substring(to_char(d.nu_ddd_domicilio, '999') from 1 for 3) AS tel_ddd, d.nu_telefone_domicilio AS tel_num, d.ic_tipo_localidade AS tp_localidade, d.ic_situacao_domicilio AS tp_situacao_domicilio,
        d.ic_tipo_domicilio AS tp_domicilio, d.ic_tipo_construcao AS tp_construcao, d.ic_tipo_abastecimento_agua AS tp_abastecimento, d.ic_tratamento_agua AS tp_tratamento_agua,
        d.ic_tipo_iluminacao AS tp_iluminacao, d.ic_escoamento_sanitario AS tp_escoamento_sanitario, d.ic_destino_lixo AS tp_destino_lixo, d.qt_pessoas AS qtd_pessoa, d.qt_comodos AS qtd_comodo,
        -- Despesas
        COALESCE(despesas.valor_despesa_aluguel,0) AS vlr_despesa_aluguel, COALESCE(despesas.valor_despesa_prestacao,0) AS vlr_despesa_prestacao,
        COALESCE(despesas.valor_despesa_alimentacao,0) AS vlr_despesa_alimentacao, COALESCE(despesas.valor_despesa_agua,0) AS vlr_despesa_agua,
        COALESCE(despesas.valor_despesa_luz,0) AS vlr_despesa_luz, COALESCE(despesas.valor_despesa_transporte,0) AS vlr_despesa_transporte,
        COALESCE(despesas.valor_despesa_medicamento,0) AS vlr_despesa_medicamento, COALESCE(despesas.valor_despesa_gas,0) AS vlr_despesa_gas,
        COALESCE(despesas.valor_outras_despesas,0) AS vlr_outras_despesas,
        (COALESCE(valor_despesa_aluguel,0) + COALESCE(valor_despesa_prestacao,0) + COALESCE(valor_despesa_alimentacao,0) + COALESCE(valor_despesa_agua,0) +
        COALESCE(valor_despesa_luz,0) + COALESCE(valor_despesa_transporte,0) + COALESCE(valor_despesa_medicamento,0) + COALESCE(valor_despesa_gas,0) +
        COALESCE(valor_outras_despesas,0)) AS vlr_despesa_familia,
        -- Rendas
        COALESCE(rendas.valor_remuneracao,0) AS vlr_remuneracao, COALESCE(rendas.valor_aposentadoria_pensao,0) AS vlr_aposentadoria_pensao,
        COALESCE(rendas.valor_seguro_desemprego,0) AS vlr_seguro_desemprego, COALESCE(rendas.valor_pensao_alimenticia,0) AS vlr_pensao_alimenticia,
        COALESCE(rendas.valor_outras_rendas,0) AS vlr_outras_rendas,
        (COALESCE(valor_remuneracao,0) + COALESCE(valor_aposentadoria_pensao,0) +
            COALESCE(valor_seguro_desemprego,0) + COALESCE(valor_pensao_alimenticia,0) +
            COALESCE(valor_outras_rendas,0)) AS vlr_renda_familia,
        (CASE
                WHEN d.dt_alteracao_domicilio = '1899-12-30' THEN NULL
                ELSE d.dt_alteracao_domicilio
        END) AS dt_atualizacao,
        (CASE
                WHEN d.dt_inclusao_domicilio = '1899-12-30' THEN NULL
                ELSE d.dt_inclusao_domicilio
        END) AS dt_inclusao,
        (CASE
                WHEN d.dt_pesquisa = '1899-12-30' THEN NULL
                ELSE d.dt_pesquisa
        END) AS dt_pesquisa
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
    WHERE
        d.dt_pesquisa > '2009-09-01'
        AND (d.dt_exclusao_domicilio = '1899-12-30' OR d.dt_exclusao_domicilio IS NULL)
        AND d.qt_pessoas > 0
        AND d.ic_situacao_cadastral = 'A'
        AND d.ic_domicilio_valido = 't'
        AND TRIM(d.no_logradouro_domicilio) <> '' AND d.no_logradouro_domicilio IS NOT NULL
        AND (SELECT COUNT(*) FROM cubtb027_pessoa p WHERE p.co_domicilio = d.co_domicilio) = d.qt_pessoas
) AS t