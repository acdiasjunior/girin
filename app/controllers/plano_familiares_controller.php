<?php

class PlanoFamiliaresController extends AppController {

    var $name = 'PlanoFamiliares';

    function index() {
        parent::temAcesso();
        $temAcessoExclusao = parent::temAcessoExclusao();
        $this->set(compact('temAcessoExclusao'));
    }

    function lista() {
        $this->layout = 'ajax';

        $this->PlanoFamiliar->recursive = -1;

        $conditions = array(
            'Bairro.id_cras IN(' . $this->crasUsuario() . ')',
        );

        if ($this->params['form']['query'] != '')
            $conditions[sprintf('UPPER(%s) LIKE', $this->params['form']['qtype'])]
                    = sprintf('%%%s%%', str_replace(' ', '%', stroupper($this->params['form']['query'])));

        $this->paginate = array(
            'joins' => array(
                array(
                    'table' => 'tb_domicilio',
                    'alias' => 'Domicilio',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'PlanoFamiliar.cod_domiciliar = Domicilio.cod_domiciliar',
                    )
                ),
                array(
                    'table' => 'tb_bairro',
                    'alias' => 'Bairro',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Bairro.id_bairro = Domicilio.id_bairro',
                    )
                ),
                array(
                    'table' => 'tb_cras',
                    'alias' => 'Cras',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Bairro.id_cras = Cras.id_cras',
                    )
                ),
                array(
                    'table' => 'tb_indice',
                    'alias' => 'Indice',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'Domicilio.cod_domiciliar = Indice.cod_domiciliar',
                    )
                ),
                array(
                    'table' => 'tb_usuario',
                    'alias' => 'Usuario',
                    'type' => 'LEFT',
                    'conditions' => array(
                        'PlanoFamiliar.id_usuario = Usuario.id_usuario',
                    )
                ),
            ),
            'fields' => array(
                'PlanoFamiliar.id_plano_familiar', 'PlanoFamiliar.num_plano_familiar', 'Domicilio.cod_domiciliar',
                'Cras.desc_cras', 'Indice.vlr_idf', 'Usuario.nome_usuario', 'PlanoFamiliar.created'
            ),
            'page' => $this->params['form']['page'],
            'limit' => $this->params['form']['rp'],
            'order' => array(
                $this->params['form']['sortname'] => $this->params['form']['sortorder']
            ),
            'conditions' => $conditions
        );

        $plano_familiares = $this->paginate($this->modelClass);
        $page = $this->params['form']['page'];
        $total = $this->params['paging'][$this->modelClass]['count'];
        $this->set(compact('plano_familiares', 'page', 'total'));
    }

    function excluir($id) {
        parent::temAcesso();
        if (!empty($id)) {
            $this->PlanoFamiliar->delete($id);
            $this->Session->setFlash('O plano familiar com código: ' . $id . ' foi excluída.');
        } else {
            $this->Session->setFlash('Erro ao tentar excluir: id inexistente!');
        }
        $this->redirect(array('action' => 'index'));
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

    function gerarPlanoFamiliar($cod_domiciliar = null) {
        parent::temAcesso();
        if ($cod_domiciliar == null)
            $this->redirect(array('action' => 'index'));

        $this->loadModel('Indice');
        $this->loadModel('Indicador');
        $this->loadModel('EstrategiaIndicador');

        $this->Indice->recursive = -1;
        $indices = $this->Indice->read($this->Indice->indicadores, $cod_domiciliar);

        $this->Indicador->displayField = 'cod_coluna_indicador';
        $indicadores = $this->Indicador->find('list');

        $this->data = array();
        $this->data['PlanoFamiliar'] = array(
            'cod_domiciliar' => $cod_domiciliar,
            'id_usuario' => $this->Session->read('Auth.Usuario.id_usuario'),
            'num_plano_familiar' => (int) $this->PlanoFamiliar->field('MAX(num_plano_familiar)', array('cod_domiciliar' => $cod_domiciliar)) + 1,
        );

        foreach ($indices['Indice'] as $key => $value) {
            if ($value == '0' && array_search($key, $indicadores) !== false) {
                $list[array_search($key, $indicadores)] = $key;
                $this->data['Indicador']['Indicador'][] = array_search($key, $indicadores);
            }
        }

        $conditions = isset($list) ? array("id_indicador IN ('" . implode("','", array_keys($list)) . "')") : '';

        $estrategias = $this->EstrategiaIndicador->find('all', array(
            'fields' => array(
                'DISTINCT(EstrategiaIndicador.id_estrategia)',
            ),
            'conditions' => $conditions
                )
        );

        foreach ($estrategias as $estrategia) {
            $this->data['Estrategia']['Estrategia'][] = $estrategia[0]['id_estrategia'];
        }

        if ($this->PlanoFamiliar->save($this->data)) {
            $this->redirect(array('controller' => 'plano_familiares', 'action' => 'gerarPDF', $this->PlanoFamiliar->id));
        } else {
            $this->Session->setFlash('Ocorreu um erro ao gravar o prontuário!');
            $this->redirect(array('controller' => 'plano_familiares', 'action' => 'index'));
        }
    }

    function exibirPlanoFamiliar($id) {
        parent::temAcesso();
        $this->layout = 'ajax';
        $this->PlanoFamiliar->recursive = 2;
        $this->data = $this->PlanoFamiliar->read();
        $this->loadModel('Estrategia');
        $total_estrategias = $this->Estrategia->find('count');
        $this->set(compact('total_estrategias'));
    }

    function gerarPDF($id) {
        $this->autoRender = false;
        $cod_domiciliar = $this->PlanoFamiliar->field('cod_domiciliar');
        $num_plano_familiar = $this->PlanoFamiliar->field('num_plano_familiar');
        $html = $this->requestAction(array('controller' => 'plano_familiares', 'action' => 'exibirPlanoFamiliar'), array('return', 'pass' => array($id)));
        App::import('Vendor', 'mpdf53/mpdf');
        $pdf = new mPDF('utf-8', 'A4-L', '', '', 15, 15, 25, 15, 10, 10);
        //The last parameters are all margin values in millimetres: left-margin, right-margin, top-margin, bottom-margin, header-margin, footer-margin.
        $setFooter = $pdf->SetFooter("Prontuário no. " . str_pad($num_plano_familiar, 4, "0", STR_PAD_LEFT) . "|Código Domiciliar: $cod_domiciliar|{PAGENO}");
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
        $pdf->Output('PlanoFamiliar_' . $cod_domiciliar . '_' . str_pad($num_plano_familiar, 4, "0", STR_PAD_LEFT) . '.pdf', 'D');
    }

    private function crasUsuario() {
        $this->loadModel('Usuario');
        $this->Usuario->id = $this->Session->read('Auth.Usuario.id_usuario');
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