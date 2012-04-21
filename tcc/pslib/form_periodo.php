<?php

echo "<link href='../css/tcc.css' rel='stylesheet' type='text/css'>";
echo "<body>";

$sql = "select distinct periodo from monografia order by periodo";
include("../conexao.inc");
echo "
<form action='$acao' name='declaracoes' method='post'>
<select name='periodo' size='1'>
<option value=0>Selecione periodo</option>
";
while($rows_monografia = mysql_fetch_array($res))
	{
	$periodo = $rows_monografia['periodo'];
	echo "
	<option value=$periodo>$periodo</option>
	";
	}
echo "
</select>

<input type='submit' name='submit' value='Enviar'>
</form>
";
	
?>
