<?php

echo "
<html>
<head>
<title>Avança e retrocede monografias</title>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";

$nova_area_prof = $_REQUEST['nova_area_prof'];

if(empty($nova_area_prof))
    $nova_area_prof = '91';

// require_once("../../conexao.dat");
require_once("../../include_db.inc");
$sql_update = "update monografia set num_area='$nova_area_prof' where codigo='$codigo'";
$resultado = $db->Execute($sql_update);
if ($resultado == false) die ("Nao foi possivel atualizar a tabela monografia");

if ($submit == "Avanzar")
{
  if ($indice > ($quantidade_mono-2))
    $indice = 0;
  else
    $indice++;
}
elseif ($submit == "Retroceder")
{
  if ($indice == 0)
    $indice = ($quantidade_mono-1);
  else
    $indice--;
}

require_once("selecao_monografia.php");

?>