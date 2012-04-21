<html>
<head>
<link href="../../css/tcc.css" rel="stylesheet" type="text/css">

<script language="JavaScript" type="text/javascript">
function janela(numero)
	{
	var controle=window.open("../../professor/visualizar/ver_professor.php?num_prof="+numero,"janela1","width=500,height=250,screenX=150,screenY=200,scrollbars=yes,resizable=yes,dependent=yes");
	}
</script>

</head>

<body>

<?php

$ordem = $_REQUEST['ordem'];

$sql = "select * from professores order by nome";
include("../../include_db.inc");
$resposta = $db->Execute($sql);
if ($resposta == false) die ("Não foi possível consultar a tabela professores");

$j = 0;
while (!$resposta->EOF) {
	$numero       = $resposta->fields['id'];
	$nome         = $resposta->fields['nome'];
	$condicao     = $resposta->fields['condicao'];
	// $situacao     = $resposta->fields['situacao'];
	$email        = $resposta->fields['email'];
	$departamento = $resposta->fields['departamento'];

	$resposta->MoveNext();
/*
	// Busco a situacao do professor
	$sql_situacao = "select * from situacoes where codigo='$situacao'";
	$resposta_situacao = $db->Execute($sql_situacao);
	if($resposta_situacao == false) die ("Não foi possivel consultar a tabela situacoes");
	while(!$resposta_situacao->EOF) {
	    $descreve_situacao = $resposta_situacao->fields['situacao'];
	    $resposta_situacao->MoveNext();
	}
*/
	// Busco as areas de orientação dos professores
	$sql_prof_area = "select * from prof_area where num_prof='$numero'";
	$resposta_prof_area = $db->Execute($sql_prof_area);
	if ($resposta_prof_area == false) die ("Não foi possível consultar a tabela prof_area");
        $i = 0;
	while (!$resposta_prof_area->EOF) {
	    $num_area = $resposta_prof_area->fields['num_area'];
	    $resposta_prof_area->MoveNext();

    	$sql_area = "select * from areas where numero='$num_area'";
	    $resposta_area = $db->Execute($sql_area);
	    if ($resposta_area == false) die ("Não foi possivel consultar a tabela area");

	    while (!$resposta_area->EOF) {
		$principal_area = $resposta_area->fields['area'];
		$area[$i] = $resposta_area->fields['area'];
		$resposta_area->MoveNext();
		$i++;
	    }

	}

	if (empty($ordem))
	    $ordem = 'nome';
	else
	    $ordem = $ordem;

	$matriz[$j][$ordem] = $$ordem;

	$matriz[$j]['nome']     = $nome;
	$matriz[$j]['numero']   = $numero;
	$matriz[$j]['condicao'] = $condicao;
	$matriz[$j]['situacao'] = $descreve_situacao;
	$matriz[$j]['email']    = $email;
	$matriz[$j]['departamento'] = $departamento;
	$matriz[$j]['area']     = $area[0];
	$j++;

}

$db->Close();

echo "
<div>
<table>
<thead>
<caption>
Área principal de orientação dos professores da ESS (ordenados por $ordem)
</caption>

<tr>
<th width='35%'><a href=$_SERVER[PHP_SELF]?ordem=nome>Nome</a></th>
<th width='10%'><a href=$_SERVER[PHP_SELF]?ordem=departamento>Departamento</a></th>
<th width='10%'><a href=$_SERVER[PHP_SELF]?ordem=situacao>Situacao</a></th>
<th width='15%'><a href=$_SERVER[PHP_SELF]?ordem=area>Área principal</a></th>
<th width='20%'><a href=$_SERVER[PHP_SELF]?ordem=email>E-mail</a></th>
</tr>
</thead>

<tfoot></tfoot>

<tbody>
";
reset($matriz);
sort($matriz);

for ($i=0;$i<sizeof($matriz);$i++)
{
	$numero       = $matriz[$i]['numero'];
	$nome         = $matriz[$i]['nome'];
	$departamento = $matriz[$i]['departamento'];
	$condicao     = $matriz[$i]['condicao'];
	$situacao     = $matriz[$i]['situacao'];
	$area         = $matriz[$i]['area'];
	$email        = $matriz[$i]['email'];

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
    <td width='35%'><a href='javascript:janela($numero)'>$nome</a></td>
    <td width='10%'>$departamento</td>
    <td width='10%'>$situacao</td>
    <td width='15%'>$area</td>
    <td width='10%'><a href=mailto:'$email'>$email</a></td>
    </tr>
    ";
}

?>

</tbody>
</table>
</div>

</body>
</html>
