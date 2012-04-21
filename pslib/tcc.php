<?php require("pslib.class"); ?>
<html>
<head>
<title>Declaração para professor orientador de TCC</title>
<link href="../css/tcc.css" rel="stylesheet" type="text/css">
</head>

<body>

<?php 
$data = date('d/m/Y',time());
$ano  = trim(date('Y',time()));
$mes_data  = trim(date('m',time()));
$dia  = trim(date('d',time()));
switch($mes_data)
	{
	case 01:
	$mes = "janeiro";
	break;

	case 02:
	$mes = "fevereiro";
	break;

	case 03:
	$mes = "março";
	break;

	case 04:
	$mes = "abril";
	break;

	case 05:
	$mes = "maio";
	break;

	case 06:
	$mes = "junho";
	break;

	case 07:
	$mes = "julho";
	break;

	case 08:
	$mes = "agosto";
	break;

	case 09:
	$mes = "setembro";
	break;

	case 10:
	$mes = "outubro";
	break;

	case 11:
	$mes = "novembro";
	break;

	case 12:
	$mes = "dezembro";
	break;
	}

$sql = "select * from professores where numero=$num_prof";
include("../conexao.inc");
while($rows = mysql_fetch_array($res))
	{
	$professor = $rows["nome"];
	for($i = 0;$i < strlen($professor);$i++)
		{
		$letra = $professor[$i];
		if($letra != " ")
			$prof_nome .=$letra;
		}	
	echo $prof_nome . "<br>";	
	}

/*
* PS DESTINATION FILE - ARQUIVO PS DESTINO
*/

$nome_arq_ps = $prof_nome . ".ps";
$q_monografia = "select * from monografia where codigo=$codigo";
$r_monografia = mysql_query($q_monografia,$con) or die ("Não foi possivel consultar a tabela monografia");
while($rows = mysql_fetch_array($r_monografia))
	{
	$titulo = $rows['titulo'];
	include("alunos.inc");
	}

if($sexo == "1")
	$texto = "O professor ";
elseif($sexo == "0")
	$texto = "A professora ";
else
	echo "Falta indicar o sexo do professor";
	
$texto .= $professor;
$texto .= " orientou a monografia intitulada \"";
$texto .= $titulo;
$texto .= "\" de autoria do(s) aluno(s) ";
$texto .= $aluno;
$resto = $texto;

$j = 0;
while(strlen($resto) > 90)
{
	$tamanho = strlen($texto);
	for($i=0;$i<$tamanho;$i++)
		{
		$letra = $texto[$i];
		if($letra == " ")
			$branco = $i;
		if($i >= 90)
			{
			$variavel = substr($texto,0,$branco);
			$resto = substr($texto,$branco,$tamanho);
			$corpo[$j] = $variavel;
			echo $corpo[$j] . "<br>";
			break;
			}
		}
	$texto = $resto;
	$j++;
}

for($i=0;$i<sizeof($corpo);$i++)
{
	echo "Texto " . $corpo[$i] . "<br>";
}

echo("<font face=\"Verdana, Arial, Helvetica, sans-serif\"> AGUARDE. ENVIANDO PARA UM ARQUIVO DE IMPRESSÃO... (PRINTING...) <br></font>");
   
$PS = new postscript($nome_arq_ps, "ESS", "Comissão de TCC","Portrait");

$PS->begin_page(1); 

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
$PS->show_xy_font("Rio de Janeiro, $dia de $mes de $ano", 350, 400, "Arial", 12);

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
   
$PS->close();
   
echo("<font face=\"Verdana, Arial, Helvetica, sans-serif\"> IMPRESSÃO REALIZADA. (FINISHED) </font>");

?> 

<script Language="Javascript">
    location="<?php echo($nome_arq_ps) ?>";
</script>
    <br>
</body>
</html>
