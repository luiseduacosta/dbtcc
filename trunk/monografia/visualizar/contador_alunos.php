<?php

echo "
<html>
<title>Contador de alunos</title>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";

/*
Crio um array *numero* com a quantidade de alunos por monografia
*/
$sql = "select codigo from monografia";
include("../../include_db.inc");
$resultados = $db->Execute($sql);
if($resultados === false) die ("Nao foi possivel consultar a tabela monografia");

$j = 0;
while(!$resultados->EOF) {
	$codigo = $resultados->fields['codigo'];
	$sql_alunos = "select * from tcc_alunos where num_monografia='$codigo'";
	$resultados_alunos = $db->Execute($sql_alunos);
	if($resultados_alunos === false) die ("Não foi possivel consultar a tabela alunos");
	$quantidade = $resultados_alunos->RecordCount();
	$numero[$j] = $quantidade;
	$tabelaCodigoQuantdade[$j]['codigo'] = $codigo;
	$tabelaCodigoQuantdade[$j]['quantidade'] = $quantidade;
	$j++;
	$resultados->MoveNext();
}

/*
Crio um array *$valor* para contar a quantidade de alunos
*/
sort($numero);
$j = 1;
$k = 0;
for($i=0;$i<sizeof($numero);$i++) {
	if($numero[$i] !=  $numero[$j]) {
		$valor[$k] = $numero[$i];
		$k++;
		}
	$j++;
	}

echo "
<div align='center'>
<table>
<caption>Quantidade de alunos por monografia</caption>
<tr>
<th>Modalidade</th>
<th>Monografias</th>
<th>Total alunos</th>
<tr>
";
$var = count($valor);
$a = count($numero);
for($i=0;$i<count($valor);$i++) {
	$contador = 0;
	for($j=0;$j<count($numero);$j++) {
		if($valor[$i] == $numero[$j])
			$contador++;
		}
		$subtotal = $contador * $valor[$i];
		$total_alunos += $subtotal;

		$total_monografia += $contador;

	    // Para alternar as cores das linhas
		if($color === '1') {
			echo "<tr class='resaltado' id='resaltado'>";
			$color = '0';
		} else {
			echo "<tr class='natural' id='natural'>";
			$color = '1';
		}
		
		echo "
		<td align='center'><p class='coluna_centralizada'>$valor[$i]
		<td align='center'><p class='coluna_centralizada'>$contador
		<td align='center'><p class='coluna_centralizada'>$subtotal
		</tr>
		";
	}

echo "

<tr class=total>
<td align='center'><p class='coluna_centralizada'>Total</td>
<td align='center'><p class='coluna_centralizada'>$total_monografia</td>
<td align='center'><p class='coluna_centralizada'>$total_alunos</td>
</tr>

</table>
</div>
</body>
</html>
";

$db->Close();

?>