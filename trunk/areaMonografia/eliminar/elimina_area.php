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
// Recebo o valor da variável
$id_area = $_POST['id_area'];

// Consulto a tabela monografia para saber quais estão associados a esta área
$sql = "select codigo, titulo from monografia where areamonografia='$id_area'";
$resultado = $db->Execute($sql);
if($resultado == false) die ("Não foi possível consultar a tabela monografia");
$nrows = $resultado->RecordCount();
// Si existe uma monografia associada a esta area não pode ser eliminada
if($nrows != 0)
{
	echo "<p>Nao é possível eliminar esta area por estar associada a uma monografia. <br>";
	exit;
}
// Em caso contrário si posso eliminar a area da tabela
else 
{
	$sql = "delete from areasmonografia where id='$id_area'";
	$resultado = $db->Execute($sql);
	if($resultado == false) die ("Não foi possível eliminar o registro da tabela areasmonografia");

	echo "<p>Registro eliminado <br>";
}
	
$db->Close();

echo "
</body>
</html>
";

?>
