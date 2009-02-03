<?php

echo "
<html>
<head>
</head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
<body>

<form name='aluno_seleciona' action='aluno.php' method='post'>
<select name='id_aluno' size='1'>
<option value='0'>Seleciona aluno</option>
";

$sql = "select numero, registro, nome from tcc_alunos order by nome";
include("../../include_db.inc");
$resultado = $db->Execute($sql);
if($resultado === false) die ("Nao foi possível consultar a tabela alunos");
while(!$resultado->EOF)
	{
	$registro  = $resultado->fields['id'];
	$num_aluno = $resultado->fields['numero'];
	$nome      = $resultado->fields['nome'];
	$num_monografia = $resultado->fields['num_monografia'];
	echo "<option value='$num_aluno'>$nome</option>";
	$resultado->MoveNext();
	}

$db->Close();

echo "
</select>

<input type='submit' name='submit' value='Enviar'>
</form>
</body>
</html>
";

?>