<?php

$fazer  = $_REQUEST['fazer'];
$codigo = $_REQUEST['codigo'];

include("../../autentica.inc");
require_once("elimina.php");

if($fazer == 'seleciona_elimina')
	seleciona_elimina();

if($fazer == 'elimina')
	elimina($codigo);
	
?>