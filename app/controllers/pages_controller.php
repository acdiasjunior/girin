<?php

class PagesController extends AppController
{

    var $name = 'Pages';
    var $helpers = array('Html', 'Session');
    var $uses = array('Pagina');

    function display()
    {
        $path = func_get_args();

        $count = count($path);
        if (!$count) {
            $this->redirect('/');
        }
        $page = $subpage = $title_for_layout = null;

        if (!empty($path[0])) {
            $page = $path[0];
        }
        if (!empty($path[1])) {
            $subpage = $path[1];
        }
        if (!empty($path[$count - 1])) {
            $title_for_layout = Inflector::humanize($path[$count - 1]);
        }
        $this->set(compact('page', 'subpage', 'title_for_layout'));
        $this->render(implode('/', $path));
    }

    function pagina($link)
    {
        $pagina = $this->Page->findByLink($link);
        $this->set('conteudo', $pagina['Page']['conteudo']);
        $this->set('title_for_layout', $pagina['Page']['titulo']);
    }

    function beforeFilter()
    {
        parent::beforeFilter();
        $this->Auth->allow(array('pagina'));
    }

}
