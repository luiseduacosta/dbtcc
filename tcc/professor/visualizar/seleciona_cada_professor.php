<?php

$num_prof = $_REQUEST['num_prof'];
$submit   = $_REQUEST['submit'];

echo $num_prof . "<br />";
echo $submit . "<br />";

if($submit == "Avanzar")
	{
	$index++;
	echo $index . "<br />";
	}

$sql = "select * from professores where numero='$num_prof'";
echo $sql . "<br />";
include("../../include_db.inc");
$resposta = $db->Execute($sql);
if($resposta = false) die ("Não foi possível consultar a tabela professores");
while(!$resposta->EOF)
	{
	$nome = $resposta->fields['nome'];
	echo $nome . "<br />";

	$num_prof++;

	echo "
	<form action='$PHP_SELF'>
	<input type='hidden' name='num_prof' value='$num_prof'>
	<input type='hidden' name='num_prof' value='$index'>
	<input type='submit' name='submit' value='Avanzar'>
	</form>
	";

	}

?>