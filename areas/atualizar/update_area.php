<?php

include("../../autentica.inc");
$nova_area = $_REQUEST['nova_area'];
$num_area = $_REQUEST['num_area'];

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>";

$sql = "update areas set area='$nova_area' where numero='$num_area'";

require_once("../../include_db.inc");
$resultado = $db->Execute($sql);
if ($resultado == false) die ("Nao foi possivel atualizar a tabela areas");
echo "Registro atualizado !!! <br />";

$db->Close();

echo "
</body>
</html>
";

?>