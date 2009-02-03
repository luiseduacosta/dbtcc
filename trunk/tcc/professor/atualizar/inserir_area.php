<?php

include("../autentica.inc");

$num_prof = $_REQUEST['num_prof'];
$num_area = $_REQUEST['num_area'];

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";

$sql = "insert into prof_area values('$num_prof','$num_area')";
include("../../include_db.inc");
$resultado = $db->Execute($sql);
if($resultado == false) die ("Não foi possível inserir registro na tabela prof_area");
echo "<h1>Área inserida!</h1>";

// include("update.php");

?>
