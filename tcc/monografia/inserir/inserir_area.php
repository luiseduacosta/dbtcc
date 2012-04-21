<?php

include("../../autentica.inc");

$n_area        = $_REQUEST['n_area'];
$num_professor = $_REQUEST['num_professor'];

if(!(empty($n_area)))
	{
	$sql = "update monografia set num_area='$n_area' where num_prof='$num_professor'";
	require_once("../../include_db.inc");
	$resposta = $db->Execute($sql);
	if ($resposta === false) die ("Não foi possível atualizar a tabela monografia");
	$db->Close();
	
	// Retorno para o lar
	header("Location: form_inserir.php");

	}
else
	echo "Área sem dados <br>";

?>