<?php

include("../../autentica.inc");

$indice = $_REQUEST['indice'];
$codigo = $_REQUEST['codigo'];
$quantidade_mono = $_REQUEST['quantidade_mono'];
$submit = $_REQUEST['submit'];
$nova_area_prof = $_REQUEST['nova_area_prof'];

echo "
<html>
<head>
<title>Avança e retrocede monografias</title>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
<body>
";

/***********************************/
// Si o botão de submit foi clicado então atualiza a tabela de areas
if($submit) {
    // Si o professor não tem nenhuma area definida então area é 91=s/d
    if($nova_area_prof == 0) {
	$nova_area_prof = '91';
	}
    require_once("../../include_db.inc");
    $sql_update = "update monografia set num_area='$nova_area_prof' where codigo='$codigo'";
    $resultado = $db->Execute($sql_update);
    if($resultado == false) die ("Nao foi possível atualizar a tabela monografia");
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

$sql = "select codigo from monografia";
require_once("../../include_db.inc");
$resultado = $db->Execute($sql);
$quantidade_mono = $resultado->RecordCount();

echo "
<div align=\"center\">
<table width='90%'>
<tr>
<td width='40px'>$indice</td>
<td></td>
<td width='80px'>Total: $quantidade_mono</td>
</tr>	
<form name='selecion_monografia' action='selecao_monografia.php' method='post'>
";

// Seleciono as monografias uma por uma com a função SelectLimit()
$sql_monografia = "select * from monografia order by titulo";
$resultado_monografia = $db->SelectLimit($sql_monografia,1,$indice);
if($resultado_monografia == false) die ("Nao foi possivel consultar a tabela monografia");
while(!$resultado_monografia->EOF)
{
	$codigo   = $resultado_monografia->fields['codigo'];
	$titulo   = $resultado_monografia->fields['titulo'];
	$num_prof = $resultado_monografia->fields['num_prof'];
	$num_area = $resultado_monografia->fields['num_area'];
	$periodo  = $resultado_monografia->fields['periodo'];

	$sql_professores = "select nome from professores where id='$num_prof'";
	$resultado_professores = $db->Execute($sql_professores);
	if($resultado_professores == false) die ("Não foi possível consultar a tabela professores");
	while(!$resultado_professores->EOF)
	{
		$nome = $resultado_professores->fields['nome'];
		$resultado_professores->MoveNext();
	}	
	
	$sql_areas = "select area from areas where numero='$num_area'";
	$resultado_areas = $db->Execute($sql_areas);
	if($resultado_areas == false) die ("Não foi possivel consultar a tabela areas");
	while(!$resultado_areas->EOF) {
		$area = $resultado_areas->fields['area'];
		$resultado_areas->MoveNext();	
	}	
	
	echo "
	<tr>
        <td colspan='3'>$periodo</td>
        </tr>
	<tr class=titulo_monografia><td colspan='3'>$titulo</td>
        </tr>
	";
	
	include("alunos.inc");
	
	echo "
	<tr><td>Aluno(s): </td><td>$aluno</td></tr>
	<tr><td>Professor: </td><td>$nome</td></tr>
	<tr><td>Area: </td><td>$area</td></tr>
	";

	
	/*******************************************************************
	* Busco as areas do professor em *prof_area* entrando com o $num_prof
	/******************************************************************/
	$sql_area_prof = "select num_area from prof_area where num_prof='$num_prof'";
	$resultado_area_prof = $db->Execute($sql_area_prof);
	if($resultado_area_prof == false) die ("Não foi possíve consultar a tabela prof_area");
	while(!$resultado_area_prof->EOF)
		{
		$num_area_prof = $resultado_area_prof->fields['num_area'];
		// Pego o nome das areas do professor da tabela *areas*
		$sql_outras_areas = "select * from areas where numero='$num_area_prof' order by area";
		$resultado_outras_areas = $db->Execute($sql_outras_areas);
		if($resultado_outras_areas == false) die ("Não foi possível consultar a tabela areas");
		while(!$resultado_outras_areas->EOF)
			{
			$numero_area = $resultado_outras_areas->fields['numero'];
			$area        = $resultado_outras_areas->fields['area'];
			$resultado_outras_areas->MoveNext();
	    		}
			// Caso exista uma área já definida a deixo selecionada
			if($num_area == $numero_area)
			    {
			    echo "
			    <tr>
			    <td></td>
			    <td>
			    <input type='radio' name='nova_area_prof' value='$num_area' checked>$area
			    </td>
			    </tr>
			    ";
			    }
			else
			    {
			    echo "
			    <tr>
			    <td></td>
			    <td>
			    <input type='radio' name='nova_area_prof' value='$numero_area'>$area
			    </td>
			    </tr>
			    ";			
			    }
			$resultado_area_prof->MoveNext();
		} // Finaliza busca de areas do professor 

	/*********************************/
	$resultado_monografia->MoveNext();
}
	
$db->Close();

if ($num_area == '99' || $num_area == '91')
{
    echo "
    <tr>
    <td></td>
    <td>
    <input type='radio' name='nova_area_prof' value='99' checked>Não corresponde a nenhuma destas areas
    <td>
    </tr>
    ";
} else {
    echo "
    <tr>
    <td></td>
    <td>
    <input type='radio' name='nova_area_prof' value='99'>Não corresponde a nenhuma destas areas
    <td>
    </tr>
    ";
}

echo "
<tr>
<td colspan='3'>

<!-- table align='center' //-->
<table align='center' id='botao_confirma_area' name='botao_confirma_area'>
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