<?php

echo "
<html>
<head>
<link href='../css/tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";

$acao = $_REQUEST['acao'];

include("../data.php");
$data_arquivo = $dia_arquivo . "/" . $mes_arquivo . "/" . $ano_arquivo;

$sql = "select distinct periodo from monografia order by periodo";
include("../include_db.inc");
$resultado = $db->Execute($sql);
if($resultado == false) die ("Não foi possível consultar a tabela monografia");

echo "
<form action='$acao' name='declaracoes' method='post'>
<div>
<table>
<tr>
<td>
<select name='periodo' size='1'>
<option value=0>Selecione periodo</option>
";
while(!$resultado->EOF)
	{
	$periodo = $resultado->fields['periodo'];
	$resultado->MoveNext();
	
	echo "
	<option value=$periodo>$periodo</option>
	";
	}

echo "
</select>
</td>
<td>
<input type='hidden' name='data_arquivo' value=$data_arquivo>
<input type='submit' name='submit' value='Enviar'>
</td>
</tr>
</table>
</div>
</form>
";
	
?>