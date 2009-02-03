<?php

include("../../include_db.inc");

$ordem  = $_REQUEST['ordem'];
$inicio = $_REQUEST['inicio'];

$sql_monografia = "select * from monografia";
$resultado_monografia = $db->Execute($sql_monografia);
if($resultado_monografia === false) die ("Não foi possível consultar a tabela monografia");
$i = 0;
while(!$resultado_monografia->EOF) {

	$titulo    = $resultado_monografia->fields['titulo'];
	$periodo   = $resultado_monografia->fields['periodo'];
	$codigo    = $resultado_monografia->fields['codigo'];
	$professor = $resultado_monografia->fields['num_prof'];
	$resultado_monografia->MoveNext();

	// Com o numero de codigo obtenho os nomes dos alunos
	include("alunos.inc");

	// Agora é a vez dos professores
	$sql_professores = "select * from professores where id = '$professor'";
	$resultado_professores = $db->Execute($sql_professores);
	if($resultado_professores === false) die ("Não foi possível consultar a tabela professores");
	while(!$resultado_professores->EOF) {
	    $nome_professor = $resultado_professores->fields['nome'];
	    $resultado_professores->MoveNext();
	}
	
	if(empty($ordem))
	    $ordem = "titulo";
	else
	    $indice = $ordem;

	$matriz[$i][$ordem] = $$indice;

	$matriz[$i]['titulo']         = $titulo;
	$matriz[$i]['aluno']          = $aluno;
	$matriz[$i]['periodo']        = $periodo;
	$matriz[$i]['nome_professor'] = $nome_professor;

	$i++;
}

reset($matriz);
sort($matriz);

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
";

/*
echo "
<div align='center'>
<table>
<caption>Tabela de monografias por $ordem</caption>
<tr>
";
$tamanho_pagina = 8;

if (empty($inicio))
    $inicio = 0;


// Barra de navegacao
// $pagina = 0;
$numero = 0;
for($j=0;$j<sizeof($matriz);$j++)
{
    echo "
    <td><a href='$PHP_SELF?inicio=$j&ordem=$ordem'>$numero</a></td>
    ";
    $j = $j + $tamanho_pagina;
    // $pagina++;
    $numero++;
}

$inicio_pagina = $inicio + $tamanho_pagina;
// Termina barra de navegacao

echo "
</tr>
</table>
</div>
";
*/

echo "
<div align='center'>
<table>
<caption>Tabela de monografias por $ordem</caption>
<tr>
<th><a href='$_SERVER[PHP_SELF]?ordem=aluno'>Aluno(s)</a></th>
<th><a href='$_SERVER[PHP_SELF]?ordem=titulo'>Título</a></th>
<th><a href='$_SERVER[PHP_SELF]?ordem=nome_professor'>Professor</a></th>
<th><a href='$_SERVER[PHP_SELF]?ordem=periodo'>Período</a></th>
</tr>
";

// $i=$inicio;
// for($i=$inicio;$i<$inicio_pagina;$i++)
for($i=0;$i<sizeof($matriz);$i++)
{
    $aluno     = $matriz[$i]['aluno'];
    $titulo    = $matriz[$i]['titulo'];
    $professor = $matriz[$i]['nome_professor'];
    $periodo   = $matriz[$i]['periodo'];

    // Para alternar as cores das linhas
    if($color === '1') {
		echo "<tr class='resaltado' id='resaltado'>";
		$color = '0';
    } else {
		echo "<tr class='natural' id='natural'>";
		$color = '1';
    }
    
    echo "
    <td>$aluno</td>
    <td>$titulo</td>
    <td>$professor</td>
    <td>$periodo</td>

    </tr>
    ";
}

echo "
</table>
</div>
</body>
</html>
";

$db->Close();

?>