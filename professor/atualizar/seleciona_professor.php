<html>
<head>
<link href="../../css/tcc.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php

echo "
<body>
<form action='atualiza.php' name='form_atualiza' method='POST'>
<select name='id_prof' size='1'>
<option value='0'>Selecione professor</option>
";

$sql = "select * from professores order by nome";
include("../../include_db.inc");
$resposta = $db->Execute($sql);
if($resposta == false) die ("Não foi possível consultar a tabela professores");
while(!$resposta->EOF) {
	$id_prof = $resposta->fields['id'];
	$nome    = $resposta->fields['nome'];
	echo "
	<option value='$id_prof'>$nome</option>
	";
	$resposta->MoveNext();
	}
	
echo "
</select>
<input type='submit' name='submit' value='Enviar'>
</form>
";

?>

</body>
</html>
