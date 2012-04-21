<?php

include("../../autentica.inc");
require_once("../../include_db.inc");

$nova_area = $_REQUEST['nova_area'];
$id_area = $_REQUEST['id_area'];

echo "
<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>";

$sql = "update areasmonografia set areamonografia='$nova_area' where id='$id_area'";
$resultado = $db->Execute($sql);
if ($resultado == false) die ("Não foi possível atualizar a tabela areasmonografia");
echo "Registro atualizado !!! <br />";

$db->Close();

echo "
</body>
</html>
";

?>