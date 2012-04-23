<?php /* Smarty version 2.6.22, created on 2012-04-13 01:31:19
         compiled from alunos-busca_resultado.tpl */ ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<link href="../../css/tcc.css" rel="stylesheet" type="text/css"/>
<title>Resultado da busca de alunos</title>
</head>

<body>

<div>
<table>
<tbody>

<tr>
<th colspan='2'>Alunos</th>
</tr>

<?php unset($this->_sections['elemento']);
$this->_sections['elemento']['name'] = 'elemento';
$this->_sections['elemento']['loop'] = is_array($_loop=$this->_tpl_vars['alunos']) ? count($_loop) : max(0, (int)$_loop); unset($_loop);
$this->_sections['elemento']['show'] = true;
$this->_sections['elemento']['max'] = $this->_sections['elemento']['loop'];
$this->_sections['elemento']['step'] = 1;
$this->_sections['elemento']['start'] = $this->_sections['elemento']['step'] > 0 ? 0 : $this->_sections['elemento']['loop']-1;
if ($this->_sections['elemento']['show']) {
    $this->_sections['elemento']['total'] = $this->_sections['elemento']['loop'];
    if ($this->_sections['elemento']['total'] == 0)
        $this->_sections['elemento']['show'] = false;
} else
    $this->_sections['elemento']['total'] = 0;
if ($this->_sections['elemento']['show']):

            for ($this->_sections['elemento']['index'] = $this->_sections['elemento']['start'], $this->_sections['elemento']['iteration'] = 1;
                 $this->_sections['elemento']['iteration'] <= $this->_sections['elemento']['total'];
                 $this->_sections['elemento']['index'] += $this->_sections['elemento']['step'], $this->_sections['elemento']['iteration']++):
$this->_sections['elemento']['rownum'] = $this->_sections['elemento']['iteration'];
$this->_sections['elemento']['index_prev'] = $this->_sections['elemento']['index'] - $this->_sections['elemento']['step'];
$this->_sections['elemento']['index_next'] = $this->_sections['elemento']['index'] + $this->_sections['elemento']['step'];
$this->_sections['elemento']['first']      = ($this->_sections['elemento']['iteration'] == 1);
$this->_sections['elemento']['last']       = ($this->_sections['elemento']['iteration'] == $this->_sections['elemento']['total']);
?>
<tr>
<td><?php echo $this->_tpl_vars['alunos'][$this->_sections['elemento']['index']]['registro']; ?>
</td>
<td><a href="../visualizar/aluno.php?id_aluno=<?php echo $this->_tpl_vars['alunos'][$this->_sections['elemento']['index']]['id_aluno']; ?>
"><?php echo $this->_tpl_vars['alunos'][$this->_sections['elemento']['index']]['nome']; ?>
</a></td>
</tr>
<?php endfor; endif; ?>

</tbody>
</table>
</div>

</body>

</html>