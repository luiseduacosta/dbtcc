<?php

$ordem = $_REQUEST['ordem'];

$sql = "select * from areas order by area"; 
include("../../include_db.inc");
$resultado = $db->Execute($sql);
if($resultado == false) die ("Não foi possível consultar a tabela areas");

while(!$resultado->EOF)
	{
	$area     = $resultado->fields['area'];
	$num_area = $resultado->fields['numero'];
	$sql_prof_area = "select * from prof_area where num_area='$num_area'";
	$resultado_prof_area = $db->Execute($sql_prof_area);
	if($resultado_prof_area == false) die ("Não foi possível consultar a tabela prof_area");
	
	$contador = 0;
	while(!$resultado_prof_area->EOF)
		{
		$num_prof = $resultado_prof_area->fields['num_prof'];	
		$contador++;
		$resultado_prof_area->MoveNext();
		}

	$total += $contador;

	$resultado->MoveNext();
	
	if(empty($ordem))
	    $ordem = 'area';
	else 
	    $ordem = $ordem;

	// Passo  o valor do contador para quantidade	
	$quantidade = $contador;

	$matriz[$i][$ordem] = $$ordem;

	$matriz[$i]['num_area']   = $num_area;
	$matriz[$i]['area']       = $area;
	$matriz[$i]['quantidade'] = $quantidade;
	$contador = 0;

	$i++;

	}

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<div align='center'>
<table>
<thead>
<caption>Quantidade de professores por area</caption>
<tr>
<th><a href='areas.php?ordem=area'>Area</a></th>
<th><a href='areas.php?ordem=quantidade'>Quantidade</a></th>
</tr>
</thead>

<tfoot></tfoot>

<tbody>

";

reset($matriz);
sort($matriz);
for($i=0;$i<sizeof($matriz);$i++)
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
    <td><a href='areasprofessor.php?num_area=$num_area'>$area</a></td>
    <td><p class='coluna_centralizada'>$quantidade</td>
    </tr>
    ";		
}
	
echo "

<tr class=total><td>Total</td><td><p class='coluna_centralizada'>$total</td></tr>
</tbody>
</table>
</div>

";

?>