<?php

$area = $_REQUEST['area'];
include("../../autentica.inc");
include("../../include_db.inc");

$sql = "insert into areasmonografia(areamonografia) values('$area')";

$resposta = $db->Execute($sql);
if($resposta == false) die ("Nao foi possivel inserir o registro na tabela areasmonografia");
header("Location:../visualizar/listar_areas.php");
// echo "<p>Area inserida!!";

?>
