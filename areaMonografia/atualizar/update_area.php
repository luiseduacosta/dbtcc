<?php

include("../../autentica.inc");
require_once("../../include_db.inc");

$nova_area = $_REQUEST['nova_area'];
$id_area = $_REQUEST['id_area'];

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>";

$sql = "update areasmonografia set areamonografia='$nova_area' where id='$id_area'";
$resultado = $db->Execute($sql);
if($resultado == false) die ("N�o foi poss�vel atualizar a tabela areasmonografia");
echo "Registro atualizado !!! <br />";

$db->Close();

echo "
</body>
</html>
";

?>