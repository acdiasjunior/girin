<?php

class ProntuariosController extends AppController {

    var $name = 'Prontuarios';

    function index() {
        
    }

    function lista() {
        $this->layout = 'ajax';

        if ($this->params['form']['query'] != '')
            $conditions = array(
                $this->params['form']['qtype'] . ' LIKE' => '%' . str_replace(' ', '%', $this->params['form']['query']) . '%'
            );
        else
            $conditions = array();

        $this->paginate = array(
            'page' => $this->params['form']['page'],
            'limit' => $this->params['form']['rp'],
            'order' => array(
                $this->params['form']['sortname'] => $this->params['form']['sortorder']
            ),
            'conditions' => $conditions
        );

        $prontuarios = $this->paginate('Prontuario');
        $page = $this->params['form']['page'];
        $total = $this->Prontuario->find('count', array('conditions' => $conditions));
        $this->set(compact('prontuarios', 'page', 'total'));
    }

    function gerarProntuario($codigo_domiciliar = null) {
        if ($codigo_domiciliar == null)
            $this->redirect(array('action' => 'index'));

        $this->loadModel('Indice');
        $this->loadModel('Indicador');
        $this->loadModel('EstrategiaIndicador');

        $this->Indice->recursive = -1;
        $indices = $this->Indice->read($this->Indice->indicadores, $codigo_domiciliar);

        $this->Indicador->displayField = 'coluna';
        $indicadores = $this->Indicador->find('list');

        $this->data = array();
        $this->data['Prontuario'] = array(
            'codigo_domiciliar' => $codigo_domiciliar,
            'usuario_id' => $this->Session->read('Auth.Usuario.id'),
            'numero_prontuario' => (int) $this->Prontuario->field('MAX(numero_prontuario)', array('codigo_domiciliar' => $codigo_domiciliar)) + 1,
        );

        foreach ($indices['Indice'] as $key => $value) {
            if ($value == '0' && array_search($key, $indicadores) !== false) {
                $list[array_search($key, $indicadores)] = $key;
                $this->data['Indicador']['Indicador'][] = array_search($key, $indicadores);
            }
        }

        $estrategias = $this->EstrategiaIndicador->find('all', array(
            'fields' => array(
                'DISTINCT(estrategia_id)',
            ),
            'conditions' => array(
                "indicador_id IN ('" . implode("','", array_keys($list)) . "')"
            ),
                )
        );

        foreach ($estrategias as $estrategia) {
            $this->data['Estrategia']['Estrategia'][] = $estrategia['EstrategiaIndicador']['estrategia_id'];
        }

        if ($this->Prontuario->save($this->data)) {
            $this->redirect(array('controller' => 'prontuarios', 'action' => 'gerarPDF', $this->Prontuario->id));
            //$this->redirect(array('controller' => 'prontuarios', 'action' => 'exibirProntuario', $this->Prontuario->id));
        } else {
            $this->Session->setFlash('Ocorreu um erro ao gravar o prontuário!');
            $this->redirect(array('controller' => 'prontuarios', 'action' => 'index'));
        }
    }

    function exibirProntuario($id) {
        $this->layout = 'ajax';
        $this->Prontuario->recursive = 2;
        $this->data = $this->Prontuario->read();
    }

    function exibirDados($id) {
        $this->layout = 'ajax';
        $this->autoRender = false;
        $this->Prontuario->recursive = 2;
        echo '<pre>';
        echo print_r($this->Prontuario->read());
        echo '</pre>';
    }

    function cadastro($id = null) {
        if (empty($this->data)) {
            $this->data = $this->Prontuario->read();
        } else {
            if ($this->Prontuario->save($this->data)) {
                $this->Session->setFlash('Cadastro salvo.');
                $this->redirect(array('controller' => $this->name, 'action' => 'index'));
            }
        }
    }

    function gerarPDF($id) {
        $this->autoRender = false;
        $codigo_domiciliar = $this->Prontuario->field('codigo_domiciliar');
        $numero_prontuario = $this->Prontuario->field('numero_prontuario');
        $html = $this->requestAction(array('controller' => 'prontuarios', 'action' => 'exibirProntuario'), array('return', 'pass' => array($id)));
        App::import('Vendor', 'mpdf53/mpdf');
        $pdf = new mPDF('utf-8', 'A4-L');
        $setFooter = $pdf->SetFooter("Prontuário no. " . str_pad($numero_prontuario, 4, "0", STR_PAD_LEFT) . "|Código Domiciliar: $codigo_domiciliar|{PAGENO}");
        $pdf->WriteHTML($html);
        $pdf->Output('Prontuario_' . $codigo_domiciliar . '_' . str_pad($numero_prontuario, 4, "0", STR_PAD_LEFT) . '.pdf', 'D');
    }

}