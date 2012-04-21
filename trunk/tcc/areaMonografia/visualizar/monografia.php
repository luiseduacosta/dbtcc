<?php

include("../../autentica.inc");
include("../../include_db.inc");
include("../../setup.php");

$codigo = $_REQUEST['codigo'];
$local = $_REQUEST['local'];

$sql = "select monografia.codigo, monografia.catalogo, monografia.titulo, monografia.resumo, "
. " monografia.num_prof, monografia.num_co_orienta, monografia.data, monografia.periodo, "
. " professores.nome, areasmonografia.id as id_areamonografia, areasmonografia.areamonografia, "
. " areas.numero as id_area, areas.area "
. " from monografia "
. " inner join professores on monografia.num_prof = professores.id "
. " left outer join areasmonografia on monografia.areamonografia = areasmonografia.id "
. " left outer join areas on monografia.num_area = areas.numero "
. " where codigo = '$codigo' "
. " order by titulo";
// echo $sql. "<br>";
$resposta = $db->Execute($sql);
if ($resposta === false) die ("Não foi possível consultar a tabela monografia");

while (!$resposta->EOF) {
	$codigo         = $resposta->fields['codigo'];
	$catalogo       = $resposta->fields['catalogo'];
	$titulo         = $resposta->fields['titulo'];
	$resumo         = $resposta->fields['resumo'];
	$data_sql       = $resposta->fields['data'];
	$periodo        = $resposta->fields['periodo'];
	$num_prof       = $resposta->fields['num_prof'];
	$nome           = $resposta->fields['nome'];
	$num_co_orienta = $resposta->fields['num_co_orienta'];
	$num_area       = $resposta->fields['id_area'];
	$area           = $resposta->fields['area'];
	$id_areamonografia = $resposta->fields['id_areamonografia'];
	$areamonografia = $resposta->fields['areamonografia'];
	
	if (empty($areamonografia)) {
			$areamonografia = "Selecione área";
	}

	$sqlAluno = "select numero, nome from tcc_alunos where num_monografia = $codigo";
	// echo $sqlAluno . "<br>";
	$respostaAluno = $db->Execute($sqlAluno);
	if ($respostaAluno === false) die ("Não foi possível consultar a tabela monografia");
	$i = 1;
	while (!$respostaAluno->EOF) {
			if ($i == 1) {
				$id_aluno1 = $respostaAluno->fields['numero'];
				$aluno1 = $respostaAluno->fields['nome'];
			} elseif ($i == 2) {
				$id_aluno2 = $respostaAluno->fields['numero'];
				$aluno2 = $respostaAluno->fields['nome'];
			} elseif ($i == 3) {
				$id_aluno3 = $respostaAluno->fields['numero'];
				$aluno3 = $respostaAluno->fields['nome'];
			}
		$i++;
		$respostaAluno->MoveNext();
	}

	if (empty($aluno1)) {
			$id_aluno1 = 0;
			$aluno1 = "Seleciona aluno";
	}
	if (empty($aluno2)) {
			$id_aluno2 = 0;
			$aluno2 = "Seleciona aluno";
	}
	if (empty($aluno3)) {
			$id_aluno3 = 0;
			$aluno3 = "Seleciona aluno";
	}

	if(ereg("([0-9]{4}).([0-9]{2}).([0-9]{2})",$data_sql,$regs))
		$data = $regs[3]."-". $regs[2]."-". $regs[1];

	$resposta->MoveNext();
	}

/**********
Professores 
**********/
$sql = "select * from professores order by nome";
$resposta_sql = $db->Execute($sql);
if ($resposta_sql === false) die ("Nao foi possivel consultar a tabela professores");

while (!$resposta_sql->EOF) {
	$professores[$i]['id'] = $resposta_sql->fields['numero'];
	$professores[$i]['nome'] = $resposta_sql->fields['nome'];
	$resposta_sql->MoveNext();
	$i++;
}

/************
Co-orientador 
************/
if (empty($num_co_orienta))
	{
	// echo "Não tem co-orientador <br>";
	$num_co_orienta = 0;
	$co_orientador = "Selecione co-orientador";
	}
else
	{
	$sql_co_orienta = "select nome from professores where id='$num_co_orienta'";
	$resultado_co_orienta = $db->Execute($sql_co_orienta);
	if ($resultado_co_orienta === false) die ("Não foi possivel consultar a tabela professores");
	while (!$resultado_co_orienta->EOF)
		{
		$co_orientador = $resultado_co_orienta->fields['nome'];
		$resultado_co_orienta->MoveNext();
		}
	}

/**********/
/* Alunos */
/**********/
$sql = "select * from tcc_alunos where num_monografia='$codigo'";
// echo $sql . "<br>";
$resposta = $db->Execute($sql);
if ($resposta === false) die ("Nao foi possivel consultar a tabela alunos");
$j = 0;
while (!$resposta->EOF)
	{
	$alunos[$j] = $resposta->fields['nome'];
	$j++;
	$resposta->MoveNext();
	}

$sql = "select numero, nome from tcc_alunos order by nome";
$resposta = $db->Execute($sql);
if ($resposta === false) die ("Não foi possivel consultar a tabela alunos");
$j = 0;
$alunosTotal[$j]['id'] = 0;
$alunosTotal[$j]['nome'] = "Seleciona aluno";
$j++;
while (!$resposta->EOF) {
		$alunosTotal[$j]['id'] = $resposta->fields['numero'];
		$alunosTotal[$j]['nome'] = $resposta->fields['nome'];
		$j++;
		$resposta->MoveNext();
	}

/***********************
* �reas dos Professores 
***********************/
$sql = "select num_area, area "
. " from prof_area "
. " inner join areas on prof_area.num_area = areas.numero "
. " where num_prof = $num_prof";
// echo $sql . "<br>";
$resposta_sql = $db->Execute($sql);
if ($resposta_sql === false) die ("Nao foi possivel consultar a tabela areas");
$i = 0;
$areasDosProfessores[$i]['id'] = 99;
$areasDosProfessores[$i]['area'] = "Não corresponde";
$i++;
while (!$resposta_sql->EOF)	{
	$areasDosProfessores[$i]['id'] = $resposta_sql->fields['num_area'];
	$areasDosProfessores[$i]['area'] = $resposta_sql->fields['area'];
	$i++;
	$resposta_sql->MoveNext();
	}

/***********************
* Áreas das Monografias 
************************/
$sql = "select id, areamonografia from areasmonografia order by areamonografia";
// echo $sql . "<br>";
$resposta_sql = $db->Execute($sql);
if ($resposta_sql === false) die ("Nao foi possivel consultar a tabela areasmonografia");
$i = 0;
while (!$resposta_sql->EOF) {
	$areasmonografias[$i]['id'] = $resposta_sql->fields['id'];
	$areasmonografias[$i]['areamonografia'] = $resposta_sql->fields['areamonografia'];
	// echo $resposta_sql->fields['areamonografia'] . "<br>";
	$resposta_sql->MoveNext();
	$i++;
	}

$db->Close();

$smarty = new template_tcc;
$smarty->assign("codigo",$codigo);
$smarty->assign("catalogo",$catalogo);
$smarty->assign("titulo",$titulo);
$smarty->assign("id_professor",$num_prof);
$smarty->assign("professor",$nome);
$smarty->assign("num_co_professor",$num_co_professor);
$smarty->assign("co_orientador",$co_orientador);
$smarty->assign("alunos",$alunos);
$smarty->assign("id_aluno1",$id_aluno1);
$smarty->assign("aluno1",$aluno1);
$smarty->assign("id_aluno2",$id_aluno2);
$smarty->assign("aluno2",$aluno2);
$smarty->assign("id_aluno3",$id_aluno3);
$smarty->assign("aluno3",$aluno3);
$smarty->assign("resumo",$resumo);
$smarty->assign("id_areaProfessor",$num_area);
$smarty->assign("areaProfessor",$area);
$smarty->assign("id_areamonografia",$id_areamonografia);
$smarty->assign("areamonografia",$areamonografia);
$smarty->assign("data",$data_sql);
$smarty->assign("periodo",$periodo);
$smarty->assign("alunosTotal",$alunosTotal);
$smarty->assign("professores",$professores);
$smarty->assign("areasDosProfessores",$areasDosProfessores);
$smarty->assign("areasmonografias",$areasmonografias);

$smarty->display("areaMono-monografia.html");

?>