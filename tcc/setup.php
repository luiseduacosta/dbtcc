<?php

// define("RAIZ","/usr/local/htdocs/html/tcc/");
define("RAIZ","/home/luis/workspace/tcc/");
define("SMARTY_DIR","/usr/local/htdocs/html/Smarty/libs/");
require(SMARTY_DIR.'Smarty.class.php');
// echo SMARTY_DIR;

class template_tcc extends Smarty {

    function template_tcc() {

    $this->Smarty();

    $this->cache_dir    = RAIZ.'templates/cache/';
    $this->config_dir   = RAIZ.'templates/configs/';
    $this->template_dir = RAIZ.'templates/templates/';
    $this->compile_dir  = RAIZ.'templates/templates_c/';

    $this->caching = true;
    $this->compile_check = true;
    $this->clear_all_cache();
    $this->assign('app_name','tcc');

    }

}

define("TCC","/tcc/");

define("ADODB","/usr/local/htdocs/html/adodb/");
require_once(ADODB.'adodb.inc.php');

$tipo       = "mysql";
// $host       = "200.20.112.2";
$host       = "localhost";
$usuario    = "ess";
$senha      = "ess123";
$bancodados = "ess";

$db = NewADOConnection($tipo);
$db->Connect($host,$usuario,$senha,$bancodados);
$db->Execute("set names 'utf8'");
$db->SetFetchMode(ADODB_FETCH_ASSOC);

$root = $_SERVER[DOCUMENT_ROOT];
$nome_arquivo = $_SERVER[SCRIPT_NAME];
$camino_completo = $_SERVER[SCRIPT_FILENAME];
$pagina_de_origem = $_SERVER[HTTP_REFERER];
$servidor = $_SERVER[SERVER_NAME];
$porta_servidor = $_SERVER[SERVER_PORT];

// Quantidade de alunos por monografia
$alunos_por_monografia = 3;

?>
