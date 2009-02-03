<?php

include("../../autentica.inc");

$num_prof = $_REQUEST['num_prof'];

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";

/* Verifico se existe este *num_prof* na tabela *monografia* */
/* Se existe não elimino */

$sql = "select * from monografia where num_prof='$num_prof'";
include("../../include_db.inc");
$resultado = $db->Execute($sql);
if ($resultado == false) die ("Não foi possível consultar a tabela monografia");
$linhas = $resultado->RecordCount();
if ($linhas > 0)
	{
	echo $sql . "<br>";
	echo "<p><strong>Este registro não será eliminado por existir uma monografia associada a ese nome!!</strong><p>";
	$db->Close();
	exit;
	}
else
	{
	$sql_professores = "DELETE FROM professores WHERE numero='$num_prof'";
	$resultado_professores = $db->Execute($sql_professores);
	if ($resultado_professores == false) die ("Não foi possível apagar o registro da tabela professores");

	$sql_prof_area = "delete from prof_area where num_prof='$num_prof'";
	$resultado_prof_area = $db->Execute($sql_prof_area);
	if ($resultado_prof_area == false) die ("Não foi possível apagar o registro da tabela prof_area");
	
	$db->Close();

	echo "<p>Registro eliminado!!</p>";

	exit;
	}

echo "
</body>
</html>
";

?>
