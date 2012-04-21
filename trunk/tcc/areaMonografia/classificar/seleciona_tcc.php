<?php

function seleciona_tcc()
	// Seleciono numero de tcc, retorno com esse valor para *main*
	// e volto com o numero de tcc para a funcao muda_area()
	{
	echo "
	<html>
	<head>
	<title>Classifica cada monografia</title>
	<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
	";
	require_once("../../include_db.inc");
	$sql = "select * from monografia order by titulo";
	$resultado = $db->Execute($sql);
	if ($resultado == false) die ("Não foi possivel consultar a tabela monografia");

	echo "
	<form name='seleciona_monografia' action='main.php' method='post'>
	<select name='codigo' size='1'>
	<option value='0'>Seleciona monografia</option>
	";
	while (!$resultado->EOF)
		{
		$codigo   = $resultado->fields['codigo'];
		$titulo   = $resultado->fields['titulo'];
		$num_prof = $resultado->fields['num_prof'];
		$titulo_pequeno = substr($titulo,0,60);
		echo "
		<option value='$codigo'>$titulo_pequeno</option>
		";
		$areamonografia = $resultado->fields['areamonografia'];
		$resultado->MoveNext();
		}

	$db->Close();

	echo "
	</select>
	<input type='hidden' name='mudar_area' value='1'>
	<input type='submit' name='submit' value='Confirma'>
	</form>
	";
	
	}

function muda_area($codigo) {
	require_once("../../include_db.inc");
	$sql = "select monografia.codigo, monografia.titulo, monografia.periodo, "
	. " professores.nome, areasmonografia.id, areasmonografia.areamonografia "
	. " from monografia "
	. " inner join professores on monografia.num_prof = professores.id "
	. " left outer join areasmonografia on monografia.areamonografia = areasmonografia.id "
	. " where codigo = $codigo "
	. " order by titulo";
	// echo $sql . "<br>";
	$resultados =$db->Execute($sql);
	if ($resultados == false) die ("Não foi possível consultar a tabela monografia");
	while (!$resultados->EOF)
		{
		$codigo   = $resultados->fields['codigo'];
		$titulo   = $resultados->fields['titulo'];
		$periodo  = $resultados->fields['periodo'];
		$nome     = $resultados->fields['nome'];
		$id_area  = $resultados->fields['id'];
		$area     = $resultados->fields['areamonografia'];
		if (empty($area)) {
			$area = "Selecione área";
			}
		$resultados->MoveNext();
		}

	echo "
	<div align='center'>
	<table>
	<form name='seleciona_monografia' action='main.php' method='post'>
	<tr><td colspan='3'>$periodo</td></tr>
	<tr class='titulo_monografia'><td colspan='3'>$titulo</td></tr>
	";
	include("alunos.inc");
	echo "
	<tr><td>Aluno(s)</td><td>$aluno</td></tr>
	<tr><td>Professor: </td><td>$nome</td></tr>
	<tr><td>Área da monografia: </td>
	<td>
	<select name='id_area' id='id_area' size='1'>
	<option value=$id_area>$area</option>
	";
	
	$sql_outras_areas = "select * from areasmonografia order by areamonografia";
	echo $sql_outras_areas . "<br>"; 
	$resultado_outras_areas = $db->Execute($sql_outras_areas);
	if ($resultado_outras_areas == false) die ("Não foi possível consultar a tabela areasmonografia");
	while (!$resultado_outras_areas->EOF)
		{
		$id_area = $resultado_outras_areas->fields['id'];
		$areamonografia = $resultado_outras_areas->fields['areamonografia'];
		echo "
		<option value='$id_area'>$areamonografia</option>
		";
		$resultado_outras_areas->MoveNext();
		}
	echo "
	</select>
	<td>
	</tr>
	";

	$db->Close();
		
	$indice++;
	
	echo "	
	<input type='hidden' name='salvar' value='sem'>
	<input type='hidden' name='codigo' value='$codigo'>
	<input type='hidden' name='indice' value='$indice'>

	<tr><td></td>
	<td class=\"ultima_linha_tabela\">
	<input type='submit' name='submit' value='Confirma'>
	</td>
	</tr>
		
	</form>
	</table>
	</div>
	";
	}

?>