<?php

/*Alterar inscrição de alunos*/

echo "
<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<table>
<form name='alteracao' action='form_altera.php' method='post'>
<tr>
<td>
<select name='aluno_registro' size=1>
<option value=0>Selecione inscrição</option>
";
$sql_inscricao = "select * from inscricao order by nome";
include("../../include_db.inc");
$resultado = $db->Execute($sql_inscricao);
while(!$resultado->EOF)
	{
	$registro = $resultado->fields['registro'];
	$nome     = $resultado->fields['nome'];
	$resultado->MoveNext();
	echo "
	<option value=$registro>$nome</option>
	";
	}
echo "
</select>
</td>
<td><input type='submit' value='Confirma' name='envia'></td>
</tr>
</table>
";

$db->Close();

?>