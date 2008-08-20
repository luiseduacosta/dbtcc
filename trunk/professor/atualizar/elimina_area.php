<?php

include("../../autentica.inc");

/* Abro uma conexao com um banco da dados  */
require("../../include_db.inc");

$id_prof = $_REQUEST['id_prof'];

/* Verifico si essa area é a única área do professor */
$sql = "select * from prof_area where num_prof='$id_prof'";
$resultado = $db->Execute($sql);
if($resultado == false) die  ("Não foi possivel consultar a tabela monografia");
$quantidade = $resultado->RecordCount();

if($quantidade > 1) {
	$sql_prof_area = "delete from prof_area where num_area='$num_area' and num_prof='$num_prof'";
	$resultado_prof_area = $db->Execute($sql_prof_area);
	if($resultado_prof_area == false) die ("Não foi possível consultar a tabela prof_area");
	// include("atualiza.php");
	header("Location: atualiza.php?num_prof=$num_prof&origem=$PHP_SELF");
} elseif($quantidade == 1){
	echo "Área não pode ser excluida por ser a única deste professor.";
}
  	
?>
