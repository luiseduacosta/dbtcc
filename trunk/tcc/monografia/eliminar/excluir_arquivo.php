<?php

include_once("../../include_db.inc");

$url = $_GET['url'];
$codigo = $_GET['codigo'];

$file = "/usr/local/htdocs/html/monografias/" . $url;
// echo "Arquivo: ". $file . "<br>";
if (file_exists("$file")) {
	if (unlink("$file")) {
		// echo "File was successfully deleted";
		$sql = "update monografia set url='' where codigo='$codigo'";
		// echo $sql . "<br>";
		$resultado = $db->Execute($sql);
		if ($resultado === false) die("Nao foi possivel atualizar a tabela monografias");
		header("Location:../visualizar/ver_monografia.php?codigo=$codigo");
	} else {
		echo "File was not deleted.";
	}
} else {
	echo "File does not exist.";
}

?>