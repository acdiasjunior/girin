<?php
$logado = $this->Session->check('Auth.Usuario');
//var_dump($this); die();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php echo $this->Html->charset(); ?>
        <title>
            SAS - Programação Local
        </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('redmond/jquery-ui-1.8.12.custom');
        echo $this->Html->css('estilos');
        echo $this->Html->css('campos');
        echo $this->Html->css('menu');
        echo $javascript->link(array('jquery-1.6.2.min', 'jquery-ui-1.8.12.custom.min', 'jquery-ui-timepicker-addon', 'jquery.ui.datepicker-pt-BR', 'jquery.regex', 'hideflash', 'focusfirst'), true);
        echo $scripts_for_layout;
        ?>
    </head>
    <body>
        <div id="pagecontainer">
            <div id="pageheader">
                <div style="float: left;">
                    <?php
                    echo $this->Html->link(
                            $this->Html->image('logos/logo_agenda_familia.png', array('alt' => '', 'border' => '0')), '/', array('target' => '_parent', 'escape' => false)
                    );
                    ?>
                </div>
                <div style="width: 750px; float: left; text-align: center; text-decoration: none; color: #5c7492; font-size: 30pt; font-weight: bold; line-height: 40px;">
                    SIMAS
                </div>
                <div style="width: 750px; float: left; text-align: center; text-decoration: none; color: #5c7492; font-size: 12pt; font-weight: bold;">
                    Sistema de Informação e Monitoramento da Assistência Social.
                </div>
            </div>
            <div id="pagebody">
                <div id="pagebody_menu">
                    <div id="pagebody_menu_aba">
                        <?php echo $this->Html->image('menu_aba_esq.jpg', array('id' => 'pagebody_menu_aba_esq', 'alt' => '', 'width' => 17, 'height' => 24)); ?>
                        <div class="menu">
                            <?php
                            if ($logado)
                                echo $this->element('menu_logado');
                            else
                                echo $this->element('menu_deslogado');
                            ?>
                        </div>
                        <?php echo $this->Html->image('menu_aba_dir.jpg', array('id' => 'pagebody_menu_aba_dir', 'alt' => '', 'width' => 17, 'height' => 24)); ?>
                        <span style="float: right; margin-right: 10px;">
                            <?php
                            if ($logado) {
                                echo 'Logado como: ' . $this->Session->read('Auth.Usuario.nome_usuario') . ' &nbsp;&nbsp;&nbsp;';
                                echo $this->Html->link('Sair', array('controller' => 'usuarios', 'action' => 'logout'), array('target' => '_parent', 'style' => 'color: white; text-decoration: none; font-weight: bold;'));
                            }
                            ?>
                        </span>
                    </div>
                </div>
            </div>
            <div id="pagecontent">
                <?php echo $this->Session->flash(); ?>
                <?php echo $content_for_layout; ?>
            </div>
            <div style="width: 1000px; height: 5px; position: absolute; bottom: 70px; background-color: #145a75;"></div>
            <div id="pagefooter">
                <div style="float: left; margin-right: 30px;">
                    <?php
                    echo $this->Html->link(
                            $this->Html->image('logos/logopjf.png', array('alt' => '', 'border' => '0', 'height' => '50px')), 'http://www.pjf.mg.gov.br/sas/', array('target' => '_blank', 'escape' => false)
                    );
                    ?>
                </div>
                <div style="float: right; text-align: right;">
                    <span style="font-size: 11pt; font-weight: bold;">Secretaria de Assistência Social</span>
                    <br /><span style="font-size: 10pt;">Subsecretaria de Vigilância e
                        <br />Monitoramento da Assistência Social</span>
                </div>
            </div>
        </div>
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>
