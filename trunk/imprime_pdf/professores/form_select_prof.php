<html>
<head>
</head>
<link href="../../css/tcc.css" rel="stylesheet" type="text/css">
<body>

<?php
$sql = "select * from professores order by nome";
include("../../include_db.inc");
$resposta = $db->Execute($sql);
if($resposta == false) die ("Não foi possível consultar a tabela professores");

echo "
<body>
<form action='form_select_mono.php' name='professor' method='POST'>
<select name='num_prof' size='1'>
<option value='0'>Selecione professor</option>
";

while(!$resposta->EOF) {
	$num_prof = $resposta->fields['id'];
	$nome     = $resposta->fields['nome'];
	$sexo     = $resposta->fields['sexo'];
	$resposta->MoveNext();
	
	echo "
	<option value='$num_prof'>$nome</option>
	";
	}
	
echo "
</select>

<input type='submit' name='submit' value='Enviar'>
</form>
";

?>

</body>
</html>
