<?php

function corBarra($indice) {
    if ($indice <= 0.61) {
        $cor = 'red';
    } else if ($indice > 0.61 && $indice <= 0.7) {
        $cor = 'orange';
    } else if ($indice > 0.7 && $indice <= 0.8) {
        $cor = 'yellow';
    } else if ($indice > 0.8 && $indice <= 0.9) {
        $cor = 'green';
    } else if ($indice > 0.9 && $indice <= 1) {
        $cor = 'blue';
    }
    return $cor;
}

function classificaIDF($indice) {
    if ($indice <= 0.61) {
        $classificacao = 'D5';
    } else if ($indice > 0.61 && $indice <= 0.7) {
        $classificacao = 'D4';
    } else if ($indice > 0.7 && $indice <= 0.8) {
        $classificacao = 'D3';
    } else if ($indice > 0.8 && $indice <= 0.9) {
        $classificacao = 'D2';
    } else if ($indice > 0.9 && $indice <= 1) {
        $classificacao = 'D1';
    }
    return $classificacao;
}
?>
<style type="text/css">
    body, table {
        font-family: "Times New Roman", "Garamond", serif;
        font-size: 10pt;
    }
    table {
        border-collapse: collapse;
        border: 0px;
        border-style: solid;
        width: 100%;
        border-bottom: 0.4mm solid #000;
        border-top: 0.4mm solid #000;
        border-left: 0.4mm solid #000;
        border-right: 0.4mm solid #000;
    }
    table thead tr td {
        font-weight: bold;
        border-top: 0.4mm solid #000;
        border-bottom: 0.4mm solid #000;
        border-right: 0.3mm solid #000;
    }
    table tfoot tr td {
        font-weight: bold;
        border-top: 0.4mm solid #000;
        border-bottom: 0.4mm solid #000;
        border-right: 0.3mm solid #000;
    }
    table tbody tr td, table tr td {
        font-size: 9pt;
        border-bottom: 0.2mm solid #000;
        border-right: 0.3mm solid #000;
    }
    .content {
        width: 100%;
    }
    .header {
        height: 15mm;
        margin-bottom: 5mm;
    }
    .titulo {
        text-align: center;
        font-size: 15pt;
        font-weight: bold;
    }
    .subtitulo {
        font-size: 12pt;
        font-weight: bold;
        text-align: center;
    }
</style>
<div class="content">
    <p class="titulo">Plano de Desenvolvimento da Família</p>
    <p class="subtitulo">1. Dados da Família</p>
    <table>
        <tr>
            <td>
                <strong>Código Domiciliar:</strong> <?php echo $this->data['Domicilio']['codigo_domiciliar'] ?>
                <strong>CRAS:</strong> <?php echo $this->data['Domicilio']['Cras']['descricao'] ?>
                <strong>Bairro:</strong> <?php echo $this->data['Domicilio']['Bairro']['nome'] ?>
                <br />
                <strong>Endereço: </strong>
                <?php
                echo (strlen($this->data['Domicilio']['tipo_logradouro']) > 0) ? $this->data['Domicilio']['tipo_logradouro'] . ' ' : '';
                echo (strlen($this->data['Domicilio']['logradouro']) > 0) ? $this->data['Domicilio']['logradouro'] : '';
                echo (strlen($this->data['Domicilio']['numero']) > 0) ? ', no ' . $this->data['Domicilio']['numero'] : '';
                echo (strlen($this->data['Domicilio']['complemento']) > 0) ? ', ' . $this->data['Domicilio']['complemento'] : '';
                ?>
                <strong>Situação do Domicílio:</strong> <?php echo Domicilio::situacaoDomicilio($this->data['Domicilio']['situacao_domicilio']) ?>
                <p>
                    <strong>Responsável Legal:</strong> <?php echo $this->data['Domicilio']['Responsavel']['nome'] ?>
                    <strong>Telefone:</strong> <?php echo $this->data['Domicilio']['telefone'] ?>
                </p>
                <p>&nbsp;</p>
            </td>
            <td>
                Resumo:<br />
                Estratégias de enfrentamento: <?php echo count($this->data['Estrategia']) ?> de <?php echo $total_estrategias ?><br />
                Indicadores do IDF: <?php echo count($this->data['Indicador']) ?> de 41
                <br />&nbsp;
            </td>
        </tr>
    </table>
    <p><!-- SEPARADOR --></p>
    <strong>Composição Familiar:</strong>
    <?php
    if ($this->data['Domicilio']['Pessoa'] > 0) {
        ?>
        <table cellspacing="0" cellpading="0">
            <thead>
                <tr>
                    <td>Nome
                        <br />Idade - NIS</td>
                    <td style="width: 20mm;">Parentesco</td>
                    <td style="width: 20mm;">Est. Civil</td>
                    <td style="width: 80mm;">Série Escolar - Frequenta Escola</td>
                    <td style="width: 60mm;">Tipo Trabalho</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td valign="top"><?php echo $this->data['Domicilio']['Responsavel']['nome'] ?>
                        <br />Idade: <?php echo $this->data['Domicilio']['Responsavel']['idade'] ?>
                        - NIS: <?php echo $this->data['Domicilio']['Responsavel']['nis'] ?>
                        <br />&nbsp;
                    </td>
                    <td valign="top"></td>
                    <td valign="top"><?php echo Pessoa::estadoCivil($this->data['Domicilio']['Responsavel']['estado_civil']) ?></td>
                    <td valign="top"><?php echo Pessoa::serieEscolar($this->data['Domicilio']['Responsavel']['serie_escolar']) ?> - <?php echo Pessoa::tipoEscola($this->data['Domicilio']['Responsavel']['tipo_escola']) ?></td>
                    <td valign="top"><?php echo Pessoa::tipoTrabalho($this->data['Domicilio']['Responsavel']['tipo_trabalho']) ?></td>
                </tr>
            </tbody>
            <tbody>
                <?php
                foreach ($this->data['Domicilio']['Pessoa'] as $membro) {
                    if ($membro['nis'] != $this->data['Domicilio']['Responsavel']['nis']) {
                        ?>
                        <tr>
                            <td valign="top"><?php echo $membro['nome'] ?>
                                <br />Idade: <?php echo $membro['idade'] ?>
                                - NIS: <?php echo $membro['nis'] ?>
                                <br />&nbsp;
                            </td>
                            <td valign="top"><?php echo Pessoa::grauParentesco($membro['responsavel_parentesco']) ?></td>
                            <td valign="top"><?php echo Pessoa::estadoCivil($membro['estado_civil']) ?></td>
                            <td valign="top"><?php echo Pessoa::serieEscolar($membro['serie_escolar']) ?> - <?php echo Pessoa::tipoEscola($membro['tipo_escola']) ?></td>
                            <td valign="top"><?php echo Pessoa::tipoTrabalho($membro['tipo_trabalho']) ?></td>
                        </tr>
                        <?php
                    } //end if
                } // end foreach
                ?>
            </tbody>
        </table>
        <?php
    }
    ?>
    <p><!-- SEPARADOR --></p>
    <table cellspacing="0" cellpading="0">
        <thead>
            <tr>
                <td colspan="4" align="center">Prontuário gerado em: <?php echo date('d/m/Y H:i:s', strtotime($this->data['Prontuario']['created'])) ?> por <?php echo $this->data['Usuario']['nome'] ?></td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Agenda em Casa: ______/______/___________</td>
                <td>Agenda em Casa: ______/______/___________</td>
                <td>Agenda em Casa: ______/______/___________</td>
                <td>Agenda em Casa: ______/______/___________</td>
            </tr>
            <tr>
                <td>Agente:</td>
                <td>Agente:</td>
                <td>Agente:</td>
                <td>Agente:</td>
            </tr>
        </tbody>
    </table>
</div>
<div class="content">
    <p class="subtitulo">2. Situação do Desenvolvimento da Família</p>
    <?php
    if ($this->data['Indice']['vulnerabilidade'] != 1) {
        ?>
        <table cellspacing="0" cellpading="0">
            <thead>
                <tr>
                    <td colspan="2" align="center">Dimensão - Vulnerabilidade Familiar</td>
                </tr>
                <tr>
                    <td style="width: 135mm;">Indicador</td>
                    <td>Observação</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($this->data['Indicador'] as $indicador) {
                    if ($indicador['Dimensao']['coluna'] == 'vulnerabilidade') {
                        ?>
                        <tr>
                            <td><?php echo $indicador['codigo'] . ' ' . $indicador['label'] ?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <?php
    }
    ?>
    <p><!-- SEPARADOR --></p>
    <?php
    if ($this->data['Indice']['conhecimento'] != 1) {
        ?>
        <table cellspacing="0" cellpading="0">
            <thead>
                <tr>
                    <td colspan="2" align="center">Dimensão - Acesso ao Conhecimento</td>
                </tr>
                <tr>
                    <td style="width: 135mm;">Indicador</td>
                    <td>Observação</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($this->data['Indicador'] as $indicador) {
                    if ($indicador['Dimensao']['coluna'] == 'conhecimento') {
                        ?>
                        <tr>
                            <td><?php echo $indicador['codigo'] . ' ' . $indicador['label'] ?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <?php
    }
    ?>
    <p><!-- SEPARADOR --></p>
    <?php
    if ($this->data['Indice']['trabalho'] != 1) {
        ?>
        <table cellspacing="0" cellpading="0">
            <thead>
                <tr>
                    <td colspan="2" align="center">Dimensão - Acesso ao Trabalho</td>
                </tr>
                <tr>
                    <td style="width: 135mm;">Indicador</td>
                    <td>Observação</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($this->data['Indicador'] as $indicador) {
                    if ($indicador['Dimensao']['coluna'] == 'trabalho') {
                        ?>
                        <tr>
                            <td><?php echo $indicador['codigo'] . ' ' . $indicador['label'] ?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <?php
    }
    ?>
    <p><!-- SEPARADOR --></p>
    <?php
    if ($this->data['Indice']['recursos'] != 1) {
        ?>
        <table cellspacing="0" cellpading="0">
            <thead>
                <tr>
                    <td colspan="2" align="center">Dimensão - Disponibilidade de Recursos</td>
                </tr>
                <tr>
                    <td style="width: 135mm;">Indicador</td>
                    <td>Observação</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($this->data['Indicador'] as $indicador) {
                    if ($indicador['Dimensao']['coluna'] == 'recursos') {
                        ?>
                        <tr>
                            <td><?php echo $indicador['codigo'] . ' ' . $indicador['label'] ?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <?php
    }
    ?>
    <p><!-- SEPARADOR --></p>
    <?php
    if ($this->data['Indice']['desenvolvimento'] != 1) {
        ?>
        <table cellspacing="0" cellpading="0">
            <thead>
                <tr>
                    <td colspan="2" align="center">Dimensão - Desenvolvimento Infantil</td>
                </tr>
                <tr>
                    <td style="width: 135mm;">Indicador</td>
                    <td>Observação</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($this->data['Indicador'] as $indicador) {
                    if ($indicador['Dimensao']['coluna'] == 'desenvolvimento') {
                        ?>
                        <tr>
                            <td><?php echo $indicador['codigo'] . ' ' . $indicador['label'] ?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <?php
    }
    ?>
    <p><!-- SEPARADOR --></p>
    <?php
    if ($this->data['Indice']['habitacao'] != 1) {
        ?>
        <table cellspacing="0" cellpading="0">
            <thead>
                <tr>
                    <td colspan="2" align="center">Dimensão - Condições Habitacionais</td>
                </tr>
                <tr>
                    <td style="width: 135mm;">Indicador</td>
                    <td>Observação</td>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($this->data['Indicador'] as $indicador) {
                    if ($indicador['Dimensao']['coluna'] == 'habitacao') {
                        ?>
                        <tr>
                            <td><?php echo $indicador['codigo'] . ' ' . $indicador['label'] ?></td>
                            <td>&nbsp;</td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
        <?php
    }
    ?>
    <p class="subtitulo">2.1. Classificação do Índice de Desenvolvimento Familiar</p>
    <table cellspacing="0" cellpading="0">
        <thead>
            <tr>
                <td style="width: 72mm;">Dimensão</td>
                <td colspan="2" align="center">Índice</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Vulnerabilidade Familiar</td>
                <td style="text-align: center; width: 18mm;"><?php echo round($this->data['Indice']['vulnerabilidade'], 2) ?></td>
                <td style="width: 100mm;">
                    <?php
                    $tamanho = round((($this->data['Indice']['vulnerabilidade'] * 100) / 1) * 95 / 100);
                    echo $this->Html->image('graficos/' . corBarra($this->data['Indice']['vulnerabilidade']) . '.png', array('alt' => '', 'style' => 'width: ' . $tamanho . 'mm; height: 3mm;'));
                    ?>
                </td>
            </tr>
            <tr>
                <td>Acesso ao Conhecimento</td>
                <td style="text-align: center;"><?php echo round($this->data['Indice']['conhecimento'], 2) ?></td>
                <td>
                    <?php
                    $tamanho = round((($this->data['Indice']['conhecimento'] * 100) / 1) * 95 / 100);
                    echo $this->Html->image('graficos/' . corBarra($this->data['Indice']['conhecimento']) . '.png', array('alt' => '', 'style' => 'width: ' . $tamanho . 'mm; height: 3mm;'));
                    ?>
                </td>
            </tr>
            <tr>
                <td>Acesso ao Trabalho</td>
                <td style="text-align: center;"><?php echo round($this->data['Indice']['trabalho'], 2) ?></td>
                <td>
                    <?php
                    $tamanho = round((($this->data['Indice']['trabalho'] * 100) / 1) * 95 / 100);
                    echo $this->Html->image('graficos/' . corBarra($this->data['Indice']['trabalho']) . '.png', array('alt' => '', 'style' => 'width: ' . $tamanho . 'mm; height: 3mm;'));
                    ?>
                </td>
            </tr>
            <tr>
                <td>Disponibilidade de Recursos</td>
                <td style="text-align: center;"><?php echo round($this->data['Indice']['recursos'], 2) ?></td>
                <td>
                    <?php
                    $tamanho = round((($this->data['Indice']['recursos'] * 100) / 1) * 95 / 100);
                    echo $this->Html->image('graficos/' . corBarra($this->data['Indice']['recursos']) . '.png', array('alt' => '', 'style' => 'width: ' . $tamanho . 'mm; height: 3mm;'));
                    ?>
                </td>
            </tr>
            <tr>
                <td>Desenvolvimento Infantil</td>
                <td style="text-align: center;"><?php echo round($this->data['Indice']['desenvolvimento'], 2) ?></td>
                <td>
                    <?php
                    $tamanho = round((($this->data['Indice']['desenvolvimento'] * 100) / 1) * 95 / 100);
                    echo $this->Html->image('graficos/' . corBarra($this->data['Indice']['desenvolvimento']) . '.png', array('alt' => '', 'style' => 'width: ' . $tamanho . 'mm; height: 3mm;'));
                    ?>
                </td>
            </tr>
            <tr>
                <td>Condições Habitacionais</td>
                <td style="text-align: center;"><?php echo round($this->data['Indice']['habitacao'], 2) ?></td>
                <td>
                    <?php
                    $tamanho = round((($this->data['Indice']['habitacao'] * 100) / 1) * 95 / 100);
                    echo $this->Html->image('graficos/' . corBarra($this->data['Indice']['habitacao']) . '.png', array('alt' => '', 'style' => 'width: ' . $tamanho . 'mm; height: 3mm;'));
                    ?>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td align="right">IDF da Família</td>
                <td style="text-align: center;"><?php echo round($this->data['Indice']['idf'], 2) ?></td>
                <td>
                    <?php
                    $tamanho = round((($this->data['Indice']['idf'] * 100) / 1) * 95 / 100);
                    echo $this->Html->image('graficos/' . corBarra($this->data['Indice']['idf']) . '.png', array('alt' => '', 'style' => 'width: ' . $tamanho . 'mm; height: 3mm;'));
                    ?>
                </td>
            </tr>
            <tr>
                <td align="center" colspan="3">Classificação - <?php echo classificaIDF($this->data['Indice']['idf']) ?></td>
            </tr>
        </tfoot>
    </table>
</div>
<div class="content">
    <p class="subtitulo">3. Estratégias de Enfrentamento</p>
    <?php
    foreach ($this->data['Estrategia'] as $estrategia) {
        ?>
        <table cellspacing="0" cellpading="0">
            <tr>
                <td colspan="3"><strong><?php echo $estrategia['codigo'] ?></strong> - <?php echo $estrategia['descricao'] ?></td>
            </tr>
            <tr>
                <td style="width: 5cm;">Atividade:</td>
                <td>Encaminhamento:</td>
                <td style="width: 3cm;">Prazo:</td>
            </tr>
            <?php
            foreach ($estrategia['Acao'] as $acao) {
                ?>
                <tr>
                    <td><?php echo Acao::atividade($acao['atividade']) ?></td>
                    <td><?php echo $acao['encaminhamento'] ?></td>
                    <td><?php echo ($acao['prazo_maximo'] == 0) ? "" : $acao['prazo_maximo'] . " dias"; ?></td>
                </tr>
                <?php
            }
            ?>
            <tr>
                <td colspan="4">Observações gerais:</td>
            </tr>
            <tr>
                <td colspan="4">&nbsp;</td>
            </tr>
        </table>
        <br />
        <?php
    }
    ?>
</div>
<pagebreak />
<div class="content">
    <p class="subtitulo">4. Observações Gerais
        <br/> <span style="font-size: 8pt;">(preenchido pelo Agente Local da Família - datado e assinado)</span>
    </p>
    <table>
        <tbody>
            <?php
            for ($i = 0; $i < 14; $i++) {
                ?>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <p><!-- SEPARADOR --></p>
    <p class="subtitulo">5. Análise do Plano de Desenvolvimento da Família
        <br/> <span style="font-size: 8pt;">(preenchido pelo Técnico do CRAS - datado e assinado)</span>
    </p>
    <table>
        <tbody>
            <?php
            for ($i = 0; $i < 14; $i++) {
                ?>
                <tr>
                    <td>&nbsp;</td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>