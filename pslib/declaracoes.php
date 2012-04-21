<html>
<head></head>
<link href="../css/tcc.css" rel="stylesheet" type="text/css">
<body>

<?php

function divide($texto,$pagina)
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
		$corpo[$j] = $resto . ".";
	}

	echo "Pagina: " . $pagina . "<br>";
	for($i=0;$i<sizeof($corpo);$i++)
	{
		echo $i . " " . $corpo[$i] . "<br>";
	}

	return($corpo);

}

function data()
	{
	$ano  = trim(date('Y',time()));
	$mes  = trim(date('m',time()));
	$dia  = trim(date('d',time()));

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
	
require("pslib.class");
$nome_arq_ps = "declaracoes" . $periodo . ".ps";
$PS = new postscript($nome_arq_ps, "ESS", "Comissão de TCC","Portrait");

$sql = "select * from monografia where periodo='$periodo'";
echo $sql . "<br>";
include("../conexao.inc");
$pagina = 1;
while($rows_monografia = mysql_fetch_array($res))
	{
	$titulo = $rows_monografia['titulo'];
	$codigo = $rows_monografia['codigo'];
	
	include("alunos.inc");
	
	$num_prof = $rows_monografia['num_prof'];
	$sql_professor = "select * from professores where numero='$num_prof'";
	$res_professor = mysql_query($sql_professor,$con);
	
	while($rows_professor = mysql_fetch_array($res_professor))
		{
		$sexo = $rows_professor['sexo'];
		$nome = $rows_professor['nome'];
		}
		
	/* Crio uma variavel de texto para o corpo da declaracao */	
	if($sexo == 0)
		$texto = "A professora ";
	elseif($sexo == 1)
		$texto = "O professor ";
	else 
		echo "Falta indicar o sexo de professor";
		 	
	$texto .= $nome;
	$texto .= " orientou a monografia intitulada: ";
	$texto .= $titulo;
	$texto .= " de autoria do(s) aluno(s): ";
	$texto .= $aluno;

	/* Agora tenho que encaixar o texto em lineas de 90 caracteres */
	/* O resultado será uma matriz de nome $corpo */
	/* No inicio $resto eh todo o texto, no final sera somente um texto /*
	/* menor de 90 caracteres */

	$corpo = divide($texto,$pagina);
	$PS->begin_page($pagina);
	
	$PS->show_xy_font("UNIVERSIDADE FEDERAL DO RIO DE JANEIRO", 130, 720,"Arial",14);
	$PS->show_xy_font("Escola de Serviço Social", 200, 700,"Arial", 14);
	
	$PS->show_xy_font("DECLARAÇÃO", 215, 600, "Arial-Bold", 16);
	
	/*
	* Corpo do texto
	*/
	$y = 550;
	for($i=0;$i<sizeof($corpo);$i++)
	{
		$PS->show_xy_font($corpo[$i], 50, $y, "Arial", 12);
		$y = $y - 20;
	}
	
	$PS->show_xy_font("$resto", 50, $y, "Arial", 12);
	
	/*
	* Data
	*/
	$PS->show_xy_font($local, 350, 400, "Arial", 12);
	
	/*
	* Assinatura
	*/
	$PS->line(350, 300, 540, 300, 1);
	$PS->show_xy_font("por Comissão de TCC", 390, 280, "Arial", 12);
	   
	/*
	* Rodapé
	*/
	$PS->set_font("Arial", 10);
	$PS->moveto(200, 60);
	$PS->show("Comissão de Trabalho de Conclussão de Curso");
	$PS->moveto(270, 50);
	$PS->show("ESS - UFRJ");
	
	/*
	* LOGOTIPO - PS Image => Detail: when inserting a ps image, 
	* must delete the information about the file (in the top of the file)
	*/
	$PS->open_ps("minerva.eps");

	$PS->end_page();

	$pagina++;

	}

$PS->close();

?>

<script Language="Javascript">
    location="<? echo($nome_arq_ps) ?>";
</script>

</body>
</html>
