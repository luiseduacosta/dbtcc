<?php

require_once("../../setup.php");

$sql_aluno = "SELECT registro, nome, nivel, periodo FROM alunos inner join estagiarios using (registro) where estagiarios.nivel = 4 order by nome";
$resposta_aluno = $db->Execute($sql_aluno);
if($resposta_aluno == false) die ("Nao foi possi­vel consultar a tabela alunos");
$j = 0;
while(!$resposta_aluno->EOF) {
	$registro = $resposta_aluno->fields['registro'];
	$nome = $resposta_aluno->fields['nome'];
	$nivel = $resposta_aluno->fields['nivel'];
	$periodo = $resposta_aluno->fields['periodo'];

	$sql_tcc = "select registro from tcc_alunos where registro=$registro";
	// echo $sql_tcc . "<br>";
	$resposta_tcc = $db->Execute($sql_tcc);
	$quantidade = $resposta_tcc->RecordCount();
	// echo $quantidade . "<br>";

	if($quantidade === 0) {
		$alunos[$j]['registro'] = $registro;
		$alunos[$j]['nome'] = $nome;
		$alunos[$j]['nivel'] = $nivel;
		$alunos[$j]['periodo'] = $periodo;
		$j++;
		// echo $j . " " . $registro ." ". $nome . " " . $nivel . " ". $periodo .  "<br>";
	}

	$resposta_aluno->MoveNext();
}

$smarty = new template_tcc;
$smarty->assign('alunos',$alunos);
$smarty->assign('servidor',$_SERVER['SERVER_NAME']);
$smarty->display('alunos-pendencias.tpl');

?>
