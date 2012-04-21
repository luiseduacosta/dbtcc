<html>
<head>
<title>Monografias por período</title>
<script language="JavaScript" type="text/javascript">

function janela(numero)	{
	var controle=window.open("../../professor/visualizar/ver_professor.php?id_prof="+numero,"janela1","width=500,height=250,screenX=150,screenY=200,scrollbars=yes,resizable=yes,dependent=yes");
	}
</script>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<?php

$servidor = $_SERVER[SERVER_NAME];
echo $servidor . "<br>";
$periodo  = $_REQUEST['periodo'];
$ordem    = $_REQUEST['ordem'];

function titulo($periodo,$ordem) {	
	include("../../include_db.inc");
	
	$sql  = "select monografia.codigo, monografia.catalogo, monografia.titulo, monografia.url, monografia.num_prof, professores.nome from monografia ";
	$sql .= "left outer join professores ";
	$sql .= "on monografia.num_prof = professores.id ";
	$sql .= "where periodo = '$periodo' order by titulo";
	
	$resultado = $db->Execute($sql);
	if ($resultado === false) die ("Nao foi possivel consultar a tabela monografia");
	$quantidade = $resultado->RecordCount();
	for ($i=0;$i<$quantidade;$i++) {
		$catalogo  = $resultado->fields['catalogo'];
		$codigo    = $resultado->fields['codigo'];
		$titulo    = $resultado->fields['titulo'];
		$url       = $resultado->fields['url'];
		$professor = $resultado->fields['nome'];
		$num_prof  = $resultado->fields['num_prof'];
		$resultado->MoveNext();	

		// Para ordenar a tabela
		if(empty($ordem)) {
	    	    $ordem = "titulo";
		} else {
	    	    $indice = $ordem;
		}
		$matriz[$i][$ordem] = $$indice;    
		// Fim da primeira coluna

		include("alunos.inc");

		$matriz[$i]['aluno'] 	     = $aluno;	
		$matriz[$i]['num_professor'] = $num_prof;
		$matriz[$i]['professor']     = $professor;
		$matriz[$i]['codigo']        = $codigo;
		$matriz[$i]['titulo']        = $titulo;
		$matriz[$i]['url']           = $url;
		$matriz[$i]['catalogo']      = $catalogo;
		
	} // Fin do loop monografia
	
	$db->close();

	return($matriz);
}

echo "
<div align='center'>
<table>
<caption>Tabela de monografias do período $periodo</caption>
<tr>
 <th>ID</td>
 <th><a href='?ordem=catalogo&periodo=$periodo'>Cat&aacute;logo</th>
 <th><a href='?ordem=titulo&periodo=$periodo'>Título</a></th>
 <th><a href='?ordem=url&periodo=$periodo'>PDF</a></th>
 <th><a href='?ordem=aluno&periodo=$periodo'>Aluno(s)</a></th>
 <th width='25%'><a href='?ordem=professor&periodo=$periodo'>Professor</a></th>
</tr>
";

// $periodo = $_REQUEST['periodo'];

$matriz = titulo($periodo,$ordem);
reset($matriz);
sort($matriz);

$j = 1;
for ($i=0;$i<sizeof($matriz);$i++) {
	$tab_codigo        = $matriz[$i]['codigo'];
	$tab_catalogo      = $matriz[$i]['catalogo'];
	$tab_titulo        = $matriz[$i]['titulo'];
	$tab_url           = $matriz[$i]['url'];
	$tab_aluno         = $matriz[$i]['aluno'];
	$tab_professor     = $matriz[$i]['professor'];
	$tab_num_professor = $matriz[$i]['num_professor'];

    // Para alternar as cores das linhas
    if ($color === '1') {
		echo "<tr class='resaltado' id='resaltado'>";
		$color = '0';
    } else {
		echo "<tr class='natural' id='natural'>";
		$color = '1';
    }
	
	echo "
	<td style='text-align:right'>$j</td>
	<td style='text-align:right'>$tab_catalogo</td>
	<td><a href='ver_monografia.php?codigo=$tab_codigo'>$tab_titulo</a></td>
	";
	if(empty($tab_url)) {
		echo "<td></td>";
	} else {
		echo "
		<td><a href='http://$servidor/monografias/$tab_url'>PDF</a></td>
		";
	}
	echo "
	<td>$tab_aluno</td>
	<td><a href='../../professor/visualizar/ver_professor.php?id_prof=$tab_num_professor'>$tab_professor</a></td>
	";
	$j++;
}

echo "
</table>
</div>
";

?>

</body>
</html>