<?php

include("../../autentica.inc");

echo "
<html>
<head>
<title>Atualiza professor </title>
<link href='../../tcc.css' rel='stylesheet' type='text/css'>
</head>
</body>
";
// $origem  = $_REQUEST['origem'];
$id_prof = $_REQUEST['id_prof'];
/*
if($origem)
    $num_prof = $_GET['num_prof']; // O numero do professor se origina em elimina_area
else
    $num_prof = $_POST['num_prof']; 
*/    
require("../../include_db.inc");
$sql = "select * from professores where id='$id_prof' order by nome";
// echo $sql . "<br>";
$resultado = $db->Execute($sql);
if($resultado === false) die ("Não foi possível consultar a tabela professores");
echo "
<form action='update.php' name='atualiza' method='POST'>
<div align='center'>
<table>
";

while(!$resultado->EOF) {
	$id_prof       = $resultado->fields['id'];
	$nome          = $resultado->fields['nome'];
	$sexo          = $resultado->fields['sexo'];
	$condicao      = $resultado->fields['tipocargo'];
	$email         = $resultado->fields['email'];
	$departamento  = $resultado->fields['departamento'];
	$motivoegresso = $resultado->fields['motivoegresso'];

	echo "
	<tr><th>
	Atualiza professor
	</th></tr>

	<tr><td>Nome: 
	<input type='text' name='nome' value='$nome' size='50' maxlength='50'>
	</td></tr>
	
	<tr><td>Sexo: 
	";
	if($sexo == 2)
	    {
	    echo "
	    <input type='radio' name='sexo' value='2' checked>Feminino
	    <input type='radio' name='sexo' value='1'>Masculino
	    ";
	    }
	elseif($sexo == 1)
	    {
	    echo "
	    <input type='radio' name='sexo' value='2' >Feminino
	    <input type='radio' name='sexo' value='1' checked>Masculino
	    ";
	    }
	else
	    {
	    echo "
	    <input type='radio' name='sexo' value='2' checked>Feminino
	    <input type='radio' name='sexo' value='1'>Masculino
	    ";
	    }
	echo "
	</td></tr>
	";
	
	/*************/
	/* Condicao **/
	/*************/
	echo "	
	<tr><td>Condição: 
	";
	if($condicao == 'efetivo')
		{
		echo "
		<input type='radio' name='tipocargo' value='efetivo' checked>Efetivo
		<input type='radio' name='tipocargo' value='substituto'>Substituto
		";
		}
	elseif($condicao == 'substituto')
		{
		echo "	
		<input type='radio' name='tipocargo' value='efetivo'>Efetivo
		<input type='radio' name='tipocargo' value='substituto' checked>Substituto
		";
		}
	else
		{
		echo "
		<input type='radio' name='tipocargo' value='Efetivo' checked>Efetivo
		<input type='radio' name='tipocargo' value='substituto'>Substituto
		";
		}

	echo "	
	</td></tr>
	";
	/************/
	/* Situacao */
	/************/
	echo "
	<tr><td>Motivo de egresso:
	<input type='text' name='motivoegresso' value='$motivoegresso' size='50' maxlength='50'>
	</td></tr>
	";

	/***********/
	/* E-mail  */
	/***********/
	echo "    
	<tr><td>E-mail:
	<input type='text' name='email' value='$email' size='50' maxlegth='50'>
	</td></tr>
	";
	
	/****************/
	/* Departamento */
	/****************/
	switch($departamento) {
	    case "Fundamentos":
		$departamento_extenso = "Fundamentos";
	    break;
	    case "Metodos e tecnicas":
		$departamento_extenso = "MÃ©todos e tÃ©cnicas";
	    break;
	    case "Politica social":
		$departamento_extenso = "PolÃ­tic Social";
	    break;
	    }

	echo "
	<tr><td>Departamento: 
	<select name='departamento' size='1'>
	<option value='$departamento'>$departamento_extenso</option>
	<option value='Fundamentos'>Fundamentos</option>
	<option value='Metodos e tecnicas'>Métodos e técnicas</option>
	<option value='Politica social'>Política Social</option>				
	</select>
	</td></tr>
	";
	
	/***********************/
	/* Areas de orientacao */
	/***********************/
	echo "
	<tr><th>Area(s) de orientaÃ§Ã£o em TCC</th></tr>
	";

	$sql_prof_area = "select * from prof_area where num_prof='$id_prof'";
	$resultado_prof_area = $db->Execute($sql_prof_area);
	if($resultado_prof_area == false) die ("NÃ£o foi possÃ­vel consultar a tabela prof_area");
	while(!$resultado_prof_area->EOF) {
		$num_area = $resultado_prof_area->fields['num_area'];
		$sql_areas = "select * from areas where numero='$num_area'";
		$resultado_areas = $db->Execute($sql_areas);
		if($resultado_areas == false) die ("NÃ£o foi possÃ­vel consultar a tabela areas");
		while(!$resultado_areas->EOF) {
			$area = $resultado_areas->fields['area'];
			echo "
			<tr>
			<td>$area</td>
			<td><a href=elimina_area.php?num_area=$num_area&num_prof=$num_prof>X</a></td>
			</tr>
			";
			$resultado_areas->MoveNext();
			}
		$resultado_prof_area->MoveNext();
		}
	$resultado->MoveNext();	
	}

// Crio a variavel *acao* com o valor 1 para controlar que
// o registro seja atualizado apenas uma Ãºnica primeira vez
echo "
<input type='hidden' name='id_prof' value='$id_prof'>

<tr>
<td><div align='center'>
  <table border='1'>
  <tr><td colspan=3>
  <input type='submit' name='submit' value='Atualiza dados'>
  </td></tr>
  </table>
  </div>
</td>
</tr>

</table>
</div>
</form>
";

echo "
<div align='center'>
<table>
<tr>
<td>Acrescentar área</td>
</tr>
";

$sql_areas = "select * from areas order by area";
$resultado_areas = $db->Execute($sql_areas);
if($resultado_areas == false) die ("NÃ£o foi possÃ­vel consultar a tabela areas");

echo "
<form action='acrescenta_area.php' name='acrescentar_area' method='post'>

<tr>
<td>

<select name='num_area' size='1'>
<option value='0'>Seleciona area</option>
";

while(!$resultado_areas->EOF) {
	$num_area = $resultado_areas->fields['numero'];
	$area     = $resultado_areas->fields['area'];
	echo "
<option value='$num_area'>$area</option>
";
	$resultado_areas->MoveNext();
}
echo "
</select>
</td>
</tr>

<tr>
<td>
<p class=coluna_centralizada>
<input type='submit' name='area'         value='Acrescenta área'>
<input type='hidden' name='id_prof'      value='$id_prof'>
<input type='hidden' name='nome'         value='$nome'>
<input type='hidden' name='sexo'         value='$sexo'>
<input type='hidden' name='condicao'     value='$condicao'>
<input type='hidden' name='email'        value='$email'>
<input type='hidden' name='situacao'     value='$situacao'>
<input type='hidden' name='departamento' value='$departamento'>
</td>
</tr>

</form>
</table>
</div>

</body>
</html>
";

?>
