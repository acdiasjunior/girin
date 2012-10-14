<?php

class UtilitariosController extends AppController {

    var $name = 'Utilitarios';
    var $uses = '';

    function index() {
        parent::temAcesso();
        $temAcessoExclusao = parent::temAcessoExclusao();
        $this->set(compact('temAcessoExclusao'));
    }

    function backup() {
        $file['name'] = sprintf("bkp_programacao_local_%s-%s-%s_%s-%s.sql.bz2", date('Y'), date('m'), date('d'), date('H'), date('i'));
        $file['tmp'] = TMP . 'bkp_banco_' . substr(md5(microtime()), 0, 10);
        $file['tmpbz2'] = TMP . 'bkp_banco_bz2_' . substr(md5(microtime()), 0, 10);

        App::import('Core', 'ConnectionManager');
        $dataSource = ConnectionManager::getDataSource('default');
        $username = $dataSource->config['login'];

        $db_host = $dataSource->config['host'];
        $db_user = $dataSource->config['login'];
        $db_pass = $dataSource->config['password'];
        $source_db = $dataSource->config['database'];

        App::import('Vendor', 'pg_backup_restore');
        $pgBackup = new pgBackupRestore($db_host, $db_user, $db_pass, $source_db);
        $pgBackup->UseDropTable = true;
        $file['size'] = $pgBackup->Backup($file['tmp']);

        $this->autoRender = false;

        if ($file['size'] > 0) {

            $fileBz = bzopen($file['tmpbz2'], 'w');
            $fileTmp = fopen($file['tmp'], "r");
            while (!feof($fileTmp)) {
                set_time_limit(2);
                $buffer = fread($fileTmp, 2048);
                bzwrite($fileBz, $buffer);
            }
            bzclose($fileBz);
            bzclose($fileTmp);

            header('Content-Type: application/x-bzip2');
            header('Content-Disposition: attachment;filename="' . $file['name'] . '"');
            header('Cache-Control: max-age=0');
            header("Content-length: " . $file['size']);

            $fd = fopen($file['tmpbz2'], "r");
            while (!feof($fd)) {
                set_time_limit(2);
                $buffer = fread($fd, 2048);
                echo $buffer;
            }
        } else {
            echo "Erro ao gerar backup do banco!";
        }

        unlink($file['tmp']);
        unlink($file['tmpbz2']);
    }

}