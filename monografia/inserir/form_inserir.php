<?php require_once("ajaxAreaProfessor.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//CTD XHTML 1.0 Strict //EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http//www.w3.org/1999/xhtml">
<head>
<title><?php echo $_SERVER[PHP_SELF]; ?></title>
<?php $xajax->printJavascript(); ?>
<script language="JavaScript" type="text/javascript">
<!--
// Script by Paulo Vitto Ruthes

function scriptcarateres() {
    document.inserir.carateres.value = (document.inserir.resumo.value.length + 1) - 1;
}
function createXMLHttpRequest() {
		if (window.ActiveXObject) {
				xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		else if (window.XMLHttpRequest) {
				xmlHttp = new XMLHttpRequest();
		}
}
function areaprofessor() {
		var id_professor;
		id_professor = document.getElementById("id_professor").value;
		return id_professor;
}
function pergunta() {
		createXMLHttpRequest();
		var id_professor = areaprofessor();
		var url = "consultaAreaProfessor.php?id_professor="+id_professor;
		xmlHttp.onreadystatechange = handleStateChange;
		xmlHttp.open("GET",url,true);
		xmlHttp.setRequestHeader("Content-Type","text/html;charset=ISO-8859-1;");
		xmlHttp.send(null);
}
function handleStateChange() {
		if (xmlHttp.readyState == 4) {
			if (xmlHttp.status == 200) {
				var resultado = document.getElementById("areaProfessor").innerHTML = xmlHttp.responseText;
			}
		}
}
function processaConsulta () {
		var id_professor = areaprofessor();
		xajax_areaProfessor(id_professor);
}
//
-->
</script>

</head>

<?php

require_once("../../include_db.inc");

require_once("../../data.php");

echo "<hr>";
$data = $data_arquivo;
// $data_nova = split("/", $data_arquivo);
// $data = date('d/m/Y');

$data_nova = date('d/m/Y',strtotime($data));

// $mes  = $data_nova[1];
// $ano  = $data_nova[2];

$mes  = date('m',strtotime($data_nova));
$mes  = date('Y',strtotime($data_nova));

if ($mes >= 1 AND $mes <= 6) {
	$ano = $ano - 1;        // Ano passado
	$periodo = $ano . "-2"; // Segundo periodo do ano passado
	}
if ($mes >= 7 AND $mes <= 12) {
	$periodo = $ano . "-1"; // Primeiro periodo deste ano
	}
?>

<body bgcolor='#B0FFFB'>

<div align="center">

<form name="inserir" action="verifica_tcc.php" method="post">

<table>
<tr>
<td>Titulo: <textarea rows="3" cols="70" name="titulo"></textarea></td>
</tr>

<?php
// Catalogo
$sql_catalogo = "select max(catalogo) as num_catalogo from monografia";
$resposta_catalogo = $db->Execute($sql_catalogo);
if($resposta_catalogo === null) die ("Não foi possível consultar a tabela tcc_alunos");
$catalogo = $resposta_catalogo->fields['num_catalogo'];
$catalogo = $catalogo + 1;
?>

<tr>
<td>
Cat&aacute;logo: <input type='text' name='catalogo' id='catalogo' value='<?php echo $catalogo; ?>' size='4'>
</td>
<tr>

<tr>
<td>�rea da monografia:
<select name="id_areaMonografia" id="id_areaMonografia" size="1">
<option value=0>Selecione �rea da monografia</option>
<?php
$sql_areaMonografia = "select id, areamonografia from areasmonografia order by areamonografia";
// echo $sql_areaMonografia . "<br>";
$resultado = $db->Execute($sql_areaMonografia);
if($resultado === false) die ("N�o foi poss�vel consultar a tabela areasmonografias");
while (!$resultado->EOF) {
	$id_area = $resultado->fields['id'];
	$areamonografia = $resultado->fields['areamonografia'];
?>
<option value="<?php echo $id_area; ?>"><?php echo $areamonografia; ?></option>
<?php
	$resultado->MoveNext();
	}
?>
</select>
</td>
</tr>

<tr>
<td>Orientador (obrigat�rio):
<select name="id_professor" id="id_professor" size="1" onChange="return processaConsulta();">
<option value=0>Selecione o professor</option>
<?php
$sql_professores = "select id, nome from professores order by nome";
$resultado = $db->Execute($sql_professores);
if($resultado === false) die ("N�o foi poss�vel consultar a tabela professores");
while (!$resultado->EOF) {
	$num_professor = $resultado->fields['id'];
	$professor     = $resultado->fields['nome'];
?>
<option value="<?php echo $num_professor; ?>"><?php echo $professor; ?></option>
<?php
	$resultado->MoveNext();
	}
?>
</select>
</td>
</tr>

<tr>
<td id="areaProfessor"></td>
</tr>

<tr>
<td>Co-orientador (opcional):

<select name="co_orientador" size="1">
<option value=0>selecione co-orientador</option>

<?php
$sql_professores = "select id, nome from professores order by nome";
$resposta_professores = $db->Execute($sql_professores);
if($resposta_professores == false) die ("N�o foi poss�vel consultar a tabela professores");
while (!$resposta_professores->EOF)	{
	$num_professor = $resposta_professores->fields['id'];
	$professor     = $resposta_professores->fields['nome'];
?>
<option value="<?php echo $num_professor; ?>"><?php echo $professor; ?></option>
<?php
	$resposta_professores->MoveNext();
	}
?>
</select>
</td>
</tr>

<tr>
<td>
Aluno 1:  <input type="text" name="aluno1" size="50">
Registro: <input type="text" name="numeroaluno1" size="9">
</td>
</tr>

<tr>
<td>Aluno 1:
<select name="registro_aluno1" size="1">
<option value=0>Selecione aluno</option>

<?php
$sql_aluno = "SELECT registro, nome, nivel, periodo FROM alunos inner join estagiarios using (registro) where estagiarios.nivel = 4 order by nome";
$resposta_aluno = $db->Execute($sql_aluno);
if($resposta_aluno == false) die ("N�o foi poss�vel consultar a tabela alunos");
$j = 0;
while(!$resposta_aluno->EOF) {
	$registro = $resposta_aluno->fields['registro'];
	$nome = $resposta_aluno->fields['nome'];
	$nivel = $resposta_aluno->fields['nivel'];
	$periodo = $resposta_aluno->fields['periodo'];
	
	$sql_tcc = "select registro from tcc_alunos where registro=$registro";
	// echo $sql_tcc . "<br>";
	$resposta_tcc = $db->Execute($sql_tcc);
	$quantidade = $resposta_tcc->RecordCount();
	// echo $quantidade . "<br>";
	if($quantidade === 0) {
	// echo $nome . "<br>";
?>

<option value="<?php echo $registro; ?>"><?php echo $nome; ?></option>

<?php
		}
	$resposta_aluno->MoveNext();
}
?>

</select>
</td>
</tr>

<tr>
<td>
Aluno 2:  <input type="text" name="aluno2" size="50">
Registro: <input type="text" name="numeroaluno2" size="9">
</td>
</tr>

<tr>
<td>Aluno 2:
<select name="registro_aluno2" size="1">
<option value=0>Selecione aluno</option>

<?php
$sql_aluno = "SELECT registro, nome FROM alunos inner join estagiarios using (registro) where estagiarios.nivel = 4 order by nome";
$resposta_aluno = $db->Execute($sql_aluno);
print_r($resposta_aluno);
if($resposta_aluno == false) die ("N�o foi poss�vel consultar a tabela alunos");
while(!$resposta_aluno->EOF) {
	$registro = $resposta_aluno->fields['registro'];
	$nome = $resposta_aluno->fields['nome'];
	echo $nome . "<br>";
?>

<option value="<?php echo $registro; ?>"><?php echo $nome; ?></option>

<?php
	$resposta_aluno->MoveNext();
}
?>

</select>
</td>
</tr>

<tr>
<td>
Aluno 3:  <input type="text" name="aluno3" size="50">
Registro: <input type="text" name="numeroaluno3" size="9">
</td>
</tr>

<tr>
<td>Aluno 3:
<select name="registro_aluno3" size="1">
<option value=0>Selecione aluno</option>

<?php
$sql_aluno = "SELECT registro, nome FROM alunos inner join estagiarios using (registro) where estagiarios.nivel = 4 order by nome";
$resposta_aluno = $db->Execute($sql_aluno);
print_r($resposta_aluno);
if($resposta_aluno == false) die ("N�o foi poss�vel consultar a tabela alunos");
while(!$resposta_aluno->EOF) {
	$registro = $resposta_aluno->fields['registro'];
	$nome = $resposta_aluno->fields['nome'];
	echo $nome . "<br>";
?>

<option value="<?php echo $registro; ?>"><?php echo $nome; ?></option>

<?php
	$resposta_aluno->MoveNext();
}
?>

</select>
</td>
</tr>

<tr>
<td>
Resumo:
</td>
</tr>

<tr>
<td>
<!--
Resumo: <input type="text" name="carateres" value="0" size='4' readonly>
//-->
<textarea id="resumo" name="resumo" rows="10" cols="70" value="s/d">
</textarea>
</td>
</tr>

<!--
<tr>
<td><textarea onkeyup="scriptcarateres();" rows="20" cols="70" name="resumo" wrap=no></textarea></td>
</tr>
//-->

<tr>
<td>
Per�odo: <input type="text" name="periodo" size="6" value="<?php echo $periodo; ?>">
Data:    <input type="text" name="data" size="10" value="<?php echo $data; ?>">
</td>
</tr>

<tr>
	<td>
		Monografia: <input type="file" name="monografia" size="30">
	</td>
</tr>

<tr>
<td align="center">
<input type="submit" value="Enviar" name="inserir">
<input type="reset" value="Limpar" name="limpar"></td>
</tr>

</table>

</form>

</div>

</body>
</html>