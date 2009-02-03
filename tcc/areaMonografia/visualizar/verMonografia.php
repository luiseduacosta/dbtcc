<?php

include("../../autentica.inc");
include("../../include_db.inc");

$codigo = $_REQUEST['codigo'];

$sql = "select monografia.codigo, monografia.catalogo, monografia.titulo, monografia.resumo, "
. " monografia.num_prof, monografia.num_co_orienta, monografia.data, monografia.periodo, "
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
if($resposta === false) die ("Não foi possível consultar a tabela monografia");

while(!$resposta->EOF) {
	$codigo         = $resposta->fields['codigo'];
	$catalogo       = $resposta->fields['catalogo'];
	$titulo         = $resposta->fields['titulo'];
	$resumo         = $resposta->fields['resumo'];
	$data_sql       = $resposta->fields['data'];
	$periodo        = $resposta->fields['periodo'];
	$num_prof       = $resposta->fields['num_prof'];
	$nome           = $resposta->fields['nome'];
	$num_co_orienta = $resposta->fields['num_co_orienta'];
	$num_area       = $resposta->fields['id_area'];
	$area           = $resposta->fields['area'];
	$id_areamonografia = $resposta->fields['id_areamonografia'];
	$areamonografia = $resposta->fields['areamonografia'];
	
	if (empty($areamonografia)) {
			$areamonografia = "Selecione área";
	}
	
	if(ereg("([0-9]{4}).([0-9]{2}).([0-9]{2})",$data_sql,$regs))
		$data = $regs[3]."-". $regs[2]."-". $regs[1];

	$resposta->MoveNext();
	}

echo "
<html>
<head>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
<body>
<form name='actualizar' action='atualiza_mono.php' method='POST'>
	
<div align='center'>
<table border='1' bgcolor='#C7FFB3f'>
<th bgcolor='#E7E1AE'>Atualiza registro</th>
<tr>
<td>
<input type='hidden' name='codigo' size='5' value='$codigo'>
</td>
</tr>

<tr>
<td>
Titulo:
</td>
</tr>

<tr>
<td>
<textarea rows='2' cols='80' name='titulo'>$titulo</textarea>
</td>
</tr>

<tr>
<td>
Cat&aacute;logo: <input type='text' name='catalogo' id='catalogo' size='4' value='$catalogo'>
</td>
</tr>

";

/**********
Professor 
**********/

echo "
<tr>
<td>
Professor(a):
";
echo "
<select name='num_prof' size='1'>
<option value='$num_prof'>$nome</option>
";

$sql = "select * from professores order by nome";
$resposta_sql = $db->Execute($sql);
if($resposta_sql === false) die ("Nao foi possivel consultar a tabela professores");

while(!$resposta_sql->EOF) {
	$numero_prof = $resposta_sql->fields['numero'];
	$nome        = $resposta_sql->fields['nome'];
	echo "<option value='$numero_prof'>$nome</option>";
	$resposta_sql->MoveNext();
	}

echo "	
</select>
</td>
</tr>
";
/*Fim de professor*/

/************
Co-orientador 
************/
echo "
<tr>
<td>
Co-orientador(a):
";
if(empty($num_co_orienta)) {
	echo "Não tem co-orientador <br>";
	$num_co_orienta = 0;
	$co_orientador = "Selecione co-orientador";
} else {
	$sql_co_orienta = "select nome from professores where numero='$num_co_orienta'";
	$resultado_co_orienta = $db->Execute($sql_co_orienta);
	if($resultado_co_orienta === false) die ("Não foi possivel consultar a tabela professores");
	while(!$resultado_co_orienta->EOF) {
		$co_orientador = $resultado_co_orienta->fields['nome'];
		$resultado_co_orienta->MoveNext();
		}
	}

echo "	
<select name='num_co_orienta' size='1'>
<option value='$num_co_orienta'>$co_orientador</option>
";

$sql = "select * from professores order by nome";
$resultado = $db->Execute($sql);
if($resultado === false) die ("Nao foi possivel consultar a tabela professores");

while(!$resultado->EOF)	{
	$numero_prof = $resultado->fields['numero'];
	$nome        = $resultado->fields['nome'];
	echo "<option value='$numero_prof'>$nome</option>";
	$resultado->MoveNext();
	}
	echo "	
</select>
</td>
</tr>
";
/*Fim de co-orientador*/

/**********/
/* Alunos */
/**********/
echo "
<tr>
<td><b>Para atualizar os dados dos alunos utilize o módulo alunos</b></td>
</tr>
";

$sql = "select * from tcc_alunos where num_monografia='$codigo'";
// echo $sql . "<br>";
$resposta = $db->Execute($sql);
if($resposta === false) die ("Não foi possivel consultar a tabela alunos");
$j = 0;
while(!$resposta->EOF) {
	$aluno[$j] = $resposta->fields['nome'];
	$num_variavel = 'num_aluno' . $j;
	$variavel = 'aluno' . $j;

	echo "
	<tr>
	<td>
	Aluno(s): $aluno[$j]
	</td>
	</tr>
	";

	$j++;
	$resposta->MoveNext();
		
	}

/**********/
/* Resumo */
/**********/
	
echo "
<tr>
<td>
Resumo: <input type='text' name='resumo' size='55' value='$resumo'>
</td>
</tr>
";

/***********/
/* Areas ***/
/***********/
echo "
<tr>
<td>
<b>Área de orientação do professor</b>: $area
</td>
</tr>
";

echo "
<tr>
<td align='center'>Área(s) de orientação do professor</td>
</tr>
";
// echo "Num_area " . $num_area . "<br>";
if($num_area == "99") {
	echo "
	<tr>
	<td>
	<input type='radio' name='num_area' value='$num_area' checked>$area
	</td>
	</tr>
	";
} else {
	echo "
	<tr>
	<td>
	<input type='radio' name='num_area' value='99'>Não corresponde a nenhuma desta(s) area(s)
	</td>
	</tr>
	";	
	}

// Inicio um bucle (loop) com a tabela prof_area
$sql_prof_area = "select * from prof_area where num_prof='$num_prof'";
$resposta_prof_area = $db->Execute($sql_prof_area);
if($resposta_prof_area === false) die ("Não foi possivel consultar a tabela prof_area");
$quantidade_area = $resposta_prof_area->RecordCount();
while(!$resposta_prof_area->EOF) {
	$num_area = $resposta_prof_area->fields['num_area'];

	// Incio um bucle (loop) interior com a tabela areas a partir do num_area. 
	$sql_areas = "select * from areas where numero='$num_area'";
	$resposta_areas = $db->Execute($sql_areas);
	if($resposta_areas == false) die ("Não foi possivel consultar a tabela areas");
	$quantidade = $resposta_areas->RecordCount();
	while(!$resposta_areas->EOF) {
		$nomeArea = $resposta_areas->fields['area'];
		if(($nomeArea == $area) || ($quantidade_area == "1")) {
			echo "
			<tr>
			<td>
			<input type='radio' name='num_area' value='$num_area' checked>$nomeArea
			</td>
			</tr>
			";
		} else {
			echo "
			<tr>
			<td>
			<input type='radio' name='num_area' value='$num_area'>$nomeArea
			</td>
			</tr>
			";
		}
		$resposta_areas->MoveNext();
	    } // Finaliza bucle interior
	$resposta_prof_area->MoveNext();
	} // Finaliza bucle maior

/**********************
* Área da monografia
**********************/

echo "
<tr>
<td align='center'><b>Área da monografia</b>
<select name='id_areamonografia' size='1'>
<option value='$id_areamonografia'>$areamonografia</option>
";

$sql = "select * from areasmonografia order by areamonografia";
$resposta_sql = $db->Execute($sql);
if($resposta_sql === false) die ("Nao foi possivel consultar a tabela areasmonografia");

while(!$resposta_sql->EOF) {
	$id_area = $resposta_sql->fields['id'];
	$area = $resposta_sql->fields['areamonografia'];
	echo "<option value='$id_area'>$area</option>";
	$resposta_sql->MoveNext();
	}

echo "	
</select>
</td>
</tr>
";

/***********/
/* Periodo */
/***********/

echo "
<tr>
<td>
Periodo: <input type='text' name='periodo' size='6' value='$periodo'>
Data:    <input type='text' name='data' size='10' value='$data'>
</td>
</tr>

<input type='hidden' name='fazer' value='atualiza'>

<tr>
<td class='coluna_centralizada'>
<input type='submit' name='submit' value='Atualizar'>
</td>
</tr>

</table>
</div>

</form>
";
	
$db->Close();

?>