<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
<style type="text/css">@import "../../lib/datepick/jquery.datepick.css";</style> 
{literal}
<script language='JavaScript' type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js'></script>
<!--
A partir do professor mostra a caixa de seleção das áreas.
Também atribui o valor do professor orientador para presidente da banca
//-->
<script language='JavaScript' type='text/javascript'>
$(function() {
    $('#id_professor').change(function() {
        var id_professor = $(this).val();
        var dados = 'id_professor=' + id_professor;    
        /* alert(id_professor); */
        $('#banca1').val(id_professor);    
        $('#areaProfessor').load('../inserir/consultaAreaProfessor.php', dados);
        $('#areaOrientacao').hide();
        })
});
</script>

<script language="JavaScript" type="text/javascript">
$(function() {
    $('#dre_registro_id_aluno0').change(function() {
        var id_estudante0 = $(this).val();
        /* alert(id_estudante0); */
        $('#nome_registro_id_aluno0').val(id_estudante0);
        })
});
$(function() {
    $('#nome_registro_id_aluno0').change(function() {
        var id_estudante0 = $(this).val();
        /* alert(id_estudante0); */
        $('#dre_registro_id_aluno0').val(id_estudante0);    
        })
});

$(function() {
    $('#dre_registro_id_aluno1').change(function() {
        var id_estudante1 = $(this).val();
        /* alert(id_estudante1); */
        $('#nome_registro_id_aluno1').val(id_estudante1);    
        })
});
$(function() {
    $('#nome_registro_id_aluno1').change(function() {
        var id_estudante1 = $(this).val();
        /* alert(id_estudante1); */
        $('#dre_registro_id_aluno1').val(id_estudante1);    
        })
});

$(function() {
    $('#dre_registro_id_aluno2').change(function() {
        var id_estudante2 = $(this).val();
        /* alert(id_estudante2); */
        $('#nome_registro_id_aluno2').val(id_estudante2);    
        })
}); 
$(function() {
    $('#nome_registro_id_aluno2').change(function() {
        var id_estudante2 = $(this).val();
        /* alert(id_estudante2); */
        $('#dre_registro_id_aluno2').val(id_estudante2);    
        })
});
</script>

<script type='text/javascript' src='../../lib/datepick/jquery.datepick.js'></script>
<script language='JavaScript' type='text/javascript'>
$(function() {
    $('#data').datepick({dateFormat: 'dd-mm-yyyy'});
    $('#defesa').datepick({dateFormat: 'dd-mm-yyyy'});
});
</script>

<script language='JavaScript' type='text/javascript' src='../../lib/jquery.maskedinput-1.2.1.pack.js'></script>
<script language='JavaScript' type='text/javascript'>
$(function() {
	$('#periodo').mask('9999-9');
});
</script>

<script language='JavaScript' type='text/javascript'>
// Script by Paulo Vitto Ruthes
function scriptcarateres() {
    document.inserir.carateres.value = (document.inserir.resumo.value.length + 1) - 1;
}
</script>

{/literal}

</head>

<body>

<div>
    
<h1>Atualiza monografia</h1>

<form name='actualizar' action='atualiza_mono.php' method='POST' enctype='multipart/form-data'>

<fieldset>    
<input type='hidden' name='codigo' id='codigo' size='5' value='{$codigo}'>

Cat&aacute;logo:
<input type='text' name='catalogo' id='catalogo' size='4' value='{$catalogo}'>
<br>

Titulo:<br>
<textarea rows='2' cols='80' name='titulo' id='titulo'>{$titulo}</textarea>
</fieldset>

<fieldset>
Professor(a):
<select name='id_professor' id='id_professor' size='1'>
    <option value={$id_professor}>{$professor}</option>
    {section name=i loop=$professores}
    <option value='{$professores[i].id}'>{$professores[i].nome}</option>
    {/section}
</select>

<div id="areaProfessor"></div>

Co-orientador: 
<select name='num_co_orienta' size='1'>
<option value={$id_co_orientador}>{$co_orientador}</option>    
{section name=i loop=$professores}
<option value='{$professores[i].id}'>{$professores[i].nome}</option>
{/section}
</select>
<br>

{section name=i loop=$alunostcc}
Estudante(s): 
<input type='hidden' name={$alunostcc[i].aluno} value={$alunostcc[i].registro}>

<select name = id_atualiza{$alunostcc[i].aluno} id=dre_registro_{$alunostcc[i].aluno}>
    <option value='{$alunostcc[i].registro}'>{$alunostcc[i].registro}
    {section name=j loop=$alunos_dre}
    <option value="{$alunos_dre[j].registro}">{$alunos_dre[j].registro}</option>
    {/section}
</select>
<select name = id_atualiza{$alunostcc[i].aluno} id=nome_registro_{$alunostcc[i].aluno}>
    <option value='{$alunostcc[i].registro}'>{$alunostcc[i].nome}
    {section name=j loop=$alunos}
    <option value="{$alunos[j].registro}">{$alunos[j].nome}</option>
    {/section}
</select>
    
{* Somente excluo se ha mais de um estudante *}

{if $smarty.section.i.index > 0}
    <a href='../eliminar/main.php?fazer=excluialuno&id_aluno={$alunostcc[i].id}&codigo={$codigo}'>Excluir</a>
{/if}
<br>
{/section}

{* Se a quantidade de alunos eh menor de tres *}
{section name=k start=$smarty.section.i.index loop=3}
Estudante:
<select name = id_novoid_aluno{$smarty.section.k.index} id=dre_registro_id_aluno{$smarty.section.k.index}>
     <option value="">DRE</option>
    {section name=j loop=$alunos_dre}       
    <option value="{$alunos_dre[j].registro}">{$alunos_dre[j].registro}</option>    
    {/section}
</select>
<select name = id_novoid_aluno{$smarty.section.k.index} id=nome_registro_id_aluno{$smarty.section.k.index}>
     <option value="">Nome</option>
    {section name=j loop=$alunos}
    <option value="{$alunos[j].registro}">{$alunos[j].nome}</option>    
    {/section}
</select>

<br>    
{/section}
</fieldset>

<fieldset>
<label for='resumo'>Resumo:</label><br> 
<textarea name='resumo' id='resumo' rows='10' cols='70'>{$resumo}</textarea>
<br>

Arquivo: 
{if $url}
{$url} 
<input type='hidden' name='url' id='url' size='30' value='{$url}'>
<a href='../eliminar/excluir_arquivo.php?url={$url}&codigo={$codigo}'>Excluir</a>
{else}
<input type='file' name='monografia' size='30'>
{/if}
<br>

<div id="areaOrientacao">
Área de orientação do professor:
{section name=i loop=$areas}
{if $areas[i].id eq $id_areaprofessor}
<br>
<input type='radio' name='num_area' value='{$areas[i].id}' checked="{$id_areaprofessor}">{$areas[i].area}
{else}
<br>
<input type='radio' name='num_area' value='{$areas[i].id}'>{$areas[i].area}
{/if}
{/section}
<br>
<!--
<input type='radio' name='num_area' value='99'>Não corresponde
<br>
//-->
</div>

Área da monografia:
<select name='id_areamonografia' size='1'>
    {section name=i loop=$area_monografia}
    <option value='{$area_monografia[i].id}'>{$area_monografia[i].area}</option>
    {/section}
</select>
<br>

Período:
<input type='text' name='periodo' id='periodo' size='6' value='{$periodo}'>
</fieldset>

<fieldset>
Data defesa: 
<input type='text' name='data_defesa' id='defesa' size='10' value='{$data_defesa}'>
<br>

Orientador: 
<select name='banca1' id='banca1' size='1'>
<option value={$banca1}>{$professorbanca1}</option>    
{section name=i loop=$professores}
<option value='{$professores[i].id}'>{$professores[i].nome}</option>
{/section}
</select>
<br>

Banca: 
<select name='banca2' size='1'>
<option value={$banca2}>{$professorbanca2}</option>    
{section name=i loop=$professores}
<option value='{$professores[i].id}'>{$professores[i].nome}</option>
{/section}
</select>
<br>

Banca: 
<select name='banca3' id='banca3' size='1'>
<option value={$banca3}>{$professorbanca3}</option>    
{section name=i loop=$professores}
<option value='{$professores[i].id}'>{$professores[i].nome}</option>
{/section}
</select>
<br>

Convidado: 
<input type='text' name='convidado' id='convidado' size='50' value='{$convidado}'>
</fieldset>

<input type='hidden' name='fazer' value='atualiza'>

<p class='coluna_centralizada'>
<input type='submit' name='submit' value='Atualizar'>
</p>

</form>

</div>

</body>