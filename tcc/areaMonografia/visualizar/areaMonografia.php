<?php

include("../../include_db.inc");
include("../../setup.php");

$id_areamonografia = $_GET['id_area'];
$area = $_GET['area'];

$sql = "select codigo, titulo, periodo, "
. " nome as professor "
. " from monografia "
. " left outer join professores on monografia.num_prof = professores.id "
. " where areamonografia = $id_areamonografia";
// echo $sql . "<br>";
$resultado = $db->Execute($sql);
if ($resultado === false) die ("Não foi possível consultar a tabela mongrafia");
$i = 0;
while (!$resultado->EOF) {
		$monografia[$i]['codigo'] = $resultado->fields['codigo'];
		$monografia[$i]['titulo'] = $resultado->fields['titulo'];
		$monografia[$i]['periodo'] = $resultado->fields['periodo'];
		$monografia[$i]['professor'] = $resultado->fields['professor'];
		$resultado->MoveNext();
		$i++;
}

$smarty = new templateTcc;
$smarty->assign("monografia",$monografia);
$smarty->assign("area",$area);
$smarty->display("areamonografia.tpl");

?>
