<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
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
    }
</style>
<?php
echo $this->element('filtro');
?>
<table style="text-align: center; width: 920px;" border="1" cellpadding="4" cellspacing="0">
    <tbody>
        <tr>
            <td style="width: 388px; font-weight: bold;">Faixa etária</td>
            <td style="width: 150px; font-weight: bold;">Masculino</td>
            <td style="width: 150px; font-weight: bold;">Feminino</td>
            <td style="width: 100px; font-weight: bold;">Total</td>
            <td style="width: 100px; font-weight: bold;">%</td>
        </tr>
    </tbody>
</table>
<br />
<table style="text-align: center; width: 920px;" border="1" cellpadding="4" cellspacing="0">
    <tbody>
        <tr>
            <td rowspan="11" style="width: 65px; font-weight: bold;"><span class="rotate">Crianças</span></td>
            <td style="width: 317px;">até 1 ano</td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Criança'][Pessoa::SEXO_MASCULINO][0] ?></td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Criança'][Pessoa::SEXO_FEMININO][0] ?></td>
            <td style="width: 100px;"><?php echo $faixaEtaria['Criança']['idade'][0] ?></td>
            <td style="width: 100px;"><?php echo round($faixaEtaria['Criança']['idade'][0] * 100 / $faixaEtaria['total'], 2) ?> %</td>
        </tr>
        <?php
        for ($i = 1; $i <= 9; $i++):
            ?>
            <tr>
                <td style="width: 317px;"><?php echo ($i == 1) ? '1 ano' : $i . ' anos'; ?></td>
                <td style="width: 150px;"><?php echo $faixaEtaria['Criança'][Pessoa::SEXO_MASCULINO][$i] ?></td>
                <td style="width: 150px;"><?php echo $faixaEtaria['Criança'][Pessoa::SEXO_FEMININO][$i] ?></td>
                <td style="width: 100px;"><?php echo $faixaEtaria['Criança']['idade'][$i] ?></td>
                <td style="width: 100px;"><?php echo round($faixaEtaria['Criança']['idade'][$i] * 100 / $faixaEtaria['total'], 2) ?> %</td>
            </tr>
            <?php
        endfor;
        ?>
        <tr style="font-weight: bold;">
            <td style="width: 317px;">Subtotal crianças</td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Criança'][Pessoa::SEXO_MASCULINO]['total'] ?></td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Criança'][Pessoa::SEXO_FEMININO]['total'] ?></td>
            <td style="width: 100px;"><?php echo $faixaEtaria['Criança']['total'] ?></td>
            <td style="width: 100px;"><?php echo round($faixaEtaria['Criança']['total'] * 100 / $faixaEtaria['total'], 2) ?> %</td>
        </tr>
    </tbody>
</table>
<br />

<table style="text-align: center; width: 920px;" border="1" cellpadding="4" cellspacing="0">
    <tbody>
        <tr>
            <td rowspan="11" style="width: 65px; font-weight: bold;"><span class="rotate">Adolescentes</span></td>
            <td style="width: 317px;">10 anos</td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::SEXO_MASCULINO][10] ?></td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::SEXO_FEMININO][10] ?></td>
            <td style="width: 100px;"><?php echo $faixaEtaria['Adolescente']['idade'][10] ?></td>
            <td style="width: 100px;"><?php echo round($faixaEtaria['Adolescente']['idade'][10] * 100 / $faixaEtaria['total'], 2) ?> %</td>
        </tr>
        <?php
        for ($i = 11; $i <= 14; $i++):
            ?>
            <tr>
                <td style="width: 317px;"><?php echo $i; ?> anos</td>
                <td style="width: 150px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::SEXO_MASCULINO][$i] ?></td>
                <td style="width: 150px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::SEXO_FEMININO][$i] ?></td>
                <td style="width: 100px;"><?php echo $faixaEtaria['Adolescente']['idade'][$i] ?></td>
                <td style="width: 100px;"><?php echo round($faixaEtaria['Adolescente']['idade'][$i] * 100 / $faixaEtaria['total'], 2) ?> %</td>
            </tr>
            <?php
        endfor;
        ?>
        <tr style="font-weight: bold;">
            <td style="width: 317px;">Subtotal Adolescentes</td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::SEXO_MASCULINO]['total'] ?></td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Adolescente'][Pessoa::SEXO_FEMININO]['total'] ?></td>
            <td style="width: 100px;"><?php echo $faixaEtaria['Adolescente']['total'] ?></td>
            <td style="width: 100px;"><?php echo round($faixaEtaria['Adolescente']['total'] * 100 / $faixaEtaria['total'], 2) ?> %</td>
        </tr>
    </tbody>
</table>
<br />

<table style="text-align: center; width: 920px;" border="1" cellpadding="4" cellspacing="0">
    <tbody>
        <tr>
            <td rowspan="11" style="width: 65px; font-weight: bold;"><span class="rotate">Jovens</span></td>
            <td style="width: 317px;">15 anos</td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Jovem'][Pessoa::SEXO_MASCULINO][15] ?></td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Jovem'][Pessoa::SEXO_FEMININO][15] ?></td>
            <td style="width: 100px;"><?php echo $faixaEtaria['Jovem']['idade'][15] ?></td>
            <td style="width: 100px;"><?php echo round($faixaEtaria['Jovem']['idade'][15] * 100 / $faixaEtaria['total'], 2) ?> %</td>
        </tr>
        <?php
        for ($i = 16; $i <= 17; $i++):
            ?>
            <tr>
                <td style="width: 317px;"><?php echo $i; ?> anos</td>
                <td style="width: 150px;"><?php echo $faixaEtaria['Jovem'][Pessoa::SEXO_MASCULINO][$i] ?></td>
                <td style="width: 150px;"><?php echo $faixaEtaria['Jovem'][Pessoa::SEXO_FEMININO][$i] ?></td>
                <td style="width: 100px;"><?php echo $faixaEtaria['Jovem']['idade'][$i] ?></td>
                <td style="width: 100px;"><?php echo round($faixaEtaria['Jovem']['idade'][$i] * 100 / $faixaEtaria['total'], 2) ?> %</td>
            </tr>
            <?php
        endfor;
        ?>
        <tr style="font-weight: bold;">
            <td style="width: 317px;">Subtotal Jovens</td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Jovem'][Pessoa::SEXO_MASCULINO]['total'] ?></td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Jovem'][Pessoa::SEXO_FEMININO]['total'] ?></td>
            <td style="width: 100px;"><?php echo $faixaEtaria['Jovem']['total'] ?></td>
            <td style="width: 100px;"><?php echo round($faixaEtaria['Jovem']['total'] * 100 / $faixaEtaria['total'], 2) ?> %</td>
        </tr>
    </tbody>
</table>
<br />

<table style="text-align: center; width: 920px;" border="1" cellpadding="4" cellspacing="0">
    <tbody>
        <tr>
            <td rowspan="43" style="width: 65px; font-weight: bold;"><span class="rotate">Adultos</span></td>
            <td style="width: 317px;">18 anos</td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Adulto'][Pessoa::SEXO_MASCULINO][18] ?></td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Adulto'][Pessoa::SEXO_FEMININO][18] ?></td>
            <td style="width: 100px;"><?php echo $faixaEtaria['Adulto']['idade'][18] ?></td>
            <td style="width: 100px;"><?php echo round($faixaEtaria['Adulto']['idade'][18] * 100 / $faixaEtaria['total'], 2) ?> %</td>
        </tr>
        <?php
        for ($i = 19; $i <= 59; $i++):
            ?>
            <tr>
                <td style="width: 317px;"><?php echo $i; ?> anos</td>
                <td style="width: 150px;"><?php echo $faixaEtaria['Adulto'][Pessoa::SEXO_MASCULINO][$i] ?></td>
                <td style="width: 150px;"><?php echo $faixaEtaria['Adulto'][Pessoa::SEXO_FEMININO][$i] ?></td>
                <td style="width: 100px;"><?php echo $faixaEtaria['Adulto']['idade'][$i] ?></td>
                <td style="width: 100px;"><?php echo round($faixaEtaria['Adulto']['idade'][$i] * 100 / $faixaEtaria['total'], 2) ?> %</td>
            </tr>
            <?php
        endfor;
        ?>
        <tr style="font-weight: bold;">
            <td style="width: 317px;">Subtotal Adultos</td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Adulto'][Pessoa::SEXO_MASCULINO]['total'] ?></td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Adulto'][Pessoa::SEXO_FEMININO]['total'] ?></td>
            <td style="width: 100px;"><?php echo $faixaEtaria['Adulto']['total'] ?></td>
            <td style="width: 100px;"><?php echo round($faixaEtaria['Adulto']['total'] * 100 / $faixaEtaria['total'], 2) ?> %</td>
        </tr>
    </tbody>
</table>
<br />

<table style="text-align: center; width: 920px;" border="1" cellpadding="4" cellspacing="0">
    <tbody>
        <tr>
            <td rowspan="11" style="width: 65px; font-weight: bold;"><span class="rotate">Idosos</span></td>
            <td style="width: 317px;">60 anos</td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Idoso'][Pessoa::SEXO_MASCULINO][60] ?></td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Idoso'][Pessoa::SEXO_FEMININO][60] ?></td>
            <td style="width: 100px;"><?php echo $faixaEtaria['Idoso']['idade'][60] ?></td>
            <td style="width: 100px;"><?php echo round($faixaEtaria['Idoso']['idade'][60] * 100 / $faixaEtaria['total'], 2) ?> %</td>
        </tr>
        <?php
        for ($i = 61; $i <= 65; $i++):
            ?>
            <tr>
                <td style="width: 317px;"><?php echo ($i == 65) ? '≥ ' . $i : $i; ?> anos</td>
                <td style="width: 150px;"><?php echo $faixaEtaria['Idoso'][Pessoa::SEXO_MASCULINO][$i] ?></td>
                <td style="width: 150px;"><?php echo $faixaEtaria['Idoso'][Pessoa::SEXO_FEMININO][$i] ?></td>
                <td style="width: 100px;"><?php echo $faixaEtaria['Idoso']['idade'][$i] ?></td>
                <td style="width: 100px;"><?php echo round($faixaEtaria['Idoso']['idade'][$i] * 100 / $faixaEtaria['total'], 2) ?> %</td>
            </tr>
            <?php
        endfor;
        ?>
        <tr style="font-weight: bold;">
            <td style="width: 317px;">Subtotal Idosos</td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Idoso'][Pessoa::SEXO_MASCULINO]['total'] ?></td>
            <td style="width: 150px;"><?php echo $faixaEtaria['Idoso'][Pessoa::SEXO_FEMININO]['total'] ?></td>
            <td style="width: 100px;"><?php echo $faixaEtaria['Idoso']['total'] ?></td>
            <td style="width: 100px;"><?php echo round($faixaEtaria['Idoso']['total'] * 100 / $faixaEtaria['total'], 2) ?> %</td>
        </tr>
    </tbody>
</table>
<br />

<table style="text-align: center; width: 920px;" border="1" cellpadding="4" cellspacing="0">
    <tbody>
        <tr style="font-weight: bold;">
            <td style="width: 388px;">Total</td>
            <td style="width: 150px;"><?php echo $faixaEtaria[Pessoa::SEXO_MASCULINO] ?></td>
            <td style="width: 150px;"><?php echo $faixaEtaria[Pessoa::SEXO_FEMININO] ?></td>
            <td style="width: 100px;"><?php echo $faixaEtaria['total'] ?></td>
            <td style="width: 100px;">100 %</td>
        </tr>
    </tbody>
</table>
<br />

Tempo de processamento: <?php echo $faixaEtaria['tempo'] ?> segundos.