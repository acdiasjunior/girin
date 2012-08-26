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
<table style="text-align: center; margin-left: 0px;" border="1" cellpadding="2" cellspacing="0">
    <tbody>
        <tr style="font-weight: bold;">
            <td colspan="8">Perfil Sócio Econômico</td>
        </tr>
        <tr style="font-weight: bold;">
            <td colspan="8">Valor Renda</td>
        </tr>
        <tr>
            <td style="width: 255px;" colspan="2">Faixa etária</td>
            <td style="width: 105px;">0,00</td>
            <td style="width: 105px;">0,01 a 70,00</td>
            <td style="width: 105px;">70,01 a 140,00</td>
            <td style="width: 105px;">140,01 a 240,00</td>
            <td style="width: 105px;">240,01 a 545,00</td>
            <td style="width: 105px;">&gt; 545,00</td>
        </tr>
    </tbody>
</table>
<br />
<table style="text-align: center; margin-left: 0px;" border="1" cellpadding="2" cellspacing="0">
    <tbody>
        <tr>
            <td style="width: 60px;" rowspan="11"><span class="rotate">Crianças</span></td>
            <td style="width: 200px;">até 1 ano</td>
            <td style="width: 110px;"><?php echo $valorRenda['Criança']['0 reais'][0] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Criança']['ate 70 reais'][0] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Criança']['70 a 140 reais'][0] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Criança']['140 a 240 reais'][0] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Criança']['240 a 545 reais'][0] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Criança']['acima 545 reais'][0] ?></td>
        </tr>
        <?php
        for ($i = 1; $i <= 9; $i++):
            ?>
            <tr>
                <td style="width: 200px;"><?php echo ($i == 1) ? '1 ano' : $i . ' anos'; ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Criança']['0 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Criança']['ate 70 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Criança']['70 a 140 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Criança']['140 a 240 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Criança']['240 a 545 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Criança']['acima 545 reais'][$i] ?></td>
            </tr>
            <?php
        endfor;
        ?>
        <tr style="font-weight: bold;">
            <td style="width: 200px;">Subtotal Crianças</td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Criança']['0 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Criança']['ate 70 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Criança']['70 a 140 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Criança']['140 a 240 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Criança']['240 a 545 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Criança']['acima 545 reais']) ?></td>
        </tr>
    </tbody>
</table>
<br />

<table style="text-align: center; margin-left: 0px;" border="1" cellpadding="2" cellspacing="0">
    <tbody>
        <tr>
            <td style="width: 60px;" rowspan="7"><span class="rotate">Adolescentes</span></td>
            <td style="width: 200px;">10 anos</td>
            <td style="width: 110px;"><?php echo $valorRenda['Adolescente']['0 reais'][10] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Adolescente']['ate 70 reais'][10] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Adolescente']['70 a 140 reais'][10] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Adolescente']['140 a 240 reais'][10] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Adolescente']['240 a 545 reais'][10] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Adolescente']['acima 545 reais'][10] ?></td>
        </tr>
        <?php
        for ($i = 10; $i <= 14; $i++):
            ?>
            <tr>
                <td style="width: 200px;"><?php echo $i; ?> anos</td>
                <td style="width: 110px;"><?php echo $valorRenda['Adolescente']['0 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Adolescente']['ate 70 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Adolescente']['70 a 140 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Adolescente']['140 a 240 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Adolescente']['240 a 545 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Adolescente']['acima 545 reais'][$i] ?></td>
            </tr>
            <?php
        endfor;
        ?>
        <tr style="font-weight: bold;">
            <td style="width: 200px;">Subtotal Adolescentes</td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Adolescente']['0 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Adolescente']['ate 70 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Adolescente']['70 a 140 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Adolescente']['140 a 240 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Adolescente']['240 a 545 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Adolescente']['acima 545 reais']) ?></td>
        </tr>
    </tbody>
</table>
<br />

<table style="text-align: center; margin-left: 0px;" border="1" cellpadding="2" cellspacing="0">
    <tbody>
        <tr>
            <td style="width: 60px;" rowspan="4"><span class="rotate">Jovens</span></td>
            <td style="width: 200px;">15 anos</td>
            <td style="width: 110px;"><?php echo $valorRenda['Jovem']['0 reais'][15] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Jovem']['ate 70 reais'][15] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Jovem']['70 a 140 reais'][15] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Jovem']['140 a 240 reais'][15] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Jovem']['240 a 545 reais'][15] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Jovem']['acima 545 reais'][15] ?></td>
        </tr>
        <?php
        for ($i = 16; $i <= 17; $i++):
            ?>
            <tr>
                <td style="width: 200px;"><?php echo $i; ?> anos</td>
                <td style="width: 110px;"><?php echo $valorRenda['Jovem']['0 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Jovem']['ate 70 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Jovem']['70 a 140 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Jovem']['140 a 240 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Jovem']['240 a 545 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Jovem']['acima 545 reais'][$i] ?></td>
            </tr>
            <?php
        endfor;
        ?>
        <tr style="font-weight: bold;">
            <td style="width: 200px;">Subtotal Jovens</td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Jovem']['0 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Jovem']['ate 70 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Jovem']['70 a 140 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Jovem']['140 a 240 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Jovem']['240 a 545 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Jovem']['acima 545 reais']) ?></td>
        </tr>
    </tbody>
</table>
<br />

<table style="text-align: center; margin-left: 0px;" border="1" cellpadding="2" cellspacing="0">
    <tbody>
        <tr>
            <td style="width: 60px;" rowspan="43"><span class="rotate">Adultos</span></td>
            <td style="width: 200px;">18 anos</td>
            <td style="width: 110px;"><?php echo $valorRenda['Adulto']['0 reais'][18] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Adulto']['ate 70 reais'][18] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Adulto']['70 a 140 reais'][18] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Adulto']['140 a 240 reais'][18] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Adulto']['240 a 545 reais'][18] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Adulto']['acima 545 reais'][18] ?></td>
        </tr>
        <?php
        for ($i = 19; $i <= 59; $i++):
            ?>
            <tr>
                <td style="width: 200px;"><?php echo $i; ?> anos</td>
                <td style="width: 110px;"><?php echo $valorRenda['Adulto']['0 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Adulto']['ate 70 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Adulto']['70 a 140 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Adulto']['140 a 240 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Adulto']['240 a 545 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Adulto']['acima 545 reais'][$i] ?></td>
            </tr>
            <?php
        endfor;
        ?>
        <tr style="font-weight: bold;">
            <td style="width: 200px;">Subtotal Adultos</td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Adulto']['0 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Adulto']['ate 70 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Adulto']['70 a 140 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Adulto']['140 a 240 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Adulto']['240 a 545 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Adulto']['acima 545 reais']) ?></td>
        </tr>
    </tbody>
</table>
<br />

<table style="text-align: center; margin-left: 0px;" border="1" cellpadding="2" cellspacing="0">
    <tbody>
        <tr>
            <td style="width: 60px;" rowspan="11"><span class="rotate">Idosos</span></td>
            <td style="width: 200px;">60 anos</td>
            <td style="width: 110px;"><?php echo $valorRenda['Idoso']['0 reais'][60] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Idoso']['ate 70 reais'][60] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Idoso']['70 a 140 reais'][60] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Idoso']['140 a 240 reais'][60] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Idoso']['240 a 545 reais'][60] ?></td>
            <td style="width: 110px;"><?php echo $valorRenda['Idoso']['acima 545 reais'][60] ?></td>
        </tr>
        <?php
        for ($i = 61; $i <= 65; $i++):
            ?>
            <tr>
                <td style="width: 200px;"><?php echo ($i == 65) ? '≥ ' . $i : $i; ?> anos</td>
                <td style="width: 110px;"><?php echo $valorRenda['Idoso']['0 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Idoso']['ate 70 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Idoso']['70 a 140 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Idoso']['140 a 240 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Idoso']['240 a 545 reais'][$i] ?></td>
                <td style="width: 110px;"><?php echo $valorRenda['Idoso']['acima 545 reais'][$i] ?></td>
            </tr>
            <?php
        endfor;
        ?>
        <tr style="font-weight: bold;">
            <td style="width: 200px;">Subtotal Idosos</td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Idoso']['0 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Idoso']['ate 70 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Idoso']['70 a 140 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Idoso']['140 a 240 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Idoso']['240 a 545 reais']) ?></td>
            <td style="width: 110px;"><?php echo array_sum($valorRenda['Idoso']['acima 545 reais']) ?></td>
        </tr>
    </tbody>
</table>
<br />

<table style="text-align: center; margin-left: 0px;" border="1" cellpadding="2" cellspacing="0">
    <tbody>
        <tr style="font-weight: bold;">
            <td style="width: 255px;">Total</td>
            <td style="width: 105px;"><?php echo $valorRenda['0 reais'] ?></td>
            <td style="width: 105px;"><?php echo $valorRenda['ate 70 reais'] ?></td>
            <td style="width: 105px;"><?php echo $valorRenda['70 a 140 reais'] ?></td>
            <td style="width: 105px;"><?php echo $valorRenda['140 a 240 reais'] ?></td>
            <td style="width: 105px;"><?php echo $valorRenda['240 a 545 reais'] ?></td>
            <td style="width: 105px;"><?php echo $valorRenda['acima 545 reais'] ?></td>
        </tr>
    </tbody>
</table>
<br />
Tempo de processamento: <?php echo $valorRenda['tempo'] ?> segundos.