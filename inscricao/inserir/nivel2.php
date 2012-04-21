<html>
<head>
<title><?php echo $_SERVER[PHP_SELF]; ?></title>
<link href="../../css/tcc.css" rel="stylesheet" type="text/css">

<style type="text/css">
<!--
.primeira_linha_tabela {text-align: center}
.ultima_linha_tabela {text-align: center}
//-->
</style>

</head>

</body>

<?php

$numeroAluno = $_REQUEST['numeroAluno'];
$nivel 		= $_REQUEST['nivel'];

require_once("../../include_db.inc");

$sql_inscricao = "select * from inscricao where numero=$numeroAluno";
$resultado = $db->Execute($sql_inscricao);
if ($resultado === false) die ("Não foi possível consultar a tabela inscricao");
while(!$resultado->EOF)
{
	$id               = $resultado->fields['numero'];
	$numero_registro  = $resultado->fields['registro'];
	$nome_aluno       = $resultado->fields['nome'];
	$numero_professor = $resultado->fields['num_professor'];
	$numero_area      = $resultado->fields['num_area'];
	$acordo           = $resultado->fields['acordo'];
	$resultado->MoveNext();
}

if($numero_professor !=0)
{
	$sql_professor = "select * from professores where numero=$numero_professor";
	$resultado = $db->Execute($sql_professor);
	if($resultado === false) die ("Não foi possível consultar a tabela professores");
	while(!$resultado->EOF)
	{
		$professor = $resultado->fields['nome'];
		$resultado->MoveNext();
	}
}
else
	{
	$professor = "Selecione professor";
	}

if($numero_area !=0)
{
	$sql_area = "select * from areas where numero=$numero_area";
	$resultado = $db->Exalign=\"center\"ecute($sql_area);
	if($resultado === false) die ("Não foi possível consultar a tabela areas");
	while(!$resultado->EOF)
	{
		$area = $rows_area->fields['area'];
		$resultado->MoveNext();
	}
}
else
	{
	$area = "Selecione area";
	}

echo "
<div>
<h1>Inscrição na disciplina Seminário de TCC - nivel $nivel</h1>
<h2>$numero_registro  -  $nome_aluno</h2>
</div>
";

echo "
<form name='inserir' action='verifica.php' method='post'>

<div align='center'>
<table border='1' width='80%'>

<tr>
<td>Area:
<select name='area_nova' size='1'>
<option value='$numero_area'>$area</option>
";
$sql_area = "select * from areas order by area";
$resultado = $db->Execute($sql_area);
if($resultado === false) die ("Não foi possível consultar a tabela areas");
while (!$resultado->EOF)
	{
	$num_area  = $resultado->fields['numero'];
	$nome_area = $resultado->fields['area'];
	$resultado->MoveNext();
	echo "
	<option value=$num_area>$nome_area</option>
	";
	}
	
echo "
</select>
</td>
</tr>

<tr>
<td>Orientador:
<select name='professor' size='1'>
<option value='$numero_professor'>$professor</option>
";
$sql_professor = "select * from professores order by nome";
$resultdo = $db->Execute($sql_professor);
if($resultado === false) die ("Não foi possível consultar a tabela professores");
while (!$resultado->EOF)
	{
	$num_professor = $resultado->fields["numero"];
	$professor     = $resultado->fields["nome"];
	$resultado->MoveNext();
	echo "
	<option value=$num_professor>$professor</option>
	";
	}
	echo "
</select>

</td>
</tr>

<tr>
<td>
A orientação já foi acordada com o professor?
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
";

/* A data está em formato UNIX. Tem que ser convertida para MySQL */
$data = date("d/m/Y",time());
$ano  = trim(date("Y",time()));
$mes  = trim(date("m",time()));
if ($mes >= 1 AND $mes <= 6)
	{
	$ano = $ano;            // Este ano  
	$periodo = $ano . "-1"; // Primeiro periodo deste mesmo ano
	}
if ($mes >= 7 AND $mes <= 12) 
	{
	$ano = $ano;        // Proximo ano
	$periodo = $ano . "-2"; // Segundo periodo deste mesmo ano
	}

echo "
<tr>
<td>
Período: <input type='text' name='periodo' size='6' value='$periodo'>
</td>
</tr>

<tr>
<td>
Data:    <input type='text' name='data' size='10' value='$data'>
</td>
</tr>

<input type='hidden' name='nivel' value=$nivel>
<input type='hidden' name='id' value=$id>
<input type='hidden' name='aluno' value=$nome_aluno>
<input type='hidden' name='numero' value=$numero_registro>
<input type='hidden' name='area' value=$numero_area>

<tr>
	<td class=\"ultima_linha_tabela\">
	<input type='submit' name='enviar' value='Confirmar'>
	<input type='reset' name= 'limpar' value='Limpar'>
	</td>
</tr>

</table>
</div>
</form>
"; 

$db->Close();

?>

</body>
</html>