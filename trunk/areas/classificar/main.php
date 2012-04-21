<?php

include("../../autentica.inc");

echo "
<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";

$opcao  = $_REQUEST['opcao'];
$mudar_area = $_REQUEST['mudar_area'];
$codigo = $_REQUEST['codigo'];

// echo $opcao . "<br>";

if($opcao == "muda_area")
	{
	include("seleciona_tcc.php");
	seleciona_tcc();
	}
	
if($mudar_area == '1')
	{
	include("seleciona_tcc.php");
	muda_area($codigo);
	}

if($salvar == "sem")
	{
	$sql = "update monografia set num_area='$valor_num_area' where codigo='$codigo'";
	include("../../include_db.inc");
	$resposta = $db->Execute($sql);
	if($resposta == false) die ("Nao foi possivel atualizar a tabela monografia");
	$db->Close();
	echo "<h1>Registro atualizado !!</h1>";
	}

?>