<?php

/*
<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";
*/

$num_prof = $_REQUEST['num_prof'];

/* Abro uma conexao com um banco da dados  */
require("../../include_db.inc");

/* Verifico si essa area � a �nica �rea do professor */
$sql = "select * from prof_area where num_prof='$num_prof'";
$resultado = $db->Execute($sql);
if($resultado == false) die  ("N�o foi possivel consultar a tabela monografia");
$quantidade = $resultado->RecordCount();

$sql_monografia = "select * from monografia where num_prof='$num_prof' and num_area='$num_area'";
$resultado_monografia = $db->Execute($sql_monografia);
$num = $resultado_monografia->RecordCount();

/* Se eh a uhnica area do professor n�o eliminar ou si a area 
est� relacionada a uma(s) monografia(s) orientada(s) pele professor*/
if($quantidade > 1 & $num == 0)
	{
	$sql_prof_area = "delete from prof_area where num_area='$num_area' and num_prof='$num_prof'";
	$resultado_prof_area = $db->Execute($sql_prof_area);
	if($resultado_prof_area == false) die ("N�o foi poss�vel consultar a tabela prof_area");
	echo "<h1>Area exclu�da!</h1>";
	}
else
	{
	if($num > 0)
		{
		echo "�rea n�o pode ser eliminada por estar relacionada com "; 
		echo "uma ou mais monografias orientadas por esse professor" . "<br>";
		echo "Para eliminar a �rea primeiro mude a �rea da(s) monografia(s) orientada(s) pelo professor";
		}
	elseif($quantidade == 1)
		echo "�rea n�o pode ser eliminada por ser a �nica deste professor.";
	else
		echo "Erro desconhecido.";
	}
  	
?>
