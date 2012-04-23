<?php 

require("../../setup.php");

$titulo = isset($_REQUEST['titulo']) ? $_REQUEST['titulo'] : NULL;

if ($titulo) {
	$sql = "select codigo, titulo from monografia where titulo like '%$titulo%' order by titulo";
	// echo $sql . "<br>";
	$res = $db->Execute($sql);
	$quantidade = $res->RecordCount();
	if ($quantidade == 0) die ("<p>Não há registros com a palavra: $titulo</p><meta HTTP-EQUIV='refresh' CONTENT='2;URL=busca.php'>");
	// echo $res . "<br>";
	$i = 0;
	while (!$res->EOF) {
		
		$monografia[$i]['titulo'] = $res->fields['titulo'];
		$monografia[$i]['codigo'] = $res->fields['codigo'];

		// echo $i . " " . $monografia[$i]['titulo'] . "<br>";

		$res->MoveNext();
		$i++;
	}
}

$smarty = new template_tcc;
$smarty->assign("monografia",$monografia);
$smarty->display("monografia-busca.tpl");

?>