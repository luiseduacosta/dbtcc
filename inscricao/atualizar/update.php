<?php

/* TODO:
* Corregir a variavel *acordo* caso exista algum valor na variavel professor
*/

include("../../include_db.inc");

$id					= $_REQUEST['id'];
$aluno				= $_REQUEST['aluno'];
$registro_atual 	= $_REQUEST['registro_atual'];
$registro_novo		= $_REQUEST['registro_novo'];
$numero_professor 	= $_REQUEST['numero_professor'];
$numero_area 		= $_REQUEST['numero_area'];
$acordo 			= $_REQUEST['acordo'];
$data 				= $_REQUEST['data'];
$periodo			= $_REQUEST['periodo'];

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";

/* Transformo a data de formato UNIX para formato MySQL */
$dia = substr($data,0,2);
$mes = substr($data,3,2);
$ano = substr($data,6,4);
$data_sql = $ano . "/" . $mes . "/" . $dia;

/* Si o registro_novo n�o � 99 (sem informa��o) ent�o
verfico si o n�mero de registro j� existe */
if($registro_novo != '99')
	{
	if($registro_novo != $registro_atual)
		{
		$sql_inscricao = "select registro from inscricao order by registro";
		echo $sql_inscricao . "<br>";
		$resultado = $db->Execute($sql_inscricao);
		if($resultado === false) die ("N�o foi poss�vel consultar a tabela inscricao");
		while(!$resultado->EOF)
			{
			$registro = $resultado->fields['registro'];
			$resultado->MoveNext();
			if($registro_novo === $registro)
				{
				echo "N�mero de registro: $registro_novo do aluno: $aluno j� existe";
				// Fecho conexao e saio fora
				$db->Close();
				exit;
				}
			}
		}
	}

/*
* Verifico area do professor
*/

$flag_area = 0; // Utilizo esta flag para verificar si passou 
                // no test de saber si o professor � de �rea ou n�o.
$i = 0;         // Esta variavel � para criar a matriz de professores da �rea

/*
Caso a vari�vel $area tenha um valor v�lido
*/
if($numero_area != 91)
	{
	$sql_area = "select num_prof from prof_area where num_area = $numero_area";
	$resultado = $db->Execute($sql_area);
	if($resultado === false) die ("N�o foi poss�vel consultar a tabela prof_area");
	while(!$resultado->EOF)
		{
		$num_prof = $resultado->fields['num_prof']; // A variavel $num_prof eh diferente de $numero_professor
		$resultado->MoveNext();
		if($num_prof === $numero_professor)
			{
			$flag_area = 1; // Si o professor � da �rea o valor � 1	
			echo "<h1>Ok!! Professor � da �rea</h1>";
			}
		else
			{
			$sql_professor = "select numero, nome from professores where numero = $num_prof";
			$resultado = $db->Execute($sql_professor);
			if($resultado === false) die ("N�o foi poss�vel consultar a tabela professores");
			while(!$resultado->EOF)
				{
				$num_professor  = $resultado->fields['numero'];
				$nome_professor = $resultado->fields['nome'];
				$resultado->MoveNext();
				// Armazeno os professores da area numa matriz
				$matriz_professor[$i]['nome'] = $nome_professor;
				$i++;
				}
			}
		}
	}
	
/* Si o professor n�o � da area e a �rea tem um valor v�lido (deferente de 91 */
if(($flag_area == 0) & ($numero_area != 91))
	{
	if(empty($numero_professor))
		echo "<h1>Professor n�o foi selecionado</h1>";
	else
		echo "<h1>Aten��o: o professor selecionado n�o orienta nessa �rea!</h1>";
	
	echo "
	<div align=\"center\">
	<table>
	<tr><th>Veja os professores que orientam na area selecionada</th></tr>
	";
	for($j=0; $j < sizeof($matriz_professor); $j++) 
		{
		$professor = $matriz_professor[$j]['nome'];
		echo"
		<tr><td>$professor</td></tr>
		";
		}
	echo "	
	</table>
	</div>
	";
	}

/*
Obtengo o nome a area e do professor a partir do n�mero para construir a tabela.
Obviamente s� pode funcionar si a �rea � diferente de 91: s/d.
*/

if($numero_area != 91)
{
	$sql_outra_area = "select area from areas where numero='$numero_area'";
	$resultado_outra_area = $db->Execute($sql_outra_area);
	if($resultado_outra_area === false) die ("N�o foi poss�vel consultar a tabela areas");
	while(!$resultado_outra_area->EOF)
	{
		$palavra_area = $resultado_outra_area->fields['area'];
		$resultado_outra_area->MoveNext();
	}
}
	
if($numero_professor != 0)
{
	$sql_outro_professor = "select nome from professores where numero='$numero_professor'";
	$resultado_outro_professor = $db->Execute($sql_outro_professor);
	if($resultado_outro_professor === false) die ("N�o foi poss�vel consultar a tabela professores");
	while(!$resultado_outro_professor->EOF)
	{
		$palavra_professor = $resultado_outro_professor->fields['nome'];
		$resultado_outro_professor->MoveNext();
	}
}

if($acordo == "s")
	$acordo_extenso = "sim";
elseif($acordo == "n")
	$acordo_extenso = "n�o";

/*
* Mostrar os dados a serem inseridos
*/

echo "
<div>
<table>
<tr><th colspan=2>Datos inseridos</th></tr>
<tr><td>Nome</td><td>$aluno</td></tr>
<tr><td>Registro:</td><td>$registro_novo</td></tr>
<tr><td>Area:</td><td>$palavra_area</td></tr>
<tr><td>Orientador:</td><td>$palavra_professor</td></tr>
<tr><td>Num prof.:</td><td>$numero_professor</td></tr>
<tr><td>Acordo?</td><td>$acordo_extenso</td></tr>
<tr><td>Per�odo:</td><td>$periodo</td></tr>
<tr><td>Data de preenchimento:</td><td>$data_sql</td></tr>
</table>
</div>

</body>
</html>
";

$sql_up  = "update inscricao set registro='$registro_novo', ";
$sql_up .= "nome='$aluno', ";
$sql_up .= "num_professor='$numero_professor', ";
$sql_up .= "num_area='$numero_area', ";  
$sql_up .= "data='$data_sql', ";
$sql_up .= "periodo='$periodo', ";
$sql_up .= "acordo='$acordo' ";
$sql_up .= "where numero=$id"; 
$resultado_update = $db->Execute($sql_up);
if($resultado_update === false) die ("N�o foi possivel consultar a tabela inscricao");

$db->Close();

?>