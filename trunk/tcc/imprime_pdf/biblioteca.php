<?php

define("FPDF_FONTPATH","/usr/local/htdocs/html/fpdf151/font/");
define("FPDF","/usr/local/htdocs/html/fpdf151/");
require(FPDF."fpdf.php");

$periodo      = $_REQUEST['periodo'];
$data_arquivo = $_REQUEST['data_arquivo'];

$sql = "select * from monografia where periodo='$periodo' order by titulo";
include("../include_db.inc");
$resposta_monografia = $db->Execute($sql);
if($resposta_monografia == false) die ("Não foi possível consultar a tabela monografia");

$i = 0;
while(!$resposta_monografia->EOF) {
	$codigo        = $resposta_monografia->fields['codigo'];
	$titulo        = $resposta_monografia->fields['titulo'];
	$num_professor = $resposta_monografia->fields['num_prof'];
	$resposta_monografia->MoveNext();

	include("alunos.inc");

	$sql_professores = "select * from professores where id='$num_professor'";
	$resposta_professores = $db->Execute($sql_professores);
	if($resposta_professores == false) die ("Não foi possível consultar a tabela professores");
	while(!$resposta_professores->EOF) {
		$professor = $resposta_professores->fields['nome'];
		$resposta_professores->MoveNext();
	}

	$matriz[$i]['titulo'] = $titulo;
	$matriz[$i]['aluno'] = $aluno;
	$matriz[$i]['professor'] = $professor;
	$i++;

	}

$data = split("/",$data_arquivo);
$dia = $data[0];
$mes_num = $data[1];
$mes_data = array("Janeiro","Fevereiro","Março","Abril","Maio","Junho","Julho","Agosto","Setembro","Outubro","Novembro","Dezembro");
$mes = $mes_data[($mes_num - 1)];
$ano = $data[2];

$local = "Rio de Janeiro, " . $dia . " de " . $mes . " de " . $ano . ".";

$pagina = 1; // A primeira pagina corresponde a carta de apresentação da listagem

$pdf=new FPDF();
$pdf->Open();
$pdf->AddPage();
$pdf->SetMargins(30,20,30);
$pdf->SetFont("Arial","","12");

$pdf->Image("minerva.jpg",100,20,20,20,jpg);
$pdf->Ln(30);

$cabecalho1 = $pdf->GetStringWidth("UNIVERSIDADE FEDERAL DO RIO DE JANEIRO");
$pdf->SetX((210-$cabecalho1)/2);
$pdf->Cell($cabecalho1,9,"UNIVERSIDADE FEDERAL DO RIO DE JANEIRO",0,1,'C',0);
$pdf->Ln(5);

$cabecalho2 = $pdf->GetStringWidth("Escola de Serviço Social");
$pdf->SetX((210-$cabecalho2)/2);
$pdf->Cell($cabecalho2,9,"Escola de Serviço Social",0,1,'C',0);
$pdf->Ln(20);

/* Data */
$pdf->SetX(120);
$pdf->Cell(20,0, $local);
$pdf->Ln(20);

/* Corpo da carta */
$pdf->SetX(30);
$pdf->Cell(40,0, "Responsável da biblioteca:");
$pdf->Ln(30);
$pdf->MultiCell(0,5,"Estamos encaminhando a listagem das monografias (trabalho de conclusão de curso) dos alunos da Escola de Serviço Social correspondente ao período $periodo.");
$pdf->Ln(10);

$pdf->Cell(0,0,"Atenciosamente,");
$pdf->Ln(10);
/* Assinatura */
$pdf->SetXY(120,200);
$pdf->Line(120,195,180,195);
$pdf->Cell(30,0, "por Comissão de TCC","r");

$pdf->AddPage();

$pagina++;

$cabecalho1 = $pdf->GetStringWidth("UNIVERSIDADE FEDERAL DO RIO DE JANEIRO");
$pdf->SetX((210-$cabecalho1)/2);
$pdf->Cell($cabecalho1,9,"UNIVERSIDADE FEDERAL DO RIO DE JANEIRO",0,1,'C',0);
$pdf->Ln(3);

$cabecalho2 = $pdf->GetStringWidth("Escola de Serviço Social");
$pdf->SetX((210-$cabecalho2)/2);
$pdf->Cell($cabecalho2,9,"Escola de Serviço Social",0,1,'C',0);

$cabecalho3 = $pdf->GetStringWidth("Monografias do periodo $periodo");
$pdf->SetX((210-$cabecalho3)/2);
$pdf->Cell($cabecalho3,9,"Monografias do periodo $periodo",0,1,'C',0);

$pdf->SetX(25);
$pdf->Cell(70,7,"Titulo",1,0,"C");
$pdf->Cell(50,7,"Aluno",1,0,"C");
$pdf->Cell(45,7,"Orientador",1,0,"C");

$y = 60; // A primeira linea inicia no lugar 650. Logo passa a ser 750.

for($i=0;$i<sizeof($matriz);$i++) {
	$titulo    = $matriz[$i]['titulo'];
	$aluno     = $matriz[$i]['aluno'];
	$professor = $matriz[$i]['professor'];

	$pdf->SetXY(25,$y);
	$pdf->MultiCell(70,5,$titulo, 0, 1);
	
	$pdf->SetXY(100,$y);
	$pdf->MultiCell(50,5,$aluno, 0, 1);

	$pdf->SetXY(150,$y);
	$pdf->MultiCell(40,5,$professor, 0, 1);

	$pdf->SetY(260); // 15 mm a partir del borde inferior
	$numero_pagina = $pdf->PageNo() - 1 ;
	$pdf->Cell(0,10,$numero_pagina,0,0,"C");

	$y = $y + 32;
	if($y > 230) {
		$y = 30;
		$pdf->AddPage();
		$pdf->SetX(25);
		$pdf->Cell(70,7,"Titulo",1,0,"C");
		$pdf->Cell(50,7,"Aluno",1,0,"C");
		$pdf->Cell(45,7,"Orientador",1,0,"C");
		}

	$pdf->Ln();

	}

$pdf->Output();

?>