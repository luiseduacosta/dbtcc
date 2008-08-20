<?php

include("../../include_db.inc");

$codigo = $_REQUEST['codigo'];
$servidor = $_SERVER['SERVER_NAME'];

$sql = "select monografia.codigo, monografia.catalogo, monografia.titulo, monografia.resumo, "
. " monografia.num_prof, monografia.num_co_orienta, monografia.data, monografia.periodo, monografia.url, "
. " professores.nome, areasmonografia.id as id_areamonografia, areasmonografia.areamonografia, "
. " areas.numero as id_area, areas.area "
. " from monografia "
. " inner join professores on monografia.num_prof = professores.id "
. " left outer join areasmonografia on monografia.areamonografia = areasmonografia.id "
. " left outer join areas on monografia.num_area = areas.numero "
. " where codigo = $codigo "
. " order by titulo";
// echo $sql. "<br>";
$resposta = $db->Execute($sql);
if($resposta === false) die ("Nao foi possivel consultar a tabela monografia");

while(!$resposta->EOF) {
	$codigo         = $resposta->fields['codigo'];
	$catalogo       = $resposta->fields['catalogo'];
	$titulo         = $resposta->fields['titulo'];
	$resumo         = $resposta->fields['resumo'];
	$data_sql       = $resposta->fields['data'];
	$periodo        = $resposta->fields['periodo'];
	// $num_prof       = $resposta->fields['num_prof'];
	$nome           = $resposta->fields['nome'];
	$num_co_orienta = $resposta->fields['num_co_orienta'];
	// $num_area       = $resposta->fields['id_area'];
	$area           = $resposta->fields['area'];
	// $id_areamonografia = $resposta->fields['id_areamonografia'];
	$areamonografia = $resposta->fields['areamonografia'];
	$url            = $resposta->fields['url'];
	// echo $url . "<br>";
	$data = date('d-m-Y',strtotime($data_sql));

	$resposta->MoveNext();
	}

echo "
<html>
<head>
<title>Ver cada monografia</title>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<form name='actualizar' action='../atualizar/modifica_mono.php' method='POST'>

<div align='center'>
<table border='1' bgcolor='#C7FFB3f' summary='Ver cada mongrafia'>

<thead>
<tr>
<th bgcolor='#E7E1AE' colspan='2'>Monografia</th>
</tr>
</thead>

<tr>
<td>Titulo:</td>
<td>$titulo</td>
</tr>

<tr>
<td>Cat&aacute;logo:</td>
<td>$catalogo</td>
</tr>

<tr>
<td>Orientador</td>
<td>$nome</td>
</tr>
";

/**********/
/* Alunos */
/**********/
$sql = "select * from tcc_alunos where num_monografia='$codigo' order by nome";
// echo $sql . "<br>";
$resposta = $db->Execute($sql);
if($resposta === false) die ("N�o foi possivel consultar a tabela alunos");
$j = 0;
while(!$resposta->EOF) {
	$aluno = $resposta->fields['nome'];
	$id_aluno = $resposta->fields['numero'];
	$registro = $resposta->fields['registro'];

	echo "
	<tr>
	<td>Aluno(s)</td>
	<td><a href='../../alunos/visualizar/aluno.php?id_aluno=$id_aluno'>$aluno</a></td>
	</tr>
	";

	$j++;
	$resposta->MoveNext();

	}

echo "
<tr>
<td>Resumo</td>
<td>$resumo</td>
</tr>

<tr>
<td>�rea do professor</td>
<td>$area</td>
</tr>

<tr>
<td align='center'>�rea da monografia
</td>
<td></td>
</tr>

<tr>
<td>Periodo:</td>
<td>$periodo</td>
</tr>

<tr>
<td>Arquivo</td>
";
if(!empty($url)) {
	echo "
	<td><a href='http://$servidor/monografias/$url'>Descarrega arquivo</a></td>
	";
} else {
	echo "
	<td>Sem arquivo</td>
	";
}
echo "
</tr>

<tr>
<td class='coluna_centralizada' colspan='2'>
<input type='hidden' name='codigo' value=$codigo>
<input type='submit' name='submit' value='Atualizar'>
</td>
</tr>

</table>
</div>

</form>
";

$db->Close();

?>