<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<ul>
    <li><a href="#" class="hide pai">Sobre</a>
        <ul>
            <li>
                <a href="http://www.pjf.mg.gov.br/sas/" target="_blank" class="hide">SAS</a>
            </li>
            <?php
            foreach ($paginas as $pagina) {
                ?>

                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'pages', 'action' => $pagina['Page']['link'])); ?>" class="hide"><?php echo $pagina['Page']['titulo'] ?></a>
                </li>
                <?php
            }
            ?>
        </ul>
    </li>
</ul>