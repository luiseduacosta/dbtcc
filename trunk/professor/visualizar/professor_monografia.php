<?php

$num_prof = $_REQUEST['id_prof'];
$ordem = $_REQUEST['ordem'];

include("../../include_db.inc");

if (empty($ordem)) $ordem = 'titulo';

$sql = "select nome from professores where id='$num_prof'";
$resultado = $db->Execute($sql);
if ($resultado == false) die ("Nao foi possivel consultar a tabela professores");
$nome = $resultado->fields['nome'];

echo "
<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<div>

<table>

<thead>
<caption>Monografias orientadas pelo(a) professor(a): $nome 
</caption>

<tr>
<th>ID</th>
<th><a href='?ordem=catalogo&id_prof=$num_prof'>Cat&aacute;logo</a></th>
<th><a href='?ordem=titulo&id_prof=$num_prof'>T&iacute;tulo</a></th>
<th><a href='?ordem=periodo&id_prof=$num_prof'>Per&iacute;odo</a></th>
</tr>

</thead>

<tfoot>
</tfoot>

<tbody>

";

$sql = "select monografia.codigo, monografia.catalogo, monografia.titulo, monografia.periodo 
from professores 
left outer join monografia on professores.id = monografia.num_prof 
where professores.id='$num_prof' 
order by $ordem";
// echo $sql . "<br>";

$resposta = $db->Execute($sql);
if ($resposta == false) die ("Nao foi possivel consultar a tabela professores");
$j = 1; // Contador
//$i = 0;
while (!$resposta->EOF) {
	$codigo   = $resposta->fields['codigo'];
	$catalogo = $resposta->fields['catalogo'];
	$titulo   = $resposta->fields['titulo'];
	$periodo  = $resposta->fields['periodo'];
	// echo $nome . " " . $codigo ." "  . $titulo . " ". $periodo . "<br>";

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
	<td class='coluna_centralizada'>$catalogo</td>
	<td><a href='../../monografia/visualizar/ver_monografia.php?codigo=$codigo'>$titulo</a></td>
	<td>$periodo</td>
	</tr>
	";
	$j++;

	$resposta->MoveNext();
}

echo "

</tbody>
</table>

</div>
</body>
";

?>