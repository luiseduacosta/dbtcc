<html>
<head>
<title><?php echo $_SERVER[PHP_SELF]; ?></title>
<link href="../../tcc.css" rel="stylesheet" type="text/css">
<script language="JavaScript" type="text/javascript">
<!--
function elimina()
	{
	var confirma;
	confirma=confirm("Tem certeza?");
	if(confirma==true)
		return true;
	else
		return false;
	}
//-->
</script>

</head>

<body>

<?php

/* Abro um conexao com o banco de dados */
include("../../include_db.inc");

$sql = "select * from inscricao order by nome";
$resultado = $db->Execute($sql);
if($resultado === false) die ("Não foi possível consultar a tabela inscricao");

echo "
<table>
<tr>
<td>
<form name='apagar' action='apagar.php' method='post'>
<select name='numero_inscricao' size='1'>
<option value='0'>Selecionar aluno</option>
";
while(!$resultado->EOF)
	{
	$nome      = $resultado->fields['nome'];
	$inscricao = $resultado->fields['numero'];
	$resultado->MoveNext();
	echo "
	<option value=$inscricao>$nome</option>
	";
	}
echo "
</select>
</td>

<td>
<input type='submit' name='enviar' value='Confirma' onClick='return elimina()'>
</td>
</form>
</table>
";

$db->Close();

?>

</body>
</html>