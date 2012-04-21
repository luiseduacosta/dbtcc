<?php

include("../../autentica.inc");

$indice = $_REQUEST['indice'];
$codigo = $_REQUEST['codigo'];
$quantidade_mono = $_REQUEST['quantidade_mono'];
$submit = $_REQUEST['submit'];
$id_area = $_REQUEST['id_area'];
if (empty($id_area)) {
	$id_area = 0;
}
// echo $indice . " " . $codigo . " " . $quantidade_mono . " " . $submit . " " . $id_area . "<br>";

/***********************************/
// Si o botão de submit foi clicado então atualiza a tabela de areas
if ($submit)
{
    require_once("../../include_db.inc");
    $sql_update = "update monografia set areamonografia='$id_area' where codigo='$codigo'";
	// echo $sql_update . "<br>";
    $resultado = $db->Execute($sql_update);
    if ($resultado == false) die ("Nao foi possível atualizar a tabela monografia");
    // $db->Close();
}

if($submit == "Avanzar")
{
  if($indice > ($quantidade_mono-2))
    $indice = 0;
  else
    $indice++;
}
elseif($submit == "Retroceder")
{
  if($indice == 0)
    $indice = ($quantidade_mono-1);
  else
    $indice--;
}
/**************************************/

require_once("../../include_db.inc");
$sql = "select codigo from monografia";
$resultado = $db->Execute($sql);
$quantidade_mono = $resultado->RecordCount();

echo "
<html>
<head>
<title>Avança e retrocede monografias</title>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
<body>

<div>
<table>
<tr>
<td width='40px'>$indice</td>
<td></td>
<td width='80px'>Total: $quantidade_mono</td>
</tr>
<form name='selecion_monografia' id='selecion_monografia' action='selecao_monografia.php' method='post'>
";

// Seleciono as monografias uma por uma com a função SelectLimit()
$sql_monografia = "select monografia.codigo, monografia.titulo, monografia.periodo, "
. " monografia.areamonografia as id_areamonografia, "
. " professores.nome, areasmonografia.areamonografia "
. " from monografia "
. " inner join professores on monografia.num_prof = professores.id "
. " left outer join areasmonografia on monografia.areamonografia = areasmonografia.id "
. " order by titulo";
$resultado_monografia = $db->SelectLimit($sql_monografia,1,$indice);
if ($resultado_monografia == false) die ("Nao foi possivel consultar a tabela monografia");
while (!$resultado_monografia->EOF) {
	$codigo   = $resultado_monografia->fields['codigo'];
	$titulo   = $resultado_monografia->fields['titulo'];
	$periodo  = $resultado_monografia->fields['periodo'];
	$nome     = $resultado_monografia->fields['nome'];
	$id_areamonografia = $resultado_monografia->fields['id_areamonografia'];
	$num_prof = $resultado_monografia->fields['num_prof'];
	$areamonografia = $resultado_monografia->fields['areamonografia'];
	if (empty($areamonografia)) {
		$areamonografia = "Selecione área";
	}
	
	echo "
	<tr>
        <td colspan='3'>Período: $periodo</td>
	</tr>
	<tr class='titulo_monografia'><td colspan='3'>$titulo</td>
	</tr>
	";
	
	include("alunos.inc");
	
	echo "
	<tr><td>Aluno(s): </td><td>$aluno</td></tr>
	<tr><td>Professor: </td><td>$nome</td></tr>
	<tr><td>Área da monografia: </td>
	";

	echo "
	<td>
	<select name='id_area' size='1'>
	<option value=$id_areamonografia>$areamonografia</option>
	";

	$sql_outras_areas = "select * from areasmonografia order by areamonografia";
	$resultado_outras_areas = $db->Execute($sql_outras_areas);
	if ($resultado_outras_areas == false) die ("Não foi possível consultar a tabela areasmonografia");
	while (!$resultado_outras_areas->EOF) {
		$id_area = $resultado_outras_areas->fields['id'];
		$areamonografia = $resultado_outras_areas->fields['areamonografia'];
		echo "
		<option value='$id_area'>$areamonografia</option>
		";
		$resultado_outras_areas->MoveNext();
		}
	echo "
	</select>
	<td>
	";
	$resultado_monografia->MoveNext();
}

$db->Close();

echo "
<tr>
<td colspan='3'>

<!-- table align='center' //-->
<table id='botao_confirma_area' name='botao_confirma_area'>
    <tr><td>
    <input type='hidden' name='indice' value='$indice'>
    <input type='hidden' name='quantidade_mono' value='$quantidade_mono'>
    <input type='hidden' name='codigo' value='$codigo'>
    <input type='submit' name='submit' value='Retroceder'>	
    <input type='submit' name='submit' value='Avanzar'>
    </td>
    </tr>
</table>
</td>
</tr>

</form>
</table>
</div>
</body>
</html>
";

?>