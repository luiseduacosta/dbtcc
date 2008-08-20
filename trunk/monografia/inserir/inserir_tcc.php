<?php

require_once("../../include_db.inc");
include("../../autentica.inc");

// Verifico se cursou estagio
$sql = "select registro from alunos where registro='$numeroaluno1'";
$resultado = $db->Execute($sql);
if($resultado === false) die ("Nao foi possivel consultar a tabela alunos");
$quantidade = $resultado->RecordCount();
if($quantidade > 0) {
    // echo "Aluno cursou estagio" . "<br>";
} else {
    echo "Opps! Aluno nao cursou estagio!" . "<br>";
    // exit;
}

$sql  = "INSERT INTO monografia(titulo,catalogo,areamonografia,resumo,data,periodo,num_prof,num_co_orienta,num_area, url) ";
$sql .= "VALUES('$titulo','$catalogo','$id_areamonografia','$resumo','$data','$periodo',$num_professor,$num_co_orienta,$id_areaProfessor,'$fichero')";
// echo $sql . "<br>";

// die("Aguarde");

$resultado = $db->Execute($sql);
if($resultado === false) die ("Nao foi possivel inserir os dados na tabela monografia");

// Pego o n�mero do codigo da monografia inserida anteriormente
// Con ele vou a inserir os alunos
$resposta = $db->Execute("select max(codigo) as id from monografia");
// $q_num_monografia = mysql_query("select last_insert_id()",$con);
if($resposta === false) die ("N�o foi poss�vel obter o �ltimo id da tabela monografia");
$num_monografia = $resposta->fields['id'];

if(empty($aluno1)) {
	echo "Campo de aluno vazio!!";
	exit;
} else {
	$aluno = $aluno1;
	$sql_aluno1  = "INSERT INTO tcc_alunos(nome,num_monografia,registro) ";
	$sql_aluno1 .= "VALUES('$aluno','$num_monografia','$numeroaluno1')";
	// echo $sql_aluno1 . "<br>";
	$resultado_aluno1 = $db->Execute($sql_aluno1);
	if($resultado_aluno1 === false) die ("N�o foi poss�vel inserir aluno1 na tabela alunos");
}

if($aluno2) {
	$aluno = $aluno2;
	$sql_aluno2  = "INSERT INTO tcc_alunos(nome,num_monografia,registro) ";
	$sql_aluno2 .= "VALUES('$aluno','$num_monografia','$numeroaluno2')";
	$resultado_aluno2 = $db->Execute($sql_aluno2);
	if($resultado_aluno2 === false) die ("N�o foi poss�vel inserir aluno2 na tabela alunos");
}

if($aluno3) {
	$aluno = $aluno3;
	$sql_aluno3  = "INSERT INTO tcc_alunos(nome,num_monografia,registro) ";
	$sql_aluno3 .= "VALUES('$aluno','$num_monografia','$numeroaluno3')";
	$resultado_aluno3 = $db->Execute($sql_aluno3);
	if($resultado_aluno3 === false) die ("N�o foi poss�vel inserir aluno3 na tabela alunos");
}

$sql_professores = "select nome from professores where id='$num_professor'";
$resultado_professores = $db->Execute($sql_professores);
if($resultado_professores === false) die ("N�o foi possivel consultar a tabela professores");
while(!$resultado_professores->EOF) {
	$professor = $resultado_professores->fields['nome'];
	$resultado_professores->MoveNext();
}

$sql_co_orienta = "select nome from professores where id='$num_co_orienta'";
$resultado_co_orienta = $db->Execute($sql_co_orienta);
if($resultado_co_orienta === false) die ("N�o foi possivel consultar a tabela (co)professores");
while(!$resultado_co_orienta->EOF) {
	$co_orienta = $resultado_co_orienta->fields['nome'];
	$resultado_co_orienta->MoveNext();
}

header("Location:../visualizar/ver_monografia.php?codigo=$num_monografia");

$db->close();

exit;

?>