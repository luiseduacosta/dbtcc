<?php

$ordem = $_REQUEST['ordem'];

$sql = "select num_area, count(*) as quantidade from monografia group by num_area order by num_area";
include_once("../include_db.inc");
$resultado = $db->Execute($sql);
if ($resultado == false) die ("Nao foi possível consultar a tabela monografia");

// Inicio o contador em 0
$i = 0;
while (!$resultado->EOF)
{
	$num_area   = $resultado->fields['num_area'];
	$quantidade = $resultado->fields['quantidade'];
	$sql_areas = "select * from areas where numero='$num_area'";
	$resultado_areas = $db->Execute($sql_areas);
	if ($resultado_areas == false) die ("Não foi possivel consultar a tabela areas");
	while (!$resultado_areas->EOF)
	{
		$area = $resultado_areas->fields['area'];

		if (empty($ordem))
		    $ordem='area';
		else
		    $indice=$ordem;
		
		$matriz[$i][$ordem] = $$indice;

		$matriz[$i]['num_area']   = $num_area;
		$matriz[$i]['area']       = $area;
		$matriz[$i]['quantidade'] = $quantidade;
		
		$resultado_areas->MoveNext();
			
		$i++;

		$total += $quantidade;
	}
	$resultado->MoveNext();
}

echo "
<html>
<head>
<link href='../css/tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<div>
<table>
<theader>
<caption>Quantidade de monografias por área</caption>
<tr>
<th><a href='resumo_classifica.php?ordem=area'>Area</a></th>
<th><a href='resumo_classifica.php?ordem=quantidade'>Quantidade de monografias</a></th>
</tr>
</theader>
<tfooter></tfooter>

<tbody>
";

reset($matriz);
sort($matriz);

for ($i=0;$i<sizeof($matriz);$i++)
{
    $num_area   = $matriz[$i]['num_area'];
    $area       = $matriz[$i]['area'];
    $quantidade = $matriz[$i]['quantidade'];

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
    <td><a href='../monografia/visualizar/areasprofessor.php?num_area=$num_area&origem=resumo_classifica'>$area</a></td>
    <td><p class='coluna_centralizada'>$quantidade</td>
    </tr>
    ";
}

echo "
<tr class=total>
<td>Total</td>
<td><p class='coluna_centralizada'>$total</td>
</tr>

</tbody>
</table>
</div>
</body>
</html>
";
?>
