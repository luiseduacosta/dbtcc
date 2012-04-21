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
$salvar = $_REQUEST['salvar'];
$id_area = $_REQUEST['id_area'];

// echo $opcao . " " . $mudar_area . " " . $codigo . "<br>";
// 480-9101

if($opcao == "muda_area") {
	include("seleciona_tcc.php");
	seleciona_tcc();
	}
	
if($mudar_area == '1') {
	include("seleciona_tcc.php");
	muda_area($codigo);
	}

if($salvar == "se") {
	$sql = "update monografia set areamonografia='$id_area' where codigo='$codigo'";
	// echo $sql . "<br>";
	include("../../include_db.inc");
	$resposta = $db->Execute($sql);
	if($resposta == false) die ("Nao foi possivel atualizar a tabela monografia");
	$db->Close();
	echo "<h1>Registro atualizado !!</h1>";
	}

?>