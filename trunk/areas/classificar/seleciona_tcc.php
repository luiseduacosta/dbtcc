<?php

function seleciona_tcc()
	// Seleciono numero de tcc, retorno com esse valor para *main*
	// e volto com o numero de tcc para a funcao muda_area()
	{
	echo "
	<html>
	<head>
	<title>Classifica cada monografia</title>
	<link href='../../tcc.css' rel='stylesheet' type='text/css'>
	</head>
	<body>
	";
	require_once("../../include_db.inc");
	$sql = "select * from monografia order by titulo";
	$resultado = $db->Execute($sql);
	if ($resultado == false) die ("Nao foi possivel consultar a tabela monografia");

	echo "
	<form name='seleciona_monografia' action='main.php' method='post'>
	<select name='codigo' size='1'>
	<option value='0'>Seleciona monografia</option>
	";
	while(!$resultado->EOF)
		{
		$codigo   = $resultado->fields['codigo'];
		$titulo   = $resultado->fields['titulo'];
		$num_prof = $resultado->fields['num_prof'];
		$titulo_pequeno = substr($titulo,0,60);
		echo "
		<option value='$codigo'>$titulo_pequeno</option>
		";
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

function muda_area($codigo)
	{
	require_once("../../include_db.inc");
	$sql = "select * from monografia where codigo='$codigo'";
	$resultados =$db->Execute($sql);
	if ($resultados == false) die ("Não foi possível consultar a tabela monografia");
	while (!$resultados->EOF)
		{
		$codigo   = $resultados->fields['codigo'];
		$titulo   = $resultados->fields['titulo'];
		$num_prof = $resultados->fields['num_prof'];
		$num_area = $resultados->fields['num_area'];
		$periodo  = $resultados->fields['periodo'];
		$resultados->MoveNext();
		}

	$sql = "select * from areas where numero='$num_area'";
	$resultados_areas = $db->Execute($sql);
	if ($resultados_areas == false) die ("Não foi possível consultar a tabela areas");
	while (!$resultados_areas->EOF) {
		$area = $resultados_areas->fields['area'];
		$resultados_areas->MoveNext();
	}
	
	$sql = "select * from professores where id='$num_prof'";
	$resultados_professores = $db->Execute($sql);
	if ($resultados_professores == false) die ("Nao foi possivel consultar a tabela professores");
	while (!$resultados_professores->EOF) {
		$nome = $resultados_professores->fields['nome'];
		$resultados_professores->MoveNext();
	}
	
	echo "
	<div align='center'>
	<table>
	<form name='seleciona_monografia' action='main.php' method='post'>
	<tr><td colspan='3'>$periodo</td></tr>
	<tr class=titulo_monografia><td colspan='3'>$titulo</td></tr>
	";
	include("alunos.inc");
	echo "
	<tr><td>Aluno(s)</td><td>$aluno</td></tr>
	<tr><td>Professor: </td><td>$nome</td></tr>
	<tr><td>Area: </td><td>$area</td>
	</tr>
	";
	
	/******************************************************************
	* Pego as areas dos professores
	*******************************************************************/
	$sql = "select * from prof_area where num_prof='$num_prof'";
	$resultados_prof_area = $db->Execute($sql);
	if($resultados_prof_area == false) die ("Nao foi possivel consultar a tabela prof_area");
	while(!$resultados_prof_area->EOF) {
		$valor_area = $resultados_prof_area->fields['num_area'];
		$sql_area = "select * from areas where numero='$valor_area' order by area";
		$resultados_areas = $db->Execute($sql_area);
		if($resultados_areas == false) die ("Nao foi possivel consultar a tabela areas");
		while(!$resultados_areas->EOF) {
			$numero_area = $resultados_areas->fields['numero'];
			$area        = $resultados_areas->fields['area'];
			$resultados_areas->MoveNext();
			}
			if($num_area == $numero_area)
			    {
			    echo "
			    <tr>
			    <td></td>
			    <td>
			    <input type='radio' name='valor_num_area' value='$numero_area' checked>$area
			    </td>
			    </tr>
			    ";
			    }
			else
			    {
			    echo "
			    <tr>
			    <td></td>
			    <td>
			    <input type='radio' name='valor_num_area' value='$numero_area'>$area
			    </td>
			    </tr>
			    ";			
			    }
			$resultados_prof_area->MoveNext();	
		}
	/*************************************************************************/
	
	$db->Close();
		
	$indice++;
	
	if ($num_area == '99') {
	    echo "
	    <tr>
	    <td></td>
	    <td>
	    <input type='radio' name='valor_num_area' value='99' checked>Não corresponde a nenhuma destas areas
	    </td>
	    </tr>
	    ";
	} else {
	    echo "
	    <tr>
	    <td></td>
	    <td>
	    <input type='radio' name='valor_num_area' value='99'>Não corresponde a nenhuma destas areas
	    </td>
	    </tr>
	    ";	
	}
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