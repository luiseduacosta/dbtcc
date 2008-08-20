<?php

/*
Agregar um campo de outras observa��es?
Depois que o aluno seleciona a area o programa poderia oferecer como
escolha apenas aqueles professores dessa �rea. Esta escolha n�o seria
obrigatoria, o aluno poderia escolher um professor de uma outra �rea.
*/

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";

require_once("../../include_db.inc");

$nivel  	= $_REQUEST['nivel'];
$numero 	= $_REQUEST['numero'];
$aluno  	= $_REQUEST['aluno'];
$area_nova	= $_REQUEST['area_nova'];
$professor 	= $_REQUEST['professor'];
$acordo		= $_REQUEST['acordo'];
$data		= $_REQUEST['data'];
$periodo	= $_REQUEST['periodo'];

if((empty($aluno)) || (empty($numero)))
{
    echo "<H1>Retornar para preencher o campo aluno e/ou o campo registro</HI>";
    exit;
}

if($nivel == "2") // O nivel 2 � na verdade uma atualiza��o
{
	$sql_inscricao = "select nome from inscricao where numero=$id";
	$resultado = $db->Execute($sql_inscricao);
	if($resultado === false) die ("N�o foi poss�vel consultar a tabela inscricao");
	while(!$resultado->EOF)
	{
		$aluno = $resultado->fields['nome'];
		$resultado->MoveNext();
	}
}

/* 
Corrigo o valor da variavel $acordo para 'n' 
caso n�o exista um professor selecionado 
*/
if(empty($professor))
	$acordo = "n";

/*
Si a variavel $area est� vazia ou com o valor 99: 'n�o corresponde' 
muda para 91:'s/d'
*/
if((empty($area_nova)) || ($area_nova == "99"))
	$area_nova = 91;

/* Si o n�mero est� vazio ent�o n�mero = 99 sem fazer nenhuma verifica��o
Caso contr�rio verifico si o n�mero de registro j� existe e si o � nivel=="1"
*/
if((empty($numero)) || $numero == '99') 
	$numero = '99';
else
	{
	$sql_outra_inscricao = "select * from inscricao order by numero";
	$resultado_outra_inscricao = $db->Execute($sql_outra_inscricao);
	if($resultado_outra_inscricao === false) die ("N�o foi poss�vel consultar a tabela inscricao");
	while(!$resultado_outra_inscricao->EOF)
		{
		$registro = $resultado_outra_inscricao->fields['registro'];
		$resultado_outra_inscricao->MoveNext();
		if(($numero === $registro) AND ($nivel === "1"))
			{
			echo "N�mero de registro: $numero do aluno: $aluno j� existe";
			$db->Close;
			exit;
			}
		}
	}
	
$flag_area = 0; // Utilizo esta flag para verificar si passou 
                // no test de saber si o professor � de �rea ou n�o.
$i = 0;         // Esta variavel � para criar a matriz de professores da �rea

/*
Caso a vari�vel $area tenha um valor diferente de s/d 
busco os professores dessa area. Si existe uma professor
a variavel *flag* asume o valor 1 
*/
if($area_nova != 91)
	{
	$sql_area = "select num_prof from prof_area where num_area = $area_nova";
	$resultado_area = $db->Execute($sql_area);
	if($resultado_area === false) die ("N�o foi poss�vel consultar a tabela prof_area");
	while(!$resultado_area->EOF)
		{
		$num_prof = $resultado_area->fields['num_prof'];
		$resultado_area->MoveNext();
		if($num_prof === $professor)
			{
			$flag_area = 1; // Si o professor � da �rea o valor � 1	
			echo "<h1>Ok!! Professor � da �rea</h1>";
			}
		else
			{
			$sql_professor = "select numero, nome from professores where numero = $num_prof";
			$resultado_professor = $db->Execute($sql_professor);
			if($resultado_professor === false) die ("N�o foi poss�vel consultar a tabela professores");
			while(!$resultado_professor->EOF)
				{
				$num_professor  = $resultado_professor->fields['numero'];
				$nome_professor = $resultado_professor->fields['nome'];
				$resultado_professor->MoveNext();
				$matriz_professor[$i]['nome'] = $nome_professor;
				$i++;
				}
			}
		}
	}

/* Si o professor n�o � da area e a �rea tem um valor v�lido (defierente de 91 */
if(($flag_area == 0) & ($area_nova != 91))
	{
	if(empty($professor))
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
		$nome_professor = $matriz_professor[$j]['nome'];
		echo"
		<tr><td>$nome_professor</td></tr>
		";
		}
	echo "	
	</table>
        </div>
	";
	}

/******************************************************************
* Obtengo o nome da area a partir de n�mero.
* Obviamente s� pode funcionar si a �rea � diferente de 91: s/d
*******************************************************************/
if($area_nova != 91)
{
	$sql_outra_area = "select area from areas where numero=$area_nova";
	$resultado_outra_area = $db->Execute($sql_outra_area);
	if($resultado_outra_area === false) die ("N�o foi poss�vel consultar a tabela areas");
	while(!$resultado_outra_area->EOF)
	{
		$palavra_area = $resultado_outra_area->fields['area'];
		$resultado_outra_area->MoveNext();
	}
}

/******************************************************
* Obtengo o nome do professor a partir do n�mero
******************************************************/
if(!(empty($professor)))
{
	$sql_outro_professor = "select nome from professores where numero=$professor";
	$resultado_outro_professor = $db->Execute($sql_outro_professor);
	if($resultado_outro_professor === false) die ("N�o foi poss�vel consultar a tabela professores");
	while(!$resultado_outro_professor->EOF)
	{
		$palavra_professor = $resultado_outro_professor->fields['nome'];
		$resultado_outro_professor->MoveNext();
	}
}

if($acordo === "s")
	$acordoExtenso = "sim";
elseif($acordo === "n")
	$acordoExtenso = "n�o";

/*********************************************** 
* Obtengo a data
***********************************************/
$dia = substr($data,0,2);
$mes = substr($data,3,2);
$ano = substr($data,6,4);
$data = $ano . "/" . $mes . "/" . $dia;

/***********************************************
* Mostrar os dados numa tabela
***********************************************/
echo "
<div align=\"center\">
<table>
<tr><th colspan=2>Datos a serem inseridos</th></tr>
<tr><td>Nome</td><td>$aluno</td></tr>
<tr><td>Registro:</td><td>$numero</td></tr>
<tr><td>Area:</td><td>$palavra_area</td></tr>
<tr><td>Professor:</td><td>$palavra_professor</td></tr>
<tr><td>Acordo?</td><td>$acordoExtenso</td></tr>
<tr><td>Per�odo:</td><td>$periodo</td></tr>
<tr><td>Data de preenchimento:</td><td>$data</td></tr>
</table>
</div>
";

/*****************************************************
* Inserir ou atualizar dados
*****************************************************/
if($nivel === "1") // Inserir um novo registro
	{
	$sql_inserir  = "insert into inscricao (nome,registro,num_area,num_professor,acordo,periodo,data)";
	$sql_inserir .= "values ('$aluno','$numero','$area_nova','$professor','$acordo','$periodo','$data')";
	$resultado_inserir = $db->Execute($sql_inserir);
	if($resultado_inserir === false) die ("N�o foi poss�vel inserir dados na tabela inscricao");
	echo "<H1>Ok! Dados inseridos.</H1>";
	}
elseif($nivel === "2") // Atualizar registro de nivel 1 para nivel 2
	{
	$sql_atualizar  =  "update inscricao set nome='$aluno', registro='$numero', ";
	$sql_atualizar .= "num_area='$area_nova', num_professor='$professor', ";
	$sql_atualizar .= "acordo='$acordo', periodo='$periodo', data='$data' "; 
	$sql_atualizar .= "where numero='$id'";
	// $resultado_atualizar = $db->Execute($sql_atualizar);
	if($resultado_atualizar === false) die ("N�o foi poss�vel atualizar a tabela inscricao");		
	echo "<H1>Ok! Dados atualizados.</H1>";
	}

$db->Close();

?>