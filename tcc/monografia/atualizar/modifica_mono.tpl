<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
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
        
</head>

<body>
        
<form name='actualizar' action='atualiza_mono.php' method='POST' enctype='multipart/form-data'>

<div>
<table>
<th>Atualiza registro</th>
<tr>
<td>
<input type='hidden' name='codigo' size='5' value='{$codigo}'>
</td>
</tr>

<tr>
<td>
Cat&aacute;logo:
<input type='text' name='catalogo' size='4' value='{$catalogo}'>
</td>
</td>
</tr>

<tr>
<td>
Titulo:
</td>
</tr>

<tr>
<td>
<textarea rows='2' cols='80' name='titulo'>{$titulo}</textarea>
</td>
</tr>

<tr>
<td>
Professor(a):
<select name='num_prof' size='1'>
    {section name=i loop=$professores}
    <option value='{$profesores[i].id}'>{$professores[i].nome}</option>
    {/section}
</select>
</td>
</tr>

<tr>
<td>
<select name='num_co_orienta' size='1'>
{section name=i loop=$professores}
    <option value='{$professores[i].id}'>{$professores[i].nome}</option>
{/section}
</select>
</td>
</tr>

<tr>
<td>
Aluno(s):
<select name = 'id_aluno$j'>
    {section name=i loop=$alunostcc}
    <option value='{$alunostcc[i].id}'>{$alunostcc[i].nome}</a>
    {/section}
</select>
</td>
</tr>

<tr>
<td>
Aluno(s):
<select name = 'id_aluno$j'>
    {section name=i loop=$alunostcc}
    <option value='{$alunostcc[i].id}'>{$alunostcc[i].nome}</a>
    {/section}
</select>
</td>
</tr>

<tr>
<td>
Aluno(s):
<select name = 'id_aluno$j'>
    {section name=i loop=$alunostcc}
    <option value='{$alunostcc[i].id}'>{$alunostcc[i].nome}</a>
    {/section}
</select>
</td>
</tr>

<tr>
<td>
Resumo: <textarea name='resumo' id='resumo' rows='10' cols='70'>$resumo</textarea>
</td>
</tr>

<tr>
<td>
Arquivo: <a href='http://$servidor/monografias/$url'>$url</a>
<input type='file' name='monografia' size='30'>
<input type='hidden' name='url' id='url' size='30' value='$url'>
<a href='../eliminar/excluir_arquivo.php?url=$url&codigo=$codigo'>Excluir</a>
</td>
</tr>

<tr>
<td>
<b>Área de orientação do professor</b>: {$area}
</td>
</tr>

<tr>
<td align='center'>Área(s) de orientação do professor</td>
</tr>
<input type='radio' name='num_area' value='$num_area' checked>{$area}
</td>
</tr>

<tr>
<td><b>Área da monografia</b>
<select name='id_areamonografia' size='1'>
    {section name=i loop=$area_monografia}
    <option value='{$area_monografia[i].id}'>{$area_monografia[i].area}</option>
    {/section}
    </select>
</td>
</tr>

<tr>
<td>
Periodo: <input type='text' name='periodo' size='6' value='{$periodo}'>
</td>
</tr>

<tr>
<td>
Data defesa: <input type='text' name='data_defesa' id='data_defesa' size='10' value='{$data_defesa}'>
</td>
</tr>

<tr>
<td>
Orientador: <input type='text' name='banca1' id='banca1' size='10' value='{$banca1}'>
</td>
</tr>

<tr>
<td>
Banca: <input type='text' name='banca2' id='banca2' size='10' value='{$banca2}'>
</td>
</tr>

<tr>
<td>
Banca: <input type='text' name='banca3' id='banca3' size='10' value='{$banca3}'>
</td>
</tr>

<tr>
<td>
Convidado: <input type='text' name='convidado' id='convidado' size='50' value='{$convidado}'>
</td>
</tr>

<input type='hidden' name='fazer' value='atualiza'>

<tr>
<td>
<p class='coluna_centralizada'>
<input type='submit' name='submit' value='Atualizar'></td>
</tr>

</table>
</div>

</form>

</body>
</html>