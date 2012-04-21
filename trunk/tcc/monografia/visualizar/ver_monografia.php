<?php

include("../../setup.php");
include("../../autoriza.inc");

$codigo = isset($_REQUEST['codigo']) ? $_REQUEST['codigo'] : NULL;
$servidor = $_SERVER['SERVER_NAME'];

$sql = "select monografia.codigo, monografia.catalogo, monografia.titulo, monografia.resumo, monografia.data, monografia.periodo, "
. " monografia.num_prof, monografia.num_co_orienta, monografia.num_area, monografia.areamonografia, "
. " monografia.data_defesa, monografia.banca1, monografia.banca2, monografia.banca3, monografia.convidado, monografia.url, "
. " professores.nome, areasmonografia.id as id_areamonografia, areasmonografia.areamonografia, "
. " areas.numero as id_area, areas.area "
. " from monografia "
. " inner join professores on monografia.num_prof = professores.id "
. " left outer join areasmonografia on monografia.areamonografia = areasmonografia.id "
. " left outer join areas on monografia.num_area = areas.numero "
. " where codigo = $codigo "
. " order by titulo";
// echo $sql . "<br>";
// die();
$resposta = $db->Execute($sql);
if ($resposta === false) die ("Nao foi possivel consultar a tabela monografia");

while (!$resposta->EOF) {
	$codigo            = $resposta->fields['codigo'];
	$catalogo          = $resposta->fields['catalogo'];
	$titulo            = $resposta->fields['titulo'];
	$resumo            = $resposta->fields['resumo'];
	$data_sql          = $resposta->fields['data'];
	$periodo           = $resposta->fields['periodo'];
	$num_prof          = $resposta->fields['num_prof'];
	$nome              = $resposta->fields['nome'];
	$num_co_orienta    = $resposta->fields['num_co_orienta'];
	$num_area          = $resposta->fields['num_area'];
	$area              = $resposta->fields['area'];
	$id_areamonografia = $resposta->fields['id_areamonografia'];
	$areamonografia    = $resposta->fields['areamonografia'];
	$url               = $resposta->fields['url'];
        $data_defesa_sql   = $resposta->fields['data_defesa'];
        $banca1            = $resposta->fields['banca1'];
        $banca2            = $resposta->fields['banca2'];
        $banca3            = $resposta->fields['banca3'];
        $convidado         = $resposta->fields['convidado'];
        // echo $url . "<br>";
        
        if ($data_sql != 0) {
            $data = date('d-m-Y',strtotime($data_sql));
        } else {
            $data = "s/d";
        }

        if ($data_defesa_sql != 0) {
            $data_defesa = date('d-m-Y',strtotime($data_defesa_sql));
        } else {
            $data_defesa = "s/d";
        }
        
        $resposta->MoveNext();
	}

echo "
<html>
<head>
<title>Ver cada monografia</title>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>

<a href='javascript:history.back();'>Voltar</a>

<form name='actualizar' action='../atualizar/modifica_mono.php' method='POST'>

<div>
<table summary='Ver cada mongrafia'>

<thead>
<tr>
<th colspan='2'>Monografia</th>
</tr>
</thead>

<tr>
<td>Título:</td>
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
if ($resposta === false) die ("Não foi possivel consultar a tabela alunos");
$j = 0;
while (!$resposta->EOF) {
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
<td>Área do professor</td>
<td>$area</td>
</tr>

<tr>
<td>Área da monografia
</td>
<td></td>
</tr>

<tr>
<td>Período:</td>
<td>$periodo</td>
</tr>

<tr>
<td>Data:</td>
<td>$data</td>
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
";

echo "
<tr>
<td>Data defesa</td>    
<td>$data_defesa</td>    
</tr>
";

echo "
<tr>
<td>Banca (orientador)</td>    
<td>$banca1</td>    
</tr>
";

echo "
<tr>
<td>Banca</td>    
<td>$banca2</td>    
</tr>
";

echo "
<tr>
<td>Banca</td>    
<td>$banca3</td>    
</tr>
";

echo "
<tr>
<td>Convidado</td>    
<td>$convidado</td>    
</tr>
";

// echo "Sistema autentica " . $sistema_autentica . "<br>";
if ($sistema_autentica === 1) {
	echo "
	<tr>
	<td class='coluna_centralizada' colspan='2'>
	<input type='hidden' name='codigo' value=$codigo>
	<input type='submit' name='submit' value='Atualizar'>
	</td>
	</tr>
	";
}

echo "
</table>
</div>

</form>
";

$db->Close();

?>