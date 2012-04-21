<?php

include("../../autentica.inc");
include("../../include_db.inc");

$numero_aluno = $_REQUEST['numero_aluno'];

echo "
<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";

$sql = "select * from tcc_alunos where numero='$numero_aluno'";
// echo $sql . "<br>";
$resultado = $db->Execute($sql);
if ($resultado === false) die ("Não foi possível consultar a tabela tcc_alunos");
while (!$resultado->EOF) {
	$nome           = $resultado->fields['nome'];
	$num_monografia = $resultado->fields['num_monografia'];
	$resultado->MoveNext();
}

$sql_tcc_alunos = "select numero, registro from tcc_alunos where num_monografia = $num_monografia"; 
// echo "sql_tcc_alunos: " . $sql_tcc_alunos . "<br>";
$resultado_tcc_alunos = $db->Execute($sql_tcc_alunos);
if ($resultado_tcc_alunos === false) die ("Não foi possível consultar a tabela tcc_alunos");
$q_alunos = $resultado_tcc_alunos->RecordCount();
// echo $q_alunos . "<br>";
			
$sql_monografia = "select titulo from monografia where codigo='$num_monografia'";
$resultado_monografia = $db->Execute($sql_monografia);
$quantidade = $resultado_monografia->RecordCount();
if ($resultado_monografia === false) die ("Não foi possível consultar a tabela monografia");
while (!$resultado_monografia->EOF) {
	$titulo = $resultado_monografia->fields['titulo'];
	$resultado_monografia->MoveNext();
}

echo "
<table>
<tr>
<td><p>Aluno $nome está relacionado com a monografia $titulo</td>
</tr>
</table>
";

// Si tem monografias associadas a este aluno não se cancela o registro
if ($q_alunos === 1) {
    echo "Registro do aluno não pode ser cancelado por estar relacionado com uma monografia";
} else {    
    $sql_aluno = "delete from tcc_alunos where numero='$numero_aluno'";
	// echo $sql_aluno . "<br>";
    $resultado = $db->Execute($sql_aluno);
    if ($resultado === false) die ("Não foi possível cancelar o registro do aluno da tabela alunos");
    echo "Registro excluido !! <br>";
}

$db->Close;

$destino = $_SERVER[HTTP_REFERER]. "?codigo=$num_monografia";
// echo "<a href='$destino'>Continuar</a>" . "<br>";
// header("location:$_SERVER[HTTP_REFERER]?codigo=$num_monografia");
echo "<meta http-equiv='refresh' content='1; url=$_SERVER[HTTP_REFERER]?codigo=$num_monografia'>";

?>