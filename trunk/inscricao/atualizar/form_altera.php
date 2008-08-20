<?php

$aluno_registro = $_REQUEST['aluno_registro'];

$sql_inscricao = "select * from inscricao where registro=$aluno_registro";
include("../../include_db.inc");
$resultado = $db->Execute($sql_inscricao);
if($resultado === false) die ("Não foi possível consultar a tabela inscricao");
while(!$resultado->EOF)
{
	$id             = $resultado->fields['numero'];
	$registro_atual = $resultado->fields['registro'];
	$aluno          = $resultado->fields['nome'];
	$num_professor  = $resultado->fields['num_professor'];
	$num_area       = $resultado->fields['num_area'];
	$acordo         = $resultado->fields['acordo'];
	$data_sql       = $resultado->fields['data'];
	$periodo        = $resultado->fields['periodo'];
	$resultado->MoveNext();

	if($num_professor != 0)	
	{
		$sql_professor = "select nome from professores where numero=$num_professor";
		$resultado_professor = $db->Execute($sql_professor);
		while(!$resultado_professor->EOF)
		{
			$nome_professor = $resultado_professor->fields['nome'];
			$resultado_professor->MoveNext();
		}
	}
	else
		$nome_professor = "s/d";
		
	$sql_area = "select area from areas where numero=$num_area";
	$resultado_area = $db->Execute($sql_area);
	if($resultado_area === false) die ("Não foi possível consultar a tabela areas");
	while(!$resultado_area->EOF)
	{
		$nome_area = $resultado_area->fields['area'];
		$resultado_area->MoveNext();
	}
}
	
$dia = substr($data_sql,8,2);
$mes = substr($data_sql,5,2);
$ano = substr($data_sql,0,4);
$data = $dia . "/" . $mes . "/" . $ano;

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<div align='center'>
<table>
<form name='form_altera' action='update.php' method='post'>
<tr>
	<td>Aluno:</td>
	<td><input type='text' name='aluno' value='$aluno' size='50'></td>
</tr>
<tr>
	<td>Registro:</td>
	<td><input type='text' name='registro_novo' value=$registro_atual size='10'>
	(Digite 99 para indicar \"sem informação\")</td>
</tr>
<tr>
	<td>Orientador:</td>
	<td>
	";
	$sql_outro_professor = "select * from professores order by nome";
	$resultado_outro_professor = $db->Execute($sql_outro_professor);
	if($resultado_outro_professor === false) die ("Não foi possível consultar a tabela professores");
    echo"
	<select name='numero_professor' size='1'>
	<option value=$num_professor>$nome_professor</option>
	";
	while(!$resultado_outro_professor->EOF)
		{
		$nome_professor   = $resultado_outro_professor->fields['nome'];
		$numero_professor = $resultado_outro_professor->fields['numero'];
		$resultado_outro_professor->MoveNext();
		echo "
		<option value=$numero_professor>$nome_professor</option>
		";
		}
	echo "
	</select>
	</td>
</tr>
<tr>
	<td>Área:</td>
	<td>
	";
	$sql_outra_area = "select * from areas order by area";
	$resultado_outra_area = $db->Execute($sql_outra_area);
	if($resultado_outra_area === false) die ("Não foi possível consultar a tabela areas");
	echo"
	<select name='numero_area' size='1'>
	<option value=$num_area>$nome_area</option>
	";
	while(!$resultado_outra_area->EOF)
		{
		$area        = $resultado_outra_area->fields['area'];
		$numero_area = $resultado_outra_area->fields['numero'];
		$resultado_outra_area->MoveNext();
		echo "
		<option value=$numero_area>$area</option>		
		";
		}
	echo "	
	</select>

	</td>
</tr>

<tr>
	<td>Acordo:</td>
	<td>
	";
	if($acordo == "s")
		{
		echo "
		<input type='radio' value='s' name='acordo' checked>Sim
		<input type='radio' value='n' name='acordo'>Não
		";
		}
	elseif($acordo == "n")
		{
		echo "	
		<input type='radio' value='s' name='acordo'>Sim
		<input type='radio' value='n' name='acordo' checked>Não
		";
		}
	echo "		
	</td>
</tr>
<tr>
	<td>Data:</td>
	<td><input type='text' name='data' value=$data size='10'></td>
</tr>
<tr>
	<td>Período:</td>
	<td><input type='text' name='periodo' value=$periodo size='10'></td>
</tr>

</table>
</div>
";

echo "
<input type='hidden' name='id' value=$id>		
<input type='hidden' name='registro_atual' value=$registro_atual>

<div align='center'>
<table>
<tr>
<td><input type='submit' name='enviar' value='Confirma'></td>
<td><input type='reset' name='limpar' value='Limpar'></td>
</tr>
</table>
</div>
";

$db->Close();

?>