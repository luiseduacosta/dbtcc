<?php

/*
Para ser iniciada é necessário o número da monografia (variavel $codigo)
O resultado desta rotina é uma string de nome aluno com o(s) nome(s)
dos aluno(s) autor(es) da monografia.
*/

// require_once("../../include_db.inc");
$sql_alunos = "select * from tcc_alunos where num_monografia='$codigo'";
$resultado_alunos = $db->Execute($sql_alunos);
if($resultado_alunos === false) die ("Não foi possivel consultar a tabela alunos");
$quantidade_alunos = $resultado_alunos->RecordCount();

$j = 0;
while(!$resultado_alunos->EOF)
	{
	$num_aluno[$j]      = $resultado_alunos->fields['numero'];
	$nome_aluno[$j]     = $resultado_alunos->fields['nome'];
	$num_monografia[$j] = $resultado_alunos->fields['num_monografia'];
	$j++;
	$resultado_alunos->MoveNext();
	}

/*
Si a monografia foi feita por mais da um aluno então *$quantidade* tem que ser maior que 1
*/

if($quantidade_alunos == 1)
	{
	$aluno = $nome_aluno[0];
	}
elseif($quantidade_alunos == 2)
	{
	$aluno = $nome_aluno[0] . " e " . $nome_aluno[1];
	}
elseif($quantidade_alunos == 3)
	{
	$aluno = $nome_aluno[0] . ", " . $nome_aluno[1] . " e " . $nome_aluno[2];
	}
elseif($quantidade_aluno > 3)
	echo "Error: mais da três alunos em monografia $codigo";
else 
	echo "Error: nenhum aluno em monografia $codigo";

?>