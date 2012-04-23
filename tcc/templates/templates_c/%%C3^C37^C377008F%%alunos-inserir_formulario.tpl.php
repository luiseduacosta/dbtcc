<?php /* Smarty version 2.6.22, created on 2012-04-17 08:49:07
         compiled from alunos-inserir_formulario.tpl */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'date_format', 'alunos-inserir_formulario.tpl', 177, false),)), $this); ?>
<!DOCTYPE html PUBLIC "-//W3C//CTD XHTML 1.0 Strict //EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http//www.w3.org/1999/xhtml">
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'/>
<style type="text/css">@import "../../lib/datepick/jquery.datepick.css";</style> 

<title><?php  echo $_SERVER[PHP_SELF];  ?></title>

<?php echo '
<script language="JavaScript" type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js"></script>
<!--
A partir do professor mostra a caixa de seleção das áreas.
Também atribui o valor do professor orientador para presidente da banca
//-->
<script language="JavaScript" type="text/javascript">
$(function() {
    $(\'#id_professor\').change(function() {
        var id_professor = $(this).val();
        var dados = \'id_professor=\' + id_professor;    
        /* alert(id_professor); */
        $("#banca1").val(id_professor);    
        $(\'#areaProfessor\').load(\'consultaAreaProfessor.php\', dados);
        })
});
</script>

<script type="text/javascript" src="../../lib/datepick/jquery.datepick.js"></script>
<script language="JavaScript" type="text/javascript">
$(function() {
    $(\'#data\').datepick({dateFormat: \'dd-mm-yyyy\'});
    $(\'#defesa\').datepick({dateFormat: \'dd-mm-yyyy\'});
});
</script>

<script language="JavaScript" type="text/javascript" src="../../lib/jquery.maskedinput-1.2.1.pack.js"></script>
<script language="JavaScript" type="text/javascript">
$(function() {
	$(\'#periodo\').mask(\'9999-9\');
});
</script>

<script language="JavaScript" type="text/javascript">
// Script by Paulo Vitto Ruthes
function scriptcarateres() {
    document.inserir.carateres.value = (document.inserir.resumo.value.length + 1) - 1;
}
</script>

'; ?>

</head>

<body class='body'>

<div>

<form name="inserir" action="verifica_tcc.php" method="post" enctype="multipart/form-data">

<fieldset>    
<legend>Dados da monografia</legend>

<label for="catalogo">Catálogo</label>
<input type='text' name='catalogo' id='catalogo' value='<?php echo $this->_tpl_vars['catalogo']+1; ?>
' size='4'>
<br>

<label for="titulo">Título</label><br>
<textarea rows="3" cols="70" name="titulo" id="titulo"></textarea>
<br>
    
<label for="id_areaMonografi">Área da monografia:</label>
<select name="id_areaMonografia" id="id_areaMonografia" size="1">
<option value=0>Selecione área da monografia</option>
<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['areamonografia']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
<option value='<?php echo $this->_tpl_vars['areamonografia'][$this->_sections['i']['index']]['id_area']; ?>
'><?php echo $this->_tpl_vars['areamonografia'][$this->_sections['i']['index']]['areamonografia']; ?>
</option>
<?php endfor; endif; ?>
</select>
</fieldset>

<fieldset>
<legend>Dados do(s) autor(es)</legend>
<label for="id_professor">Orientador (obrigatório):</label>
<select name="id_professor" id="id_professor" size="1">
<option value=0>Selecione o professor</option>
<?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['professores']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
<option value='<?php echo $this->_tpl_vars['professores'][$this->_sections['j']['index']]['id_professor']; ?>
'><?php echo $this->_tpl_vars['professores'][$this->_sections['j']['index']]['nome']; ?>
</option>
<?php endfor; endif; ?>
</select>
<br>
    
<div id="areaProfessor"></div>
    
<label for="co_orientador">Co-orientador (opcional):</label>
<select name="co_orientador" id="co_orientador" size="1">
<option value=0>selecione co-orientador</option>
<?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['professores']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
<option value='<?php echo $this->_tpl_vars['professores'][$this->_sections['j']['index']]['id_professor']; ?>
'><?php echo $this->_tpl_vars['professores'][$this->_sections['j']['index']]['nome']; ?>
</option>
<?php endfor; endif; ?>
</select>
<br>
    
<label for="registro_aluno1">Aluno 1:</label>
<select name="registro_aluno1" id="registro_aluno1" size="1">
<option value=0>Selecione aluno</option>
<?php unset($this->_sections['k']);
$this->_sections['k']['name'] = 'k';
$this->_sections['k']['loop'] = is_array($_loop=$this->_tpl_vars['alunos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['k']['show'] = true;
$this->_sections['k']['max'] = $this->_sections['k']['loop'];
$this->_sections['k']['step'] = 1;
$this->_sections['k']['start'] = $this->_sections['k']['step'] > 0 ? 0 : $this->_sections['k']['loop']-1;
if ($this->_sections['k']['show']) {
    $this->_sections['k']['total'] = $this->_sections['k']['loop'];
    if ($this->_sections['k']['total'] == 0)
        $this->_sections['k']['show'] = false;
} else
    $this->_sections['k']['total'] = 0;
if ($this->_sections['k']['show']):

            for ($this->_sections['k']['index'] = $this->_sections['k']['start'], $this->_sections['k']['iteration'] = 1;
                 $this->_sections['k']['iteration'] <= $this->_sections['k']['total'];
                 $this->_sections['k']['index'] += $this->_sections['k']['step'], $this->_sections['k']['iteration']++):
$this->_sections['k']['rownum'] = $this->_sections['k']['iteration'];
$this->_sections['k']['index_prev'] = $this->_sections['k']['index'] - $this->_sections['k']['step'];
$this->_sections['k']['index_next'] = $this->_sections['k']['index'] + $this->_sections['k']['step'];
$this->_sections['k']['first']      = ($this->_sections['k']['iteration'] == 1);
$this->_sections['k']['last']       = ($this->_sections['k']['iteration'] == $this->_sections['k']['total']);
?>
<option value='<?php echo $this->_tpl_vars['alunos'][$this->_sections['k']['index']]['registro']; ?>
'><?php echo $this->_tpl_vars['alunos'][$this->_sections['k']['index']]['nome']; ?>
</option>
<?php endfor; endif; ?>
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
<select name="registro_aluno2" id="registro_aluno2" size="1">
<option value=0>Selecione aluno</option>
<?php unset($this->_sections['k']);
$this->_sections['k']['name'] = 'k';
$this->_sections['k']['loop'] = is_array($_loop=$this->_tpl_vars['alunos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['k']['show'] = true;
$this->_sections['k']['max'] = $this->_sections['k']['loop'];
$this->_sections['k']['step'] = 1;
$this->_sections['k']['start'] = $this->_sections['k']['step'] > 0 ? 0 : $this->_sections['k']['loop']-1;
if ($this->_sections['k']['show']) {
    $this->_sections['k']['total'] = $this->_sections['k']['loop'];
    if ($this->_sections['k']['total'] == 0)
        $this->_sections['k']['show'] = false;
} else
    $this->_sections['k']['total'] = 0;
if ($this->_sections['k']['show']):

            for ($this->_sections['k']['index'] = $this->_sections['k']['start'], $this->_sections['k']['iteration'] = 1;
                 $this->_sections['k']['iteration'] <= $this->_sections['k']['total'];
                 $this->_sections['k']['index'] += $this->_sections['k']['step'], $this->_sections['k']['iteration']++):
$this->_sections['k']['rownum'] = $this->_sections['k']['iteration'];
$this->_sections['k']['index_prev'] = $this->_sections['k']['index'] - $this->_sections['k']['step'];
$this->_sections['k']['index_next'] = $this->_sections['k']['index'] + $this->_sections['k']['step'];
$this->_sections['k']['first']      = ($this->_sections['k']['iteration'] == 1);
$this->_sections['k']['last']       = ($this->_sections['k']['iteration'] == $this->_sections['k']['total']);
?>
<option value='<?php echo $this->_tpl_vars['alunos'][$this->_sections['k']['index']]['registro']; ?>
'><?php echo $this->_tpl_vars['alunos'][$this->_sections['k']['index']]['nome']; ?>
</option>
<?php endfor; endif; ?>
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
<select name="registro_aluno3" id="registro_aluno3" size="1">
<option value=0>Selecione aluno</option>
<?php unset($this->_sections['k']);
$this->_sections['k']['name'] = 'k';
$this->_sections['k']['loop'] = is_array($_loop=$this->_tpl_vars['alunos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['k']['show'] = true;
$this->_sections['k']['max'] = $this->_sections['k']['loop'];
$this->_sections['k']['step'] = 1;
$this->_sections['k']['start'] = $this->_sections['k']['step'] > 0 ? 0 : $this->_sections['k']['loop']-1;
if ($this->_sections['k']['show']) {
    $this->_sections['k']['total'] = $this->_sections['k']['loop'];
    if ($this->_sections['k']['total'] == 0)
        $this->_sections['k']['show'] = false;
} else
    $this->_sections['k']['total'] = 0;
if ($this->_sections['k']['show']):

            for ($this->_sections['k']['index'] = $this->_sections['k']['start'], $this->_sections['k']['iteration'] = 1;
                 $this->_sections['k']['iteration'] <= $this->_sections['k']['total'];
                 $this->_sections['k']['index'] += $this->_sections['k']['step'], $this->_sections['k']['iteration']++):
$this->_sections['k']['rownum'] = $this->_sections['k']['iteration'];
$this->_sections['k']['index_prev'] = $this->_sections['k']['index'] - $this->_sections['k']['step'];
$this->_sections['k']['index_next'] = $this->_sections['k']['index'] + $this->_sections['k']['step'];
$this->_sections['k']['first']      = ($this->_sections['k']['iteration'] == 1);
$this->_sections['k']['last']       = ($this->_sections['k']['iteration'] == $this->_sections['k']['total']);
?>
<option value='<?php echo $this->_tpl_vars['alunos'][$this->_sections['k']['index']]['registro']; ?>
'><?php echo $this->_tpl_vars['alunos'][$this->_sections['k']['index']]['nome']; ?>
</option>
<?php endfor; endif; ?>
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
<input type="text" id="periodo" name="periodo" size="6" value="<?php echo $this->_tpl_vars['periodo']; ?>
">

<input type="hidden" id="data" name="data" size="10" value="<?php echo ((is_array($_tmp=time())) ? $this->_run_mod_handler('date_format', true, $_tmp, "%d-%m-%Y") : smarty_modifier_date_format($_tmp, "%d-%m-%Y")); ?>
">
     
</fieldset>
    
<fieldset>
<legend>Dados da defesa da monografia</legend>

<label for="defesa">Data da defesa:</label>
<input type="text" id="defesa" name="data_defesa" size="10" maxlength="10">
<br>
    
<label for="banca1">Banca (orientador):</label>
<select name="banca1" id="banca1" size="1">
<option value=0>selecione o professor</option>
<?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['professores']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
<option value='<?php echo $this->_tpl_vars['professores'][$this->_sections['j']['index']]['id_professor']; ?>
'><?php echo $this->_tpl_vars['professores'][$this->_sections['j']['index']]['nome']; ?>
</option>
<?php endfor; endif; ?>
</select>
<br>
    
<label for="banca2">Banca (professor):</label> 
<select name="banca2" id="banca2" size="1">
<option value=0>selecione o professor</option>
<?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['professores']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
<option value='<?php echo $this->_tpl_vars['professores'][$this->_sections['j']['index']]['id_professor']; ?>
'><?php echo $this->_tpl_vars['professores'][$this->_sections['j']['index']]['nome']; ?>
</option>
<?php endfor; endif; ?>
</select>
<br>
    
<label for="banca3">Banca (professor):</label> 
<select name="banca2" id="banca3" size="1">
<option value=0>selecione o professor</option>
<?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['professores']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['j']['show'] = true;
$this->_sections['j']['max'] = $this->_sections['j']['loop'];
$this->_sections['j']['step'] = 1;
$this->_sections['j']['start'] = $this->_sections['j']['step'] > 0 ? 0 : $this->_sections['j']['loop']-1;
if ($this->_sections['j']['show']) {
    $this->_sections['j']['total'] = $this->_sections['j']['loop'];
    if ($this->_sections['j']['total'] == 0)
        $this->_sections['j']['show'] = false;
} else
    $this->_sections['j']['total'] = 0;
if ($this->_sections['j']['show']):

            for ($this->_sections['j']['index'] = $this->_sections['j']['start'], $this->_sections['j']['iteration'] = 1;
                 $this->_sections['j']['iteration'] <= $this->_sections['j']['total'];
                 $this->_sections['j']['index'] += $this->_sections['j']['step'], $this->_sections['j']['iteration']++):
$this->_sections['j']['rownum'] = $this->_sections['j']['iteration'];
$this->_sections['j']['index_prev'] = $this->_sections['j']['index'] - $this->_sections['j']['step'];
$this->_sections['j']['index_next'] = $this->_sections['j']['index'] + $this->_sections['j']['step'];
$this->_sections['j']['first']      = ($this->_sections['j']['iteration'] == 1);
$this->_sections['j']['last']       = ($this->_sections['j']['iteration'] == $this->_sections['j']['total']);
?>
<option value='<?php echo $this->_tpl_vars['professores'][$this->_sections['j']['index']]['id_professor']; ?>
'><?php echo $this->_tpl_vars['professores'][$this->_sections['j']['index']]['nome']; ?>
</option>
<?php endfor; endif; ?>
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