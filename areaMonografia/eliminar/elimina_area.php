<?php

include("../../autentica.inc");

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
<script language='JavaScript' type='text/javascript'>
</script>
</head>
<body>
";

include("../../include_db.inc");
// Recebo o valor da vari�vel
$id_area = $_POST['id_area'];

// Consulto a tabela monografia para saber quais est�o associados a esta �rea
$sql = "select codigo, titulo from monografia where areamonografia='$id_area'";
$resultado = $db->Execute($sql);
if($resultado == false) die ("N�o foi poss�vel consultar a tabela monografia");
$nrows = $resultado->RecordCount();
// Si existe uma monografia associada a esta area n�o pode ser eliminada
if($nrows != 0)
{
	echo "<p>Nao � poss�vel eliminar esta area por estar associada a uma monografia. <br>";
	exit;
}
// Em caso contr�rio si posso eliminar a area da tabela
else 
{
	$sql = "delete from areasmonografia where id='$id_area'";
	$resultado = $db->Execute($sql);
	if($resultado == false) die ("N�o foi poss�vel eliminar o registro da tabela areasmonografia");

	echo "<p>Registro eliminado <br>";
}
	
$db->Close();

echo "
</body>
</html>
";

?>
