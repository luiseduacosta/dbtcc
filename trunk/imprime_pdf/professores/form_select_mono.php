<html>
<head>
</head>
<link href="../../css/tcc.css" rel="stylesheet" type="text/css">
<body>

<?php

$num_prof = $_REQUEST['num_prof'];

require("../../data.php");
$data_arquivo = $dia_arquivo . "/" . $mes_arquivo . "/" . $ano_arquivo;

include("../../include_db.inc");

$sql_professores = "select * from professores where id=$num_prof";
$resposta_professores = $db->Execute($sql_professores);
if($resposta_professores == false) die ("Não foi possível consultar a tabela professores");
while(!$resposta_professores->EOF) {
	$sexo = $resposta_professores->fields['sexo'];
	$resposta_professores->MoveNext();
}

$sql_monografia = "select * from monografia where num_prof=$num_prof"; 
$resposta_monografia = $db->Execute($sql_monografia);
if($resposta_monografia == false) die ("Não foi possível consultar a tabela monografia");

$j = 0;
while(!$resposta_monografia->EOF) {
	$codigo = $resposta_monografia->fields['codigo'];
	$titulo = $resposta_monografia->fields['titulo'];
	$resposta_monografia->MoveNext();
	
	$matriz[$j]['codigo'] = $codigo;
	$matriz[$j]['titulo'] = $titulo;

	$j++;

	}

echo "
<form action='declaracao.php' name='monografia' method='POST'>
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
	 <td><input type='radio' name='codigo' value=$codigo></td>
	</tr>
	";
}
echo "
<input type='hidden' name='data_arquivo' value=$data_arquivo>
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
