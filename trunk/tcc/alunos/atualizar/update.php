<?php

include("../../autentica.inc");
include("../../include_db.inc");

$codigo         = $_POST['codigo'];
$num_monografia = $_POST['num_monografia'];
$registro       = $_POST['registro'];
$id_aluno       = $_POST['id_aluno'];
$nome		= $_POST['nome'];
$titulo		= $_POST['titulo'];
$periodo	= $_POST['periodo'];

// echo $registro . "<br>";
/* Se não foi selecionada outra monografia */
if ($codigo != '0') {
	// echo "Codigo: " . $codigo . "<br>";
	$num_monografia = $codigo;
	// echo "Numero monografia: " . $num_monografia . "<br>";
} else {
	// echo "Codigo igual a zero <br>";
	// $num_monografia = "";
}

if (empty($registro)) {
	$registro = 0;
}

$sql  = "update tcc_alunos set nome='$nome', ";
$sql .= "num_monografia='$num_monografia', ";
$sql .= "registro='$registro' ";
$sql .= "where numero='$id_aluno'";
// echo $sql . "<br>";

$resultado = $db->Execute($sql);
if ($resultado === false) die ("Nao foi possivel atualizar a tabela alunos");
// Mostro o aluno atualizado

$sql_monografia = "update monografia set titulo='$titulo', periodo='$periodo' " .
		"where codigo='$num_monografia'";
// echo $sql_monografia . "<br>";

$res_monografia = $db->Execute($sql_monografia);
if ($res_monografia === false) die ("Não foi possível atualizar a tabela monografia");

header("Location: ../visualizar/aluno.php?id_aluno=$id_aluno");

?>