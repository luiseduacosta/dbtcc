<?php

/*
Para ser iniciada � necess�rio o n�mero da monografia (variavel $codigo)
O resultado desta rotina � uma string de nome aluno com o(s) nome(s)
dos aluno(s) autor(es) da monografia.
*/

$sql_alunos = "select * from alunos where num_monografia='$codigo'";
$resultado_alunos = $db->Execute($sql_alunos);
if($resultado_alunos === false) die ("N�o foi possivel consultar a tabela alunos");
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
Si a monografia foi feita por mais da um aluno ent�o *$quantidade* tem que ser maior que 1
*/

if($quantidade_alunos === 1)
	{
	$aluno = $nome_aluno[0];
	}
elseif($quantidade_alunos === 2)
	{
	$aluno = $nome_aluno[0] . " e " . $nome_aluno[1];
	}
elseif($quantidade_alunos === 3)
	{
	$aluno = $nome_aluno[0] . ", " . $nome_aluno[1] . " e " . $nome_aluno[2];
	}
elseif($quantidade_aluno > 3)
	echo "Error: mais da tr�s alunos em monografia $codigo";
else 
	echo "Error: nenhum aluno em monografia $codigo";

?>