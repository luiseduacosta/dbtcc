<html>
<head>
<link href="../../css/tcc.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php

$num_area = $_REQUEST['num_area'];

if (empty($num_area))
	{
	echo "<p>Retornar para selecionar uma area";
	exit;
	}

include("../../include_db.inc");

// Obtengo o nome da �rea para o cabecalho
$sql_areas = "select area from areas where numero='$num_area'";
$resposta = $db->Execute($sql_areas);
if ($resposta === false) die ("Nao foi possivel consultar a tabela areas");
while (!$resposta->EOF)
{
	$area = $resposta->fields['area'];
	$resposta->MoveNext();
}

echo "
<div>
<table>
<thead>
<caption>Professores da area: $area</caption>
<tr>
<th>Professor</th>
<th>Departamento</th>
<th>Condicao</th>
<th>E-mail</th>
</tr>
<thead>

<tfoot></tfoot>

<tbody>
";

// Si a �rea � n�o corresponde
if($num_area === '99')
{
    echo "
    <div>
    <table>
    <caption>Monografias classificadas como área: não corresponde</caption>
    <tr>
    <th>Titulo</th>
    <th>Professor</td>
    <th>Periodo</th>
    </tr>
    ";
    $sql_sem_dados = "select * from monografia where num_area = '99'";
    $resultado_sem_dados = $db->Execute($sql_sem_dados);

    while (!$resultado_sem_dados->EOF) {

	$numero_area = $resultado_sem_dados->fields['num_area'];
	$titulo      = $resultado_sem_dados->fields['titulo'];
	$periodo     = $resultado_sem_dados->fields['periodo'];
	$professor   = $resultado_sem_dados->fields['num_prof'];
	$resultado_sem_dados->MoveNext();
	$sql_nome_professor = "select * from professores where id = '$professor'";
	$resultado_nome_professor = $db->Execute($sql_nome_professor);
	if ($resultado_nome_professor === false) die ("Não foi possível consultar a tabela professores");
	while (!$resultado_nome_professor->EOF) {
	
	    $nome_professor = $resultado_nome_professor->fields['nome'];
	    $resultado_nome_professor->MoveNext();
	}

   	echo "
	<tr>
	<td>$titulo</td>
	<td>$nome_professor</td>
	<td>$periodo</td>
	</tr>
	";
    }
    exit;
}
// Si a �rea � sem dados
elseif ($num_area === '91')
{
    echo "
    <div>
    <table>
    <caption>Monografias classificadas como área: sem dados</caption>
    <tr>
    <th>Titulo</th>
    <th>Professor</td>
    <th>Período</th>
    </tr>
    ";
    $sql_sem_dados = "select * from monografia where num_area='91'";
    $resultado_sem_dados = $db->Execute($sql_sem_dados);

    while (!$resultado_sem_dados->EOF) {
	$numero_area = $resultado_sem_dados->fields['num_area'];
	$titulo      = $resultado_sem_dados->fields['titulo'];
	$periodo     = $resultado_sem_dados->fields['periodo'];
	$professor   = $resultado_sem_dados->fields['num_prof'];
	$resultado_sem_dados->MoveNext();
	$sql_nome_professor = "select * from professores where id = '$professor'";
	$resultado_nome_professor = $db->Execute($sql_nome_professor);
	if ($resultado_nome_professor === false) die ("Não foi possivel consultar a tabela professores");
	while (!$resultado_nome_professor->EOF) {
	    $nome_professor = $resultado_nome_professor->fields['nome'];
	    $resultado_nome_professor->MoveNext();
	}

   	echo "
	<tr>
	<td>$titulo</td>
	<td>$nome_professor</td>
	<td>$periodo</td>
	</tr>
	";
    }
    exit;
}

// Busco o professores da area utilizando a tabela prof_area
// Armazendo os resultado em uma matriz que contem os numeros dos professores
$sql = "select * from prof_area where num_area='$num_area'";
$resposta_prof_area = $db->Execute($sql);
if ($resposta_prof_area == false) die ("Nao foi possivel consultar a tabela prof_area");
$j = 0;
while (!$resposta_prof_area->EOF) {
	$professores[$j] = $resposta_prof_area->fields['num_prof'];
	
	$sql = "select * from professores where id='$professores[$j]' order by nome";
	$resposta_professores = $db->Execute($sql);
	if ($resposta_professores == false) die ("Nao foi possivel consultar a tabela professores");

	while (!$resposta_professores->EOF) {
		$nome         = $resposta_professores->fields['nome'];
		$departamento = $resposta_professores->fields['departamento'];
		$condicao     = $resposta_professores->fields['condicao'];
		$email	      = $resposta_professores->fields['email'];
		
	    // Para alternar as cores das linhas
		if($color === '1') {
			echo "<tr class='resaltado' id='resaltado'>";
			$color = '0';
		} else {
			echo "<tr class='natural' id='natural'>";
			$color = '1';
		}
		
		echo "
		<td>$nome        </td>
		<td>$departamento</td>
		<td>$condicao    </td>
		<td><a href=mailto:$email>$email</a></td>
		</tr>
		";
		$resposta_professores->MoveNext();
		}
	$j++;
	$resposta_prof_area->MoveNext();
	}

echo "
</tbody>
</table>
</div>
";

/*************************************************************
 Verfico se existem monografias orientadas pelos professores *
**************************************************************/
for ($i=0;$i<sizeof($professores);$i++)
	{
	$sql = "select * from monografia where num_prof='$professores[$i]'";
	$resposta_monografia = $db->Execute($sql);
	if ($resposta_monografia == false) die ("Não foi possivel consultar a tabela monografia");
	$quantidade = $resposta_monografia->RecordCount();
	$total += $quantidade;
	}

if ($total == 0)
	{
	echo "<p>Não existem monografias orientadas pelos professores da área $area<br>";
	exit;
	}

echo "
<br>
<div>
<table>
<thead>
<caption>Monografias orientadas pelos professores da área: $area
</caption>
<tr>
<th>Id</th>
<th>Titulo</th>
<th>Periodo</th>
<th>Area principal</th>
</tr>
<thead>

<tfoot></tfoot>

<tbody>

";

$j = 0;
for ($i=0;$i<sizeof($professores);$i++)
	{
	$sql = "select * from monografia where num_prof='$professores[$i]' order by titulo";
	$resultado_monografia = $db->Execute($sql);
	if ($resultado_monografia == false) die ("Não foi possivel consultar a tabela monografia");
	$quantidade = $resultado_monografia->RecordCount();
	/**************************************************************************
	 Si existem monografias orientadas pelos professores entao $quantidade=1  *
	**************************************************************************/
	while (!$resultado_monografia->EOF)
		{
		$titulo   = $resultado_monografia->fields['titulo'];
		$periodo  = $resultado_monografia->fields['periodo'];
		$num_area = $resultado_monografia->fields['num_area'];
		// $num_area = $resultado_monografia->fields['num_area'];		
		
		// Busco a area a partir do num_area
		$sql_areas = "select * from areas where numero='$num_area'";
		$resultado_areas = $db->Execute($sql_areas);
		if ($resultado_areas == false) die ("Nao foi possivel consultar a tabela areas");
		while (!$resultado_areas->EOF)
		{
		    $areas = $resultado_areas->fields['area'];
		    $resultado_areas->MoveNext();
		}
		
		// Agora si faco as lineas da tabela		
		
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
		<td>$j</td>
		<td>$titulo</td>
		<td>$periodo</td>
		<td>$areas</td>
		</tr>
		";
		$resultado_monografia->MoveNext();
		$j++;
		}
	}

echo "
</tbody>
</table>
</div>
";

$db->Close();

?>

</body>
<html>