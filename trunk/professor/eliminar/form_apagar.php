<html>
<head>
<link href="../../css/tcc.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php

$sql = "SELECT * FROM professores ORDER BY nome";
include("../../include_db.inc");
$resultado = $db->Execute($sql);
if($resultado == false) die ("Não foi possível consultar a tabela professores");
echo "
<div align='left'>
<form name='eliminar' method='POST' action='apagar.php'>

<p>Nome:
<select name='num_prof' size='1'>
<option value='0'>Selecione registro a ser cancelado</option>
";

while(!$resultado->EOF)
	{
	$num_prof = $resultado->fields['numero'];
	$nome     = $resultado->fields['nome'];
	echo "
	<option value='$num_prof'>$nome</option>
	";
	$resultado->MoveNext();
	}

echo "
</select>
<input type='submit' name='enviar' value='Enviar'>
</form>
</div>
";

$db->Close();

?>

</body>
</html>