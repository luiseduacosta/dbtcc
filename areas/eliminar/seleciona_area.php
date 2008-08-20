<?php

require_once("../../include_db.inc");
$sql = "select * from areas order by area";
$resultado = $db->Execute($sql);
if($resultado == false) die ("Não foi possível consultar a tabela areas");

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<form name='seleciona_area' action='elimina_area.php' method='post'>
<select name='num_area' size='1'>
<option value='0'>Selecione area</option>
";
while(!$resultado->EOF)
	{
	$num_area = $resultado->fields['numero'];
	$area     = $resultado->fields['area'];
	echo "
	<option value='$num_area'>$area</option>
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
