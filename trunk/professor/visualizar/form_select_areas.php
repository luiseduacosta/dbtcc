<html>
<head>
<link href="../../css/tcc.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php

$sql = "select * from areas order by area";
include("../../include_db.inc");
$resultado = $db->Execute($sql);
if ($resultado == false) die ("Não foi possível consultar a tabela areas");

echo "
<form name='seleciona_area' action='areasprofessor.php' method='POST'>
<select name='num_area' size='1'>
<option value='0'>Selecione uma area</option>
";
while (!$resultado->EOF)
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
<input type='submit' name='submit' value='Enviar'>
</form>
";

?>

</body>
</html>