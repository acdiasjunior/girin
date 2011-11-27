-- PESSOAS
SELECT
	p.no_pessoa as nome, p.co_nis as nis, p.dt_nascimento as data_nascimento, p.co_cpf as cpf, p.de_titulo_eleitor as titulo_eleitor,
	p.de_zona_titulo_eleitor as zona, p.de_secao_titulo_eleitor as secao, p.co_ocupacao as codigo_ocupacao, p.nu_inep_escola as inep,
	p.dt_alteracao_pessoa as data_atualizacao, p.dt_inclusao_pessoa as data_inclusao, d.nu_domiciliar,
	r.co_nis as responsavel_nis, p.vr_renda_aposentadoria as valor_aposentadoria, p.vr_renda_seguro_desemprego as valor_seguro_desemprego,
	p.vr_renda_pensao as valor_pensao, p.vr_outras_rendas as valor_renda, p.ic_serie_escolar AS serie_escolar, p.ic_grau_instrucao AS grau_instrucao,
	p.ic_tipo_escola AS tipo_escola, p.ic_sexo AS genero, p.ic_raca_cor AS raca_cor,
FROM cubtb027_pessoa AS p
LEFT JOIN
	cubtb027_pessoa AS r
	ON p.nu_pessoa = r.nu_pessoa
INNER JOIN
	cubtb013_domicilio AS d
	ON p.co_domicilio = d.co_domicilio
WHERE p.dt_alteracao_pessoa > '2009-11-01'

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