<?php

include("../../include_db.inc");

$ordem = $_REQUEST['ordem'];

$sql = "select id, areamonografia from areasmonografia order by areamonografia"; 
// echo $sql . "<br>";
$resultado = $db->Execute($sql);
if($resultado === false) die ("Não foi possível consultar a tabela areasMongrafia");

echo "
<htnl>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<div align='center'>
<table>
<tbody>
<caption>Quantidade de monografias por área da monografia</caption>
<tr>
<th><a href='listar_areas.php?ordem=areamonografia'>Área</a></th>
<th><a href='listar_areas.php?ordem=contador'>Quantidade</a></th>
</tr>
";

$i = 0;
while(!$resultado->EOF)
	{
	$areamonografia = $resultado->fields['areamonografia'];
	$id_area = $resultado->fields['id'];

	/* Capturo as monografias */
	$sql_monografia = "select codigo, titulo from monografia where areamonografia='$id_area'";
	// echo $sql_monografia . "<br>";
	$resultado_monografia = $db->Execute($sql_monografia);
	if($resultado_monografia === false) die ("Não foi possível consultar a tabela monografia");
	$contador = 0;
	while(!$resultado_monografia->EOF)
		{
		$codigo = $resultado_monografia->fields['codigo'];	
		$titulo = $resultado_monografia->fields['titulo'];	
		$resultado_monografia->MoveNext();
		$contador++;
		}
	/* Fim da captura das monografia */
	/*amo liberdade por isso tudo que amo as deixo livre se valta e porque as conquistei se nao valtarem porque nunca as tive.*/

	if(empty($ordem))
	    $ordem = "areamonografia";
	else
	    $ordem = $ordem; // $ordem será igual a $area ou $contador

	// O conteúdo da variavel dinâmica $$indice é $ordem
	// Para testar:
	// echo $ordem . " " . $$ordem . "<br>";
	$matriz[$i][$ordem] = $$ordem; // $ordem será igual ao conteúdo de $area ou $contador

	$matriz[$i]['id_area'] = $id_area;
	$matriz[$i]['areamonografia'] = $areamonografia;
	$matriz[$i]['contador'] = $contador;
	$i++;
	
	$total += $contador;

	$resultado->MoveNext();

	}

if (sizeof($matriz) > 0) {
	reset($matriz);
	sort($matriz);
}

for($i=0;$i<sizeof($matriz);$i++)
{
    $id_area = $matriz[$i]['id_area'];
    $areamonografia = $matriz[$i]['areamonografia']; 
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
    <td><a href='areaMonografia.php?id_area=$id_area&area=$areamonografia'>$areamonografia</a></td>
    <td class=coluna_centralizada>$contador
    </tr>
    ";
}

echo "
<tr class=total>
<td>Total</td>
<td class=coluna_centralizada>$total</td>
</tr>
<tbody>
</table>
</div>
</body>
</html>
";

?>
