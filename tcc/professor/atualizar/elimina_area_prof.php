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

/* Verifico si essa area é a única área do professor */
$sql = "select * from prof_area where num_prof='$num_prof'";
$resultado = $db->Execute($sql);
if($resultado == false) die  ("Não foi possivel consultar a tabela monografia");
$quantidade = $resultado->RecordCount();

$sql_monografia = "select * from monografia where num_prof='$num_prof' and num_area='$num_area'";
$resultado_monografia = $db->Execute($sql_monografia);
$num = $resultado_monografia->RecordCount();

/* Se eh a uhnica area do professor não eliminar ou si a area 
está relacionada a uma(s) monografia(s) orientada(s) pele professor*/
if($quantidade > 1 & $num == 0)
	{
	$sql_prof_area = "delete from prof_area where num_area='$num_area' and num_prof='$num_prof'";
	$resultado_prof_area = $db->Execute($sql_prof_area);
	if($resultado_prof_area == false) die ("Não foi possível consultar a tabela prof_area");
	echo "<h1>Area excluída!</h1>";
	}
else
	{
	if($num > 0)
		{
		echo "Área não pode ser eliminada por estar relacionada com "; 
		echo "uma ou mais monografias orientadas por esse professor" . "<br>";
		echo "Para eliminar a área primeiro mude a área da(s) monografia(s) orientada(s) pelo professor";
		}
	elseif($quantidade == 1)
		echo "Área não pode ser eliminada por ser a única deste professor.";
	else
		echo "Erro desconhecido.";
	}
  	
?>
