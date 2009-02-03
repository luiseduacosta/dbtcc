<?php

$num_area = $_POST['num_area'];

include("../../autentica.inc");

require_once("../../include_db.inc");
$sql = "select * from areas where numero='$num_area'";
$resultado = $db->Execute($sql);
if($resultado == false) die ("Nao foi possível consultar a tabela areas");
while(!$resultado->EOF)
{
	$area = $resultado->fields['area'];
	$resultado->MoveNext();
}

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<p>Atualizar área:  $num_area  $area  </p>
<form name='area' action='update_area.php' method='post'>
<input type='text' name='nova_area' value='$area' size='50' maxlength='50'>
<input type='hidden' name='num_area' value='$num_area'>
<input type='submit' name='enviar' value='Confirma'>
</form>
</body>
</html>
";

$db->Close();

?>
