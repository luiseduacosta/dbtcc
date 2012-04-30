<!DOCTYPE html PUBLIC "-//W3C//CTD XHTML 1.0 Strict //EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http//www.w3.org/1999/xhtml">
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'/>
<style type="text/css">@import "../../lib/datepick/jquery.datepick.css";</style> 

<title>{php} echo $_SERVER[PHP_SELF]; {/php}</title>

{literal}
<script language="JavaScript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<!--
A partir do professor mostra a caixa de seleção das áreas.
Também atribui o valor do professor orientador para presidente da banca
//-->
<script language="JavaScript" type="text/javascript">
$(function() {
    $('#id_professor').change(function() {
        var id_professor = $(this).val();
        var dados = 'id_professor=' + id_professor;    
        /* alert(id_professor); */
        $("#banca1").val(id_professor);    
        $('#areaProfessor').load('consultaAreaProfessor.php', dados);
        })
});
</script>

<script language="JavaScript" type="text/javascript">
$(function() {
    $('#dre_registro_aluno1').change(function() {
        var id_estudante1 = $(this).val();
        /* alert(id_estudante1); */
        $('#nome_registro_aluno1').val(id_estudante1);
        })
});
$(function() {
    $('#nome_registro_aluno1').change(function() {
        var id_estudante1 = $(this).val();
        /* alert(id_estudante1); */
        $('#dre_registro_aluno1').val(id_estudante1);    
        })
});

$(function() {
    $('#dre_registro_aluno2').change(function() {
        var id_estudante2 = $(this).val();
        /* alert(id_estudante2); */
        $('#nome_registro_aluno2').val(id_estudante2);    
        })
});
$(function() {
    $('#nome_registro_aluno2').change(function() {
        var id_estudante2 = $(this).val();
        /* alert(id_estudante2); */
        $('#dre_registro_aluno2').val(id_estudante2);    
        })
});

$(function() {
    $('#dre_registro_aluno3').change(function() {
        var id_estudante3 = $(this).val();
        /* alert(id_estudante3); */
        $('#nome_registro_aluno3').val(id_estudante3);    
        })
}); 
$(function() {
    $('#nome_registro_aluno3').change(function() {
        var id_estudante3 = $(this).val();
        /* alert(id_estudante3); */
        $('#dre_registro_aluno3').val(id_estudante3);    
        })
});

</script>

<script type="text/javascript" src="../../lib/datepick/jquery.datepick.js"></script>
<script language="JavaScript" type="text/javascript">
$(function() {
    $('#data').datepick({dateFormat: 'dd-mm-yyyy'});
    $('#defesa').datepick({dateFormat: 'dd-mm-yyyy'});
});
</script>

<script language="JavaScript" type="text/javascript" src="../../lib/jquery.maskedinput-1.2.1.pack.js"></script>
<script language="JavaScript" type="text/javascript">
$(function() {
	$('#periodo').mask('9999-9');
});
</script>

<script language="JavaScript" type="text/javascript">
// Script by Paulo Vitto Ruthes
function scriptcarateres() {
    document.inserir.carateres.value = (document.inserir.resumo.value.length + 1) - 1;
}
</script>

{/literal}
</head>

<body class='body'>

<div>

<form name="inserir" action="verifica_tcc.php" method="post" enctype="multipart/form-data">

<fieldset>    
<legend>Dados da monografia</legend>

<label for="catalogo">Catálogo</label>
<input type='text' name='catalogo' id='catalogo' value='{$catalogo+1}' size='4'>
<br>

<label for="titulo">Título</label><br>
<textarea rows="3" cols="70" name="titulo" id="titulo"></textarea>
<br>
    
<label for="id_areaMonografia">Área da monografia:</label>
<select name="id_areaMonografia" id="id_areaMonografia" size="1">
<option value=0>Selecione área da monografia</option>
{section name=i loop=$areamonografia}
<option value='{$areamonografia[i].id_area}'>{$areamonografia[i].areamonografia}</option>
{/section}
</select>
</fieldset>

<fieldset>
<legend>Dados do(s) autor(es)</legend>
<label for="id_professor">Orientador (obrigatório):</label>
<select name="id_professor" id="id_professor" size="1">
<option value=0>Selecione o professor</option>
{section name=j loop=$professores}
<option value='{$professores[j].id_professor}'>{$professores[j].nome}</option>
{/section}
</select>
<br>
    
<div id="areaProfessor"></div>
    
<label for="co_orientador">Co-orientador (opcional):</label>
<select name="co_orientador" id="co_orientador" size="1">
<option value=0>selecione co-orientador</option>
{section name=j loop=$professores}
<option value='{$professores[j].id_professor}'>{$professores[j].nome}</option>
{/section}
</select>
<br>
    
<label for="registro_aluno1">Aluno 1:</label>

<select name="registro_aluno1" id="dre_registro_aluno1" size="1">
<option value=0>Selecione estudante pelo DRE</option>
{section name=k loop=$alunos_dre}
<option value='{$alunos_dre[k].registro}'>{$alunos_dre[k].registro}</option>
{/section}
</select>

<select name="registro_aluno1" id="nome_registro_aluno1" size="1">
<option value=0>Selecione estudante pelo nome</option>
{section name=k loop=$alunos}
<option value='{$alunos[k].registro}'>{$alunos[k].nome}</option>
{/section}
</select>

<br>
    
<!--
<tr>
<td>
Aluno 1:  <input type="text" name="aluno1" size="50">
Registro: <input type="text" name="numeroaluno1" size="9">
</td>
</tr>
//-->

<label for="registro_aluno2">Aluno 2:</label>
<select name="registro_aluno2" id="dre_registro_aluno2" size="1">
<option value=0>Selecione estudante pelo DRE</option>
{section name=k loop=$alunos_dre}
<option value='{$alunos_dre[k].registro}'>{$alunos_dre[k].registro}</option>
{/section}
</select>

<select name="registro_aluno2" id="nome_registro_aluno2" size="1">
<option value=0>Selecione estudante pelo nome</option>
{section name=k loop=$alunos}
<option value='{$alunos[k].registro}'>{$alunos[k].nome}</option>
{/section}
</select>

<br>
    
<!--
<tr>
<td>
Aluno 2:  <input type="text" name="aluno2" size="50">
Registro: <input type="text" name="numeroaluno2" size="9">
</td>
</tr>
//-->

<label for="registro_aluno3">Aluno 3:</label>
<select name="registro_aluno3" id="dre_registro_aluno3" size="1">
<option value=0>Selecione estudante pelo DRE</option>
{section name=k loop=$alunos_dre}
<option value='{$alunos_dre[k].registro}'>{$alunos_dre[k].registro}</option>
{/section}
</select>

<select name="registro_aluno3" id="nome_registro_aluno3" size="1">
<option value=0>Selecione estudante pelo nome</option>
{section name=k loop=$alunos}
<option value='{$alunos[k].registro}'>{$alunos[k].nome}</option>
{/section}
</select>

<br>
    
<!--
<tr>
<td>
Aluno 3:  <input type="text" name="aluno3" size="50">
Registro: <input type="text" name="numeroaluno3" size="9">
</td>
</tr>
//-->
</fieldset>

<fieldset>
<legend>Dados do conteúdo da monografia</legend>

<label for="resumo">Resumo:</label><br>
<textarea id="resumo" name="resumo" rows="10" cols="70" value="s/d">
</textarea>
<br>
    
<!--
<tr>
<td><textarea onkeyup="scriptcarateres();" rows="20" cols="70" name="resumo" wrap=no></textarea></td>
</tr>
//-->
    
<label for="monografi">Monografia:</label>
<input type="file" name="monografia" id="monografia" size="30">
<br>
    
<label for="periodo">Período</label>
<input type="text" id="periodo" name="periodo" size="6" value="{$periodo}">

<input type="hidden" id="data" name="data" size="10" value="{$smarty.now|date_format:"%d-%m-%Y"}">
     
</fieldset>
    
<fieldset>
<legend>Dados da defesa da monografia</legend>

<label for="defesa">Data da defesa:</label>
<input type="text" id="defesa" name="data_defesa" size="10" maxlength="10">
<br>
    
<label for="banca1">Banca (orientador):</label>
<select name="banca1" id="banca1" size="1">
<option value=0>selecione o professor</option>
{section name=j loop=$professores}
<option value='{$professores[j].id_professor}'>{$professores[j].nome}</option>
{/section}
</select>
<br>
    
<label for="banca2">Banca (professor):</label> 
<select name="banca2" id="banca2" size="1">
<option value=0>selecione o professor</option>
{section name=j loop=$professores}
<option value='{$professores[j].id_professor}'>{$professores[j].nome}</option>
{/section}
</select>
<br>
    
<label for="banca3">Banca (professor):</label> 
<select name="banca2" id="banca3" size="1">
<option value=0>selecione o professor</option>
{section name=j loop=$professores}
<option value='{$professores[j].id_professor}'>{$professores[j].nome}</option>
{/section}
</select>
<br>

<label for="convidado">Convidado (opcional):</label>
<input type="text" name="convidado" id="convidado" size="50">

</fieldset>

<div align="center">
<input type="submit" value="Enviar" name="inserir">
<input type="reset" value="Limpar" name="limpar">
</div>

</form>

</div>

</body>
</html>