<?php

require_once("../../setup.php");
require_once("../../data.php");

$data = $data_arquivo;
$data_nova = date('d/m/Y',strtotime($data));

$mes  = date('m',strtotime($data_nova));
$mes  = date('Y',strtotime($data_nova));

if ($mes >= 1 AND $mes <= 6) {
	$ano = $ano - 1;        // Ano passado
	$periodo = $ano . "-2"; // Segundo periodo do ano passado
	}
if ($mes >= 7 AND $mes <= 12) {
	$periodo = $ano . "-1"; // Primeiro periodo deste ano
	}

// Catalogo
$sql_catalogo = "select max(catalogo) as num_catalogo from monografia";
$resposta_catalogo = $db->Execute($sql_catalogo);
if($resposta_catalogo === null) die ("Nao foi possi­vel consultar a tabela tcc_alunos");
$catalogo = $resposta_catalogo->fields['num_catalogo'];

// Area da monografia
$sql_areaMonografia = "select id, areamonografia from areasmonografia order by areamonografia";
// echo $sql_areaMonografia . "<br>";
$resultado = $db->Execute($sql_areaMonografia);
if($resultado === false) die ("Nao foi possivel consultar a tabela areasmonografias");
$i = 0;
while (!$resultado->EOF) {
	$id_area = $resultado->fields['id'];
	$areamonografia = $resultado->fields['areamonografia'];

	$area_monografia[$i]['id_area'] = $id_area;
	$area_monografia[$i]['areamonografia'] = $areamonografia;

	$i++;
	$resultado->MoveNext();
}

// Orientadores
$sql_professores = "select id, nome from professores order by nome";
$resultado = $db->Execute($sql_professores);
if($resultado === false) die ("Nï¿½o foi possï¿½vel consultar a tabela professores");
$i = 0;
while (!$resultado->EOF) {
	$id_professor = $resultado->fields['id'];
	$professor    = $resultado->fields['nome'];

	$professores[$i]['id_professor'] = $id_professor;
	$professores[$i]['nome'] = $professor;

	$i++;
	$resultado->MoveNext();
}

// Alunos
// Seleciono os alunos que ja finalizaram o estagio
$sql_aluno = "SELECT registro, nome, nivel, periodo FROM alunos inner join estagiarios using (registro) where estagiarios.nivel = 4 order by nome";
$resposta_aluno = $db->Execute($sql_aluno);
if($resposta_aluno == false) die ("Nao foi possi­vel consultar a tabela alunos");
$j = 0;
while(!$resposta_aluno->EOF) {
	$registro = $resposta_aluno->fields['registro'];
	$nome = $resposta_aluno->fields['nome'];
	$nivel = $resposta_aluno->fields['nivel'];
	$periodo = $resposta_aluno->fields['periodo'];

	// Seleciono os alunos que ainda nao entregaram a monografia
	$sql_tcc = "select registro from tcc_alunos where registro=$registro";
	// echo $sql_tcc . "<br>";
	$resposta_tcc = $db->Execute($sql_tcc);
	$quantidade = $resposta_tcc->RecordCount();
	// echo $quantidade . "<br>";

	if($quantidade === 0) {
		$alunos[$j]['registro'] = $registro;
		$alunos[$j]['nome'] = $nome;
		$j++;
		// echo $j . " " . $registro ." ". $nome . " " . $nivel . " ". $periodo .  "<br>";
	}

	$resposta_aluno->MoveNext();
}

$smarty = new template_tcc;
$smarty->assign('catalogo',$catalogo);
$smarty->assign('areamonografia',$area_monografia);
$smarty->assign('professores',$professores);
$smarty->assign('alunos',$alunos);
$smarty->assign('periodo',$periodo);
$smarty->assign('data',$data);
$smarty->display('alunos-inserir_formulario.tpl');

?>
