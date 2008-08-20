<?php

$id_aluno = $_REQUEST['id_aluno'];

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";

// Obtenho o codigo da monografia realizada pelo aluno
$sql = "select registro, num_monografia from tcc_alunos where numero='$id_aluno'";
// echo $sql . "<br>";
include("../../include_db.inc");
$resultado = $db->Execute($sql);
if($resultado === false) die ("Não foi possível consultar a tabela alunos");
while(!$resultado->EOF) {
	$registro = $resultado->fields['registro'];
	$codigo = $resultado->fields['num_monografia'];
	$resultado->MoveNext();
}

// Pego o(s) aluno(s) da monografia
include("alunos.inc");

echo "
<div align='center'>
<table border='1'>
<form name='atualiza' id='atualiza' action='../atualizar/atualiza.php' method='post'>
<tr>
<th colspan='2'>Trabalho de Conclusão de Curso do(s) aluno(s): $aluno</th>
</tr>
";

$sql_monografia = "select * from monografia where codigo='$codigo'";
$resultado_monografia = $db->Execute($sql_monografia);
if($resultado_monografia === false) die ("Não foi possível consultar a tabela monografia");
while(!$resultado_monografia->EOF) {
	$codigo   = $resultado_monografia->fields['codigo'];
	$titulo   = $resultado_monografia->fields['titulo'];
	$periodo  = $resultado_monografia->fields['periodo'];
	$num_prof = $resultado_monografia->fields['num_prof'];
	$resultado_monografia->MoveNext();	

	$sql_professores = "select * from professores where id='$num_prof'";
	$resultado_professores = $db->Execute($sql_professores);
	if($resultado_professores == false) die ("Não foi possível consultar a tabela professores");
	while(!$resultado_professores->EOF) {
		$professor = $resultado_professores->fields['nome'];
		$resultado_professores->MoveNext();
	}
        echo "
	<tr>
	<td>Titulo</td><td><a href='../../monografia/visualizar/ver_monografia.php?codigo=$codigo'>$titulo</a></td>
	</tr>

	<tr>
	<td>Periodo</td><td>$periodo</td>
	</tr>

	<tr>
	<td>Orientador</td><td>$professor</td>
	</tr>
	";
}

echo "
<tr>
<td class='coluna_centralizada' colspan='2'>
<input type='hidden' name='id_aluno' value=$id_aluno'>
<input type='submit' name='submit' value='Atualiza'>
</td>
</tr>
</form>
</table>
</div>
</body>
</html>
";
	
$db->Close();

?>