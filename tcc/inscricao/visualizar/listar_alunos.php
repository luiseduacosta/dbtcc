<?php

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";

$ordem = $_REQUEST['ordem'];
/* Abro uma conexão com o banco da dados */
require_once("../../include_db.inc");

$i = 0;
$sql_inscricao = "select * from inscricao order by nome";
$resultado = $db->Execute($sql_inscricao);
if($resultado === false) die ("Não foi possível consultar a tabela inscricao");
while(!$resultado->EOF)
{
	$registro      = $resultado->fields['registro'];
	$aluno         = $resultado->fields['nome'];
	$num_professor = $resultado->fields['num_professor'];
	$num_area      = $resultado->fields['num_area'];
	$acordo        = $resultado->fields['acordo'];
	$data          = $resultado->fields['data'];
	$periodo       = $resultado->fields['periodo'];
	$resultado->MoveNext();
	
	// Para ordenar a matriz
	if(empty($ordem))
	    $ordem = 'registro';
	else
	    $indice = $ordem;
	    
	$matriz[$i][$ordem] = $$indice;
	// Fim 
	
	if($num_professor != 0)	
	{
		$sql_professor = "select nome from professores where numero=$num_professor";
		$resultado_professor = $db->Execute($sql_professor);
		if($resultado_professor === false) die ("Não foi possível consultar a tabela professores");
		while(!$resultado_professor->EOF)
		{
			$professor = $resultado_professor->fields['nome'];
			$resultado_professor->MoveNext();
		}
		$matriz[$i]['professor'] = $professor;
	}
	else
	{
		$matriz[$i]['professor'] = ' s/d'; // Eh necessario para a ordenacao dos dados
	}
		
	$sql_area = "select area from areas where numero=$num_area";
	$resultado_area = $db->Execute($sql_area);
	if($resultado_area === false) die ("Não foi possível consultar a tabela areas");
	while(!$resultado_area->EOF)
	{
		$area = $resultado_area->fields['area'];
		$resultado_area->MoveNext();
	}
	
	$matriz[$i]['registro']  = $registro;
	$matriz[$i]['aluno']     = $aluno;
	$matriz[$i]['area']      = $area;
	$matriz[$i]['acordo']    = $acordo;
	$matriz[$i]['data']      = $data;
	$matriz[$i]['periodo']   = $periodo;

	$i++;		

}

$db->Close();

echo "
<table>
<tr>
<th><a href=$_SERVER[PHP_SELF]?ordem=registro>Registro</th>
<th><a href=$_SERVER[PHP_SELF]?ordem=aluno>Aluno</a></th>
<th><a href=$_SERVER[PHP_SELF]?ordem=professor>Professor</a></th>
<th><a href=$_SERVER[PHP_SELF]?ordem=area>Área</a></th>
<th><a href=$_SERVER[PHP_SELF]?ordem=acordo>Acordo</a></th>
<th>Periodo</th>
</tr>
";

reset($matriz);
sort($matriz);

for($i=0;$i < sizeof($matriz);$i++)
	{
	$registro  = $matriz[$i]['registro'];	
	$aluno     = $matriz[$i]['aluno'];
	$professor = $matriz[$i]['professor'];
	$area      = $matriz[$i]['area'];
	$acordo    = $matriz[$i]['acordo'];
	$periodo   = $matriz[$i]['periodo'];
	echo "
	<tr>
	<td>$registro</td>
	<td>$aluno</td>
	<td>$professor</td>
	<td>$area</td>
	<td>$acordo</td>
	<td>$periodo</td>
	</tr>
	";
	}

echo "
</table>
";

?>