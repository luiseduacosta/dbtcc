<?php
require("../../autentica.inc");
?>
<html>
<head>
<link href="../../tcc.css" rel="stylesheet" type="text/css">
</head>
<body>

<form name='seleciona_area' method='post' action='seleciona_area.php'>
<div align="center">
<table>
<!-- Nome do profressor -->
<tr><td>Nome: <input type='text' name='nome' size='50'></td></tr>

<!-- Sexo -->
<tr><td>Sexo: <input type='radio' name='sexo' value='2' checked>Feminino
              <input type='radio' name='sexo' value='1'>Masculino
</td></tr>

<!-- Departamento em que trabalha -->
<tr><td>Departamento: 
<select name='departamento' size='1'>
	<option value='sem informação'>Selecione o departamento</option>
	<option value='fundamentos'>Fundamentos</option>
	<option value='politica social'>Políticas Sociais e SeSo aplicado</option>
	<option value='metodos e tecnicas'>Métodos e técnicas</option>
	<option value='sem informação'>Sem informação</option>
</select>
</td></tr>

<!-- Condicao de trabalho -->
<tr><td>Condição: 
<input type='radio' value='efectivo' checked name='tipocargo'>permanente
<input type='radio' value='substituto' name='tipocargo'>substituto
</td></tr>

<!-- Situacao 
<tr><td>Situação:
-->

<?php 
require("../../include_db.inc");
/*
$sql_situacoes = "select * from situacoes order by codigo";
$resultado_situacoes = $db->Execute($sql_situacoes);
if($resultado_situacoes == false) die ("Não foi possível consultar a tabela situacoes");
*/
?>

<!--
<select name='situacao' size=1>
<option value=0>Indique a situação do professor</option>
//-->

<?php
/*
while(!$resultado_situacoes->EOF)
    {
    $codigo_situacao   = $resultado_situacoes->fields['codigo'];
    $descreve_situacao = $resultado_situacoes->fields['situacao'];
    echo "
    <option value=$codigo_situacao>$descreve_situacao</option>
    ";
    $resultado_situacoes->MoveNext();
    }
*/
?>

<!--
</select>
</td></tr>
//-->

<!-- Endereco electronico -->
<tr><td>E-mail: <input type='text' name='email' size='30'></td></tr>

<!-- Areas -->
<?php
$sql_areas = "select * from areas order by area";
$resultado_areas = $db->Execute($sql_areas);
if($resultado_areas == false) die ("Não foi possível consultar a tabela areas");
?>

<tr>
<td>
Áreas:

<!-- A area 91 é s/d //-->
<select name='num_area' size='1'>
<option value='91'>Seleciona area</option>

<?php
while(!$resultado_areas->EOF) {
	$num_area = $resultado_areas->fields['numero'];
	$area     = $resultado_areas->fields['area'];
	echo "
	<option value='$num_area'>$area</option>
	";
	$resultado_areas->MoveNext();
}
?>

</select>
</td>
</tr>

<!-- Enviar -->
<input type='hidden' name='inserir' value='1'>
<tr><td>
    <div align="center">
    <table>
    <tr><td>
    <input type='submit' name='submit' value='Enviar'>
    <input type='reset' name='limpar' value='Limpar'>
    </td></tr>
    </table>
    </div>
</td></tr>

</table>
</div>
</form>

</body>
</html>