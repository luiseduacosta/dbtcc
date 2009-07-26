<?php

include("../../include_db.inc");

$ordem = $_REQUEST['ordem'];

$sql = "select * from areas order by area"; 
$resultado = $db->Execute($sql);
if($resultado == false) die ("Não foi possível consultar a tabela areas");

echo "
<htnl>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<div align='center'>
<table>
<caption>Quantidade de professores por area</caption>
<tr>
<th><a href='listar_areas.php?ordem=area'>Area</a></th>
<th><a href='listar_areas.php?ordem=contador'>Quantidade</a></th>
</tr>
";

$i = 0;
while(!$resultado->EOF)	{
	$area     = $resultado->fields['area'];
	$num_area = $resultado->fields['numero'];
	$sql_prof_area = "select * from prof_area where num_area='$num_area'";
	$resultado_prof_area = $db->Execute($sql_prof_area);
	if($resultado_prof_area == false) die ("Não foi possível consultar a tabela prof_area");
	$contador = 0;
	while(!$resultado_prof_area->EOF) { 
		$num_prof = $resultado_prof_area->fields['num_prof'];	
		$contador++;
		$resultado_prof_area->MoveNext();
		}
	
	if(empty($ordem))
	    $ordem = "area";
	else
	    $ordem = $ordem; // $ordem será igual a $area ou $contador

	// O conteúdo da variavel dinâmica $$indice é $ordem
	// Para testar:
	// echo $ordem . " " . $$ordem . "<br>";
	$matriz[$i][$ordem] = $$ordem; // $ordem será igual ao conteúdo de $area ou $contador

	$matriz[$i]['num_area'] = $num_area;
	$matriz[$i]['area']     = $area;
	$matriz[$i]['contador'] = $contador;
	
	$i++;
	
	$total += $contador;

	$resultado->MoveNext();

	}

reset($matriz);
sort($matriz);

for($i=0;$i<sizeof($matriz);$i++)
{
    $num_area = $matriz[$i]['num_area'];
    $area     = $matriz[$i]['area']; 
    $contador = $matriz[$i]['contador'];   

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
    <td><a href='../../professor/visualizar/areasprofessor.php?num_area=$num_area'>$area</a></td>
    <td class=coluna_centralizada>$contador
    </tr>
    ";
}

echo "
<tr class=total>
<td>Total</td>
<td class=coluna_centralizada>$total</td>
</tr>
</table>
</div>
</body>
</html>
";

?>
