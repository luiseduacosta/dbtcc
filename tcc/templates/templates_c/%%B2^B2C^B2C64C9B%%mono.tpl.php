<?php /* Smarty version 2.6.22, created on 2012-04-23 13:21:59
         compiled from file:/home/luis/workspace/tcc/monografia/atualizar/mono.tpl */ ?>
<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'>
<style type="text/css">@import "../../lib/datepick/jquery.datepick.css";</style> 
<?php echo '
<script language=\'JavaScript\' type=\'text/javascript\' src=\'http://ajax.googleapis.com/ajax/libs/jquery/1.4.4/jquery.min.js\'></script>
<!--
A partir do professor mostra a caixa de seleção das áreas.
Também atribui o valor do professor orientador para presidente da banca
//-->
<script language=\'JavaScript\' type=\'text/javascript\'>
$(function() {
    $(\'#id_professor\').change(function() {
        var id_professor = $(this).val();
        var dados = \'id_professor=\' + id_professor;    
        /* alert(id_professor); */
        $(\'#banca1\').val(id_professor);    
        $(\'#areaProfessor\').load(\'../inserir/consultaAreaProfessor.php\', dados);
        $(\'#areaOrientacao\').hide();
        })
});
</script>

<script language=\'JavaScript\' type=\'text/javascript\'>
$(function() {
    $(\'#id_aluno0\').change(function() {
        var id_aluno0 = $(this).val();
        /* alert(id_aluno0); */
        })
});
</script>

<script type=\'text/javascript\' src=\'../../lib/datepick/jquery.datepick.js\'></script>
<script language=\'JavaScript\' type=\'text/javascript\'>
$(function() {
    $(\'#data\').datepick({dateFormat: \'dd-mm-yyyy\'});
    $(\'#defesa\').datepick({dateFormat: \'dd-mm-yyyy\'});
});
</script>

<script language=\'JavaScript\' type=\'text/javascript\' src=\'../../lib/jquery.maskedinput-1.2.1.pack.js\'></script>
<script language=\'JavaScript\' type=\'text/javascript\'>
$(function() {
	$(\'#periodo\').mask(\'9999-9\');
});
</script>

<script language=\'JavaScript\' type=\'text/javascript\'>
// Script by Paulo Vitto Ruthes
function scriptcarateres() {
    document.inserir.carateres.value = (document.inserir.resumo.value.length + 1) - 1;
}
</script>

'; ?>


</head>

<body>

<div>
    
<h1>Atualiza monografia</h1>

<form name='actualizar' action='atualiza_mono.php' method='POST' enctype='multipart/form-data'>

<fieldset>    
<input type='hidden' name='codigo' id='codigo' size='5' value='<?php echo $this->_tpl_vars['codigo']; ?>
'>

Cat&aacute;logo:
<input type='text' name='catalogo' id='catalogo' size='4' value='<?php echo $this->_tpl_vars['catalogo']; ?>
'>
<br>

Titulo:<br>
<textarea rows='2' cols='80' name='titulo' id='titulo'><?php echo $this->_tpl_vars['titulo']; ?>
</textarea>
</fieldset>

<fieldset>
Professor(a):
<select name='id_professor' id='id_professor' size='1'>
    <option value=<?php echo $this->_tpl_vars['id_professor']; ?>
><?php echo $this->_tpl_vars['professor']; ?>
</option>
    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['professores']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
    <option value='<?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['id']; ?>
'><?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['nome']; ?>
</option>
    <?php endfor; endif; ?>
</select>

<div id="areaProfessor"></div>

Co-orientador: 
<select name='num_co_orienta' size='1'>
<option value=<?php echo $this->_tpl_vars['id_co_orientador']; ?>
><?php echo $this->_tpl_vars['co_orientador']; ?>
</option>    
<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['professores']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<option value='<?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['id']; ?>
'><?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['nome']; ?>
</option>
<?php endfor; endif; ?>
</select>
<br>

<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['alunostcc']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
Estudante(s): 
<input type='hidden' name=<?php echo $this->_tpl_vars['alunostcc'][$this->_sections['i']['index']]['aluno']; ?>
 value=<?php echo $this->_tpl_vars['alunostcc'][$this->_sections['i']['index']]['id']; ?>
>

<select name = id_atualiza<?php echo $this->_tpl_vars['alunostcc'][$this->_sections['i']['index']]['aluno']; ?>
 id=<?php echo $this->_tpl_vars['alunostcc'][$this->_sections['i']['index']]['aluno']; ?>
>
    <option value='<?php echo $this->_tpl_vars['alunostcc'][$this->_sections['i']['index']]['id']; ?>
'><?php echo $this->_tpl_vars['alunostcc'][$this->_sections['i']['index']]['nome']; ?>

    <?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['alunos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
    <option value="<?php echo $this->_tpl_vars['alunos'][$this->_sections['j']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['alunos'][$this->_sections['j']['index']]['nome']; ?>
</option>
    <?php endfor; endif; ?>
</select>


<?php if ($this->_sections['i']['index'] > 0): ?>
    <a href='../eliminar/main.php?fazer=excluialuno&id_aluno=<?php echo $this->_tpl_vars['alunostcc'][$this->_sections['i']['index']]['id']; ?>
&codigo=<?php echo $this->_tpl_vars['codigo']; ?>
'>Excluir</a>
<?php endif; ?>
<br>
<?php endfor; endif; ?>

<?php unset($this->_sections['k']);
$this->_sections['k']['name'] = 'k';
$this->_sections['k']['start'] = (int)$this->_sections['i']['index'];
$this->_sections['k']['loop'] = is_array($_loop=3) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['k']['show'] = true;
$this->_sections['k']['max'] = $this->_sections['k']['loop'];
$this->_sections['k']['step'] = 1;
if ($this->_sections['k']['start'] < 0)
    $this->_sections['k']['start'] = max($this->_sections['k']['step'] > 0 ? 0 : -1, $this->_sections['k']['loop'] + $this->_sections['k']['start']);
else
    $this->_sections['k']['start'] = min($this->_sections['k']['start'], $this->_sections['k']['step'] > 0 ? $this->_sections['k']['loop'] : $this->_sections['k']['loop']-1);
if ($this->_sections['k']['show']) {
    $this->_sections['k']['total'] = min(ceil(($this->_sections['k']['step'] > 0 ? $this->_sections['k']['loop'] - $this->_sections['k']['start'] : $this->_sections['k']['start']+1)/abs($this->_sections['k']['step'])), $this->_sections['k']['max']);
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
Estudante:
<select name = id_novoid_aluno<?php echo $this->_sections['k']['index']; ?>
 id=aluno<?php echo $this->_sections['k']['index']; ?>
>
    <?php unset($this->_sections['j']);
$this->_sections['j']['name'] = 'j';
$this->_sections['j']['loop'] = is_array($_loop=$this->_tpl_vars['alunos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
    <option value="<?php echo $this->_tpl_vars['alunos'][$this->_sections['j']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['alunos'][$this->_sections['j']['index']]['nome']; ?>
</option>    
    <?php endfor; endif; ?>
</select>
<br>    
<?php endfor; endif; ?>
</fieldset>

<fieldset>
<label for='resumo'>Resumo:</label><br> 
<textarea name='resumo' id='resumo' rows='10' cols='70'><?php echo $this->_tpl_vars['resumo']; ?>
</textarea>
<br>

Arquivo: 
<?php if ($this->_tpl_vars['url']): ?>
<?php echo $this->_tpl_vars['url']; ?>
 
<input type='hidden' name='url' id='url' size='30' value='<?php echo $this->_tpl_vars['url']; ?>
'>
<a href='../eliminar/excluir_arquivo.php?url=<?php echo $this->_tpl_vars['url']; ?>
&codigo=<?php echo $this->_tpl_vars['codigo']; ?>
'>Excluir</a>
<?php else: ?>
<input type='file' name='monografia' size='30'>
<?php endif; ?>
<br>

<div id="areaOrientacao">
Área de orientação do professor:
<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['areas']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<?php if ($this->_tpl_vars['areas'][$this->_sections['i']['index']]['id'] == $this->_tpl_vars['id_areaprofessor']): ?>
<br>
<input type='radio' name='num_area' value='<?php echo $this->_tpl_vars['areas'][$this->_sections['i']['index']]['id']; ?>
' checked="<?php echo $this->_tpl_vars['id_areaprofessor']; ?>
"><?php echo $this->_tpl_vars['areas'][$this->_sections['i']['index']]['area']; ?>

<?php else: ?>
<br>
<input type='radio' name='num_area' value='<?php echo $this->_tpl_vars['areas'][$this->_sections['i']['index']]['id']; ?>
'><?php echo $this->_tpl_vars['areas'][$this->_sections['i']['index']]['area']; ?>

<?php endif; ?>
<?php endfor; endif; ?>
<br>
<!--
<input type='radio' name='num_area' value='99'>Não corresponde
<br>
//-->
</div>

Área da monografia:
<select name='id_areamonografia' size='1'>
    <?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['area_monografia']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
    <option value='<?php echo $this->_tpl_vars['area_monografia'][$this->_sections['i']['index']]['id']; ?>
'><?php echo $this->_tpl_vars['area_monografia'][$this->_sections['i']['index']]['area']; ?>
</option>
    <?php endfor; endif; ?>
</select>
<br>

Período:
<input type='text' name='periodo' id='periodo' size='6' value='<?php echo $this->_tpl_vars['periodo']; ?>
'>
</fieldset>

<fieldset>
Data defesa: 
<input type='text' name='data_defesa' id='defesa' size='10' value='<?php echo $this->_tpl_vars['data_defesa']; ?>
'>
<br>

Orientador: 
<select name='banca1' id='banca1' size='1'>
<option value=<?php echo $this->_tpl_vars['banca1']; ?>
><?php echo $this->_tpl_vars['professorbanca1']; ?>
</option>    
<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['professores']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<option value='<?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['id']; ?>
'><?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['nome']; ?>
</option>
<?php endfor; endif; ?>
</select>
<br>

Banca: 
<select name='banca2' size='1'>
<option value=<?php echo $this->_tpl_vars['banca2']; ?>
><?php echo $this->_tpl_vars['professorbanca2']; ?>
</option>    
<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['professores']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<option value='<?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['id']; ?>
'><?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['nome']; ?>
</option>
<?php endfor; endif; ?>
</select>
<br>

Banca: 
<select name='banca3' id='banca3' size='1'>
<option value=<?php echo $this->_tpl_vars['banca3']; ?>
><?php echo $this->_tpl_vars['professorbanca3']; ?>
</option>    
<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['professores']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
<option value='<?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['id']; ?>
'><?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['nome']; ?>
</option>
<?php endfor; endif; ?>
</select>
<br>

Convidado: 
<input type='text' name='convidado' id='convidado' size='50' value='<?php echo $this->_tpl_vars['convidado']; ?>
'>
</fieldset>

<input type='hidden' name='fazer' value='atualiza'>

<p class='coluna_centralizada'>
<input type='submit' name='submit' value='Atualizar'>
</p>

</form>

</div>

</body>