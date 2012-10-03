<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
<ul>
    <li><a href="#" class="hide pai">Cadastros</a>
        <ul>
            <li>
                <a href="#" class="hide">Pessoas »</a>
                <ul>
                    <li>
                        <a href="<?php echo $this->Html->url(array('controller' => 'pessoas', 'action' => 'index')); ?>">Listar</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->Html->url(array('controller' => 'pessoas', 'action' => 'importar')); ?>">Importar</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="hide">Domicílios »</a>
                <ul>
                    <li>
                        <a href="<?php echo $this->Html->url(array('controller' => 'domicilios', 'action' => 'index')); ?>">Listar</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->Html->url(array('controller' => 'domicilios', 'action' => 'importar')); ?>">Importar</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="hide">Serviços »</a>
                <ul>
                    <li>
                        <a href="<?php echo $this->Html->url(array('controller' => 'servicos', 'action' => 'index')); ?>">Listar</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->Html->url(array('controller' => 'servicos', 'action' => 'cadastro')); ?>">Cadastro</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="hide">Território »</a>
                <ul>
                    <li>
                        <a href="<?php echo $this->Html->url(array('controller' => 'bairros', 'action' => 'index')); ?>">Bairros</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->Html->url(array('controller' => 'cras', 'action' => 'index')); ?>">CRAS</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->Html->url(array('controller' => 'regioes', 'action' => 'index')); ?>">Regiões</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="hide">Agenda »</a>
                <ul>
                    <li>
                        <a href="<?php echo $this->Html->url(array('controller' => 'acoes', 'action' => 'index')); ?>">Ações</a>
                    </li>
                    <li>
                        <a href="<?php echo $this->Html->url(array('controller' => 'estrategias', 'action' => 'index')); ?>">Estratégias</a>
                    </li>
                </ul>
            </li>
            <li>
                <a href="#" class="hide">IDF »</a>
                <ul>
                    <li>
                        <a href="<?php echo $this->Html->url(array('controller' => 'indicadores', 'action' => 'index')); ?>">Indicadores</a>
                    </li>
                    <!--                    <li>
                                            <a href="<?php echo $this->Html->url(array('controller' => 'dimensoes', 'action' => 'index')); ?>">Dimensões</a>
                                        </li>-->
                </ul>
            </li>
            <li>
                <a href="#" class="hide">Paginas »</a>
                <ul>
                    <li>
                        <a href="<?php echo $this->Html->url(array('controller' => 'paginas', 'action' => 'index')); ?>">Listar</a>
                    </li>
                    <?php
                    foreach ($paginas as $pagina) {
                        ?>

                        <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'pages', 'action' => $pagina['Page']['link'])); ?>"><?php echo $pagina['Page']['titulo'] ?></a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </li>
        </ul>
    </li>
    <li>
        <a href="#" class="hide pai">Estratificação</a>
        <ul>
            <li>
                <a href="<?php echo $this->Html->url(array('controller' => 'relatorios', 'action' => 'faixasEtarias')); ?>">Faixas Etárias</a>
            </li>
            <li>
                <a href="<?php echo $this->Html->url(array('controller' => 'relatorios', 'action' => 'educacaoFormal')); ?>">Educação Formal</a>
            </li>
            <li>
                <a href="<?php echo $this->Html->url(array('controller' => 'relatorios', 'action' => 'trabalhoEmprego')); ?>">Trabalho / Emprego</a>
            </li>
            <li>
                <a href="<?php echo $this->Html->url(array('controller' => 'relatorios', 'action' => 'valorRenda')); ?>">Valor Renda</a>
            </li>
        </ul>
    </li>
    <li><a href="#" class="hide pai">Classificação</a>
        <ul>
            <!--            <li>
                            <a href="#" class="hide">Índices »</a>
                            <ul>
                                <li>
                                    <a href="<?php echo $this->Html->url(array('controller' => 'indices', 'action' => 'atualizarIndices')); ?>">Atualizar Índices</a>
                                </li>
                            </ul>
                        </li>-->
            <!--            <li>
                            <a href="<?php echo $this->Html->url(array('controller' => 'relatorios', 'action' => 'vlr_idf')); ?>">Selecionar Famílias</a>
                        </li>-->
            <li>
                <a href="<?php echo $this->Html->url(array('controller' => 'indices', 'action' => 'index')); ?>">Mapa Social</a>
            </li>
            <li>
                <a href="<?php echo $this->Html->url(array('controller' => 'relatorios', 'action' => 'mapaIdfCsv')); ?>">Mapa IDF CSV</a>
            </li>
        </ul>
    </li>
    <li><a href="#" class="hide pai">Prontuários</a>
        <ul>
            <li>
                <a href="<?php echo $this->Html->url(array('controller' => 'plano_familiares', 'action' => 'index')); ?>">Listar</a>
            </li>
            <li>
                <a href="<?php echo $this->Html->url(array('controller' => 'plano_familiares', 'action' => 'gerar')); ?>">Gerar Prontuário</a>
            </li>
        </ul>
    </li>
    <li><a href="#" class="hide pai">Usuário</a>
        <ul>
            <?php
            if ($this->Session->read('Auth.Usuario.id_grupo') == 1) {
                ?>
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'usuarios', 'action' => 'index')); ?>" class="hide">Cadastro</a>
                </li>
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'permissoes', 'action' => 'index')); ?>" class="hide">Permissões</a>
                </li>
                <?php
            } else {
                ?>
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'usuarios', 'action' => 'mudarSenha')); ?>" class="hide">Mudar Senha</a>
                </li>
                <li>
                    <a href="<?php echo $this->Html->url(array('controller' => 'usuarios', 'action' => 'cadastro', $this->Session->read('Auth.Usuario.id_usuario'))); ?>" class="hide">Alterar Dados</a>
                </li>
                <?php
            }
            ?>
            <li>
                <a href="<?php echo $this->Html->url(array('controller' => 'usuarios', 'action' => 'logout')); ?>" class="hide">Sair</a>
            </li>
        </ul>
    </li>
</ul>