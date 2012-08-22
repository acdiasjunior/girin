<?php
echo $javascript->link(array('preencheCombo'));
?>
<style type="text/css">
    .rotate {
        display: block;
        -webkit-transform: rotate(270deg);
        -moz-transform: rotate(270deg);
        -ms-transform: rotate(270deg);
        -o-transform: rotate(270deg);
        writing-mode: lr-bt;
        text-align: center;
        font-weight: bold;
    }
</style>
<?php
echo $this->element('filtro');
?>
<table style="text-align: center; width: 920px;" border="1" cellpadding="2" cellspacing="0">
    <tbody>
        <tr>
            <td colspan="9" rowspan="1" style="width: 80px;">Perfil Sócio Econômico</td>
        </tr>
        <tr>
            <td colspan="9" rowspan="1" style="width: 80px;">Trabalho / Emprego</td>
        </tr>
        <tr>
            <td colspan="2" rowspan="2" style="width: 80px;">Faixa etária</td>
            <td colspan="2" rowspan="1" style="width: 90px;">Assalariado</td>
            <td colspan="2" rowspan="1" style="width: 90px;">Autônomo</td>
            <td colspan="1" rowspan="2" style="width: 90px;">Aposentado / Pensionista</td>
            <td colspan="1" rowspan="2" style="width: 90px;">Trabalhador Rural</td>
            <td colspan="1" rowspan="2" style="width: 90px;">Não Trabalha</td>
        </tr>
        <tr>
            <td style="width: 90px;">com CTPS</td>
            <td style="width: 90px;">sem CTPS</td>
            <td style="width: 90px;">com Previdência</td>
            <td style="width: 90px;">sem Previdência</td>
        </tr>
    </tbody>
</table>
<br />
<table style="text-align: center; width: 920px;" border="1" cellpadding="2" cellspacing="0">
    <tbody>
        <tr>
            <td colspan="1" rowspan="11" style="width: 80px;"><span class="rotate">Crianças</span></td>
            <td style="width: 154px;">Até 1 ano</td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Criança'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA][0] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Criança'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA][0] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Criança'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA][0] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Criança'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA][0] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Criança'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA][0] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Criança'][Pessoa::TRABALHO_TRABALHADOR_RURAL][0] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Criança'][Pessoa::TRABALHO_NAO_TRABALHA][0] ?></td>
        </tr>

        <?php
        for ($i = 1; $i <= 9; $i++):
            ?>
            <tr>
                <td style="width: 154px;"><?php echo ($i == 1) ? '1 ano' : $i . ' anos'; ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Criança'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Criança'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Criança'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Criança'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Criança'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Criança'][Pessoa::TRABALHO_TRABALHADOR_RURAL][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Criança'][Pessoa::TRABALHO_NAO_TRABALHA][$i] ?></td>
            </tr>
            <?php
        endfor;
        ?>

        <tr style="font-weight: bold;">
            <td style="width: 154px;">Sub-total Crianças</td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Criança'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Criança'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Criança'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Criança'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Criança'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Criança'][Pessoa::TRABALHO_TRABALHADOR_RURAL]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Criança'][Pessoa::TRABALHO_NAO_TRABALHA]) ?></td>
        </tr>
    </tbody>
</table>
<br />
<table style="text-align: center; width: 920px;" border="1" cellpadding="2" cellspacing="0">
<tbody>
    <tr>
        <td colspan="1" rowspan="6" style="width: 80px;"><span class="rotate">Adolescentes</span></td>
        <td style="width: 154px;">10 anos</td>
        <td style="width: 90px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA][10] ?></td>
        <td style="width: 90px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA][10] ?></td>
        <td style="width: 90px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA][10] ?></td>
        <td style="width: 90px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA][10] ?></td>
        <td style="width: 90px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA][10] ?></td>
        <td style="width: 90px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::TRABALHO_TRABALHADOR_RURAL][10] ?></td>
        <td style="width: 90px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::TRABALHO_NAO_TRABALHA][10] ?></td>
    </tr>

    <?php
    for ($i = 11; $i <= 14; $i++):
        ?>
        <tr>
            <td style="width: 154px;"><?php echo $i ?> anos</td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA][$i] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA][$i] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA][$i] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA][$i] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA][$i] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::TRABALHO_TRABALHADOR_RURAL][$i] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::TRABALHO_NAO_TRABALHA][$i] ?></td>
        </tr>
        <?php
    endfor;
    ?>

    <tr style="font-weight: bold;">
        <td style="width: 154px;">Sub-total Adolescentes</td>
        <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Adolescente'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA]) ?></td>
        <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Adolescente'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA]) ?></td>
        <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Adolescente'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA]) ?></td>
        <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Adolescente'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA]) ?></td>
        <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Adolescente'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA]) ?></td>
        <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Adolescente'][Pessoa::TRABALHO_TRABALHADOR_RURAL]) ?></td>
        <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Adolescente'][Pessoa::TRABALHO_NAO_TRABALHA]) ?></td>
    </tr>
</tbody>
</table>
<br />
<table style="text-align: center; width: 920px;" border="1" cellpadding="2" cellspacing="0">
    <tbody>
        <tr>
            <td colspan="1" rowspan="6" style="width: 80px;"><span class="rotate">Jovens</span></td>
            <td style="width: 154px;">15 anos</td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Jovem'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA][15] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Jovem'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA][15] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Jovem'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA][15] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Jovem'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA][15] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Jovem'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA][15] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Jovem'][Pessoa::TRABALHO_TRABALHADOR_RURAL][15] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Jovem'][Pessoa::TRABALHO_NAO_TRABALHA][15] ?></td>
        </tr>

        <?php
        for ($i = 16; $i <= 17; $i++):
            ?>
            <tr>
                <td style="width: 154px;"><?php echo $i ?> anos</td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Jovem'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Jovem'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Jovem'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Jovem'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Jovem'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Jovem'][Pessoa::TRABALHO_TRABALHADOR_RURAL][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Jovem'][Pessoa::TRABALHO_NAO_TRABALHA][$i] ?></td>
            </tr>
            <?php
        endfor;
        ?>

        <tr style="font-weight: bold;">
            <td style="width: 154px;">Sub-total Jovens</td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Jovem'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Jovem'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Jovem'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Jovem'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Jovem'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Jovem'][Pessoa::TRABALHO_TRABALHADOR_RURAL]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Jovem'][Pessoa::TRABALHO_NAO_TRABALHA]) ?></td>
        </tr>
    </tbody>
</table>
<br />
<table style="text-align: center; width: 920px;" border="1" cellpadding="2" cellspacing="0">
    <tbody>
        <tr>
            <td colspan="1" rowspan="43" style="width: 80px;"><span class="rotate">Adultos</span></td>
            <td style="width: 184px;">18 anos</td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Adulto'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA][18] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Adulto'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA][18] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Adulto'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA][18] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Adulto'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA][18] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Adulto'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA][18] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Adulto'][Pessoa::TRABALHO_TRABALHADOR_RURAL][18] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Adulto'][Pessoa::TRABALHO_NAO_TRABALHA][18] ?></td>
        </tr>

        <?php
        for ($i = 19; $i <= 59; $i++):
            ?>
            <tr>
                <td style="width: 154px;"><?php echo $i ?> anos</td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Adulto'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Adulto'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Adulto'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Adulto'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Adulto'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Adulto'][Pessoa::TRABALHO_TRABALHADOR_RURAL][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Adulto'][Pessoa::TRABALHO_NAO_TRABALHA][$i] ?></td>
            </tr>
            <?php
        endfor;
        ?>

        <tr style="font-weight: bold;">
            <td style="width: 184px;">Sub-total Adultos</td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Adulto'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Adulto'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Adulto'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Adulto'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Adulto'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Adulto'][Pessoa::TRABALHO_TRABALHADOR_RURAL]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Adulto'][Pessoa::TRABALHO_NAO_TRABALHA]) ?></td>
        </tr>
    </tbody>
</table>
<br />
<table style="text-align: center; width: 920px;" border="1" cellpadding="2" cellspacing="0">
    <tbody>
        <tr>
            <td colspan="1" rowspan="7" style="width: 80px;"><span class="rotate">Idosos</span></td>
            <td style="width: 604px;">60 anos</td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Idoso'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA][60] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Idoso'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA][60] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Idoso'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA][60] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Idoso'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA][60] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Idoso'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA][60] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Idoso'][Pessoa::TRABALHO_TRABALHADOR_RURAL][60] ?></td>
            <td style="width: 90px;"><?php echo $faixaEtaria['Idoso'][Pessoa::TRABALHO_NAO_TRABALHA][60] ?></td>
        </tr>

        <?php
        for ($i = 61; $i <= 65; $i++):
            ?>
            <tr>
                <td style="width: 154px;"><?php echo $i ?> anos</td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Idoso'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Idoso'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Idoso'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Idoso'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Idoso'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Idoso'][Pessoa::TRABALHO_TRABALHADOR_RURAL][$i] ?></td>
                <td style="width: 90px;"><?php echo $faixaEtaria['Idoso'][Pessoa::TRABALHO_NAO_TRABALHA][$i] ?></td>
            </tr>
            <?php
        endfor;
        ?>

        <tr style="font-weight: bold;">
            <td style="width: 154px;">Sub-total Idosos</td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Idoso'][Pessoa::TRABALHO_ASSALARIADO_COM_CARTEIRA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Idoso'][Pessoa::TRABALHO_ASSALARIADO_SEM_CARTEIRA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Idoso'][Pessoa::TRABALHO_AUTONOMO_COM_PREVIDENCIA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Idoso'][Pessoa::TRABALHO_AUTONOMO_SEM_PREVIDENCIA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Idoso'][Pessoa::TRABALHO_APOSENTADO_PENSIONISTA]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Idoso'][Pessoa::TRABALHO_TRABALHADOR_RURAL]) ?></td>
            <td style="width: 90px;"><?php echo array_sum($faixaEtaria['Idoso'][Pessoa::TRABALHO_NAO_TRABALHA]) ?></td>
        </tr>
    </tbody>
</table>
<br />

Tempo de processamento: <?php echo $faixaEtaria['tempo'] ?> segundos.