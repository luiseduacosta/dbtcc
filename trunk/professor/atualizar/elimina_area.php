<?php

include("../../autentica.inc");

/* Abro uma conexao com um banco da dados  */
require("../../include_db.inc");

$id_prof = $_REQUEST['id_prof'];

/* Verifico si essa area � a �nica �rea do professor */
$sql = "select * from prof_area where num_prof='$id_prof'";
$resultado = $db->Execute($sql);
if($resultado == false) die  ("N�o foi possivel consultar a tabela monografia");
$quantidade = $resultado->RecordCount();

if($quantidade > 1) {
	$sql_prof_area = "delete from prof_area where num_area='$num_area' and num_prof='$num_prof'";
	$resultado_prof_area = $db->Execute($sql_prof_area);
	if($resultado_prof_area == false) die ("N�o foi poss�vel consultar a tabela prof_area");
	// include("atualiza.php");
	header("Location: atualiza.php?num_prof=$num_prof&origem=$PHP_SELF");
} elseif($quantidade == 1){
	echo "�rea n�o pode ser excluida por ser a �nica deste professor.";
}
  	
?>
