<?php

$fazer  = $_REQUEST['fazer'];
$codigo = $_REQUEST['codigo'];
$id_aluno = $_REQUEST['id_aluno'];

// echo "Fazer: " . $fazer . " Código: " . $codigo . "<br>";
// die();

include("../../autentica.inc");
require_once("elimina.php");

if ($fazer == 'seleciona_elimina')
	seleciona_elimina();

if ($fazer == 'elimina')
	elimina($codigo);
	
if ($fazer == 'excluialuno')
	excluialuno($id_aluno, $codigo);

?>