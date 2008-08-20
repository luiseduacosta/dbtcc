<html>
<head>
<link href="../tcc.css" rel="stylesheet" type="text/css">
<title><?php echo $_SERVER[PHP_SELF]; ?></title>

<script language="JavaScript">
function janela(numero)
	{
	var controle=window.open("../professor/visualizar/ver_professor.php?id_prof="+numero,"janela1","width=500,height=250,screenX=150,screenY=200,scrollbars=yes,resizable=yes,dependent=yes");
	}
</script>

</head>
<body>

<?php

$ordem = $_REQUEST['ordem'];

$i = 0;
$sql = "select titulo, num_prof, num_area from monografia order by titulo";
include("../include_db.inc");
$resultado = $db->Execute($sql);
if($resultado == false) die ("Não foi possivel consultar a tabela monografia");

while(!$resultado->EOF)
{
	$titulo   = $resultado->fields['titulo'];
	$num_prof = $resultado->fields['num_prof'];
	$num_area = $resultado->fields['num_area'];
	
	$sql_professores = "select nome from professores where id='$num_prof'";
	$resultado_professores = $db->Execute($sql_professores);
	if($resultado_professores == false) die ("Não foi possivel consultar a tabela areas");
	while(!$resultado_professores->EOF) {
		$professor = $resultado_professores->fields['nome'];
		$resultado_professores->MoveNext();
	}
		
	$sql_areas = "select area from areas where numero='$num_area'";
	$resultado_areas = $db->Execute($sql_areas);
	if($resultado_areas == false) die ("Não foi possivel consultar a tabela areas");
	while(!$resultado_areas->EOF)
	{
		$area = $resultado_areas->fields['area'];
		$resultado_areas->MoveNext();
	}
	    
	if(empty($ordem))
	    $ordem = 'titulo';
	else
	    $indice = $ordem;
		    
	$matriz[$i][$ordem] = $$indice;
		
	$matriz[$i]['titulo'] = $titulo;
	$matriz[$i]['num_professor'] = $num_prof;
	$matriz[$i]['professor'] = $professor;
	$matriz[$i]['area'] = $area;
	$i++;
	
	$resultado->MoveNext();
	
}

reset($matriz);
sort($matriz);

echo "
<table>
<caption>Monografias classificadas por área</caption>
<tr>
 <th width='55%'><a href='$_SERVER[PHP_SELF]?ordem=titulo'>Titulo</a></th>
 <th width='35%'><a href='$_SERVER[PHP_SELF]?ordem=professor'>Professor</a></th>
 <th width='10%'><a href='$_SERVER[PHP_SELF]?ordem=area'>Área</a></th>
</tr>
";

for($i=0;$i<sizeof($matriz);$i++)
{
    $titulo        = $matriz[$i]['titulo'];
    $num_professor = $matriz[$i]['num_professor'];
    $professor     = $matriz[$i]['professor'];
    $area          = $matriz[$i]['area'];		

    // Para alternar as cores das linhas
    if($color === '1') {
		echo "<tr class='resaltado' id='resaltado'>";
		$color = '0';
    } else {
		echo "<tr class='natural' id='natural'>";
		$color = '1';
    }
	
    echo "
    <td>$titulo</td>
    <td><a href='javascript:janela($num_professor)'>$professor</a></td>
    <td>$area</td>
    </tr>
    ";
}

echo "
</table>
";

?>

</body>
</html>
