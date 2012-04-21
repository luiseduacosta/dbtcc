<html>
<head>
<link href="../../css/tcc.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php

$id_prof = $_REQUEST['id_prof'];
$local   = $_SERVER['PHP_SELF'];

include("../../include_db.inc");
$sql_prof = "select * from professores where id='$id_prof'";
// echo $sql_prof . "<br>";
$resposta_professores = $db->Execute($sql_prof);
if ($resposta_professores == false) die ("Não foi possível consultar a tabela professores");
while (!$resposta_professores->EOF) {
	$nome = $resposta_professores->fields['nome'];
	$resposta_professores->MoveNext();
}

echo "
<body>
<div>
<table>
<thead>
<caption>Áreas e monografias orientadas pelo professor $nome</caption>
</thead>
";

$sql = "select * from professores where id='$id_prof' order by nome";
// echo $sql . "<br>";
$resposta_professores = $db->Execute($sql);
if ($resposta_professores == false) die ("Não foi possível consultar a tabela professores");
while (!$resposta_professores->EOF) {
	$num_prof     = $resposta_professores->fields['id'];
	$nome         = $resposta_professores->fields['nome'];
	$email        = $resposta_professores->fields['email'];
	$departamento = $resposta_professores->fields['departamento']; 
	$situacao     = $resposta_professores->fields['motivoegresso'];
	$resposta_professores->MoveNext();
/*
	// Busco a descriçao da situacao
	$sql = "select * from situacoes where codigo = '$situacao'";
	$resultado = $db->Execute($sql);
	if($resultado == false) die ("Nao foi possivel consultar a tabela situacoes"); 
	while(!$resultado->EOF)	{
	    $descreve_situacao = $resultado->fields['situacao'];
	    $resultado->MoveNext();
	}
*/	
	echo "	
	<tr>
	    <td>Nome</td>
	    <td colspan=3>$nome</td>
	</tr>
	<tr>
	    <td>Departamento</td>
	    <td colspan=3>$departamento</td>
	</tr>
	<tr>
	    <td>Situação</td>
	    <td colspan=3>$situacao</td>
	</tr>
	<tr>
	    <td>E-mail</td>
	    <td colspan=3><a href=mailto:$email>$email</a></td>
	</tr>
	
	<tr><th colspan='4'>Area(s)</th></tr>
	";

	// Busco as areas do professor
	$sql = "select * from prof_area where num_prof='$num_prof'";
	$resposta_prof_area = $db->Execute($sql);
	if ($resposta_prof_area == false) die ("Não foi possivel consultar a tabela prof_area");
	echo "<tr><td colspan=4>";
	while (!$resposta_prof_area->EOF) {
		$num_area = $resposta_prof_area->fields['num_area'];
		$resposta_prof_area->MoveNext();
		
		$sql = "select * from areas where numero='$num_area'";
		$resposta_areas = $db->Execute($sql);
		if ($resposta_areas == false) die ("Não foi possivel consultar a tabela areas");

		while (!$resposta_areas->EOF) {
			$area = $resposta_areas->fields['area'];
			$resposta_areas->MoveNext();

			echo $area . ", ";
			
			}

		}
	echo "</td></tr>";
	echo "
	<tr><th colspan='4'>Monografias orientadas</th></tr>
	";
	
	// Busco as monografias orientadas
	$sql = "select * from monografia where num_prof='$num_prof' order by periodo";
	$resposta_monografia = $db->Execute($sql);
	if ($resposta_monografia == false) die ("Não foi possível consultar a tabela monografia");
	while (!$resposta_monografia->EOF) {
		$catalogo = $resposta_monografia->fields['catalogo'];
		$codigo   = $resposta_monografia->fields['codigo'];
		$titulo   = $resposta_monografia->fields['titulo'];
		$periodo  = $resposta_monografia->fields['periodo'];
		$num_area = $resposta_monografia->fields['num_area'];
		$resposta_monografia->MoveNext();
		
		$sql = "select * from areas where numero='$num_area'";
		$resultado_areas = $db->Execute($sql);
		if ($resultado_areas == false) die ("Nao foi possivel consultar a tabela areas");
		while (!$resultado_areas->EOF) {
	    	$area = $resultado_areas->fields['area'];
		    $resultado_areas->MoveNext();
		}
		
		// Para alternar as cores das linhas
		if ($color === '1')
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
		<td>$catalogo</td>
		<td><a href='../../monografia/visualizar/ver_monografia.php?codigo=$codigo&local=$local'>$titulo</a></td>
		<td>$periodo</td>
		</tr>
		";
		}
		
	echo "	
	</table>
	</div>
	
	";

	}

$db->Close();

?>

</body>
</html>
