<?php

$area = $_REQUEST['area'];
include("../../autentica.inc");
include("../../include_db.inc");

$sql = "insert into areas(area) values('$area')";

$resposta = $db->Execute($sql);
if($resposta == false) die ("Nao foi possivel inserir o registro na tabela areas");
header("Location:../visualizar/listar_areas.php");
// echo "<p>Area inserida!!";

?>
