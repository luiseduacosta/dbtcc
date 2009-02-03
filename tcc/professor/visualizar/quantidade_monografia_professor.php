<?php

$ordem = $_REQUEST['ordem'];

$sql = "select * from professores order by nome";
include("../../include_db.inc");
$resultado = $db->Execute($sql);
if($resultado == false) die ("Não foi possível consultar a tabela professores");

$j = 0;
while(!$resultado->EOF)	{
	$nome     = $resultado->fields['nome'];
	$num_prof = $resultado->fields['id'];
	$tipocargo = $resultado->fields['tipocargo'];
	$situacao = $resultado->fields['motivoegresso'];
	$resultado->MoveNext();
	
	$sql = "select * from monografia where num_prof='$num_prof'";
	$resultado_monografia = $db->Execute($sql);
	if($resultado_monografia == false) die ("Não foi possivel consultar a tabela monografia");
	$contador = 0;
	while(!$resultado_monografia->EOF) {
		$codigo = $resultado_monografia->fields['codigo'];
		$resultado_monografia->MoveNext();
		$contador++;
		}

	$total += $contador;
/*
	// Pego a situacao do professor
	$sql_situacao = "select * from situacoes where codigo='$situacao'";
	$resposta_situacao = $db->Execute($sql_situacao);
	if($resposta_situacao == false) die ("Não foi possível consultar a tabela situacoes");
	while(!$resposta_situacao->EOF) {
	    $descreve_situacao = $resposta_situacao->fields['situacao'];
	    $resposta_situacao->MoveNext();
	}
*/	
	// Transformo o contador em quantidade
	$quantidade = $contador;
	if(empty($ordem))
	    $ordem = "nome";
	else
	    $ordem = $ordem;

	$resumo[$j][$ordem] = $$ordem;
	
	$resumo[$j]['num_prof']   = $num_prof;
	$resumo[$j]['nome']       = $nome;
	$resumo[$j]['tipocargo']  = $tipocargo;
	$resumo[$j]['situacao']   = $situacao;
	$resumo[$j]['quantidade'] = $quantidade;

	$j++;

	}

reset($resumo);
sort($resumo);

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<div align='center'>
<table>
<thead>
<caption>Quantidade de monografias orientadas pelos professores da ESS</caption>
<tr>
<th>ID</th>
<th><a href='?ordem=nome'>Nome</a></th>
<th><a href='?ordem=tipocargo'>Cargo</a></th>
<th><a href='?ordem=situacao'>Motivo do egresso</a></th>
<th><a href='?ordem=quantidade'>Quantidade de monografias orientadas</a></th>
</tr>
<thead>

<tfoot></tfoot>

<tbody>
";

$j = 1;
for($i=0;$i<sizeof($resumo);$i++) {
	$num_prof   = $resumo[$i]['num_prof'];
	$nome       = $resumo[$i]['nome'];
	$tipocargo  = $resumo[$i]['tipocargo'];
	$situacao   = $resumo[$i]['situacao'];
	$quantidade = $resumo[$i]['quantidade'];
	
	// Para alternar as cores das linhas
	if($color === '1') {
	    echo "<tr class='resaltado' id='resaltado'>";
	    $color = '0';
	} else {
	    echo "<tr class='natural' id='natural'>";
	    $color = '1';
	}
	
	echo "
	<td class='coluna_centralizada'>$j</td>
	<td>$nome</td>
	<td>$tipocargo</td>
	<td>$situacao</td>
	";
	if($quantidade == 0) {
	    echo "<td class='coluna_centralizada'>$quantidade</td>";
	} else {
	    echo "<td class='coluna_centralizada'><a href='professor_monografia.php?id_prof=$num_prof'>$quantidade</a></td>";
        }
	echo "
	<tr>
	";
	$j++;
}

echo "
<tr class='total'>
<td>Total</td>
<td colspan='2'></td>
<td><p class='coluna_centralizada'>$total</td>
</tr>
</tbody>
</table>
</div>
</body>
</html>
";

?>