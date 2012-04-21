<?php

echo "
<html>
<head>
<title>$PHP_SELF</title>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";

$numero_inscricao = $_POST['numero_inscricao'];

/* Abro conexao */
include("../../include_db.inc");

/* Consulto a tabela */
$sql = "delete from inscricao where numero=$numero_inscricao";
$resultado = $db->Execute($sql);

echo "<h1>Registro cancelado!</h1>";

$db->Close();

?>