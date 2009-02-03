<?php

define("FPDF_FONTPATH", "/usr/local/htdocs/html/fpdf151/font/");
define("FPDF","/usr/local/htdocs/html/fpdf151/");
require(FPDF."fpdf.php");

$data_arquivo = $_REQUEST['data_arquivo'];
$codigo = $_REQUEST['codigo'];

$data = split("/",$data_arquivo);
$dia = $data[0];
$mes_num = $data[1];
$mes_data = array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
$mes = $mes_data[($mes_num - 1)];
$ano = $data[2];

$local = "Rio de Janeiro, " . $dia . " de " . $mes . " de " . $ano . ".";

$pdf=new FPDF("P","mm","a4");
$pdf->Open();
$pdf->SetMargins(30,20,30);
$pdf->AddPage();
$pdf->SetFont("Arial","","12");

$periodo = $_REQUEST['periodo'];

$sql = "select * from monografia where codigo='$codigo'";
include("../../include_db.inc");
$resposta = $db->Execute($sql);
if($resposta == false) die ("Não foi possível consultar a tabela monografia");

$pagina = 1;
while(!$resposta->EOF) {
	$titulo   = $resposta->fields['titulo'];
	$codigo   = $resposta->fields['codigo'];
	$periodo  = $resposta->fields['periodo'];
	$num_prof = $resposta->fields['num_prof'];
	
	include("../alunos.inc");
	
	$resposta->MoveNext();

	$sql_professor = "select * from professores where id='$num_prof'";
	$resposta_professor = $db->Execute($sql_professor);
	if($resposta_professor == false) die ("Não foi possível consultar a tabela professores");
	while(!$resposta_professor->EOF)
		{
		$sexo = $resposta_professor->fields['sexo'];
		$nome = $resposta_professor->fields['nome'];
		$resposta_professor->MoveNext();
		}
		
	/* Crio uma variavel de texto para o corpo da declaracao */	
	if($sexo == 2)
		$texto = "A professora ";
	elseif($sexo == 1)
		$texto = "O professor ";
	else 
		echo "Falta indicar o sexo de professor";
		 	
	$texto .= $nome;
	$texto .= " orientou a monografia intitulada: ";
	$texto .= "``" . $titulo . "''";
	$texto .= " (" . $periodo . ")";
	$texto .= " de autoria do(s) aluno(s): ";
	$texto .= $aluno . ".";

	$pdf->Image("../../configura/minerva.jpg",100,20,20,20,jpg);
	$pdf->Ln(30);

	$cabecalho1 = $pdf->GetStringWidth("UNIVERSIDADE FEDERAL DO RIO DE JANEIRO");
	$pdf->SetX((210-$cabecalho1)/2);
	$pdf->Cell($cabecalho1,9,"UNIVERSIDADE FEDERAL DO RIO DE JANEIRO",0,1,'C',0);
	$pdf->Ln(5);

	$cabecalho2 = $pdf->GetStringWidth("Escola de Serviço Social");
	$pdf->SetX((210-$cabecalho2)/2);
	$pdf->Cell($cabecalho2,9,"Escola de Serviço Social",0,1,'C',0);
	$pdf->Ln(20);

	$cabecalho3 = $pdf->GetStringWidth("DECLARAÇÃO");
	$pdf->SetX((210-$cabecalho3)/2);
	$pdf->Cell($cabecalho3,9,"DECLARAÇÃO",0,1,'C',0);
	$pdf->Ln(20);

	$pdf->MultiCell(0,5,$texto);
	$pdf->Ln(10);

	$pdf->SetX(100);
	$pdf->Cell(0,5, $local);
	$pdf->Ln(31);

	// Coloco o cursor em 100 para a dereita e 180 de cima para baixo
	$pdf->SetXY(100,180);
	$pdf->Line(120,175,180,175);
	$pdf->SetX(120);
	$pdf->Cell(30,0, "por Comissão de TCC","r");

	$pdf->AddPage();

	}

$pdf->Output();

?>