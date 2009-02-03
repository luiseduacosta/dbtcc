<html>
<head>
</head>
<link href="../tcc.css" rel="stylesheet" type="text/css">
<body>

<?php
$sql = "select * from professores order by nome";
include("../conexao.inc");

echo "
<body bgcolor='#B0FFFB'>
<form action='formulario1.php' name='professor' method='POST'>
<select name='num_prof' size='1'>
<option value='0'>Selecione professor</option>
";

while($rows=mysql_fetch_array($res))
	{
	$num_prof = $rows['numero'];
	$nome = $rows['nome'];
	$sexo = $rows['sexo'];
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
