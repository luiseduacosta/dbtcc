<?php

require_once("../../include_db.inc");
$sql = "select * from areasmonografia order by areamonografia";
$resultado = $db->Execute($sql);
if ($resultado == false) die ("Não foi possível consultar a tabela areasmonografia");

echo "
<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<form name='seleciona_area' action='atualiza_area.php' method='post'>
<select name='id_area' size='1'>
<option value='0'>Selecione área</option>
";
while(!$resultado->EOF)
	{
	$id_area = $resultado->fields['id'];
	$areamonografia = $resultado->fields['areamonografia'];
	echo "
	<option value='$id_area'>$areamonografia</option>
	";
	$resultado->MoveNext();
	}
echo "
</select>
<input type='hidden' name='opcao' value=$opcao>
<input type='submit' name='submit' value='Confirma'>
</form>
</body>
</html>
";

?>
