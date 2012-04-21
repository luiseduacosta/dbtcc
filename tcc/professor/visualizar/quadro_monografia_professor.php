<?php

// Seleciono o numero do professor
$sql = "select * from professores order by nome";
include("../../include_db.inc");
$resposta = $db->Execute($sql);
if ($resposta == false) die ("Nao foi possivel consultar a tabela professores");

$j = 0;
while (!$resposta->EOF) {
	$nome     = $resposta->fields['nome'];
	$num_prof = $resposta->fields['id'];
	$resposta->MoveNext();
	
	// Seleciono as monografias orientadas por cada professor
	$sql = "select * from monografia where num_prof='$num_prof'";
	$resposta_monografia = $db->Execute($sql);
	if ($resposta_monografia == false) die ("Nao foi possivel consultar a tabela monografia");
	$contador = 0;
	while (!$resposta_monografia->EOF) {
		$codigo = $resposta_monografia->fields['codigo'];
		$resposta_monografia->MoveNext();
		$contador++;
		}
	$total += $contador;

	$resumo[$j] = $contador;
	$j++;

	}
	
reset($resumo);
sort($resumo);

$j = 1;
$variavel = 0;
$indicador = 1;
for ($i=0;$i<sizeof($resumo);$i++)
	{
	if($resumo[$i] != $resumo[$j])
		{
		$valores[$variavel] = $resumo[$i];
		$variavel++;
		}
	$j++;
	
	}


echo "
<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<div>
<table>
<thead>
<caption>
Quantidade de professores por quantidade de monografias orientadas
</caption>
<tr>
<th>Quantidade de professores</th>
<th>Quantidade de monografias orientadas</th>
</tr>
</thead>

<tfoot></tfoot>

<tbody>
";

for ($i=0;$i<sizeof($valores);$i++)
	{
	$contador = 0;
	for($j=0;$j<sizeof($resumo);$j++)
		{
			if($valores[$i] == $resumo[$j])
				$contador++;
	 	}
		
		// Para alternar as cores das linhas
		if($color === '1')
		{
			echo "<tr class='resaltado' id='resaltado'>";
			$color = '0';
		}
		else
		{
			echo "<tr class='natural' id='natural'>";
			$color = '1';
		}
		
		echo "
		<td><p class='coluna_centralizada'>$contador</td>
		<td><p class='coluna_centralizada'>$valores[$i]</td>
		</tr>
		";
	}

echo "
<tbody>
</table>
</div>
</body>
</html>

";

?>