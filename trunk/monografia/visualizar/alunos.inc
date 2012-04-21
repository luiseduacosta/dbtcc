<?php

/*
Para ser iniciada é necessário o número da monografia (variavel $codigo)
O resultado desta rotina é uma string de nome aluno com o(s) nome(s)
dos aluno(s) autor(es) da monografia.
*/

$sql_monografia = "select titulo from monografia where codigo=$codigo";
$resultado_monografia = $db->Execute($sql_monografia);
if ($resultado_monografia === false) die ("Não foi possível consultar a tabela monografia");
$titulo = $resultado_monografia->fields['titulo'];

$sql_alunos = "select * from tcc_alunos where num_monografia='$codigo'";
$resultado_alunos = $db->Execute($sql_alunos);
if ($resultado_alunos === false) die ("Não foi possível consultar a tabela alunos");
$quantidade_alunos = $resultado_alunos->RecordCount();

// echo $sql_alunos . "<br>";

$j = 0;
while (!$resultado_alunos->EOF) {
	$registro[$j]       = $resultado_alunos->fields['registro'];
	$num_aluno[$j]      = $resultado_alunos->fields['numero'];
	$nome[$j]           = $resultado_alunos->fields['nome'];
	$num_monografia[$j] = $resultado_alunos->fields['num_monografia'];
	$j++;
	$resultado_alunos->MoveNext();
	}
	
/*
Si a monografia foi feita com mais da um aluno entao *$quantidade* tem que ser maior que 1
*/

if ($quantidade_alunos == 1) {
	$aluno = $nome[0];
} elseif ($quantidade_alunos == 2) {
	$aluno = $nome[0] . " e " . $nome[1];
} elseif ($quantidade_alunos == 3) {
	$aluno = $nome[0] . ", " . $nome[1] . " e " . $nome[2];
} elseif ($quantidade_aluno > 3)
	echo "Error: mais da três alunos em monografia $codigo: $titulo";
else 
	echo "Error: nenhum aluno em monografia $codigo: $titulo";

?>