<?php

include("../../autentica.inc");

require_once("../../include_db.inc");

$id_area = $_POST['id_area'];

$sql = "select areamonografia from areasmonografia where id='$id_area'";
$resultado = $db->Execute($sql);
if($resultado == false) die ("Nao foi poss�vel consultar a tabela areasmonografia");
while(!$resultado->EOF)
{
	$areamonografia = $resultado->fields['areamonografia'];
	$resultado->MoveNext();
}

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<p>Atualizar tabela das �reas das monografias:  $id_area  $areamonografia  </p>
<form name='area' action='update_area.php' method='POST'>
<input type='text' name='nova_area' value='$areamonografia' size='50' maxlength='50'>
<input type='hidden' name='id_area' value='$id_area'>
<input type='submit' name='enviar' value='Confirma'>
</form>
</body>
</html>
";

$db->Close();

?>
