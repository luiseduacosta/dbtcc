<?php /* Smarty version 2.6.22, created on 2012-04-13 10:35:54
         compiled from monografia-monografia.tpl */ ?>
<html>
<head>
<link href='../../css/tcc.css' rel='stylesheet' type='text/css'/>
</head>

<body>
<?php if ($this->_tpl_vars['id_area'] == '99' || $this->_tpl_vars['id_area'] == '91'): ?>
	<table>
	<caption>Monografias classificadas como área: <?php echo $this->_tpl_vars['area']; ?>
</caption>
	<tbody>
	<tr>
	<th><a href="?ordem=titulo&num_area=<?php echo $this->_tpl_vars['id_area']; ?>
">Título</a></th>
	<th><a href="?ordem=nome&num_area=<?php echo $this->_tpl_vars['id_area']; ?>
">Professor</a></td>
	<th><a href="?ordem=periodo&num_area=<?php echo $this->_tpl_vars['id_area']; ?>
">Período</a></th>
	</tr>

	<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['monografiaSem']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	<?php if ($this->_tpl_vars['color'] == 0): ?>
		<tr class="resaltado" id="resaltado">
		<?php $this->assign('color', '1'); ?>
	<?php else: ?>
		<tr class="natural" id="natural">
		<?php $this->assign('color', '0'); ?>
	<?php endif; ?>	
	<td><a href="../../areaMonografia/visualizar/monografia.php?codigo=<?php echo $this->_tpl_vars['monografiaSem'][$this->_sections['i']['index']]['codigo']; ?>
"><?php echo $this->_tpl_vars['monografiaSem'][$this->_sections['i']['index']]['titulo']; ?>
</a></td>
	<td><?php echo $this->_tpl_vars['monografiaSem'][$this->_sections['i']['index']]['professor']; ?>
</td>
	<td><?php echo $this->_tpl_vars['monografiaSem'][$this->_sections['i']['index']]['periodo']; ?>
</td>
	</tr>
	<?php endfor; endif; ?>

	</tbody>
	</table>
<?php else: ?>
	<div>
	<table>
	<caption>Professores da área: <?php echo $this->_tpl_vars['area']; ?>
</caption>
	<tbody>

	<tr>
	<th>Professor</th>
	<th>Departamento</th>
	<th>Condição</th>
	<th>E-mail</th>
	</tr>

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
	<?php if ($this->_tpl_vars['color'] == 0): ?>
		<tr class="resaltado" id="resaltado">
		<?php $this->assign('color', '1'); ?>
	<?php else: ?>
		<tr class="natural" id="natural">
		<?php $this->assign('color', '0'); ?>
	<?php endif; ?>	
	<td><?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['nome']; ?>
</td>
	<td><?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['departamento']; ?>
</td>
	<td><?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['condicao']; ?>
</td>
	<td><a href="mailto:<?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['email']; ?>
"><?php echo $this->_tpl_vars['professores'][$this->_sections['i']['index']]['email']; ?>
</a></td>
	<?php endfor; endif; ?>

	</tbody>
	</table>

	<br>

	<table>
	<caption>Monografias classificadas como área: <?php echo $this->_tpl_vars['area']; ?>
</caption>
	<tbody>
	<tr>
	<th><a href="?ordem=titulo&num_area=<?php echo $this->_tpl_vars['id_area']; ?>
">Título</a></th>
	<th><a href="?ordem=nome&num_area=<?php echo $this->_tpl_vars['id_area']; ?>
">Professor</a></td>
	<th><a href="?ordem=periodo&num_area=<?php echo $this->_tpl_vars['id_area']; ?>
">Período</a></th>
	<th><a href="?ordem=area&num_area=<?php echo $this->_tpl_vars['id_area']; ?>
">Área</a></th>
	</tr>

	<?php unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($_loop=$this->_tpl_vars['monografias']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
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
	<?php if ($this->_tpl_vars['color'] == 0): ?>
		<tr class="resaltado" id="resaltado">
		<?php $this->assign('color', '1'); ?>
	<?php else: ?>
		<tr class="natural" id="natural">
		<?php $this->assign('color', '0'); ?>
	<?php endif; ?>	
	<td><a href="../../areaMonografia/visualizar/monografia.php?codigo=<?php echo $this->_tpl_vars['monografias'][$this->_sections['i']['index']]['codigo']; ?>
"><?php echo $this->_tpl_vars['monografias'][$this->_sections['i']['index']]['titulo']; ?>
</a></td>
	<td><?php echo $this->_tpl_vars['monografias'][$this->_sections['i']['index']]['nome']; ?>
</td>
	<td><?php echo $this->_tpl_vars['monografias'][$this->_sections['i']['index']]['periodo']; ?>
</td>
	<td><?php echo $this->_tpl_vars['monografias'][$this->_sections['i']['index']]['area']; ?>
</td>
	</tr>
	<?php endfor; endif; ?>
	
	</tbody>
	</table>
	</div>
<?php endif; ?>

</body>
</html>