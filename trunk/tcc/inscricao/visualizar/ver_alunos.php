<?php

echo "
<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";

$ordem = $_REQUEST['ordem'];

/* Abro uma conexão com o banco de dados */
require_once("../../include_db.inc");

$i = 0;  // Contador para definir si o nome de professor está repetido (+ de 0)
$j = 0;

$sql_professores = "select * from professores order by nome";
$resultado = $db->Execute($sql_professores);
if($resultado === false) die ("Não foi possível consultar a tabela professores");
while(!$resultado->EOF)
	{
	$nome_prof   = $resultado->fields['nome'];
	$numero_prof = $resultado->fields['numero'];
	$resultado->MoveNext();
	/* Busco na tabela inscricao si o professor tem orientandos */
	$sql_inscricao = "select * from inscricao where num_professor = '$numero_prof'";
	$resultado_inscricao = $db->Execute($sql_inscricao);
	if($resultado_inscricao === false) die ("Não foi possível consultar a tabela inscricao");
	$quantidade  = $resultado_inscricao->RecordCount();

	if(empty($ordem))
	    $ordem = "nome_prof";
	else
	    $indice = $ordem;

	$matriz[$j][$ordem] = $$indice;

	/* 
	* Si o professor não tem orientandos, então -> $quantidade == 0 .
	* Guardo o resultado na $matriz e incremento a variavel $j.
	*/
	
	if($quantidade === 0)
		{
		$matriz[$j]['nome_prof']   = $nome_prof;
		$matriz[$j]['numero_prof'] = $numero_prof;
		$matriz[$j]['quantidade']  = $quantidade;
		$matriz[$j]['registro']    = "0"; // O professor não tem alunos.
		$matriz[$j]['nome_aluno']  = " "; // Deixo o campo aluno em branco.
		$j++; // Aumento um registro: professores sem aluno 
		}
	else
		{
		while(!$resultado_inscricao->EOF)
			{
			$registro   = $resultado_inscricao->fields['registro'];
			$nome_aluno = $resultado_inscricao->fields['nome'];    // Pego o nome do aluno.
			$resultado_inscricao->MoveNext();
			
			$matriz[$j]['nome_prof']   = $nome_prof;
			$matriz[$j]['numero_prof'] = $numero_prof;
			$matriz[$j]['quantidade']  = $quantidade;
			$matriz[$j]['registro']    = trim($registro);
			$matriz[$j]['nome_aluno']  = $nome_aluno;
			$j++; // Aumento outro registro: professores com um ou mais aluno(s).
			}
		}
	}

$db->Close();

echo "
<div>
<table>
<tr>
	<th><a href=$_SERVER[PHP_SELF]?ordem=nome_prof>Professor</a></th>
	<th><a href=$_SERVER[PHP_SELF]?ordem=quantidade>Quantidade</th>
	<th><a href=$_SERVER[PHP_SELF]?ordem=registro>Registro</td>
	<th><a href=$_SERVER[PHP_SELF]?ordem=nome_aluno>Alunos</a></th>
</tr>
";

reset($matriz);	
sort($matriz);

for($i=0;$i < sizeof($matriz);$i++)
	{
	$professor      = $matriz[$i]['nome_prof'];
	$q_orientandos  = $matriz[$i]['quantidade'];
	$registro_aluno = $matriz[$i]['registro'];
	$aluno          = $matriz[$i]['nome_aluno'];

	echo "
	<tr>
		<td>$professor</td>
		<td>$q_orientandos</td>
		<td>$registro_aluno</td>
		<td>$aluno</td>
	</tr>
	";
	}

echo "
</table>
</div>
</body>
</html>
";

?>
