<?php

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<form name='seleciona_aluno' action='atualiza.php' method='post'>
<select name='id_aluno' size='1'>
<option value='0'>Seleciona aluno</option>
";

$sql = "select * from tcc_alunos order by nome";
include("../../include_db.inc");
$resultado = $db->Execute($sql);
if($resultado == false) die ("Não foi possível consultar a tabela alunos");
while(!$resultado->EOF)
	{
	$num_aluno = $resultado->fields['numero'];
	$nome      = $resultado->fields['nome'];
	$num_monografia = $resultado->fields['num_monografia'];
	echo "<option value='$num_aluno'>$nome</option>";
	$resultado->MoveNext();
	}

$db->Close();
		
echo "
</select>
";

echo "
<input type='submit' name='submit' value='Enviar'>
</form>
</body>
</html>
";

?>