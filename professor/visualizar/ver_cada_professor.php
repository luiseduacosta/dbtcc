<?php

include("../../include_db.inc");
$submit = $_REQUEST['submit'];
$index  = $_REQUEST['index'];

$sql = "select * from professores";
$resultado = $db->Execute($sql);
if($resultado == false) die ("Não foi possível consultar a tabela professores");
$nrows = $resultado->RecordCount();
$db->Close();

$ultimo = $nrows - 1;

if($submit == "Retroceder")
	{
	$index--;
	if(($index == 0) || ($index < 0))
		$index = $ultimo;
	}
elseif($submit == "Avanzar")
	{
	$index++;
	if($index == $nrows)
		$index = 0;
	}	

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<body>
<div align='center'>
<table id='tabela_ver_cada_professor' name='tabela_ver_cada_professor'>
<thead>
<caption>
Professores da Escola de Serviço Social
</caption>
</thead>

<tfoot></tfoot>
";

// Seleciono os professores um por um com a função SelectLimit()
$sqlProfessores = "select id,nome,email,departamento from professores order by nome";
include("../../include_db.inc");
$resposta = $db->SelectLimit($sqlProfessores,1,$index);
if($resposta == false) die ("Não foi possivel consultar a tabela professores");
while(!$resposta->EOF) {
	$num_prof     = $resposta->fields['id'];
	$nome         = $resposta->fields['nome'];
	$email        = $resposta->fields['email'];
	$departamento = $resposta->fields['departamento']; 
	$resposta->MoveNext();
	
	echo "
	<tr><td width='20%'>Nome</td><td>$nome</td></tr>
	<tr><td>Departamento</td><td>$departamento</td></tr>
	<tr><td>E-mail</td><td>$email</td></tr>
	<tr><th colspan='3'>Area(s)</th></tr>
	";

	$sql = "select * from prof_area where num_prof='$num_prof'";
	$resposta_prof_area = $db->Execute($sql);
	if($resposta_prof_area == false) die ("Não foi possivel consultar a tabela prof_area");
	while(!$resposta_prof_area->EOF)
		{
		$num_area = $resposta_prof_area->fields['num_area'];
		$resposta_prof_area->MoveNext();
		
		$sql = "select * from areas where numero='$num_area'";
		$resposta_areas = $db->Execute($sql);
		if($resposta_areas == false) die ("Não foi possivel consultar a tabela areas");
		while(!$resposta_areas->EOF)
			{
			$area = $resposta_areas->fields['area'];
			$resposta_areas->MoveNext();
			echo "
			<tr><td></td><td>$area</td></tr>
			";
			}

		}

	echo "
	<tr><th colspan='3'>Monografias orientadas</th></tr>
	";

	$sql = "select * from monografia where num_prof='$num_prof' order by periodo";
	$resposta_monografia = $db->Execute($sql);
	if($resposta_monografia == false) die ("Não foi possível consultar a tabela monogrfia");
	while(!$resposta_monografia->EOF) {
		$codigo   = $resposta_monografia->fields['codigo'];
		$titulo   = $resposta_monografia->fields['titulo'];
		$periodo  = $resposta_monografia->fields['periodo'];
		$num_area = $resposta_monografia->fields['num_area'];
		$resposta_monografia->MoveNext();
		
		$sql = "select * from areas where numero='$num_area'";
		$resposta_areas = $db->Execute($sql);
		if($resposta_areas == false) die ("Não foi possível consultar a tabela areas");
		while(!$resposta_areas->EOF) {
			$area = $resposta_areas->fields['area'];
			$resposta_areas->MoveNext();
		}
		
		// Para alternar as cores das linhas
		if($color === '1')
		{
			echo "<tr class='resaltado' id='resaltado'>";
			$color = '0';
		}
		else
		{
			echo "<tr class='natural' id='natural'>";
			$color = '1';
		}
		
		echo "
		<td>$area</td>
		<td><a href='../../areaMonografia/visualizar/monografia.php?codigo=$codigo'>$titulo</a></td>
		<td>$periodo</td>
		</tr>
		";
		}

	echo "
	
	<tr class='botao'>
	<td colspan='3'>
		
	<form action='$_SERVER[PHP_SELF]'>
	<table id='botao_confirma_professor' name='botao_confirma_professor'>
	<tr><td>
	<input type='submit' name='submit' value='Retroceder'>
	<input type='submit' name='submit' value='Avanzar'>
	<input type='hidden' name='index' value='$index'>
	</td></tr>
	</table>
	</form>
	
	</td>	
	</tr>
		
	</table>
	</div>
	
	";
	}

$db->Close();

?>
