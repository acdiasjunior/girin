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
	(CASE
		WHEN p.nu_mes_gestacao IS NOT NULL THEN
			(SELECT CURRENT_DATE + (9 - p.nu_mes_gestacao) * INTERVAL '1 month')
		ELSE NULL
	END) AS data_concepcao_gestacao, p.nu_mes_gestacao AS mes_gestacao
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
WHERE p.dt_alteracao_pessoa > (now() - interval '2 YEAR')

-- DOMICILIOS
SUM(vr_despesa_aluguel) AS valor_despesa_aluguel,
SUM(vr_prestacao_habitacional) AS valor_despesa_prestacao,
SUM(vr_despesa_alimentacao) AS valor_despesa_alimentacao,
SUM(vr_despesa_agua) AS valor_despesa_agua,
SUM(vr_despesa_luz) AS valor_despesa_luz,
SUM(vr_despesa_transporte) AS valor_despesa_transporte,
SUM(vr_despesa_medicamento) AS valor_despesa_medicamento,
SUM(vr_despesa_gas) AS valor_despesa_gas,
SUM(vr_outras_despesas) AS valor_outras_despesas