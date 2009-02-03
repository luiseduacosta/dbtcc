<?php

$departamento = $_REQUEST['departamento'];
$ordem        = $_REQUEST['ordem'];

$sql  = "select * from professores where departamento='$departamento'";
// echo $sql . "<br>";
include("../../include_db.inc");
$resultado_professores = $db->Execute($sql);
if($resultado_professores === false) die ("Não foi possível consultar a tabela professores");
$total_professores = $resultado_professores->RecordCount();
$i = 0;
while(!$resultado_professores->EOF) {
	$num_prof = $resultado_professores->fields['id'];
	$nome     = $resultado_professores->fields['nome'];
	$resultado_professores->MoveNext();

	$sql_monografia = "select * from monografia where num_prof='$num_prof'";
	$resultado_monografia = $db->Execute($sql_monografia);
	if($resultado_monografia === false) die ("Não foi possível consultar a tablea monografia");
	while(!$resultado_monografia->EOF) {
		$titulo  = $resultado_monografia->fields['titulo'];
		$periodo = $resultado_monografia->fields['periodo'];
		$resultado_monografia->MoveNext();

		if(empty($ordem))
		    $ordem = 'titulo';
		else 
		    $indice = $ordem;
		    
		$matriz[$i][$ordem] = $$indice;
		
		$matriz[$i]['titulo']  = $titulo;
		$matriz[$i]['nome']    = $nome;
		$matriz[$i]['periodo'] = $periodo;

		$i++;

	}
}

reset($matriz);
sort($matriz);

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
<title>Monografias orientadas pelos professores dos departamentos</title>
</head>

<body>

<table>
<caption>
Monografias orientadas pelos professores do departamento de $departamento
</caption>
<thead>

<tr>
<th>Id</th>
<th><a href='$_SERVICE[PHP_SELF]?ordem=titulo&departamento=$departamento'>Titulo</a></th>
<th><a href='$_SERVICE[PHP_SELF]?ordem=nome&departamento=$departamento'>Professor</a></th>
<th><a href='$_SERVICE[PHP_SELF]?ordem=periodo&departamento=$departamento'>Periodo</a></th>
</tr>

</thead>

<tbody>
";

for($i=0;$i<sizeof($matriz);$i++) {
	$titulo  = $matriz[$i]['titulo'];
	$nome    = $matriz[$i]['nome'];
	$periodo = $matriz[$i]['periodo'];

    // Para alternar as cores das linhas
    if($color === '1') {
		echo "<tr class='resaltado' id='resaltado'>";
		$color = '0';
    } else {
		echo "<tr class='natural' id='natural'>";
		$color = '1';
    }
	
	echo "
	<td>$i</td>
	<td>$titulo</td>
	<td>$nome</td>
	<td>$periodo</td>
	</tr>
	";
}

echo "
<tr class=total>
<td colspan='4'>
<p class='coluna_centralizada'>
Total de professores: $total_professores</td>
</tr>
</tbody>

</table>
</body>
</html>
";

?>