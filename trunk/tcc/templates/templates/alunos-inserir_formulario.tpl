{php}
require_once("ajaxAreaProfessor.php");
{/php}
<!DOCTYPE html PUBLIC "-//W3C//CTD XHTML 1.0 Strict //EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http//www.w3.org/1999/xhtml">
<head>
<title>{php} echo $_SERVER[PHP_SELF]; {/php}</title>
{php}
$xajax->printJavascript();
{/php}
{literal}
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
{/literal}

</head>

<body bgcolor='#B0FFFB'>

<hr>

<div align="center">

<form name="inserir" action="verifica_tcc.php" method="post" enctype="multipart/form-data">

<table>
<tr>
<td>Titulo: <textarea rows="3" cols="70" name="titulo"></textarea></td>
</tr>

<tr>
<td>
Cat&aacute;logo: <input type='text' name='catalogo' id='catalogo' value='{$catalogo+1}' size='4'>
</td>
<tr>

<tr>
<td>Área da monografia:
<select name="id_areaMonografia" id="id_areaMonografia" size="1">
<option value=0>Selecione área da monografia</option>
{section name=i loop=$areamonografia}
<option value='{$areamonografia[i].id_area}'>{$areamonografia[i].areamonografia}</option>
{/section}
</select>
</td>
</tr>

<tr>
<td>Orientador (obrigatório):
<select name="id_professor" id="id_professor" size="1" onChange="return processaConsulta();">
<option value=0>Selecione o professor</option>
{section name=j loop=$professores}
<option value='{$professores[j].id_professor}'>{$professores[j].nome}</option>
{/section}
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
{section name=j loop=$professores}
<option value='{$professores[j].id_professor}'>{$professores[j].nome}</option>
{/section}
</select>
</td>
</tr>

<tr>
<td>Aluno 1:
<select name="registro_aluno1" size="1">
<option value=0>Selecione aluno</option>
{section name=k loop=$alunos}
<option value='{$alunos[k].registro}'>{$alunos[k].nome}</option>
{/section}
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
<td>Aluno 2:
<select name="registro_aluno2" size="1">
<option value=0>Selecione aluno</option>
{section name=k loop=$alunos}
<option value='{$alunos[k].registro}'>{$alunos[k].nome}</option>
{/section}
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
<td>Aluno 3:
<select name="registro_aluno3" size="1">
<option value=0>Selecione aluno</option>
{section name=k loop=$alunos}
<option value='{$alunos[k].registro}'>{$alunos[k].nome}</option>
{/section}
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
Perí­odo: <input type="text" name="periodo" size="6" value="{$periodo}">
Data:    <input type="text" name="data" size="10" value="{$data}">
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