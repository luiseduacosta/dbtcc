<html>
<head>
<link href="../../tcc.css" rel="stylesheet" type="text/css">
</head>
<body>

<?php

$fazer = $_REQUEST['fazer'];

if($fazer == "monografia")
	$acao = "professor_monografia.php";
elseif($fazer == "professor")
	$acao = "ver_professor.php";

$sql = "select * from professores order by nome";
include("../../include_db.inc");
$resultado = $db->Execute($sql);
if($resultado == false) die ("Não foi possível consultar a tabela professores");

echo "
<body>
<form action=$acao name='seleciona_professor' method='POST'>
<select name=id_prof size='1'>
<option value='0'>Seleciona professor</option>
";

while(!$resultado->EOF) {
	$num_prof = $resultado->fields['id'];
	$nome     = $resultado->fields['nome'];
	echo "
	<option value='$num_prof'>$nome</option>
	";
	$resultado->MoveNext();
	}
	
echo "
</select>
<input type='hidden' name='index' value=0>
<input type='submit' name='submit' value='Enviar'>
</form>
";

$db->Close();

?>

</body>
</html>
