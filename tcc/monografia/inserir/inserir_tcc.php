<?php

require_once("../../include_db.inc");
require("../../autentica.inc");

// Verifico se cursou estagio
$sql = "select registro from alunos where registro='$numeroaluno1'";
$resultado = $db->Execute($sql);
if ($resultado === false) die ("Nao foi possivel consultar a tabela alunos");
$quantidade = $resultado->RecordCount();
if ($quantidade > 0) {
    // echo "Aluno cursou estagio" . "<br>";
} else {
    echo "Opps! Aluno não cursou estagio!" . "<br>";
    // exit;
}

/* Coloco as datas no padrõn sql */
$data_sql = date('Y-m-d', strtotime($data));
// echo "Data " . $data . "<br>";
// echo "Data sql " . $data_sql . "<br>";
$data_defesa_sql = date('Y-m-d', strtotime($data_defesa));

$sql  = "INSERT INTO monografia(titulo, catalogo, areamonografia, resumo, data, periodo, num_prof, num_co_orienta, num_area, url, data_defesa, banca1, banca2, banca3, convidado) ";
$sql .= "VALUES('$titulo','$catalogo','$id_areamonografia','$resumo','$data_sql','$periodo',$num_professor,$num_co_orienta,$id_areaProfessor,'$fichero', '$data_defesa_sql', '$banca1', '$banca2', '$banca3', '$convidado')";
// echo $sql . "<br>";
// die("Aguarde");

$resultado = $db->Execute($sql);
if ($resultado === false) die ("Nao foi possivel inserir os dados na tabela monografia");

// Pego o numero do codigo da monografia inserida anteriormente
// Con ele vou a inserir os alunos
$resposta = $db->Execute("select max(codigo) as id from monografia");
// $q_num_monografia = mysql_query("select last_insert_id()",$con);
if ($resposta === false) die ("Não foi possível obter o último id da tabela monografia");
$num_monografia = $resposta->fields['id'];

if (empty($aluno1)) {
	echo "Campo de aluno vazio!!";
	exit;
} else {
	$aluno = $aluno1;
	$sql_aluno1  = "INSERT INTO tcc_alunos(nome,num_monografia,registro) ";
	$sql_aluno1 .= "VALUES('$aluno','$num_monografia','$numeroaluno1')";
	// echo $sql_aluno1 . "<br>";
	$resultado_aluno1 = $db->Execute($sql_aluno1);
	if ($resultado_aluno1 === false) die ("Não foi possível inserir aluno1 na tabela alunos");
}

if ($aluno2) {
	$aluno = $aluno2;
	$sql_aluno2  = "INSERT INTO tcc_alunos(nome,num_monografia,registro) ";
	$sql_aluno2 .= "VALUES('$aluno','$num_monografia','$numeroaluno2')";
	$resultado_aluno2 = $db->Execute($sql_aluno2);
	if ($resultado_aluno2 === false) die ("Não foi possível inserir aluno2 na tabela alunos");
}

if ($aluno3) {
	$aluno = $aluno3;
	$sql_aluno3  = "INSERT INTO tcc_alunos(nome,num_monografia,registro) ";
	$sql_aluno3 .= "VALUES('$aluno','$num_monografia','$numeroaluno3')";
	$resultado_aluno3 = $db->Execute($sql_aluno3);
	if($resultado_aluno3 === false) die ("Não foi possível inserir aluno3 na tabela alunos");
}

$sql_professores = "select nome from professores where id='$num_professor'";
$resultado_professores = $db->Execute($sql_professores);
if ($resultado_professores === false) die ("Não foi possivel consultar a tabela professores");
while (!$resultado_professores->EOF) {
	$professor = $resultado_professores->fields['nome'];
	$resultado_professores->MoveNext();
}

$sql_co_orienta = "select nome from professores where id='$num_co_orienta'";
$resultado_co_orienta = $db->Execute($sql_co_orienta);
if ($resultado_co_orienta === false) die ("Não foi possivel consultar a tabela (co)professores");
while (!$resultado_co_orienta->EOF) {
	$co_orienta = $resultado_co_orienta->fields['nome'];
	$resultado_co_orienta->MoveNext();
}

header("Location:../visualizar/ver_monografia.php?codigo=$num_monografia");

$db->close();

exit;

?>