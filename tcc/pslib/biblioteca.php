<html>
<head></head>
<link href="../css/tcc.css" rel="stylesheet" type="text/css">
<body>

<?php

include("../include_db.inc");
$sql = "select * from monografia where periodo='$periodo' order by titulo";
$resultado = $db->Execute($sql);
if($resultado === false) die ("Não foi possível consultar a tabela monografia");

$i = 0;
while(!$resultado->EOF)
	{
	$codigo        = $resultado->fields['codigo'];
	$titulo        = $resultado->fields['titulo'];
	$num_professor = $resultado->fields['num_prof'];
	$resultado->MoveNext();

	include("alunos.inc");

	$sql_professores = "select * from professores where numero='$num_professor'";
	$resultado_professores = $db->Execute($sql_professores);
	while(!$resultado_professores->EOF)
	{
		$professor = $resultado_professores->fields['nome'];
		$resultado_professores->MoveNext();
	}

	$matriz[$i]['titulo']    = $titulo;
	$matriz[$i]['aluno']     = $aluno;
	$matriz[$i]['professor'] = $professor;
	$i++;

	}

function divide($texto)
	{
	$resto = $texto;
	$tamanho = strlen($resto);	
	$j = 0;
	while($tamanho > 90)
		{
		for($i=0;$i<(strlen($resto));$i++)
			{
			$letra = $resto[$i];
			if($letra == " ")
				$branco = $i;
			if($i >= 90)
				{
				$variavel = substr($resto,0,$branco);
				$resto = substr($resto,$branco,$tamanho);
				$corpo[$j] = $variavel;
				break;
				}
			}
		$j++;
		$tamanho = strlen($resto);
		$corpo[$j] = $resto;
		}
	return($corpo);
	}

function data()
	{
	$dia  = trim(date('d',time()));	
	$mes  = trim(date('m',time()));	
	$ano  = trim(date('Y',time()));
	
	$mes_data = array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");

	$fecha['dia'] = $dia;
	$fecha['mes'] = $mes_data[($mes - 1)];
	$fecha['ano'] = $ano;
	return($fecha);
	}

$fecha = data();
for($i=0;$i<sizeof($fecha);$i++)
	{
	$dia = $fecha['dia'];
	$mes = $fecha['mes'];
	$ano = $fecha['ano'];
	}

$local = "Rio de Janeiro, " . $dia . " de " . $mes . " de " . $ano . ".";

$pagina = 1; // A primeira pagina corresponde a carta de apresentação da listagem
$final = 9; // quantidade de registros na primeira página. Depois passa para 11.

require("pslib.class");
$nome_arq_ps = "biblioteca" . $periodo . ".ps";
$PS = new postscript($nome_arq_ps, "ESS", "Comissão de TCC", "Portrait");

$PS->begin_page($pagina);
$PS->show_xy_font("UNIVERSIDADE FEDERAL DO RIO DE JANEIRO", 130, 720,"Arial", 14);
$PS->show_xy_font("Escola de Serviço Social", 200, 700,"Arial", 14);
/* Data */
$PS->show_xy_font($local, 300, 650,"Arial", 12);
/* Corpo da carta */
$PS->show_xy_font("Responsável da biblioteca:", 50, 600,"Arial", 12);
$PS->show_xy_font("Estamos encaminhando a listagem das monografias (trabalho de conclusão de curso) ",50,550,"Arial",12);
$PS->show_xy_font("dos alunos da Escola de Serviço Social correspondente ao período $periodo.",50,520,"Arial",12);
$PS->show_xy_font("Atenciosamente,",50,470,"Arial",12);
/* Assinatura */
$PS->line(350, 300, 540, 300, 1);
$PS->show_xy_font("por Comissão de TCC", 390, 280, "Arial", 12);
/* Logotipo */
$PS->open_ps("minerva.eps");

$PS->end_page();

$pagina++;
$PS->begin_page($pagina);
$PS->show_xy_font("UNIVERSIDADE FEDERAL DO RIO DE JANEIRO", 130, 750,"Arial",14);
$PS->show_xy_font("Escola de Serviço Social", 200, 730,"Arial", 14);
$PS->show_xy_font("Monografias do periodo $periodo", 195, 710, "Arial", 12);

$linea = 0;
$y = 650; // A primeira linea inicia no lugar 650. Logo passa a ser 750.

for($i=0;$i<sizeof($matriz);$i++)
	{
	$titulo = "Titulo: " . $matriz[$i]['titulo'];
	$aluno = "Aluno(s): " . $matriz[$i]['aluno'];
	$professor = "Orientador: " . $matriz[$i]['professor'];
	$largo = strlen($titulo);

	$PS->begin_page($pagina);

	$folha = $pagina - 1;
	if($folha > 1)
		$PS->show_xy_font("$folha", 540, 770, "Arial", 8);
		
	if(strlen($titulo) > 90)
		{
		$titulo_aux = divide($titulo);
		for($k=0;$k<sizeof($titulo_aux);$k++)
			{
			if($k >= 1)
				{
				$titulo_raw = $titulo_aux[$k];
				$PS->show_xy_font("$titulo_raw", 70, $y - 15 , "Arial", 12);
				$y = $y - 15;
				echo $y . " " . $titulo_raw . "<br>";
				}
			else
				{
				$titulo_raw = $titulo_aux[$k];
				$PS->show_xy_font("$titulo_raw", 50, $y, "Arial", 12);
				echo $y . " " . $titulo_raw . "<br>";
				}
			}
		}
	else
		{
		$PS->show_xy_font("$titulo", 50, $y, "Arial", 12);
		echo $y . " " . $titulo . "<br>";
		}
	
	$y = $y - 15;	
	if(strlen($aluno) > 90)
		{
		$aluno_aux = divide($aluno);
		for($k=0;$k<sizeof($aluno_aux);$k++)
			{
			if($k >= 1)
				{
				$aluno_raw = $aluno_aux[$k];
				$PS->show_xy_font("$aluno_raw",70, $y - 15, "Arial", 12);
				$y = $y - 15;
				echo $y . " " . $aluno_raw . "<br>";
				}
			else
				{
				$aluno_raw = $aluno_aux[$k];
				$PS->show_xy_font("$aluno_raw",50, $y, "Arial", 12);
				echo $y . " " . $aluno_raw . "<br>";
				}	
			}
		}
	else
		{ 
		$PS->show_xy_font("$aluno", 50, $y, "Arial", 12);
		echo $y . " " . $aluno . "<br>";
		}

	$y = $y - 15;
	$PS->show_xy_font("$professor", 50, $y, "Arial", 12);
	echo $y . " " . $professor .  "<br>";

   $PS->line(50, $y-5, 550, $y-5, 1);

	$y = $y - 20;
	$linea++;

	if($linea == $final)
		{
		echo "<hr>";
		$linea = 0;
		$y = 750;
		$PS->end_page();
		$pagina++;
		$final = 11;
		}
	}
	
$PS->close();

?>

<script Language="Javascript">
    location="<? echo($nome_arq_ps) ?>";
</script>

</body>
</html>