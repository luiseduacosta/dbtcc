<?php

include("../../include_db.inc");
include("../../setup.php");

$origem   = $_REQUEST['origem'];
$num_area = $_REQUEST['num_area'];
$ordem    = $_REQUEST['ordem'];

if (empty($num_area)) {
	echo "<p>Retornar para selecionar uma area";
	exit;
	}

if (empty($ordem)) {
	$ordem = "titulo";
	}

$sql = "select area from areas where numero='$num_area'";
$resultado = $db->Execute($sql);
if($resultado === false) die ("Não foi possivel consultar a tabela areas");
while(!$resultado->EOF) {
	$area = $resultado->fields['area'];
	$resultado->MoveNext();
}

// Si a área é não corresponde ou sem dados
if (($num_area === '99') || ($num_area === '91')) {
	if ($num_area == '99') {
			$sql_sem_dados = "select monografia.codigo, monografia.titulo, monografia.periodo, professores.nome from monografia "
			. " inner join professores on monografia.num_prof = professores.id "
			. " where num_area = '99' "
			. " order by $ordem";
	} elseif ($num_area == '91') {
			$sql_sem_dados = "select monografia.codigo, monografia.titulo, monografia.periodo, professores.nome from monografia "
			. " inner join professores on monografia.num_prof = professores.id "
			. " where num_area = '91' "
			. " order by $ordem";
	}
	// echo $sql_sem_dados . "<br>";
	$resultado_sem_dados = $db->Execute($sql_sem_dados);
	$i = 0;
	while(!$resultado_sem_dados->EOF) {
		$monografias[$i]['codigo'] = $resultado_sem_dados->fields['codigo'];
		$monografias[$i]['titulo'] = $resultado_sem_dados->fields['titulo'];
		$monografias[$i]['periodo'] = $resultado_sem_dados->fields['periodo'];
		$monografias[$i]['professor'] = $resultado_sem_dados->fields['nome'];
		$i++;
		$resultado_sem_dados->MoveNext();
	}

	$smarty = new template_tcc;
	$smarty->assign("id_area",$num_area);
	$smarty->assign("area",$area);
	$smarty->assign("monografiaSem",$monografias);
	$smarty->display("monografia-monografia.tpl");
	exit;
}

/* Tabela dos professores da área */
$sql_prof_area = "select * from prof_area where num_area='$num_area'";
// echo $sql_prof_area . "<br>";
$resultados_prof_area = $db->Execute($sql_prof_area);
if($resultados_prof_area === false) die ("Nao foi possivel consultar a tabela prof_area");
$quantidade = $resultados_prof_area->RecordCount();

$j = 0;
while(!$resultados_prof_area->EOF) {
	$num_prof = $resultados_prof_area->fields['num_prof'];
	$resultados_prof_area->MoveNext();

	$sql_professores = "select nome, departamento, tipocargo, email from professores where id='$num_prof' order by nome";
	// echo $sql_professores . "<br>";
	$resultados_professores = $db->Execute($sql_professores);
	if($resultados_professores === false) die ("Naox foi possivel consultar a tabela professores");
	while(!$resultados_professores->EOF) {
		$professores[$j]['nome'] = $resultados_professores->fields['nome'];
		$professores[$j]['departamento'] = $resultados_professores->fields['departamento'];
		$professores[$j]['condicao'] = $resultados_professores->fields['condicao'];
		$professores[$j]['email'] = $resultados_professores->fields['email'];
		$resultados_professores->MoveNext();
		}

	$sql_monografia_num_prof = "select codigo, titulo, periodo, area, nome from monografia "
	. " inner join areas on monografia.num_area = areas.numero "
	. " inner join professores on monografia.num_prof = professores.id "
	. " where num_prof='$num_prof' order by $ordem";
	// echo $sql_monografia_num_prof . "<br>";
	$resultado = $db->Execute($sql_monografia_num_prof);
	if($resultado === false) die ("Não foi possivel consultar a tabela monografia");
	$quantidade = $resultado->RecordCount();

	$k = 0;
	while(!$resultado->EOF) {
		$monografias[$k]['codigo'] = $resultado->fields['codigo'];
		$monografias[$k]['titulo'] = $resultado->fields['titulo'];
		$monografias[$k]['periodo'] = $resultado->fields['periodo'];
		$monografias[$k]['area'] = $resultado->fields['area'];
		$monografias[$k]['nome'] = $resultado->fields['nome'];
		$resultado->MoveNext();
		$k++;
		}
	$j++;
	}

$smarty = new template_tcc;
$smarty->assign("id_area",$num_area);
$smarty->assign("area",$area);
$smarty->assign("professores",$professores);
$smarty->assign("monografias",$monografias);
$smarty->display("monografia-monografia.tpl");

$db->Close();

?>