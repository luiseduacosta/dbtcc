<?php

echo "
<body class='body'>
<div>
<table width='50%'>
<th>Selecione a area</th>
<tr><td>
<form name='seleciona_area_professor' action='inserir_area.php' method='post'>
";

$sql = "select * from prof_area where num_prof='$num_professor'";
include("../../include_db.inc");
$resposta = $db->Execute($sql);
if ($resposta === false) die ("Não foi possível consultar a tabela prof_area");
while (!$resposta->EOF)
	{
	$num_area = $resposta->fields['num_area'];
	$sql_areas = "select * from areas where numero='$num_area' order by area";
	$resposta_areas = $db->Execute($sql_areas);
	if ($resposta_areas === false) die ("Não foi possivel consultar a tabela areas");
	while (!$resposta_areas->EOF)
		{
		$n_area = $resposta_areas->fields['numero'];
		$area   = $resposta_areas->fields['area'];
		$resposta_areas->MoveNext();
		}
	echo "
	<input type='radio' name='n_area' value='$n_area'>$area<br>
	";
	$resposta->MoveNext();
	}

echo "
<input type='radio' name='n_area' value='99'>Não se corresponde com nenhuma destas áreas<br>

</td></tr>
<tr><td>
<input type='hidden' name='num_professor' value='$num_professor'>
<input type='submit' name='submit' value='Enviar'>
</td></tr>
</form>
</td>
</tr>
</table>
</div>
";

$db->Close();

?>