<?php

class ProntuariosController extends AppController {

    var $name = 'Prontuarios';

    function index() {
        parent::temAcesso();
        $temAcessoExclusao = parent::temAcessoExclusao();
        $this->set(compact('temAcessoExclusao'));
    }

    function lista() {
        $this->layout = 'ajax';

        $this->Prontuario->recursive = 2;

        $conditions = array(
            'Domicilio.id_cras IN(' . $this->crasUsuario() . ')',
        );

        if ($this->params['form']['query'] != '')
            $conditions[$this->params['form']['qtype'] . ' LIKE'] = '%' . str_replace(' ', '%', $this->params['form']['query']) . '%';

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

    function filtro() {
        $this->layout = 'ajax';
        $this->loadModel('Domicilio');
        $bairros = $this->Domicilio->Bairro->find('list', array('order' => 'Bairro.nome_bairro'));
        $cras = $this->Domicilio->Cras->find('list');
        $regioes = $this->Domicilio->Regiao->find('list');
        $this->set(compact('bairros', 'cras', 'regioes'));
    }

    function gerar() {
        parent::temAcesso();
    }

    function gerarProntuario($cod_domiciliar = null) {
        parent::temAcesso();
        if ($cod_domiciliar == null)
            $this->redirect(array('action' => 'index'));

        $this->loadModel('Indice');
        $this->loadModel('Indicador');
        $this->loadModel('EstrategiaIndicador');

        $this->Indice->recursive = -1;
        $indices = $this->Indice->read($this->Indice->indicadores, $cod_domiciliar);

        $this->Indicador->displayField = 'coluna';
        $indicadores = $this->Indicador->find('list');

        $this->data = array();
        $this->data['Prontuario'] = array(
            'cod_domiciliar' => $cod_domiciliar,
            'usuario_id' => $this->Session->read('Auth.Usuario.id'),
            'numero_prontuario' => (int) $this->Prontuario->field('MAX(numero_prontuario)', array('cod_domiciliar' => $cod_domiciliar)) + 1,
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
            $this->data['Estrategia']['Estrategia'][] = $estrategia[0]['estrategia_id'];
        }

        if ($this->Prontuario->save($this->data)) {
            $this->redirect(array('controller' => 'prontuarios', 'action' => 'gerarPDF', $this->Prontuario->id));
        } else {
            $this->Session->setFlash('Ocorreu um erro ao gravar o prontuário!');
            $this->redirect(array('controller' => 'prontuarios', 'action' => 'index'));
        }
    }

    function exibirProntuario($id) {
        parent::temAcesso();
        $this->layout = 'ajax';
        $this->Prontuario->recursive = 2;
        $this->data = $this->Prontuario->read();
        $this->loadModel('Estrategia');
        $total_estrategias = $this->Estrategia->find('count');
        $this->set(compact('total_estrategias'));
    }

    function gerarPDF($id) {
        $this->autoRender = false;
        $cod_domiciliar = $this->Prontuario->field('cod_domiciliar');
        $numero_prontuario = $this->Prontuario->field('numero_prontuario');
        $html = $this->requestAction(array('controller' => 'prontuarios', 'action' => 'exibirProntuario'), array('return', 'pass' => array($id)));
        App::import('Vendor', 'mpdf53/mpdf');
        $pdf = new mPDF('utf-8', 'A4-L', '', '', 15, 15, 25, 15, 10, 10);
        //The last parameters are all margin values in millimetres: left-margin, right-margin, top-margin, bottom-margin, header-margin, footer-margin.
        $setFooter = $pdf->SetFooter("Prontuário no. " . str_pad($numero_prontuario, 4, "0", STR_PAD_LEFT) . "|Código Domiciliar: $cod_domiciliar|{PAGENO}");
        $setFooter = $pdf->SetHTMLHeader('<table cellspacing="0" cellpading="0" border="0" style="border: none; margin-bottom: 10mm;">
        <tr>
            <td style="border: none;">
                <img src="/prefeitura/img/logos/logo_agenda_familia.png" style="height: 12mm;" alt="" />            </td>
            <td style="text-align: right; border: none;">
                <img src="/prefeitura/img/logos/logopjf.png" style="height: 12mm;" alt="" />            </td>
            <td style="width: 65mm; text-align: right; border: none;">
                <span style="text-decoration: none; color: #000; font-size: 10pt; font-weight: bold;">Secretaria de Assistência Social</span>
                <br /><span style="font-size: 9pt;">Subsecretaria de Vigilância e
                    <br />Monitoramento da Assistência Social</span>
            </td>
        </tr>
    </table>');
        $pdf->WriteHTML($html);
        $pdf->Output('Prontuario_' . $cod_domiciliar . '_' . str_pad($numero_prontuario, 4, "0", STR_PAD_LEFT) . '.pdf', 'D');
    }

    private function crasUsuario() {
        $this->loadModel('Usuario');
        $this->Usuario->id = $this->Session->read('Auth.Usuario.id');
        $cras_usuario = array();

        if ($this->Usuario->id == 1) {
            $this->loadModel('Cras');
            $cras_usuario = array_keys($this->Cras->find('list'));
        } else {
            $usuario = $this->Usuario->read();
            if (count($usuario['Cras']) > 0)
                foreach ($usuario['Cras'] as $cras)
                    $cras_usuario[] = $cras['id_cras'];
        }

        return implode(',', $cras_usuario);
    }

}