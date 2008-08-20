<html>
<head>
</head>
<link href="../tcc.css" rel="stylesheet" type="text/css">
<body>

<?php

$sql = "select * from monografia where num_prof=$num_prof"; 
include("../conexao.inc");

$sql_professores = "select * from professores where numero=$num_prof";
$res_professores = mysql_query($sql_professores,$con);
while($rows_professores = mysql_fetch_array($res_professores))
	$sexo = $rows_professores['sexo'];

$j = 0;
while($rows_monografia = mysql_fetch_array($res))
	{
	$codigo = $rows_monografia['codigo'];
	$titulo = $rows_monografia['titulo'];

	$matriz[$j]['codigo'] = $codigo;
	$matriz[$j]['titulo'] = $titulo;

	$j++;

	}

echo "
<form action='tcc.php' name='monografia' method='POST'>
<div align='center'>
<table border='1'>
<tr><th>Selecione a monografia</th></tr>
";
for($i=0;$i<sizeof($matriz);$i++)
{
	$titulo = $matriz[$i]['titulo'];
	$codigo = $matriz[$i]['codigo'];
	echo "
	<tr>
	 <td>$titulo</td>
	 <td><input type='radio' value=$codigo name='codigo'></td>
	</tr>
	";
}
echo "
<input type='hidden' name='num_prof' value=$num_prof>
<input type='hidden' name='sexo' value=$sexo>

</table>
</div>

<div align='center'>
<table>
<tr>
 <td><input type='submit' name='enviar' value='Confirmar'></td>
</tr>
</table>
</div>

</form>
";
?>

</body>
</html>
